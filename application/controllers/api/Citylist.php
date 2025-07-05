<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Citylist extends CI_Controller{
	
	 public function __construct() {
		parent::__construct();
	 }
	 
		
	public function index() {
			
			$response = array();
	            $list = array();  
		        $data = array(); 
			
		
	        $select = "CONCAT(a.cityname , ',',  b.statename) as cityname, a.id" ; 
		    $from = ' pt_city as a';

		    $join[0]['table'] = 'pt_state as b';
		    $join[0]['on'] = 'a.stateid = b.id';
		    $join[0]['key'] = 'LEFT'; 

		    $orderby = 'a.cityname ASC';

		    $getdata = $this->c_model->joindata( $select,null, $from, $join, null,$orderby );


			
		    foreach( $getdata as $key=>$value ): 
	
			    $arra = array( 'id'=> (string) $value['id'],
				'cityname'=> (string) capitalize( $value['cityname'] ) );
				 array_push($list,$arra);
				
			endforeach;
            
            if( !empty($list) ){
			$response['status'] = TRUE;
			$response['list'] = $list ;  
		    $response['message'] = "Success!";
			}else{
			
			$response['status'] = FALSE;
		    $response['message'] = "No Record matched!";		
			}
			
		  
		
	    header("Content-Type:application/json");
		echo json_encode( $response );
		
	
	 }
			
}
?>