<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_claim extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
	     $this->pagename = 'vehicle_claim';
	     $this->table = 'pt_vehicle_service_claim';
	     
        /*check domain start*/
        if(  !checkdomain() ){
         redirect( adminurl('Changedomain?return='.$currentpage ) );
        }
        /*check domain end*/ 
  	
     }	


  public function index() {  

	$data['posturl'] = adminurl($this->pagename.'/savedata');

	$table = $this->table;
    $id = $this->input->get('id') ? $this->input->get('id') : '';
    $vehicle_con_id = $this->input->get('vehicle_con_id') ? $this->input->get('vehicle_con_id') : '';
	$redirect =  $this->input->get('redirect') ? $this->input->get('redirect') : '';
	
	$data['title'] = 'Add/Update Vehicle Claims';
	$data['redirect'] = $redirect;

	$data['id'] = '';
	$data['vehicle_con_id'] = $vehicle_con_id;
	$data['claim_date'] =  date('d-m-Y');
	$data['claim_details'] = '';
	$data['amount'] = '';
	$data['claim_cleared'] = 'no';
	$data['catid'] = '';
	$data['clear_claim_date'] = '';
	$data['claim_sequence'] = ''; 
	$data['policy_no'] = ''; 
	$data['policy_valid_from'] = date('d-m-Y'); 
	$data['policy_valid_till'] = date('d-m-Y');
	$data['company_id'] = ''; 
    $data['insu_company_name'] = '';
	
	$dateformat = 'd-m-Y';
	
	/*get vehicle Policy Number from vehiclke DOcument list*/
	if( !empty($vehicle_con_id)){
	 $getConData = $this->db->query("select insurence_from, insurence_till, policy_no, company_id,insu_company_name   from pt_vehicle_details where vehicle_con_id = '".$vehicle_con_id."' ORDER BY id DESC LIMIT 1 ")->row_array();
         
         if(!empty($getConData)){
             $data['policy_valid_from'] = !empty($getConData['insurence_from']) ? date( $dateformat , strtotime($getConData['insurence_from'])) : '';
             $data['policy_valid_till'] = !empty($getConData['insurence_till']) ? date( $dateformat , strtotime($getConData['insurence_till'])) : '';
             $data['policy_no'] = !empty($getConData['policy_no']) ? $getConData['policy_no'] : '';
             $data['company_id'] = !empty($getConData['company_id']) ? $getConData['company_id'] : '';
             $data['insu_company_name'] = !empty($getConData['insu_company_name']) ? $getConData['insu_company_name'] : '';
         }
	}
	
 
 
	

	if( $id ){
     $old_dta = $this->c_model->getSingle($table,['md5(id)'=>$id],'*');
            $data['id'] = $old_dta['id'];
            $data['vehicle_con_id'] =  $old_dta['vehicle_con_id'];
            $data['claim_date'] = date($dateformat,strtotime($old_dta['claim_date']));
            $data['claim_details'] =  $old_dta['claim_details'];
            $data['amount'] =  $old_dta['amount'];
            $data['claim_cleared'] =  $old_dta['claim_cleared'];
            $data['clear_claim_date'] = $old_dta['claim_cleared'] == 'yes' ?  date($dateformat,strtotime($old_dta['clear_claim_date'])) : '';
            $data['claim_sequence'] =  $old_dta['claim_sequence'];
            $data['catid'] =  $old_dta['catid'];
            $data['policy_no'] =  $old_dta['policy_no'];
            $data['company_id'] =  $old_dta['company_id'];
            $data['insu_company_name'] =  $old_dta['insu_company_name'];
            $data['policy_valid_from'] = date($dateformat,strtotime($old_dta['policy_valid_from']));
            $data['policy_valid_till'] = date($dateformat,strtotime($old_dta['policy_valid_till']));
            
                /*get vehicle Policy Number from vehiclke DOcument list*/
                if( !empty($old_dta['policy_no']) && empty($old_dta['company_id'])){
                 $getConData = $this->db->query("select insurence_from, insurence_till, policy_no, company_id,insu_company_name   from pt_vehicle_details where policy_no = '".$old_dta['policy_no']."' ORDER BY id DESC LIMIT 1 ")->row_array();
                     
                     if(!empty($getConData)){
                         $data['policy_valid_from'] = !empty($getConData['insurence_from']) ? date( $dateformat , strtotime($getConData['insurence_from'])) : '';
                         $data['policy_valid_till'] = !empty($getConData['insurence_till']) ? date( $dateformat , strtotime($getConData['insurence_till'])) : '';
                         $data['policy_no'] = !empty($getConData['policy_no']) ? $getConData['policy_no'] : '';
                         $data['company_id'] = !empty($getConData['company_id']) ? $getConData['company_id'] : '';
                         $data['insu_company_name'] = !empty($getConData['insu_company_name']) ? $getConData['insu_company_name'] : '';
                     }
                }
	
	
	}
	
	$keyExtraKey = 'vnumberdt';
	$select = "CONCAT(vnumber,',',(SELECT model FROM pt_vehicle_model WHERE id = modelid )) as vnumberdt"; 
	$wherevh = [];
	$wherevh['status'] = 'yes';
	if( in_array( $redirect, ['bike','car'])){
	    $carBikeId = $redirect == 'bike' ? 2 : 1;
	    $wherevh["modelid IN( SELECT id FROM pt_vehicle_model WHERE catid = '".$carBikeId."' )"] = NULL; 
	}
	

	
	$data['vehiclelist'] = get_dropdownsmultitxt('pt_con_vehicle',$wherevh,'id','vnumber',' Vehicle ---', $select, $keyExtraKey ); 
	
 
 
	 _view( 'add_vehicle_claim', $data );
	  
 }


 public  function savedata(){
     
     	$post = $this->input->post();

		$id = $post['id'];
		$redirect =  $post['redirect'];  
		
// 		echo '<pre>';
// 		print_r( $post); exit;

		 
	        $sdata['vehicle_con_id'] =  $post['vehicle_con_id'];
            $sdata['claim_date'] = !empty($post['claim_date'])?date('Y-m-d',strtotime($post['claim_date'])):NULL;
            $sdata['policy_valid_till'] = !empty($post['policy_valid_till'])?date('Y-m-d',strtotime($post['policy_valid_till'])):NULL;
            $sdata['policy_valid_from'] = !empty($post['policy_valid_from'])?date('Y-m-d',strtotime($post['policy_valid_from'])):NULL;
            $sdata['amount'] =  $post['amount'];
            $sdata['claim_sequence'] =  $post['claim_sequence'];
            $sdata['claim_cleared'] =  $post['claim_cleared'];
            $sdata['policy_no'] =  $post['policy_no'];
            $sdata['company_id'] =  $post['company_id'];
            $sdata['insu_company_name'] =  $post['insu_company_name'];
            if( $sdata['claim_cleared'] == 'yes'){
             $sdata['clear_claim_date'] = !empty($post['clear_claim_date'])?date('Y-m-d',strtotime($post['clear_claim_date'])):NULL; ;
             if(empty($post['clear_claim_date'])){
                $this->session->set_flashdata('error',"Claim Cleared date is Blank!");
                redirect( adminurl( $this->pagename.'/?id='.md5($id).'&redirect='.$redirect )); exit;
             }
            }
            $sdata['claim_details'] =  $post['claim_details'];
            
            //get vehicle category id
            $catId = $this->db->query("SELECT catid FROM pt_vehicle_model WHERE id = (SELECT modelid FROM pt_con_vehicle WHERE id='".$post['vehicle_con_id']."') ")->row_array();
            if(!empty($catId['catid'])){
              $sdata['catid'] =  $catId['catid'];  
            }

		$sdata = $this->security->xss_clean($sdata);
		
		$upwh = null;  $check = null;
		if( $id ){
			$upwh['id'] = $id;
		} 
		
		if( empty($id) ){
		    //$check = [];
			//$check['vehicle_con_id'] = $post['vehicle_con_id'];
			$sdata['add_date'] =  date('Y-m-d H:i:s');
		} 
		
		
		 
		 
		$update = $this->c_model->saveupdate( $this->table , $sdata, $check, $upwh );
		
		
		if( $update && $id ){
		$this->session->set_flashdata('success',"Data updated successfully!");
		redirect( adminurl( $this->pagename.'/?id='.md5($id).'&redirect='.$redirect ));
		
		}else if( $update && !$id){ 
		$this->session->set_flashdata('success',"Data inserted successfully!");
		redirect( adminurl( $this->pagename.'?redirect='.$redirect )) ;
		  
		}else if( !$update ){
		$this->session->set_flashdata('error',"Duplicate Entry!");
		redirect( adminurl( $this->pagename.'?redirect='.$redirect )) ;
		}
		
		
	 
 } 
   
  
  


 public function list() {

			$data = [];
			$output = []; 

	        $title = 'Vehicle Insurence Claim List';
	        $data['title'] = $title;
	        $data['exporturl'] = '';
	        $data['list'] = [];
			$data['totalrows'] = 0;
	        $get = $this->input->get(); 
	        $redirect = !empty($get['type']) ? $get['type'] : '';
	        

			 
			$where = []; 
			    
			$data['redirect'] = $redirect;
			$data['type'] = !empty($get['type']) ? $get['type'] : 'all';
			$data['totalpage'] = NULL;
			$data['page'] = NULL;
			$data['prebtn'] = NULL;
			$data['nxtbtn'] = NULL;
			$data['startbtn'] = NULL;
			$data['endbtn'] = NULL;
			
			//check csv report key
			$is_csv_export = !empty($get['csv_report']) ? $get['csv_report'] : false ;
			$data['exporturl'] = base_url('private/'.strtolower($this->pagename).'/list?type='.$data['type'].'&csv_report=yes'); 
			
			 $post = $this->input->post();
                $get = $this->input->get();
                $post = array_merge($get,$post);
                
		 
 
 
            if(!empty($is_csv_export)){ 
                $getdata = $this->getRecoprdsFromDb( $post , $limit = null , $start = null, $is_count = null );
                $this->exportCSV( $getdata,$data['type'] );
            }  

	        $data['title'] = $title .' &nbsp; [ <span style="font-size:12px;color:red">   Total Records: <span id="totalBookings">0</span> </span>]';  
	        
	        
	         //vehicle drop down list
            $keyExtraKey = 'vnumberdt';
            $select = "CONCAT(vnumber,',',(SELECT model FROM pt_vehicle_model WHERE id = modelid )) as vnumberdt"; 
            $where = [];
            $where["status"] = 'yes';
            if(in_array($redirect,['car','bike'])){
                $where["modelid IN( SELECT id FROM pt_vehicle_model WHERE catid = '".($redirect=='car'?1:2)."' )"] = NULL;
            }
            
            
            $data['vehiclelist'] = get_dropdownsmultitxt('pt_con_vehicle',$where,'md5(id)','vnumber',' Vehicle ---', $select, $keyExtraKey );
	        
			 
	        _viewlist( 'vehicle_claim_list', $data );  
   }
   
  
  protected function getRecoprdsFromDb( $post , $limit = null , $start = null, $is_count = null ){
      
        	$where = []; 
            $like = null;
            $likekey = null;
            $likeaction = null;
            
            $claimtype = !empty($post['type']) ? $post['type'] : ''; 
            if( !empty($claimtype) ){
                $where['a.catid'] = $claimtype == 'bike' ? 2 : 1;
            }
            
            //filter
            $get_vcid = $this->input->get('vcid');
	        $get_vcid2 = $this->input->get('vcid2'); 
	        
	        if(!empty($get_vcid)){
		     $where['md5(a.vehicle_con_id)'] = $get_vcid;   
		    }
		    else if(!empty($get_vcid2)){
		     $where['b.vnumber'] = trim($get_vcid2);   
		    }
		    
            
            
            $select = 'a.*, DATE_FORMAT(a.add_date,"%d-%b-%Y %r") as add_date, DATE_FORMAT(a.claim_date,"%d-%b-%Y") as claim_date, DATE_FORMAT(a.clear_claim_date,"%d-%b-%Y") as clear_claim_date, md5(a.id) as enc_id,  b.modelid, b.vnumber,b.vyear,b.fueltype, c.model,d.category,DATE_FORMAT(a.policy_valid_from,"%d-%b-%Y") as policy_valid_from,DATE_FORMAT(a.policy_valid_till,"%d-%b-%Y") as policy_valid_till, a.policy_no ';
            $from = 'pt_vehicle_service_claim as a'; 
            
            $join[0]['table'] = 'pt_con_vehicle as b';
		    $join[0]['on'] = 'a.vehicle_con_id = b.id';
		    $join[0]['key'] = 'LEFT';

		    $join[1]['table'] = 'pt_vehicle_model as c';
		    $join[1]['on'] = 'b.modelid = c.id';
		    $join[1]['key'] = 'LEFT';
		   
		    $join[2]['table'] = 'pt_vehicle_cat as d';
		    $join[2]['on'] = 'c.catid = d.id';
		    $join[2]['key'] = 'LEFT';
            
            $groupby  = null;
            $orderby = 'a.id DESC'; 
            
            $in_not_in = null; 
            
            
            if( !empty($post['search']['value']) ) {  
                $serchStr = trim($post['search']['value']) ;
                $where[" b.vnumber LIKE '%".$serchStr."%' OR c.model LIKE '%".$serchStr."%' OR a.amount = '".$serchStr."' "] = NULL;
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
    //echo '<pre>'; print_r($getdata); exit;
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


public function delete() { 
	 	    $table = 'pt_vehicle_details';
	        $getid = $this->input->get() ? $this->input->get('delId') : array(); 
	        $redirect = $this->input->get('redirect') ? $this->input->get('redirect') : ''; 
	        $where['md5(id)'] = $getid; 
		    $status = $getid ? $this->c_model->delete( $this->table , $where ) : '';
		    $message = $getid && $status ? 'Data Deleted Successfully' :'Some Error Occured';
		    $this->session->set_flashdata('error', $message ); 
		    redirect( adminurl('Vehicle_claim/list?type='.$redirect ));
	    
 } 
 
 function exportCSV( $list, $type ){
     
    //  echo '<pre>';
    //  print_r( $list ); exit;
		    
		       // file name 
               $filename = 'All_claim_details_'.date('Y-m-d').'.csv'; 
               header("Content-Description: File Transfer"); 
               header("Content-Disposition: attachment; filename=$filename"); 
               header("Content-Type: application/csv; ");
               
               $dformat = 'd-m-Y';
               
               
               // file creation 
               $file = fopen('php://output', 'w');
             
               $header = array("Sno","Vehicle Name","Vehicle Number","Fuel Type","Model Year","Policy Number","Policy Valid From Date","Policy Valid Till Date","Claim Date","Claim Amount","Claim Status","Claim Clear Date","Claim Sequence","Add Date" ); 
               fputcsv($file, $header); $i=1;
               foreach ($list as $key=>$value){
                   $line = [];
                   $line[] = $i;
                   $line[] = $value['model'];
                   $line[] = $value['vnumber'];
                   $line[] = $value['fueltype'];
                   $line[] = $value['vyear']; 
                   $line[] = $value['policy_no']; 
                   $line[] = dateformat($value['policy_valid_from'], $dformat );
                   $line[] = dateformat($value['policy_valid_till'],$dformat);
                   $line[] = dateformat($value['claim_date'],$dformat);
                   $line[] = $value['amount'];
                   $line[] = $value['claim_cleared']=='yes'?'Clear':'Pending';
                   $line[] = $value['clear_claim_date'] ? dateformat($value['clear_claim_date'],$dformat):'';
                   $line[] = $value['claim_sequence'];
                   $line[] = dateformat($value['add_date'],$dformat); 
                 fputcsv($file,$line); 
                 $i++;
               }
               fclose($file); 
               exit; 
   
		}
		
		
 function getpolicyno(){
     $post = $this->input->post() ? $this->input->post() : '' ;
     $vehi_con_id = $post['id'];
     
     $getData = $this->db->query("select insurence_from, insurence_till, policy_no   from pt_vehicle_details where vehicle_con_id = '".$vehi_con_id."' ORDER BY id DESC LIMIT 1 ")->row_array();
     $output['from'] = !empty($getData['insurence_from']) ? date( 'd-m-Y' , strtotime($getData['insurence_from'])) : '';
     $output['to'] = !empty($getData['insurence_till']) ? date( 'd-m-Y' , strtotime($getData['insurence_till'])) : '';
     $output['policy_no'] = !empty($getData['policy_no']) ? $getData['policy_no'] : '';
     echo json_encode( $output );
 }
  
	
}
?>