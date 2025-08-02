<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bookingview extends CI_Controller{
	  var $pagename;
      var $table;
	  function __construct() {
         parent::__construct(); 
		  adminlogincheck();
		  $this->pagename = 'bookingview';
		  $this->table = 'pt_booking';
		  //$this->load->helper('slip');
      }
	
    public function getPreviousThreeMonths( $start_date = null , $end_date = null ) {
        if(!empty($start_date) && !empty($end_date)){ 
            $start = new DateTime($start_date);
            $end = new DateTime($end_date);
            $end->modify('first day of next month');
            $month_list = [];
             
            while ($start < $end) {
            $month_list[] = $start->format('Y-m-01');
            $start->modify('first day of next month');
            }
            
            return $month_list;
        }else{ 
            $currentMonth = date('Y-m-d');
            $currentMonth = date('Y-m-d', strtotime( $currentMonth."  +28 days"));
            $previousMonths = array();
            
            $monthList = [];
            
            for ($i = 1; $i <= 5; $i++) { 
                  $endMonth = $i == 1 ? $currentMonth : end( $previousMonths );
                  $previousMonth = date('Y-m-d', strtotime( $endMonth."  -28 days"));
                  if( !in_array( date('Y-m', strtotime( $previousMonth )), $monthList ) ){
                  $previousMonths[] = $previousMonth; 
                  $monthList[] = date('Y-m', strtotime( $previousMonth )); 
                  }
            } 
            return $previousMonths;
        }
    }

  public function index() {

			$data = [];
			$output = []; 
			$totalSaleSumsArrayList = ['todaysale','total','today','monthly','totaldue'];

	        $title = 'Booking List';
	        $data['title'] = $title;
	        $data['exporturl'] = '';
	        $data['list'] = [];
			$data['totalrows'] = 0;
	        $get = $this->input->get();
	        //$pagename = 'bookingview'; 
	        
	        //free temp bookings
	        freeCabSlots();

			 
			$where = []; 
			   
			$bookingtype = $get['type'];
			$data['bookingtype'] = $get['type'];
			$data['totalpage'] = NULL;
			$data['page'] = NULL;
			$data['prebtn'] = NULL;
			$data['nxtbtn'] = NULL;
			$data['startbtn'] = NULL;
			$data['endbtn'] = NULL;
			
			
			$post = $this->input->post();
            $get = $this->input->get();
            $post = array_merge($get,$post);
            
            
            $n = isset($post['n']) && !empty($post['n'])?trim($post['n']):false;
            $f = isset($post['f']) && !empty($post['f'])?trim($post['f']):false;
            $t = isset($post['t']) && !empty($post['t'])?trim($post['t']):false;
            $veh = isset($post['veh']) && !empty($post['veh'])?trim($post['veh']):false;
            $role_mobile = isset($post['role_mobile']) && !empty($post['role_mobile'])?trim($post['role_mobile']):false;
            $data['n'] = $n;
            $data['f'] = $f;
            $data['t'] = $t;
            $data['veh'] = $veh;
            $data['role_mobile'] = $role_mobile;
			
			//check csv report key
			$is_csv_export = !empty($get['csv_report']) ? $get['csv_report'] : false ;
			$data['exporturl'] = base_url('private/'.strtolower($this->pagename).'?type='.$bookingtype.'&csv_report=yes&veh='.$veh.'&f='.$f.'&t='.$t.'&n='.$n.'&role_mobile='.$role_mobile );  
                
		
 
 
            if(!empty($is_csv_export)){ 
                $getdata = $this->getRecordsFromDb( $post ); 
                $this->exportCSV( $getdata,$bookingtype );
            }  

	        $data['title'] = $title .' &nbsp; [ <span style="font-size:12px;color:red">   Total Records: <span id="totalBookings">0</span> </span>]';  
	        
	        /*******  calculate sales Amount *****/
	        $data['total_sale_amount'] = 0;
	        $data['total_sale_booking_amount'] = 0;
	        $data['total_sale_rest_amount'] = 0;
            if( in_array($bookingtype, $totalSaleSumsArrayList )){
                $where = [];
                $where["attemptstatus NOT IN('cancel','reject','temp','new')"] = NULL;
                if( !empty($f) && !empty($t) ){
                    $where["DATE(pickupdatetime) >="] = date('Y-m-d', strtotime($f));
                    $where["DATE(pickupdatetime) <="] = date('Y-m-d', strtotime($t));
                }else{
                    if( in_array($bookingtype, ['today']) ){
                        $where["DATE(pickupdatetime) >="] = date('Y-m').'-01';
                        $where["DATE(pickupdatetime) <="] = date('Y-m-d');
                    }else if( in_array($bookingtype, ['todaysale'] )){
                         $where["DATE(bookingdatetime)"] = date('Y-m-d');
                    }
                }
                //apply vehicle filter
                if(!empty($veh)){
                    $where['vehicleno'] = $veh;
                }
                 
                $todaySale = $this->db->select('SUM(totalamount) AS total, SUM(restamount) AS total_restamount, SUM(bookingamount) AS total_bookingamount, SUM(refund_amount) AS total_refund_amount ')->get_where('pt_booking',  $where )->row_array(); 
                // echo $this->db->last_query(); exit; 
                // print_r( $todaySale ); exit;
                
                $total_sale_amount = !empty($todaySale) ? $todaySale['total'] : 0;
                $total_sale_booking_amount =  !empty($todaySale) ? $todaySale['total_bookingamount'] : 0;
                $total_sale_rest_amount = !empty($todaySale) ? $todaySale['total_restamount'] : 0;
                
                $total_extended_amount = 0;
                 
                
                $data['total_sale_amount'] = $total_sale_amount + $total_extended_amount;
                $data['total_sale_booking_amount'] = $total_sale_booking_amount + $total_extended_amount;
                $data['total_sale_rest_amount'] = $total_sale_rest_amount;
                
                //collect THree Months Sale Records
                $saleRecords = []; 
                if( in_array($bookingtype, ['todaysale','totaldue'] )){
                    $monthsLists = $this->getPreviousThreeMonths( $f, $t ); 
                    if(!empty($monthsLists)){
                        foreach( $monthsLists as $row ){
                            $saleRecords[] = $this->getMonthlyRecords( $row );
                        }
                    } 
                    //print_r( $monthsLists ); exit;
                }
                $data['monthly_data'] = $saleRecords ;
                
            }
			 
			
			
			 
			
			
			//get vehicle list
            $keyExtraKey = 'vnumberdt';
            $select = "CONCAT(vnumber,',',(SELECT model FROM pt_vehicle_model WHERE id = modelid )) as vnumberdt";  
            $data['vehicle_list'] = get_dropdownsmultitxt('pt_con_vehicle',['status'=>'yes'],'vnumber','vnumber',' Vehicle ---', $select, $keyExtraKey );
            
            
            //add condition and define blank vehicle details
            $data['total_cars'] = 0; 
            $data['hold_booking_cars'] = 0; 
            $data['run_cars'] = 0; 
            $data['free_cars'] = 0; 
            
            $data['total_bike'] = 0; 
            $data['hold_booking_bike'] = 0; 
            $data['run_bike'] = 0; 
            $data['free_bike'] = 0; 
            if( in_array($bookingtype, ['run'] )){
                //cars management
                $data['total_cars'] = $this->db->query("select a.id from pt_con_vehicle as a inner join pt_vehicle_model as b on a.modelid = b.id where b.catid = '1' AND a.status = 'yes' ")->num_rows();
                $whereHoldCars = [];
                $whereHoldCars['attemptstatus'] = 'approved'; 
                $whereHoldCars['DATE(dropdatetime) <'] = date('Y-m-d');
                $whereHoldCars['vehicleno !='] = '';
                $whereHoldCars["triptype IN('selfdrive','monthly')"] = NULL;
                $data['hold_booking_cars'] = $this->c_model->countitem('pt_booking', $whereHoldCars, null, null, 'id' );
                
                $whereRun = [];
                $whereRun['attemptstatus'] = 'approved';
                $whereRun['DATE(pickupdatetime) <='] = date('Y-m-d');
                $whereRun['DATE(dropdatetime) >='] = date('Y-m-d');
                $whereRun['vehicleno !='] = '';
                $whereRun["triptype IN('selfdrive','monthly')"] = NULL;
                $data['run_cars'] = $this->c_model->countitem( 'pt_booking', $whereRun ,null, null, 'id'  ); 
                $data['free_cars'] = $data['total_cars'] - $data['hold_booking_cars'] - $data['run_cars']; 
	            
	            //bike management
	            $data['total_bike'] = $this->db->query("select a.id from pt_con_vehicle as a inner join pt_vehicle_model as b on a.modelid = b.id where b.catid = '2' AND a.status = 'yes' ")->num_rows();
                $whereHoldBike = [];
                $whereHoldBike['attemptstatus'] = 'approved'; 
                $whereHoldBike['DATE(dropdatetime) <'] = date('Y-m-d');
                $whereHoldBike['vehicleno !='] = '';
                $whereHoldBike['triptype'] = 'bike';
                $data['hold_booking_bike'] = $this->c_model->countitem('pt_booking', $whereHoldBike, null, null, 'id' );
                
                $whereRunBike = [];
                $whereRunBike['attemptstatus'] = 'approved';
                $whereRunBike['DATE(pickupdatetime) <='] = date('Y-m-d');
                $whereRunBike['DATE(dropdatetime) >='] = date('Y-m-d');
                $whereRunBike['vehicleno !='] = '';
                $whereRunBike['triptype'] = 'bike';
                $data['run_bike'] = $this->c_model->countitem( 'pt_booking', $whereRunBike ,null, null, 'id'  ); 
                $data['free_bike'] = $data['total_bike'] - $data['hold_booking_bike'] - $data['run_bike']; 
                
                //calculate running boooking amount details
                $where = [];
                $where['attemptstatus'] = 'approved';
                $where["DATE(pickupdatetime) <="] = date('Y-m-d');
                $where["DATE(dropdatetime) >="] = date('Y-m-d');
			    $todayUpcomingSale = $this->db->select('SUM(totalamount) AS total, SUM(restamount) AS total_restamount, SUM(bookingamount) AS total_bookingamount ')->get_where('pt_booking',  $where )->row_array(); 
                
			    $data['total_sale_amount'] = !empty($todayUpcomingSale) ? $todayUpcomingSale['total'] : 0;
                $data['total_sale_booking_amount'] = !empty($todayUpcomingSale) ? $todayUpcomingSale['total_bookingamount'] : 0;
                $data['total_sale_rest_amount'] = !empty($todayUpcomingSale) ? $todayUpcomingSale['total_restamount'] : 0;
                
                $totalSaleSumsArrayList = array_merge($totalSaleSumsArrayList,['run']);
			
            }
            
            
            $data['total_sum_array_list'] = $totalSaleSumsArrayList;
            
            //cancel
            $data['reason_list'] = get_dropdownsmultitxt('pt_booking_terms',['status'=>'yes','contenttype'=>'cancel'],'content','content','Reason ---' );
            
            // echo '<pre>';
            // print_r($data); exit;   
			 
	        _viewlist( strtolower($this->pagename), $data );  
   }
   
   
 protected  function getMonthlyRecords( $monthDate ){
       $previousMonthName = date('F', strtotime( $monthDate )); 
       $previousFirstMonth = date('m', strtotime( $monthDate )); 
       $previousFirstYear = date('Y', strtotime( $monthDate )); 
       
       $startDate = date( $previousFirstYear.'-'.$previousFirstMonth.'-01' );
       $endDate = $previousFirstMonth == date('m') ? date('Y-m-d') : date( 'Y-m-t',strtotime( $startDate ) ); 
       
       $where = [];
       $where["attemptstatus NOT IN('cancel','reject','temp','new')"] = NULL;
       $where["DATE(pickupdatetime) >="] = $startDate;
       $where["DATE(pickupdatetime) <="] = $endDate;
       $SaleData = $this->db->select('SUM(totalamount) AS total, SUM(restamount) AS total_restamount, SUM(bookingamount) AS total_bookingamount ')->get_where('pt_booking',  $where )->row_array(); 
       //echo $this->db->last_query(); exit; 
       
        
       $outPut = ['from'=>$startDate,'to'=>$endDate,'monthname'=>$previousMonthName,'month'=>$previousFirstMonth,'total'=>$SaleData['total'],'total_restamount'=>$SaleData['total_restamount'],'total_bookingamount'=>$SaleData['total_bookingamount'],'total_over_due_amount'=>$totalOverDueAmount];
       return $outPut; 
   }
   
  
  protected function getRecordsFromDb( $post , $limit = null , $start = null, $is_count = null ){
      
        	$where = []; 
            $like = null;
            $likekey = null;
            $likeaction = null;
            
            $bookingtype = $post['type'];
            $is_rest_amount = !empty($post['is_rest_amount']) ? $post['is_rest_amount']:'';
            
            // Load RBAC helper for hierarchy filtering
            $this->load->helper('rbac');
            
            // Apply admin hierarchy filter
            $hierarchy_filter = get_admin_hierarchy_filter();
            if (!empty($hierarchy_filter)) {
                $where = array_merge($where, $hierarchy_filter);
            }
            
            
            if(in_array($bookingtype,['total'])){
            $where['a.attemptstatus !='] = 'temp';
            }
            
            if($bookingtype == 'new'){ 
            $where['a.attemptstatus'] = $bookingtype;
            }else if($bookingtype == 'today'){ 
            $where['a.attemptstatus'] = 'approved';
            //$where["a.attemptstatus NOT IN('temp','cancel','reject')"] = NULL;
            $where['DATE(a.pickupdatetime)'] = date('Y-m-d');	
            }else if($bookingtype == 'temp'){ 
            $where['a.attemptstatus'] = 'temp';
            //$where['DATE(a.pickupdatetime)'] = date('Y-m-d');	
            }else if($bookingtype == 'run'){ 
            $where['a.attemptstatus'] = 'approved';
            $where['DATE(a.pickupdatetime) <='] = date('Y-m-d');
            $where['DATE(a.dropdatetime) >='] = date('Y-m-d');	
            }else if($bookingtype == 'cancel'){ 
            $where['a.attemptstatus'] = $bookingtype;	
            }else if($bookingtype == 'upcoming'){ 
            $where['a.attemptstatus'] = 'approved';
            $where['DATE(a.pickupdatetime) >'] = date('Y-m-d');
            $where['DATE(a.dropdatetime) >'] = date('Y-m-d');	
            }
            else if($bookingtype == 'vpending'){ 
            $where['a.attemptstatus'] = 'approved';
            $where['DATE(a.pickupdatetime)'] = date('Y-m-d');
            //$where['DATE(a.dropdatetime) >='] = date('Y-m-d');
            $where['a.vehicleno'] = '';	
            }
            else if($bookingtype == 'vtpending'){ 
            $where['a.attemptstatus'] = 'approved';
            $where['DATE(a.pickupdatetime) <='] = date('Y-m-d'); 
            $where['a.vehicleno'] = '';	
            }
            else if($bookingtype == 'complete'){ 
            $where['a.attemptstatus'] = $bookingtype;	
            }else if($bookingtype == 'hold'){ 
            $where['a.attemptstatus'] = 'approved'; 
            $where['a.vehicleno !='] = '';	
            $where['DATE(a.dropdatetime) <'] = date('Y-m-d');	
            }
            else if($bookingtype == 'edit'){ 
                $where["a.attemptstatus NOT IN('temp','cancel','reject')"] = NULL; 
                $where['a.edit_verify_status'] = 'edit';	
            }
            else if($bookingtype == 'todaysale'){ 
                $where["a.attemptstatus NOT IN('temp','cancel','reject','new')"] = NULL; 
                 $where["DATE(a.bookingdatetime)"] = date('Y-m-d');   
            }
            else if($bookingtype == 'monthly'){ 
                $where["a.attemptstatus NOT IN('temp','cancel','reject')"] = NULL;  
            }
            else if($bookingtype == 'restamount'){ 
                $where["a.attemptstatus NOT IN('temp','cancel','reject')"] = NULL;
                $where["a.restamount >"] = '0';
                $where['DATE(a.pickupdatetime) >='] = '2023-11-01';
                $where['DATE(a.pickupdatetime) <='] = date('Y-m-d');
            }
            else if($bookingtype == 'totalsale'){ 
                $where["a.attemptstatus NOT IN('temp','cancel','reject')"] = NULL;  
            }
            else if($bookingtype == 'refund'){ 
                $where["a.attemptstatus NOT IN('temp','cancel','reject')"] = NULL;
                $where["a.refund_amount >"] = '0';
                if(empty($post['f']) && empty($post['t'])){
                $where['DATE(a.pickupdatetime) >='] = '2023-11-01';
                $where['DATE(a.pickupdatetime) <='] = date('Y-m-d');
                }
            }
            else if($bookingtype == 'totaldue'){ 
                $where["a.attemptstatus NOT IN('temp','cancel','reject')"] = NULL;
                $where['DATE(a.pickupdatetime) >='] = '2024-01-01'; 
                $where['DATE(a.dropdatetime) <='] = date('Y-m-d');
                $where["a.restamount >"] = 0;
            }
            
            
            /*Apply Rest Amount Filter*/
            if(!empty($is_rest_amount) && $is_rest_amount == 'yes' && in_array($bookingtype, ['todaysale'] ) ){
               $where["a.restamount >"] = '0'; 
            }
            
            
            /*filter script start here*/
            $veh = isset($post['veh']) && !empty($post['veh'])?trim($post['veh']):false;
            $n = isset($post['n']) && !empty($post['n'])?trim($post['n']):false;
            $f = isset($post['f']) && !empty($post['f'])?trim($post['f']):false;
            $t = isset($post['t']) && !empty($post['t'])?trim($post['t']):false;
             
            $ismobile = filter_var($n,FILTER_SANITIZE_NUMBER_INT);
            $isemail = filter_var($n,FILTER_VALIDATE_EMAIL);
            if( strlen($ismobile) == 10 ){
            $where['a.mobileno'] = $ismobile;
            }else if( $isemail ){
            $where['a.email'] = $n;
            $where['a.email'] = $n;
            }else if( strpos($n, 'RCPL') !== FALSE ){
            $where['a.bookingid'] = $n;
            }else if( in_array(strtolower(substr($n,0,2)), ['ch','pb']) ){
            $where['a.vehicleno'] = $n;
            }else if(!empty($n)){
            $like = $n;
            $likekey = 'a.name';
            $likeaction = 'both';
            }
            
            //filter by vehicle number
            if(!empty($veh)){
                $where['a.vehicleno'] = $veh;
            }
            
            if(!empty($f) && !empty($t) && !in_array( $bookingtype, ['todaysale','refund','total_role_bookings'] ) ){
            $where['DATE(a.pickupdatetime) >='] = $f;
            $where['DATE(a.pickupdatetime) <='] = $t;
            }
            
            //filter by Role User Mobile number
            if(!empty($post['role_mobile']) && in_array( $bookingtype, ['total_role_bookings']) && !empty($post['ids']) ){
                $where = [];
                $where['a.add_by'] = trim($post['role_mobile']);
                $where["a.attemptstatus NOT IN('temp','cancel','reject')"] = NULL;
                $where["a.id IN(".$post['ids'].")"] = NULL; 
            }
            
            //filter by Guest User Mobile number
            if(!empty($post['u_mobile']) && in_array( $bookingtype, ['total_user_bookings']) ){
                $where = [];
                $where['a.mobileno'] = trim($post['u_mobile']);
                $where["a.attemptstatus NOT IN('temp')"] = NULL; 
            }
            /*filter script start here*/
            
            $editSorting = "(CASE  WHEN a.edit_verify_status = 'edit' THEN 2 WHEN a.edit_verify_status = 'verify' THEN 1 ELSE 0 END) AS edit_id";
            $select = 'a.*, DATEDIFF(dropdatetime, CURDATE()) AS days_difference, DATE_FORMAT(a.bookingdatetime,"%d-%b-%Y %r") as bookingdates,DATE_FORMAT(a.close_date,"%d-%b-%Y %r") as close_date, a.bookingdatetime as booked_on, DATE_FORMAT(a.ext_apply_on,"%d-%b-%Y %r") as ext_apply_on, DATE_FORMAT(a.pickupdatetime,"%d-%b-%Y %r") as pickupdates, DATE_FORMAT(a.dropdatetime,"%d-%b-%Y %r") as dropdates, md5(a.id) as enc_id, b.domain,c.model,'.$editSorting;
            
            if(empty($is_count)){
               // $select .= ',  d.amount as lates_recieved_amount '; 
            }
            
            $from = 'pt_booking as a'; 
            $join[0]['table'] = 'pt_domain as b';
            $join[0]['on'] = 'a.domainid = b.id';
            $join[0]['key'] = 'LEFT';
            
            $join[1]['table'] = 'pt_vehicle_model as c';
            $join[1]['on'] = 'a.modelid = c.id';
            $join[1]['key'] = 'LEFT';
            
            if(empty($is_count)){
            //$join[2]['table'] = '( SELECT pl.amount, pl.booking_id, pl.added_on FROM pt_payment_log pl INNER JOIN ( SELECT booking_id, MAX(added_on) AS latest_added_on FROM pt_payment_log WHERE amount > 0  GROUP BY booking_id ) latest ON pl.booking_id = latest.booking_id AND pl.added_on = latest.latest_added_on ) as d';
            //$join[2]['on'] = 'a.id = d.booking_id';  
            //$join[2]['key'] = 'LEFT';
            }
            
            $groupby  = null; 
            $orderby = 'edit_id DESC';
            
            if( in_array( $bookingtype, ['run','hold']) ){
             $orderby = 'a.dropdatetime ASC';    
            }
            else if( in_array( $bookingtype, ['upcoming']) ){
             $orderby = 'a.pickupdatetime ASC';    
            }
            else if( in_array( $bookingtype, ['temp']) ){
             $orderby = 'a.id DESC';    
            } 
            else if( in_array( $bookingtype, ['cancel','new']) ){
             $orderby = 'a.edit_date DESC';    
            }
            else if( in_array( $bookingtype, ['complete']) ){ 
             $orderby = 'a.edit_date DESC'; 
            } 
            else if( in_array( $bookingtype, ['totaldue']) ){ 
             $orderby = 'a.pickupdatetime DESC'; 
            } 
              
            
           
            
            
            $in_not_in = null; 
            
           // echo json_encode($where);
            
            
            if( !empty($post['search']['value']) ) {  
                $serchStr = trim($post['search']['value']) ;
                $where[" ( a.mobileno LIKE '%".$serchStr."%' OR a.name LIKE '%".$serchStr."%' OR a.bookingid LIKE '%".$serchStr."%' OR a.vehicleno LIKE '%".$serchStr."%' OR a.email LIKE '%".$serchStr."%' OR a.modelname LIKE '%".$serchStr."%' OR a.pickupcity LIKE '%".$serchStr."%' OR a.pickupcity LIKE '%".$serchStr."%' OR a.add_by_name LIKE '%".$serchStr."%' OR a.add_by LIKE '%".$serchStr."%' )"] = NULL;
                $limit = 200;
                $start = 0;
                $orderby = 'a.pickupdatetime DESC';  
            }
            
            
            if( $is_count == 'yes' ){
                $select = 'a.id'; 
                $getdata = $this->c_model->joindata( $select, $where, $from, $join, null,null,null,null,$like,$likekey,$likeaction, null );  
                //echo $this->db->last_query($getdata); exit;
                return !empty($getdata) ? count($getdata) : 0 ;
            }else{
                 
                $getdata = $this->c_model->joindata( $select, $where, $from, $join, $groupby, $orderby, $limit, $in_not_in, $like, $likekey, $likeaction, $start ); 
                if(!empty($getdata) && !in_array($bookingtype,['upcoming','cancel','temp','run','hold','complete','total','totaldue'])){ krsort($getdata); }
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
        $collectIds = '';
        foreach ($getdata as $key => $value) {
            $collectIds .= "'".$value['id']."',";
        }
        $collectIds = rtrim($collectIds,',');
        
        $queryResult = $this->db->query("SELECT p.* FROM pt_payment_log p INNER JOIN ( SELECT booking_id, MAX(`added_on`) AS latest_payment FROM pt_payment_log WHERE `booking_id` IN(".$collectIds.") GROUP BY booking_id ) AS latest ON p.booking_id = latest.booking_id AND p.`added_on` = latest.latest_payment;")->result_array();
			$i = $start + 1;
			foreach ($getdata as $key => $value) {
				$push = [];
				$push =  $value;
				$push['sr_no'] = $i;
				$push['hold_days'] = $value['days_difference'] < 0 ? str_replace("-", "", $value['days_difference'] ) : 0; 
				$push['is_invoice'] = ( strtotime($value['booked_on'])  >=  strtotime( INVOICE_PRINT_NEW_FORMAT ) ) ? true : false;  
				$push['edit_date'] = !empty($value['edit_date']) ? date('d-M-Y h:i A',strtotime($value['edit_date'])): '';
				$push['ext_apply_on'] = !empty($value['ext_apply_on']) ? date('d-M-Y h:i A',strtotime($value['ext_apply_on'])): '';
				$push['close_date'] = !empty($value['close_date']) ? date('d-M-Y h:i A',strtotime($value['close_date'])): '';
				$push['ext_from_date'] = !empty($value['ext_from_date']) ? date('d-M-Y h:i A',strtotime($value['ext_from_date'])): '';
				$push['ext_to_date'] = !empty($value['ext_to_date']) ? date('d-M-Y h:i A',strtotime($value['ext_to_date'])): '';
				$push['pickupdates'] = !empty($value['pickupdates']) ? date('d-M-Y h:i A',strtotime($value['pickupdates'])): '';
				$push['dropdates'] = !empty($value['dropdates']) ? date('d-M-Y h:i A',strtotime($value['dropdates'])): '';
				$push['bookingdates'] = !empty($value['bookingdates']) ? date('d-M-Y h:i A',strtotime($value['bookingdates'])): '';
				$push['lates_recieved_amount'] = 0;
				foreach( $queryResult as $keyIndex=>$valuePayment){
				    if($value['id']==$valuePayment['booking_id']){
				      $push['lates_recieved_amount'] = $valuePayment['amount']; 
				      break;
				    }
				    
				}
				array_push($result, $push );
				$i++;
			}
	}
    
	$json_data = array();

	if( !empty($_REQUEST['search']['value']) ) { 
		$countItems = !empty($result) ? count( $result ) : 0; 
		$json_data['draw'] = 0;
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





public function cancel(){
    
    $loginUser = $this->session->userdata('adminloginstatus');  
    $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
    $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
    $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';
    
    
 	$request = $this->input->post(); 
 	
 	
 	$response = []; 
 	
 	if(empty($request['id'])){
 	    $response['status'] = false;
 	    $response['message'] = 'Booking ID is Blank!'; 
 	    echo json_encode( $response ); exit;
 	}
 	
 	if(empty($request['message'])){
 	    $response['status'] = false;
 	    $response['message'] = 'Please Select Reason!'; 
 	    echo json_encode( $response ); exit;
 	}
 	

 	$id = $request['id'];
 	$message = $request['message'];


 	$keys = ' * ';
	$getdata = $this->c_model->getSingle('booking',['id'=>$id],'*'); 


 	$save = [];
 	$save['drvname'] = '';
 	$save['dvrtableid'] = '';
 	$save['drvmobile'] = '';
 	$save['vehicleno'] = '';
 	$save['attemptstatus'] = 'cancel';
 	$save['driverstatus'] = 'reject'; 
 	$save['edit_date'] = date('Y-m-d H:i:s'); 
 	$save['message'] = $message;
 	
 	$save['edit_by_mobile'] = $login_by_mobile;
    $save['edit_by_name'] = $login_by_name;
    $save['edit_verify_status'] = 'edit';
 	$where['id'] = $id;

 	$update = $this->c_model->saveupdate('pt_booking', $save, null, $where ); 
 	
    /*maintain cancel booking log*/
    $saveEditLog = ['booking_id'=>$id,'edited_field'=>'status','new_value'=>'cancelbooking','previous_value'=>$getdata['attemptstatus'],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    $this->db->insert('pt_booking_editing_log', $saveEditLog );
    
    $saveEditLog = ['booking_id'=>$id,'edited_field'=>'message','new_value'=>$message,'previous_value'=>$getdata['message'],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    $this->db->insert('pt_booking_editing_log', $saveEditLog );
	 
	$sms = shootsms($getdata,'cancel'); 

	/*free slot */
	$this->setFreeSlot( $id );


    $response['status'] = true;
    $response['message'] = "Booking Cancelled Successfully!"; 

	echo json_encode( $response ); exit;
   }


   public function confirm(){
       
    $loginUser = $this->session->userdata('adminloginstatus');  
    $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
    $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
    $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';
    
 	$request = $this->input->get(); 
 	$id = $request['id'];
 	$redirect = $request['redirect']; 
 	$keys = ' * ';
	$getdata = $this->c_model->getSingle('booking',['id'=>$id],'*'); 
 	$save = [];
 	$save['drvname'] = '';
 	$save['dvrtableid'] = '';
 	$save['drvmobile'] = '';
 	$save['vehicleno'] = '';
 	$save['attemptstatus'] = 'approved'; 
 	
 	$save['edit_by_mobile'] = $login_by_mobile;
    $save['edit_by_name'] = $login_by_name;
    $save['edit_verify_status'] = 'edit';
    $save['last_activity'] = 'Booking Confirmed'; 
    $save['edit_date'] = date('Y-m-d H:i:s');
    
 	$where['id'] = $id; 
 	$update = $this->c_model->saveupdate('booking', $save, null, $where );  
 	
 	/*maintain cancel booking log*/
    $saveEditLog = ['booking_id'=>$id,'edited_field'=>'status','new_value'=>'approved','previous_value'=>$getdata['attemptstatus'],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    $this->db->insert('pt_booking_editing_log', $saveEditLog );
    
    $this->load->helper('slip');
	$sms = shootsms($getdata,'approved');  
	$htmlmail = bookingslip($getdata,'mail');
	$this->session->set_flashdata('success',"Booking Confirmed Successfully!"); 
	redirect( adminurl('bookingview/?type='.$redirect ) );
   }

   public function delete(){
 	$request = $this->input->get(); 
 	$id = $request['id'];
 	$redirect = $request['redirect'];      
 	$where['id'] = $id; 
 	$update = $this->c_model->delete('booking', $where );
 	$this->setFreeSlot( $id );   
	$this->session->set_flashdata('success',"Booking Deleted Successfully!"); 
	redirect( adminurl('bookingview/?type='.$redirect ) );
   }

   public function close(){
 	$request = $this->input->get(); 
 	
 	$loginUser = $this->session->userdata('adminloginstatus');  
    $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
    $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
    $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';
    
 	$id = $request['id'];
 	$redirect = $request['redirect']; 
 	$keys = ' * ';
	$getdata = $this->c_model->getSingle('booking',['id'=>$id],'*'); 
 	$save = [];
 	$save['attemptstatus'] = 'complete';
 	$save['closed_by_name'] = $login_by_name;
 	$save['closed_by_mobile'] = $login_by_mobile;
 	$save['closed_date'] = date('Y-m-d H:i:s');
 	
 	$save['edit_by_mobile'] = $login_by_mobile;
    $save['edit_by_name'] = $login_by_name;
    $save['edit_verify_status'] = 'edit';
    
 	$where['id'] = $id; 
 	$update = $this->c_model->saveupdate('booking',$save,null, $where ); 
 	
 	/*maintain cancel booking log*/
    $saveEditLog = ['booking_id'=>$id,'edited_field'=>'attemptstatus','new_value'=>'complete','previous_value'=>$getdata['attemptstatus'],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    $this->db->insert('pt_booking_editing_log', $saveEditLog );
    
	$sms = shootsms($getdata,'complete');  
	$this->session->set_flashdata('success',"Booking Closed Successfully!"); 
	redirect( adminurl('bookingview/?type='.$redirect ) );
   }



  public function reactive(){
    
    $loginUser = $this->session->userdata('adminloginstatus');  
    $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
    $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
    $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';
    
 	$request = $this->input->get(); 
 	$id = $request['id'];
 	$redirect = $request['redirect']; 
 	$keys = ' * ';
	$getdata = $this->c_model->getSingle('booking',['md5(id)'=>$id],'*'); 
 	$save = [];
 	$save['attemptstatus'] = 'approved'; 
 	$save['edit_date'] = date('Y-m-d H:i:s'); 
 	
 	$save['edit_by_mobile'] = $login_by_mobile;
    $save['edit_by_name'] = $login_by_name;
    $save['edit_verify_status'] = 'edit';
    
 	$where['md5(id)'] = $id; 
 	$update = $this->c_model->saveupdate('booking',$save,null, $where ); 
 	
 	/*maintain cancel booking log*/
    $saveEditLog = ['booking_id'=>$getdata['id'],'edited_field'=>'attemptstatus','new_value'=>'reactive','previous_value'=>$getdata['attemptstatus'],'edit_by_name'=>$login_by_name,'edit_by_mobile'=>$login_by_mobile,'edited_on'=>date('Y-m-d H:i:s')];
    $this->db->insert('pt_booking_editing_log', $saveEditLog );
    
	$sms = shootsms($getdata,'approved');  
	$this->session->set_flashdata('success',"Booking Reactive Successfully!"); 
	redirect( adminurl('bookingview/?type='.$redirect ) );
  }



   function setFreeSlot($id=null){ 
			$save = [];
			$where = [];
			$save['status'] = 'free';
			$save['bookingid'] = ''; 
			if(!empty($id)){
			$where['bookingid'] = $id; 
			$this->c_model->saveupdate('pt_dateslots',$save,null,$where);
			} 
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
             
               $header = array("Sno","Booking ID","Trip Type","Customer Name","Mobile","Email","Pickup City","Pickup Address","Drop City","Drop Address","Pickup Date","Drop Date","Vehicle Name","Vehicle Number","Status","Added By Mobile","Added By Name","Last Edited By Mobile","Last Edited By Name","Total Amount","Recieved Amount","Rest Amount" ); 
               fputcsv($file, $header); $i=1;
               $totalAmount = 0;
               $totalBookingAmount = 0;
               $totalRestAmount = 0;
               foreach ($list as $key=>$value){
                   $line = [];
                   $line['sno'] = $i;
                   $line['bookingid'] = $value['bookingid'];
                   $line['triptype'] = $value['triptype'];
                   $line['name'] = $value['name'];
                   $line['mobileno'] = $value['mobileno'];
                   $line['email'] = $value['email'];
                   $line['pickupcity'] = $value['pickupcity'];
                   $line['pickupaddress'] = $value['pickupaddress'];
                   $line['dropaddress'] = $value['dropaddress'];
                   $line['pickupdatetime'] = date('d-M-Y, h:i A',strtotime($value['pickupdatetime']));
                   $line['dropdatetime'] = date('d-M-Y, h:i A',strtotime($value['dropdatetime']));
                   $line['modelname'] = $value['modelname'];
                   $line['vehicleno'] = $value['vehicleno'];
                   $line['attemptstatus'] = $value['attemptstatus']; 
                   $line['add_by'] = $value['add_by']; 
                   $line['add_by_name'] = $value['add_by_name']; 
                   $line['edit_by_mobile'] = $value['edit_by_mobile']; 
                   $line['edit_by_name'] = $value['edit_by_name'];
                   $line['totalamount'] = $value['totalamount'];
                   $line['bookingamount'] = $value['bookingamount'];
                   $line['restamount'] = $value['restamount'];
                   if( !in_array( $value['attemptstatus'] , ['cancel','reject','temp'])){
                        $totalAmount += $value['totalamount'];
                        $totalBookingAmount += $value['bookingamount'];
                        $totalRestAmount += $value['restamount'];  
                   }
                   
               
                 fputcsv($file,$line); 
                 $i++;
               }
               
               $footer = array("","","","","","","","","","","","","","","","","","","","Total Amount: ".$totalAmount,"Total Recieved Amount : ".$totalBookingAmount ,"Total Rest Amount: ".$totalRestAmount ); 
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
	    $verify_status = $this->input->post('verify_status');
	    $saveData = [];
	    $saveData['edit_verify_status'] = 'verify';
	    if(!empty($verify_status)){
	    $saveData['verify_status'] = $verify_status;
	    }
	    
	    $this->c_model->saveupdate('pt_booking',$saveData,null, ['id'=>$id]);
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
            
            $this->load->helper('slip'); 
            $html = bookingslip($getdata, 'mail');  
            
             
            echo true;
	    }
	    echo false;
    }
    
/*********************** Print Invoice Slip ***************************/
	function invoice_slip(){ 

	    $post = $this->input->get();
	    $id = !empty($post['id']) ? $post['id'] : '';
	    if(!empty($id)){ 
	        
            $keys = ' * ';
            $getdata = $this->c_model->getSingle('pt_booking',['md5(id)'=>$id],'*'); 
             
             
            
            if(  strtotime($getdata['bookingdatetime'])  >=  strtotime( INVOICE_PRINT_NEW_FORMAT ) ){ 
              $this->load->helper('slip_new');
              $html = bookingslipnew($getdata, 'print');  
            }else{
              echo 'no record';  exit;
            }
            
            // echo $html;
            // exit;
              
             
              // Try to use mPDF if available, otherwise show HTML version
              if (file_exists(FCPATH.'vendor/autoload.php')) {
                  require_once FCPATH.'vendor/autoload.php';
                  if (class_exists('\Mpdf\Mpdf')) {
                      // Use mPDF
                      header('Content-Type: application/pdf; charset=utf-8');
                      $mpdf = new \Mpdf\Mpdf(); 
                      $filename = $fetch['bookingid'].".pdf"; 
                      $mpdf->SetFont('Arial');
                      $mpdf->SetFont('Helvetica');
                      $mpdf->SetFont('sans-serif'); 
                      $mpdf->SetTitle($filename);
                      $mpdf->setAutoTopMargin = 'pad';
                      $mpdf->autoMarginPadding = 10;
                      $mpdf->WriteHTML($html,2);
                      $mpdf->Output($filename, "I"); 
                      exit;
                  }
              } elseif (file_exists(APPPATH.'third_party/mpdf/vendor/autoload.php')) {
                  require_once APPPATH.'third_party/mpdf/vendor/autoload.php';
                  if (class_exists('\Mpdf\Mpdf')) {
                      // Use mPDF
                      header('Content-Type: application/pdf; charset=utf-8');
                      $mpdf = new \Mpdf\Mpdf(); 
                      $filename = $fetch['bookingid'].".pdf"; 
                      $mpdf->SetFont('Arial');
                      $mpdf->SetFont('Helvetica');
                      $mpdf->SetFont('sans-serif'); 
                      $mpdf->SetTitle($filename);
                      $mpdf->setAutoTopMargin = 'pad';
                      $mpdf->autoMarginPadding = 10;
                      $mpdf->WriteHTML($html,2);
                      $mpdf->Output($filename, "I"); 
                      exit;
                  }
              }
              
              // Fallback: Show HTML version with print-friendly styling
              header('Content-Type: text/html; charset=utf-8');
              echo '<!DOCTYPE html>
              <html>
              <head>
                  <meta charset="utf-8">
                  <title>Booking Slip - ' . $fetch['bookingid'] . '</title>
                  <style>
                      body { font-family: Arial, sans-serif; margin: 20px; }
                      .print-button { 
                          position: fixed; top: 20px; right: 20px; 
                          background: #007bff; color: white; padding: 10px 20px; 
                          border: none; border-radius: 5px; cursor: pointer;
                      }
                      @media print {
                          .print-button { display: none; }
                      }
                  </style>
              </head>
              <body>
                  <button class="print-button" onclick="window.print()">Print Slip</button>
                  ' . $html . '
              </body>
              </html>';
              exit;   
	    }
	    echo 'no direct access allowed';
    }


public function discountclose(){
 	$request = $this->input->post(); 
 	
 	$loginUser = $this->session->userdata('adminloginstatus');  
    $login_by_id = !empty($loginUser['logindata']['id']) ? $loginUser['logindata']['id'] : '';
    $login_by_name = !empty($loginUser['logindata']['fullname']) ? $loginUser['logindata']['fullname'] : '';
    $login_by_mobile = !empty($loginUser['logindata']['mobile']) ? $loginUser['logindata']['mobile'] : '';
    
 	$id = $request['id']; 
 	$discount = $request['amount']; 
 	if(empty($id) && !empty($discount)){
 	    echo false; exit;
 	}
 	$keys = ' * ';
	$getdata = $this->c_model->getSingle('pt_booking',['id'=>$id,'attemptstatus'=>'complete'],'offerprice,id,restamount,totalamount'); 
	$giveDiscount = $discount > 0 ? $discount : 0;
 	$save = [];
 	$save['offerprice'] = (float)$getdata['offerprice'] + (float)$giveDiscount;
 	$save['restamount'] = (float)$getdata['restamount'] - (float)$giveDiscount;
 	$save['totalamount'] = (float)$getdata['totalamount'] - (float)$giveDiscount;
 	
 	$save['edit_by_mobile'] = $login_by_mobile;
    $save['edit_by_name'] = $login_by_name; 
    $save['edit_date'] = date('Y-m-d H:i:s'); 
    $save['last_activity'] = 'Forcely Discount Applied: '.$giveDiscount; 
    $save['edit_verify_status'] = 'edit';
    $save['force_discount'] = $giveDiscount;
    
 	$where['id'] = $id; 
 	$update = $this->c_model->saveupdate('pt_booking',$save,null, $where );  
 	  
	echo true;
}

public function getPaymentTrackLog(){
    $id = $this->input->post('id');
    $paymentList = $this->c_model->getAll( 'pt_payment_log', null,['booking_id'=>$id], '*' );
    $html = '<div class="timeline"></div>';
    
        if(!empty($paymentList)){
            foreach($paymentList as $key=>$value){ 
                
               $html .= '<div class="step completed">
                    <div class="details">
                        <h4>'.ucwords($value['paymode']).' '.($value['paymode']=='cash'?'Recieved':'Payment').'</h4>
                        <p> '.date('d/m/Y',strtotime($value['added_on'])).'</p>
                        <p><strong>'.$value['amount'].' INR  </strong> By '.$value['add_by'].'</p>
                    </div>
                    <div class="admin-verify">
                        <span>Verified by ADMIN</span>
                        <img src="'.base_url('assets/images/blue_tick.png').'" alt="Verified">
                    </div>
                </div>';
            }
        }

        
    echo $html;
}
   

}
?>