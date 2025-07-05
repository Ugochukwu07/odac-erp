<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Cmsdata extends CI_Controller{
	
	 public function __construct() {
		parent::__construct(); 
		header("Content-Type:application/json");
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

					$data = [];
				  foreach ($getdata as $key => $value) {
				  	$arr = [];
				  	$arr['id'] = $value['id'];
				  	$arr['metatitle'] = $value['metatitle'];
				  	$arr['metadescription'] = $value['metadescription'];
				  	$arr['metakeyword'] = $value['metakeyword'];
				  	$arr['titleorheading'] = $value['titleorheading'];
				  	$arr['summary'] = $value['summary'];
				  	$arr['content'] = ($value['content']);
				  	$arr['pagetype'] = $value['pagetype'];
				  	$arr['subject'] = $value['subject'];
				  	$arr['tableid'] = $value['tableid'];
				  	$arr['cityid'] = $value['cityid'];
				  	$arr['oldprice'] = $value['oldprice'];
				  	$arr['newprice'] = $value['newprice'];
				  	$arr['cabname'] = $value['cabname'];
				  	$arr['add_datetime'] = $value['add_datetime'];
				  	$arr['status'] = $value['status'];
				  	$arr['pageurl'] = $value['pageurl'];
				  	$arr['image'] = $value['image'];
				  	$arr['domainid'] = $value['domainid'];
				  	$arr['catid'] = $value['catid'];
				  	array_push($data, $arr);
				  }


			
			if( isset($post['catid']) && $post['catid'] ){
			$response['status'] = TRUE;
			$response['data'] = ($data) ; 
			}else{ $response['data'] = ($data[0]) ;  } 
			$response['status'] = TRUE;
		    $response['message'] = "Success!";
			}else{
			
			$response['status'] = FALSE;
		    $response['message'] = "No Record matched!";		
			}
			

}else{

		$response['status'] = FALSE;
		$response['message'] = "Request method is wrong!";		
		}

		
		echo json_encode( $response ); 
	
	}
	 
	 
	 
	 
	 	public function other() {
			
			$response = array();
	            $list = array();  
		        $data = array(); 
			
        	if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){
                    $response['status'] = FALSE;
                    $response['message'] = "Request method is wrong!"; 
                    echo json_encode( $response ); exit;
        	}
        
        		    $post = getparam(); 
        		    
        		    if(empty($post['pageurl'])){
                        $response['status'] = FALSE;
                        $response['message'] = "page url is wrong!";   
                        echo json_encode( $response ); exit;
        		    } 
        		    else if(!empty($post['pageurl']) && !in_array( $post['pageurl'],['privacy_policy_m','about_us_m','cancellation_refund_policy_m','terms_and_conditions_m','disclaimer_policy_m']) ){
                        $response['status'] = FALSE;
                        $response['message'] = "page url is wrong!";  
                        echo json_encode( $response ); exit;
        		    } 
        		    
        		     
        		     $where = [];
        		     $where['domainid'] = 2;
        
        		    if( $post['pageurl'] == 'privacy_policy_m' ){
        		     $where['pageurl'] = 'privacy-policy';	
        		    }
        		    else if( $post['pageurl'] == 'about_us_m' ){
        		     $where['pageurl'] = 'about-us';	
        		    }
        		    else if( $post['pageurl'] == 'cancellation_refund_policy_m' ){
        		     $where['pageurl'] = 'cancellation-refund-policy';	
        		    }
        		    else if( $post['pageurl'] == 'terms_and_conditions_m' ){
        		     $where['pageurl'] = 'terms-and-conditions';	
        		    }
        		    else if( $post['pageurl'] == 'disclaimer_policy_m' ){
        		     $where['pageurl'] = 'disclaimer-policy';	
        		    }
        		    
        		    
        		    $getdata = $this->c_model->getSingle('pt_cms',$where );
        		    
        		    if(empty($getdata)){
        		        $response['status'] = FALSE;
                        $response['message'] = "No Record Found!";  
                        echo json_encode( $response ); exit;
        		    }
        		    
        		    $output = [];
        		    $output['title'] = $getdata['titleorheading'];
        		    $output['content'] = $getdata['content'];
        		    
        		    
                    $response['status'] = true;
                    $response['data'] = $output;
                    $response['message'] = "Success!";  
                    echo json_encode( $response ); exit;
        		    
        		    
        	
	 	    
	 	}
	
			
}
?>