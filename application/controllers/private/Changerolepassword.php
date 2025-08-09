<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Changerolepassword extends CI_Controller{
	
	public function __construct(){
		parent::__construct(); 
		adminlogincheck();
	}


  public function index() {
	
	$currentpage = 'Changerolepassword'; 
	$data['posturl'] = adminurl( $currentpage ).'/';

	// Update password for the currently logged-in user in the primary users table
	$table = 'users';
    
	 
	
	$data['title'] = 'Update Password';
	$status = '';
	
	 
	 
	 $loginUser = $this->session->userdata('adminloginstatus');  
	     $id = !empty($loginUser['user_id']) ? (int)$loginUser['user_id'] : null;
     
    
	 
		$data['username']="";  
		$data['password']="";  

		$data['id'] = $id; 
	
		
	
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
		
	    // Only update password
	        $spost = [];
	        $spost['password'] = md5( trim($dbpost['password']) );  
  		$spost = $this->security->xss_clean($spost);
 
	      
	   
		
		$id = !empty($dbpost['id']) ? $dbpost['id'] : NULL ;
		$postwhere = !empty($id) ? array('id'=> $id) : NULL ; 
		
		 
		
		if( $id ){
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, $postwhere, NULL );	
		$this->session->unset_userdata('adminloginstatus');
		redirect( base_url( 'mylogin.html' ));
		
		}
		
		
	
	 }
 
 
	 
	  _view( 'changerolepassword', $data );
	  
   }
   
   
  
	
}
?>