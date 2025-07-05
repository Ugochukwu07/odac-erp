<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Callback extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	 
public function index(){

    $data = [];
    $data['metadescription'] = '';
    $data['metasummary'] = '';
    $data['metakeywords'] = '';
    $data['title'] = 'Get A Call Back by Rana Cabs Pvt Ltd.';
    $data['heading'] = ''; 
    
    /* citylist code */
    $cityurl = API_PATH.('api/citylist');
     $citylist = curl_apis($cityurl,'GET');
     $data['citylist'] = array();
     if($citylist['status']){
     	$data['citylist'] = $citylist['list'];
     }
     

    $this->load->view( 'includes/doctype',$data );
    $this->load->view( 'includes/meta_file',$data );
    $this->load->view( 'includes/allcss',$data );
    $this->load->view( 'includes/analytics_file',$data );
    $this->load->view( 'includes/header',$data ); 


    $this->load->view( 'callback',$data );
    $this->load->view( 'includes/footer',$data );
    $this->load->view( 'includes/all-js',$data );
    $this->load->view( 'includes/footer-bottom',$data );
}

function send(){
    $post = $this->input->post() ?  $this->input->post() : [];
    $post = $this->security->xss_clean($post);
    
    $response = [];
    $response['status'] = false ;
    $response['message'] = '' ;
    
    if( empty($post['fullname'])){
       $response['message'] = 'Please Enter Full Name' ; 
       echo json_encode( $response ); exit;
    }
    else if( empty($post['mobileno'])){
       $response['message'] = 'Please Enter 10 Digit Mobile Number' ; 
       echo json_encode( $response ); exit;
    }
    else if( empty($post['emailid'])){
       $response['message'] = 'Please Enter Valid Email Id' ; 
       echo json_encode( $response ); exit;
    }
    else if( empty($post['c_trip'])){
       $response['message'] = 'Please Select Service Type' ; 
       echo json_encode( $response ); exit;
    }
    else if( empty($post['sourcecity'])){
       $response['message'] = 'Please Select Service City' ; 
       echo json_encode( $response ); exit;
    }
    else if( empty($post['sourcecity_name'])){
       $response['message'] = 'Please Select Service City' ; 
       echo json_encode( $response ); exit;
    }
    else if( empty($post['remark'])){
       $response['message'] = 'Please Enter Some Remark' ; 
       echo json_encode( $response ); exit;
    }
    else if( empty($post['captua_code'])){
       $response['message'] = 'Please Enter Valid Captua Code' ; 
       echo json_encode( $response ); exit;
    }
    else if( empty($post['hi_captua_code'])){
       $response['message'] = 'Please Enter Valid Captua Code' ; 
       echo json_encode( $response ); exit;
    }
    
    $saveData = [];
    $saveData['lead_uid'] = 'RCLD'.date('YmdHis');
    $saveData['full_name'] = $post['fullname'];
    $saveData['mobile_no'] = $post['mobileno'];
    $saveData['email_id'] = $post['emailid'];
    $saveData['service_type'] = $post['c_trip'];
    $saveData['service_city'] = $post['sourcecity'];
    $saveData['service_city_name'] = $post['sourcecity_name'];
    $saveData['remark'] = $post['remark'];
    $saveData['add_date'] = date('Y-m-d H:i:s');
    $saveData['lead_status'] = 'new';
    $saveData['domain_id'] = DOMAINID;
    
    $this->c_model->saveupdate('pt_leads', $saveData );
    
    $admin_mobile = '8747000041';
    
     /*send to admin sms format */
     //$msgadmin = 'New Query By '.$data['name'].',Email: '.$data['emailid'].', Mobile no.: '.$data['mobile'].', Query: '.$data['comment'].' Rana Cabs Pvt. Ltd.';
     $msgadmin =  'Requested For A Call By This Mobile no.: '.$post['mobileno'].' Rana Cabs';
     $msgadmin = "New Query By ".$post['fullname'].",Email: ".$post['emailid'].", Mobile no.: ".$post['mobileno'].", Service Type ".$post['c_trip']." Citi ".$post['sourcecity_name']." Query Details : ".$post['remark']." Received Check & Confirm this Query. Rana Cabs Pvt Ltd";

     /*send to client sms format */
     //$msgclient ='Thanks For Visiting Rana Cabs Website. Our Relationship Manager +91'.$admin_mobile.' Will Contact You Soon. Rana Cabs';
     //$msgclient ='Rana Cabs Website. Our Relationship Manager +919988412141 Will Contact You Soon';
     $msgclient = "Dear ".$post['fullname']." Your Query has been generated. Our Relationship Manager Mobile Number:+919988412141 Will Contact You Soon. Thanks for Choosing. Rana Cabs Pvt Ltd.";
     
     
     $sensmsd =  sendsms( $admin_mobile ,$msgadmin,'1707170056017413637'); 
     $sensmsd =  sendsms( '9988412141' ,$msgadmin,'1707170056017413637');  
	 $sensmsd =  sendsms($post['mobileno'],$msgclient,'1707170055089807892');
	
    
    $response['status'] = true ;
    $response['message'] = 'Request Submitted Successfully' ; 
    echo json_encode( $response ); exit;
    
    
}


}
?>