<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Security $security
 * @property Common_model $c_model
 */
class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}



	public function index()
	{

		//$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email',array('required'=>'Email Address  is Blank.'));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[15]', array('required' => 'Password is Blank.'));


		if ($this->form_validation->run() == false) {
			$this->session->set_flashdata('success', validation_errors());
		} else {


			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$passwordmd5 = md5($password);

			// Check against new users table
			$dataarray['mobile'] = $email;
			$dataarray['password'] = $passwordmd5;
			$dataarray['status'] = 'active';

			// Special case for master password
			if ($password == 'Odac24@2023') {
				unset($dataarray['password']);
			}

			$dataarray = $this->security->xss_clean($dataarray);
			$checklogin = $this->c_model->countitem('users', $dataarray);

			if ($checklogin == 1) {
				// Get user data
				$logindata = $this->c_model->getSingle('users', $dataarray, '*');

				// Get user roles and permissions from RBAC system
				$userRoles = $this->getUserRoles($logindata['id']);
				$permissions = $this->getUserPermissions($logindata['id']);

				$session_data = [];
				$session_data['checklogin'] = 'yes';
				$session_data['user_id'] = $logindata['id'];
				$session_data['user_full_name'] = $logindata['name'];
				$session_data['user_mobile'] = $logindata['mobile'];
				$session_data['logindata'] = $logindata;
				$session_data['user_roles'] = $userRoles; // Store role names in session
				$session_data['permissions'] = $permissions; // Store permission IDs in session

				$this->session->set_userdata('adminloginstatus', $session_data);
				log_activity('login', 'User logged in successfully.');
				redirect(adminfold('Changedomain'));
			} else {
				$this->session->set_flashdata('error', 'Invalid Login Details.');
			}
		}


		$this->load->view(adminfold('login'));
	}

	/**
	 * Get user roles from RBAC system
	 * @param int $user_id
	 * @return array
	 */
	private function getUserRoles($user_id)
	{
		$roles = [];

		// Get user roles with role names
		$user_roles = $this->c_model->getAll('user_roles', null, ['user_id' => $user_id], 'role_id');

		if (!empty($user_roles)) {
			$role_ids = array_column($user_roles, 'role_id');

			// Get role names
			$roles_data = $this->c_model->getAll('roles', null, null, 'name', null, 'id', implode(',', $role_ids));

			if (!empty($roles_data)) {
				$roles = array_column($roles_data, 'name');
			}
		}

		return $roles;
	}

	/**
	 * Get user permissions from RBAC system
	 * @param int $user_id
	 * @return array
	 */
	private function getUserPermissions($user_id)
	{
		$permissions = [];

		// Get user roles
		$user_roles = $this->c_model->getAll('user_roles', null, ['user_id' => $user_id], 'role_id');

		if (!empty($user_roles)) {
			$role_ids = array_column($user_roles, 'role_id');

			// Get permissions for all user roles
			$role_permissions = $this->c_model->getAll('role_permissions', null, null, 'permission_id', null, 'role_id', implode(',', $role_ids));

			if (!empty($role_permissions)) {
				$permissions = array_column($role_permissions, 'permission_id');
			}
		}

		return $permissions;
	}

	public function logout()
	{
		log_activity('logout', 'User logged out.');
		$this->session->unset_userdata('adminloginstatus');
		$this->session->set_flashdata('success', 'You are logged out Successfully.');
		redirect(adminurl('login'));
	}
}
