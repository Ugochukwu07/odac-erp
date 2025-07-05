<?php  defined("BASEPATH") OR exit('No direct access allowed');

class Coupon extends CI_Controller{
	
	public function __construct(){
		 parent::__construct(); 
	}
	
	public function index(){
		 		
	        $response = array();
		    $data = array();
			$post = array();
			$pusharray = array();
			$trippackage = ''; 
			$minamount = '';
			$tablename = 'coupon';
			$request = array();
			$today = date('Y-m-d');	
		  

			if( ($_SERVER['REQUEST_METHOD'] == 'POST') ){
			$request = getParam();
			}else if( ($_SERVER['REQUEST_METHOD'] == 'GET') ){ 
			$request = $this->input->get();
			}  
		    
		  /*******************  check request start ***************************/ 
	        if( empty($request) ){ 
				$response['status'] = false;  
				$response['message'] = 'Bad request'; 
				echo json_encode($response);
				exit;
	        }	
			
			//print_r($request); exit;
			
			$trippackage =  !empty($request['triptype'])?$request['triptype']:false; 
			$coupon_code =  !empty($request['coupon_code'])?$request['coupon_code']:false;
			$withgstamount = !empty($request['withgstamount']) ? $request['withgstamount'] : false; 
			
			if( empty($trippackage) ){ 
				$response['status'] = false;  
				$response['message'] = 'Trip Type Is Blank'; 
				echo json_encode($response);
				exit;
	        }
	        else if( empty($coupon_code) ){ 
				$response['status'] = false;  
				$response['message'] = 'Coupon Code is Blank'; 
				echo json_encode($response);
				exit;
	        }
	        else if( empty($withgstamount) ){ 
				$response['status'] = false;  
				$response['message'] = 'with gst amount is blank'; 
				echo json_encode($response);
				exit;
	        }
			
			  
			$where['trippackage'] = $trippackage;
			$where['status'] = 'yes';
			$where['DATE(validfrom) <='] = $today;
			$where['DATE(validto) >='] = $today;  

            if( $withgstamount ){ 
            	$where['minamount <='] = $withgstamount; 
            }
            
            if( $coupon_code ){ 
            	$where['couponcode'] = $coupon_code; 
            }
            
			$couponarray = $this->c_model->getAll($tablename, null, $where,'*' );
			 
			if( !empty($couponarray) ){  
				foreach($couponarray as $value):
					
					$discount = $value['cpnvalue'];
					if($value['valuetype'] == 'percent'){
						$discount = ($withgstamount*$value['cpnvalue']/100);
						if($discount > $value['maxdiscount']){
							$discount = $value['maxdiscount'];
						}
					}  
 				 $pusharray = array('id'=>(string) $value['id'],
 				 					'trippackage'=>(string)$value['trippackage'],
									'titlename'=>(string)$value['titlename'],
									'couponcode'=>(string)$value['couponcode'],
									'cpnvalue'=>(string)round($value['cpnvalue']),
									'valuetype'=>(string)$value['valuetype'],
									'validfrom'=>(string) date('d-M-Y', strtotime($value['validfrom'])),
									'validto'=>(string)  date('d-M-Y', strtotime($value['validto'])),
									'couponimage'=>(string)( !empty($value['couponimage']) ?  base_url('uploads/').$value['couponimage'] : '') ,
									'minamount'=>(string)round($value['minamount']),
									'maxdiscount'=>(string)round($value['maxdiscount']),
									'totaldiscount'=>(string)round( $discount ),
									'description'=>(string)$value['cpn_description'],
									);
				array_push($data,$pusharray);
				endforeach;
            
			 
			$response['status'] = true; 
			$response['data'] = $data; 
			$response['message'] = count($couponarray).' coupon/s found!';
			}else{
				$response['status'] = false; 
			    $response['message'] = 'no coupon list found!';
				}
			 
			 
			
			 
		  /*******************  check token  end *****************************/ 
		header("Content-Type:application/json");
		echo json_encode($response);
	} 



public function cpnlist(){

 			$response = array();
		    $data = array();
			$post = array();
			$pusharray = array(); 
			$tablename = 'coupon';
			$request = array();
			$today = date('Y-m-d'); 
			
			if( ($_SERVER['REQUEST_METHOD'] == 'POST') ){
			$request = getParam();
			}else if( ($_SERVER['REQUEST_METHOD'] == 'GET') ){ 
			$request = $this->input->get();
			}  
			
			if( !empty(	$request['triptype']) ){
			    $where['trippackage'] = 	trim($request['triptype']);
			}
			
			if( !empty(	$request['withgstamount']) ){
			    $where['minamount <='] = 	trim($request['withgstamount']);
			}
			
			 
			$where['status'] = 'yes';
			$where['DATE(validfrom) <='] = $today;
			$where['DATE(validto) >='] = $today;   
            
			$couponarray = $this->c_model->getAll($tablename, null, $where,'*' );
			//print_r($couponarray);
			 // exit;
			if( !empty($couponarray) ){  
				foreach($couponarray as $value): 
					  
 				 $pusharray = array('id'=>(string) $value['id'],
 				                    'trippackage'=>(string)$value['trippackage'],
									'titlename'=>(string)$value['titlename'],
									'couponcode'=>(string)$value['couponcode'],
									'cpnvalue'=>(string)round($value['cpnvalue']),
									'valuetype'=>(string)$value['valuetype'],
									'validfrom'=>(string)date('d-M-Y',strtotime($value['validfrom'])),
									'validto'=>(string)date('d-M-Y',strtotime($value['validto'])),
									'couponimage'=>(string)( !empty($value['couponimage']) ?  base_url('uploads/').$value['couponimage'] : '') ,
									'minamount'=>(string)round($value['minamount']),
									'maxdiscount'=>(string)round($value['maxdiscount']),
									'totaldiscount'=>(string) ( $value['valuetype'] == 'percent'? $value['maxdiscount'] : $value['cpnvalue']  ), 
									'description'=>(string)$value['cpn_description'],
									);
				array_push($data,$pusharray);
				endforeach;
            
			 
			$response['status'] = true; 
			$response['data'] = $data; 
			$response['message'] = count($couponarray).' coupon/s found!';
			}else{
				$response['status'] = false; 
			    $response['message'] = 'no coupon list found!';
				}
			 
			 
			
			 
		  /*******************  check token  end *****************************/ 
		header("Content-Type:application/json");
		echo json_encode($response);
}	
	
	
}
?>