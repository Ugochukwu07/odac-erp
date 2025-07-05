<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Add_veh_service_cab extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
	     $this->pagename = 'Add_veh_service_cab';
	     $this->table = 'pt_vehicle_services';
     }	


  public function index() { 

  	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return='.$currentpage ) );
  	}
  	/*check domain end*/ 

	$data['posturl'] = adminurl($this->pagename );

	$table = $this->table;
    $id = $this->input->get('id') ? $this->input->get('id') : '';
    $vehicle_con_id = $this->input->get('vehicle_con_id') ? $this->input->get('vehicle_con_id') : '';
    $redirect = $this->input->get('redirect') ? $this->input->get('redirect') : '';
	 
	
	$data['title'] = 'Add Cab Service Details';

	$data['id'] = '';
	$data['vehicle_con_id'] = $vehicle_con_id;
	$data['service_details'] =  '';
	$data['service_date'] = date('d-m-Y');
	$data['service_km'] = '';
	$data['next_service_date'] = date('d-m-Y');
	$data['next_service_km'] = '';
	$data['tyre_alignment_date'] = date('d-m-Y');
	$data['tyre_alignment_km'] = '';
	$data['battery_date'] = '';
	$data['battery_details'] = '';
	$data['amount'] = ''; 
	$data['service_taken_from'] = ''; 
	
	$dateformat = 'd-m-Y';

	if( $id ){
     $old_dta = $this->c_model->getSingle($table,['md5(id)'=>$id],'*');
     
            $data['id'] = $old_dta['id'];
            $data['vehicle_con_id'] = $old_dta['vehicle_con_id'];
            $data['service_details'] =  $old_dta['service_details'];
            $data['service_date'] = date($dateformat,strtotime($old_dta['service_date']));
            $data['service_km'] = (int)$old_dta['service_km'];
            $data['next_service_date'] = date($dateformat,strtotime($old_dta['next_service_date']));
            $data['next_service_km'] = (int)$old_dta['next_service_km'];
            $data['tyre_alignment_date'] = !empty($old_dta['tyre_alignment_date']) ? date($dateformat,strtotime($old_dta['tyre_alignment_date'])) : '';
            $data['tyre_alignment_km'] = (int)$old_dta['tyre_alignment_km'];
            //$data['battery_date'] =  ($old_dta['battery_date'] != '0000-00-00') ? date($dateformat,strtotime($old_dta['battery_date'])) : '';
            //$data['battery_details'] = $old_dta['battery_details'];
            $data['amount'] = (int)$old_dta['amount'];
            $data['service_taken_from'] = $old_dta['service_taken_from'];
	}else{
	   $oldData = $this->db->query("select * from ".$table." where vehicle_con_id = '".$vehicle_con_id."' AND catid = 1 ORDER BY id DESC LIMIT 1 ")->row_array(); 
	   if(!empty($oldData)){
	       	$data['service_km'] = $oldData['next_service_km']; 
	        $data['next_service_km'] = (int)$oldData['next_service_km'] + 10000;
	   }
	}
	
	$keyExtraKey = 'vnumberdt';
	$select = "CONCAT(vnumber,',',(SELECT model FROM pt_vehicle_model WHERE id = modelid )) as vnumberdt"; 
	$where = [];
	$where["status"] = 'yes';
	$where["modelid IN( SELECT id FROM pt_vehicle_model WHERE catid = '1' )"] = NULL;
	
	$data['vehiclelist'] = get_dropdownsmultitxt('pt_con_vehicle',$where,'id','vnumber',' Vehicle ---', $select, $keyExtraKey );
	
	$data['redirect'] = $redirect;
 
	  _view( 'add_veh_service_cab', $data );
	  
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
            $sdata['service_details'] = !empty($post['service_details']) ? $post['service_details'] : NULL;
            $sdata['service_date'] =  !empty($post['service_date']) ? date('Y-m-d',strtotime($post['service_date'])):NULL;
            $sdata['service_km'] =  !empty($post['service_km']) ? $post['service_km']:NULL;
            $sdata['next_service_date'] = !empty($post['next_service_date'])?date('Y-m-d',strtotime($post['next_service_date'])):NULL;
            $sdata['next_service_km'] =  !empty($post['next_service_km']) ? $post['next_service_km']:NULL;
            $sdata['tyre_alignment_date'] =  !empty($post['tyre_alignment_date'])?date('Y-m-d',strtotime($post['tyre_alignment_date'])):NULL;
            $sdata['tyre_alignment_km'] =  !empty($post['tyre_alignment_km']) ? $post['tyre_alignment_km']:NULL;
            $sdata['battery_date'] =  !empty($post['battery_date'])?date('Y-m-d',strtotime($post['battery_date'])):NULL;
            $sdata['battery_details'] = !empty($post['battery_details'])?$post['battery_details']:NULL;
            $sdata['amount'] = !empty($post['amount']) ? $post['amount']:NULL;
            $sdata['service_taken_from'] = !empty($post['service_taken_from']) ? $post['service_taken_from']:NULL;
            $sdata['catid'] = 1; 
            
            if(empty($id)){
            $sdata['add_by_mobile'] = $login_by_mobile;
            $sdata['add_by_name'] = $login_by_name; 
            }

		$sdata = $this->security->xss_clean($sdata);
		
		$upwh = null;  $check = null;
		if( $id ){
			$upwh['id'] = $id;
			
			//set previous entry done
			$this->c_model->saveupdate( $this->table , ['is_done'=>1], null , ['vehicle_con_id'=>$post['vehicle_con_id'],'catid'=>'1', 'id !='=>$id ] );
		} 
		
		if( empty($id) ){
		    $check = [];
			$check['vehicle_con_id'] = $post['vehicle_con_id'];
			$check['DATE(add_date)'] = date('Y-m-d'); 
			$sdata['add_date'] = date('Y-m-d H:i:s');
			
			
			//set previous entry done
			$this->c_model->saveupdate( $this->table , ['is_done'=>1], null , ['vehicle_con_id'=>$post['vehicle_con_id'],'catid'=>'1'] );
		} 
		
		
		 
		 /*get old Vehicle services data*/
        $getData = !empty($id) ? $this->c_model->getSingle( $this->table ,['id'=>$id],'*') : [];
        $saveEditLog = []; 
        
        if(!empty($sdata['service_details'])){  
    		$editKey = 'service_details';  
    		//if( $getData[$editKey] != $sdata[$editKey] ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		//}
     	}
     	
     	if(!empty($sdata['service_date'])){  
    		$editKey = 'service_date';  
    		//if( $getData[$editKey] != $sdata[$editKey] ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		//}
     	}
     	
     	if(!empty($sdata['service_km'])){  
    		$editKey = 'service_km';  
    		//if( $getData[$editKey] != $sdata[$editKey] ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		//}
     	}
     	
     	if(!empty($sdata['next_service_date'])){  
    		$editKey = 'next_service_date';  
    		//if( $getData[$editKey] != $sdata[$editKey] ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		//}
     	}
     	
     	if(!empty($sdata['next_service_km'])){  
    		$editKey = 'next_service_km';  
    		//if( $getData[$editKey] != $sdata[$editKey] ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		//}
     	}
     	
     	if(!empty($sdata['tyre_alignment_date'])){  
    		$editKey = 'tyre_alignment_date';  
    		//if( $getData[$editKey] != $sdata[$editKey] ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		//}
     	}
     	
     	if(!empty($sdata['tyre_alignment_km'])){  
    		$editKey = 'tyre_alignment_km';  
    		//if( $getData[$editKey] != $sdata[$editKey] ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		//}
     	}
     	
     	if(!empty($sdata['amount'])){  
    		$editKey = 'amount';  
    		//if( $getData[$editKey] != $sdata[$editKey] ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		//}
     	}
     	if(!empty($sdata['service_taken_from'])){  
    		$editKey = 'service_taken_from';  
    		//if( $getData[$editKey] != $sdata[$editKey] ){
    		    $saveEditLog[] = ['table_id'=>$id,'edited_field'=>$editKey,'new_value'=>$sdata[$editKey],'previous_value'=>(!empty($getData[$editKey]) ? $getData[$editKey] :''),'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    		//}
     	} 
		 
    	//mantain Edit Data
     	if(!empty($saveEditLog) /*&& !empty($id )*/){ 
     	 $sdata['edit_date'] = date('Y-m-d H:i:s');
     	 $sdata['edit_by_mobile'] = $login_by_mobile;
     	 $sdata['edit_by_name'] = $login_by_name;
     	 $sdata['edit_verify_status'] = 'edit'; 
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
     	    $this->db->insert_batch('pt_vehicle_services_editing_log', $saveEditRecords ); 
     	}
     	
      
		
		if( $update && $id ){
		$this->session->set_flashdata('success',"Data updated successfully!");
		redirect( adminurl( $this->pagename.'/?id='.md5($id).'&redirect='.$redirect));
		
		}else if( $update && !$id){ 
		$this->session->set_flashdata('success',"Data Added successfully!");
		redirect( adminurl( $this->pagename ).'?redirect='.$redirect ) ;
		  
		}else if( !$update ){
		$this->session->set_flashdata('error',"Duplicate Entry!");
		redirect( adminurl( $this->pagename ).'?redirect='.$redirect ) ;
		}
		
		
	 
 } 
 
 function addMonthDates(){
     $date = $this->input->post( 'indate');
     echo date( 'd-m-Y', strtotime( $date.' +3 months' ));
 }
   
   
  
	
}
?>