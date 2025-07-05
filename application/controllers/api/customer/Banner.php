<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Banner extends CI_Controller{
	
	 public function __construct() {
		parent::__construct(); 
	 }
	 
		
	public function index() {
	 
	   header("Content-Type:application/json"); 


	    $response = []; 
	    $data = [];  

	    $where['usertype'] = 'mobile';
	    $where['documenttype'] = 'BN';
	    $where['status'] = 'yes';
	    $where['tableid'] = '2';

		$resp = $this->c_model->getAll('pt_uploads',null,$where,'id,documentorimage'); 
	 
		if(empty($resp)){
			$response['status'] = FALSE;   
		    $response['message'] = "No Records!";
		}else{
			foreach ($resp as $key => $value) { 
				$arr['image'] = UPLOADS.''.$value['documentorimage'];
				array_push($data, $arr);
			}
		$response['status'] = TRUE; 
		$response['data'] = $data;  
		$response['message'] = "Success!"; 
		
	    }

	 echo json_encode( $response ); 
		}
			
}
?>