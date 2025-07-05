<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Role_business_report extends CI_Controller{
	  var $pagename;
      var $table;
	  function __construct() {
         parent::__construct(); 
		  adminlogincheck();
		  $this->pagename = 'role_business_report';
		  $this->table = 'pt_booking'; 
      }
	


  public function index() {

			$data = []; 
		 
	        $title = 'Role User Business Report';
	        $data['title'] = $title;
	        $data['exporturl'] = '';
	        $data['list'] = [];
	        
	        $post = !empty($this->input->post()) ? $this->input->post() : $this->input->get();  
            
            $from = !empty($post['from'])?trim($post['from']):'';
            $to = !empty($post['to'])?trim($post['to']):'';
            $user_id = !empty($post['user_id'])?trim($post['user_id']):'';
            $type = !empty($post['type'])?trim($post['type']):'';
            
            $data['from'] = $from;
            $data['to'] = $to;
            $data['user_id'] = $user_id; 
            $data['type'] = $type; 
			
			//check csv report key
			$is_csv_export = !empty($post['csv_report']) ? $post['csv_report'] : false ;
			$data['exporturl'] = base_url('private/'.strtolower($this->pagename).'?from='.$from.'&to='.$to.'&user_id='.$user_id.'&csv_report=yes' ); 
 
  
	        $data['title'] = $title .' &nbsp; [ <span style="font-size:12px;color:red"> Export Report : <span id="totalBookings">0</span> </span>]';  
	        
	        //echo 'Code Stucked'; die;  
            
            //get users list
            $keyExtraKey = 'user_detail';
            $select = "CONCAT(fullname,',',mobile) as user_detail";  
            $userList = get_dropdownsmultitxt('pt_roll_team_user',null,'mobile','mobile','Role User ---', $select, $keyExtraKey );
            $data['role_user_list'] = $userList;
            
           // echo '<pre>';
            // print_r($userList); exit; 
            
            
            if(!empty($post)){
                    $getBookingData = !empty($post) ? $this->getRecordsFromDb( $post ) : []; 
                   //echo count( $getBookingData ); exit;
                    
                    $dateRangeList = generateDateRangeFromDates( $post['from'],$post['to']);  
                    $totalDays = !empty($dateRangeList) ? sizeof($dateRangeList) : 0;
                    //echo print_r( $dateRangeList ); exit;
                    
                    $newRoleUserList = [];
                    foreach($userList as $key=>$value ){
                        if(!empty($key)){
                        $newRoleUserList[] = $key;  
                        }
                    }
            
            
                    //collect booking data from booking list
                    
                    $collectRowsData = [];
                    foreach ($userList as $keyy=>$row) {
                            if(!empty($keyy)){
                                $userMobile = $keyy;
                                $push = [];
                                $push['mobile_no'] = $userMobile; 
                                $explodeArry = explode(',', $row ); 
                                $push['name'] = !empty($explodeArry[0]) ? rtrim($explodeArry[0],', ') : '' ; 
                                $push['from'] = date('d-F-Y',strtotime( $post['from']));
                                $push['to'] = date('d-F-Y',strtotime( $post['to']));
                                $push['total_sum'] =  0;
                                $push['total_bookings'] =  0;
                                 
                                $totalSumAmount = 0;
                                
                                $totalBookings = [];
                            
                                foreach($dateRangeList as $date ){
                                     
                                    if(!empty($getBookingData)){ 
                                        foreach($getBookingData as $key=>$value){ 
                                            if( trim($value['add_by']) == trim($userMobile) && strtotime($value['pickupdates']) <= strtotime($date) && strtotime($value['dropdates']) >= strtotime($date) ){
                                              $totalSumAmount += $value['vehicle_price_per_unit']; 
                                              if(!in_array($value['id'], $totalBookings)){
                                                  $totalBookings[] = $value['id'];
                                              }
                                            } 
                                        } 
                                    }  
                                }
                                
                                $push['total_sum'] = $totalSumAmount; 
                                $push['sorting'] = (float) $totalSumAmount;
                                $push['ids'] =  !empty($totalBookings) ? implode(",", array_unique($totalBookings)) : 0;
                                $push['total_bookings'] = !empty($totalBookings) ? sizeof( array_unique($totalBookings)) : 0;
                                array_push($collectRowsData,$push);
                            }
                    }
                    
                    
                    //print_r( $collectRowsData ); exit; 
            
            }
            
            
            
            if(!empty($collectRowsData)){
                usort( $collectRowsData, 'incomeSorting'); 
            }
            
            // echo '<pre>';
            // print_r( $collectRowsData ); exit; 
            
            if( $is_csv_export == 'yes' && !empty($collectRowsData) ){ 
                    $this->exportReport( $collectRowsData ); exit;
            }else{
                $data['list'] = $collectRowsData;
            } 
             
			 
	        _viewlist( 'report/'.strtolower($this->pagename), $data );  
   }
   
   

  protected function getRecordsFromDb( $post ){
      
        	$where = []; 
            $like = null;
            $likekey = null;
            $likeaction = null;  
            
             
            $where["attemptstatus NOT IN('temp','cancel','reject')"] = NULL; 
             
            
            if(!empty($post['user_id'])){ 
             $where['add_by'] = $post['user_id'];	
            }  
             
            
            if( !empty($post['from']) && !empty($post['to']) ){
            $where['DATE(pickupdatetime) >='] = date('Y-m-d',strtotime($post['from'].' -3 months'));
            $where['DATE(dropdatetime) <='] = date('Y-m-d',strtotime($post['to'].' +3 months'));
            }
            /*filter script start here*/
            
            
            $select = 'id, vehicle_price_per_unit,driverdays, DATE(pickupdatetime) as pickupdates, DATE(dropdatetime) as dropdates, add_by';
            $from = 'pt_booking'; 
            
            
            $groupby  = null;
            $orderby = 'pickupdatetime ASC'; 
             
            
            $in_not_in = null; 
            
            //echo json_encode($where); 
                 
            $getdata = $this->c_model->joindata( $select, $where, $from, $join, $groupby, $orderby, $limit, $in_not_in, $like, $likekey, $likeaction, $start ); 
            //echo $this->db->last_query($getdata); exit;
            return $getdata; 
               
            
  } 
   
 
  
   
   //Export CSV Files
   
   	function exportReport( $listData ){
		    
		       
               $filename = 'Role_Business_Report_'.date('Y-m-d').'.csv'; 
               header("Content-Description: File Transfer"); 
               header("Content-Disposition: attachment; filename=$filename"); 
               header("Content-Type: application/csv; ");
               
               
               // file creation 
               $file = fopen('php://output', 'w');
             
               $header = array("Sno","Full Name","Mobile No","Date From" ,"Date Till" ,"Total Bookings" ,"Total Bussiness" ); 
               fputcsv($file, $header); $i=1;
                
               $totalAmount = 0;    
               foreach ($listData as $key=>$value){
                   $line = [];
                   $line['sno'] = $i;
                   $line['name'] = $value['name'];
                   $line['mobile_no'] = $value['mobile_no'];
                   $line['from'] = $value['from'];
                   $line['to'] = $value['to'];
                   $line['total_bookings'] = $value['total_bookings'];
                   $line['total_sum'] = $value['total_sum'];
                     
                 fputcsv($file,$line); 
                 $i++;
               } 
               
               fclose($file); 
               exit; 
   
		}
		
		
    

}
?>