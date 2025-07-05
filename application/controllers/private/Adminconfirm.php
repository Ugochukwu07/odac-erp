<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Adminconfirm extends CI_Controller{
	
	  function __construct() {
         parent::__construct(); 
      }
	


  public function index() {
	  
	        $id = $this->input->get('id') ? $this->input->get('id') : '';
	        if(empty($id)){
                redirect( base_url('') ); exit;
	        }
	
	       
		    

$select = 'a.*,b.domain,c.model,d.added_on,d.amount as ad_booking_amount,e.fullname as roll_fullname';
$where['md5(a.id)'] = $id; 
$where['a.attemptstatus'] = 'new'; 
$from = 'pt_booking as a'; 
$join[0]['table'] = 'pt_domain as b';
$join[0]['on'] = 'a.domainid = b.id';
$join[0]['key'] = 'LEFT';

$join[1]['table'] = 'pt_vehicle_model as c';
$join[1]['on'] = 'a.modelid = c.id';
$join[1]['key'] = 'LEFT';

$join[2]['table'] = 'pt_payment_log as d';
$join[2]['on'] = 'a.id = d.booking_id';
$join[2]['key'] = 'LEFT';

$join[3]['table'] = 'pt_roll_team_user as e';
$join[3]['on'] = 'a.add_by = e.mobile';
$join[3]['key'] = 'LEFT';

$groupby  = null;
$orderby = null;
$limit = null;


$getdata = $this->c_model->joindata( $select, $where, $from, $join, $groupby,$orderby,$limit); 

 

if( empty($getdata)){
      echo '<html><br/><br/><center><img src="'.base_url("assets/images/booking_closed.png").'" style="width:90%;"></center></html>'; 
    exit;
}
 
 
		
		$this->load->view('private/adminconfirm',['data'=>$getdata]); 
	    
}
   
   
 
   
   
public function cancel(){
 	$request = $this->input->get(); 

 	$id = $request['id'];
 	$redirect = $request['redirect'];


 	$keys = ' * ';
	$getdata = $this->c_model->getSingle('booking',['id'=>$id],'*'); 


 	$save = [];
 	$save['drvname'] = '';
 	$save['dvrtableid'] = '';
 	$save['drvmobile'] = '';
 	$save['vehicleno'] = '';
 	$save['attemptstatus'] = 'cancel';
 	$save['driverstatus'] = 'reject';  
 	$where['id'] = $id;

 	$update = $this->c_model->saveupdate('booking', $save, null, $where ); 
	 
	$sms = shootsms($getdata,'cancel'); 

	/*free slot */
	$this->setFreeSlot( $id );

	$this->session->set_flashdata('success',"Booking Cancelled Successfully!");

	redirect( adminurl('adminconfirm/index?id='.md5($id).'&type='.$redirect ) );
   }


   public function confirm(){
 	$request = $this->input->get(); 
 	$id = $request['id'];
 	$redirect = $request['redirect']; 
 	$keys = ' * ';
	$getdata = $this->c_model->getSingle('booking',['id'=>$id],'*'); 
 	$save = [];
 	$save['drvname'] = '';
 	$save['dvrtableid'] = '';
 	$save['drvmobile'] = '';
 	$save['vehicleno'] = '';
 	$save['attemptstatus'] = 'approved';   
 	$where['id'] = $id; 
 	$update = $this->c_model->saveupdate('booking', $save, null, $where );  
	$sms = shootsms($getdata,'approved');  
	$this->session->set_flashdata('success',"Booking Confirmed Successfully!"); 
	redirect( adminurl('adminconfirm/index?id='.md5($id).'&type='.$redirect ) );
   }


   function setFreeSlot($id=null){ 
			$save = [];
			$where = [];
			$save['status'] = 'free';
			if(!empty($id)){
			$where['bookingid'] = $id; 
			$this->c_model->saveupdate('pt_dateslots',$save,null,$where);
			} 
   }
   
   

   

}
?>