<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Assignvehicle extends CI_Controller{
	
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
     }	


  public function index() {
	 
	$currentpage = 'assignvehicle'; 
	$data['posturl'] = adminurl($currentpage.'/savedvr');

	$request = $this->input->get();
 
    $id = $request['id'];
    $redirect = $request['redirect'];;

    $keys = 'id, modelid, triptype,pickupdatetime,dropdatetime,vehicleno, driverdays';
    $getdata = $this->c_model->getSingle('booking',['id'=>$id],'*');
 
	 
	
	    $data['title'] = ( !empty($getdata['vehicleno']) ? 'Update' : 'Assign') .' Vehicle No. '; 
	    $data['triptype'] = $getdata['triptype'];  
		$data['id'] = $id; 
		$data['vehicleno'] = strtoupper($getdata['vehicleno']);
		$data['driverstatus'] = $getdata['driverstatus'];
		$data['dvrtableid'] = $getdata['dvrtableid'];
		$data['drvmobile'] = $getdata['drvmobile']; 
		$data['drvname'] = $getdata['drvname']; 
		$data['redirect'] = $redirect;

		$check['modelid'] = $getdata['modelid'];
		$check['pickupdatetime'] = $getdata['pickupdatetime'];
		$check['dropdatetime'] = $getdata['dropdatetime'];
		$check['days'] 		= $getdata['driverdays'];
		$check['id'] = $getdata['id'];
		$vehiclelist = $this->checkavailibility_two($check);
		//print_r( $vehiclelist ); exit;
		$data['vehiclelist'] = $vehiclelist; 	 

   
	  _view( 'assignvehicle', $data );
	  
   }


 public function savedvr()
 {
     
    $loginUser = $this->session->userdata('adminloginstatus');  
    $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
    $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
    $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';

 	$request = $this->input->post(); 

 	$id = $request['id'];
 	$redirect = $request['redirect'];
 	$triptype = $request['triptype'];
 	$vehicleno = !empty($request['vehicleno'])?$request['vehicleno']:'';
 	
 	if(empty($vehicleno)){
 	    	$this->session->set_flashdata('error',"Please select Vehicle No!");  
 	        redirect( adminurl('bookingview/?type='.$redirect ) ); exit;
 	}
 	
 	//get old vehicle no
 	$keys = 'id, modelid, triptype,pickupdatetime,dropdatetime,vehicleno, driverdays';
    $getOlddata = $this->c_model->getSingle('booking',['id'=>$id], $keys ); 
    
    /*Assign Vehicle And Verify  */ 
		   	$reserv = [];
		   	$reserv['id'] = $id;
		   	$reserv['startdate'] = $getOlddata['pickupdatetime'];
		   	$reserv['enddate'] = $getOlddata['dropdatetime'];
		   	$reserv['modelid'] = $getOlddata['modelid'];
		   	$reserv['old_vehicleno'] = $getOlddata['vehicleno'];
		   	$reserv['vehicleno'] = $vehicleno;
		   	$resStatus = $this->reserveVehicle($reserv); 
		   	if(empty($resStatus)){
		   	    $this->session->set_flashdata('error',"Please select Another Vehicle No!");  
 	            redirect( adminurl('bookingview/?type='.$redirect ) ); exit;
		   	}
	/*Assign Vehicle And Verify  */ 
			
			
	        
        
 	$save = [];
 	$save['drvname'] = isset($request['drvname'])?$request['drvname']:'';
 	$save['dvrtableid'] = isset($request['dvrtableid'])?$request['dvrtableid']:'';
 	$save['drvmobile'] = isset($request['drvmobile'])?$request['drvmobile']:'';
 	$save['vehicleno'] = isset($request['vehicleno'])?$request['vehicleno']:'';
 	$save['driverassign'] = date('Y-m-d H:i:s'); 
 	$save['approvaltime'] = date('Y-m-d H:i:s');
 	$save['attemptstatus'] = 'approved';
 	$save['driverstatus'] = 'accept'; 
    $save['edit_by_mobile'] = $login_by_mobile;
    $save['edit_by_name'] = $login_by_name;
    $save['edit_verify_status'] = 'edit'; 
            
 	$where['id'] = $id; 
 	
 	$update = $this->c_model->saveupdate('booking', $save, null, $where ); 
 	
    /*maintain vehicle assign log*/
    $saveEditLog = ['booking_id'=>$id,'edited_field'=>'assignvehicle','new_value'=>$vehicleno,'previous_value'=>$getOlddata['vehicleno'],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    $this->db->insert('pt_booking_editing_log', $saveEditLog );


 	$this->session->set_flashdata('success',"Vehicle Assigned Successfully!");

 	if($update){
		$keys = ' * ';
		$getdata = $this->c_model->getSingle('booking',['id'=>$id],'*');  
		$sms = shootsms($getdata,'assign');  
 	}

 	redirect( adminurl('bookingview/?type='.$redirect ) );  
 	
 }  


public function checkavailibility_two($data){ 

$startdate = date('Y-m-d',strtotime($data['pickupdatetime']));
$enddate = date('Y-m-d',strtotime($data['dropdatetime']));

$sql = "SELECT COUNT(*) AS `totaldays`,`vehicleno` as `vnumber` FROM `pt_dateslots` WHERE `dateslot` between '".$startdate."' and '".$enddate."' AND `modelid` = '".$data['modelid']."' AND ((`status`='free' ) OR (`status`='book' AND bookingid='".$data['id']."') OR (`status`='reserve' AND bookingid='".$data['id']."') ) AND `vehicleno` IN( SELECT DISTINCT vnumber FROM pt_con_vehicle WHERE status='yes' and `modelid` = '".$data['modelid']."' ) GROUP BY `vehicleno` HAVING totaldays >= ".$data['days']." "; 
$fdata = $this->db->query( $sql );
$fdata = $fdata->result_array();
///echo $this->db->last_query(); exit;
return  $fdata;

}	


   
 

function reserveVehicle($dataArray=null){ 

		$bookingTableId = $dataArray['id'];
		$startdate = date('Y-m-d',strtotime($dataArray['startdate']));
		$enddate = date('Y-m-d',strtotime($dataArray['enddate']));
		$vehicleno = $dataArray['vehicleno'];  
		$old_vehicleno = $dataArray['old_vehicleno'];
		
		$isAlreadyBooked = '';
		if( trim($vehicleno) == trim($old_vehicleno) ){
		  $isAlreadyBooked = " OR ( status = 'booked' AND bookingid = '".$bookingTableId."' )";  
		}

		$sql = "SELECT DISTINCT(vehicleno) FROM `pt_dateslots` WHERE `dateslot` >= '".$startdate."'  and `dateslot` <= '".$enddate."' AND `modelid` = '".$dataArray['modelid']."' AND `vehicleno` = '".$vehicleno."' AND ( `status`='free' OR (`status`='reserve' AND `bookingid`='".$bookingTableId."' ) ".$isAlreadyBooked." ) ";
		$fsdata = $this->db->query( $sql );
		$fdata = $fsdata->row_array();

		 
		if(!empty($fdata)){ 
		    
		    //free old reserve slots
		    $this->c_model->saveupdate('pt_dateslots',['status'=>'free','bookingid'=>''],null,['bookingid'=>$bookingTableId]);
		    
			$where['vehicleno'] = $vehicleno;
			if( trim($vehicleno) != trim($old_vehicleno) ){
			$where["(status ='free' OR status='reserve' )"] = NULL;
			}
			$where['modelid'] = $dataArray['modelid'];
			$where['dateslot >='] = $startdate;
			$where['dateslot <='] = $enddate; 
			$save = [];
			$save['status'] = 'book';
			$save['bookingid'] = $bookingTableId; 
			
			$updatedStats = $this->c_model->saveupdate('pt_dateslots',$save,null,$where);
			 
			return $updatedStats;
		}else{
		    return false;
		}
        
	}   
  
	
}
?>