<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Editbooking extends CI_Controller{
	
 function __construct() {
     parent::__construct();   
     adminlogincheck();
 }	


 public function index() {
	 
	$currentpage = 'editbooking'; 
	$data['posturl'] = adminurl($currentpage.'/savebooking');

	$request = $this->input->get();
 
    $id = !empty($request['id']) ? $request['id'] : '';
    $redirect = !empty($request['redirect']) ? $request['redirect'] : '';
    $action = !empty($request['action']) ? $request['action'] : '';
    
    $getdata = $this->c_model->getSingle('booking',['id'=>$id],'*');
    
    if((float)$getdata['discount_per_day'] < 1 ){
        $getdata['discount_per_day'] = $getdata['offerprice']/$getdata['driverdays'];
    }
 
	 
	
	    $data['title'] =  (  $action == 'close' ? 'Close Booking' : 'Edit Booking Details');  
		$data['id'] = $id; 
		$data['list'] = $getdata;  
		$data['redirect'] = $redirect; 
		$data['action'] = $action;
		$data['is_new_edit'] = false; 
	   
	   if( strtotime( date('Y-m-d',strtotime($getdata['bookingdatetime'])) ) >=  strtotime('2023-11-22') && !empty($getdata['vehicle_price_per_unit'])){
	       $data['is_new_edit'] = true;
	       $data['posturl'] = adminurl($currentpage.'/savebookingNew');
	   }
	   
// 		echo '<pre>';
// 		print_r( $data );

   
	  _view( 'editbooking' , $data );
	  
   }


 public function savebooking()
 {
 	$request = $this->input->post(); 

 	//print_r($request); exit;

 	$id = $request['id'];
 	$redirect = $request['redirect']; 
 	$action = !empty($request['action']) ? $request['action'] : '';
 	$save = [];
 	
 	
 	//get old booking data
 	$getData = !empty($id) ? $this->c_model->getSingle('booking',['id'=>$id],'*') : [];
 	$saveEditLog = [];
 	
    $loginUser = $this->session->userdata('adminloginstatus');  
    $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
    $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
    $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';

     

 	if(!empty($request['name'])){
		$save['name'] = $request['name'];
		$editKey = 'name';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['mobileno'])){
		$save['mobileno'] = $request['mobileno'];
		$editKey = 'mobileno';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	} 

 	if(!empty($request['email'])){
		$save['email'] = $request['email'];
		$editKey = 'email';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	} 

 	if(!empty($request['pickupaddress'])){
		$save['pickupaddress'] = $request['pickupaddress'];
		$editKey = 'pickupaddress';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['dropcity'])){
		$save['dropcity'] = $request['dropcity'];
 	}

 	if(!empty($request['dropaddress'])){
		$save['dropaddress'] = $request['dropaddress'];
		$editKey = 'dropaddress';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['pickupdate']) && !empty($request['pickuptime']) ){
 		//explodeme($request['pickupdate'],'');
 		$pickupdate =  date('Y-m-d',strtotime($request['pickupdate']));
 		$pickuptime =  date('H:i:s',strtotime($request['pickuptime']));
		$save['pickupdatetime'] = $pickupdate.' '.$pickuptime;
		$editKey = 'pickupdatetime';
		if( strtotime($getData[$editKey]) != strtotime($save[$editKey]) ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['dropdate']) && !empty($request['droptime']) ){
 		$dropdate =  date('Y-m-d',strtotime($request['dropdate']));
 		$droptime =  date('H:i:s',strtotime($request['droptime']));
		$save['dropdatetime'] = $dropdate.' '.$droptime;
		$editKey = 'dropdatetime';
		if( strtotime($getData[$editKey]) != strtotime($save[$editKey]) ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}


 	if(!empty($request['driverdays'])){
		$save['driverdays'] = $request['driverdays'];
		$editKey = 'driverdays';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['basefare'])){
		$save['basefare'] = $request['basefare'];
		$editKey = 'basefare';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['estimatedfare'])){
		$save['estimatedfare'] = $request['estimatedfare'];
		$editKey = 'estimatedfare';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['gstpercent'])){
		$save['gstpercent'] = $request['gstpercent'];
 	}

 	if(!empty($request['gstapplyon'])){
		$save['gstapplyon'] = $request['gstapplyon'];
 	}

 	if(!empty($request['totalgstcharge'])){
		$save['totalgstcharge'] = $request['totalgstcharge'];
 	}

 	if(!empty($request['othercharge'])){
		$save['othercharge'] = $request['othercharge'];
 	}

 	if(!empty($request['grosstotal'])){
		$save['grosstotal'] = $request['grosstotal'];
		$editKey = 'grosstotal';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['offerprice'])){
		$save['offerprice'] = $request['offerprice'];
		$editKey = 'offerprice';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['totalamount'])){
		$save['totalamount'] = $request['totalamount'];
		$editKey = 'totalamount';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['bookingamount'])){
		//$save['bookingamount'] = $request['bookingamount'];
		$editKey = 'bookingamount';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}
 	if(isset($request['restamount'])){
		$save['restamount'] = $request['restamount'];
 	}

 	 

 	//$save['driverdays'] = getdays($request['pickupdatetime'],$request['dropdatetime']);
 	
 	//close booking
 	if( $action == 'close' ){
 	   $save['attemptstatus'] = 'complete'; 
 	}
 	
 	//mantain Edit Data
 	if(!empty($saveEditLog)){
 	 $this->db->insert_batch('pt_booking_editing_log', $saveEditLog );
 	 $save['edit_by_mobile'] = $login_by_mobile;
 	 $save['edit_by_name'] = $login_by_name;
 	 $save['edit_verify_status'] = 'edit'; 
 	}
 	
 	
 	$save['edit_date'] = date('Y-m-d H:i:s'); 


 	$where['id'] = $id; 
 	$update = $this->c_model->saveupdate('booking', $save, null, $where );

 	$this->session->set_flashdata('success',"Booking ".(  $action == 'close' ? 'closed' : 'edited')." Successfully!");

 	if($update){
		$keys = ' * ';
		$getdata = $this->c_model->getSingle('booking',['id'=>$id],'*'); 
		
		if( empty($action ) ){
		    $sms = shootsms($getdata,'edit'); 
		}
 	}

     //redirect to related page
 	 if( !empty( $action ) ){
 	     redirect( adminurl('bookingview/?type='.$redirect ) ); 
 	 }else{
 	      redirect( adminurl('details/?id='.md5($id).'&redirect='.$redirect ) );  
 	 } 
 	
 }  
 
 
 
 public function savebookingNew()
 {
 	$request = $this->input->post(); 

 	//print_r($request); exit;

 	$id = $request['id'];
 	$redirect = $request['redirect']; 
 	$action = !empty($request['action']) ? $request['action'] : '';
 	$is_date_edited = !empty($request['is_date_edited']) ? $request['is_date_edited'] : 'no';
 	$is_per_unit_price_edited = 'no';
 	$save = [];
 	$last_activity = '';
 	
 	
 	//get old booking data
 	$getData = !empty($id) ? $this->c_model->getSingle('booking',['id'=>$id],'*') : [];
 	$saveEditLog = [];
 	
    $loginUser = $this->session->userdata('adminloginstatus');  
    $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
    $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
    $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';

     

 	if(!empty($request['name'])){
		$save['name'] = $request['name'];
		$editKey = 'name';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity = 'Name,';
		}
 	}

 	if(!empty($request['mobileno'])){
		$save['mobileno'] = $request['mobileno'];
		$editKey = 'mobileno';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Mobile No,';
		}
 	} 

 	if(!empty($request['email'])){
		$save['email'] = $request['email'];
		$editKey = 'email';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Email,';
		}
 	} 

 	if(!empty($request['pickupaddress'])){
		$save['pickupaddress'] = $request['pickupaddress'];
		$editKey = 'pickupaddress';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Pickup Address,';
		}
 	}

 	if(!empty($request['dropcity'])){
		$save['dropcity'] = $request['dropcity'];
 	}

 	if(!empty($request['dropaddress'])){
		$save['dropaddress'] = $request['dropaddress'];
		$editKey = 'dropaddress';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Drop Address,';
		}
 	}

 	if(!empty($request['pickupdate']) && !empty($request['pickuptime']) ){
 		//explodeme($request['pickupdate'],'');
 		$pickupdate =  date('Y-m-d',strtotime($request['pickupdate']));
 		$pickuptime =  date('H:i:s',strtotime($request['pickuptime']));
		$save['pickupdatetime'] = $pickupdate.' '.$pickuptime;
		$editKey = 'pickupdatetime';
		if( strtotime($getData[$editKey]) != strtotime($save[$editKey]) ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Pickup Date,';
		}
 	}

 	if(!empty($request['dropdate']) && !empty($request['droptime']) ){
 		$dropdate =  date('Y-m-d',strtotime($request['dropdate']));
 		$droptime =  date('H:i:s',strtotime($request['droptime']));
		$save['dropdatetime'] = $dropdate.' '.$droptime;
		$editKey = 'dropdatetime';
		if( strtotime($getData[$editKey]) != strtotime($save[$editKey]) ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Drop Date,'; 
		}
 	} 


 	if(!empty($request['driverdays'])){
		$save['driverdays'] = $request['driverdays'];
		$editKey = 'driverdays';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		}
 	}

 	if(!empty($request['vehicle_price_per_unit'])){
 	    $save['vehicle_price_per_unit'] = $request['vehicle_price_per_unit'];
		$save['basefare'] = round( $request['gstapplyon']/$request['driverdays'] );
		$editKey = 'basefare';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
	        $is_per_unit_price_edited = 'yes';
	        $last_activity .= 'Per Unit Price,';
		}
 	}

 	if(!empty($request['estimatedfare'])){
		$save['estimatedfare'] = $request['estimatedfare'];
		$editKey = 'estimatedfare';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Estimate Price,';
		}
 	}

 	if(!empty($request['gstpercent'])){
		$save['gstpercent'] = $request['gstpercent'];
 	}
 	
 	if(!empty($request['discount_per_day'])){
		$save['discount_per_day'] = $request['discount_per_day'];
 	}

 	if(!empty($request['gstapplyon'])){
		$save['gstapplyon'] = $request['gstapplyon'];
 	}

 	if(!empty($request['totalgstcharge'])){
		$save['totalgstcharge'] = $request['totalgstcharge'];
 	}

 	if(!empty($request['othercharge'])){
		$save['othercharge'] = $request['othercharge'];
 	}

 	if(!empty($request['grosstotal'])){
		$save['grosstotal'] = $request['grosstotal'];
		$editKey = 'grosstotal';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Estimate Price,'; 
		}
 	}

 	if(!empty($request['offerprice'])){
		$save['offerprice'] = $request['offerprice'];
		$editKey = 'offerprice';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Discount,'; 
		}
 	}

 	if(!empty($request['totalamount'])){
		$save['totalamount'] = $request['totalamount'];
		$editKey = 'totalamount';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Total Amt.,'; 
		}
 	}

 	if(!empty($request['bookingamount'])){
		$save['bookingamount'] = $request['bookingamount'];
		$editKey = 'bookingamount';
		if( $getData[$editKey] != $save[$editKey] ){
		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
		    $last_activity .= 'Booking Amt.';  
		}
 	}
 	if(isset($request['restamount'])){
		$save['restamount'] = $request['restamount'];
 	}

 	 

 	//$save['driverdays'] = getdays($request['pickupdatetime'],$request['dropdatetime']);
 	
 	//close booking
 	if( $action == 'close' ){
 	   $save['attemptstatus'] = 'complete'; 
 	   $save['close_date'] = date('Y-m-d H:i:s'); 
 	   $save['closed_by_mobile'] = $login_by_mobile;
 	   $save['closed_by_name'] = $login_by_name;
 	   $save['edit_verify_status'] = 'edit'; 
 	}
 	
 	//mantain Edit Data
 	if(!empty($saveEditLog)){
 	 $this->db->insert_batch('pt_booking_editing_log', $saveEditLog );
 	 $save['edit_by_mobile'] = $login_by_mobile;
 	 $save['edit_by_name'] = $login_by_name;
 	 $save['edit_verify_status'] = 'edit'; 
 	}



        /* calculate extended date system if is_date_edited is yes */
        $ext_days = 0;
     	if( ($is_date_edited == 'yes')  ){
     	    $dropdate =  date('Y-m-d',strtotime($request['dropdate']));
     		$droptime =  date('H:i:s',strtotime($request['droptime'])); 
    		$dropdatetimeNew = $dropdate.' '.$droptime;
    		if( ((int) $request['driverdays'] > (int) $getData['driverdays']) && (date('Y-m-d',strtotime($getData['bookingdatetime'])) != date('Y-m-d') ) ){
         	    $ext_days = (int)$request['driverdays'] - (int) $getData['driverdays'];
         	    if( ($ext_days > 0) ){
                    $save['ext_days'] =  $ext_days ; 
                    $save['total_extend_days'] =  (float)$ext_days + (float)$getData['total_extend_days'] ; 
                    $save['ext_from_date'] = date('Y-m-d H:i:s' , strtotime($getData['dropdatetime'])); 
                    $save['ext_to_date'] = $dropdatetimeNew; 
                    $save['extend_by_name'] = $login_by_name; 
                    $save['extend_by_mobile'] = $login_by_mobile; 
                    $save['ext_apply_on'] = date('Y-m-d H:i:s');
                        /*Added on 27-April-2024 Start Script*/
                        $bkamount = [];
                        $bkamount['booking_id'] = $id;
                        $bkamount['per_vehicle_price'] = $request['vehicle_price_per_unit'];
                        $bkamount['total_days'] = $save['ext_days'];
                        $bkamount['total_amount'] = (float)$save['ext_days'] * (float)$request['vehicle_price_per_unit'];
                        $bkamount['booking_amount'] = 0;
                        $bkamount['rest_amount'] = $bkamount['total_amount'];
                        $bkamount['from_date'] = $save['ext_from_date'];
                        $bkamount['to_date'] = $save['ext_to_date'];
                        $bkamount['add_date'] = date('Y-m-d H:i:s');
                        $bkamount['act_type'] = 'extended';
                        $addBookingAmount = $this->c_model->saveupdate( 'pt_booking_amount', $bkamount ) ;
                        /*Added on 27-April-2024 End Script*/
         	    } 
    		}else if( date('Y-m-d',strtotime($getData['bookingdatetime'])) == date('Y-m-d') ){
    		            /*Added on 27-April-2024 Start Script*/
                            $pickupdate =  date('Y-m-d',strtotime($request['pickupdate']));
                            $pickuptime =  date('H:i:s',strtotime($request['pickuptime'])); 
                            $dropdate =  date('Y-m-d',strtotime($request['dropdate']));
                            $droptime =  date('H:i:s',strtotime($request['droptime']));
                        $bkamount = [];
                        $bkamount['booking_id'] = $id;
                        $bkamount['per_vehicle_price'] = $request['vehicle_price_per_unit'];
                        $bkamount['total_days'] = $request['driverdays'];
                        $bkamount['total_amount'] = $request['totalamount'];
                        $bkamount['booking_amount'] = $request['bookingamount'];
                        $bkamount['rest_amount'] = $request['restamount'];
                        $bkamount['from_date'] = $pickupdate.' '.$pickuptime;
                        $bkamount['to_date'] = $dropdate.' '.$droptime;
                        $addBookingAmount = $this->c_model->saveupdate( 'pt_booking_amount', $bkamount, null, ['booking_id'=>$id] ) ;
                        /*Added on 27-April-2024 End Script*/
    		}
     	    
     	    $this->reserveDateSlots( $getData['id'], $request['pickupdate'] , $request['dropdate'], $getData['modelid'], $getData['vehicleno'] );  
     	}
     	
     	
     	//edit booking amount if perunit amount changed 
     	$checkBookingAmountEntry = $this->c_model->getSingle( 'pt_booking_amount', ['booking_id'=>$id],'id' );
     	if(!empty($checkBookingAmountEntry) && sizeof($checkBookingAmountEntry)==1 ){
                /*Added on 27-April-2024 Start Script*/
                $pickupdate =  date('Y-m-d',strtotime($request['pickupdate']));
                $pickuptime =  date('H:i:s',strtotime($request['pickuptime'])); 
                $dropdate =  date('Y-m-d',strtotime($request['dropdate']));
                $droptime =  date('H:i:s',strtotime($request['droptime']));
                $bkamount = [];
                $bkamount['booking_id'] = $id;
                $bkamount['per_vehicle_price'] = $request['vehicle_price_per_unit'];
                $bkamount['total_days'] = $request['driverdays'];
                $bkamount['total_amount'] = $request['totalamount'];
                $bkamount['booking_amount'] = $request['bookingamount'];
                $bkamount['rest_amount'] = $request['restamount'];
                $bkamount['from_date'] = $pickupdate.' '.$pickuptime;
                $bkamount['to_date'] = $dropdate.' '.$droptime;
                //$addBookingAmount = $this->c_model->saveupdate( 'pt_booking_amount', $bkamount, null, ['booking_id'=>$id] ) ;
                /*Added on 27-April-2024 End Script*/
     	}
     	
     	//refund amount 
     	if( (int)$request['refund_amount'] > 0 ){
		    $save['refund_amount'] = $request['refund_amount'];
    		if( ((float)$getData['bookingamount'] - (float)$request['refund_amount']) > 0 ){
    		//$save['bookingamount'] = (float)$getData['bookingamount'] - (float)$request['refund_amount'];
    		$editKey = 'refund_amount';
        		if( $getData[$editKey] != $save[$editKey] ){
        		    $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>$editKey,'new_value'=>$save[$editKey],'previous_value'=>$getData[$editKey],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
        		    $last_activity .= 'Refund Amt.';
        		} 
    		}
 	    }


    $save['edit_date'] = date('Y-m-d H:i:s'); 
    $save['last_activity'] = $last_activity;

 	$where['id'] = $id; 
    $update = $this->c_model->saveupdate('pt_booking', $save, null, $where ); 

 	$this->session->set_flashdata('success',"Booking ".(  $action == 'close' ? 'closed' : 'edited')." Successfully!");

 	if($update){
		$keys = ' * ';
		$getdata = $this->c_model->getSingle('pt_booking',['id'=>$id],'*');
		
		if( $ext_days > 0 ){
		    $sms = shootsms($getdata,'extend'); 
		}
		
		if( !empty($action) && $action == 'close' ){
		    $sms = shootsms($getdata,'complete'); 
		}else if( empty($action ) ){
		    $sms = shootsms($getdata,'edit'); 
		}
 	}

     //redirect to related page
 	 if( !empty( $action ) ){
 	     redirect( adminurl('bookingview/?type='.$redirect ) ); 
 	 }else{
 	      redirect( adminurl('details/?id='.md5($id).'&redirect='.$redirect ) );  
 	 } 
 	
 }  
 
 
 function reserveDateSlots( $id, $pickupDate, $dropDate, $modelid, $vehicleno ){
     
     $dbpickupdate = date('Y-m-d',strtotime($pickupDate));
     $dbdropdate = date('Y-m-d',strtotime($dropDate));
     
     $vehicleSql = '';
     if(!empty($vehicleno)){
         $vehicleSql = " AND `vehicleno` = '".$vehicleno."' " ;
     }else if( !empty($id)){
         $sloatVehicleno = $this->db->query("select `vehicleno` FROM `pt_dateslots` WHERE `bookingid`= '".$id."' LIMIT 1 ")->row_array(); 
         $vehicleSql = !empty($sloatVehicleno['vehicleno']) ? " AND `vehicleno` = '".$sloatVehicleno['vehicleno']."' " : '' ;
     }
     
     
      $selectSql = "SELECT * FROM `pt_dateslots`  WHERE `dateslot` between '".$dbpickupdate."' AND '".$dbdropdate."' AND `modelid` = '".$modelid."' ".$vehicleSql." AND ( `status`='free' OR  `bookingid`='".$id."' ) ";
      $getDateSlots = $this->db->query( $selectSql )->result_array();
      
      $collectBookedIds = [];
      $collectAssignedIds = '';
      $slotStatus = 'reserve';
          
      if(!empty($getDateSlots)){ 
          foreach( $getDateSlots as $key=>$value ){
              if( $value['bookingid'] == $id ){
                  $collectBookedIds[]= $value['id'];
                  if( $value['id'] == 'book '){
                      $slotStatus = 'book';
                  }
              }
              $collectAssignedIds .= "'".$value['id']."',";
          }
          $collectAssignedIds = rtrim($collectAssignedIds,',');
      } 
       
      //free all slots first
      if(!empty($id)){
        $this->db->query("UPDATE `pt_dateslots` SET bookingid = '', status = 'free'  WHERE `bookingid` = '".$id."' ");
      } 
      
      if(!empty($collectAssignedIds)){ 
        $this->db->query("UPDATE `pt_dateslots` SET bookingid = '".$id."', status = '".$slotStatus."'  WHERE `id` IN(".$collectAssignedIds.")" );
      } 
      
      return true; 
 }
 
 
 function checkExtendedSlots(){
     $post = $this->input->post() ? $this->input->post() : $this->input->get();
     
     $response = [];
     $response['status'] = false;
     $response['message'] = 'Error';
     
     $id = !empty($post['id']) ? $post['id'] : '';
     $dropdate =  !empty($post['dropdate']) ? date('Y-m-d',strtotime($post['dropdate'])) : ''; 
     $fromdate =  !empty($post['fromdate']) ? date('Y-m-d',strtotime($post['fromdate'])) : ''; 
     
     if(!empty($id)){
         $getData = $this->c_model->getSingle('booking',['id'=>$id],'id, vehicleno, modelid, dropdatetime, pickupdatetime ');  

            $startdate = date('Y-m-d',strtotime($getData['dropdatetime'].' +1 day'));  
            $days = getdays($startdate,$dropdate);
            
             if( strtotime($getData['dropdatetime']) < strtotime($post['dropdate']) ){
                 
                $vehicleSql = '';
                if(!empty($getData['vehicleno'])){
                    $vehicleSql = " AND `vehicleno` = '".$getData['vehicleno']."' " ;
                }else if( !empty($id)){
                    $sloatVehicleno = $this->db->query("select `vehicleno` FROM `pt_dateslots` WHERE `bookingid`= '".$id."' LIMIT 1 ")->row_array(); 
                    $vehicleSql = !empty($sloatVehicleno['vehicleno']) ? " AND `vehicleno` = '".$sloatVehicleno['vehicleno']."' " : '' ;
                    //assign old vehicle no
                    $getData['vehicleno'] = !empty($sloatVehicleno['vehicleno']) ? $sloatVehicleno['vehicleno'] : '' ;
                }

                $sql = "SELECT COUNT(*) AS total FROM `pt_dateslots` WHERE `dateslot` between '".$startdate."' AND '".$dropdate."' AND `modelid` = '".$getData['modelid']."' ".$vehicleSql." AND `status`='free'  having total >= ".$days." ";
    
                $fdata = $this->db->query( $sql );
                $countData = $fdata->num_rows();
                if( $countData == 0 ){
                    
                    $response['status'] = false;
                    $response['message'] = 'No Slots Available For This Vehicle No';
                    $response['dropdate'] = date('m/d/Y',strtotime($getData['dropdatetime']));
                    $response['sloturl'] = base_url('private/bookingslots?id='.$getData['vehicleno'].'&from='.date('Y-m-d',strtotime($fromdate.'-15 days')).'&to='. date('Y-m-d',strtotime($dropdate.' + 15 days')).'');
                    echo json_encode($response);
                    exit;
                    
                }
            } 
            
            $response['status'] = true;
            $response['message'] = 'Success';
            echo json_encode($response);
            exit;
              
     } 
 }
 
 
 
 function getDatesFromRange($start, $end, $format = 'Y-m-d') {
    $array = array();
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach($period as $date) { 
        $array[] = $date->format($format); 
    }

    return $array;
}




 	
	protected function takeBookingPartialAmount( $bookingId , $beforeAmount, $amount, $payment_type, $txn_id = null,$totalAmount = null ){
	    
        $loginUser = $this->session->userdata('adminloginstatus');  
        $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
        $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
        $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';
        
        if(empty($loginUser)){
            return false; exit;
        }
        
        $totalBookingAmount = (float)$beforeAmount + (float)$amount;
        
        $save = [];
        $save['booking_id'] = $bookingId;
        $save['add_by'] = $login_by_mobile;
        $save['add_by_id'] = $login_by_id;
        $save['added_on'] = date('Y-m-d H:i:s');
        $save['amount'] = (float)$amount;
        $save['before_amt'] = (float)$beforeAmount;
        $save['after_amt'] = (float)$totalBookingAmount;
        $save['paymode'] = $payment_type;
        if( !empty($txn_id)){
         $save['txn_id'] = $txn_id;   
        }
        
        $is_insert = $this->c_model->saveupdate('pt_payment_log', $save );
        //echo $this->db->last_query(); exit;
        
        $restAmountQuery = '';
        if( !empty($totalAmount) && (float)$totalAmount > 0){
            
            $restAmountQuery = " , restamount = '".( (float)$totalAmount - (float)$totalBookingAmount )."'";
        }
        
         
        $last_activity = ' Amount '.$amount.' Collected'; 
                
        if( !empty($is_insert) ){
        $this->db->query("update pt_booking set edit_verify_status = 'edit', edit_by_name = '".$login_by_name."', edit_by_mobile = '".$login_by_mobile."', `edit_date`='".date('Y-m-d H:i:s')."', `last_activity`='".$last_activity."' , bookingamount = bookingamount +".$amount." ".$restAmountQuery."  where `id` ='".$bookingId."' ");
	      $saveEditLog = [];
                $saveEditLog[] = ['booking_id'=>$bookingId,'edited_field'=>'bookingamount','new_value'=>$totalBookingAmount,'previous_value'=>$beforeAmount,'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
                $this->db->insert_batch('pt_booking_editing_log', $saveEditLog ); 
                return true;
        }else{
           return false; 
        }
        
	}
	
	
	function takepartialpayment(){
	    $post = $this->input->post();
	    $id = !empty($post['id']) ? $post['id'] : '';
	    $amount = !empty($post['amount']) ? (int)$post['amount'] : 0;
	    $paymode = !empty($post['paymode']) ? trim($post['paymode']) : 'cash';
	    
	    if(!empty($id) && ($amount > 0) && $paymode ){
	        $getdata = $this->c_model->getSingle('pt_booking',['id'=>$id],'id, bookingamount,totalamount '); 
	        $beforeAmount = $getdata['bookingamount'];
	        echo $retrun = $this->takeBookingPartialAmount( $id , $beforeAmount, $amount, $paymode, '', $getdata['totalamount'] );  exit;
	    } 
	    
	    echo false;
	    
	}
	
	
	function refundPayment(){
	    $post = $this->input->post();
	    $id = !empty($post['id']) ? $post['id'] : '';
	    $amount = !empty($post['amount']) ? (int)$post['amount'] : 0;
	    $paymode = !empty($post['paymode']) ? trim($post['paymode']) : 'cash';
	    $transaction_id = !empty($post['transaction_id']) ? trim($post['transaction_id']) : '';
	    
        $loginUser = $this->session->userdata('adminloginstatus');  
        $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
        $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
        $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';
	    
	    if(!empty($id) && ($amount > 0) && $paymode && !empty($loginUser) ){
	        
	        $getdata = $this->c_model->getSingle('booking',['id'=>$id],'id, bookingamount,totalamount '); 
	        $beforeAmount = $getdata['bookingamount']; 
	        $totalAmount = $getdata['totalamount']; 
	        
            $totalBookingAmount = (float)$beforeAmount - (float)$amount;
            
            $save = [];
            $save['booking_id'] = $id;
            $save['add_by'] = $login_by_mobile;
            $save['add_by_id'] = $login_by_id;
            $save['added_on'] = date('Y-m-d H:i:s');
            $save['amount'] = $amount;
            $save['before_amt'] = $beforeAmount;
            $save['after_amt'] = $totalBookingAmount;
            $save['paymode'] = 'refund';
            if( !empty($transaction_id)){
            $save['txn_id'] = $transaction_id;   
            }
            
            $this->c_model->saveupdate('pt_payment_log', $save ); 
            
            $restAmountQuery = " , restamount = '".( (float)$totalAmount - (float)$totalBookingAmount )."' , refund_amount ='".$amount."'";
            
            
            $this->db->query("update pt_booking set bookingamount = bookingamount -".$amount." ".$restAmountQuery."  where id='".$id."' ");
                
                $saveEditLog = [];
                $saveEditLog[] = ['booking_id'=>$id,'edited_field'=>'bookingamount','new_value'=>$totalBookingAmount,'previous_value'=>$beforeAmount,'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
                
                if(!empty($saveEditLog)){
                $this->db->insert_batch('pt_booking_editing_log', $saveEditLog );
                $save = [];
                $save['edit_by_mobile'] = $login_by_mobile;
                $save['edit_by_name'] = $login_by_name;
                $save['edit_verify_status'] = 'edit'; 
                $save['edit_date'] = date('Y-m-d H:i:s'); 
                $save['last_activity'] = 'Amount '.$amount.' Refunded'; 
                $where['id'] = $id; 
                $update = $this->c_model->saveupdate('booking', $save, null, $where ); 
                }
	    }
	    
	    echo true;
	    
	}
	
	
	
	function reOpenBooking(){
    
        $loginUser = $this->session->userdata('adminloginstatus');  
        $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
        $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
        $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';


	    $post = $this->input->post();
	    $id = !empty($post['id']) ? $post['id'] : '';
	    if(!empty($id)){
	        $saveEditLog = ['booking_id'=>$id,'edited_field'=>'status','new_value'=>'running','previous_value'=>'completed','edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
	        $this->db->insert('pt_booking_editing_log', $saveEditLog );
	         
            $save = [];
            $save['edit_by_mobile'] = $login_by_mobile;
            $save['edit_by_name'] = $login_by_name;
            $save['edit_verify_status'] = 'edit'; 
            $save['attemptstatus'] = 'approved';
            $save['edit_date'] = date('Y-m-d H:i:s'); 
            $save['last_activity'] = 'Booking Re-Opened'; 
            $where['id'] = $id; 
            $update = $this->c_model->saveupdate('pt_booking', $save, null, $where );
	        echo true;
	    }
	    echo false;
    }
	
	
	
}
?>