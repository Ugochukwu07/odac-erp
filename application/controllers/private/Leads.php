<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends CI_Controller{
	  var $pagename;
      var $table;
	  function __construct() {
         parent::__construct(); 
		  adminlogincheck();
		  $this->pagename = 'leads';
		  $this->table = 'pt_leads';
      }
	


  public function index() {

			$data = [];
			$output = []; 

	        $title = 'Leads List';
	        $data['title'] = $title;
	        $data['exporturl'] = '';
	        $data['list'] = [];
			$data['totalrows'] = 0;
	        $get = $this->input->get();   

			 
			$where = []; 
			   
			$leadtype = $get['type'];
			$data['leadtype'] = $get['type'];
			$data['totalpage'] = NULL;
			$data['page'] = NULL;
			$data['prebtn'] = NULL;
			$data['nxtbtn'] = NULL;
			$data['startbtn'] = NULL;
			$data['endbtn'] = NULL;
			
			//check csv report key
			$is_csv_export = !empty($get['csv_report']) ? $get['csv_report'] : false ;
			$data['exporturl'] = base_url('private/'.strtolower($this->pagename).'?type='.$leadtype.'&csv_report=yes'); 
			
			 $post = $this->input->post();
                $get = $this->input->get();
                $post = array_merge($get,$post);
                
			$n = isset($post['n']) && !empty($post['n'])?trim($post['n']):false;
            $f = isset($post['f']) && !empty($post['f'])?trim($post['f']):false;
            $t = isset($post['t']) && !empty($post['t'])?trim($post['t']):false;
            $data['n'] = $n;
            $data['f'] = $f;
            $data['t'] = $t;
 
 
            if(!empty($is_csv_export)){ 
               // $getdata = $this->getRecoprdsFromDb( $post , $limit = null , $start = null, $is_count = null );
               // $this->exportCSV( $getdata,$bookingtype );
            }  

	        $data['title'] = $title .' &nbsp; [ <span style="font-size:12px;color:red">   Total Records: <span id="totalBookings">0</span> </span>]';  
			 
	        _viewlist( strtolower($this->pagename), $data );  
   }
   
  
  protected function getRecoprdsFromDb( $post , $limit = null , $start = null, $is_count = null ){
      
        	$where = []; 
            $like = null;
            $likekey = null;
            $likeaction = null;
            
            $leadtype = $post['type']; 
            
            
            /*filter script start here*/
            $n = isset($post['n']) && !empty($post['n'])?trim($post['n']):false;
            $f = isset($post['f']) && !empty($post['f'])?trim($post['f']):false;
            $t = isset($post['t']) && !empty($post['t'])?trim($post['t']):false;
            $data['n'] = $n;
            $data['f'] = $f;
            $data['t'] = $t;
            $ismobile = filter_var($n,FILTER_SANITIZE_NUMBER_INT);
            $isemail = filter_var($n,FILTER_VALIDATE_EMAIL);
            if( strlen($ismobile) == 10 ){
            $where['a.mobile_no'] = $ismobile;
            }else if( $isemail ){
            $where['a.email_id'] = $n; 
            }else if( strpos($n, 'RCLD') !== FALSE ){
            $where['a.lead_uid'] = $n;
            }
            else {
            $like = $n;
            $likekey = 'a.full_name';
            $likeaction = 'both';
            }
            
            if(!empty($f) && !empty($f) ){
            $where['DATE(a.add_date) >='] = $f;
            $where['DATE(a.add_date) <='] = $t;
            }
            /*filter script start here*/
            
            
            $select = 'a.*, DATE_FORMAT(a.add_date,"%d-%b-%Y %r") as added_date, DATE_FORMAT(a.picked_date,"%d-%b-%Y %r") as pickeddate, md5(a.id) as enc_id, b.domain';//,c.fullname as lead_fullname, c.mobile as lead_mobile';
            $from = 'pt_leads as a'; 
            $join[0]['table'] = 'pt_domain as b';
            $join[0]['on'] = 'a.domain_id = b.id';
            $join[0]['key'] = 'LEFT';
            
            //$join[1]['table'] = 'pt_roll_team_user as c';
            //$join[1]['on'] = 'a.picked_by_id = c.id';
            //$join[1]['key'] = 'LEFT';
            
            $groupby  = null;
            $orderby = 'a.id DESC'; 
            
            $in_not_in = null; 
            
            
            if( !empty($post['search']['value']) ) {  
                $serchStr = trim($post['search']['value']) ;
                $where[" ( a.mobile_no LIKE '%".$serchStr."%' OR a.full_name LIKE '%".$serchStr."%' OR a.lead_uid LIKE '%".$serchStr."%'  OR a.email_id LIKE '%".$serchStr."%' )"] = NULL;
                $limit = 100;
                $start = 0;
            }
            
            
            if( $is_count == 'yes' ){
                $select = 'a.id'; 
                $getdata = $this->c_model->joindata( $select, $where, $from, $join, null,null,null,null,$like,$likekey,$likeaction, null );  
                return !empty($getdata) ? count($getdata) : 0 ; 
            }else{
                 
                $getdata = $this->c_model->joindata( $select, $where, $from, $join, $groupby, $orderby, $limit, $in_not_in, $like, $likekey, $likeaction, $start ); 
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
        echo $this->getRecoprdsFromDb( $post , null , null , $is_count );  exit;
    }else{ 

       
    $result = [];
    $getdata = $this->getRecoprdsFromDb( $post , $limit , $start, $is_count );
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





public function confirm(){
 	$request = $this->input->get(); 

 	$id = $request['id'];
 	$redirect = $request['redirect'];

 

 	$save = []; 
 	$save['lead_status'] = 'picked';  
 	
 	 
     
     if($loginUser = $this->session->userdata('adminloginstatus')){ 
      $post['picked_date'] = date('Y-m-d H:i:s');
      $save['picked_by_id'] = $loginUser['logindata']['id'];
      $save['picked_by_name'] = $loginUser['logindata']['fullname'];
      $save['picked_by_mobile'] = $loginUser['logindata']['mobile'];
     } 
     
 	$where['id'] = $id;

 	$update = $this->c_model->saveupdate('pt_leads', $save, null, $where );  
 

	$this->session->set_flashdata('success',"Lead picked up Successfully!");

	redirect( adminurl('leads/?type='.$redirect ) );
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
             
               $header = array("Sno","Booking ID","Trip Type","Customer Name","Mobile","Email","Pickup City","Pickup Address","Drop City","Drop Address","Pickup Date","Drop Date","Vehicle Name","Vehicle Number","Status" ); 
               fputcsv($file, $header); $i=1;
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
                   $line['lead_status'] = $value['lead_status']; 
                 fputcsv($file,$line); 
                 $i++;
               }
               fclose($file); 
               exit; 
   
		}
   
   

}
?>