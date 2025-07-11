<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_DB_query_builder $db
 * @property Common_model $c_model
 */
class Createslot extends CI_Controller{
    
    var $slotTable;
	
	 function __construct() {
         parent::__construct(); 
         ini_set('max_execution_time', '30000');
         //$this->slotTable = 'pt_dateslots_backup';
         $this->slotTable = 'pt_dateslots';
     }	



function generateDateRange($start_date, $end_date) {
    $dates = array();

    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);

    if ($start_timestamp === false || $end_timestamp === false) {
        return false;
    }

    while ($start_timestamp <= $end_timestamp) {
        $dates[] = date('Y-m-d', $start_timestamp);
        $start_timestamp = strtotime('+1 day', $start_timestamp);
    }

    return $dates;
}


public function index(){
    
    $post = $this->input->post() ? $this->input->post() : $this->input->get() ;
    
    if( $this->input->post() ){
    
        $fromDate = !empty($post['fromDate']) ? trim($post['fromDate']) : '';
        $toDate = !empty($post['toDate']) ? trim($post['toDate']) : '';
        $id = !empty($post['id']) ? $post['id'] : '';
        
        if ($fromDate) {
            $dateObj = DateTime::createFromFormat('m/d/Y', $fromDate);
            if ($dateObj) {
                $fromDate = $dateObj->format('Y-m-d');
            }
        }
        
        if ($toDate) {
            $dateObj = DateTime::createFromFormat('m/d/Y', $toDate);
            if ($dateObj) {
                $toDate = $dateObj->format('Y-m-d');
            }
        }
        
        if(empty($fromDate) && empty($toDate)){
             echo "Invalid date format."; exit;
        }
        
        
        
        /***** create slots list ****/
        $date_range = $this->generateDateRange($fromDate, $toDate);
           if ($date_range === false) {
                echo "Invalid date format."; exit;
           }
       
       
        $dateList = [];
        foreach ($date_range as $date) {
            $dateList[] = $date;
        }
        
        if ( empty($dateList) ) {
                echo "Invalid date format."; exit;
        }
        
       
        
        /****************************  get all vehicle list start  **********************************/
        $con_where = [];
        $con_where['status'] = 'yes';
        if( !empty($id)){
        $con_where['id'] = $id;
        }
        
        $vehicleList = $this->c_model->getAll('pt_con_vehicle', null, $con_where ,'modelid,vnumber, id ' );
        //echo $this->db->last_query();
        
        if(empty($vehicleList)){
            echo 'No Vehicle Records'; exit;
        }
        
        
         
        
        $invalue = null;// implode(',', $dateList );
        
        //append data
        foreach( $vehicleList as $key=>$value ){
                
            $where = [];
            $where['vehicleno'] = $value['vnumber']; 
            $where['modelid'] = $value['modelid']; 
            $where['dateslot >='] = $fromDate; 
            $where['dateslot <='] = $toDate; 
            $checkSlotsList = $this->c_model->getfilter( $this->slotTable , $where, null,null, null, null,null, null, null, null, 'get', 'dateslot', $invalue ,'dateslot'  );
            //echo $this->db->last_query();
            //echo '<br/>find slots: '.count( $checkSlotsList );
            
            $filteredDateArrayList = [];
            if(!empty($checkSlotsList)){
               $matchedList = $this->makeItemsIndexedList( $checkSlotsList );
               $filteredDateArrayList = array_diff( $dateList , $matchedList );
            }else{
               $filteredDateArrayList = $dateList; 
            }
            
            //echo '<br/>new slots: '.count( $filteredDateArrayList );
           
            $bulkArray = [];
            if(!empty($filteredDateArrayList)){
                foreach( $filteredDateArrayList as $rows ){
                    $push = [];
                    $push['modelid'] = $value['modelid']; 
                    $push['vehicleno'] = $value['vnumber']; 
                    $push['dateslot'] = $rows; 
                    $push['status'] = 'free';
                    $push['bookingid'] = 0;
                    array_push( $bulkArray, $push );
                }
            }
            
            //batch insert 
            if(!empty($bulkArray)){
                 $this->db->insert_batch( $this->slotTable , $bulkArray );
                 $this->maintainstartend( $value['vnumber'] , $value['id'] );
            } 
              
        } 
        
        /*get all vehicle list end*/
        
        
        
        echo "Slots created successfully!";

    } else {
        $data = [];
		$data['title'] = 'Create Slots';
        _view('createslot', $data);
    }
}


public function makeItemsIndexedList( $checkSlotsList ){
        $list = [];
        foreach( $checkSlotsList as $slotsRows ){
           $list[] = $slotsRows['dateslot']; 
        }
        return $list;
}
 
 

//create start end slots
function maintainstartend( $vehicleno, $id ){

  $start = $this->db->query("SELECT dateslot FROM ".$this->slotTable." WHERE vehicleno='".$vehicleno."'  order by id ASC limit 1")->row_array(); 

  $end = $this->db->query("SELECT dateslot FROM ".$this->slotTable." WHERE vehicleno='".$vehicleno."'  order by id DESC limit 1")->row_array(); 

  $startdate = !empty($start) ? $start['dateslot'] : ''; 
  $enddate = !empty($end) ? $end['dateslot'] : ''; 
  $update = $this->db->query("UPDATE pt_con_vehicle SET startdate = '".$startdate."',enddate = '".$enddate."'  WHERE id = '".$id."' ");

}
 
	
}
?>