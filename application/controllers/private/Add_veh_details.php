<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Add_veh_details extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
	     $this->pagename = 'Add_veh_details';
	     $this->table = 'pt_vehicle_details';
     }	


  public function index() { 

  	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return='.$currentpage ) );
  	}
  	/*check domain end*/ 

	$data['posturl'] = adminurl($this->pagename.'/uploads');

	$table = $this->table;
    $id = $this->input->get('id') ? $this->input->get('id') : '';
    $vehicle_con_id = $this->input->get('vehicle_con_id') ? $this->input->get('vehicle_con_id') : '';
    
    $redirect = $this->input->get('redirect') ? $this->input->get('redirect') : '';
	 
	
	$data['title'] = 'Add Vehicle Documents';
	$data['redirect'] = $redirect;

	$data['id'] = '';
	$data['vehicle_con_id'] = $vehicle_con_id;
	$data['white_permit_from'] =  date('d-m-Y');
	$data['white_permit_till'] = '';
	$data['permit_from'] = '';
	$data['permit_till'] = '';
	$data['tax_from'] = '';
	$data['tax_till'] = '';
	$data['fitness_from'] = '';
	$data['fitness_till'] = '';
	$data['insurence_from'] = '';
	$data['insurence_till'] = '';
	$data['polution_from'] = '';
	$data['polution_till'] = '';
	$data['policy_no'] = '';
	$data['company_id'] = '';
    $data['insu_company_name'] = '';
    $data['payment_mode'] = '';
    $data['payment_date'] = '';
    $data['payment_txn_id'] = '';
	
	$dateformat = 'd-m-Y';

	if( $id ){
     $old_dta = $this->c_model->getSingle($table,['md5(id)'=>$id],'*');
            $data['id'] = $old_dta['id'];
            $data['vehicle_con_id'] =  $old_dta['vehicle_con_id'];
            $data['white_permit_from'] = date($dateformat,strtotime($old_dta['white_permit_from']));
            $data['white_permit_till'] =  date($dateformat,strtotime($old_dta['white_permit_till']));
            $data['permit_from'] =  date($dateformat,strtotime($old_dta['permit_from']));
            $data['permit_till'] =  date($dateformat,strtotime($old_dta['permit_till']));
            $data['tax_from'] =  date($dateformat,strtotime($old_dta['tax_from']));
            $data['tax_till'] =  date($dateformat,strtotime($old_dta['tax_till']));
            $data['fitness_from'] =  date($dateformat,strtotime($old_dta['fitness_from']));
            $data['fitness_till'] =  date($dateformat,strtotime($old_dta['fitness_till']));
            $data['insurence_from'] =  date($dateformat,strtotime($old_dta['insurence_from']));
            $data['insurence_till'] =  date($dateformat,strtotime($old_dta['insurence_till']));
            $data['polution_from'] =  date($dateformat,strtotime($old_dta['polution_from']));
            $data['polution_till'] =  date($dateformat,strtotime($old_dta['polution_till']));
            $data['policy_no'] =  $old_dta['policy_no'];
            $data['company_id'] =  $old_dta['company_id'];
            $data['insu_company_name'] =  $old_dta['insu_company_name'];
            $data['payment_mode'] = $old_dta['payment_mode']; 
            $data['payment_date'] = $old_dta['payment_date']!='0000-00-00' ? date($dateformat,strtotime( $old_dta['payment_date'])) :'';
            $data['payment_txn_id'] = $old_dta['payment_txn_id'];
	}
	
	//$data['vehiclelist'] = get_dropdownsmulti('pt_con_vehicle',['status'=>'yes'],'id','vnumber',' Vehicle ---' );
	$keyExtraKey = 'vnumberdt';
	$select = "CONCAT(vnumber,',',(SELECT model FROM pt_vehicle_model WHERE id = modelid )) as vnumberdt";  
	$data['vehiclelist'] = get_dropdownsmultitxt('pt_con_vehicle',['status'=>'yes'],'id','vnumber',' Vehicle ---', $select, $keyExtraKey );
	
	$data['companylist'] = get_dropdownsmulti('pt_insurance_company',['status'=>'Active'],'id','company_name',' Company Name ---' ); 
 
	_view( 'add_veh_details', $data );
	  
   }


 public  function savedata(){
 	$post = $this->input->post();

// echo '<pre>';
// print_r( $post );
// exit;
         
        $loginUser = $this->session->userdata('adminloginstatus');  
        $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
        $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
        $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';


		$id = $post['id'];
		$redirect = $post['redirect'];

		 
	        $sdata['vehicle_con_id'] =  $post['vehicle_con_id'];
            $sdata['white_permit_from'] = !empty($post['white_permit_from'])?date('Y-m-d',strtotime($post['white_permit_from'])):NULL;
            $sdata['white_permit_till'] =  !empty($post['white_permit_till'])?date('Y-m-d',strtotime($post['white_permit_till'])):NULL;
            $sdata['permit_from'] =  !empty($post['permit_from'])?date('Y-m-d',strtotime($post['permit_from'])):NULL;
            $sdata['permit_till'] = !empty($post['permit_till'])?date('Y-m-d',strtotime($post['permit_till'])):NULL;
            $sdata['tax_from'] =  !empty($post['tax_from'])?date('Y-m-d',strtotime($post['tax_from'])):NULL;
            $sdata['tax_till'] =  !empty($post['tax_till'])?date('Y-m-d',strtotime($post['tax_till'])):NULL;
            $sdata['fitness_from'] =  !empty($post['fitness_from'])?date('Y-m-d',strtotime($post['fitness_from'])):NULL;
            $sdata['fitness_till'] =  !empty($post['fitness_till'])?date('Y-m-d',strtotime($post['fitness_till'])):NULL;
            $sdata['insurence_from'] = !empty($post['insurence_from'])?date('Y-m-d',strtotime($post['insurence_from'])):NULL;
            $sdata['insurence_till'] = !empty($post['insurence_till'])?date('Y-m-d',strtotime($post['insurence_till'])):NULL;
            $sdata['polution_from'] =  !empty($post['polution_from'])?date('Y-m-d',strtotime($post['polution_from'])):NULL;
            $sdata['polution_till'] =  !empty($post['polution_till'])?date('Y-m-d',strtotime($post['polution_till'])):NULL;
            $sdata['policy_no'] =  !empty($post['policy_no']) ? trim($post['policy_no']) : NULL;
            $sdata['company_id'] =  !empty($post['company_id']) ? trim($post['company_id']) : NULL;
            $sdata['insu_company_name'] =  !empty($post['insu_company_name']) ? trim($post['insu_company_name']) : NULL;
            
            $sdata['payment_mode'] = !empty($post['payment_mode']) ? trim($post['payment_mode']) : 'N/A';
            $sdata['payment_date'] = !empty($post['payment_date'])?date('Y-m-d',strtotime($post['payment_date'])):NULL;
            $sdata['payment_txn_id'] = !empty($post['payment_txn_id']) ? trim($post['payment_txn_id']) : 'N/A';
            
            
            if(empty($id)){
            $sdata['add_by_mobile'] = $login_by_mobile;
            $sdata['add_by_name'] = $login_by_name; 
            $sdata['add_date'] = date('Y-m-d H:i:s'); 
            }

		$sdata = $this->security->xss_clean($sdata);
		
		$upwh = null;  $check = null;
		if( $id ){
			$upwh['id'] = $id; 
		} 
		
		if( empty($id) ){
		    $check = [];
			$check['vehicle_con_id'] = $post['vehicle_con_id'];
		} 
		
		
		 
		 /*get old Vehicle services data*/
        $getData = !empty($id) ? $this->c_model->getSingle( $this->table ,['id'=>$id],'*') : [];
        $saveEditLog = []; 
        $lastActivity = [];
        
        if(!empty($sdata['white_permit_from'])){  
    		$editKey = 'white_permit_from';  
    		if( $getData[$editKey] != $sdata[$editKey] && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = 'white_permit_from'; 
    		}else {
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['white_permit_till'])){  
    		$editKey = 'white_permit_till';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id) ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = 'white_permit_till'; 
    		}else{
    		     $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['permit_from'])){  
    		$editKey = 'permit_from';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = 'permit_from'; 
    		}else{
    		   $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['permit_till'])){  
    		$editKey = 'permit_till';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = 'permit_till'; 
    		}else{
    		   $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['tax_from'])){  
    		$editKey = 'tax_from';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey;  
    		}else{
    		     $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['tax_till'])){  
    		$editKey = 'tax_till';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey;  
    		}else{
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['fitness_from'])){  
    		$editKey = 'fitness_from';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey; 
    		}else{
    		      $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['fitness_till'])){  
    		$editKey = 'fitness_till';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey;  
    		}else{
    		      $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['insurence_from'])){  
    		$editKey = 'insurence_from';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey;  
    		}else{
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	} 
     	
     	if(!empty($sdata['insurence_till'])){  
    		$editKey = 'insurence_till';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey;  
    		}else{
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	} 
     	
     	if(!empty($sdata['polution_from'])){  
    		$editKey = 'polution_from';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey;  
    		}else{
    		   $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	} 
     	
     	if(!empty($sdata['polution_till'])){  
    		$editKey = 'polution_till';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey;  
    		}else{
    		 $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['policy_no'])){  
    		$editKey = 'policy_no';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey;
    		}else{
    		      $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	} 
     	
     	if(!empty($sdata['insu_company_name'])){  
    		$editKey = 'insu_company_name';  
    		if( $getData[$editKey] != $sdata[$editKey] && !empty($id) ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey; 
    		}else{
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}  
     	
     	if(!empty($sdata['payment_mode'])){  
    		$editKey = 'payment_mode';  
    		if( $getData[$editKey] != $sdata[$editKey] && !empty($id) ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey; 
    		}else{
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['payment_txn_id'])){  
    		$editKey = 'payment_txn_id';  
    		if( $getData[$editKey] != $sdata[$editKey] && !empty($id) ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey; 
    		}else{
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
     	
     	if(!empty($sdata['payment_date'])){  
    		$editKey = 'payment_date';  
    		if( $getData[$editKey] != $sdata[$editKey]  && !empty($id)){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		    $lastActivity[] = $editKey;  
    		}else{
    		 $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		}
     	}
       
		 
    	//mantain Edit Data
     	if(!empty($saveEditLog) /*&& !empty($id )*/ ){ 
     	 $sdata['edit_date'] = date('Y-m-d H:i:s'); 
     	 $sdata['edit_by_mobile'] = $login_by_mobile;
     	 $sdata['edit_by_name'] = $login_by_name;
     	 $sdata['edit_verify_status'] = 'edit'; 
     	 $sdata['last_activity'] = !empty($lastActivity) ? json_encode( $lastActivity ) : '';
     	}
 	
		
		/*insert / update edited data*/
		$update = $this->c_model->saveupdate( $this->table , $sdata, $check, $upwh ); 
		
		$table_id = !empty($id) ? $id : ($update != 1 ? $update : '');
		if(!empty($saveEditLog) && !empty($table_id ) ){
		    $saveEditRecords = [];
		    foreach( $saveEditLog as $key=>$value ){
		        $push = [];
		        $push = $value;
		        $push['table_id'] = $table_id;
		        array_push( $saveEditRecords, $push );
		    }
     	    $this->db->insert_batch('pt_vehicle_details_editing_log', $saveEditRecords ); 
     	}
     	
     	
		
		if( $update && $id ){
		$this->session->set_flashdata('success',"Data updated successfully!");
		redirect( adminurl( $this->pagename.'/?id='.md5($id).'&redirect='.$redirect ));
		
		}else if( $update && !$id){ 
		$this->session->set_flashdata('success',"Data inserted successfully!");
		redirect( adminurl( $this->pagename.'?redirect='.$redirect )) ;
		  
		}else if( !$update ){
		$this->session->set_flashdata('error',"Duplicate Entry!");
		redirect( adminurl( $this->pagename.'?redirect='.$redirect )) ;
		} 	
	 
 } 
 
 
 
  public function getEditLog(){
		    $id = $this->input->post('id');
		    $getData = $this->db->query('SELECT *  FROM pt_vehicle_details_editing_log WHERE table_id = '.$id.' ')->result_array();
	
	    $html = '';
	    if(!empty($getData)){
	        $html .= '<div class="row">';
	        $html .= '<div class="col-lg-2 spanr12">Edit Field</div>';
	        $html .= '<div class="col-lg-2 spanr12">New Value</div>';
	        $html .= '<div class="col-lg-2 spanr12">Old Value</div>';
	        $html .= '<div class="col-lg-2 spanr12">Edit By Name</div>';
	        $html .= '<div class="col-lg-2 spanr12">Edit By Mobile</div>';
	        $html .= '<div class="col-lg-2 spanr12">Edit Date</div>';
	        $html .= '</div>';
	        foreach( $getData as $key=>$value ){
                $html .= '<div class="row">';
                $html .= '<div class="col-lg-2">'.ucwords( str_replace('_', ' ', $value['edited_field'])).'</div>';
                $html .= '<div class="col-lg-2">'.$value['new_value'].'</div>';
                $html .= '<div class="col-lg-2">'.$value['previous_value'].'</div>';
                $html .= '<div class="col-lg-2">'.$value['edit_by_name'].'</div>';
                $html .= '<div class="col-lg-2">'.$value['edit_by_mobile'].'</div>';
                $html .= '<div class="col-lg-2">'.date('d M Y h:i A', strtotime($value['edited_on'])).'</div>';
                $html .= '</div>';
	        } 
	    }
	    
	    echo $html;
	}
	
	
	
	public function verifyEditLog(){
	    $id = $this->input->post('id');
	    if( !empty($id)){
	    $this->c_model->saveupdate('pt_vehicle_details',['edit_verify_status'=>'verify','last_activity'=>''],null, ['id'=>$id]);
	    }
	    
	    echo true;
	}
   
   
  
	
}
?>