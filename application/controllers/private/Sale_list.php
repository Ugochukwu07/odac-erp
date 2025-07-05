<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_list extends CI_Controller{
	  var $pagename;
      var $table;
	  function __construct() {
         parent::__construct(); 
		  adminlogincheck();
		  $this->pagename = 'sale_list';
		  $this->table = 'pt_booking';
		  $this->load->helper('slip');
      }
	


  public function index() {

			$data = [];
			$output = [];  

	        $title = 'Sale List';
	        $data['title'] = $title;
	        $data['exporturl'] = '';
	        $data['list'] = [];
			$data['totalrows'] = 0;
	        $get = $this->input->get(); 
	        
	        $data['uid'] = !empty($get['uid']) ? $get['uid'] : '';
	        $data['month'] = !empty($get['month']) ? $get['month'] : '';
	        $data['year'] = !empty($get['year']) ? $get['year'] : '';
	        
	        $type = !empty($get['type']) ? $get['type'] : '';
			   
	        
	        
	        $where = '';
	        $where = "WHERE attemptstatus NOT IN('temp','cancel','reject')"; 
	        $where .= "AND DATE(bookingdatetime) >= '2023-12-01' ";
	        
	        if($type=='today'){
	            $where .= "AND DATE(bookingdatetime) = '".date('Y-m-d')."' ";
	        }
	        else if( !empty($data['month']) && !empty($data['year']) ){
	            $where .= "AND MONTH(bookingdatetime) = '".$data['month']."' ";
	            $where .= "AND YEAR(bookingdatetime) = '".$data['year']."' ";  
	        }
	        else{
	            $where .= "AND MONTH(bookingdatetime) = '".date('m')."' ";
	            $where .= "AND YEAR(bookingdatetime) = '".date('Y')."' ";  
	        }
	        
	        //filter by user
	        if(!empty( $data['uid'])){
	             $where .= "AND add_by = '".$data['uid']."' ";
	        }
	        
	        
	        $sqlQuery = "SELECT COUNT(*) AS no_of_bookings, add_by, add_by_name, YEAR(bookingdatetime) AS year, MONTH(bookingdatetime) AS month, SUM(totalamount) AS total_amount, SUM(restamount) AS rest_amount, SUM(bookingamount) AS advance_amount, SUM( (ext_days*vehicle_price_per_unit) ) AS extend_amount FROM pt_booking ".$where." GROUP BY add_by, YEAR(bookingdatetime), MONTH(bookingdatetime) ORDER BY add_by, year, month ";
	         
	        $getData = $this->db->query( $sqlQuery )->result_array(); 
	        
	        $data['list'] = $getData;
	        
	        
            $total_sale = 0;
            $total_advance = 0;
            $total_rest = 0;
            $total_extend = 0;
	        
	        
	        //sum data
	        if( !empty($getData) ){ 
	            foreach( $getData as $key=>$value ){
                    $total_sale += $value['total_amount'];
                    $total_advance += $value['advance_amount'];
                    $total_rest += $value['rest_amount'];
                    $total_extend += $value['extend_amount'];
	            } 
	        }
	        
	        
	        $data['total_sale'] = $total_sale;
	        $data['total_advance'] = $total_advance;
	        $data['total_rest'] = $total_rest;
	        $data['total_extend'] = $total_extend;
	        
	        
	        
	        $data['title'] = $title .' &nbsp; [ <span style="font-size:12px;color:red">   Total Records: <span id="totalBookings">'.(!empty($getData) ? count($getData) : 0).'</span> </span>]';  
	        
	          
	       $data['userlist'] = get_dropdownsmulti('pt_roll_team_user',['status'=>'yes'],'mobile','fullname', 'User--' );
             
             // echo '<pre>';
	       // print_r($data); exit;
		 
			 
	        _viewlist( strtolower($this->pagename), $data );  
   }
   
   
}
?>