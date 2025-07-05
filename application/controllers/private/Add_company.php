<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Add_company extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
	     $this->pagename = 'Add_company';
	     $this->table = 'pt_insurance_company';
     }	


  public function index() { 

  	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return='.$currentpage ) );
  	}
  	/*check domain end*/ 

	$data['posturl'] = adminurl($this->pagename ).'/savedata';

	$table = $this->table;
    $id = $this->input->get('id') ? $this->input->get('id') : ''; 
	
	$data['title'] = 'Add Insurance Company';

	$data['id'] = ''; 
	$data['company_name'] =  '';
	$data['add_date'] = date('d-m-Y');
	$data['status'] = 'Active'; 
	
	$dateformat = 'd-m-Y';

	if( !empty( $id ) ){
     $old_dta = $this->c_model->getSingle($table,['md5(id)'=>$id],'*');
     
            $data['id'] = $old_dta['id'];
            $data['company_name'] = $old_dta['company_name']; 
            $data['status'] = $old_dta['status']; 
	}  
	 
	$data['redirect'] = $redirect;
 
	  _view( strtolower($this->pagename) , $data );
	  
   }



 public  function savedata(){
     
 	$post = $this->input->post(); 

		    $id = $post['id'];  
	         
            $sdata['company_name'] = !empty($post['company_name']) ? $post['company_name'] : NULL; 
            $sdata['status'] = !empty($post['status']) ? $post['status'] : 'Inactive';   

		    $sdata = $this->security->xss_clean($sdata);
		
		$upwh = null; 
		$check = null;
		if( !empty( $id ) ){
			$upwh['id'] = $id; 
		}
		
		if( empty($id) ){
		    $check = [];
			$check['company_name'] = $sdata['company_name'];
			$check['DATE(add_date)'] = date('Y-m-d'); 
			$sdata['add_date'] = date('Y-m-d H:i:s');  
		}  
		 
		 
		$update = $this->c_model->saveupdate( $this->table , $sdata, $check, $upwh );
		
		
		if( $update && $id ){
    		$this->session->set_flashdata('success',"Data updated successfully!");
    		redirect( adminurl( $this->pagename.'/?id='.md5($id)));
		
		}else if( $update && !$id){ 
    		$this->session->set_flashdata('success',"Data Added successfully!");
    		redirect( adminurl( $this->pagename )) ;
		  
		}else if( !$update ){
    		$this->session->set_flashdata('error',"Duplicate Entry!");
    		redirect( adminurl( $this->pagename )) ;
		}
		
		
	 
 } 
    
  
	
}
?>