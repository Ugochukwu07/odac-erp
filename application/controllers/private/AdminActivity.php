<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AdminActivity extends CI_Controller {
    
    function __construct() {
        parent::__construct(); 
        adminlogincheck();
        $this->load->model('Common_model', 'c_model');
        $this->load->helper('rbac');
        
        // Check if user has permission to view admin activity
        if (!has_permission('admin_activity_tracking') && !is_admin()) {
            $this->session->set_flashdata('error', 'You do not have permission to access admin activity tracking.');
            redirect(adminurl('Dashboard'));
        }
    }
    
    public function index() {
        $data = [];
        $data['title'] = 'Admin Activity Tracking';
        
        // Get current user's hierarchy level
        $current_level = get_admin_hierarchy_level();
        
        // Get trackable users based on hierarchy
        $trackable_mobiles = get_trackable_user_mobiles();
        
        // Get admin users that current user can track
        $admin_users = [];
        if (empty($trackable_mobiles)) {
            // If no trackable users, show only current user
            $session_data = $this->session->userdata('adminloginstatus');
            $current_user = $this->c_model->getSingle('users', ['mobile' => $session_data['user_mobile']], '*');
            if ($current_user) {
                $admin_users[] = $current_user;
            }
        } else {
            // Get all trackable users
            $admin_users = $this->c_model->getAll('users', null, ['status' => 'active'], '*');
            $admin_users = array_filter($admin_users, function($user) use ($trackable_mobiles) {
                return in_array($user['mobile'], $trackable_mobiles);
            });
        }
        
        // Add hierarchy information to each user
        foreach ($admin_users as &$user) {
            $user['hierarchy_level'] = get_admin_hierarchy_level($user['id']);
            $user['hierarchy_display'] = get_admin_hierarchy_display($user['id']);
            $user['hierarchy_badge'] = get_admin_hierarchy_badge_class($user['id']);
            
            // Get user roles
            $user_roles = $this->c_model->getAll('user_roles', null, ['user_id' => $user['id']], 'role_id');
            $role_ids = array_column($user_roles, 'role_id');
            
            if (!empty($role_ids)) {
                $roles = $this->c_model->getAllwherein('roles', null, 'name', null, 'id', $role_ids);
                if (!is_array($roles)) { $roles = []; }
                $user['roles'] = array_column($roles, 'name');
            } else {
                $user['roles'] = [];
            }
        }
        
        $data['admin_users'] = $admin_users;
        $data['current_level'] = $current_level;
        
        $this->load->view('private/admin_activity', $data);
    }
    
    public function getUserBookings() {
        $user_mobile = $this->input->get('mobile');
        
        if (empty($user_mobile)) {
            echo json_encode(['error' => 'User mobile is required']);
            return;
        }
        
        // Check if current user can track this user
        $target_user = $this->c_model->getSingle('users', ['mobile' => $user_mobile], 'id');
        if (!$target_user) {
            echo json_encode(['error' => 'User not found']);
            return;
        }
        
        if (!can_track_user_bookings($target_user['id'])) {
            echo json_encode(['error' => 'You do not have permission to track this user']);
            return;
        }
        
        // Get user's bookings
        $where = ['add_by' => $user_mobile];
        $where["attemptstatus NOT IN('temp','cancel','reject')"] = NULL;
        
        $select = 'a.*, b.domain, c.model, DATE_FORMAT(a.bookingdatetime,"%d-%b-%Y %r") as bookingdates, DATE_FORMAT(a.pickupdatetime,"%d-%b-%Y %r") as pickupdates, DATE_FORMAT(a.dropdatetime,"%d-%b-%Y %r") as dropdates';
        $from = 'pt_booking as a';
        $join[0]['table'] = 'pt_domain as b';
        $join[0]['on'] = 'a.domainid = b.id';
        $join[0]['key'] = 'LEFT';
        $join[1]['table'] = 'pt_vehicle_model as c';
        $join[1]['on'] = 'a.modelid = c.id';
        $join[1]['key'] = 'LEFT';
        
        $bookings = $this->c_model->joindata($select, $where, $from, $join, null, 'a.bookingdatetime DESC', 50);
        
        echo json_encode(['success' => true, 'bookings' => $bookings]);
    }
    
    public function getUserActivity() {
        $user_mobile = $this->input->get('mobile');
        $date_from = $this->input->get('from');
        $date_to = $this->input->get('to');
        
        if (empty($user_mobile)) {
            echo json_encode(['error' => 'User mobile is required']);
            return;
        }
        
        // Check if current user can track this user
        $target_user = $this->c_model->getSingle('users', ['mobile' => $user_mobile], 'id');
        if (!$target_user) {
            echo json_encode(['error' => 'User not found']);
            return;
        }
        
        if (!can_track_user_bookings($target_user['id'])) {
            echo json_encode(['error' => 'You do not have permission to track this user']);
            return;
        }
        
        // Get user's activity (bookings created, edited, etc.)
        $where = ['add_by' => $user_mobile];
        
        if (!empty($date_from) && !empty($date_to)) {
            $where['DATE(bookingdatetime) >='] = $date_from;
            $where['DATE(bookingdatetime) <='] = $date_to;
        }
        
        $select = 'a.*, b.domain, c.model, DATE_FORMAT(a.bookingdatetime,"%d-%b-%Y %r") as bookingdates, DATE_FORMAT(a.edit_date,"%d-%b-%Y %r") as editdates';
        $from = 'pt_booking as a';
        $join[0]['table'] = 'pt_domain as b';
        $join[0]['on'] = 'a.domainid = b.id';
        $join[0]['key'] = 'LEFT';
        $join[1]['table'] = 'pt_vehicle_model as c';
        $join[1]['on'] = 'a.modelid = c.id';
        $join[1]['key'] = 'LEFT';
        
        $activities = $this->c_model->joindata($select, $where, $from, $join, null, 'a.bookingdatetime DESC', 100);
        
        // Get editing logs
        $edit_logs = [];
        if (!empty($activities)) {
            $booking_ids = array_column($activities, 'id');
            $edit_logs = $this->c_model->getAll('pt_booking_editing_log', null, null, '*', null, 'booking_id', implode(',', $booking_ids));
        }
        
        echo json_encode([
            'success' => true, 
            'activities' => $activities,
            'edit_logs' => $edit_logs
        ]);
    }
    
    public function getActivitySummary() {
        $date_from = $this->input->get('from', date('Y-m-01'));
        $date_to = $this->input->get('to', date('Y-m-d'));
        
        // Get trackable user mobiles
        $trackable_mobiles = get_trackable_user_mobiles();
        
        $summary = [];
        
        if (empty($trackable_mobiles)) {
            // If no trackable users, show only current user
            $session_data = $this->session->userdata('adminloginstatus');
            $trackable_mobiles = [$session_data['user_mobile']];
        }
        
        foreach ($trackable_mobiles as $mobile) {
            $user = $this->c_model->getSingle('users', ['mobile' => $mobile], 'id, name, mobile');
            if (!$user) continue;
            
            // Get user's booking summary using proper table references
            $where = [
                'add_by' => $mobile,
                'DATE(bookingdatetime) >=' => $date_from,
                'DATE(bookingdatetime) <=' => $date_to
            ];
            
            $total_bookings = $this->c_model->countitem('pt_booking', $where);
            
            $where['attemptstatus'] = 'approved';
            $approved_bookings = $this->c_model->countitem('pt_booking', $where);
            
            $where['attemptstatus'] = 'complete';
            $completed_bookings = $this->c_model->countitem('pt_booking', $where);
            
            $where['attemptstatus'] = 'cancel';
            $cancelled_bookings = $this->c_model->countitem('pt_booking', $where);
            
            // Get total amount
            $where = [
                'add_by' => $mobile,
                'DATE(bookingdatetime) >=' => $date_from,
                'DATE(bookingdatetime) <=' => $date_to,
                "attemptstatus NOT IN('temp','cancel','reject')" => NULL
            ];
            
            $amount_data = $this->db->select('SUM(totalamount) as total_amount, SUM(bookingamount) as booking_amount, SUM(restamount) as rest_amount')
                                   ->where($where)
                                   ->get('pt_booking')
                                   ->row_array();
            
            $summary[] = [
                'user_id' => $user['id'],
                'user_name' => $user['name'],
                'user_mobile' => $user['mobile'],
                'hierarchy_level' => get_admin_hierarchy_level($user['id']),
                'hierarchy_display' => get_admin_hierarchy_display($user['id']),
                'total_bookings' => $total_bookings,
                'approved_bookings' => $approved_bookings,
                'completed_bookings' => $completed_bookings,
                'cancelled_bookings' => $cancelled_bookings,
                'total_amount' => $amount_data['total_amount'] ?? 0,
                'booking_amount' => $amount_data['booking_amount'] ?? 0,
                'rest_amount' => $amount_data['rest_amount'] ?? 0
            ];
        }
        
        echo json_encode(['success' => true, 'summary' => $summary]);
    }
} 