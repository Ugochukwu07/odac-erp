<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Companydetails extends CI_Controller{
	
	 public function __construct() {
		parent::__construct(); 
	 }
	 
		
	public function index() {
	 
	    header("Content-Type:application/json"); 


	    $response = array();  

		$arr = $this->c_model->getSingle('pt_setting',null,'mapscript,headoffice,companyname,landline,caremobile,personalmobile,careemail,personalemail,propwriter,registration_no,gstinno,whatsupno,placeapi'); 
		$data = $arr;
		if($arr['mapscript']){
			$ex = explode('src=', $arr['mapscript']);
			$ex = $ex[1];
			$ex = explode('"', $ex);
			$ex = $ex[1];
			$data['mapscript'] = $ex;//.'&key='.$arr['placeapi'];
		}

		unset($data['placeapi']);

		 
		$response['status'] = TRUE; 
		$response['data'] = $data;  
		$response['message'] = "Success!"; 
 

		
		echo json_encode( $response );
		
	
	 }
			
}
?>