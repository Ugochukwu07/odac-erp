<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_d_list extends CI_Controller{
	 var $pagename;
     function __construct() {
         parent::__construct();  
	     adminlogincheck();
	     $this->pagename = 'vehicle_d_list';
     }	
	
	 
	public function index(){
	    
	        $is_export = $this->input->get('is_export');
	        $post = $this->input->get();
	        
	        
	        $get_vcid = $this->input->get('vcid');
	        $get_vcid2 = $this->input->get('vcid2'); 
		    
		    $data = [];
		    $data['title'] = 'Vehicle List';
		     
		     
		    //export csv report 
            if( !empty($is_export) ){
                $list = $this->getRecordsFromDb( $post );
		        $this->exportCSV( $list );
		    }
            
            
            $data['exporturl'] = adminurl('Vehicle_d_list?is_export=yes');
            
            
             //vehicle drop down list
            $keyExtraKey = 'vnumberdt';
            $select = "CONCAT(vnumber,',',(SELECT model FROM pt_vehicle_model WHERE id = modelid )) as vnumberdt"; 
            $where = [];
            $where["status"] = 'yes';
           // $where["modelid IN( SELECT id FROM pt_vehicle_model WHERE catid = '2' )"] = NULL;
            
            $data['vehiclelist'] = get_dropdownsmultitxt('pt_con_vehicle',$where,'md5(id)','vnumber',' Vehicle ---', $select, $keyExtraKey );
            
            
  
		    _viewlist( strtolower($this->pagename), $data ); 
		}


protected function getRecordsFromDb( $post , $limit = null , $start = null, $is_count = null ){
      
            $like = null;
            $likekey = null;
            $likeaction = null; 
		    
            
            $select = "DATE_FORMAT(a.edit_date,'%d-%b-%Y') as edit_dated, b.modelid,b.vnumber,b.vyear,b.fueltype, c.model,d.category, a.* , (CASE  WHEN a.edit_verify_status = 'edit' THEN 2 WHEN a.edit_verify_status = 'verify' THEN 1 ELSE 0 END) AS edit_id"; 
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

		    //$orderby = 'edit_id, a.edit_date ASC';
		    $orderby = 'a.edit_date DESC';
		    
		    $where = []; 
		    $where["b.status !='block'"] = NULL;
		    
		    if(!empty($post['vcid'])){
		     $where['md5(a.vehicle_con_id)'] = $post['vcid'];   
		    }
		    else if(!empty($post['vcid2'])){
		     $where['b.vnumber'] = trim($post['vcid2']);   
		    }
		    
		    //vehicle verification pending
		    if(!empty($post['status']) && $post['status']=='verifypending'){
		        $where['a.edit_verify_status'] = 'edit';
		    }
		     
            
            
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
                 
                if( !empty($getdata) && !empty($post['status']) && $post['status']=='verifypending'){
                    krsort($getdata); 
                }
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
  
    $limit = (int)( !empty($_REQUEST['length']) ? $_REQUEST['length'] : 10 );
    $start = (int) !empty($_REQUEST['start'] ) ? $_REQUEST['start'] : 0; 
    
    

    if( $is_count == 'yes' ){
        echo $this->getRecordsFromDb( $post , null , null , $is_count );  exit;
    }else{ 

       
    $result = [];
    $getdata = $this->getRecordsFromDb( $post , $limit , $start, $is_count );
    if( !empty($getdata) ){
			$i = $start + 1;
			foreach ($getdata as $key => $value) {
				$push = [];
				$push =  $value;
				$push['sr_no'] = $i;
				$push['enc_id'] = md5($value['id']);
				$push['white_permit_from'] = date('d-F-Y',strtotime($value['white_permit_from']));
				$push['white_permit_till'] = date('d-F-Y',strtotime($value['white_permit_till']));
				$push['permit_from'] = date('d-F-Y',strtotime($value['permit_from']));
				$push['permit_till'] = date('d-F-Y',strtotime($value['permit_till']));
				$push['tax_from'] = date('d-F-Y',strtotime($value['tax_from']));
				$push['tax_till'] = date('d-F-Y',strtotime($value['tax_till']));
				$push['fitness_from'] = date('d-F-Y',strtotime($value['fitness_from']));
				$push['fitness_till'] = date('d-F-Y',strtotime($value['fitness_till']));
				$push['insurence_from'] = date('d-F-Y',strtotime($value['insurence_from']));
				$push['insurence_till'] = date('d-F-Y',strtotime($value['insurence_till']));
				$push['polution_from'] = date('d-F-Y',strtotime($value['polution_from']));
				$push['polution_till'] = date('d-F-Y',strtotime($value['polution_till'])); 
				$push['payment_date'] = $value['payment_date']!='0000-00-00' ? date('d-F-Y',strtotime($value['payment_date'])) : ''; 
			  
				
				 $last_wpermit_edit = ''; 
				 $last_permit_edit = ''; 
				 $last_tax_edit = ''; 
				 $last_fitness_edit = ''; 
				 $last_insurence_edit = ''; 
				 $last_polution_edit = ''; 
				 $last_policy_no_edit = '';  
				 $last_insu_company_name_edit = ''; 
				 
				if(!empty($value['last_activity'])){
				    $lastEditRecord = json_decode($value['last_activity'],true);
				     foreach( $lastEditRecord as $row ){
				        if( in_array( trim($row),['white_permit_till','white_permit_from']) ){
				          $last_wpermit_edit .= $row.',';  
				        }
				        if(in_array( trim($row),['permit_from','permit_till']) ){
				          $last_permit_edit .= $row.',';   
				        }
				        if( in_array(trim($row),['tax_from','tax_till']) && empty($push['last_tax_edit']) ){
				          $last_tax_edit .= $row.',';   
				        }
				        if( in_array(trim($row),['fitness_from','fitness_till']) ){
				          $last_fitness_edit .= $row.',';   
				        }
				        if( in_array(trim($row),['insurence_from','insurence_till']) ){
				          $last_insurence_edit .= $row.','; 
				        }
				        if( in_array(trim($row),['polution_from','polution_till']) ){
				          $last_polution_edit .= $row.','; 
				        }
				        if( in_array(trim($row),['policy_no'])  ){
				          $last_policy_no_edit .= $row.',';  
				        }
				        if( in_array(trim($row),['insu_company_name']) ){
				          $last_insu_company_name_edit .= $row.',';  
				        }
				    }
				}
				
				$push['last_wpermit_edit'] = $last_wpermit_edit; 
				$push['last_permit_edit'] = $last_permit_edit;
				$push['last_tax_edit'] = $last_tax_edit; 
				$push['last_fitness_edit'] = $last_fitness_edit; 
				$push['last_insurence_edit'] = $last_insurence_edit; 
				$push['last_polution_edit'] = $last_polution_edit; 
				$push['last_policy_no_edit'] = $last_policy_no_edit;
				$push['last_insu_company_name_edit'] = $last_insu_company_name_edit;
				
				
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
               $filename = 'All_Documents_'.date('Y-m-d').'.csv'; 
               header("Content-Description: File Transfer"); 
               header("Content-Disposition: attachment; filename=$filename"); 
               header("Content-Type: application/csv; ");
               
               $dformat = 'd-m-Y';
               
               
               // file creation 
               $file = fopen('php://output', 'w');
             
               $header = array("Sno","Vehicle Name","Vehicle Number","Fuel Type","Model Year","White Pemit From","White Pemit To Date","Permit From Date","Permit To Date","Tax From Date","Tax To Date","Fitness From Date","Fitness To Date","Insurence From Date","Insurence To Date","Pollution From Date","Pollution To Date" ); 
               fputcsv($file, $header); $i=1;
               foreach ($list as $key=>$value){
                   $line = [];
                   $line[] = $i;
                   $line[] = $value['model'];
                   $line[] = $value['vnumber'];
                   $line[] = $value['fueltype'];
                   $line[] = $value['vyear']; 
                   $line[] = dateformat($value['white_permit_from'], $dformat );
                   $line[] = dateformat($value['white_permit_till'],$dformat);
                   $line[] = dateformat($value['permit_from'],$dformat);
                   $line[] = dateformat($value['permit_till'],$dformat);
                   $line[] = dateformat($value['tax_from'],$dformat);
                   $line[] = dateformat($value['tax_till'],$dformat);
                   $line[] = dateformat($value['fitness_from'], $dformat);
                   $line[] = dateformat($value['fitness_till'],$dformat);
                   $line[] = dateformat($value['insurence_from'],$dformat);
                   $line[] = dateformat($value['insurence_till'],$dformat);
                   $line[] = dateformat($value['polution_from'],$dformat);
                   $line[] = dateformat($value['polution_till'],$dformat);
                 fputcsv($file,$line); 
                 $i++;
               }
               fclose($file); 
               exit; 
   
		}
		

	 public function delete() { 
	 	    $table = 'pt_vehicle_details';
	        $getid = $this->input->get() ? $this->input->get('delId') : array();  
	        $where['md5(id)'] = $getid; 
		    $status = $getid ? $this->c_model->delete( $table, $where ) : '';
		    $message = $getid && $status ? 'Data Deleted Successfully' :'Some Error Occured';
		    $this->session->set_flashdata('error', $message ); 
		    redirect( adminurl('vehicle_d_list'));
	    
   }  
   

}
?>