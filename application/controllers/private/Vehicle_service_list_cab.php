<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_service_list_cab extends CI_Controller{
	 var $pagename;
     function __construct() {
         parent::__construct();  
	     adminlogincheck();
	     $this->pagename = 'vehicle_service_list_cab';
     }	
	
	 
	public function index(){
	    
	        $post = $this->input->get();
	        $get_vcid = $this->input->get('vcid');
	        $get_vcid2 = $this->input->get('vcid2');
	        $get_status = $this->input->get('status');
	        $is_history = !empty($post['is_history']) ? $post['is_history'] : '';
	        
	        $is_export = $this->input->get('is_export');

		    $data['title'] = 'Vehicle Service List'; 
		  
		    //export csv report 
            if( !empty($is_export) ){
                $list = $this->getRecordsFromDb( $post, null, null, null, $is_history );
		        $this->exportCSV( $list );
		    }
            
            
            $data['exporturl'] =  adminurl('Vehicle_service_list_cab?is_export=yes&vcid='.$get_vcid.'&vcid2='.$get_vcid2.'&status='.$get_status.'&is_history='.$is_history );
            $data['vcid'] = $get_vcid;
            $data['vcid2'] = $get_vcid2;
            
            
            //vehicle drop down list
            $keyExtraKey = 'vnumberdt';
            $select = "CONCAT(vnumber,',',(SELECT model FROM pt_vehicle_model WHERE id = modelid )) as vnumberdt"; 
            $where = [];
            $where["status"] = 'yes';
            $where["modelid IN( SELECT id FROM pt_vehicle_model WHERE catid = '1' )"] = NULL;
            
            $data['vehiclelist'] = get_dropdownsmultitxt('pt_con_vehicle',$where,'md5(id)','vnumber',' Vehicle ---', $select, $keyExtraKey );

	        $data['redirect'] = $get_status;
  
		    _viewlist( strtolower($this->pagename), $data ); 
		}


 protected function getRecordsFromDb( $post , $limit = null , $start = null, $is_count = null, $is_history = null ){
      
            $like = null;
            $likekey = null;
            $likeaction = null;
            
        	$select = "CASE WHEN next_service_date > CURDATE() THEN 1 ELSE 2 END AS date_status,(CASE  WHEN a.edit_verify_status = 'edit' THEN 2 WHEN a.edit_verify_status = 'verify' THEN 1 ELSE 0 END) AS edit_id, b.modelid,b.vnumber,b.vyear,b.fueltype, c.model,d.category, a.* , md5( a.vehicle_con_id) as vehicle_con_idmd, DATE_FORMAT(a.add_date,'%d-%b-%Y') as add_date "; 
		    $from = ' pt_vehicle_services as a';
		    
		    $join[0]['table'] = "(SELECT vehicle_con_id, MAX(add_date) AS max_add_date FROM pt_vehicle_services GROUP BY vehicle_con_id ) latest_ent";
		    $join[0]['on'] = 'a.vehicle_con_id = latest_ent.vehicle_con_id AND a.add_date = latest_ent.max_add_date';
		    $join[0]['key'] =  $is_history ? 'LEFT' : 'INNER';
		    
		    $join[1]['table'] = 'pt_con_vehicle as b';
		    $join[1]['on'] = 'a.vehicle_con_id = b.id';
		    $join[1]['key'] = 'LEFT';

		    $join[2]['table'] = 'pt_vehicle_model as c';
		    $join[2]['on'] = 'b.modelid = c.id';
		    $join[2]['key'] = 'LEFT';
		   
		    $join[3]['table'] = 'pt_vehicle_cat as d';
		    $join[3]['on'] = 'c.catid = d.id';
		    $join[3]['key'] = 'LEFT';

		    
		    $orderby = $is_history ? 'a.add_date DESC' : 'a.add_date DESC';
		    
		    $where = [];
		    $where['a.catid'] = 1;
		    $where["b.status !='block'"] = NULL;
		    
		    if(!empty($post['vcid'])){
		     $where['md5(a.vehicle_con_id)'] = $post['vcid'];   
		    }
		    else if(!empty($post['vcid2'])){
		     $where['b.vnumber'] = trim($post['vcid2']);   
		    }
		    
		    
		     //set status
		    if( $post['status'] == 'verifypending'){
		       $where['a.edit_verify_status'] = 'edit'; 
		       $orderby = 'edit_id, a.edit_date ASC';
		    }
		    else if( $post['status'] == 'pending'){
		       $where['a.next_service_date <'] = date('Y-m-d'); 
		       $where['a.is_done'] = 0;
		    }
		    else if( $post['status'] == 'upcoming'){
		        $where['a.next_service_date >'] = date('Y-m-d');
		        $where['a.next_service_date <'] = date('Y-m-d', strtotime( date('Y-m-d').'+ 10 days'));
		        $where['a.is_done'] = 0;
		    } 
		    
            
            //echo json_encode($where);
            
            
            if( !empty($post['search']['value']) ) {  
                $serchStr = trim($post['search']['value']) ;
                $where[" ( b.vnumber LIKE '%".$serchStr."%' OR a.add_by_name LIKE '%".$serchStr."%' OR a.add_by_mobile LIKE '%".$serchStr."%' OR a.edit_by_name LIKE '%".$serchStr."%' OR a.edit_by_mobile LIKE '%".$serchStr."%' OR b.vyear LIKE '%".$serchStr."%' OR c.model LIKE '%".$serchStr."%' )"] = NULL;
                $limit = 100;
                $start = 0;
            }
            
            
            if( $is_count == 'yes' ){
                $select = 'a.id'; 
                $getdata = $this->c_model->joindata( $select, $where, $from, $join, null,null,null,null,$like,$likekey,$likeaction, null );   
                return !empty($getdata) ? count($getdata) : 0 ; 
            }else{
                 
                $getdata = $this->c_model->joindata( $select, $where, $from, $join, $groupby, $orderby, $limit, $in_not_in, $like, $likekey, $likeaction, $start );  
                if(!empty($getdata)){ krsort($getdata); }
                return $getdata; 
            }     
            
  } 
  

function getDataList(){

    $post = $_REQUEST;
    $get = $this->input->get(); 
    $post = array_merge($get,$post);
    
    $pageno = (int)( $post['start'] == 0 ? 1 : $post['length'] + 1 ); 
    $is_count = !empty($post['is_count']) ? $post['is_count'] : '';
    $totalRecords = !empty($post['recordstotal']) ? $post['recordstotal'] : 0; 
    $is_history = !empty($post['is_history']) ? $post['is_history'] : ''; 
    $status = !empty($post['status']) ? $post['status'] : ''; 
  
    $limit = (int)( !empty($_REQUEST['length']) ? $_REQUEST['length'] : 10 );
    $start = (int) !empty($_REQUEST['start'] ) ? $_REQUEST['start'] : 0; 
    
    

    if( $is_count == 'yes' ){
        echo $this->getRecordsFromDb( $post , null , null , $is_count, $is_history );  exit;
    }else{ 

       
    $result = [];
    $getdata = $this->getRecordsFromDb( $post , $limit , $start, $is_count, $is_history );
    if( !empty($getdata) ){
			$i = $start + 1;
			foreach ($getdata as $key => $value) {
				$push = [];
				$push =  $value;
				$push['sr_no'] = $i;
				$push['enc_id'] = md5($value['id']);
				$push['next_service_date'] = date('d-F-Y',strtotime($value['next_service_date']));
				$push['service_date'] = date('d-F-Y',strtotime($value['service_date']));
				$push['tyre_alignment_date'] = date('d-F-Y',strtotime($value['tyre_alignment_date']));
				$push['edit_date'] = date('d-F-Y h:i A',strtotime($value['edit_date']));
				$push['battery_date'] = !empty($value['battery_date']) && $value['battery_date'] != '0000-00-00' ? date('d-F-Y',strtotime($value['battery_date'])) : '';
				$push['battery_details'] = !empty($value['battery_details']) ? $value['battery_details'] : '';
				
				$lastEditRecord = $value['edit_verify_status'] == 'edit' ?  $this->db->query("select edited_field,previous_value,new_value from pt_vehicle_services_editing_log where table_id = '".$value['id']."'  AND DATE(edited_on) = '".date('Y-m-d',strtotime($value['edit_date']))."' GROUP BY edited_field ORDER BY id DESC  limit 10")->result_array() : [];
				$push['last_service_edit'] = ''; 
				$push['last_next_service_edit'] = '';
				$push['last_tyre_align_edit'] = ''; 
				$push['last_sr_amount_edit'] = ''; 
				if(!empty($lastEditRecord)){
				    foreach($lastEditRecord as $row ){
				        if( (int)$row['new_value'] != (int)$row['previous_value'] && in_array( trim($row['edited_field']),['service_date','service_km']) && empty($push['last_service_edit']) ){
				          $push['last_service_edit'] = $row['edited_field'];  
				        }
				        if( $row['new_value'] != $row['previous_value'] && in_array( trim($row['edited_field']),['service_date','service_km']) && empty($push['last_service_edit']) ){
				          $push['last_service_edit'] = $row['edited_field'];  
				        }
				        if( (int)$row['new_value'] != (int)$row['previous_value'] && in_array(trim($row['edited_field']),['next_service_date','next_service_km']) && empty($push['last_next_service_edit']) ){
				          $push['last_next_service_edit'] = $row['edited_field'];  
				        }
				        if( $row['new_value'] != $row['previous_value'] && in_array(trim($row['edited_field']),['next_service_date','next_service_km']) && empty($push['last_next_service_edit']) ){
				          $push['last_next_service_edit'] = $row['edited_field'];  
				        }
				        if( (int)$row['new_value'] != (int)$row['previous_value'] && in_array(trim($row['edited_field']),['tyre_alignment_date','tyre_alignment_km']) && empty($push['last_tyre_align_edit']) ){
				          $push['last_tyre_align_edit'] = $row['edited_field'];  
				        }
				        if( $row['new_value'] != $row['previous_value'] && in_array(trim($row['edited_field']),['tyre_alignment_date','tyre_alignment_km']) && empty($push['last_tyre_align_edit']) ){
				          $push['last_tyre_align_edit'] = $row['edited_field'];  
				        }
				        if( (int)$row['new_value'] != (int)$row['previous_value'] && in_array(trim($row['edited_field']),['sr_amount']) && empty($push['last_sr_amount_edit']) ){
				          $push['last_sr_amount_edit'] = $row['edited_field'];  
				        }
				    }
				}
				
				array_push($result, $push );
				$i++;
			}
	}
    
	$json_data = array();

	if( !empty($_REQUEST['search']['value']) ) { 
		$countItems = !empty($result) ? count( $result ) : 0; 
		$json_data['draw'] = intval( $_REQUEST['draw'] );
		$json_data['recordsTotal'] = intval( $countItems );
		$json_data['recordsFiltered'] =  intval( $countItems );
		$json_data['data'] = !empty($result) ? $result : [];  
	}else{ 
		$json_data['draw'] = intval( $_REQUEST['draw'] );
		$json_data['recordsTotal'] = intval($totalRecords );
		$json_data['recordsFiltered'] =  intval($totalRecords);
		$json_data['data'] = !empty($result) ? $result : [];  
	}       

    echo json_encode( $json_data );

    } 

}



	function exportCSV( $list ){
		    
		       // file name 
               $filename = 'All_Service_Details_'.date('Y-m-d').'.csv'; 
               header("Content-Description: File Transfer"); 
               header("Content-Disposition: attachment; filename=$filename"); 
               header("Content-Type: application/csv; ");
               
               $dformat = 'd-m-Y';
               
               
               // file creation 
               $file = fopen('php://output', 'w');
             
               $header = array("Sno","Vehicle Name","Vehicle Number","Fuel Type","Model Year","Service Details","Service Date","Service Kms","Next Service Date","Next Service Kms","Tyre & Alignment Date","Tyre & Alignment Km","Battey/Change Date","Battery Details","Total Amount","Database Entry Date" ,"Service Taken From"); 
               fputcsv($file, $header); $i=1;
               foreach ($list as $key=>$value){
                   $line = [];
                   $line[] = $i;
                   $line[] = $value['model'];
                   $line[] = $value['vnumber'];
                   $line[] = $value['fueltype'];
                   $line[] = $value['vyear']; 
                   $line[] = $value['service_details'];
                   $line[] = dateformat($value['service_date'],$dformat);
                   $line[] = (int)$value['service_km'];
                   $line[] = !empty($value['tyre_alignment_date']) ? dateformat($value['next_service_date'],$dformat) : '';
                   $line[] = (int)$value['next_service_km'];
                   $line[] = !empty($value['tyre_alignment_date']) ? dateformat($value['tyre_alignment_date'],$dformat) : '';
                   $line[] = (int)$value['tyre_alignment_km'];
                   $line[] = ($value['battery_date'] !='0000-00-00') ? dateformat($value['battery_date'],$dformat) : '';
                   $line[] = $value['battery_details'];
                   $line[] =  $value['amount'];
                   $line[] = dateformat($value['add_date'],$dformat);
                   $line[] =  $value['service_taken_from'];
                 fputcsv($file,$line); 
                 $i++;
               }
               fclose($file); 
               exit; 
   
		}
		

	 public function delete() { 
	 	    $table = 'pt_vehicle_services';
	        $getid = $this->input->get('delId') ? $this->input->get('delId') : array();
	        $vcid = $this->input->get('vcid') ? $this->input->get('vcid') : array();
	        $redirect = $this->input->get('redirect') ? $this->input->get('redirect') : '';
	        
	        $where['md5(id)'] = $getid; 
		    $status = $getid ? $this->c_model->delete( $table, $where ) : '';
		    
		    $message = $getid && $status ? 'Data Deleted Successfully' :'Some Error Occured';
		    $this->session->set_flashdata('error', $message ); 
		    
		    redirect( adminurl('vehicle_service_list_cab?vcid='.$vcid.'&status='.$redirect )  );
	    
   }  
   

}
?>