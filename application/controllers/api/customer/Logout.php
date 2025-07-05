<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Logout extends CI_Controller{
	
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
        	if(!$mobileno){
        		$response['status'] = FALSE;
        		$response['message'] = 'Mobile number is blank!'; 
        		echo json_encode($response);
        		exit;
            }
    
            $post = [];
            $post['firebaseid'] = '';
            $post['imeidevice'] = ''; 
            $post['loginstatus'] = 'no';
            
            $where = [];
            $where['uniqueid'] = $mobileno;
		   
            $update = $this->c_model->saveupdate( $table, $post, null, $where ) ;
            
            $response['status'] = true;
            $response['message'] = 'Logout Successful'; 
            echo json_encode($response);
            exit;
    
	
	}
    
}?>
	