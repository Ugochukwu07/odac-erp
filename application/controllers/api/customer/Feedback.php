<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Feedback extends CI_Controller{
	
	 public function __construct() {
		parent::__construct(); 
	 }
	 
		
	public function index() {
	 
	header("Content-Type:application/json"); 


			$response = array(); 
	
	if( ($_SERVER['REQUEST_METHOD'] == 'POST') ){

		    $post = getparam();

		  if(!$post['name']){
			$response['status'] = FALSE;
			$response['message'] = "Please enter fullname!";
			echo json_encode( $response );
			exit;
		  }else if(!$post['email']){
			$response['status'] = FALSE;
			$response['message'] = "Please enter email address!";
			echo json_encode( $response );
			exit;
		  }else if( !filter_var($post['email'],FILTER_VALIDATE_EMAIL )){
			$response['status'] = FALSE;
			$response['message'] = "Please enter valid email address!";
			echo json_encode( $response );
			exit;
		  }else if( !$post['mobileno'] && strlen($post['mobileno']) != 10){
			$response['status'] = FALSE;
			$response['message'] = "Please enter 10 digit mobile number!";
			echo json_encode( $response );
			exit;
		  }else if( !filter_var($post['mobileno'],FILTER_SANITIZE_NUMBER_INT )){
			$response['status'] = FALSE;
			$response['message'] = "Please enter 10 digit mobile number!";
			echo json_encode( $response );
			exit;
		  }else if(!$post['comment']){
			$response['status'] = FALSE;
			$response['message'] = "Please enter Remark!";
			echo json_encode( $response );
			exit;
		  }



		$save['name'] = $post['name'];
		$save['mobile'] = $post['mobileno'];
		$save['emailid'] = $post['email'];
		$save['requesttime'] = date('Y-m-d H:i:s');
		$save['comment'] = $post['comment'];
		$save['viewstatus'] = 'no';
		$save['type'] = 'feedback';

		$insert = $this->c_model->saveupdate('pt_request',$save,$save);

		
		 

		if( $insert ){ 
		$response['status'] = TRUE;  
		$response['message'] = "Feedback Submitted Successfully!";
		}else{

		$response['status'] = FALSE;
		$response['message'] = "Some Error!";		
		}
			

}else{

		$response['status'] = FALSE;
		$response['message'] = "Request method is wrong!";		
		}

		
		echo json_encode( $response );
		
	
	 }
			
}
?>