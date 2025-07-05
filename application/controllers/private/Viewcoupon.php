<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewcoupon extends CI_Controller{
	
	
	public  function __construct() {
         parent::__construct();  
	     adminlogincheck();
     }	

	
	 
	public function index(){

            

            $title = 'View Coupon List';
	        $data['title'] = $title;
	        $data['list'] = array();  
		    $data['list'] = $this->c_model->getAll('pt_coupon','id DESC');
 
		    _viewlist( 'viewcoupon', $data );
 
		}


public  function delete(){
    if( $this->input->get('delId') ){
      $this->c_model->delete( 'pt_coupon', array('md5(id)'=>$this->input->get('delId') ) ); 
      $this->session->set_flashdata('success',"Coupon Deleted successfully!");
      $corpouid = isset($input['corpouid']) ? $input['corpouid'] : '';
      redirect( adminurl( 'viewcoupon' ));
            
      }
   }
  


	}
?>