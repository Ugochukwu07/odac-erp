<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Testme extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
    		header("Pragma: no-cache");
    		header("Cache-Control: no-cache");
    		header("Expires: 0");
    		header("Content-Type: application/json");
		}
		
	
	
	public function index(){ 
				
			$response = [];
			$data = [];
			$getdata = [];  
			$today = date('Y-m-d H:i:s');
			$request = getparam(); 
 
		
            if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){
                $response['status'] = FALSE;
                $response['message'] = 'Invalid Request!';
                echo json_encode($response); exit;
            } 
            
            
            /*release reserve vehicle*/
            $this->releaseVehicle();
            	  
            /****************************** Check input data start *******************/
            $tab = isset($request['tab']) ? $request['tab'] : null;
            $subtab = isset($request['subtab']) ? $request['subtab'] : null;
            $sourceid = isset($request['source']) ? $request['source'] : null;
            $destination = isset($request['destination']) ? $request['destination'] : null;
            $pickdatetime = isset($request['pickdatetime']) ? date('Y-m-d H:i:s',strtotime($request['pickdatetime'])) : null;
            $dropdatetime = isset($request['dropdatetime']) ? date('Y-m-d H:i:s',strtotime($request['dropdatetime'])) : null;


            if( empty($tab) ){
                $response['status'] = FALSE;
                $response['message'] = 'Tab is Blank!';
                echo json_encode($response); exit;
            }
            else if( !in_array($tab,['bike','selfdrive','outstation','monthly']) ){
                $response['status'] = FALSE;
                $response['message'] = 'Allow tabs are bike,selfdrive,outstation,monthly';
                echo json_encode($response); exit;
            }
            else if( empty($sourceid) ){
                $response['status'] = FALSE;
                $response['message'] = 'Source ID is Blank!';
                echo json_encode($response); exit;
            }
            else if( empty($pickdatetime) ){
                $response['status'] = FALSE;
                $response['message'] = 'Pickup Date And Time is Blank!';
                echo json_encode($response); exit;
            }
            else if( empty($dropdatetime) ){
                $response['status'] = FALSE;
                $response['message'] = 'Droop Date And Time is Blank!';
                echo json_encode($response); exit;
            }
            
            
            /*calculate days */
            $days = getdays($pickdatetime,$dropdatetime);
            
            if( in_array($tab,['monthly']) && (int)$days < 28 ){
                $response['status'] = FALSE;
                $response['message'] = 'Please select minimum 28 days for monthly package';
                echo json_encode($response); exit;
            }
            
            
        $source = $this->getCity($sourceid);
        $cleanuid = isset($request['cleanuid']) ? $request['cleanuid'] : null;
        /*delete old records*/	
        $delwhere['indate <='] = date('Y-m-d');
        if(!empty($cleanuid)){ $delwhere['uid'] = $cleanuid; }
        $cleanrecords = $this->c_model->delete('pt_urlsortner',$delwhere);
        

        
        $distance = 0;
        $travelstime = 0;
        $routes = [];
        $store = [];
        
        if($tab == 'outstation'){
         $destination = rtrim($destination,'|');
         $googleApi = viadistancecalutaor($source,$destination);
         $distance = $googleApi['kms'];
         $travelstime = convertmintohour( $googleApi['time'] );
         if(!empty($googleApi['routes'])){
         foreach ($googleApi['routes'] as $key => $rvalue) {
         	 $store['via'] = $rvalue;
         	 array_push($routes,  $store);
         }}
           
         if( strpos($destination, '|') !== false){
        	$destination = explode('|', $destination );
        	$destination = end( $destination );
         }
        
        }
        
        
       
        
        $fare = []; 
        $where['a.status'] = 'yes';
        $where['a.fromcity'] = $sourceid;
        $where['DATE(a.validfrom) <='] = $today;
        $where['DATE(a.validtill) >='] = $today;
        $where['a.triptype'] = $tab; 
        $where['d.status'] = 'yes'; 
        
        
        $select = 'a.*,b.model,b.image,c.category as categoryname,d.vyear,d.fueltype,d.seat';
        $from = 'pt_fare as a'; 
        
        $join[0]['table'] = 'pt_vehicle_model as b'; 
        $join[0]['on'] = 'a.modelid = b.id'; 
        $join[0]['key'] = 'INNER';
        
        $join[1]['table'] = 'pt_vehicle_cat as c'; 
        $join[1]['on'] = 'a.category = c.id'; 
        $join[1]['key'] = 'INNER';
        
        $join[2]['table'] = 'pt_con_vehicle as d'; 
        $join[2]['on'] = 'a.modelid = d.modelid'; 
        $join[2]['key'] = 'LEFT';
         
        
        $groupby = null;
        $orderby = null;
        $limit = null;
        
        $fdata = $this->c_model->joindata($select,$where,$from,$join,$groupby,$orderby,$limit);
        //print_r($fdata); exit;
        if( empty($fdata) ){
            $response['status'] = FALSE;  
            $response['message'] = 'No cab available on this date for this trip!';  
            echo json_encode($response);
            exit;
        }
    
        $inkeys = 'id,startdate,enddate';
    	$estkm = 0;
    	foreach ($fdata as $key => $value) {
    
    		//$getmodel_assesssory = $this->c_model->getSingle('pt_con_vehicle',['modelid'=>$value['modelid'],'status'=>'yes'],'vyear,fueltype,seat',null,1);
  
    		//check empty model list
    		 //if(!empty($getmodel_assesssory)){
    
    		 $countitem = 0;
    		 $put = [];
    
    		 $put['modelid'] = $value['modelid'];
    		 $put['startdate'] = $pickdatetime;
    		 $put['enddate'] = $dropdatetime;
    		 $put['days'] = $days;
    		 $avails = $this->checkavailibility( $put );
    
    		// print_r($avails); exit;
    
             $countitem = !empty($avails) ? ($avails) : 0; 
    		 $basefare = $value['basefare'];
    		/*calculate fare */
    		if($tab == 'outstation'){
    			$ttldayskm = $value['minkm_day'] * $days;
    			$estkm = $distance;
    			if($ttldayskm > $distance ){
    				$estkm = $ttldayskm;
    			}
    
    			$basefare = (float)$value['fareperkm'] * (float)$estkm;
    		 
    		}else if($tab == 'bike'){
    		    $basefare = (float)$value['basefare'] * (float)$days;
    		}else if($tab == 'selfdrive'){ 
    		 	$basefare = (float)$value['basefare'] * (float)$days;
    		}
    		else if($tab == 'monthly'){ 
    		 	$basefare = (float)$value['basefare'] * (float)$days;
    		}
    		 
    
    
             
    		 $arra['id'] 				= $value['id'];
    		 $arra['triptype']  		= $value['triptype'];
    		 $arra['fromcity'] 		 	= $value['fromcity'];
    		 $arra['categoryid']  		= $value['category'];
    		 $arra['categoryname'] 		= $value['categoryname'];
    		 $arra['modelid'] 			= $value['modelid'];
    		 $arra['model'] 			= $value['model'];
    		 $arra['basefare'] 			= $value['basefare'];
    		 $arra['fareperkm'] 		= $value['fareperkm'];
    		 $arra['minkm_day'] 		= $value['minkm_day'];
    		 $arra['drivercharge'] 		= $value['drivercharge'];
    		 $arra['nightcharge'] 		= $value['nightcharge'];
    		 $arra['googlekm'] 			= (string)$distance;
    		 $arra['estkm'] 			= (string)$estkm;
    		 $arra['esttime'] 			= (string)$travelstime;
    		 $arra['est_fare'] 			= (string)$basefare;
    		 $arra['gst'] 				= (string)CABGST;
    		 $arra['gstamount'] 		= (string)percentage($basefare,CABGST );
    		 $arra['withgstamount'] 	= (string) ((float)$arra['gstamount']+(float)$basefare); 
    		 $arra['night_from'] 		= !empty($value['night_from']) ? date('h:i A',strtotime($value['night_from'])):'';
    		 $arra['night_till'] 		= !empty($value['night_from']) ? date('h:i A',strtotime($value['night_till'])) : '';
    		 $arra['secu_amount'] 		= $value['secu_amount'];
    		 $arra['available_cars'] 	= (string)($countitem?$countitem:0);
    		 $arra['days'] 				= (string)$days;
    		 $arra['source'] 			= $source;
    		 $arra['destination'] 		= $destination;
    		 $arra['route'] 			= $routes;
    		 $arra['imageurl'] 			= UPLOADS.$value['image'];
    		 $arra['segment'] 			= (string) !empty($value['seat'])?$value['seat']:'';
    		 $arra['yearmodel'] 		= (string) !empty($value['vyear'])?$value['vyear']:''; 
    		 $arra['fueltype'] 			= (string) !empty($value['fueltype'])?$value['fueltype']:''; 
    		 $arra['acstatus'] 			= 'ac';
    		 $arra['bags'] 				= '2';
    		 $arra['pickupdatetime']    = date('Y-m-d h:i A',strtotime($pickdatetime));
    		 $arra['dropdatetime'] 		= date('Y-m-d h:i A',strtotime($dropdatetime));
    		 $arra['subtab'] 			= $subtab;
    		 
    		/*delete old records*/	
    		$record['indate'] = date('Y-m-d');
    		$record['odr'] = $arra['id'];
    		$record['payload'] = base64_encode( json_encode($arra));
    		
    		if(!empty($cleanuid)){ $record['uid'] = $cleanuid; }
    		 $putrecords = $this->c_model->saveupdate('pt_urlsortner',$record);  
    		 $arra['stock'] 			= $putrecords;
    		 array_push( $data, $arra );
    		//}//end of check model 
    	}



        if(empty($data)){
            $response['status'] = FALSE;  
            $response['message'] = 'No cab available on this date for this trip!';  
            echo json_encode($response);
            exit;
        }
        

        $price = array();
        foreach ($data as $key => $row)
        {
            $price[$key] = $row['withgstamount'];
        }
        array_multisort($price, SORT_ASC, $data);
        
        
        $response['status'] = true;
        $response['data'] = $data;
        $response['terms'] = $this->getterms($tab);
        $response['message'] = 'Success!';  
 	    echo json_encode($response);
	
}




public function getCity($id){
			$where['a.id'] = $id; 
	        $select = 'CONCAT(a.cityname,",",b.statename) AS cityname'; 
		    $from = 'pt_city as a'; 
		    $join[0]['table'] = 'pt_state as b';
		    $join[0]['on'] = 'a.stateid = b.id';
		    $join[0]['key'] = 'LEFT';  
		    $orderby = 'a.cityname ASC'; 
		    $getdata = $this->c_model->joindata( $select,$where, $from, $join); 
			
			$arra = '';
		    foreach( $getdata as $key=>$value ):  
			    $arra = (string) capitalize( $value['cityname'] ); 
			endforeach;
			return $arra;
}	


public function checkavailibility($data){ 

$startdate = date('Y-m-d',strtotime($data['startdate']));
$enddate = date('Y-m-d',strtotime($data['enddate']));

//$sql = "SELECT COUNT(id) as total FROM `pt_dateslots` WHERE `dateslot` >= '".$startdate."'  and `dateslot` <= '".$enddate."' AND `modelid` = '".$data['modelid']."' AND `status`='free' AND `vehicleno` in( select distinct vnumber from pt_con_vehicle WHERE status='yes' ) having  total >= '".$data['days']."' ";
//$sql = "SELECT DISTINCT `vehicleno` FROM `pt_dateslots-` WHERE `dateslot` between '".$startdate."' and '".$enddate."' AND `modelid` = '".$data['modelid']."' AND `status`='free' AND `vehicleno` IN( SELECT DISTINCT vnumber FROM pt_con_vehicle WHERE status='yes' and `modelid` = '".$data['modelid']."' ) ";
$sql = "SELECT COUNT(*) AS total, vehicleno FROM `pt_dateslots` WHERE `dateslot` between '".$startdate."' AND '".$enddate."' AND `modelid` = '".$data['modelid']."' AND `status`='free' AND `vehicleno` IN( SELECT DISTINCT vnumber FROM pt_con_vehicle WHERE status='yes' and `modelid` = '".$data['modelid']."' ) GROUP BY `vehicleno` having total >= '".$data['days']."' ";
$fdata = $this->db->query( $sql );
$fdata = $fdata->num_rows();
return  $fdata;

}

public function getterms( $triptype ){
	$table = 'pt_booking_terms';
	$keys = 'content';
	$orderby = 'content ASC';
	$where['datacategory'] = $triptype;
	$where['status'] = 'yes';
	$where['contenttype'] = 'terms';

$data = $this->c_model->getAll( $table, $orderby, $where ,$keys);
return !empty($data) ?  $data : [];
} 


 public function releaseVehicle(){

	        $today = date('Y-m-d H:i:s');
	        $now = date('Y-m-d H:i:s', strtotime( $today.' -15 minutes' ) );

	     
	    $sql = "SELECT * FROM `pt_dateslots` WHERE `bookingid` IN( SELECT id FROM `pt_booking` WHERE `bookingdatetime` <= '".$now."' AND `pickupdatetime` >= '".$today."' AND (`attemptstatus` = 'temp' or `attemptstatus` = 'cancel') )";
		$bookdata = $this->db->query( $sql );
		$getdata = $bookdata->result_array();

		if(!empty($getdata)){
			foreach ($getdata as $key => $value) { 
			$where['status'] = 'reserve';
			$where['id'] = $value['id']; 
			$save = [];
			$save['status'] = 'free';
			$save['bookingid'] = '';
			$up = $this->c_model->saveupdate('pt_dateslots',$save,null,$where);
			}
		} 	
}	
		
}
?>