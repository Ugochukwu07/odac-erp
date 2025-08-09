<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_business_report extends CI_Controller{
	  var $pagename;
      var $table;
	  function __construct() {
         parent::__construct(); 
		  adminlogincheck();
		  $this->pagename = 'vehicle_business_report';
		  $this->table = 'pt_booking'; 
      }
	


  public function index() {

			$data = []; 
		 
	        $title = 'Vehicle Business Report';
	        $data['title'] = $title;
	        $data['exporturl'] = '';
	        $data['list'] = [];
	        
	        $post = !empty($this->input->post()) ? $this->input->post() : $this->input->get();  
            
            $from = !empty($post['from'])?trim($post['from']):'';
            $to = !empty($post['to'])?trim($post['to']):'';
            $vehicle_no = !empty($post['vehicle_no'])?trim($post['vehicle_no']):'';
            $type = !empty($post['type'])?trim($post['type']):'';
            
            $data['from'] = $from;
            $data['to'] = $to;
            $data['vehicle_no'] = $vehicle_no; 
            $data['type'] = $type; 
			
			//check csv report key
			$is_csv_export = !empty($post['csv_report']) ? $post['csv_report'] : false ;
			$data['exporturl'] = base_url('private/'.strtolower($this->pagename).'?from='.$from.'&to='.$to.'&vehicle_no='.$vehicle_no.'&csv_report=yes' ); 
 
  
	        $data['title'] = $title .' &nbsp; [ <span style="font-size:12px;color:red"> Export Report : <span id="totalBookings">0</span> </span>]';  
	        
	        
			
			//get vehicle list
            $vehicleList = $this->getVehicleList( $type,'yes' );
            $data['vehicle_list'] = $vehicleList;
            
            // echo '<pre>';
            // print_r($vehicleList); //exit; 
            
            //prepare query and collect data from db
            $collectRowsData = [];
            if(!empty($post)){
                    $getBookingData = !empty($post) ? $this->getRecordsFromDb( $post ) : [];  
                    
                    $dateRangeList = generateDateRangeFromDates( $post['from'],$post['to']);  
                    $totalDays = !empty($dateRangeList) ? sizeof($dateRangeList) : 0;
                    
                    //Create Headers
                    $vehicleNoMainList = [];
                    $vehicleNoList = [];
                    if(!empty($vehicleList)){
                        $vehicleNoList[] = 'Date';
                        foreach($vehicleList as $key=>$value ){
                            if(!empty($key)){
                                if( !empty($vehicle_no) ){
                                    if( $vehicle_no == $key ){ 
                                        $vehicleNoList[] = $key;
                                        $vehicleNoMainList[] = $key;
                                    }
                                }else{ 
                                     $vehicleNoList[] = $key;
                                     $vehicleNoMainList[] = $key;
                                } 
                            } 
                        }
                        $vehicleNoList[] = 'Total';
                    }
                    
                    //maintain header
                    array_push( $collectRowsData, $vehicleNoList ); 
                    
                    
                    
                    //collect booking data from booking list
                    
                    $totalSumAMount = 0;
                    //collect datevise rows 
                    foreach($dateRangeList as $date ){
                            $push = [];
                            $push[] = $date;
                            $totalOfRow = 0; 
                            foreach ($vehicleNoMainList as $vehicle) {
                                $matchValue = 0;
                                if(!empty($getBookingData)){ 
                                    foreach($getBookingData as $key=>$value){ 
                                        if( trim($value['vehicleno']) == trim($vehicle) && strtotime($value['pickupdates']) <= strtotime($date) && strtotime($value['dropdates']) >= strtotime($date) ){
                                           $matchValue = $value['vehicle_price_per_unit'];  
                                        } 
                                    } 
                                } 
                                $push[] = $matchValue;
                                $totalOfRow += $matchValue;
                                $totalSumAMount += $matchValue;
                            }
                            $push[] = $totalOfRow; 
                            array_push($collectRowsData,$push);
                            
                    }
                    
                    //print_r( $vehicleNoList ); //exit;
                    $newVehicleBusinessList = [];
                    //collect columns data for above result
                    if(!empty($vehicleNoList)){ 
                         
                        $collectFinalPrice = [];
                        foreach($vehicleNoList as $key=>$rows ){ 
                             
                            $totalOfColumn = '';
                             if( !in_array($rows,['Total','Date'])  ){
                                 $totalOfColumn = 0;
                                    foreach($collectRowsData as $collectIndex=>$rowValue ){
                                              if( $collectIndex > 0){
                                                 foreach( $rowValue as $index=>$value ){ 
                                                     if( !in_array( trim($value),['Date','Total']) && $index == $key ){
                                                         $totalOfColumn += (float)$value;
                                                     }
                                                 }
                                              }
                                              
                                    }  
                                
                                $push = [];
                                $push['vehicle_no'] = $rows;
                                $push['total'] = $totalOfColumn;
                                $push['sorting'] = (float) $totalOfColumn;
                                $push['vehicle_name'] = '';
                                //find vehicle name 
                                foreach($vehicleList as $key=>$vValue){
                                    
                                    if( $key == $rows ){
                                        $explodeArry = explode($rows, $vValue ); 
                                        $push['vehicle_name'] = !empty($explodeArry[1]) ? ltrim($explodeArry[1],', ') : '' ; break;
                                    }
                                }
                                
                                array_push( $newVehicleBusinessList , $push );    
                             }   
                        } 
                    } 
            
            }
            
            
            
            if(!empty($newVehicleBusinessList)){
                usort( $newVehicleBusinessList, 'incomeSorting'); 
            }
            
            // echo '<pre>';
            // print_r( $newVehicleBusinessList ); exit; 
            
            
            
            if( $is_csv_export == 'yes' && !empty($newVehicleBusinessList) ){ 
                    $this->exportReport( $newVehicleBusinessList ); exit;
            }else{
                $data['list'] = $newVehicleBusinessList;
            } 
             
			 
	        _viewlist( 'report/'.strtolower($this->pagename), $data );  
   }
   
   

  protected function getRecordsFromDb( $post , $limit = null , $start = null, $is_count = null ){
      
        	$where = []; 
            $like = null;
            $likekey = null;
            $likeaction = null;  
            
             
            $where["attemptstatus NOT IN('temp','cancel','reject')"] = NULL; 
             
            
            if(!empty($post['vehicle_no'])){ 
             $where['vehicleno'] = $post['vehicle_no'];	
            }  
             
            
            if( !empty($post['from']) && !empty($post['to']) ){
            $where['DATE(pickupdatetime) >='] = date('Y-m-d',strtotime($post['from'].' -3 months'));
            $where['DATE(dropdatetime) <='] = date('Y-m-d',strtotime($post['to'].' +3 months'));
            }
            /*filter script start here*/
            
            
            $select = 'vehicle_price_per_unit,vehicleno,driverdays, DATE(pickupdatetime) as pickupdates, DATE(dropdatetime) as dropdates   ';
            $from = 'pt_booking as a'; 
            
            
            $groupby  = null;
            $orderby = 'pickupdatetime ASC'; 
             
            
            $in_not_in = null; 
            $join = null;
            
            //echo json_encode($where); 
                 
            $getdata = $this->c_model->joindata( $select, $where, $from, $join, $groupby, $orderby, $limit, $in_not_in, $like, $likekey, $likeaction, $start ); 
           //echo $this->db->last_query($getdata); exit;
            return $getdata; 
               
            
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
  
 
  
   
   //Export CSV Files
   
   	function exportReport( $listData ){
		    
		       
               $filename = 'Vehicle_Business_Report_'.date('Y-m-d').'.csv'; 
               header("Content-Description: File Transfer"); 
               header("Content-Disposition: attachment; filename=$filename"); 
               header("Content-Type: application/csv; ");
               
               
               // file creation 
               $file = fopen('php://output', 'w');
             
               $header = array("Sno","Vehicle No","Vehicle Name","Total" ); 
               fputcsv($file, $header); $i=1;
                
               $totalAmount = 0;    
               foreach ($listData as $key=>$value){
                   $line = [];
                   $line['sno'] = $i;
                   $line['vehicle_no'] = $value['vehicle_no'];
                   $line['vehicle_name'] = $value['vehicle_name'];
                   $line['total'] = $value['total']; 
                   $totalAmount += $value['total'];
                 fputcsv($file,$line); 
                 $i++;
               }
               
               $footer = array("","","Total Amount: ", $totalAmount ); 
               fputcsv($file, $footer);
               
               fclose($file); 
               exit; 
   
		}
		
		
	public function getEditLog(){
		    $id = $this->input->post('id');
		    $getData = $this->db->query('SELECT *  FROM pt_booking_editing_log WHERE booking_id = '.$id.' ')->result_array();
	
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
                $html .= '<div class="col-lg-2">'.$value['edited_field'].'</div>';
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
	    $this->c_model->saveupdate('pt_booking',['edit_verify_status'=>'verify'],null, ['id'=>$id]);
	    }
	    
	    echo true;
	}
	
	
	/*********************** send email ***************************/
	function reSendMailSms(){
    
        $loginUser = $this->session->userdata('adminloginstatus');  
        $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
        $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
        $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';


	    $post = $this->input->post();
	    $id = !empty($post['id']) ? $post['id'] : '';
	    if(!empty($id)){
	        $saveEditLog = ['booking_id'=>$id,'edited_field'=>'activity','new_value'=>'Sent SMS Mail','previous_value'=>'Sent SMS Mail','edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
	        $this->db->insert('pt_booking_editing_log', $saveEditLog );
	         
            $keys = ' * ';
            $getdata = $this->c_model->getSingle('booking',['id'=>$id],'*'); 
            $save = [];
            $save['crontab'] = 1;   
            $where['id'] = $id; 
            $update = $this->c_model->saveupdate('booking', $save, null, $where );  
            $sms = shootsms($getdata,'new');  
            $htmlmail = bookingslip($getdata,'mail');
            echo true;
	    }
	    echo false;
    }
    
    function getVehicleList( $inputtype = null, $is_list = null ){
        
            $type = !empty($inputtype) ? $inputtype : $this->input->post('type');
            
            $where = null;
            if( $type == 'active' ){
               $where = [];
               $where['status'] = 'yes'; 
            }
            else if( $type == 'block' ){
               $where = [];
               $where['status'] = 'block'; 
            }
            else if( $type == 'car' ){
               $where = [];
               $where["modelid IN (SELECT id FROM `pt_vehicle_model` WHERE  catid = '1')"] = NULL; 
            }
            else if( $type == 'activecar' ){
               $where = [];
               $where["modelid IN (SELECT id FROM `pt_vehicle_model` WHERE  catid = '1')"] = NULL;
               $where['status'] = 'yes'; 
            }
            else if( $type == 'blockedcars' ){
               $where = [];
               $where["modelid IN (SELECT id FROM `pt_vehicle_model` WHERE  catid = '1')"] = NULL;
               $where['status'] = 'block'; 
            }
            else if( $type == 'bike' ){
               $where = [];
               $where["modelid IN (SELECT id FROM `pt_vehicle_model` WHERE  catid = '2')"] = NULL; 
            }
            else if( $type == 'activebike' ){
               $where = [];
               $where["modelid IN (SELECT id FROM `pt_vehicle_model` WHERE  catid = '2')"] = NULL; 
               $where['status'] = 'yes'; 
            }
            else if( $type == 'blockedbike' ){
               $where = [];
               $where["modelid IN (SELECT id FROM `pt_vehicle_model` WHERE  catid = '2')"] = NULL; 
               $where['status'] = 'block'; 
            }
        
            $keyExtraKey = 'vnumberdt';
            $select = "CONCAT(vnumber,',',(SELECT model FROM pt_vehicle_model WHERE id = modelid )) as vnumberdt";  
            $vehicleList = get_dropdownsmultitxt('pt_con_vehicle', $where,'vnumber','vnumber',' Vehicle ---', $select, $keyExtraKey );
            
            if(!empty($is_list)){
                return $vehicleList;
            }else{ 
            
                $html = '';
                if(!empty($vehicleList)){
                    foreach( $vehicleList as $key=>$value ){
                      $html .= '<option value="'.$key.'">'.$value.'</option>';  
                    }
                }
                
                echo $html;
            }
    }

   
   

}
?>