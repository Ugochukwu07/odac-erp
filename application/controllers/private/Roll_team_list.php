<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Roll_team_list extends CI_Controller{
	var $pagename;
	var $table;
     function __construct() {
			parent::__construct();  
			adminlogincheck();
			$this->pagename = 'roll_team_list';
			$this->table = 'pt_roll_team_user';
     }	
	
	 
	public function index(){ 

		    $data['title'] = 'View Roll Team List ';
		    $data['pageno'] = 0;
		    $data['uid'] = '';

		    $get = $this->input->get() ? $this->input->get() : [];



			$table = $this->table;
			$orderby = 'id DESC';
			$where = null;
			$keys = "* ,(SELECT SUM(bookingamount) FROM `pt_booking` WHERE `add_by` = `mobile` and DATE(bookingdatetime) = '".date('Y-m-d')."') AS collect_today";
			$start = 0;
			$limit = 200;

			if(!empty($get['pageno'])){
				$start = (int)$limit * (int) ($get['pageno']-1) ; 
			    $data['pageno'] = $get['pageno'];
			}

			if(!empty($get['mobile'])){
				$where['mobile'] =  $get['mobile']; 
			    $data['mobile'] = $get['mobile'];
			}
 


		    $getdata = $this->c_model->getAll( $table, $orderby, $where, $keys ); 
			
			$data['list'] = $getdata;

			/* pagination list data start here */
		    $countrows = !empty($getdata) ? count($getdata) : 0 ;

			$data['prebtn'] = '';
			$data['nxtbtn'] = ''; 

			if($countrows <= $limit ){
			$data['prebtn'] = ($data['pageno'] > 1) ? adminurl($this->pagename.'/index?uid='.$data['uid'].'&pageno='.($data['pageno']-1)) : ''; 
			}

			if($countrows == $limit ){
			$data['nxtbtn'] =  adminurl($this->pagename.'/index?uid='.$data['uid'].'&pageno='.($data['pageno'] + 1));
			}  
			/* pagination list data end here */ 
		    
		    _viewlist( strtolower($this->pagename) , $data );
 
	}



 public function deleterecord(){

	$get = $this->input->get();  
	$delId  = !empty($get['delId']) ? $get['delId'] : 0;  
	$delete = $this->c_model->delete( $this->table , ['md5(id)'=>$delId] ); 

	$this->session->set_flashdata('success','Data Deleted Successfully!');
	redirect( adminurl( $this->pagename.'?pageno='.$pageno ) ); 
	exit;
} 



} 
?>