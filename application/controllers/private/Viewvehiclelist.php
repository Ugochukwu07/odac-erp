<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewvehiclelist extends CI_Controller{
	
     function __construct() {
         parent::__construct();  
	     adminlogincheck();
     }	
	
	 
	public function index(){

		    $data['title'] = 'View Model List';
		    $select = 'b.model, b.catid, a.* ,c.category'; 
		    $from = ' pt_con_vehicle as a';

		    $join[0]['table'] = 'pt_vehicle_model as b';
		    $join[0]['on'] = 'a.modelid = b.id';
		    $join[0]['key'] = 'LEFT';
		    $join[1]['table'] = 'pt_vehicle_cat as c';
		    $join[1]['on'] = 'b.catid = c.id';
		    $join[1]['key'] = 'LEFT';

		    $orderby = 'b.model ASC';

		    $data['list'] = $this->c_model->joindata( $select,null, $from, $join, null,$orderby );
  
		    _viewlist( 'viewvehiclelist', $data ); 
		}



	 public function delete() { 
	 	    $table = 'pt_con_vehicle';
	        $getid = $this->input->get() ? $this->input->get('delId') : array();  
	        $where['md5(id)'] = $getid; 
		    $status = $getid ? $this->c_model->delete( $table, $where ) : '';
		    $message = $getid && $status ? 'Data Deleted Successfully' :'Some Error Occured';
		$this->session->set_flashdata('error', $message ); 
		    redirect( adminurl('viewvehiclelist'));
	    
   }  
   
   function blockVehicle(){
       $id = $this->input->post('id');
       if( !empty($id) ){
           $this->c_model->saveupdate( 'pt_con_vehicle', ['status'=>'block'],null, ['id'=>$id] ) ;
           $this->session->set_flashdata('success',"Vehicle Blocked Successfully!");
           echo true; exit;
       }else{
           	$this->session->set_flashdata('error',"Some Error Occurred!");
           echo false; exit;
       }
       
   }
   

}
?>