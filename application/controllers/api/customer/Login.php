<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Login extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");
		header("Content-Type: application/json");
		}
		
	
	
	public function index(){ 
	    
				$response = array();
				    $data = array();  
					
				   $table = 'customer';
				 
				 $request = getparam(); 
	 
		
	if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){
		$response['status'] = FALSE;
		$response['message'] = 'Bad Request!';
		echo json_encode($response);
		exit;
	}
		
		
         

			
	$mobileno = !empty($request['mobileno']) ? trim($request['mobileno']) : false;
	$mobileno = filter_var( $mobileno, FILTER_SANITIZE_NUMBER_INT );
	$firebase = !empty($request['firebase']) ? trim($request['firebase']) : false;
    $deviceid = !empty($request['deviceid']) ? trim($request['deviceid']) : false;


    if(!$mobileno){
		$response['status'] = FALSE;
		$response['message'] = 'Mobile number is blank!'; 
		echo json_encode($response);
		exit;
    }else if( strlen($mobileno) !== 10 ) {
		$response['status'] = FALSE;
		$response['message'] = 'Please enter 10 digit mobile number!'; 
		echo json_encode($response);
		exit;
    }else if( !$firebase ) {
		$response['status'] = FALSE;
		$response['message'] = 'Firebase Id is blank!'; 
		echo json_encode($response);
		exit;
    }else if( !$deviceid ) {
		$response['status'] = FALSE;
		$response['message'] = 'Device Id is blank!'; 
		echo json_encode($response);
		exit;
    }


		 
		 $otp = rand(1000,9999);
		 $sendotpat = date('Y-m-d H:i:s');
		
		
	     $chkw['uniqueid'] = $mobileno ;
		 $checkuser = $this->c_model->getSingle($table,$chkw,'emailid,mobileno,status,id');
		 $upw = null;	
		  		
		/* Check User  start*/
		if( !empty($checkuser) ){

		   $mobileno = !empty($checkuser['mobileno'])?$checkuser['mobileno']:$mobileno;
		   $upw['id'] = $checkuser['id'];	
	 
		   
		   $post['otp'] = $otp; 
		   $post['sendotpat'] = $sendotpat;
		   $post['firebaseid'] = $firebase;
		   $post['imeidevice'] = $deviceid; 
		   $post['loginstatus'] = 'no'; 
		}else if( empty($checkuser) ){
		   $post['otp'] = $otp; 
		   $post['sendotpat'] = $sendotpat;
		   $post['firebaseid'] = $firebase;
		   $post['imeidevice'] = $deviceid; 
		   $post['loginstatus'] = 'no';
		   $post['status'] = 'yes';
		   $post['uniqueid'] = $mobileno;
		   $post['mobileno'] = $mobileno;
		   $post['add_date'] = $sendotpat;
		   $post['referalcode'] = $mobileno;
		   $post['completeprofile'] = 'no';  
		   }

		   $update = $this->c_model->saveupdate( $table, $post,null,$upw ) ;

		   if($update){

		   	if(!empty($checkuser)){
		   	$msg = 'Your Login OTP is : '.$otp.' Rana Cabs';
		   	$sms = sendsms($mobileno,$msg,'1707167991472578110');
		   	}else{
		   	$msg = 'Your Account Verification OTP Code is : '.$otp.' Rana Cabs'; 
		   	$sms = sendsms($mobileno,$msg,'1707167998930246555');
		   	}

		   	$response['status'] = TRUE;
			$response['message'] = 'OTP send successfully at your '.(!empty($checkuser)?'registered ':'').'mobile no!'; 
			echo json_encode($response);
			exit; 
		   }


	
	}
		
}
?>