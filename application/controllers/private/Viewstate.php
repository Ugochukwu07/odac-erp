<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewstate extends CI_Controller{
	
	 function __construct() {
         parent::__construct();  
	     adminlogincheck();
      }
	


  public function index() {
	
	        $data['title'] = 'View State';
		    $data['list'] = $this->c_model->getAll('state',null,null);
			 
		    _viewlist( 'viewstate', $data );
	    
   }



   public function deletestate(){

      if( $id = $this->input->get('delId') ){
      	$this->c_model->delete('state',array('md5(id)'=>$id));
      	$this->session->set_flashdata('error',"State deleted successfully!");
      	redirect( adminurl('Viewstate') );
      }

   }
   

}
?>