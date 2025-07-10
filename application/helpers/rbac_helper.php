<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RBAC Helper Functions
 * 
 * This helper provides functions for Role-Based Access Control (RBAC)
 * operations throughout the application.
 */

/**
 * Check if current user has a specific permission
 * @param string $permission_name The permission name to check
 * @return bool True if user has permission, false otherwise
 */
function has_permission($permission_name)
{
    $CI =& get_instance();
    $session_data = $CI->session->userdata('adminloginstatus');
    
    if (empty($session_data) || !isset($session_data['permissions'])) {
        return false;
    }
    
    // Get permission ID from database
    $CI->load->model('Common_model', 'c_model');
    $permission = $CI->c_model->getSingle('permissions', ['name' => $permission_name], 'id');
    
    if (!$permission) {
        return false;
    }
    
    return in_array($permission['id'], $session_data['permissions']);
}

/**
 * Check if current user has any of the specified permissions
 * @param array $permission_names Array of permission names to check
 * @return bool True if user has any of the permissions, false otherwise
 */
function has_any_permission($permission_names)
{
    foreach ($permission_names as $permission_name) {
        if (has_permission($permission_name)) {
            return true;
        }
    }
    return false;
}

/**
 * Check if current user has all of the specified permissions
 * @param array $permission_names Array of permission names to check
 * @return bool True if user has all permissions, false otherwise
 */
function has_all_permissions($permission_names)
{
    foreach ($permission_names as $permission_name) {
        if (!has_permission($permission_name)) {
            return false;
        }
    }
    return true;
}

/**
 * Check if current user has a specific role
 * @param string $role_name The role name to check
 * @return bool True if user has role, false otherwise
 */
function has_role($role_name)
{
    $CI =& get_instance();
    $session_data = $CI->session->userdata('adminloginstatus');
    
    if (empty($session_data) || !isset($session_data['user_roles'])) {
        return false;
    }
    
    return in_array($role_name, $session_data['user_roles']);
}

/**
 * Check if current user has any of the specified roles
 * @param array $role_names Array of role names to check
 * @return bool True if user has any of the roles, false otherwise
 */
function has_any_role($role_names)
{
    $CI =& get_instance();
    $session_data = $CI->session->userdata('adminloginstatus');
    
    if (empty($session_data) || !isset($session_data['user_roles'])) {
        return false;
    }
    
    foreach ($role_names as $role_name) {
        if (in_array($role_name, $session_data['user_roles'])) {
            return true;
        }
    }
    return false;
}

/**
 * Get current user's primary role
 * @return string The primary role name or 'User' if no roles
 */
function get_primary_role()
{
    $CI =& get_instance();
    $session_data = $CI->session->userdata('adminloginstatus');
    
    if (empty($session_data) || !isset($session_data['user_roles']) || empty($session_data['user_roles'])) {
        return 'User';
    }
    
    return $session_data['user_roles'][0];
}

/**
 * Get current user's all roles
 * @return array Array of role names
 */
function get_user_roles()
{
    $CI =& get_instance();
    $session_data = $CI->session->userdata('adminloginstatus');
    
    if (empty($session_data) || !isset($session_data['user_roles'])) {
        return [];
    }
    
    return $session_data['user_roles'];
}

/**
 * Get current user's permissions
 * @return array Array of permission IDs
 */
function get_user_permissions()
{
    $CI =& get_instance();
    $session_data = $CI->session->userdata('adminloginstatus');
    
    if (empty($session_data) || !isset($session_data['permissions'])) {
        return [];
    }
    
    return $session_data['permissions'];
}

/**
 * Check if current user is admin (has Super Admin role)
 * @return bool True if user is admin, false otherwise
 */
function is_admin()
{
    return has_role('Super Admin');
}

/**
 * Require a specific permission - redirect if not authorized
 * @param string $permission_name The permission name required
 * @param string $redirect_url URL to redirect to if not authorized
 */
function require_permission($permission_name, $redirect_url = null)
{
    if (!has_permission($permission_name)) {
        $CI =& get_instance();
        $CI->session->set_flashdata('error', 'You do not have permission to access this page.');
        
        if ($redirect_url) {
            redirect($redirect_url);
        } else {
            redirect(adminfold('Dashboard'));
        }
    }
}

/**
 * Require any of the specified permissions - redirect if not authorized
 * @param array $permission_names Array of permission names
 * @param string $redirect_url URL to redirect to if not authorized
 */
function require_any_permission($permission_names, $redirect_url = null)
{
    if (!has_any_permission($permission_names)) {
        $CI =& get_instance();
        $CI->session->set_flashdata('error', 'You do not have permission to access this page.');
        
        if ($redirect_url) {
            redirect($redirect_url);
        } else {
            redirect(adminfold('Dashboard'));
        }
    }
}

/**
 * Require a specific role - redirect if not authorized
 * @param string $role_name The role name required
 * @param string $redirect_url URL to redirect to if not authorized
 */
function require_role($role_name, $redirect_url = null)
{
    if (!has_role($role_name)) {
        $CI =& get_instance();
        $CI->session->set_flashdata('error', 'You do not have the required role to access this page.');
        
        if ($redirect_url) {
            redirect($redirect_url);
        } else {
            redirect(adminfold('Dashboard'));
        }
    }
} 

/**
 * Get admin hierarchy level for a user
 * @param int $user_id User ID to check
 * @return int Hierarchy level (1 = Super Admin, 2 = Manager, 3 = User)
 */
function get_admin_hierarchy_level($user_id = null)
{
    $CI =& get_instance();
    
    if (!$user_id) {
        $session_data = $CI->session->userdata('adminloginstatus');
        if (empty($session_data)) {
            return 3; // Default to lowest level
        }
        $user_id = $session_data['user_id'];
    }
    
    // Get user roles
    $user_roles = $CI->c_model->getAll('user_roles', null, ['user_id' => $user_id], 'role_id');
    if (empty($user_roles)) {
        return 3; // Default to lowest level
    }
    
    $role_ids = array_column($user_roles, 'role_id');
    
    // Get role names
    $roles_data = $CI->c_model->getAllwherein('roles', null, 'name', null, 'id', $role_ids);
    if (empty($roles_data)) {
        return 3; // Default to lowest level
    }
    
    $role_names = array_column($roles_data, 'name');
    
    // Determine hierarchy level
    if (in_array('Super Admin', $role_names)) {
        return 1; // Super Admin - highest level
    } elseif (in_array('Manager', $role_names)) {
        return 2; // Manager - middle level
    } else {
        return 3; // User - lowest level
    }
}

/**
 * Check if current user can track bookings of another user
 * @param int $target_user_id User ID whose bookings we want to track
 * @return bool True if current user can track, false otherwise
 */
function can_track_user_bookings($target_user_id)
{
    $CI =& get_instance();
    
    // Get current user's hierarchy level
    $current_level = get_admin_hierarchy_level();
    
    // Super Admin can track everyone
    if ($current_level == 1) {
        return true;
    }
    
    // Get target user's hierarchy level
    $target_level = get_admin_hierarchy_level($target_user_id);
    
    // Users can only track users at same level or below
    return $target_level >= $current_level;
}

/**
 * Get list of user IDs that current user can track
 * @return array Array of user IDs
 */
function get_trackable_user_ids()
{
    $CI =& get_instance();
    
    $current_level = get_admin_hierarchy_level();
    
    // Super Admin can track everyone
    if ($current_level == 1) {
        return []; // Empty array means all users
    }
    
    // Get all users with their hierarchy levels
    $users = $CI->c_model->getAll('users', null, ['status' => 'active'], 'id');
    if (!is_array($users)) { $users = []; }
    $trackable_users = [];
    
    foreach ($users as $user) {
        $user_level = get_admin_hierarchy_level($user['id']);
        if ($user_level >= $current_level) {
            $trackable_users[] = $user['id'];
        }
    }
    
    return $trackable_users;
}

/**
 * Get list of mobile numbers that current user can track
 * @return array Array of mobile numbers
 */
function get_trackable_user_mobiles()
{
    $CI =& get_instance();
    
    $current_level = get_admin_hierarchy_level();
    
    // Super Admin can track everyone
    if ($current_level == 1) {
        return []; // Empty array means all users
    }
    
    // Get all users with their hierarchy levels
    $users = $CI->c_model->getAll('users', null, ['status' => 'active'], 'id, mobile');
    if (!is_array($users)) { $users = []; }
    $trackable_mobiles = [];
    
    foreach ($users as $user) {
        $user_level = get_admin_hierarchy_level($user['id']);
        if ($user_level >= $current_level) {
            $trackable_mobiles[] = $user['mobile'];
        }
    }
    
    return $trackable_mobiles;
}

/**
 * Get admin hierarchy filter for booking queries
 * @return array Array with 'where' conditions for filtering bookings
 */
function get_admin_hierarchy_filter()
{
    $CI =& get_instance();
    
    $current_level = get_admin_hierarchy_level();
    
    // Super Admin can see all bookings
    if ($current_level == 1) {
        return []; // No filter needed
    }
    
    // Get trackable user mobiles
    $trackable_mobiles = get_trackable_user_mobiles();
    
    if (empty($trackable_mobiles)) {
        // If no trackable users, show only own bookings
        $session_data = $CI->session->userdata('adminloginstatus');
        $current_mobile = $session_data['user_mobile'];
        return ['a.add_by' => $current_mobile];
    }
    
    // Filter by trackable user mobiles
    return ['a.add_by IN' => $trackable_mobiles];
}

/**
 * Get admin hierarchy filter for user queries
 * @return array Array with 'where' conditions for filtering users
 */
function get_admin_hierarchy_user_filter()
{
    $CI =& get_instance();
    
    $current_level = get_admin_hierarchy_level();
    
    // Super Admin can see all users
    if ($current_level == 1) {
        return []; // No filter needed
    }
    
    // Get trackable user IDs
    $trackable_user_ids = get_trackable_user_ids();
    
    if (empty($trackable_user_ids)) {
        // If no trackable users, show only current user
        $session_data = $CI->session->userdata('adminloginstatus');
        return ['id' => $session_data['user_id']];
    }
    
    // Filter by trackable user IDs
    return ['id IN' => $trackable_user_ids];
}

/**
 * Check if current user can view booking details
 * @param array $booking Booking data array
 * @return bool True if user can view, false otherwise
 */
function can_view_booking($booking)
{
    $CI =& get_instance();
    
    $current_level = get_admin_hierarchy_level();
    
    // Super Admin can view all bookings
    if ($current_level == 1) {
        return true;
    }
    
    // Get the user who created this booking
    $booking_creator_mobile = $booking['add_by'];
    
    // Get user ID from mobile
    $creator = $CI->c_model->getSingle('users', ['mobile' => $booking_creator_mobile], 'id');
    if (!$creator) {
        return false; // Creator not found
    }
    
    // Check if current user can track this creator
    return can_track_user_bookings($creator['id']);
}

/**
 * Get admin hierarchy display text
 * @param int $user_id User ID (optional, uses current user if not provided)
 * @return string Display text for hierarchy level
 */
function get_admin_hierarchy_display($user_id = null)
{
    $level = get_admin_hierarchy_level($user_id);
    
    switch ($level) {
        case 1:
            return 'Super Admin';
        case 2:
            return 'Manager';
        case 3:
            return 'User';
        default:
            return 'User';
    }
}

/**
 * Get admin hierarchy badge class
 * @param int $user_id User ID (optional, uses current user if not provided)
 * @return string Bootstrap badge class
 */
function get_admin_hierarchy_badge_class($user_id = null)
{
    $level = get_admin_hierarchy_level($user_id);
    
    switch ($level) {
        case 1:
            return 'label-danger';
        case 2:
            return 'label-warning';
        case 3:
            return 'label-info';
        default:
            return 'label-default';
    }
} 