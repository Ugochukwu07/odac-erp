<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Check if user is logged in
        $session_data = $this->session->userdata('adminloginstatus');
        if(empty($session_data)){
            redirect(base_url('mylogin.html'));
            exit;
        }
        
        // Load required models
        $this->load->model('Common_model', 'c_model');
        
        // Load RBAC helper
        $this->load->helper('rbac');
        
        // Check if user has permission to manage users
        if(!has_permission('user_management') && !is_admin()) {
            $this->session->set_flashdata('error', 'You do not have permission to access user management.');
            redirect(adminfold('Dashboard'));
        }
    }

    /**
     * Display list of all users
     */
    public function index()
    {
        // Get all users with their roles
        $users = $this->c_model->getAll(table: 'users', where: null, limit: null, keys: '*', orderby: 'name ASC');
        
        // Add role information for each user
        foreach($users as &$user) {
            // Get user roles
            $user_roles = $this->c_model->getAll(table: 'user_roles', where: ['user_id' => $user['id']], keys: 'role_id');
            $role_ids = array_column($user_roles, 'role_id');
            
            if(!empty($role_ids)) {
                $roles = $this->c_model->getAll(table: 'roles', where: null, limit: null, keys: 'name', in_not_in: [['type' => 'in', 'key' => 'id', 'inlist' => array_values($role_ids)]]);
                $user['roles'] = array_column($roles, 'name');
            } else {
                $user['roles'] = [];
            }
        }
        
        $data['users'] = $users;
        $this->load->view(adminfold('users/index'), $data);
    }

    /**
     * Display form to add new user
     */
    public function add()
    {
        // Get all active roles
        $roles = $this->c_model->getAll(table: 'roles', where: ['status' => 'active'], limit: null, keys: '*', orderby: 'name ASC');
        
        $data['roles'] = $roles;
        $this->load->view(adminfold('users/form'), $data);
    }

    /**
     * Display form to edit existing user
     */
    public function edit($id = null)
    {
        if(!$id) {
            redirect(adminfold('Users'));
        }
        
        // Get user data
        $user = $this->c_model->getSingle('users', ['id' => $id], '*');
        if(!$user) {
            $this->session->set_flashdata('error', 'User not found.');
            redirect(adminfold('Users'));
        }
        
        // Get all active roles
        $roles = $this->c_model->getAll('roles', null, ['status' => 'active'], '*', 'name ASC');
        
        // Get user roles
        $user_roles = $this->c_model->getAll('user_roles', null, ['user_id' => $id], 'role_id');
        $user_role_ids = array_column($user_roles, 'role_id');
        
        $data['user'] = $user;
        $data['roles'] = $roles;
        $data['user_roles'] = $user_role_ids;
        
        $this->load->view(adminfold('users/form'), $data);
    }

    /**
     * Save user (create or update)
     */
    public function save()
    {
        // Validate form
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('mobile', 'Mobile/Email', 'required|trim|max_length[20]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[active,inactive]');
        
        $role_id = $this->input->post('role_id');
        
        // Password validation
        if(!$role_id) {
            // New user - password required
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[20]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        } else {
            // Existing user - password optional
            $password = $this->input->post('password');
            if(!empty($password)) {
                $this->form_validation->set_rules('password', 'Password', 'min_length[6]|max_length[20]');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            }
        }
        
        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            
            if($role_id) {
                redirect(adminfold('Users/edit/'.$role_id));
            } else {
                redirect(adminfold('Users/add'));
            }
            return;
        }
        
        $name = $this->input->post('name');
        $mobile = $this->input->post('mobile');
        $password = $this->input->post('password');
        $status = $this->input->post('status');
        $roles = $this->input->post('roles');
        
        // Check if mobile/email already exists (for new users)
        if(!$role_id) {
            $existing_user = $this->c_model->getSingle('users', ['mobile' => $mobile], 'id');
            if($existing_user) {
                $this->session->set_flashdata('error', 'A user with this mobile/email already exists.');
                redirect(adminfold('Users/add'));
                return;
            }
        }
        
        // Prepare user data
        $user_data = [
            'name' => $name,
            'mobile' => $mobile,
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle password
        if(!empty($password)) {
            $user_data['password'] = md5($password);
        }
        
        if($role_id) {
            // Update existing user
            $this->c_model->update('users', $user_data, ['id' => $role_id]);
            $user_id = $role_id;
            $message = 'User updated successfully.';
        } else {
            // Create new user
            $user_data['created_at'] = date('Y-m-d H:i:s');
            $user_id = $this->c_model->insert('users', $user_data);
            $message = 'User created successfully.';
        }
        
        // Handle roles
        if($user_id) {
            // Remove existing roles
            $this->c_model->delete('user_roles', ['user_id' => $user_id]);
            
            // Add new roles
            if($roles && is_array($roles)) {
                foreach($roles as $role_id) {
                    $this->c_model->insert('user_roles', [
                        'user_id' => $user_id,
                        'role_id' => $role_id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
        
        $this->session->set_flashdata('success', $message);
        redirect(adminfold('Users'));
    }

    /**
     * Delete user
     */
    public function delete($id = null)
    {
        if(!$id) {
            redirect(adminfold('Users'));
        }
        
        // Prevent self-deletion
        $current_user_id = $this->session->userdata('adminloginstatus')['user_id'];
        if($id == $current_user_id) {
            $this->session->set_flashdata('error', 'You cannot delete your own account.');
            redirect(adminfold('Users'));
        }
        
        // Get user data
        $user = $this->c_model->getSingle('users', ['id' => $id], '*');
        if(!$user) {
            $this->session->set_flashdata('error', 'User not found.');
            redirect(adminfold('Users'));
        }
        
        // Delete user roles
        $this->c_model->delete('user_roles', ['user_id' => $id]);
        
        // Delete user
        $this->c_model->delete('users', ['id' => $id]);
        
        $this->session->set_flashdata('success', 'User deleted successfully.');
        redirect(adminfold('Users'));
    }

    /**
     * Get user ID by mobile number (AJAX endpoint)
     */
    public function getUserByMobile()
    {
        // Check if it's an AJAX request
        if(!$this->input->is_ajax_request()) {
            show_404();
            return;
        }

        $mobile = $this->input->post('mobile');
        
        if(empty($mobile)) {
            echo json_encode(['success' => false, 'message' => 'Mobile number is required']);
            return;
        }

        // Get user by mobile
        $user = $this->c_model->getSingle('users', ['mobile' => $mobile], 'id, name, mobile');
        
        if($user) {
            echo json_encode(['success' => true, 'user_id' => $user['id'], 'user_name' => $user['name']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
    }
} 