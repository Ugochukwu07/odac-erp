<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Cmsdata extends CI_Controller{
	
	 public function __construct() {
		parent::__construct(); 
	 }
	 
		
	public function index() {
			
			$response = array();
	            $list = array();  
		        $data = array(); 
			
	if( ($_SERVER['REQUEST_METHOD'] == 'POST') ){

		    $post = getparam();

		    if( $post['id'] ){
		     $where['a.id'] = trim($post['id']);	
		    }

		    if( $post['pagetype'] ){
		     $where['a.pagetype'] = trim($post['pagetype']);	
		    }

		    if( $post['pageurl'] ){
		     $where['a.pageurl'] = trim($post['pageurl']);	
		    }

		    if( $post['domainid'] ){
		     $where['a.domainid'] = trim($post['domainid']);	
		    }

			$orderby = null;

		    if( isset($post['catid']) && $post['catid'] ){
		     $where['pt_vehicle_model.catid'] = trim($post['catid']);
		     $select = "a.id, pt_vehicle_model.model,pt_vehicle_model.catid " ;
		     $orderby = 'pt_vehicle_model.model';	
		    }else{
		    	$select = "a.*, pt_vehicle_model.catid, pt_vehicle_model.image,pt_vehicle_model.catid " ;
		    }
			
			
		    $from = ' pt_cms as a';

		    $join[0]['table'] = 'pt_vehicle_model';
		    $join[0]['on'] = 'a.tableid = pt_vehicle_model.id';
		    $join[0]['key'] = 'LEFT'; 
 

		    

		    $getdata = $this->c_model->joindata( $select,$where, $from, $join, null,$orderby );

		 
            
            if( !empty($getdata) ){

			$response['status'] = TRUE;
			if( isset($post['catid']) && $post['catid'] ){
			$response['data'] = $getdata ; 
			}else{ $response['data'] = $getdata[0] ;  } 
		    $response['message'] = "Success!";
			}else{
			
			$response['status'] = FALSE;
		    $response['message'] = "No Record matched!";		
			}
			

}else{

		$response['status'] = FALSE;
		$response['message'] = "Request method is wrong!";		
		}

		
	    header("Content-Type:application/json");
		echo json_encode( $response );
		
	
	 }
			
}
?>