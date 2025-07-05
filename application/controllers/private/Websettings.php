<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Websettings extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
	     $this->pagename = 'Websettings';
	     $this->table = 'pt_address_office_list';
     }	


  public function index() { 

  	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return='.$currentpage ) );
  	}
  	/*check domain end*/ 

	$data['posturl'] = adminurl($this->pagename.'/savedata');

	$table = $this->table;
    $id = $this->input->get('id') ? $this->input->get('id') : ''; 
	 
	
	$data['title'] = 'Add Address';

	$data['id'] = '';
	$data['office_type'] = ''; 
	$data['city_name'] = '';
	$data['sortby'] = '';
	$data['address_name'] = '';
	$data['mobile_numbers'] = '';
	$data['map_script'] = '';
	$data['whats_app'] = '';
	$data['email_address'] = '';
	$data['status'] = 'Yes'; 
	$data['working_hours'] = '';
	$data['working_days'] = '';

	if( $id ){
     $old_dta = $this->c_model->getSingle($table,['md5(id)'=>$id],'*');
            $data['id'] = $old_dta['id'];
            $data['office_type'] =  $old_dta['office_type'];
            $data['city_name'] = $old_dta['city_name'];
            $data['sortby'] = $old_dta['sortby'];
            $data['address_name'] = $old_dta['address_name'];
            $data['mobile_numbers'] = $old_dta['mobile_numbers'];
            $data['map_script'] = $old_dta['map_script'];
            $data['status'] = $old_dta['status'];
            $data['whats_app'] = $old_dta['whats_app'];
            $data['email_address'] = $old_dta['email_address'];
            $data['working_hours'] = $old_dta['working_hours'];
            $data['working_days'] = $old_dta['working_days'];
	} 
	 
 
	  _view( strtolower($this->pagename), $data );
	  
   }


 public function savedata(){
 	$post = $this->input->post();

// echo '<pre>';
// print_r( $post );
// exit;
         


        $id = $post['id']; 
        
        $sdata = [];
        
        $sdata['office_type'] =  $post['office_type'];
        $sdata['city_name'] = $post['city_name'];
        $sdata['sortby'] =  $post['sortby'];
        $sdata['address_name'] = $post['address_name'];
        $sdata['mobile_numbers'] = $post['mobile_numbers'];
        $sdata['map_script'] = $post['map_script'];
        $sdata['status'] = 'Yes'; //$post['status'];
        $sdata['whats_app'] = $post['whats_app'];
        $sdata['email_address'] = $post['email_address'];
        $sdata['updated_date'] = date('Y-m-d H:i:s');
        $sdata['add_by'] = 'Super Admin';
        $sdata['working_days'] = $post['working_days'];
        $sdata['working_hours'] = $post['working_hours'];
       
        
        //$sdata = $this->security->xss_clean($sdata);
		
		$upwh = null;  $check = null;
		if( !empty($id) ){
			$upwh['id'] = $id; 
		} 
		
		if( empty($id) ){
		    //$check = [];
			//$check['office_type'] =  $post['office_type'];
			$sdata['add_date'] = date('Y-m-d H:i:s');
		} 
		
		
		 
		 
		$update = $this->c_model->saveupdate( $this->table , $sdata, $check, $upwh, $id );
		
		//echo $this->db->last_query(); exit;
		
		
		if( $update && $id ){
		$this->session->set_flashdata('success',"Data updated successfully!");
		redirect( adminurl( $this->pagename.'/?id='.md5($id)));
		
		}else if( $update && !$id){ 
		$this->session->set_flashdata('success',"Data inserted successfully!");
		redirect( adminurl( $this->pagename )) ;
		  
		}else if( !$update ){
		$this->session->set_flashdata('error',"Duplicate Entry!");
		redirect( adminurl( $this->pagename )) ;
		} 
		
	 
 } 
 
 
 public function list(){ 
	 
	        $data['title'] = 'View Address List';
		    $data['list'] = $this->c_model->getAll( $this->table ); 
			 
		    _viewlist( 'websettings_list', $data ); 
   }  
   
  public function deleteitem(){
  	$id = $this->input->get('delId');
  	$this->c_model->delete( $this->table , ['md5(id)'=>$id]);
  	$this->session->set_flashdata('success','Data Deleted Successfully!');
  	redirect( adminurl( $this->pagename.'/list' )) ;
  } 
   
  
	
}
?>