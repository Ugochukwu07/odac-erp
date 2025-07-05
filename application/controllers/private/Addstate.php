<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Addstate extends CI_Controller{
	
	 function __construct() {
         parent::__construct(); 
	     adminlogincheck();
      }
	


  public function index() {
	
	$currentpage = 'Viewstate'; 

	$table = 'state';
    $id = $this->input->get('id') ? $this->input->get('id') : '';
	 
	
	$data['title'] = ( !empty($id) ? 'Update' : 'Add') .' State';
	
	 
	    $data['statename']=""; 
	    $data['statecode']="";
		$data['add_by']=""; 
		$data['add_date']=""; 
		$data['status']=""; 
		$data['id'] = $id; 
		$status = ''; 
	
		
	
	 if( !empty($id ))
	 {
	    $dbstate = $this->c_model->getSingle($table, array( 'id'=>$id ) );
	    $data['id'] = $dbstate['id']; 
		$data['statename'] = $dbstate['statename'];
		$data['statecode'] = $dbstate['statecode']; 
		$data['add_by'] = $dbstate['add_by'];  
		$data['add_date'] = $dbstate['add_date'];  
		$data['status'] = $dbstate['status'];
		$status = $dbstate['status'];   
	 }
	 	 
	 $this->form_validation->set_rules('statename','Enter State name ','required');
	 
	 if($this->form_validation->run() == false){ 
		$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
	 }
		
	 
	 if( $this->form_validation->run() != false){
		 
		$dbstate = $this->input->post();
		 
	    $spost['statename'] = $dbstate['statename']; 
	    $spost['statecode'] = $dbstate['statecode'];  
		$spost['add_by'] = 'admin';  
		empty($dbstate['id']) ? ($spost['add_date'] = date('Y-m-d H:i:s') ) : ''; 
		$spost['status']= isset($dbstate['status']) ? $dbstate['status'] : 'yes';    
		
		
		$id = !empty($dbstate['id']) ? $dbstate['id'] : NULL ;
		$postwhere = !empty($id) ? array('id'=> $id) : NULL ; 
		
		
		$checkpost['statename'] = $dbstate['statename'];
		
		$checkitem = $this->c_model->countitem( $table, $checkpost );
		
		
		if( !empty($id)){
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, $postwhere, NULL );	
		$this->session->set_flashdata('success',"Your data has been updated successfully!");
		redirect( adminurl( $currentpage.'/?id='.$id));
		
		}else if( empty($checkitem) && empty($id)){
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, NULL, NULL );
		$this->session->set_flashdata('success',"Your data has been added successfully!");
		  
		}else if( !empty($checkitem)){
		$this->session->set_flashdata('error',"Data is already exist please check the details!");
		redirect( adminurl( $currentpage ));
		}
		
		
	
	 }
 
      $data['status'] = ( $status === 'no') ? 'no'  : 'yes' ;
	 
	  _view( 'addstate', $data );
	  
   }
   
   
  
	
}
?>