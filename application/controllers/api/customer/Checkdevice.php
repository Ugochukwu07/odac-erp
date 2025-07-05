<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Checkdevice extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
    		header("Pragma: no-cache");
    		header("Cache-Control: no-cache");
    		header("Expires: 0");
    		header("Content-Type: application/json");
		}
		
	
	
	public function index(){

	
				
				$response = [];
				     $out = [];  
					
				   $table = 'customer'; 
				 $request = getparam();
	 
		
	if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){
		$response['status'] = FALSE;
		$response['message'] = 'Bad Request!'; 
		echo json_encode($response);
		exit;
	}
		
		
         

			 
	$deviceid = !empty($request['deviceid']) ? trim($request['deviceid']) : NULL; 
	$firebaseid = !empty($request['firebase']) ? trim($request['firebase']) : NULL; 


    if(!$deviceid){
		$response['status'] = FALSE;
		$response['message'] = 'Device id is blank!'; 
		echo json_encode($response);
		exit;
    }else if(!$firebaseid){
		$response['status'] = FALSE;
		$response['message'] = 'Firebase id is blank!'; 
		echo json_encode($response);
		exit;
    }


		  
		
		 $upw = [];	
	     $upw['imeidevice'] = $deviceid ;
		 $checkuser = $this->c_model->countitem($table,$upw );
		 
		  		
		 
		if( $checkuser != 1 ){
			$response['status'] = FALSE;
			$response['message'] = 'No Record for a such user!'; 
			echo json_encode($response);
			exit;
		}


		
  
			$checkuser = $this->c_model->getSingle($table,$upw ,'*');
				$out['id'] 			= (string) !empty($checkuser['id']) ? trim($checkuser['id']) : '' ;
		   	    $out['uniqueid'] 	= (string) $checkuser['uniqueid'];
		   	    $out['fullname'] 	= (string) $checkuser['fullname'];
		   	    $out['emailid'] 	= (string) $checkuser['emailid'];
		   	    $out['mobileno'] 	= (string) $checkuser['mobileno'];
		   	    $out['altmobile'] 	= (string) $checkuser['altmobile'];
		   	    $out['opcity'] 		= (string) $checkuser['opcity'];
		   	    $out['opcityname'] 	= (string) '';
			   	    if($checkuser['opcity']){
					$ct = $this->c_model->getSingle('pt_city',['id'=>$checkuser['opcity']],'cityname,id');
					$out['opcityname'] 	= (string) (!empty($ct['cityname']) ? trim($ct['cityname']) : '');
			   	    } 
		   	    $out['referalcode'] = (string) $checkuser['referalcode'];
		   	    $out['referer'] 	= (string) $checkuser['referer'];
		   	    $out['image'] 		= (string) ($checkuser['image'] ?  UPLOADS.$checkuser['image'] : '');
		   	    $out['address'] 	= (string) $checkuser['address'];
		   	    $out['completeprofile'] = (string) $checkuser['completeprofile'];

		   	    /* update */
		   	    $update = $this->c_model->saveupdate($table,['firebaseid'=>$firebaseid ] ,null,['id'=>$checkuser['id'] ]);
				
			$response['status'] = TRUE;
			$response['data'] = $out; 
			$response['message'] = 'Profile logged in successfully!!'; 
			echo json_encode($response);
			exit;
		
	
	}
		
}
?>