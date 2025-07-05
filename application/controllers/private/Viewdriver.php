<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewdriver extends CI_Controller{
	
	  function __construct() {
         parent::__construct(); 
		  adminlogincheck();
      }
	


  public function index() {

	        $title = 'View Driver(s)';
	        $data['title'] = $title;
	        $data['list'] = array();
	        $get = $this->input->get();
	        $where = null; 
	        


			$table = 'driver';
			$pagename = 'viewdriver';    
 

			$uniqueid = ''; 

			$data['prebtn'] = NULL;
			$data['nxtbtn'] = NULL;
			$data['startbtn'] = NULL;
			$data['endbtn'] = NULL;

  	        /*********************check user type ******************************/
 				$data = array();
 			  $output = array(); 
		     $likekey = NULL;
			    $like = NULL;
			   $where = array(); 
	   

	   	   $currentdate = date('Y-m-d');
	       $currentdt = date('Y-m-d G:i:s');

             
 
			$filterby = !empty($get['filterby']) ? $get['filterby'] : '';
			$requestparam = !empty($get['requestparam']) ? $get['requestparam'] : '';


			$start = null;
			$limit = null; 

		  $orderby = 'DESC'; 
	   $orderbykey = 'id';   
	$operationcity = NULL;    

            
			


			if( $filterby == 'uniqueid' ){
				$where['uniqueid'] = $requestparam;
			 
			}else if( $filterby == 'name' ){
				$like = $requestparam;
				$likekey = 'fullname'; 
			 
			}else if( $filterby == 'city' ){ 
				$requestparam ? ($where['operationcity'] = $requestparam) : '';
			
			}else if( $filterby == 'date' ){
				
				if(strpos($requestparam, '|') !== false) {
				$datearr =!empty($requestparam) ? explode('|',$requestparam ) : '';
				$startdate = date('Y-m-d', strtotime($datearr[0]) );
				$enddate = date('Y-m-d', strtotime($datearr[1]) );
				$where['DATE(add_date) >= '] = $startdate;
				$where['DATE(add_date) <= '] = $enddate;
				
				}else{
				     $date = date('Y-m-d', strtotime($requestparam) );
			         $where['DATE(add_date)='] = $date ;
				     }
			} 
			
isset( $get['operationcity']) ? ($where['operationcity'] = $get['operationcity']) : '';

if( isset( $get['uniqueid'] )){
	$uniqueid = $get['uniqueid'];
	$countstrng = strlen($uniqueid);
	if( $countstrng == 12 && filter_var($uniqueid,FILTER_SANITIZE_NUMBER_INT)){
    $where['uniqueid'] = $uniqueid;
	}elseif($countstrng==10 && filter_var($uniqueid,FILTER_SANITIZE_NUMBER_INT)){
    $where['mobileno'] = $uniqueid;
	}else if(filter_var($uniqueid,FILTER_SANITIZE_STRING)){
		$like = $uniqueid;
	    $likekey = 'fullname'; 
	}

 }
			
		  //  print_r( $where );
			
			$limit = !empty($limit) ? $limit : NULL;
			$start = !empty($start) ? $start : NULL;
			$like = !empty($like) ? $like : NULL;
			$likekey = !empty($like) ? $likekey : NULL;
			$whereor = !empty($whereor) ? $whereor : NULL;
			$whereorkey = !empty($whereor) ? $whereorkey : NULL;
			$data['list'] = array();
			$data['totalrows'] = 0;
	
	
			 
	$getdata = $this->c_model->getfilter($table, $where, $limit, $start, $orderby, $orderbykey, $whereor,$whereorkey, $like, $likekey, 'get' ); 
 
			
			if( !empty($getdata) ){ 
				 $data['list'] = $getdata;
				 $data['totalrows'] = count($getdata);
			}
  	        /*********************check user type ******************************/
 
// echo '<pre>'; print_r($getdata);


	  


	   $data['title'] = $title .' List &nbsp; [ <span style="font-size:12px;color:red">   Total Records: '.$data['totalrows'].' </span>] Filtered [ <span style="font-size:12px;color:green">'.($start ? $start : '0').' - '.($start + $limit).' </span>]'; 
		     
 
			 
		    _viewlist( $pagename, $data ); 
 
	    
   }
   

}
?>