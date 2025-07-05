<?php defined('BASEPATH') OR exit('No direct script access allowed');

class View_company extends CI_Controller{
	
	 function __construct() {
         parent::__construct();  
	     adminlogincheck();
      }
	


  public function index() {
	
	        $data['title'] = 'View Insurance Company List';
		    $data['list'] = $this->c_model->getAll('pt_insurance_company' );
			 
		    _viewlist( 'view_company', $data );
	    
   }



   public function deletestate(){

      if( $id = $this->input->get('delId') ){
      	$this->c_model->delete('pt_insurance_company',array('md5(id)'=>$id));
      	$this->session->set_flashdata('error',"Company deleted successfully!");
      	redirect( adminurl('View_company') );
      }

   }
   

}
?>