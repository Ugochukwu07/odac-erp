<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Configurevehicle extends CI_Controller{
	
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
     }	


  public function index() {
	 
	$currentpage = 'Configurevehicle'; 
	$data['posturl'] = adminurl($currentpage.'/');

	$table = 'pt_con_vehicle';
     
	 
	
	$data['title'] = 'Configure Vehicle Number';
	$data['redirect'] = !empty($this->input->get('redirect')) ? $this->input->get('redirect') : ''; 
	
	
	 
	    $data['id'] = "";
	    $data['modelid'] = ""; 
	    $data['vnumber'] = "";  
		$data['status'] = "yes"; 
		$data['vyear'] = "";
		$data['seat'] = ""; 
		$data['fueltype'] = "";  
		 
	
		
	
	 if( $id = $this->input->get('id') ){
	    $dbdistpost = $this->c_model->getSingle($table, array( 'id'=>$id ) );
	    $data['id'] = $dbdistpost['id']; 
	    $data['modelid'] = $dbdistpost['modelid']; 
	    $data['vnumber'] = $dbdistpost['vnumber'];   
		$data['status'] = $dbdistpost['status']; 
		$data['vyear'] = $dbdistpost['vyear']; 
		$data['seat'] = $dbdistpost['seat']; 
		$data['fueltype'] = $dbdistpost['fueltype'];   
	 }


	 	 
	$this->form_validation->set_rules('modelid','Select model name ','required');
	$this->form_validation->set_rules('vnumber','Enter vehicle number','required'); 

	if($this->form_validation->run() == false){ 
	$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
	}
		
	 


	 if( $this->form_validation->run() != false){
		 
		$dbpost = $this->input->post(); 
		
		$redirect = $dbpost['redirect'];

		 
	    $spost['modelid'] = $dbpost['modelid']; 
	    $spost['vnumber'] = $dbpost['vnumber'];   
		$spost['status']= isset($dbpost['status']) ? $dbpost['status'] : 'yes'; 
		$spost['vyear'] = $dbpost['vyear']; 
		$spost['seat'] = $dbpost['seat']; 
		$spost['fueltype'] = $dbpost['fueltype'];

		  

		$spost = $this->security->xss_clean($spost);
		
		$id = !empty($dbpost['id']) ? $dbpost['id'] : NULL ;
		$postwhere = !empty($id) ? array('id'=> $id) : NULL ; 
		
		
		$checkpost['modelid'] = $dbpost['modelid'];
		$checkpost['vnumber'] = $dbpost['vnumber'];
		
		$checkitem = $this->c_model->countitem( $table, $checkpost );
		
		
		if( !empty($id) ){
		$status = $this->c_model->saveupdate( $table, $spost, NULL, $postwhere, NULL );	
		$this->session->set_flashdata('success',"Data updated successfully!");
		redirect( adminurl( $currentpage.'/?id='.$id.'&redirect='.$redirect ));
		
		}else if( empty($checkitem) && empty($id)){
		$VehicleConId = $this->c_model->saveupdate( $table, $spost );
		$this->addServiceEntry( $VehicleConId );
		$this->session->set_flashdata('success',"Data added successfully!");
		redirect( adminurl( $currentpage ).'?redirect='.$redirect ) ;
		}else if( !empty($checkitem)){
		$this->session->set_flashdata('error',"Data is already exist!");
		redirect( adminurl( $currentpage ) .'?redirect='.$redirect ) ;
		} 
	
	 }
 

   
	  _view( 'configurevehicle', $data );
	  
   }
   
   
   function addServiceEntry( $vehicle_con_id  ){
            $catIdArray = $this->db->query("SELECT catid FROM `pt_vehicle_model` WHERE id = (SELECT modelid FROM `pt_con_vehicle` WHERE id = '".$vehicle_con_id."' ) ")->row_array();
             
            if(!empty($catIdArray)){
                $sdata['vehicle_con_id'] =  $vehicle_con_id;
                $sdata['service_details'] = 'Default Entry';
                $sdata['service_date'] =  date('Y-m-d');
                $sdata['service_km'] =  0;
                $sdata['next_service_date'] = date('Y-m-d',strtotime(date('Y-m-d').' +1 months '));
                $sdata['next_service_km'] =  1000;
                $sdata['tyre_alignment_date'] =  NULL;
                $sdata['tyre_alignment_km'] =  0;
                //$sdata['battery_date'] =  NULL;
                //$sdata['battery_details'] = NULL;
                $sdata['amount'] = 0; 
                $sdata['service_taken_from'] = 'Company'; 
                $sdata['catid'] = !empty($catIdArray['catid']) ? $catIdArray['catid'] : '';
                $sdata['add_date'] = date('Y-m-d H:i:s');
                $this->c_model->saveupdate( 'pt_vehicle_services', $sdata );
            }
   }
   
   
  
	
}
?>