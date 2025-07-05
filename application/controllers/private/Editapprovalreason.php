<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Editapprovalreason extends CI_Controller{
	
	  function __construct() {
         parent::__construct();  
	     adminlogincheck();

      }
	


  public function index() {
	  
	$table = 'pt_booking_terms';
	$currentpage = 'Editapprovalreason';
	$data['posturl'] = adminurl( $currentpage );
    $id = $this->input->get('id') ? $this->input->get('id') : '';

    /*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return='.$currentpage ) );
  	}
  	/*check domain end*/
	 
	
	$data['title'] = ( !empty($id) ? 'Update' : 'Add') .' Edit Approval Terms'; 
	 
	 
	    $data['content'] = ""; 
		$data['contenttype'] = "editapproval"; 
		$data['datacategory'] = "editapproval"; 
		$data['status']="yes"; 
		$data['id'] = $id; 
	
	
	//if( $this->input->post() == true ){  
	
	
	
	
	 if( !empty($id ))
	 {
	 $corpo = $this->c_model->getSingle($table, array( 'id'=>$id ) );
	    $data['id'] = $corpo['id']; 
		$data['content'] = $corpo['content']; 
		$data['contenttype'] = $corpo['contenttype'];  
		$data['datacategory'] = $corpo['datacategory'];  
		$data['status'] = $corpo['status'];  
	 }
	 
	 $this->form_validation->set_rules('datacategory','Select datacategory','required');
	 $this->form_validation->set_rules('contenttype','Select contenttype','required');
	 $this->form_validation->set_rules('content','Select content','required');
	 $this->form_validation->set_rules('status','Select status','required');
	 
	 if($this->form_validation->run() == false){ 
		$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
	 }
		
	 
	 if( $this->form_validation->run() != false){
		 
		$corpo = $this->input->post();
		 
	    $spost['content'] = $corpo['content'];  
		$spost['contenttype'] = isset($corpo['contenttype']) ? $corpo['contenttype'] : '';  
		$spost['datacategory'] = isset($corpo['datacategory']) ? $corpo['datacategory'] : '';
		$spost['status'] = isset($corpo['status']) ? $corpo['status'] : 'yes'; 
		$spost['domain'] = checkdomain('domainid');

		$spost = $this->security->xss_clean($spost);
		 
        if(empty($corpo['id'])){
		$spost['add_date'] = date('Y-m-d H:i:s');
		$spost['add_by'] = 'Admin';
		}   
		
		
		$id = !empty($corpo['id']) ? $corpo['id'] : NULL ;
		$postwhere = !empty($id) ? array('id'=> $id) : NULL ; 
		
		
		$checkpost['content'] = $corpo['content'];
		$checkpost['contenttype'] = $corpo['contenttype'];
		$checkpost['datacategory'] = $corpo['datacategory'];
		
		$checkitem = $this->c_model->countitem( $table, $checkpost );
		
		
		if( !empty($id)){ 
		$ststus = $this->c_model->saveupdate($table,$spost, NULL, $postwhere, NULL );	
		$this->session->set_flashdata('success',"Your data has been updated successfully!");
		redirect( adminurl($currentpage.'/index?id='.$id));
		
		}else if( empty($checkitem) && empty($id)){
		$ststus = $this->c_model->saveupdate($table,$spost, NULL, NULL, NULL );
		$this->session->set_flashdata('success',"Your data has been added successfully!");
		  
		}else if( !empty($checkitem)){
		$this->session->set_flashdata('error',"Data is already exist please check the details!");
		redirect( adminurl( $currentpage ));
		} 
	
	 } 
	 
	  _view( 'editapprovalreason', $data );
	  
   }
   
   
   
     public function view() {
	
	        $data['title'] = 'View Edit Approval Terms';

	        $select = 'a.*, b.domain '; 
		    $from = ' pt_booking_terms as a';
		    
		    $where = [];
		    $where['a.contenttype'] = 'editapproval'; 

		    $join[0]['table'] = 'pt_domain as b';
		    $join[0]['on'] = 'a.domain = b.id';
		    $join[0]['key'] = 'LEFT'; 

		    $orderby = 'a.domain ASC';

		    $data['list'] = $this->c_model->joindata( $select,$where, $from, $join, null,$orderby ); 

		    
			 
		    _viewlist( 'view_edit_approval_reason', $data );
	    
   }
   
   


   public function delete(){
   	 if($id = $this->input->get('delId')){
	   $this->c_model->delete('pt_booking_terms',array('md5(id)'=>$id ));
	   $this->session->set_flashdata('success',"Your data has been deleted successfully!");
	   redirect(adminurl('Editapprovalreason/view'));
	 }
   }
  
	
}
?>