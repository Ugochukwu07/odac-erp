<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customerlist extends CI_Controller{
	 var $pagename;
     function __construct() {
         parent::__construct();  
	     adminlogincheck();
	     $this->pagename = 'customer_list';
     }	
	
	 
	public function index(){
	    
	        $is_export = $this->input->get('is_export');
	        $post = $this->input->get(); 
		    
		    $data = [];
		    $data['title'] = 'Customer List';
		     
		     
		    //export csv report 
            if( !empty($is_export) ){
                $list = $this->getRecordsFromDb( $post );
		        $this->exportCSV( $list );
		    }
            
            
            $data['exporturl'] = adminurl('Customerlist?is_export=yes'); 
  
		    _viewlist( strtolower($this->pagename), $data ); 
		}


protected function getRecordsFromDb( $post , $limit = null , $start = null, $is_count = null ){  
      
            $like = null;
            $likekey = null;
            $likeaction = null; 
            $join = null;
            $groupby = null;
            $in_not_in = null;
		    
            
            $select = "DATE_FORMAT(add_date,'%d-%b-%Y') as add_date,id,uniqueid,fullname,emailid,mobileno,status"; 
		    $from = 'pt_customer';
		    
		    
		    $orderby = 'id DESC';
		    
		    $where = [];
            
            
            if( !empty($post['search']['value']) ) {  
                $serchStr = trim($post['search']['value']) ;
                $where[" ( uniqueid LIKE '%".$serchStr."%' OR fullname LIKE '%".$serchStr."%' OR emailid LIKE '%".$serchStr."%' )"] = NULL;
                $limit = 100;
                $start = 0;
            }
            
            
            if( $is_count == 'yes' ){
                $select = 'id'; 
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
    
    //$pageno = (int)( $post['start'] == 0 ? 1 : $post['length'] + 1 ); 
    $is_count = !empty($post['is_count']) ? $post['is_count'] : '';
    $totalRecords = !empty($post['recordstotal']) ? $post['recordstotal'] : 0; 
  
    $limit = (int)( !empty($_REQUEST['length']) ? $_REQUEST['length'] : 10 );
    $start = (int) !empty($_REQUEST['start'] ) ? $_REQUEST['start'] : 0; 

    if( $is_count == 'yes' ){
        echo $this->getRecordsFromDb( $post , null , null , $is_count );  exit;
    }else{ 

       
    $result = [];
    $getdata = $this->getRecordsFromDb( $post , $limit, $start, $is_count );
    if( !empty($getdata) ){
			$i = $start + 1;
			foreach ($getdata as $key => $value) {
				$push = [];
				$push =  $value;
				$push['sr_no'] = $i;
				$push['enc_id'] = md5($value['id']);  
				array_push($result, $push );
				$i++;
			}
	}
    
	$json_data = array();
    $draw = isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0;

	if( !empty($_REQUEST['search']['value']) ) { 
		$countItems = !empty($result) ? count( $result ) : 0; 
		$json_data['draw'] = $draw;
		$json_data['recordsTotal'] = intval( $countItems );
		$json_data['recordsFiltered'] =  intval( $countItems );
		$json_data['data'] = !empty($result) ? $result : [];  
	}else{ 
		$json_data['draw'] = $draw;
		$json_data['recordsTotal'] = intval($totalRecords );
		$json_data['recordsFiltered'] =  intval($totalRecords);
		$json_data['data'] = !empty($result) ? $result : [];  
	}       

    echo json_encode( $json_data );

    } 

}



	function exportCSV( $list ){
		    
		       // file name 
               $filename = 'All_Documents_'.date('Y-m-d').'.csv'; 
               header("Content-Description: File Transfer"); 
               header("Content-Disposition: attachment; filename=$filename"); 
               header("Content-Type: application/csv; ");
               
               $dformat = 'd-m-Y';
               
               
               // file creation 
               $file = fopen('php://output', 'w');
             
               $header = array("Sno","Vehicle Name","Vehicle Number","Fuel Type","Model Year","White Pemit From","White Pemit To Date","Permit From Date","Permit To Date","Tax From Date","Tax To Date","Fitness From Date","Fitness To Date","Insurence From Date","Insurence To Date","Pollution From Date","Pollution To Date" ); 
               fputcsv($file, $header); $i=1;
               foreach ($list as $key=>$value){
                   $line = [];
                   $line[] = $i;
                   $line[] = $value['model'];
                   $line[] = $value['vnumber'];
                   $line[] = $value['fueltype'];
                   $line[] = $value['vyear']; 
                   $line[] = dateformat($value['white_permit_from'], $dformat );
                   $line[] = dateformat($value['white_permit_till'],$dformat);
                   $line[] = dateformat($value['permit_from'],$dformat);
                   $line[] = dateformat($value['permit_till'],$dformat);
                   $line[] = dateformat($value['tax_from'],$dformat);
                   $line[] = dateformat($value['tax_till'],$dformat);
                   $line[] = dateformat($value['fitness_from'], $dformat);
                   $line[] = dateformat($value['fitness_till'],$dformat);
                   $line[] = dateformat($value['insurence_from'],$dformat);
                   $line[] = dateformat($value['insurence_till'],$dformat);
                   $line[] = dateformat($value['polution_from'],$dformat);
                   $line[] = dateformat($value['polution_till'],$dformat);
                 fputcsv($file,$line); 
                 $i++;
               }
               fclose($file); 
               exit; 
   
		}
		

	 public function delete() { 
	 	    $table = 'pt_vehicle_details';
	        $getid = $this->input->get() ? $this->input->get('delId') : array();  
	         
		    redirect( adminurl('customerlist'));
	    
   }  
   

}
?>