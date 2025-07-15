<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Addcity extends CI_Controller{
	
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
         $this->load->model('Common_model', 'c_model');
     }	


  public function index() {
	 
	$currentpage = 'Addcity';
	$data['posturl'] = adminurl($currentpage); 

	$table = 'city';
    $id = $this->input->get('id') ? $this->input->get('id') : '';
	 
	
	$data['title'] = ( !empty($id) ? 'Update' : 'Add') .' City';
	
	
	 
	    $data['stateid'] = ""; 
	    $data['cityname'] = ""; 
	    $data['citycode'] = ""; 
		$data['add_by'] = "";  
		$data['status'] = "yes"; 
		$data['id'] = $id; 
		$data['seourl'] = ""; 
		$data['pickupdropaddress'] = ""; 
		$status = '';
	
		
	
	 if( !empty($id ))
	 {
	    $dbdistrict = $this->c_model->getSingle($table, array( 'id'=>$id ) );
	    $data['id'] = $dbdistrict['id']; 
		$data['stateid'] = $dbdistrict['stateid'];
		$data['cityname'] = $dbdistrict['cityname'];
		$data['citycode'] = $dbdistrict['citycode'];  
		$data['add_by'] = $dbdistrict['add_by'];     
		$data['status'] = $dbdistrict['status'];  
		$data['seourl'] = $dbdistrict['seourl']; 
		$data['pickupdropaddress'] = $dbdistrict['pickupdropaddress']; 
		$status = $dbdistrict['status'];  
	 }
	 	 
	  $this->input->post('statename') ? $this->form_validation->set_rules('statename','Enter State name ','required') : '';
	  $this->input->post('stateid') ? $this->form_validation->set_rules('stateid','Enter State name ','required') : '';
	  $this->form_validation->set_rules('cityname','Enter City name ','required'); 
	 
	 if($this->form_validation->run() == false){ 
		$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
	 }
		
	 
	 if( $this->form_validation->run() != false){
		 
		$dbdistpost = $this->input->post();


		$spost['stateid'] = isset($dbdistpost['stateid']) ?$dbdistpost['stateid'] : NULL;
		/* maintain state list start */
		if(isset($dbdistpost['statename']) && $dbdistpost['statecode'] ){
			$dataarray['statename'] = trim( $dbdistpost['statename'] );
			$dataarray['statecode'] = trim( $dbdistpost['statecode'] );
			$dataarray['add_date'] = date('Y-m-d H:i:s');
			$dataarray['add_by'] = 'yes';
			$validation['statename'] = trim( $dbdistpost['statename'] );
			 
			$dataarray['status'] = 'yes'; 
		$id = $this->c_model->saveupdate('state', $dataarray, $validation );
		$spost['stateid'] = $id;

		if(!$spost['stateid']){
		$spost['stateid'] = getftcharray('state', $validation,'id');	
		}

		}	


		/* maintain state list end */
		 
	    $spost['cityname'] = $dbdistpost['cityname']; 
	    $checkitem = $this->c_model->countitem( $table, $spost ); 	   
 
		$spost['citycode'] = !empty($dbdistpost['citycode'])?$dbdistpost['citycode']:''; 
		$spost['add_by'] = 'admin';  
		$spost['pickupdropaddress'] = !empty($dbdistpost['pickupdropaddress'])?$dbdistpost['pickupdropaddress']:''; 
		 
		$spost['status']= isset($dbdistpost['status']) ? $dbdistpost['status'] : 'yes';    
		
		
		$id = !empty($dbdistpost['id']) ? $dbdistpost['id'] : NULL ;
		$postwhere = !empty($id) ? array('id'=> $id) : NULL ;  
		
		
		if( $id && $spost['stateid']){ 
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, $postwhere, NULL );
        log_activity('city_updated', 'Updated city: ' . $spost['cityname'], $id, $table);
	    $this->session->set_flashdata('success',"Your data has been updated successfully!");
		redirect( adminurl( $currentpage.'/?id='.$id));
		
		}else if( empty($checkitem) && empty($id) && $spost['stateid'] ){
		$ststus = $this->c_model->saveupdate( $table, $spost);
        if($ststus) {
            log_activity('city_added', 'Added new city: ' . $spost['cityname'], $ststus, $table);
        }
		$this->session->set_flashdata('success',"Your data has been added successfully!");
		redirect( adminurl( $currentpage ));
		  
		}else if( $checkitem ){
		$this->session->set_flashdata('error',"City is already Added please check the details!");
		redirect( adminurl( $currentpage )); 
		}
		
		
	
	 }
 
      
 
	  _view( 'addcity', $data );
	  
   }




   public function deletecity(){

      if( $id = $this->input->get('delId') ){
        $city = $this->c_model->getSingle('city', array('md5(id)'=>$id));
        if ($city) {
            log_activity('city_deleted', 'Deleted city: ' . $city['cityname'], $city['id'], 'city');
        }
      	$this->c_model->delete('city',array('md5(id)'=>$id));
      	$this->session->set_flashdata('error',"City deleted successfully!");
      	redirect( adminurl('viewcity') );
      }

   }
   
   
  
	
}
?>