<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_list extends CI_Controller{
	var $pagename;
	var $table;
     function __construct() {
			parent::__construct();  
			adminlogincheck();
			$this->pagename = 'menu_list';
			$this->table = 'pt_menu_list';
     }	
	
	 
	public function index(){ 

		    $data['title'] = 'View Menu List ';
		    $data['pageno'] = 0;
		    $data['uid'] = '';

		    $get = $this->input->get() ? $this->input->get() : [];



			$table = $this->table;
			$orderby = 'id ASC';
			$where = null;
			$keys = '*';
			$start = 0;
			$limit = 500;

			if(!empty($get['pageno'])){
				$start = (int)$limit * (int) ($get['pageno']-1) ; 
			    $data['pageno'] = $get['pageno'];
			}
  
		    $getdata = $this->c_model->getAll( $table, $orderby, $where, $keys, '500' ); 
			
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