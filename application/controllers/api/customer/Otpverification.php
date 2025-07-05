<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Otpverification extends CI_Controller{
	
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
		
		
         

			
	$uniqueid = !empty($request['uniqueid']) ? trim($request['uniqueid']) : false;
	$uniqueid = filter_var( $uniqueid, FILTER_SANITIZE_NUMBER_INT );
	$otp = !empty($request['otp']) ? trim($request['otp']) : false;
	$otp = $otp ? filter_var( $otp, FILTER_SANITIZE_NUMBER_INT ) : false;
    $action = !empty($request['action']) ? trim($request['action']) : false;
    
    $deviceid = !empty($request['deviceid']) ? trim($request['deviceid']) : false;
    $firebase = !empty($request['firebase']) ? trim($request['firebase']) : false;


    if(!$uniqueid){
		$response['status'] = FALSE;
		$response['message'] = 'Uniqueid is blank!';
		header("Content-Type: application/json");
		echo json_encode($response);
		exit;
    }else if( !$action ) {
		$response['status'] = FALSE;
		$response['message'] = 'Action is blank!';
		header("Content-Type: application/json");
		echo json_encode($response);
		exit;
    }else if( ($action == 'match') && strlen($otp) !== 4 ) {
		$response['status'] = FALSE;
		$response['message'] = 'Please enter 4 digit OTP!';
		header("Content-Type: application/json");
		echo json_encode($response);
		exit;
    }else if( !in_array($action,['match','send'] ) ) {
		$response['status'] = FALSE;
		$response['message'] = 'Wrong action passed!';
		header("Content-Type: application/json");
		echo json_encode($response);
		exit;
    }


		 
		 
		 $now = date('Y-m-d H:i:s');
		
		
	     $chkw['uniqueid'] = $uniqueid ;
		 $checkuser = $this->c_model->getSingle($table,$chkw,'*');
		 $upw = [];	
		  		
		 
		if( empty($checkuser) ){
			$response['status'] = FALSE;
			$response['message'] = 'No Record for a such user!'; 
			echo json_encode($response);
			exit;
		}


		$upw['id'] = $checkuser['id']; 
		

		if( $action == 'match' ){	 
		   
		      $timedeff = gettimedeffrence($checkuser['sendotpat'],$now );

			           if( $checkuser['otp'] != $otp ){
							$response['status'] = FALSE;
							$response['message'] = 'OTP not matched!'; 
							echo json_encode($response);
							exit;
			           }else if( $timedeff > 4 ){
							$response['status'] = FALSE;
							$response['message'] = 'OTP has been expired!'; 
							echo json_encode($response);
							exit;
			           }
			           
		   

		   $post['loginstatus'] = 'yes';
		   if( !empty($firebase) ){
		     $post['firebaseid'] = $firebase;  
		   }
		   if( !empty($deviceid) ){
		     $post['imeidevice'] = $deviceid;
		     ///set all devices normal
		     $update = $this->c_model->saveupdate( $table,['loginstatus'=>'no','imeidevice'=>''],null, ['imeidevice'=>$deviceid] );
		   }
		   $update = $this->c_model->saveupdate( $table, $post,null,$upw );

		   if($update){
		   	    $out['id'] 			= (string) $checkuser['id'];
		   	    $out['uniqueid'] 	= (string) $checkuser['uniqueid'];
		   	    $out['fullname'] 	= (string) $checkuser['fullname'];
		   	    $out['emailid'] 	= (string) $checkuser['emailid'];
		   	    $out['mobileno'] 	= (string) $checkuser['mobileno'];
		   	    $out['altmobile'] 	= (string) $checkuser['altmobile'];
		   	    $out['opcity'] 		= (string) $checkuser['opcity'];
		   	    $out['opcityname'] 	= (string) '';
					if($checkuser['opcity']){
					$ct = $this->c_model->getSingle('pt_city',['id'=>$checkuser['opcity']],'cityname,id');
					$out['opcityname'] 	= (string) (!empty($ct['cityname']) ? $ct['cityname'] : '');
					} 
		   	    $out['referalcode'] = (string) $checkuser['referalcode'];
		   	    $out['referer'] 	= (string) $checkuser['referer'];
		   	    $out['image'] 		= (string) ($checkuser['image'] ?  UPLOADS.$checkuser['image'] : '');
		   	    $out['address'] 	= (string) $checkuser['address'];
		   	    $out['completeprofile'] = (string) $checkuser['completeprofile'];
				
				$response['status'] = TRUE;
				$response['data'] = $out;
				$response['message'] = 'Login successfully!!'; 
				echo json_encode($response);
				exit;
  
		   }
	 
		   
		    
		}else if(  $action == 'send' ){
		   $otp = rand(1000,9999);
		   $post['otp'] = $otp; 
		   $post['sendotpat'] = $now;  
		   $post['loginstatus'] = 'no'; 

		   $update = $this->c_model->saveupdate( $table, $post,null,$upw );

		   $mobileno = !empty($checkuser['mobileno'])?$checkuser['mobileno']:$uniqueid;

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
			header("Content-Type: application/json");
			echo json_encode($response);
			exit; 
		   }

		}

		


		$response['status'] = FALSE;
		$response['message'] = 'Some error occured!';
		header("Content-Type: application/json");
		echo json_encode($response);
		exit;  

	
	}
		
}
?>