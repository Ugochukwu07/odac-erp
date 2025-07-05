<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Editbooking_two extends CI_Controller{
	
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
 
	 
	
	    $data['title'] =  (  $action == 'close' ? 'Close Booking' : 'Edit Booking Details');  
		$data['id'] = $id; 
		$data['list'] = $getdata;  
		$data['redirect'] = $redirect; 
		$data['action'] = $action;

   
	  _view( 'editbooking', $data );
	  
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
		$save['bookingamount'] = $request['bookingamount'];
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
 
 
public function editDates(){
    
    
     $post = $this->input->post() ? $this->input->post() : $this->input->get();
     $id = $post['id'];
     $fromdate = $post['fromdate'];
     $pickuptime = $post['pickuptime'];
     $dropdate = $post['dropdate'];
     $droptime = $post['droptime'];
     $days = $post['days'];
     
     $save = [];
     $save['driverdays'] =  $days;
     $save['dropdatetime'] =  date('Y-m-d',strtotime($dropdate)).' '. date('H:i:s',strtotime($droptime));
     
     
     
     $where = [];
     $where['id'] = $id;
     
     //print_r( $save );
     
     $this->c_model->saveupdate('booking',$save,null, $where );
     
     echo true;
     
     
 } 

 
	
}
?>