<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_doc_expires extends CI_Controller{
	 var $pagename;
	 public $input;
	 public $c_model;
	 public $db;
     function __construct() {
         parent::__construct();  
	     adminlogincheck();
	     $this->pagename = 'vehicle_doc_expires';
     }	
	
	 
	public function index(){
	    
	        $type = $this->input->get('type') ? $this->input->get('type') : '' ;
	        $is_count = $this->input->get('is_count') ? $this->input->get('is_count') : '' ;
	        $is_export = $this->input->get('is_export')  ? $this->input->get('is_export') : '' ;
	        
	        $get_vcid = $this->input->get('vcid')  ? $this->input->get('vcid') : '' ;
	        $get_vcid2 =  $this->input->get('vcid2')  ? $this->input->get('vcid2') : '' ;
	        
	        
	        $keyname = '';
	        $heading = $type;
	        if( $type == 'white'){ $keyname = 'white_permit_till';  $heading = 'White Permit'; }
	        else if( $type == 'permit'){ $keyname = 'permit_till'; }
	        else if( $type == 'tax'){ $keyname = 'tax_till'; }
	        else if( $type == 'fitness'){ $keyname = 'fitness_till'; }
	        else if( $type == 'insurence'){ $keyname = 'insurence_till'; }
	        else if( $type == 'pollution'){ $keyname = 'polution_till'; }

		    $data['title'] = 'Vehicle Expire Doc List';
		    $data['type'] = $type;
		    $data['redirect'] = $type;
		    $data['keyname'] = $keyname;
		    $data['tblheading'] = ucwords( $heading );
		    
		    if($is_count=='yes'){
		        $select = "a.id";
		        $orderby = '';
		    }else{
		     $select = "(CASE  WHEN a.edit_verify_status = 'edit' THEN 2 WHEN a.edit_verify_status = 'verify' THEN 1 ELSE 0 END) AS edit_id, a.add_by_mobile,a.add_by_name,a.edit_by_mobile,a.edit_by_name,a.edit_verify_status,b.modelid,b.vnumber,b.vyear,b.fueltype, c.model,d.category, a.id, a.vehicle_con_id, a.policy_no, a.edit_date, a.insu_company_name, a.".$keyname ; 
		     $orderby = 'edit_id, edit_date DESC'; 
		    }
		    $from = ' pt_vehicle_details as a';
		    
		    $join[0]['table'] = 'pt_con_vehicle as b';
		    $join[0]['on'] = 'a.vehicle_con_id = b.id';
		    $join[0]['key'] = 'LEFT';
 
		    $join[1]['table'] = 'pt_vehicle_model as c';
		    $join[1]['on'] = 'b.modelid = c.id';
		    $join[1]['key'] = 'LEFT';
		   
		    $join[2]['table'] = 'pt_vehicle_cat as d';
		    $join[2]['on'] = 'c.catid = d.id';
		    $join[2]['key'] = 'LEFT';

		    $today = date('Y-m-d');
		    $nexttendaysdate = date('Y-m-d', strtotime( $today.' +10 days') );
		    $where = [];
		    $where[' DATE(a.'.$keyname.' ) <='] = $nexttendaysdate; 
		    
		    $where["b.status !='block'"] = NULL; 
	        
	        
	        if(!empty($get_vcid)){
		        $where['md5(b.id)'] = trim($get_vcid);   
		    }
		    else if(!empty($get_vcid2)){
		        $where['b.vnumber'] = trim($get_vcid2);   
		    }
		    
		    

		    $listDocs = $this->c_model->joindata( $select, $where, $from, $join, null,$orderby );
		    //echo $this->db->last_query(); exit;
		    $list = [];
		    if(!empty($listDocs)){ 
		        krsort($listDocs);  
		        foreach( $listDocs as $key=>$value ){
		        $push = [];
		        $push = $value;  
		         
		        $lastEditRecord = !empty($value['edit_verify_status']) && $value['edit_verify_status'] == 'edit' ? $this->db->query("select edited_field,previous_value,new_value from pt_vehicle_details_editing_log where table_id = '".$value['id']."' AND DATE(edited_on) = '".date('Y-m-d',strtotime($value['edit_date']))."' GROUP BY edited_field ORDER BY id  limit 10")->result_array() : [];
				$push['last_edit'] = '';
				$last_edit = '';
				if(!empty($lastEditRecord)){
				    foreach($lastEditRecord as $row ){
				        if( $row['new_value'] != $row['previous_value'] && in_array( trim($row['edited_field']),['white_permit_till','white_permit_from']) ){
				          $last_edit .= $row['edited_field'].', ';  
				        }
				        if( $row['new_value'] != $row['previous_value'] && in_array( trim($row['edited_field']),['permit_from','permit_till']) ){ 
				          $last_edit .= $row['edited_field'].', '; 
				        }
				        if( $row['new_value'] != $row['previous_value'] && in_array(trim($row['edited_field']),['tax_from','tax_till']) ){
				          $last_edit .= $row['edited_field'].', ';   
				        }
				        if( $row['new_value'] != $row['previous_value'] && in_array(trim($row['edited_field']),['fitness_from','fitness_till'])  ){
				          $last_edit .= $row['edited_field'].', ';  
				        }
				        if( $row['new_value'] != $row['previous_value'] && in_array(trim($row['edited_field']),['insurence_from','insurence_till']) ){
				          $last_edit .= $row['edited_field'].', ';  
				        }
				        if( $row['new_value'] != $row['previous_value'] && in_array(trim($row['edited_field']),['polution_from','polution_till'])  ){
				          $last_edit .= $row['edited_field'].', ';  
				        }
				        if( $row['new_value'] != $row['previous_value'] && in_array(trim($row['edited_field']),['policy_no'])  ){
				          $last_edit .= $row['edited_field'].', ';   
				        }
				        if( $row['new_value'] != $row['previous_value'] && in_array(trim($row['edited_field']),['insu_company_name'])   ){
				          $last_edit .= $row['edited_field'].', ';   
				        }
				    }
				}
				$push['last_edit'] = $last_edit;  
				array_push($list, $push );
		    }
		    }
		    
		    $data['list'] = $list;
		    if($is_count=='yes'){
		        echo !empty($listDocs) ? count($listDocs) : 0;
		        exit;
		    }
		    
		    if( !empty($is_export) ){
		        $this->exportCSV( $listDocs , $heading, $keyname );
		    }
		    
		  //  echo '<pre>';
		  //  print_r( $data['list'] );
		  //  exit;
		  
		  $data['exporturl'] = adminurl('Vehicle_doc_expires?type='.$type.'&is_export=yes');
		  
		  
		    //vehicle drop down list
            $keyExtraKey = 'vnumberdt';
            $select = "CONCAT(vnumber,',',(SELECT model FROM pt_vehicle_model WHERE id = modelid )) as vnumberdt"; 
            $where = [];
            $where["status"] = 'yes';
           // $where["modelid IN( SELECT id FROM pt_vehicle_model WHERE catid = '2' )"] = NULL;
            
            $data['vehiclelist'] = get_dropdownsmultitxt('pt_con_vehicle',$where,'md5(id)','vnumber',' Vehicle ---', $select, $keyExtraKey );
            
  
		    _viewlist( strtolower($this->pagename), $data ); 
		}
		
		
		
		
		function exportCSV( $list , $heading, $keyname ){
		    
		       // file name 
               $filename = $heading.'_'.date('Ymd').'.csv'; 
               header("Content-Description: File Transfer"); 
               header("Content-Disposition: attachment; filename=$filename"); 
               header("Content-Type: application/csv; ");
               
               
               // file creation 
               $file = fopen('php://output', 'w');
               
               $policy_no_head = false; 
              
             
               $header = [];
               $header[] = 'Sno';
               $header[] = 'Vehicle Name';
               $header[] = 'Vehicle Number';
               $header[] = 'Fuel Type';
               $header[] = 'Model Year';
               $header[] =   ucwords($heading).' Expire Date';
               
               if( $heading == 'insurence'){
                   $header[] =  'Policy No';
                   $header[] =  'Insurance Company Name';
                   $policy_no_head = true; 
               }
               
               
               fputcsv($file, $header); $i=1;
               foreach ($list as $key=>$value){
                   $line = [];
                   $line['sno'] = $i;
                   $line['model'] = $value['model'];
                   $line['vnumber'] = $value['vnumber'];
                   $line['fueltype'] = $value['fueltype'];
                   $line['vyear'] = $value['vyear'];
                   $line[$keyname] = $value[$keyname];
                   if( $policy_no_head  ){
                        $line['policy_no'] = $value['policy_no'];
                        $line['insu_company_name'] = $value['insu_company_name'];
                   }
                 fputcsv($file,$line); 
                 $i++;
               }
               fclose($file); 
               exit; 
   
		}


}
?>