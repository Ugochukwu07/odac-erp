<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Booking extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('slip');
            header("Pragma: no-cache");
            header("Cache-Control: no-cache");
            header("Expires: 0");
            header("Content-Type: application/json");
		}
		
	
	
	public function confirm(){ 
				
				$response = array();
				    $data = array();  
					
					$table = 'booking';
				 
				 $request = getparam();
	 
		
            	if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Bad Request!'; 
            		echo json_encode($response);
            		exit;
            	}
            	
            	
		
            	if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Bad Request!'; 
            		echo json_encode($response);
            		exit;
            	}
            	
            	$booking_table_id = !empty($request['booking_table_id']) ? trim($request['booking_table_id']) : null; 
            	$txn_id = !empty($request['txn_id']) ? trim($request['txn_id']) : null; 
            	
            	if( empty($booking_table_id) ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Booking ID is Blank!'; 
            		echo json_encode($response);
            		exit;
            	} 
            	
            	
            	$where = [];
            	$where['id'] = $booking_table_id;
            	
            	$keys = '*';
            	$getdata = $this->c_model->getSingle('pt_booking', $where , $keys  );
            	
            	if( empty($getdata) ){
                    $response['status'] = FALSE;
                    $response['message'] = 'No Record!'; 
                    echo json_encode($response);
                    exit;
            	}
            	else if( !in_array($getdata['paymode'],['cash','online']) ){
                    $response['status'] = FALSE;
                    $response['message'] = 'Invalid Paymode!'; 
                    echo json_encode($response);
                    exit;
            	}
            	
            // 	else if( $getdata['attemptstatus'] != 'temp' ){
            //         $response['status'] = FALSE;
            //         $response['message'] = 'Booking Already Confirmed!'; 
            //         echo json_encode($response);
            //         exit;
            // 	}
            	
            	$save = [];
            	$save['attemptstatus'] = 'new'; 
            	if( $getdata['paymode'] == 'online' ){
            	   $save['bookingamount'] = $getdata['restamount']; 
            	}
            	
            	$this->c_model->saveupdate('pt_booking', $save, null, $where );
            	
            	
            	//$shootsms = shootsms($getdata,'new');
                //$html = bookingslip($getdata,'mail');
                
                
                $response['status'] = true;
                $response['data'] = ['id'=>$getdata['id'],'bookingid'=>$getdata['bookingid']];
                $response['message'] = 'Successful'; 
                echo json_encode($response);
                exit; 
		
	}
	
	
		public function cancel(){ 
				
				$response = array();
				    $data = array();  
					
					$table = 'booking';
				 
				 $request = getparam();
	 
		
            	if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Bad Request!'; 
            		echo json_encode($response);
            		exit;
            	}
            	
            	 
            	
            	$booking_table_id = !empty($request['booking_table_id']) ? trim($request['booking_table_id']) : null; 
            	$reason = !empty($request['reason']) ? trim($request['reason']) : null; 
            	
            	if( empty($booking_table_id) ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Booking ID is Blank!'; 
            		echo json_encode($response);
            		exit;
            	} 
            	else if( empty($reason) ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Entetr Some Text!'; 
            		echo json_encode($response);
            		exit;
            	} 
            	
            	
            	$where = [];
            	$where['id'] = $booking_table_id;
            	
            	$keys = '*';
            	$getdata = $this->c_model->getSingle('pt_booking', $where , $keys  );
            	
            	if( empty($getdata) ){
                    $response['status'] = FALSE;
                    $response['message'] = 'No Record!'; 
                    echo json_encode($response);
                    exit;
            	}
            	else if( !in_array($getdata['paymode'],['cash','online','']) ){
                    $response['status'] = FALSE;
                    $response['message'] = 'Invalid Paymode!'; 
                    echo json_encode($response);
                    exit;
            	}
            	
            	else if( $getdata['paymode'] != 'cash' ){
                    $response['status'] = FALSE;
                    $response['message'] = 'Only Cash Booking can be cancelled . Please Contact to +919041412141!'; 
                    echo json_encode($response);
                    exit;
            	}
            	
            	$save = [];
            	$save['attemptstatus'] = 'cancel';  
            	$save['message'] = $reason; 
            	
            	$this->c_model->saveupdate('pt_booking', $save, null, $where ); 
                
                $response['status'] = true; 
                $response['message'] = 'Booking Cancelled Successfully'; 
                echo json_encode($response);
                exit; 
		
	}
	
	
	
	
	
	public function list(){ 
				
				$response = array();
				    $data = array();  
					
				   $table = 'booking';
				 
				 $request = getparam();
	 
		
            	if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Bad Request!'; 
            		echo json_encode($response);
            		exit;
            	}
            	
            	$mobileno = !empty($request['mobileno']) ? trim($request['mobileno']) : null;
            	$pageno = !empty($request['pageno']) ? trim($request['pageno']) : null;
            	
            	if( empty($mobileno) ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Mobile No is Blank!'; 
            		echo json_encode($response);
            		exit;
            	} 
            	else if( empty($pageno) ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Page No is Blank!'; 
            		echo json_encode($response);
            		exit;
            	} 
            	 
            	$where = [];
            	$where['a.uniqueid'] = $mobileno;
            	$limit = 10;
            	$start = $pageno > 0 ? ($pageno-1)*$limit : 0; 
            	 
            	
            	$orderby = 'a.id DESC';
        	    $select = "a.id,a.bookingid,a.attemptstatus,a.triptype,a.vehicleno,a.pickupaddress,a.dropaddress,a.pickupcity,a.dropcity,a.modelname,a.restamount,a.pickupdatetime,a.dropdatetime,a.routes,b.image " ;
        	    
        	    $from = ' pt_booking as a'; 
        	    $join[0]['table'] = 'pt_vehicle_model as b';
        	    $join[0]['on'] = 'a.modelid = b.id';
        	    $join[0]['key'] = 'LEFT'; 
        
        
        	    
        
        	    $getdata = $this->c_model->joindata( $select,$where, $from, $join, null,$orderby, $limit,null,null,null,null, $start );  
		    
		    
            	if( empty($getdata) ){
            		$response['status'] = FALSE;
            		$response['message'] = 'No Records!'; 
            		echo json_encode($response);
            		exit;
            	} 
            	
            	 
            	
            	
            	$output = [];
            	
            	foreach( $getdata as $key=> $value ){
            	    $push = [];
            	    $push['id'] = $value['id'];
            	    $push['bookingid'] = $value['bookingid'];
            	    $push['triptype'] = $value['triptype'];
            	    $push['vehicleno'] = $value['vehicleno'];
            	    $push['pickupaddress'] = $value['pickupaddress'];
            	    $push['dropaddress'] = $value['dropaddress'];
            	    $push['pickupcity'] = $value['pickupcity'];
            	    $push['dropcity'] = $value['dropcity'];
            	    $push['modelname'] = $value['modelname'];
            	    $push['totalamount'] = $value['restamount']; 
            	    $push['routes'] = $value['routes']; 
            	    $push['vehicle_img'] = !empty($value['image']) ? base_url('uploads/'.$value['image']) : LOGO; 
            	    $push['pickupdate'] = date('d M Y', strtotime($value['pickupdatetime']));
            	    $push['pickuptime'] = date('h:i A', strtotime($value['pickupdatetime']));
            	    $push['dropdate'] = date('d M Y', strtotime($value['dropdatetime']));
            	    $push['droptime'] = date('h:i A', strtotime($value['dropdatetime']));
            	    $push['attemptstatus'] = $value['attemptstatus'];
            	    array_push( $output, $push ); 
            	    
            	}
            	
            
                $response['status'] = TRUE;
                $response['data'] = $output;
                $response['message'] = 'Success!'; 
                echo json_encode($response);
                exit;    	
		
		
	}
	
	
	public function details(){ 
				
				$response = array();
				    $data = array();  
					
				   $table = 'booking';
				 
				 $request = getparam();
	 
		
            	if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Bad Request!'; 
            		echo json_encode($response);
            		exit;
            	}
            	
            	$booking_table_id = !empty($request['booking_table_id']) ? trim($request['booking_table_id']) : null;
            	
            	if( empty($booking_table_id) ){
            		$response['status'] = FALSE;
            		$response['message'] = 'Booking ID is Blank!'; 
            		echo json_encode($response);
            		exit;
            	} 
            	
            	
            	$where = [];
            	$where['a.id'] = $booking_table_id;  
            	 
            	 
        	    $select = "a.*,b.image " ;
        	    
        	    $from = ' pt_booking as a'; 
        	    $join[0]['table'] = 'pt_vehicle_model as b';
        	    $join[0]['on'] = 'a.modelid = b.id';
        	    $join[0]['key'] = 'LEFT';  
        
        	    $getdata = $this->c_model->joindata( $select,$where, $from, $join  );  
		    
		    
            	if( empty($getdata) ){
            		$response['status'] = FALSE;
            		$response['message'] = 'No Records!'; 
            		echo json_encode($response);
            		exit;
            	} 
            	
            	 
            	
            	
            	$output = [];
            	
            	foreach( $getdata as $key=> $value ){
            	    $push = [];
            	    $push['id'] = $value['id'];
            	    $push['bookingid'] = $value['bookingid'];
            	    $push['domainid'] = (string) $value['domainid']; 
            	    $push['triptype'] = (string) $value['triptype']; 
            	    $push['invoiceno'] = (string) $value['invoiceno']; 
            	    $push['invoicedate'] = (string) $value['invoicedate']; 
            	    $push['uniqueid'] = (string) $value['uniqueid']; 
            	    $push['email'] = (string) $value['email']; 
            	    $push['name'] = (string) $value['name']; 
            	    $push['mobileno'] = (string) $value['mobileno']; 
            	    $push['vehicleno'] = (string) $value['vehicleno']; 
            	    $push['basefare'] = (string) $value['basefare'];
            	    $push['fareperkm'] = (string) $value['fareperkm']; 
            	    $push['estimatedkm'] = (string) $value['estimatedkm']; 
            	    $push['totalkm'] = (string) $value['totalkm']; 
            	    $push['estimatedtime'] = (string) $value['estimatedtime']; 
            	    $push['estimatedfare'] = (string) $value['estimatedfare']; 
            	    $push['drivercharge'] = (string) $value['drivercharge']; 
            	    $push['driverdays'] = (string) $value['driverdays']; 
            	    $push['totaldrivercharge'] = (string) $value['totaldrivercharge']; 
            	    $push['nightcharge'] = (string) $value['nightcharge']; 
            	    $push['totalnights'] = (string) $value['totalnights'];
            	    $push['totalnightcharge'] = (string) $value['totalnightcharge']; 
            	    $push['gstpercent'] = (string) $value['gstpercent']; 
            	    $push['gstapplyon'] = (string) $value['gstapplyon']; 
            	    $push['totalgstcharge'] = (string) $value['totalgstcharge']; 
            	    $push['onlinepercent'] = (string) $value['onlinepercent']; 
            	    $push['onlinecharge'] = (string) $value['onlinecharge']; 
            	    $push['totalamount'] = (string) $value['totalamount']; 
            	    $push['restamount'] = (string) $value['restamount'];  
            	    $push['attemptstatus'] = (string) $value['attemptstatus'];
            	    $push['driverstatus'] = (string) $value['driverstatus']; 
            	    $push['drvmobile'] = (string) $value['drvmobile']; 
            	    $push['drvname'] = (string) $value['drvname']; 
            	    $push['pickupaddress'] = (string) $value['pickupaddress']; 
            	    $push['dropaddress'] = (string) $value['dropaddress']; 
            	    $push['discount'] = (string) $value['offerprice']; 
            	    $push['startcoords'] = (string) $value['startcoords']; 
            	    $push['endcoords'] = (string) $value['endcoords']; 
            	    $push['tollcharge'] = (string) $value['tollcharge']; 
            	    $push['statecharge'] = (string) $value['statecharge'];
            	    $push['driverassign'] = (string) ( $value['driverassign'] != '0000-00-00 00:00:00' ? date('d M Y, h:i A', strtotime($value['driverassign'])) : ''); 
            	    $push['approvaltime'] = (string) ( $value['approvaltime'] != '0000-00-00 00:00:00' ? date('d M Y, h:i A', strtotime($value['approvaltime'])) : '');
            	    $push['paymode'] = (string) $value['paymode']; 
            	    $push['wtcharge'] = (string) $value['wtcharge'];
            	    $push['totalwt'] = (string) $value['totalwt']; 
            	    $push['totalwtcharge'] = (string) $value['totalwtcharge'];
            	    $push['bookingamount'] = (string) $value['bookingamount']; 
            	    $push['pickupcity'] = (string) $value['pickupcity']; 
            	    $push['dropcity'] = (string) $value['dropcity']; 
            	    $push['routes'] = (string) $value['routes']; 
            	    $push['minkm'] = (string) $value['minkm']; 
            	    $push['modelname'] = (string) $value['modelname']; 
            	    $push['othercharge'] = (string) $value['othercharge']; 
            	    $push['grosstotal'] = (string) $value['grosstotal']; 
            	    $push['coupon_code'] = (string) $value['coupon_code']; 
            	    
            	    $push['vehicle_img'] = !empty($value['image']) ? base_url('uploads/'.$value['image']) : LOGO; 
            	    $push['bookingdate'] = date('d M Y', strtotime($value['bookingdatetime']));
            	    $push['bookingtime'] = date('h:i A', strtotime($value['bookingdatetime']));
            	    $push['pickupdate'] = date('d M Y', strtotime($value['pickupdatetime']));
            	    $push['pickuptime'] = date('h:i A', strtotime($value['pickupdatetime']));
            	    $push['dropdate'] = date('d M Y', strtotime($value['dropdatetime']));
            	    $push['droptime'] = date('h:i A', strtotime($value['dropdatetime']));
            	    
            	}
            	
            
                $response['status'] = true;
                $response['data'] = $push;
                $response['message'] = 'Success!'; 
                echo json_encode($response);
                exit;  
		
	} 
	
	
}
?>