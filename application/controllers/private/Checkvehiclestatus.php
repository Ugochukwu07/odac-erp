<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Checkvehiclestatus extends CI_Controller{
	  var $pagename;
      var $table;
	  function __construct() {
         parent::__construct(); 
		  adminlogincheck();
		  $this->pagename = 'checkvehiclestatus';
		  $this->table = 'pt_booking';
		  $this->load->helper('slip');
      }
	


  public function index() {

			$data = [];
			$output = []; 
		 

	        $title = 'Vehicle Status';
	        $data['title'] = $title;
	        $data['exporturl'] = '';
	        $data['list'] = [];
			$data['totalrows'] = 0;
	        $get = $this->input->get();  

			 
			$where = []; 
			   
			$type = $get['type'];
			$cat_id = $get['catid'];
			$f =  !empty($post['f'])?trim($post['f']):false; 
            $veh =  !empty($post['veh'])?trim($post['veh']):false; 
            
			$data['type'] = $get['type']; 
			$data['catid'] = $get['catid'];  
            $data['f'] = $f; 
            $data['veh'] = $veh;
			
			//check csv report key
			$is_csv_export = !empty($get['csv_report']) ? $get['csv_report'] : false ;
			$data['exporturl'] = base_url('private/'.strtolower($this->pagename).'?type='.$type.'&csv_report=yes&veh='.$veh.'&f='.$f.'&catid='.$cat_id );  
              

	        
            
              
                //cars management
                $total_items_list = $this->db->query("select a.id,a.vnumber,b.model,b.catid from pt_con_vehicle as a inner join pt_vehicle_model as b on a.modelid = b.id where b.catid = '".$cat_id."' AND a.status = 'yes' ")->result_array();
                $data['total_items'] = !empty($total_items_list) ? count($total_items_list) : 0; 
                
                $inclauseList = '';
                if(!empty($total_items_list)){
                    foreach($total_items_list as $key=>$value ){
                        $inclauseList .= "'".$value['vnumber']."',";
                    }
                    $inclauseList = rtrim($inclauseList, ',' );
                }
               
                //************ count hold items ******************//
                $whereHoldCars = [];
                $whereHoldCars['attemptstatus'] = 'approved'; 
                $whereHoldCars['DATE(dropdatetime) <'] = date('Y-m-d');
                $whereHoldCars['vehicleno !='] = '';
                if( $type == 'car'){
                    $whereHoldCars["triptype IN('selfdrive','monthly')"] = NULL; 
                }else{
                    $whereHoldCars['triptype'] = 'bike';
                }
                $hold_items_list = $this->c_model->getfilter('pt_booking', $whereHoldCars,null,null, null,null,null,null,null,null,'get',null,null, 'vehicleno,bookingid,pickupdatetime,dropdatetime' );
                $data['hold_items'] = !empty($hold_items_list) ? count($hold_items_list) : 0; 
                
                //************ count Running items ******************//
                $whereRun = [];
                $whereRun['attemptstatus'] = 'approved';
                $whereRun['DATE(pickupdatetime) <='] = date('Y-m-d');
                $whereRun['DATE(dropdatetime) >='] = date('Y-m-d');
                $whereRun['vehicleno !='] = '';
                if( $type == 'car'){
                    $whereRun["triptype IN('selfdrive','monthly')"] = NULL; 
                }else{
                    $whereRun['triptype'] = 'bike';
                }
                
                $whereRun[" vehicleno IN(".$inclauseList.")"] = NULL;
                 
                $runing_items_list = $this->c_model->getfilter('pt_booking', $whereRun,null,null, null,null,null,null,null,null,'get',null,null, 'vehicleno,bookingid,pickupdatetime,dropdatetime' );
                $data['runing_items'] = !empty($runing_items_list) ? count($runing_items_list) : 0;  
                
                
                //************ count free items ******************//
                $data['free_items'] = $data['total_items'] - $data['hold_items'] - $data['runing_items']; 
                
                $listItems = [];
                $testt = '';
                
                if(!empty($total_items_list)){
                
                foreach($total_items_list as $key=>$value ){
                    $push = [];
                    $push = $value;
                    $push['status'] = 'Free';
                    $push['bookingid'] = '';
                    $push['pickup'] = '';
                    $push['drop'] = '';
                    $push['sorting'] = 1;
                    
                    if(!empty($hold_items_list)){
                        foreach($hold_items_list as $key=>$hvalue ){ 
                            if( strtolower( trim($value['vnumber'])) == strtolower( trim($hvalue['vehicleno'])) ){
                              $push['status'] = 'Hold'; 
                              $push['bookingid'] = $hvalue['bookingid'];
                              $push['pickup'] = date('d M Y, h:i A',strtotime($hvalue['pickupdatetime']));
                              $push['drop'] = date('d M Y, h:i A',strtotime($hvalue['dropdatetime']));
                              $push['sorting'] = 2;
                            } 
                        }
                    } 
                    
                    if(!empty($runing_items_list)){
                        foreach($runing_items_list as $key=>$runvalue ){ 
                            if( strtolower( trim($value['vnumber'])) == strtolower( trim($runvalue['vehicleno'])) ){
                              $push['status'] = 'Running'; 
                              $push['bookingid'] = $runvalue['bookingid'];
                              $push['pickup'] = date('d M Y, h:i A',strtotime($runvalue['pickupdatetime']));
                              $push['drop'] = date('d M Y, h:i A',strtotime($runvalue['dropdatetime']));
                              $push['sorting'] = 3;
                            } 
                        }
                    } 
                   array_push( $listItems, $push ); 
                    
                }
              
              
                  usort( $listItems,'msorting');
              }
              
              $data['list'] = $listItems;
              
              $data['title'] = $title .' &nbsp; [ <span style="font-size:12px;color:red">   Total Records: <span id="totalBookings">'.$data['total_items'].'</span> </span>]';   
			
                
                
                
                if(!empty($is_csv_export)){   
                   $this->exportCSV( $listItems,$type );
                }
                 
                
               
	        _viewlist( strtolower($this->pagename), $data );  
   }
   
   
   
 
   
   //Export CSV Files
   
   	function exportCSV( $list,$type ){
		    
		       // file name 
               $filename = ucwords($type).'_'.date('Y-m-d').'.csv'; 
               header("Content-Description: File Transfer"); 
               header("Content-Disposition: attachment; filename=$filename"); 
               header("Content-Type: application/csv; ");
               
               
               // file creation 
               $file = fopen('php://output', 'w');
             
               $header = array("Sno","Model Name","Vehicle No","Status","Booking ID","Pickup Date","Drop Date"); 
               fputcsv($file, $header); $i=1;
               $totalAmount = 0;
               $totalBookingAmount = 0;
               $totalRestAmount = 0;
               foreach ($list as $key=>$value){
                   $line = [];
                   $line['sno'] = $i;
                   $line['model'] = ucwords( $value['model'] );
                   $line['vnumber'] = $value['vnumber'];
                   $line['status'] = $value['status'];
                   $line['bookingid'] = $value['bookingid'];
                   $line['pickup'] = $value['pickup'];
                   $line['drop'] = $value['drop']; 
                   
               
                 fputcsv($file,$line); 
                 $i++;
               }
               
               
               
               fclose($file); 
               exit; 
   
		}
		
		 

}
?>