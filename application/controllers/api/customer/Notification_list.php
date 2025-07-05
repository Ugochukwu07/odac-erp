<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

Class Notification_list extends CI_Controller{
	
	
    public function __construct(){
		parent::__construct();   
		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");
		//header("Content-Type: application/json");
	}
		

	
	public function index(){ 
		
				
		$response 	= [];
		$data 	  	= [];  
		$post 		= getparam();  

		$user_id 	= !empty($post['user_id']) ?  trim($post['user_id']) : ''; 
		$pageno 	= !empty($post['pageno']) ?  trim($post['pageno']) : ''; 
		 	  

		if( !$user_id ){
			$response['status'] = FALSE;
			$response['message'] = 'User id is blank!';
		    echo json_encode($response);
		    exit;
		}else if( !$pageno ){
			$response['status'] = FALSE;
			$response['message'] = 'Page no is blank!';
		    echo json_encode($response);
		    exit;
		}
 


	    
 
	    $tablename = 'pt_notification_list';
	    $wherearray = [];
	    $wherearray['user_id'] = $user_id; 
	    $limit = 10;
	    $start = $limit * ( $pageno - 1 );
	    $orderby = 'DESC';
	    $orderbykey = 'id';
	    $whereor = null;
	    $whereorkey = null; 
	    $like = null;
	    $likekey = null;
	    $getorcount = 'get';
	    $infield = null;
	    $invalue = null;
	    $keys = '*'; 
	    $getdata = $this->c_model->getfilter($tablename,$wherearray,$limit,$start, $orderby, $orderbykey, $whereor,$whereorkey, $like, $likekey, $getorcount, $infield, $invalue, $keys); 
	    
	   // $this->db->last_query();die();
	    
	    if( empty( $getdata ) ){
			$response['status']  = FALSE;
			$response['message'] = "No Records found!";  
			echo json_encode($response);
			exit;
	    } 


	    /* set seen all notifications */
	    $this->c_model->saveupdate($tablename,['is_seen'=>1],null,$wherearray );


	    foreach ($getdata as $key => $value) {
	    	$push = [];
	    	$push['noti_id'] = (string) $value['id'];
	    	$push['title'] = (string) $value['title'];
	    	$push['image_path'] = (string) (!empty($value['image_path'])? UPLOADS.$value['image_path'] : '' ); 
	    	$push['chat_data'] = (string) $value['chat_content']; 
	    	$push['add_date'] = (string) date('M d, Y h:i A',strtotime($value['add_date']));
	    	array_push( $data, $push );
	    }
		 						 
		$response['status']  = TRUE;
		$response['data']  = $data;
	    $response['message'] = "API Accessed Successfully!";  
		echo json_encode($response);
	
	}


	public function remove(){ 
		
				
		$response 	= [];
		$data 	  	= [];  
		$post 		= getparam();  

		$user_id 	= !empty($post['user_id']) ? trim($post['user_id']) : false; 
		$noti_id 	= !empty($post['noti_id']) ? trim($post['noti_id']) : ''; 
		$action 	= !empty($post['action']) ? trim($post['action']) : ''; 

		if( !$user_id ){
			$response['status'] = FALSE;
			$response['message'] = 'User id is blank!';
		    echo json_encode($response);
		    exit;
		}else if( !$action ){
			$response['status'] = FALSE;
			$response['message'] = 'Action is blank!';
		    echo json_encode($response);
		    exit;
		}


		if( $action == 'single'){ 
			if( !$noti_id ){
			$response['status'] = FALSE;
			$response['message'] = 'Notification ID is blank!';
		    echo json_encode($response);
		    exit;
			} 
		}


		$where = [];
		$where['user_id'] = $user_id; 
		if(!empty($noti_id)){
			$where['id'] = $noti_id;
		} 
		$this->c_model->delete('pt_notification_list',$where); 

		$response['status']  = TRUE; 
	    $response['message'] = "Notification Deleted";  
		echo json_encode($response);

	}
		
}
?>