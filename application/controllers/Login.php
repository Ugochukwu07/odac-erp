<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	 
public function index(){

    $data = [];
    $data['metadescription'] = '';
    $data['metasummary'] = '';
    $data['metakeywords'] = '';
    $data['title'] = 'Login with Rana Cabs Pvt Ltd';
    $data['heading'] = '';
    $data['description'] = '';
    $data['utm'] = $this->input->get('utm')?$this->input->get('utm'):'';

    $this->load->view( 'includes/doctype',$data );
    $this->load->view( 'includes/meta_file',$data );
    $this->load->view( 'includes/allcss',$data );
    $this->load->view( 'includes/analytics_file',$data );
    $this->load->view( 'includes/header',$data ); 


    $this->load->view( 'newlogin',$data );
    $this->load->view( 'includes/footer',$data );
    $this->load->view( 'includes/all-js',$data );
    $this->load->view( 'includes/footer-bottom',$data );
}

public function signup(){

  $utm = $this->input->get('utm')?$this->input->get('utm'):'';
  $data = [];
  $data['utm'] = !empty($utm)?$utm :'';

     
    $data['metadescription'] = '';
    $data['metasummary'] = '';
    $data['metakeywords'] = '';
    $data['title'] = 'Sign up with Rana Cabs Pvt Ltd';
    $data['heading'] = '';
    $data['description'] = '';

    $this->load->view( 'includes/doctype',$data );
    $this->load->view( 'includes/meta_file',$data );
    $this->load->view( 'includes/allcss',$data );
    $this->load->view( 'includes/analytics_file',$data );
    $this->load->view( 'includes/header',$data ); 


    $this->load->view( 'signup',$data );
    $this->load->view( 'includes/footer',$data );
    $this->load->view( 'includes/all-js',$data );
    $this->load->view( 'includes/footer-bottom',$data );
}



 public  function dologin(){
  $utm = $this->input->get('utm')?$this->input->get('utm'):'';
  $data = [];
  $data['utm'] = !empty($utm)?$utm :''; 

  //$this->session->unset_userdata('adminbooking');
  //$this->session->unset_userdata('frontbooking');

  $data['posturl'] = PEADEX.'login/dologin?utm='.$utm;

  if(!empty($utm)){
  $goto = PEADEX.'reservation_form.html?utm='.$utm;
  }else if(empty($utm)){
  $goto = PEADEX.'dashboard/index';
  }

  if($return = $this->session->userdata('adminbooking') ){ 
  redirect( $goto );
  }else if($return = $this->session->userdata('frontbooking') ){ 
  redirect( $goto );
  } 

    $data['metadescription'] = '';
    $data['metasummary'] = '';
    $data['metakeywords'] = '';
    $data['title'] = 'Login With Ranacabs Pvt Ltd';
    $data['heading'] = '';
    $data['description'] = '';

    $this->load->view( 'includes/doctype',$data );
    $this->load->view( 'includes/meta_file',$data );
    $this->load->view( 'includes/allcss',$data );
    $this->load->view( 'includes/analytics_file',$data );
    $this->load->view( 'includes/header',$data ); 


    $this->load->view( 'newlogin',$data );
    $this->load->view( 'includes/footer',$data );
    $this->load->view( 'includes/all-js',$data );
    $this->load->view( 'includes/footer-bottom',$data );

 } 
	

public function sendotp(){
   $utm = $this->input->post('utm');
   $mobileno = $this->input->post('mob');
   $mobileno = filter_var($mobileno,FILTER_SANITIZE_NUMBER_INT ); 
    if(!$mobileno ){
      echo 'nomob';
      exit;
    }

   $store = [];
   $save = [];
   $otp = rand(1000,9999);
   $update = false;
   $check = false;

   if( strlen($mobileno)==10 ){
     $check = $this->c_model->getSingle('pt_customer',['uniqueid'=>$mobileno],'*');
       if(!empty($check)){ 

            $store['c_uid'] = $check['id'];
            $store['c_mobile'] = $check['mobileno'];

            $save['otp'] = $otp;
            $save['sendotpat'] = date('Y-m-d H:i:s');
            $update = $this->c_model->saveupdate('pt_customer', $save ,null,['id'=>$check['id']]);

            if($update){ 
            $msg = "Dear ".$check['fullname']." Your One Time Password for login is ".$otp.". Put this OTP and press submit. Please do not share the OTP with anyone. The OTP expires in 10 mints. Rana Cabs Pvt. Ltd."; 
            $sms = sendsms($mobileno,$msg,'1707170064125940857'); 
            }

            /*store in session*/
            if(!empty($store)){ $this->session->set_userdata('checkotp',$store); }

            echo 'sent';
            exit;
       } else{
        echo 'nouser'; exit;
       }

        
   } 
}



public function otp(){
  $utm = $this->input->post('utm')?$this->input->post('utm'):$this->input->get('utm');
  $data['utm'] = $utm; 
  $data['posturl'] = PEADEX.'login/otp?utm='.$utm;
  if($this->session->userdata('checkotp')){
    $input = $this->session->userdata('checkotp'); 
    //print_r($input); exit;
    $this->load->view('otp',$data);
  }else{
    redirect( PEADEX.'login/dologin?utm='.$utm );
  }

}


public function motp(){
  $utm = $this->input->post('utm')?$this->input->post('utm'):$this->input->get('utm');
  $otp = $this->input->post('otp'); 
  if(!$otp){
    echo 'nomatch'; 
    exit;
  }


  if($this->session->userdata('checkotp')){
    $input = $this->session->userdata('checkotp'); 
    $where['id'] = $input['c_uid'];
    $where['mobileno'] = $input['c_mobile'];
    $where['otp'] = $otp;
    $where['sendotpat <='] = date('Y-m-d H:i:s');
    $where['sendotpat >='] = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s').'-10 minutes'));

    $check = $this->c_model->getSingle('pt_customer',$where,'*');
    //print_r($check); exit;
    if($check){
            $store['c_uid'] = $check['id'];
            $store['c_mobile'] = $check['mobileno'];
            $store['c_name'] = $check['fullname']; 
            $store['c_email'] = $check['emailid']; 
            $store['c_paymode'] = '';
            $store['c_ad_amount'] = '';
            $store['c_discount'] = '';
            $this->session->unset_userdata('checkotp');
            $this->session->set_userdata('frontbooking',$store);
            if($this->session->userdata('frontbooking')){ 
                if($utm){ 
                  echo 'gotourl'; exit;
                }
                 echo 'dashboard'; exit; 
            }
    } 
      echo 'expire'; exit;
  }  
echo 'repeat'; exit;

}



public function resendotp(){
    
    $otp = rand(1000,9999);
  if($this->session->userdata('checkotp')){
    $input = $this->session->userdata('checkotp'); 
    $where['id'] = $input['c_uid'];
    $where['mobileno'] = $input['c_mobile'];
    $save['otp'] = $otp;
    $save['sendotpat'] = date('Y-m-d H:i:s'); 
    $update = $this->c_model->saveupdate('pt_customer',$save,null,$where );
    
    $msg = 'Your Login OTP is : '.$otp.' Rana Cabs';
    $sms = sendsms($input['c_mobile'],$msg,'1707162183973906750');

    $response['status'] = true;
    $response['msg'] = 'OTP send successfully!';
    header('Content-Type:application/json');
    echo json_encode($response); exit;

   }else{ redirect( PEADEX ); } 
}


function register(){
  $post = $this->input->post()?$this->input->post():$this->input->get();
  $fullname = trim($post['f']);
  $emailid  = trim($post['e']);
  $emailid  = filter_var($emailid, FILTER_VALIDATE_EMAIL );
  $mobileno = trim($post['m']);
  $mobileno = filter_var($mobileno, FILTER_SANITIZE_NUMBER_INT );
  $password = trim($post['p']);

  if(!$fullname){
  echo 'FullName Required';
  exit;
  }else if( !$emailid ){
  echo 'Email ID Required';
  exit;
  }else if( strlen($mobileno)!=10 ){
  echo 'Mobile no Required';
  exit;
  }else if( !$password ){
  echo 'Password Required';
  exit;
  }

   
     $check = $this->c_model->getSingle('pt_customer',['uniqueid'=>$mobileno]);
       if(empty($check)){ 

            $save['fullname'] = ucwords($fullname);
            $save['emailid']  = $emailid;
            $save['mobileno'] = $mobileno;
            $save['uniqueid'] = $mobileno;
            $save['password'] = $password;
            $save['enpassword'] = md5($password);
            $save['address'] = ''; // Set default empty address
            $save['completeprofile'] = 'yes';
            $save['status']   = 'yes';
            $save['add_date'] = date('Y-m-d H:i:s');
            $update = $this->c_model->saveupdate('pt_customer', $save );

            if($update){
              echo 'done';
              exit;
            }
            echo 'Register again';
            exit;  
     }
      echo 'Use Other Mobile';
      exit;

}

public function loginwithpassowrd(){
  $post = $this->input->post()?$this->input->post():$this->input->get(); 
  $mobileno = trim($post['u']);
  $mobileno = filter_var($mobileno, FILTER_SANITIZE_NUMBER_INT );
  $password = trim($post['p']);
  $utm = trim($post['utm']);

  if(!$mobileno){
  echo 'Username required';
  exit;
  }else if( strlen($mobileno) != 10 ){
  echo 'Enter Valid Mobile No.';
  exit;
  }else if( !$password ){
  echo 'Password Required';
  exit;
  }

$where = []; 
$where['uniqueid'] = $mobileno; 
$where['enpassword'] = md5($password); 

$check = $this->c_model->getSingle('pt_customer',$where,'*' );

  if($check){
            $store['c_uid'] = $check['id'];
            $store['c_mobile'] = $check['mobileno'];
            $store['c_name'] = $check['fullname']; 
            $store['c_email'] = $check['emailid']; 
            $store['c_paymode'] = '';
            $store['c_ad_amount'] = '';
            $store['c_discount'] = '';
            $this->session->unset_userdata('checkotp');
            $this->session->set_userdata('frontbooking',$store);
            if($this->session->userdata('frontbooking')){ 
                if($utm){
                  echo 'gotourl'; exit; 
                }else{ echo 'dashboard'; exit; } 
            }
    }
echo 'novalid';
exit;

}


function logout(){
   if($this->session->userdata('frontbooking')){ 
      $this->session->unset_userdata('frontbooking');
      redirect( PEADEX );
   }
}


public function otplogin(){

  $utm = $this->input->get('utm')?$this->input->get('utm'):'';
  $data = [];
  $data['utm'] = !empty($utm)?$utm :'';

     
    $data['metadescription'] = '';
    $data['metasummary'] = '';
    $data['metakeywords'] = '';
    $data['title'] = '';
    $data['heading'] = '';
    $data['description'] = '';

    $this->load->view( 'includes/doctype',$data );
    $this->load->view( 'includes/meta_file',$data );
    $this->load->view( 'includes/allcss',$data );
    $this->load->view( 'includes/analytics_file',$data );
    $this->load->view( 'includes/header',$data ); 


    $this->load->view( 'loginotp',$data );
    $this->load->view( 'includes/footer',$data );
    $this->load->view( 'includes/all-js',$data );
    $this->load->view( 'includes/footer-bottom',$data );
}


}
?>