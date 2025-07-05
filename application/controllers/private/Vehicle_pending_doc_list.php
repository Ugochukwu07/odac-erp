<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_pending_doc_list extends CI_Controller{
	
     function __construct() {
         parent::__construct();  
	     adminlogincheck();
     }	
	
	 
	public function index(){
	    
	        $is_count = $this->input->get('is_count'); 
	        $is_export = $this->input->get('is_export');
	        $get_vcid = trim( $this->input->get('vcid') );
	        $get_vcid2 = trim( $this->input->get('vcid2') );

		    $data['title'] = 'Pending Document List';
		    if($is_count =='yes'){
		        $select = 'b.model, b.catid, a.* ,c.category';
		    }else{
		        $select = 'b.model, b.catid, a.* ,c.category'; 
		    }
		    $from = 'pt_con_vehicle as a';

		    $join[0]['table'] = 'pt_vehicle_model as b';
		    $join[0]['on'] = 'a.modelid = b.id';
		    $join[0]['key'] = 'LEFT';
		    $join[1]['table'] = 'pt_vehicle_cat as c';
		    $join[1]['on'] = 'b.catid = c.id';
		    $join[1]['key'] = 'LEFT';

		    $orderby = 'b.model ASC';
		    $where = [];
		    
		    $where["a.status != 'block'"] = NULL;  
		    
		    if(!empty($get_vcid)){
		     $where['md5(a.id)'] = trim($get_vcid);   
		    }
		    else if(!empty($get_vcid2)){
		     $where['a.vnumber'] = trim($get_vcid2);   
		    }
		    
		    $where["a.id NOT IN(select vehicle_con_id from pt_vehicle_details)"] = NULL;

		    $list = $this->c_model->joindata( $select,$where, $from, $join, null,$orderby );
		     
            $data['list'] = $list;
            
            
            if($is_count =='yes'){
                echo !empty($data['list']) ? count($data['list']) : 0;
                exit;
            }
            
            //export csv report 
            if( !empty($is_export) ){
		        $this->exportCSV( $list );
		    }
            
            
            $data['exporturl'] = adminurl('Vehicle_pending_doc_list?is_export=yes');
            
            
            //vehicle drop down list
            $keyExtraKey = 'vnumberdt';
            $select = "CONCAT(vnumber,',',(SELECT model FROM pt_vehicle_model WHERE id = modelid )) as vnumberdt"; 
            $where = [];
            $where["status"] = 'yes';
           // $where["modelid IN( SELECT id FROM pt_vehicle_model WHERE catid = '2' )"] = NULL;
            
            $data['vehiclelist'] = get_dropdownsmultitxt('pt_con_vehicle',$where,'md5(id)','vnumber',' Vehicle ---', $select, $keyExtraKey );
            
            
            
		    _viewlist( 'vehicle_pending_doc_list', $data ); 
		}



		
		function exportCSV( $list ){
		    
		       // file name 
               $filename = 'Document_Pending_'.date('Y-m-d').'.csv'; 
               header("Content-Description: File Transfer"); 
               header("Content-Disposition: attachment; filename=$filename"); 
               header("Content-Type: application/csv; ");
               
               
               // file creation 
               $file = fopen('php://output', 'w');
             
               $header = array("Sno","Vehicle Name","Vehicle Number","Fuel Type","Model Year" ); 
               fputcsv($file, $header); $i=1;
               foreach ($list as $key=>$value){
                   $line = [];
                   $line['sno'] = $i;
                   $line['model'] = $value['model'];
                   $line['vnumber'] = $value['vnumber'];
                   $line['fueltype'] = $value['fueltype'];
                   $line['vyear'] = $value['vyear']; 
                 fputcsv($file,$line); 
                 $i++;
               }
               fclose($file); 
               exit; 
   
		}
		
		
 
}
?>