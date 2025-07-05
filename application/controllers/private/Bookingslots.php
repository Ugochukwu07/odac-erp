<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bookingslots extends CI_Controller{
	
     function __construct() {
         parent::__construct();  
	     adminlogincheck();
     }	
	
	 
	public function index(){

			$get = $this->input->get();

			$vehicleno = !empty($get['id']) ? $get['id'] : '';

			$data = [];
			$data['id'] = $vehicleno; 

		    $data['title'] = 'View Booking dates For Vehicle No.: '.$vehicleno;

		    $select = "a.vnumber,CONCAT(CONCAT(b.model,'/ ', a.vnumber),'/ ',c.category) AS vehicle"; 
		    $from = ' pt_con_vehicle as a';

		    $join[0]['table'] = 'pt_vehicle_model as b';
		    $join[0]['on'] = 'a.modelid = b.id';
		    $join[0]['key'] = 'LEFT';
		    $join[1]['table'] = 'pt_vehicle_cat as c';
		    $join[1]['on'] = 'b.catid = c.id';
		    $join[1]['key'] = 'LEFT';

		    $where = []; 

		    $orderby = 'b.model ASC';

		    $data['vlist'] = $this->c_model->joindata( $select, $where, $from, $join, null, $orderby );

		    /*Get Booking date List*/
		    $fromdate = !empty($get['from']) ? date('Y-m-d',strtotime($get['from'])) : date('Y-m-d'); 
		    $todate = !empty($get['to']) ? date('Y-m-d',strtotime($get['to'])) : date('Y-m-d',strtotime($fromdate.' + 30 days')); 

		    $data['from'] = $fromdate ;
		    $data['to'] = $todate ;

		    /* fetch vehicle slots*/
		    $where = [];
		    $where['vehicleno'] = $vehicleno;
		    $where['dateslot >='] = $fromdate;
		    $where['dateslot <='] = $todate;
		    $keys = 'dateslot, status, bookingid';
		    $datelist = $this->c_model->getAll('pt_dateslots',null, $where, $keys );
		    
		    $bookingIds = [];
		    $bookingList = [];
		    if(!empty($datelist)){
		        foreach($datelist as $key=>$value ){
		            if(!empty($value['bookingid']) && !in_array($value['bookingid'], $bookingIds ) ){
		             $bookingIds[] = $value['bookingid'];  
		            }
		        }
		        $bookingIdsNew = array_unique($bookingIds); 
		        
		        $collectBookingIds = '';
		        if(!empty($bookingIdsNew)){
    		        foreach($bookingIdsNew as $row ){ 
    		             $collectBookingIds .= "'".$row."',";  
    		        }    
    		        
    		        $collectBookingIdsNew = rtrim($collectBookingIds,',');
    		        //get booking Details
    		        $bwhere = [];
    		        $bwhere["id IN(". $collectBookingIdsNew .")"] = NULL;
    		        $bookingList = $this->c_model->getAll('pt_booking', null, $bwhere, 'bookingid,id' ); 
		        }
		    }
		    
		    $allSlots = [];
		    //comnbine booking data in datelist
		    if(!empty($datelist)){
		        foreach($datelist as $key=>$value ){
		            $push = [];
		            $push = $value;
		            $push['booking_no'] = '';
		            if(!empty($bookingList)){
		                foreach($bookingList as $key=>$kvalue ){
		                    if( $value['bookingid'] == $kvalue['id'] ){
		                        $push['booking_no'] = $kvalue['bookingid']; 
		                        break;
		                    } 
		                }
		            }
		            array_push( $allSlots ,$push);
		        }
		    }
		    $data['datelist'] = $allSlots;   

     $startTime = strtotime( $fromdate );
     $endTime = strtotime( $todate );
     $data['calendar'] =  $this->createCalendarBetweenTwoDates($startTime, $endTime, $allSlots );
  
		    _view( 'bookingslots', $data ); 
		}

function slotStatus($status){
    if( $status == 'free' ){
        return 'Available';
    }else if( $status == 'reserve' ){
        return 'Reserve';
    }else if( $status == 'book' ){
        return 'Booked';
    }
}

function getBookingDetails( $datelist , $calender_date ){
		foreach ($datelist as $key => $data_row) {
			if( $calender_date == $data_row['dateslot'] ){
//return json_encode($data_row); 
$html = '';
$html .= '<span class="'.$data_row['status'].'">'.($this->slotStatus( $data_row['status'])).'</span><br/>';
$html .= $data_row['booking_no'] > 0 ? 'Booking ID:<a class="bookingid" href="'.base_url('private/details/?id='.md5($data_row['bookingid']).'&redirect=total').'" target="_blank"> View</a>':'&nbsp;';
$html .= $data_row['booking_no'] > 0 ? '<span class="bookingid"> '.$data_row['booking_no'].'</span>':'&nbsp;';
return $html;
break;
			}
		}
}


//create booking calender
function createDatesTable($period, $start, $datelist) {
	$calendarStr = '';
	foreach ($period as $key => $date_row) {
		if ($start%7 == 0) {
			$calendarStr .= '</tr><tr>';
		}

		$calendarStr .= '<td class="date">' . $date_row->format('d') .'-<span class="month">'.$date_row->format('F, Y'). '</span><br/> '.$this->getBookingDetails( $datelist , $date_row->format('Y-m-d') ).'</td>';
		$start++;
	}

	if ($start%7 == 0) {
		$calendarStr .= '</tr>';
	} else {
		for ($i = 0; $i <= 6; $i++) {
			if ($start%7 != 0)
				$calendarStr .= '<td class="empty_dates"></td>';
			else
				break;
			$start++;
		}
		$calendarStr .= '</tr>';
	}

	return $calendarStr;
}

function createCalendarBetweenTwoDates($startTime, $endTime, $datelist ) {

	$calendarStr = '';
	$weekDays = array(
		'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'
	);

	$calendarStr .= '<table>';

	$calendarStr .= '<tr><th class="week-days">' . implode('</th><th class="week-days">', $weekDays) . '</th></tr>';


	$period = new DatePeriod(
		new DateTime(date('Y-m-d', $startTime)),
		new DateInterval('P1D'),
		new DateTime(date('Y-m-d', $endTime))
	);

	$currentDay = array_search(date('D', $startTime), $weekDays);
	$start = 0;
	
	$calendarStr .= '<tr>';
	for ($i = $start; $i < $currentDay; $i++) {
		$calendarStr .= '<td class="empty date"></td>';
		$start++;
	}

	if ($currentDay < 6) {
		$calendarStr .= $this->createDatesTable($period, $start, $datelist );
	} else {
		$calendarStr .= $this->createDatesTable($period, $start, $datelist );
	}

	$calendarStr .= '</table>';

	return $calendarStr;
}



}
?>