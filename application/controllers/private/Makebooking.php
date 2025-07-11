<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Makebooking extends CI_Controller{
	
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
     }	


  public function index() {

	 
	$currentpage = 'makebooking';
	$data['posturl'] = adminurl($currentpage); 
	$data['title'] = 'Create Booking';
	$data['place'] = 'no';   
	
 
      

    if($post = $this->input->post()){
     unset($post['mysubmit']) ; 

     if(empty($post['c_paymode'])){
       $post['c_paymode'] = 'paid';
     }

     /*check customer entry start script*/
     if($post['c_mobile']){
     	$check['uniqueid'] = trim($post['c_mobile']);
     	$save['add_date'] = date('Y-m-d H:i:s');
     	$save['uniqueid'] = trim($post['c_mobile']);
     	$save['mobileno'] = trim($post['c_mobile']);
     	$save['emailid'] = trim($post['c_email']); 
     	$save['fullname'] = trim($post['c_name']);
        $save['address'] = trim($post['c_address']);
     	$save['status'] = 'yes';
     	$update = $this->c_model->saveupdate('pt_customer', $save, $check );
        if($update && empty($post['c_uid'])){ $post['c_uid'] = $update; }
     } 
     /*check customer entry end script*/

     /* store logged in data*/
     if($loginUser = $this->session->userdata('adminloginstatus')){
      $post['add_by'] = $loginUser['logindata']['mobile'];
      $post['add_by_name'] = $loginUser['logindata']['fullname'];
      $post['add_by_id'] = $loginUser['logindata']['id'];
      $post['domainid'] = checkdomain('domainid');
     }

      

     $this->session->set_userdata('adminbooking',$post);


     redirect( PEADEXADMIN );
    }  


    $data['c_uid'] = '';
    $data['c_name'] = '';
    $data['c_mobile'] = '';
    $data['c_email'] = '';
    $data['c_address'] = '';
    $data['c_trip'] = '';
    $data['c_paymode'] = 'cash';
    $data['c_txn_id'] = '';
    $data['c_ad_amount'] = '0';
    $data['c_discount'] = '0';

    if($return = $this->session->userdata('adminbooking') ){
            $data['c_uid'] = $return['c_uid'];
            $data['c_name'] = $return['c_name'];
            $data['c_mobile'] = $return['c_mobile'];
            $data['c_email'] = $return['c_email'];
            $data['c_address'] = !empty($return['c_address']) ? $return['c_address'] : '';
            $data['c_trip'] = $return['c_trip'];
            $data['c_paymode'] = $return['c_paymode'];
            $data['c_ad_amount'] = $return['c_ad_amount'];
            $data['c_discount'] = $return['c_discount'];
    }
   
   
 
	  _view( 'makebooking', $data );
	  
   }



   public function getdetails(){
   	$post = $this->input->post();
   	$keys = 'uniqueid,emailid,fullname,id,address';
   	$output = $this->c_model->getSingle('pt_customer',$post ,$keys );
   	echo json_encode( $output );
   }

    public function reset(){ 
    	$this->session->unset_userdata('adminbooking');
    	 redirect( adminurl('makebooking') );
   }

 
	
}
?>