<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Tarrif extends CI_Controller{
	
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
		    //print_r( $post );

			$where['a.triptype'] = $post['triptype'];

	        $select = "a.id , a.modelid,  a.basefare, a.fareperkm, a.minkm_day,  b.model, b.image, b.thumbnail, c.vyear,c.seat, c.fueltype " ; 
		    $from = 'pt_fare as a';

		    $join[0]['table'] = 'pt_vehicle_model as b';
		    $join[0]['on'] = 'a.modelid = b.id';
		    $join[0]['key'] = 'INNER'; 

		    $join[1]['table'] = 'pt_con_vehicle as c';
		    $join[1]['on'] = 'a.modelid = c.modelid';
		    $join[1]['key'] = 'INNER'; 

		    $order = $post['orderby'];
		    $orderby = 'b.model '.($order?$order:'ASC');
		    $groupby = 'b.model';
		    $limit = isset($post['limit'])?$post['limit']:100;

		    $getdata = $this->c_model->joindata( $select,$where, $from, $join, $groupby ,$orderby, $limit );


			
		    foreach( $getdata as $key=>$value ): 
	
			    $arra = array( 'id'=> (string) $value['id'],
				'modelname'=> (string)  ( $value['model'] ),
				'fueltype'=> (string) $value['fueltype'],
				'modelyear'=> (string) $value['vyear'],
				'seatsegment'=> (string) $value['seat'],
				'basefare'=> (string) $value['basefare'],
				'fareperkm'=> (string) $value['fareperkm'],
				'minkm_day'=> (string) $value['minkm_day'],
				'image'=> (string) UPLOADS.$value['image'],
				'modelid'=> (string) $value['modelid'],
				 );
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
			

}else{

		$response['status'] = FALSE;
		$response['message'] = "Request method is wrong!";		
		}

		
	    
		echo json_encode( $response );
		
	
	 }
			
}
?>