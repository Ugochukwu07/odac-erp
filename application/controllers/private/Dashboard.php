<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{
	
	  function __construct() {
         parent::__construct(); 
	     adminlogincheck();
		 $this->load->model('Common_model', 'c_model');
      }
	
	public function index(){ 

	    $data[] = '';
	    $data['title'] = 'Dashboard';

//echo '<pre>';
//echo 'debug mode';

		$currentdate = date('Y-m-d');
		$currentdt = date('Y-m-d G:i:s');
		$table = 'booking';


		$where1['attemptstatus'] = 'new'; 
		$data['newbookng'] = $this->c_model->countitem($table,$where1,null,null,'id'  );

		$where2['attemptstatus'] = 'approved';  
		$where2['DATE(pickupdatetime) = '] = $currentdate; 
		$data['todaybooking'] = $this->c_model->countitem($table,$where2,null,null,'id'  );

		$where3['DATE(pickupdatetime) >'] = $currentdate;
		$where3['DATE(dropdatetime) >'] = $currentdate;
		$where3['attemptstatus'] = 'approved';
		$data['upcomingbooking'] = $this->c_model->countitem($table,$where3,null,null,'id'  );


		$where4['DATE(pickupdatetime) <='] = $currentdate;
		//$where4['DATE(dropdatetime) >='] = $currentdate;
		$where4['vehicleno'] = '';	
		$where4['attemptstatus'] = 'approved';
		$data['totaldriverpending'] = $this->c_model->countitem($table,$where4,null,null,'id' ); 
		
		 
		$where41['attemptstatus'] = 'temp';
		$data['totaltemp'] = $this->c_model->countitem($table,$where41,null,null,'id' ); 
 
  


		$where7['attemptstatus'] = 'cancel';
		$data['cancelbooking'] = $this->c_model->countitem($table,$where7,null,null,'id'  );



		$where8['attemptstatus'] = 'approved';
		$where8['DATE(pickupdatetime) <='] = DATE('Y-m-d');
		$where8['DATE(dropdatetime) >='] = DATE('Y-m-d');
		$data['runningbooking'] = $this->c_model->countitem($table,$where8,null,null,'id'  );
		
		
// 		$data['total_cars'] = $this->db->query("select a.id from pt_con_vehicle as a inner join pt_vehicle_model as b on a.modelid = b.id where b.catid = '1' AND a.status = 'yes' ")->num_rows();
		
// 		$whereHold = [];
// 		$whereHold['attemptstatus'] = 'approved'; 
// 		$whereHold['DATE(dropdatetime) <'] = DATE('Y-m-d');
// 		$whereHold['vehicleno !='] = '';
// 		$whereHold['triptype'] = 'selfdrive';
// 		$data['hold_booking_cars'] = $this->c_model->countitem($table, $whereHold ,null,null, 'id' );
		 
// 		$data['free_cars'] = $data['total_cars'] - $data['hold_booking_cars'] - $data['runningbooking']; 


		$where9['attemptstatus'] = 'complete';
		$data['completebooking'] = $this->c_model->countitem($table,$where9,null,null,'id'  ); 

 
		$where11['attemptstatus !='] = 'temp';
		$data['totalrecod'] = $this->c_model->countitem( $table , $where11,null,null,'id'  ); 

		$where12['attemptstatus'] = 'approved'; 
		$where12['DATE(dropdatetime) <'] = DATE('Y-m-d');
		$where12['vehicleno !='] = '';
		$data['holdbooking'] = $this->c_model->countitem($table,$where12,null,null, 'id' );

		/**total business*/
		$totalbusiness = $this->db->query("select SUM(totalamount) AS total from pt_booking where attemptstatus NOT IN('cancel','reject')")->row_array();
		$data['totalbusiness'] = !empty($totalbusiness) ? $totalbusiness['total'] : 0;

		/**total business*/
		$tbus = $this->db->query("select SUM(totalamount) AS total from pt_booking where attemptstatus NOT IN('cancel','reject') AND DATE(pickupdatetime) >='".date('Y-m-01')."' AND DATE(dropdatetime) <='".date('Y-m-d')."'  ")->row_array();

		$data['thismonthsale'] = !empty($tbus) ? $tbus['total'] : 0;

		/**today Sale business*/
		$todaySale = $this->db->query("select SUM(bookingamount) AS total from pt_booking where  DATE(bookingdatetime)= '".date('Y-m-d')."' and attemptstatus NOT IN('cancel','reject','temp')")->row_array();
        $data['todaysale'] = !empty($todaySale) ? (int)$todaySale['total'] : 0;
        
        /**today extended Sale business*/
        $collectionDate = date('Y-m-d');
		$todayCollection = $this->db->query("SELECT  SUM(`a`.`amount`) AS total FROM `pt_payment_log` as `a` LEFT JOIN `pt_booking` as `b` ON `a`.`booking_id` = `b`.`id` WHERE DATE(a.added_on) = '".$collectionDate."' AND  `b`.`attemptstatus` NOT IN('cancel','temp','reject')   ORDER BY `a`.`id` DESC;")->row_array();
        $data['todaycollection'] = !empty($todayCollection) ? (int)$todayCollection['total'] : 0;
         
		/**Total Due Amount*/
		$totalDue = $this->db->query("select SUM(restamount) AS total from pt_booking where DATE(pickupdatetime) >='2024-01-01'  AND DATE(pickupdatetime) <='".date('Y-m-d')."' AND restamount > 0 AND attemptstatus NOT IN('cancel','reject','temp')  ")->row_array();
        $data['total_due'] = !empty($totalDue) ? (int)$totalDue['total'] : 0;
        
		/**total roll business*/
		$data['totalvehiclesale'] = $this->countThisMonthSale();

		/**edit booking Logs */
		$editBookingList = $this->db->query("select COUNT(*) AS total from pt_booking where edit_verify_status = 'edit' and attemptstatus NOT IN('cancel','reject','temp') ")->row_array();

		$data['editbookings'] = !empty($editBookingList) ? $editBookingList['total'] : 0;
 
 
 
        $where = [];
        $where["vehicle_con_id NOT IN( SELECT id FROM pt_con_vehicle WHERE status = 'block'  )"] = NULL;
         	     
		$totaldocsCount = $this->db->query(" SELECT `a`.`id` FROM `pt_vehicle_details` as `a` LEFT JOIN `pt_con_vehicle` as `b` ON `a`.`vehicle_con_id` = `b`.`id` LEFT JOIN `pt_vehicle_model` as `c` ON `b`.`modelid` = `c`.`id` LEFT JOIN `pt_vehicle_cat` as `d` ON `c`.`catid` = `d`.`id` WHERE `b`.`status` != 'block' ")->result_array();
		$data['totaldocs'] = !empty($totaldocsCount) ? sizeof($totaldocsCount) : 0;
		
		//count cab bike service pending edit verification
		$data['carserviceeditverify'] = $this->c_model->countitem('pt_vehicle_services', ['catid'=>'1','edit_verify_status'=>'edit','is_done'=>0, "vehicle_con_id IN( SELECT id FROM pt_con_vehicle WHERE status = 'yes'  )"=>NULL] , null,null,'id' );
	    $data['bikeserviceeditverify'] = $this->c_model->countitem('pt_vehicle_services', ['catid'=>'2','edit_verify_status'=>'edit','is_done'=>0, "vehicle_con_id IN( SELECT id FROM pt_con_vehicle WHERE status = 'yes'  )"=>NULL] , null,null,'id' );
		
        //count cab bike document pending edit verification
        $data['doc_verification_pending'] = $this->c_model->countitem('pt_vehicle_details', ['edit_verify_status'=>'edit'] , null,null,'id' );
        // echo '<pre>';
        // print_r( $data );
        
        //count role user
        $data['total_role_user'] = $this->c_model->countitem('pt_roll_team_user', ['status'=>'yes'] , null,null,'id' );
		  
	    $this->load->view( adminfold('dashboard') ,$data );
		}
		
		
		//count services list
		
		function countserviceitems(){
		    
		    $get = $this->input->get();
		    
		    $type = !empty($get['type']) ? $get['type'] : ''; 
		    $table = 'pt_vehicle_services';
		    
		    
		    
		    if( $type == 'pendingbikeservice'){
		        $result = $this->db->query("SELECT DISTINCT(`a`.`vehicle_con_id`) FROM `pt_vehicle_services` as `a` LEFT JOIN `pt_con_vehicle` as `b` ON `a`.`vehicle_con_id` = `b`.`id` LEFT JOIN `pt_vehicle_model` as `c` ON `b`.`modelid` = `c`.`id` LEFT JOIN `pt_vehicle_cat` as `d` ON `c`.`catid` = `d`.`id` WHERE `a`.`catid` = 2 AND `b`.`status` != 'block' AND `a`.`next_service_date` < '".date('Y-m-d')."' AND `a`.`is_done` = 0 ")->result_array();
		        echo !empty($result) ? sizeof($result) : 0; 
		    }
		    else if( $type == 'totalbikeservice'){ 
		      $result = $this->db->query("SELECT DISTINCT(`a`.`vehicle_con_id`) FROM `pt_vehicle_services` as `a` LEFT JOIN `pt_con_vehicle` as `b` ON `a`.`vehicle_con_id` = `b`.`id` LEFT JOIN `pt_vehicle_model` as `c` ON `b`.`modelid` = `c`.`id` LEFT JOIN `pt_vehicle_cat` as `d` ON `c`.`catid` = `d`.`id` WHERE `a`.`catid` = '2' AND `b`.`status` != 'block'")->result_array();
		       echo !empty($result) ? sizeof($result) : 0; 
		    }
		    
		    
		    else if( $type == 'upcomingbikeservice'){ 
		      $result = $this->db->query("SELECT DISTINCT(`a`.`vehicle_con_id`) FROM `pt_vehicle_services` as `a` LEFT JOIN `pt_con_vehicle` as `b` ON `a`.`vehicle_con_id` = `b`.`id` LEFT JOIN `pt_vehicle_model` as `c` ON `b`.`modelid` = `c`.`id` LEFT JOIN `pt_vehicle_cat` as `d` ON `c`.`catid` = `d`.`id` WHERE `a`.`catid` = 2 AND `b`.`status` != 'block' AND `a`.`next_service_date` > '".date('Y-m-d')."' AND `a`.`next_service_date` < '".date('Y-m-d', strtotime( date('Y-m-d').'+ 10 days'))."' AND `a`.`is_done` = 0;")->result_array();
		        echo !empty($result) ? sizeof($result) : 0; 
		    }
		    
		    
		    else if( $type == 'pendingcarservives'){ 
		        $result = $this->db->query("SELECT DISTINCT(`a`.`vehicle_con_id`) FROM `pt_vehicle_services` as `a` LEFT JOIN `pt_con_vehicle` as `b` ON `a`.`vehicle_con_id` = `b`.`id` LEFT JOIN `pt_vehicle_model` as `c` ON `b`.`modelid` = `c`.`id` LEFT JOIN `pt_vehicle_cat` as `d` ON `c`.`catid` = `d`.`id` WHERE `a`.`catid` = 1 AND `b`.`status` != 'block' AND `a`.`next_service_date` < '".date('Y-m-d')."' AND `a`.`is_done` = 0 ")->result_array();
		        echo !empty($result) ? sizeof($result) : 0; 
		    }
		    
		    else if( $type == 'totalcarservives'){ 
		        $result = $this->db->query("SELECT DISTINCT(`a`.`vehicle_con_id`) FROM `pt_vehicle_services` as `a` LEFT JOIN `pt_con_vehicle` as `b` ON `a`.`vehicle_con_id` = `b`.`id` LEFT JOIN `pt_vehicle_model` as `c` ON `b`.`modelid` = `c`.`id` LEFT JOIN `pt_vehicle_cat` as `d` ON `c`.`catid` = `d`.`id` WHERE `a`.`catid` = 1 AND `b`.`status` != 'block'")->result_array();
		       echo !empty($result) ? sizeof($result) : 0; 
		    }
		    
		    
		    else if( $type == 'upcomingcarservives'){
		        $result = $this->db->query("SELECT DISTINCT(`a`.`vehicle_con_id`) FROM `pt_vehicle_services` as `a` LEFT JOIN `pt_con_vehicle` as `b` ON `a`.`vehicle_con_id` = `b`.`id` LEFT JOIN `pt_vehicle_model` as `c` ON `b`.`modelid` = `c`.`id` LEFT JOIN `pt_vehicle_cat` as `d` ON `c`.`catid` = `d`.`id` WHERE `a`.`catid` = 1 AND `b`.`status` != 'block' AND `a`.`next_service_date` > '".date('Y-m-d')."' AND `a`.`next_service_date` < '".date('Y-m-d', strtotime( date('Y-m-d').'+ 10 days'))."' AND `a`.`is_done` = 0;")->result_array();
		        echo !empty($result) ? sizeof($result) : 0; 
		    }
		    
		    else if( $type == 'carserviceclaim'){
		        $where = [];
		        $where['catid'] = 1;
		        echo $this->c_model->countitem('pt_vehicle_service_claim', $where );
		    } 
		    else if( $type == 'bikeserviceclaim'){
		        $where = [];
		        $where['catid'] = 2;
		        $where["vehicle_con_id NOT IN( SELECT id FROM pt_con_vehicle WHERE status = 'block'  )"] = NULL; 
		        echo $this->c_model->countitem('pt_vehicle_service_claim', $where );
		    } 
		   
		   
		} 
		
		
		function countThisMonthSale(){
		    
		    $startDate =  date('Y-m-01');
		    $endDate =  date('Y-m-d');
		    
		    $where = [];
		    $where["attemptstatus NOT IN('temp','cancel','reject')"] = NULL;   
            $where['DATE(pickupdatetime) >='] = date('Y-m-d',strtotime( $startDate.' -3 months'));
            $where['DATE(dropdatetime) <='] = date('Y-m-d',strtotime( $endDate.' +3 months')); 
            $select = 'vehicle_price_per_unit,vehicleno, DATE(pickupdatetime) as pickupdates, DATE(dropdatetime) as dropdates   ';
            $table = 'pt_booking as a';  
            
            //echo json_encode($where); 
            $totalSumAMount = 0;     
            // $getData = $this->c_model->getAll( $table, null, $where,$select );
            // if(!empty($getData)){
            //     $dateRangeList = generateDateRangeFromDates( $startDate, $endDate );  
                
            //     $vehicleNoMainList = $this->c_model->getAll( 'pt_con_vehicle', null, null, 'vnumber' );   
 
             
            //         //collect datevise rows 
            //         foreach($dateRangeList as $date ){ 
            //                 foreach ($vehicleNoMainList as $vehicle) {
            //                     $matchValue = 0;
            //                     if(!empty($getData)){ 
            //                         foreach($getData as $key=>$value){ 
            //                             if( trim($value['vehicleno']) == trim($vehicle['vnumber']) && strtotime($value['pickupdates']) <= strtotime($date) && strtotime($value['dropdates']) >= strtotime($date) ){
            //                               $matchValue = $value['vehicle_price_per_unit'];  
            //                             } 
            //                         } 
            //                     }  
            //                     $totalSumAMount += $matchValue;
            //                 }      
            //         }
            // }
            return $totalSumAMount; 
		}
		
		
	
	
	} 
?>