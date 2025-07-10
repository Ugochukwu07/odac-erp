<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller
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
        
        // Check if user has permission to manage roles
        if(!has_permission('role_management') && !is_admin()) {
            $this->session->set_flashdata('error', 'You do not have permission to access role management.');
            redirect(adminfold('Dashboard'));
        }
    }

    /**
     * Display list of all roles
     */
    public function index()
    {
        // Get all roles with user count and permission count
        $roles = $this->c_model->getAll(table: 'roles', where: null, limit: null, keys: '*', orderby: 'name ASC');
        
        // Add user count and permission count for each role
        foreach($roles as &$role) {
            // Count users with this role
            $user_count = $this->c_model->countitem('user_roles', ['role_id' => $role['id']]);
            $role['user_count'] = $user_count;
            
            // Count permissions for this role
            $permission_count = $this->c_model->countitem('role_permissions', ['role_id' => $role['id']]);
            $role['permission_count'] = $permission_count;
        }
        
        $data['roles'] = $roles;
        $this->load->view(adminfold('roles/index'), $data);
    }

    /**
     * Display form to add new role
     */
    public function add()
    {
        // Get all permissions grouped by module
        $permissions = $this->c_model->getAll(table: 'permissions', where: ['status' => 'active'], limit: null, keys: '*', orderby: 'module ASC, name ASC');
        
        $data['permissions'] = $permissions;
        $this->load->view(adminfold('roles/form'), $data);
    }

    /**
     * Display form to edit existing role
     */
    public function edit($id = null)
    {
        if(!$id) {
            redirect(adminfold('Roles'));
        }
        
        // Get role data
        $role = $this->c_model->getSingle(table: 'roles', where: ['id' => $id], keys: '*');
        if(!$role) {
            $this->session->set_flashdata('error', 'Role not found.');
            redirect(adminfold('Roles'));
        }
        
        // Get all permissions
        $permissions = $this->c_model->getAll(table: 'permissions', where: ['status' => 'active'], limit: null, keys: '*', orderby: 'module ASC, name ASC');
        
        // Get role permissions
        $role_permissions = $this->c_model->getAll(table: 'role_permissions', where: ['role_id' => $id], keys: 'permission_id');
        $role_permission_ids = array_column($role_permissions, 'permission_id');
        
        $data['role'] = $role;
        $data['permissions'] = $permissions;
        $data['role_permissions'] = $role_permission_ids;
        
        $this->load->view(adminfold('roles/form'), $data);
    }

    /**
     * Save role (create or update)
     */
    public function save()
    {
        // Validate form
        $this->form_validation->set_rules('name', 'Role Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Description', 'trim|max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[active,inactive]');
        
        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            
            if($this->input->post('role_id')) {
                redirect(adminfold('Roles/edit/'.$this->input->post('role_id')));
            } else {
                redirect(adminfold('Roles/add'));
            }
            return;
        }
        
        $role_id = $this->input->post('role_id');
        $name = $this->input->post('name');
        $description = $this->input->post('description');
        $status = $this->input->post('status');
        $permissions = $this->input->post('permissions');
        
        // Check if role name already exists (for new roles)
        if(!$role_id) {
            $existing_role = $this->c_model->getSingle(table: 'roles', where: ['name' => $name], keys: 'id');
            if($existing_role) {
                $this->session->set_flashdata('error', 'A role with this name already exists.');
                redirect(adminfold('Roles/add'));
                return;
            }
        }
        
        // Prepare role data
        $role_data = [
            'name' => $name,
            'description' => $description,
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if($role_id) {
            // Update existing role
            $this->c_model->update(table: 'roles', dataarray: $role_data, where: ['id' => $role_id]);
            $message = 'Role updated successfully.';
        } else {
            // Create new role
            $role_data['created_at'] = date('Y-m-d H:i:s');
            $role_id = $this->c_model->insert(table: 'roles', dataarray: $role_data);
            $message = 'Role created successfully.';
        }
        
        // Handle permissions
        if($role_id) {
            // Remove existing permissions
            $this->c_model->delete(table: 'role_permissions', where: ['role_id' => $role_id]);
            
            // Add new permissions
            if($permissions && is_array($permissions)) {
                foreach($permissions as $permission_id) {
                    $this->c_model->insert(table: 'role_permissions', dataarray: [
                        'role_id' => $role_id,
                        'permission_id' => $permission_id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
        
        $this->session->set_flashdata('success', $message);
        redirect(adminfold('Roles'));
    }

    /**
     * Delete role
     */
    public function delete($id = null)
    {
        if(!$id) {
            redirect(adminfold('Roles'));
        }
        
        // Get role data
        $role = $this->c_model->getSingle(table: 'roles', where: ['id' => $id], keys: '*');
        if(!$role) {
            $this->session->set_flashdata('error', 'Role not found.');
            redirect(adminfold('Roles'));
        }
        
        // Prevent deletion of Super Admin role
        if($role['name'] == 'Super Admin') {
            $this->session->set_flashdata('error', 'Super Admin role cannot be deleted.');
            redirect(adminfold('Roles'));
        }
        
        // Check if role has users assigned
        $user_count = $this->c_model->countitem('user_roles', ['role_id' => $id]);
        if($user_count > 0) {
            $this->session->set_flashdata('error', 'Cannot delete role. There are users assigned to this role.');
            redirect(adminfold('Roles'));
        }
        
        // Delete role permissions
        $this->c_model->delete('role_permissions', ['role_id' => $id]);
        
        // Delete role
        $this->c_model->delete('roles', ['id' => $id]);
        
        $this->session->set_flashdata('success', 'Role deleted successfully.');
        redirect(adminfold('Roles'));
    }
} 