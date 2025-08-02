<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Createentry extends CI_Controller{
	
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
					$table = 'booking'; 
				 $request = getparam();
	 
		
	if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){
		$response['status'] = FALSE;
		$response['message'] = 'Bad Request!'; 
		echo json_encode($response);
		exit;
	}
		
		
    

			
	$fullname = !empty($request['fullname']) ? trim($request['fullname']) : null;
	$mobileno = !empty($request['mobileno']) ? trim($request['mobileno']) : null;
	$mobileno = filter_var( $mobileno, FILTER_SANITIZE_NUMBER_INT );
	$emailid = !empty($request['emailid']) ? trim($request['emailid']) : null;
	$emailid = $emailid ? filter_var( $emailid, FILTER_VALIDATE_EMAIL ): null;
    $noofpessanger = !empty($request['noofpessanger']) ? trim($request['noofpessanger']) : null; 
    $pickupaddress = !empty($request['pickupaddress']) ? trim($request['pickupaddress']) : null;
    $dropaddress = !empty($request['dropaddress']) ? trim($request['dropaddress']) : null;
    $couponid = !empty($request['couponid']) ? trim($request['couponid']) : null; 
    $stock = !empty($request['stock']) ? trim($request['stock']) : null;
    $domainid = isset($request['domainid']) ? trim($request['domainid']) : 2;
    $uniqueid = isset($request['uniqueid']) && !empty($request['uniqueid']) ? trim($request['uniqueid']) : $mobileno;
    $apptype = !empty($request['apptype']) ? trim($request['apptype']) : 'A';
    $bookedfrom = isset($request['bookedfrom']) ? trim($request['bookedfrom']) : false;
    $offeramount = isset($request['offeramount']) ? trim($request['offeramount']) : false;
    $advamount = isset($request['bookingamount']) ? trim($request['bookingamount']) : false;
    		$paymode = !empty($request['paymode']) ? trim($request['paymode']) : 'online';
		
		// Map frontend paymode values to database values
		if ($paymode === 'advance' || $paymode === 'full') {
			$paymode = 'online';
		} 
    $add_by = !empty($request['add_by']) ? trim($request['add_by']) : '';
    $add_by_name = !empty($request['add_by_name']) ? trim($request['add_by_name']) : '';
    $is_security_deposit = !empty($request['is_security_deposit']) ? trim($request['is_security_deposit']) : 'no';
    $bank_txn_id = !empty($request['bank_txn_id']) ? trim($request['bank_txn_id']) : '';


    if(!$mobileno){
		$response['status'] = FALSE;
		$response['message'] = 'Mobile number is blank!'; 
		echo json_encode($response);
		exit;
    }else if( strlen($mobileno) !== 10 ) {
		$response['status'] = FALSE;
		$response['message'] = 'Please enter 10 digit mobile number!'; 
		echo json_encode($response);
		exit;
    }else if( !$fullname ) {
		$response['status'] = FALSE;
		$response['message'] = 'Please enter fullname!'; 
		echo json_encode($response);
		exit;
    }else if( !$emailid ) {
		$response['status'] = FALSE;
		$response['message'] = 'Please enter valid email address!'; 
		echo json_encode($response);
		exit;
    }else if( !$noofpessanger ) {
		$response['status'] = FALSE;
		$response['message'] = 'Please enter No of passengers!'; 
		echo json_encode($response);
		exit;
    }else if( !$pickupaddress ) {
		$response['status'] = FALSE;
		$response['message'] = 'Please enter pickup address!'; 
		echo json_encode($response);
		exit;
    }else if( !$dropaddress ) {
		$response['status'] = FALSE;
		$response['message'] = 'Please enter drop address!'; 
		echo json_encode($response);
		exit;
    }else if( !$stock ) {
		$response['status'] = FALSE;
		$response['message'] = 'Please enter stock value!'; 
		echo json_encode($response);
		exit;
    }else if( !$uniqueid ) {
		$response['status'] = FALSE;
		$response['message'] = 'Please enter uniqueid!'; 
		echo json_encode($response);
		exit;
    }
    
    // Validate payment mode for both admin and web bookings
    // Trim and convert to lowercase for case-insensitive comparison
    $paymode = strtolower(trim($paymode));
    
    // Log the received values for debugging
    log_message('error', 'Payment mode validation - Received paymode: "' . $paymode . '", apptype: ' . $apptype . ', bookedfrom: ' . $bookedfrom . ', RAZOR_PAY_ENABLE_DISABLE: ' . RAZOR_PAY_ENABLE_DISABLE);
    
    // Handle server-specific payment mode overrides
    if ($bookedfrom == 'directweb' && RAZOR_PAY_ENABLE_DISABLE == 'disable') {
        $paymode = 'cash';
        log_message('error', 'Payment mode forced to cash due to RAZOR_PAY_ENABLE_DISABLE = disable');
    }
    
    // Additional server-specific handling for edge cases
    if (empty($paymode) || $paymode === 'null' || $paymode === 'undefined') {
        $paymode = 'online'; // Default to online if no valid payment mode
        log_message('error', 'Payment mode was empty/null, defaulting to online');
    }
    
    if( !in_array($paymode,['cash','online']) ){
        // Log detailed information for debugging
        log_message('error', 'Payment mode validation failed. Final paymode: "' . $paymode . '", Valid modes: cash, online');
        log_message('error', 'Request details - apptype: ' . $apptype . ', bookedfrom: ' . $bookedfrom . ', RAZOR_PAY_ENABLE_DISABLE: ' . RAZOR_PAY_ENABLE_DISABLE);
        
        $response['status'] = FALSE;
		$response['message'] = 'Please enter valid payment mode !'; 
		echo json_encode($response);
		exit;
    }


	/*explode stock value start here*/
		 $stwhere['id'] = $stock;
         $fetchst = $this->c_model->getSingle('pt_urlsortner', $stwhere ,'id,payload'); 
			if( empty($fetchst) ) {
			$response['status'] = FALSE;
			$response['message'] = 'Session completed, please create new booking!'; 
			echo json_encode($response);
			exit;
			}

	     $req = base64_decode($fetchst['payload']);
         $req = json_decode($req,true); 
        // print_r($req);
         $discount = 0; $coupon_code = '';
	/*explode stock value end here*/
	if($couponid && empty($offeramount)){
	$cpnwhere['trippackage'] = $req['triptype'];
	$cpnwhere['id'] = $couponid; 
	$cpnwhere['status'] = 'yes';
	$cpnwhere['DATE(validfrom) <='] = date('Y-m-d');
	$cpnwhere['DATE(validto) >='] = date('Y-m-d'); 
	$cpnwhere['minamount <='] = $req['withgstamount'];  

	$cpn_arr = $this->c_model->getSingle('pt_coupon',$cpnwhere ,'*'); 

				if( $cpn_arr ){
					$discount = $cpn_arr['maxdiscount']?$cpn_arr['maxdiscount']:$cpn_arr['cpnvalue'];
					if($cpn_arr['valuetype'] == 'percent'){
						$discount = ($req['withgstamount']*$cpn_arr['cpnvalue']/100);
						if($discount > $cpn_arr['maxdiscount']){
							$discount = $cpn_arr['maxdiscount'];
							$coupon_code = $cpn_arr['couponcode'];
						}
					}

				}	
	}


            $security_amount =  $is_security_deposit == 'yes' ? (float)$req['secu_amount'] : 0;

			$attemptstatus = 'temp';
			$bookingamount = 0;  
			if(!empty($bookedfrom) && ($bookedfrom=='admin')){
				$discount = $offeramount > 0 ? $offeramount : $discount ;
				$restamount = $is_security_deposit == 'yes' ? ((float)$req['secu_amount'] + (float)$req['withgstamount'] - (float)$discount) : ((float)$req['withgstamount'] - (float)$discount);
				$onlinecharge = 0;
				$attemptstatus = 'new';
				$bookingamount = $advamount;
			}else{
			$restamount = $is_security_deposit == 'yes' ? ((float)$req['secu_amount'] + (float)$req['withgstamount'] - (float)$discount) : ((float)$req['withgstamount'] - (float)$discount);
			$onlinecharge = (int)($restamount * ONLINECHARGE /100);
			}
			
			 
			 /**forcly added on 22-Oct-2023 *****/
			  if( $bookedfrom == 'directweb' && RAZOR_PAY_ENABLE_DISABLE == 'disable' ){
			      $attemptstatus = 'new';
			      $bookingamount = 0;
			  }



		    $modelname = ci()->c_model->getSingle('pt_vehicle_model',['id'=>$req['modelid'] ],'model');
		    
		    //added on 26-Nov-2023
		    $principalAmount = round( calculatePrincipal( $req['withgstamount'], $req['gst'] ) );
		    $getGSTAmount = round( $req['withgstamount'] - $principalAmount );

		    $orderid = 'ODAC'.date('YmdHis').rand(10,99); 
			$post['domainid'] = $domainid;
			$post['bookingid'] = $orderid; 
			$post['triptype'] = $req['triptype']; 
			$post['invoiceno'] = '';
			$post['invoicedate'] = date('Y-m-d H:i:s');
			$post['uniqueid'] = $uniqueid; 
			$post['stock'] = $stock;
			$post['email'] = $emailid;
			$post['name'] = $fullname;
			$post['mobileno'] = $mobileno;
			$post['modelid'] = $req['modelid'];
			$post['vehicleno'] = '';
			$post['basefare'] = $req['basefare'];
			$post['fareperkm'] = $req['fareperkm'];
			$post['estimatedkm'] = $req['googlekm'];
			$post['totalkm'] = $req['estkm'];
			$post['minkm'] = isset($req['minkm']) ? $req['minkm'] : '0';
			$post['estimatedtime'] = $req['esttime'];
			//$post['estimatedfare'] = $req['est_fare'];
			$post['estimatedfare'] = $principalAmount;
			$post['drivercharge'] = $req['drivercharge'];
			$post['driverdays'] = $req['days'];
			$post['ext_days'] = '0';
			$post['ext_from_date'] = date('Y-m-d H:i:s');
			$post['ext_to_date'] = date('Y-m-d H:i:s');
			$post['totaldrivercharge'] = '0';
			$post['nightcharge'] = $req['nightcharge'];
			$post['totalnights'] = '0';
			$post['totalnightcharge'] = '0';
			$post['gstpercent'] = $req['gst'];
			$post['gstapplyon'] = $principalAmount;
			$post['totalgstcharge'] = $getGSTAmount;
			$post['othercharge'] = isset($req['othercharge']) ? $req['othercharge'] : '0';
			$post['onlinepercent'] = ONLINECHARGE;
			$post['onlinecharge'] = $onlinecharge;
			$post['totalamount'] = twoDecimal( (float)$req['withgstamount']-(float)$discount );
			$post['grosstotal'] = $req['withgstamount'];
			$post['vehicle_price_per_unit'] = $req['vehicle_price_per_unit'];
			$post['restamount'] = ($restamount - $bookingamount);
			$post['bookingdatetime'] = date('Y-m-d H:i:s');
			$post['pickupdatetime'] = date('Y-m-d H:i:s',strtotime($req['pickupdatetime']));
			$post['dropdatetime'] = date('Y-m-d H:i:s',strtotime($req['dropdatetime']));
			$post['attemptstatus'] = $attemptstatus;
			$post['driverstatus'] = '';
			$post['dvrtableid'] = '';
			$post['drvmobile'] = '';
			$post['drvname'] = '';
			$post['pickupaddress'] = $pickupaddress;
			$post['dropaddress'] = $dropaddress;
			$post['offerprice'] = $discount;
			$post['discount_per_day'] = twoDecimal( (float)$discount/(float)$req['days'] );
			$post['message'] = '';
			$post['cityid'] = $req['fromcity'];
			$post['faretblid'] = $req['id'];
			$post['startcoords'] = '0';
			$post['endcoords'] = '0';
			$post['tollcharge'] = '0';
			$post['statecharge'] = '0';
			$post['apptype'] = strtoupper($apptype);
			$post['driverassign'] = NULL;
			$post['approvaltime'] = date('Y-m-d H:i:s');
			$post['paymode'] = $paymode;
			$post['wtcharge'] = '0';
			$post['totalwt'] = '0';
			$post['totalwtcharge'] = 0;
			$post['bookingamount'] = $bookingamount;
			$post['pickupcity'] = $req['source'];
			$post['dropcity'] = $req['destination'];
			if($req['route']){
				$post['routes'] = json_encode($req['route']);
			} else {
				$post['routes'] = '0';
			}
			$post['modelname'] = !empty($modelname['model'])?$modelname['model']:'';
					$post['add_by'] = $add_by;
		$post['add_by_name'] = $add_by_name;
			$post['coupon_code'] = $coupon_code;
			$post['security_amount'] = $security_amount;
			$post['bank_txn_id'] = $bank_txn_id;
			$post['crontab'] = 0;
					$post['edit_verify_status'] = '';
		$post['edit_by_mobile'] = '';
		$post['edit_by_name'] = '';
		$post['extend_by_name'] = '';
		$post['extend_by_mobile'] = '';
		$post['ext_apply_on'] = NULL;
		$post['total_extend_days'] = '0';
		$post['refund_amount'] = '0';
		$post['closed_by_name'] = '';
		$post['closed_by_mobile'] = '';
		$post['force_discount'] = '0';
		$post['verify_status'] = '';
		$post['close_date'] = NULL;
		$post['last_activity'] = date('Y-m-d H:i:s'); 
		$post['edit_date'] = date('Y-m-d H:i:s');
		$post['invoice_url'] = '';
		// $post['final_invoice_url'] = '';
		   

		   $update = $this->c_model->saveupdate( $table, $post ) ;

		   if($update){  
		        
		    /*Added on 27-April-2024 Start Script*/
		    $bkamount = [];
		    $bkamount['booking_id'] = $update;
		    $bkamount['per_vehicle_price'] = $post['vehicle_price_per_unit'];
		    $bkamount['total_days'] = $post['driverdays'];
		    $bkamount['total_amount'] = $post['totalamount'];
		    $bkamount['booking_amount'] = $post['bookingamount'];
		    $bkamount['rest_amount'] = $post['restamount'];
		    $bkamount['from_date'] = $post['pickupdatetime'];
		    $bkamount['to_date'] = $post['dropdatetime'];
		    $bkamount['add_date'] = date('Y-m-d H:i:s');
		    $bkamount['act_type'] = 'original';
		    $addBookingAmount = $this->c_model->saveupdate( 'pt_booking_amount', $bkamount ) ;
		    /*Added on 27-April-2024 End Script*/

		   	/*reserve vehicle */
		   	$reserv = [];
		   	$reserv['id'] = $update;
		   	$reserv['startdate'] = $req['pickupdatetime'];
		   	$reserv['enddate'] = $req['dropdatetime'];
		   	$reserv['modelid'] = $req['modelid'];
		   	$reserv['driverdays'] = $req['days'];
		   	$resStatus = $this->reserveVehicle($reserv);
			/*delete old records*/	 
			$delwhere['id'] = $stock; 
			$cleanrecords = $this->c_model->delete('pt_urlsortner',$delwhere); 

			/*save admin advance payment*/
			if(($bookingamount > 0) && ( $bookedfrom == 'admin' ) ){
				$this->adminPayment($bookingamount, $update, $add_by, 'advance' );
			}
			
			
			if( $bookedfrom == 'directweb' ){
			    $sms = shootsms($post,'new');
			}else if( $bookedfrom != 'admin' ){ 
    			$sms = shootsms($post,'temp');
			}else if( $bookedfrom == 'admin' ){
			    $sms = shootsms($post,'new');
			}
			
			
			/*generate razorpay order ID*/
			$payOrderId = ''; 
			if( $bookedfrom != 'admin' ){
			    if( RAZOR_PAY_ENABLE_DISABLE == 'enable' ){
			       // $advamount = 1;//for test
                    $razorData = $this->createRazorpayOrder( $advamount, 'INR', $orderid );
                    $payOrderId = !empty($razorData['id']) ? $razorData['id'] : '';   
			    } 
			} 
			
			 

		   	$response['status'] = TRUE;
		   	$response['data'] = ['id'=>$update,'restamount'=>$restamount,'onlinecharge'=>$onlinecharge,'orderid'=>$orderid,'gateway_amount'=> $advamount,'name'=> $fullname ,'email'=> $emailid ,'mobile'=> $mobileno,'payid'=>$payOrderId ];
			$response['message'] = 'Booking created successfully!'; 
			echo json_encode($response);
			exit; 
		   } 
	
	}
	
	
	function createRazorpayOrder( $amount, $currency = 'INR' ,  $receipt = null, $partial_payment = null, $first_payment_min_amount = null ) {
    // Your Razorpay API Key and Secret
    $api_key = RAZOR_PAY_KEY_ID;
    $api_secret = RAZOR_PAY_SECRET_KEY;

    // API endpoint
    $url = "https://api.razorpay.com/v1/orders";

    // Request data
    $data = array(
        "amount" => $amount,
        "currency" => $currency 
    );

    // Convert data to JSON
    $data_json = json_encode($data);

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$api_secret");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Return the response
    return $response;
}





	function reserveVehicle($dataArray=null){ 

		$bookingTableId = $dataArray['id'];
		$startdate = date('Y-m-d',strtotime($dataArray['startdate']));
		$enddate = date('Y-m-d',strtotime($dataArray['enddate']));
		$days = $dataArray['driverdays'];

		$sql = "SELECT COUNT(*) AS totaldays,vehicleno FROM `pt_dateslots` WHERE `dateslot` >= '".$startdate."'  and `dateslot` <= '".$enddate."' AND `modelid` = '".$dataArray['modelid']."' AND `status`='free' AND `vehicleno` IN( SELECT DISTINCT vnumber FROM pt_con_vehicle WHERE status='yes' and `modelid` = '".$dataArray['modelid']."' ) GROUP BY vehicleno HAVING totaldays >= ".$days." LIMIT 1 ";
		$fsdata = $this->db->query( $sql );
		$fdata = $fsdata->row_array();
	 
		if(!empty($fdata)){ 
			$where['vehicleno'] = $fdata['vehicleno'];
			$where['status'] = 'free';
			$where['modelid'] = $dataArray['modelid'];
			$where['dateslot >='] = $startdate;
			$where['dateslot <='] = $enddate; 
			$save = [];
			$save['status'] = 'reserve';
			$save['bookingid'] = $bookingTableId;
			$this->c_model->saveupdate('pt_dateslots',$save,null,$where);
		}
        return true;

	} 


protected  function adminPayment($amount=null,$book_id=null,$add_by=null,$paymode=null){
    $loginuserid = ci()->c_model->getSingle('pt_roll_team_user',['mobile'=>$add_by ],'id,mobile');
	$save = [];
	$save['booking_id'] = $book_id;
	$save['added_on'] = date('Y-m-d H:i:s');
	$save['add_by'] = $add_by;
	$save['add_by_id'] = !empty($loginuserid) ? $loginuserid['id'] : 0;
	$save['amount'] = $amount;
	$save['paymode'] = $paymode; 
	$save['before_amt'] = 0; 
	$save['after_amt'] = $amount; 
	$this->c_model->saveupdate('pt_payment_log', $save );

}
 
		
}
?>