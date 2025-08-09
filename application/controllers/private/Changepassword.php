<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Changepassword extends CI_Controller{
	
	public function __construct(){
		parent::__construct(); 
		adminlogincheck();
	}


  public function index() {
	
	$currentpage = 'Changepassword'; 
	$data['posturl'] = adminurl( $currentpage ).'/';

	// Use the new RBAC users table and current logged-in user
	$table = 'users';
	$sessionData = $this->session->userdata('adminloginstatus');
	$id = !empty($sessionData['user_id']) ? (int)$sessionData['user_id'] : null;
	 
	
	$data['title'] = 'Update Password';
	$status = '';
	
	 
	 
	 
		$data['username']="";  
		$data['password']="";  

		$data['id'] = '1'; 
	
		
	
	 if( !empty($id ))
	 {  
	    $dbuser = $this->c_model->getSingle($table, array( 'id'=>$id ) );
	    
	    $data['id'] = $dbuser['id']; 
		$data['username'] = !empty($dbuser['mobile']) ? $dbuser['mobile'] : '';
		$data['password'] = $dbuser['password']; 
	 }

	 	 
	  
	 $this->form_validation->set_rules('username','Username is blank!','required');
	 $this->form_validation->set_rules(  'password', 'Password', 'trim|required|min_length[6]|max_length[25]',array('required'=>'Password is Blank.')); 
	 
	 if($this->form_validation->run() == false){ 
		$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
	 }
		
	 
	 if( $this->form_validation->run() != false){
		 
		$dbpost = $this->input->post();
		
		// Only update password for current user
		$spost = [];
		$spost['password'] = md5($dbpost['password']);  
  		$spost = $this->security->xss_clean($spost);
 
	      
	   
		
		$id = !empty($dbpost['id']) ? $dbpost['id'] : NULL ;
		$postwhere = !empty($id) ? array('id'=> $id) : NULL ; 
		
		 
		
		if( $id ){
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, $postwhere, NULL );	
		$this->session->unset_userdata('adminloginstatus');
		redirect( base_url( 'mylogin.html' ));
		
		}
		
		
	
	 }
 
 
	 
	  _view( 'changepassord', $data );
	  
   }
   
   
  
	
}
?>