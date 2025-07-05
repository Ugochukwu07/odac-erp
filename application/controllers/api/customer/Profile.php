<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Profile extends CI_Controller{
	
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
		
		
         

			
	$id = !empty($request['id']) ? trim($request['id']) : false;
	$id = filter_var( $id, FILTER_SANITIZE_NUMBER_INT );
	$fullname = !empty($request['fullname']) ? trim($request['fullname']) : NULL;
	$emailid = !empty($request['emailid']) ? trim($request['emailid']) : '';
	$emailid = !empty($request['mobileno']) ? filter_var( $emailid , FILTER_VALIDATE_EMAIL ) : '';
    $mobileno = !empty($request['mobileno']) ? trim($request['mobileno']) : NULL;
    $mobileno = $mobileno ? filter_var( $mobileno, FILTER_SANITIZE_NUMBER_INT ) : NULL;
    $opcity =  !empty($request['opcity']) ? trim($request['opcity']) : '';
    $opcity = filter_var( $opcity , FILTER_SANITIZE_NUMBER_INT );
    $address = isset($request['address']) ? $request['address'] : '';


    if(!$id){
		$response['status'] = FALSE;
		$response['message'] = 'Id is blank!'; 
		echo json_encode($response);
		exit;
    }else if( !$fullname ) {
		$response['status'] = FALSE;
		$response['message'] = 'Fullname is blank!'; 
		echo json_encode($response);
		exit;
    }else if( !$mobileno || ( strlen($mobileno) != 10 ) ) {
		$response['status'] = FALSE;
		$response['message'] = 'Enter 10 digit mobile number!'; 
		echo json_encode($response);
		exit;
    }else if( !$emailid ) {
		$response['status'] = FALSE;
		$response['message'] = 'Enter a valid eEmail address!'; 
		echo json_encode($response);
		exit;
    }else if( !$opcity ) {
		$response['status'] = FALSE;
		$response['message'] = 'Select city name!'; 
		echo json_encode($response);
		exit;
    }


		  
		
		 $upw = [];	
	     $upw['id'] = $id ;
		 $checkuser = $this->c_model->countitem($table,$upw );
		 
		  		
		 
		if( $checkuser != 1 ){
			$response['status'] = FALSE;
			$response['message'] = 'No Record for a such user!'; 
			echo json_encode($response);
			exit;
		}


		 
		$post['fullname'] = $fullname;
		$post['emailid'] = $emailid;
		$post['mobileno'] = $mobileno;
		$post['opcity'] = $opcity;
		$post['completeprofile'] = 'yes';
		$post['address'] = $address;
		$update = $this->c_model->saveupdate( $table, $post,null,$upw );
		
		if($update){
			$checkuser = $this->c_model->getSingle($table,$upw ,'*');
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
					$out['opcityname'] 	= $ct['cityname'];
			   	    } 
		   	    $out['referalcode'] = (string) $checkuser['referalcode'];
		   	    $out['referer'] 	= (string) $checkuser['referer'];
		   	    $out['image'] 		= (string) ($checkuser['image'] ?  UPLOADS.$checkuser['image'] : '');
		   	    $out['address'] 	= (string) $checkuser['address'];
		   	    $out['completeprofile'] = (string) $checkuser['completeprofile'];
				
				$response['status'] = TRUE;
				$response['data'] = $out; 
			$response['message'] = 'Profile updated successfully!!'; 
			echo json_encode($response);
			exit;
		} 
		     


		$response['status'] = FALSE;
		$response['message'] = 'Some error occurred!'; 
		echo json_encode($response);
		exit;  

	
	}
		
}
?>