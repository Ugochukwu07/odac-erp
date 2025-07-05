<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Details extends CI_Controller{
	
	  function __construct() {
         parent::__construct();  
		 adminlogincheck(); 
      }
	


  public function index() {
      
            $data = [];
	  
	        $id = $this->input->get('id') ? $this->input->get('id') : '';
	        if(empty($id)){
                echo  redirect( base_url('private/dashboard') ); exit;
            }
	
	        $data['title'] = 'Trip Details';
		    

$select = 'a.*,b.domain,c.model,d.added_on,d.amount as ad_booking_amount,e.fullname as roll_fullname';
$where['md5(a.id)'] = $id; 
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
 // echo '<pre>';
 // print_r( $getdata ); exit;
		
		    _view( 'details', ['data'=> $getdata ] );  
	    
}


function editHistory(){
    
        $data = [];
    
        $id = $this->input->get('id') ? $this->input->get('id') : '';
        $bookid = $this->input->get('bookid') ? $this->input->get('bookid') : '';
        $redirect = $this->input->get('redirect') ? $this->input->get('redirect') : '';
        if(empty($id)){
           echo  redirect( base_url('private/dashboard') ); exit;
        }

        $data['title'] = 'Trip Edit History Details';
        
        $getData = $this->db->query("SELECT *  FROM pt_booking_editing_log WHERE md5(booking_id) = '".$id."' ")->result_array();
        
        
        $data['list'] = $getData;
        $data['redirect'] = $redirect;
        $data['bookingid'] = $bookid;
    
     _view( 'edithistory', $data );  
    
}
   

}
?>