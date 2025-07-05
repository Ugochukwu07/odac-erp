<?php 

  function ucw($dt){ return ucwords($dt); }	
  
  function nullv($value){
	if(strlen($value) > 0 ){$data=$value;}
	else{$data='0';}
	return $data;
	}
	
	function getfareoftravel($con,$mid,$distance,$day,$traveltype){
	if($traveltype =='out'){
                $distance = $distance * 1;
		$fare = mysqli_fetch_array(mysqli_query($con,"SELECT `minkm`,`fareperkm`,`drivercharge` FROM `pt_fare` WHERE `id` = '".$mid."'"));
		
		$minkmcalc = $fare['minkm']*$day;
		if($distance > $minkmcalc){
			$fareval = $fare['fareperkm']*$distance + $day*$fare['drivercharge'];
		}else{
			$fareval = $fare['fareperkm']*$minkmcalc + $day*$fare['drivercharge'];
		}
	}else if($traveltype == 'local'){
		$fare = mysqli_fetch_array(mysqli_query($con,"SELECT `fixedfare` FROM `pt_fare` WHERE `id` = '".$mid."'"));
		$fareval = $fare['fixedfare'];
	}
	return $fareval;
}

function advanceFare($fare){
	$tripadvance = TRIPADVANCE/100;
    $tripadv = round($fare*$tripadvance,2);
	return  $tripadv;
	}
	
function onlineCharge($fare){
	$onlinecharge = ONLINETAX/100;
    $totalcharge = round($fare*$onlinecharge,2);
	return $totalcharge;
	}
	
function onlinetotalCharge($fare){
	$onlinecharge = ONLINETAX/100;
    $totalcharge = round($fare*$onlinecharge,2);
	return round($totalcharge + $fare);
	}				
	
function twoDecimal($value){
    $decimal = number_format((float)$value,2,'.','');
	return $decimal;
	}		

  function localTripType($con,$selectedcity){
	$getcity = mysqli_query($con,"SELECT `id`,`tripmode` FROM `pt_mode` where `tripcat` = '2' and `statusv`='1' order by `sortorder` asc ");
	$localtrip = "<option value=''>-- Select Package --</option>";
	while($getrow = mysqli_fetch_assoc($getcity)){
	if($getrow['id'] == $selectedcity){
		$localtrip.="<option value='".$getrow['id']."' selected>".$getrow['tripmode']."</option>";
	}else{
		$localtrip.="<option value='".$getrow['id']."'>".$getrow['tripmode']."</option>";
		}
	} 
	return $localtrip;
} 	


function stateDropdown($con,$selectedid){
	$getcity = mysqli_query($con,"SELECT `id`,`state` FROM `pt_state`");
	$statedropdown="<option value=''>-- Select State Name--</option>";
	while($getrow = mysqli_fetch_assoc($getcity)){
	if($getrow['id'] == $selectedid){
		$statedropdown.="<option value='".$getrow['id']."' selected>".$getrow['state']."</option>";
	}else{
		$statedropdown.="<option value='".$getrow['id']."'>".$getrow['state']."</option>";
		}
	} 
	return $statedropdown;
} 	

function realescape($con,$string) {
    $data = mysqli_real_escape_string($con,$string);
    return nullv($data);
} 

function timeFormat($time){  
$arr = explode(" ",$time);  
$arr1 = explode(":",$arr[0]);
foreach($arr1 as $k =>  $val){
    $arr1[$k] = sprintf("%02d", $val);    
}
$str = implode(":", $arr1)." ".$arr[1];
$timeNew = date('H:i:s',strtotime($str));
return $timeNew;
}

function dateFormat($data){ $format = date('Y-m-d',strtotime($data)); return $format; }
function dateViewFormat($data){ $format = date('d M Y',strtotime($data)); return $format; }
function dateformatTimestamp($data){ $format = date('d-m-Y H:i A',strtotime($data)); return $format;}
function dateViewFormatdMY($data){ $format = date('d-M-Y',strtotime($data)); return $format; }
function dateeditFormatDMY($data){ $format = date('d-M-Y',strtotime($data)); return $format; }
function dateformatTimestampSlip($data){ $format = date('H:i d-m-Y',strtotime($data)); return $format;}
 

function statename($con,$id){$sql = mysqli_fetch_assoc(mysqli_query($con,"select `state` from `pt_state` where `id`='".$id."'")); return $sql['state']; }
function cityname($con,$id){$sql = mysqli_fetch_assoc(mysqli_query($con,"select `cityname` from `pt_city` where `id`='".$id."'")); return $sql['cityname']; }
function bikename($con,$id){$sql = mysqli_fetch_assoc(mysqli_query($con,"select `bikename` from `pt_bikes` where `id`='".$id."'")); return $sql['bikename'];}
function vehiclemodel($con,$id){	$sql = mysqli_fetch_assoc(mysqli_query($con,"select `vehiclemodel` from `pt_model` where `id`='".$id."'"));return $sql['vehiclemodel'];}
function segmentame($con,$id){ $sql = mysqli_fetch_assoc(mysqli_query($con,"select `seatcode` from `pt_segment` where `id`='".$id."'")); return $sql['seatcode'];}
function categoryname($con,$id){	$sql = mysqli_fetch_assoc(mysqli_query($con,"select `category` from `pt_vehiclecategory` where `id`='".$id."'")); return $sql['category'];}	


function paymenttable($con,$name,$mobi,$email,$addres,$state,$payfor,$amnt,$pdate,$mldate,$gtstatus,$type){
	$fullname = nullv($name); $mobile = nullv($mobi); $email = nullv($email); $streetaddress = nullv(realescape($con,$addres)); $statename = nullv($state); $payfor = nullv($payfor); $amount = nullv($amnt); $paydate = nullv(dateFormat($pdate)); $mannualdate = nullv(dateFormat($mldate)); $gatewaystatus = nullv($gtstatus); $statusv = nullv('0');
	
   $sqlquery = "INSERT INTO `pt_paymenttable` (`id`, `fullname`, `mobile`, `email`, `streetaddress`, `statename`, `payfor`, `amount`, `paydate`, `mannualdate`, `gatewaystatus`, `statusv`) VALUES (NULL, '".$fullname."', '".$mobile."', '".$email."', '".$streetaddress."', '".$statename."', '".$payfor."', '".$amount."', '".$paydate."', '".$mannualdate."', '".$gatewaystatus."', '".$statusv."');";

$runquery = mysqli_query($con,$sqlquery);
$lastinsertid = mysqli_insert_id($con);

if($runquery){
	return $lastinsertid;
	}
	else{ return $lastinsertid;}

}

function OTP($length, $charset='0123456789'){
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    } 
    return $str;
}	
	
	
function shortLength($value,$min,$max){ $company = strip_tags($value); $companyname=  strlen($company) >= $max ? substr($company, 0, $min): $company;
	return $companyname;
	}
	
function specialCharcterRemoval($string){
	//$val = preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u',' ', strip_tags($string));
	$val = ereg_replace("[^A-Za-z0-9., ]", "", $string);	
	return  nullv($val);
}

function onlyNumber($string){
	$val = ereg_replace("[^0-9 +()-]", "", $string);
	return  nullv($val);
}

function sendsms($contactno,$message){
	$str = urlencode($message);
	$mobile = preg_replace('!\\r?\\n!', "", $contactno); 
    $url=("http://203.129.203.243/blank/sms/user/urlsms.php?username=".SMSUSERNAME."&pass=".SMSPASSWORD."&senderid=".SENDERID."&dest_mobileno=$mobile&msgtype=UNI&message=$str&response=Y");
	$data=@file_get_contents($url);
	return $data;
}	

function carsetfulbag($con,$id,$type){
	$data = mysqli_fetch_assoc(mysqli_query($con,"SELECT `fueltype`,`bags`,`yearmodel`,`seatsegment` FROM `pt_model`  WHERE `vehiclemodel`='".$id."'  "));
	if($type=='bag'){ $rdata = $data['bags'];}
	else if($type=='fuel'){ $rdata = $data['fueltype'];}
	else if($type=='year'){ $rdata = $data['yearmodel'];}
	else if($type=='seat'){ $rdata = $data['seatsegment'];}
	return  $rdata;
	}

function bikesetfulbag($con,$id,$type){
	  $data = mysqli_fetch_assoc(mysqli_query($con,"SELECT `yearmodel`,`fueltype`,`bags`,`seats` FROM `pt_bikes`  WHERE `bikename` = '".$id."' "));
	if($type=='bag'){ $rdata = $data['bags'];}
	else if($type=='fuel'){ $rdata = ucw($data['fueltype']);}
	else if($type=='year'){ $rdata = $data['yearmodel'];}
	else if($type=='seat'){ $rdata = $data['seats'];}
	return  $rdata;
	}


function farecityDropdown($con,$id,$type){
	
	$getcity = mysqli_query($con,"SELECT `fromcity` FROM `pt_fare` where `triptype`='".$type."' group by `fromcity` ");
	$dropdown="<option value=''>-- Select City Name--</option>";
	while($getrow = mysqli_fetch_assoc($getcity)){
	if(/*$getrow['fromcity'] == $id || */$getrow['fromcity'] == '1'){
		$dropdown.="<option value='".$getrow['fromcity']."' selected>".cityname($con,$getrow['fromcity'])."</option>";
	}else{
		$dropdown.="<option value='".$getrow['fromcity']."'>".cityname($con,$getrow['fromcity'])."</option>";
		}
	} 
	return $dropdown;
}


function bikecityDropdown($con,$id){
	
	$getcity = mysqli_query($con,"SELECT `cityname` FROM `pt_bike_fare` group by `cityname` ");
	$dropdown="<option value=''>-- Select City Name--</option>";
	while($getrow = mysqli_fetch_assoc($getcity)){
	if(/*$getrow['cityname'] == $id*/ $getrow['cityname'] == '1'){
	$dropdown.="<option value='".$getrow['cityname']."' selected>".cityname($con,$getrow['cityname'])."</option>";
	}else{
		$dropdown.="<option value='".$getrow['cityname']."'>".cityname($con,$getrow['cityname'])."</option>";
		}
	} 
	return $dropdown;
}

function bikeDropdown($con,$id,$type){
	
	$getcity = mysqli_query($con,"SELECT `id`,`bikename` FROM `pt_bike_fare`  group by `bikename` ");
	$dropdown="<option value=''>-- Select Bike Name--</option>";
	while($getrow = mysqli_fetch_assoc($getcity)){
	if($getrow['bikename'] == $id){
		$dropdown.="<option value='".$getrow['bikename']."' selected>".bikename($getrow['bikename'])."</option>";
	}else{
		$dropdown.="<option value='".$getrow['bikename']."'>".bikename($getrow['bikename'])."</option>";
		}
	} 
	return $dropdown;
}

function noofdays($date1,$date2){
	$start = strtotime($date1);
    $end = strtotime($date2);
    $days_between = ceil(abs($end - $start) / 86400);
	return $days_between + 1;
	}
	

 function triptype($val){
	 if($val=='2'){ $data = 'Local';}
	if($val=='3'){ $data = 'Outstation';}
	if($val=='5'){ $data = 'Bike Rental';}
	if($val=='6'){ $data = 'Self Drive';}
	return $data;
 }
 
 function timeformatHiA($id){
	if($id){ $data = date('h:i A',strtotime($id));} 
	return $data;
	}


 function outstationtype($status){
	if($status==1){
		$trip="One Way";
	}else if($status==2){
		$trip="Round Trip";
	}else if($status==3){
		$trip="Multi City";
	}
	return $trip;
}

	
/*function Timeduration($source,$destination){
	$routes=json_decode(file_get_contents('http://maps.googleapis.com/maps/api/directions/json?origin='.urlencode($source).'&destination='.urlencode($destination).'&alternatives=true&sensor=false'))->routes;
	usort($routes,create_function('$a,$b','return intval($a->legs[0]->duration->value) - intval($b->legs[0]->duration->value);'));
	return $routes[0]->legs[0]->duration->text;
}

function getdistancegoogleapi($source,$destination){
	$routes=json_decode(file_get_contents('https://maps.googleapis.com/maps/api/directions/json?origin='.urlencode($source).'&destination='.urlencode($destination).'&alternatives=true&sensor=false'))->routes;
	usort($routes,create_function('$a,$b','return intval($a->legs[0]->distance->value) - intval($b->legs[0]->distance->value);'));
	return $routes[0]->legs[0]->distance->text;
}





function getdistanceallsource($source,$destination){
	$routes=json_decode(file_get_contents('https://maps.googleapis.com/maps/api/directions/json?origin='.urlencode($source).'&destination='.urlencode($destination).'&alternatives=true&sensor=false'))->routes;
	usort($routes,create_function('$a,$b','return intval($a->legs[0]->distance->value) - intval($b->legs[0]->distance->value);'));
	return $routes[0]->legs[0]->distance->text;
}*/



 function googleMatrix($source,$destination,$type){

	$Api = 'AIzaSyCg3fNdiIzhHPmkEb_58Or_dCfkWt7550k';

	$origin = !empty($source) ?  urlencode($source) : null;
	$destination = !empty($destination) ?  urlencode($destination) : null;
	$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$origin.'&destinations='.$destination.'&mode=driving&language=en-US&key='.$Api.'';
	$jsondata = file_get_contents($url);
	$data = json_decode($jsondata, true);
	if($type=='km'){
		$result = round($data['rows'][0]['elements'][0]['distance']['text']);
	}else if($type=='hr'){
		$result = $data['rows'][0]['elements'][0]['duration']['text'];
	}
	return  $result;
	}



function Timeduration($source,$destination){
$data = googleMatrix($source,$destination,'hr');
return $data;
}



function getdistancegoogleapi($source,$destination){
$data = googleMatrix($source,$destination,'km');
return $data;
}



function getdistanceallsource($source,$destination){
$data = googleMatrix($source,$destination,'km');
return $data;
}




function distancecalutaor($vaiarray){
unset($_SESSION['viaarray']);
//for($k=0;$k<count($vaiarray)-1;$k++){
foreach($vaiarray as $key=>$value){

if($vaiarray[$key+1]){
	//$totaldistancetemp = str_replace(',','',trim(str_replace('km','',getdistanceallsource(current(explode(',',$vaiarray[$key])),current(explode(',',$vaiarray[$key+1]))))));

	$totaldistancetemp = str_replace(',','',trim(str_replace('km','',getdistanceallsource(current(explode(',',$vaiarray[$key])),current(explode(',',$vaiarray[$key+1]))))));
	
	$totaldistance = $totaldistance + $totaldistancetemp;
	
	$_SESSION['viaarray'][]= current(explode(',',$vaiarray[$key])).'---'.current(explode(',',$vaiarray[$key+1])).'---'.$totaldistancetemp;
	
	}
	$viaroute .= current(explode(',',$vaiarray[$key])).'→';
}
$_SESSION['viaroute']=rtrim($viaroute,"→");
	$totaldistance = str_replace(',','',trim(str_replace('km','',$totaldistance)));
	return round($totaldistance);
}

function payForMode($id){
	if($id =='1'){ $status = 'Pay To Drive';}
	else if($id =='2'){ $status = 'Advance Payment';}
	else if($id =='3'){ $status = 'Full Payment';}
	return $status;
	}
function localtripmode($con,$id, $type){	
$sql = mysqli_fetch_assoc(mysqli_query($con,"select * from `pt_mode` where `id`='".$id."'")); 
if($type=='mode'){ $data=$sql['tripmode'];}
else if($type=='hr'){ $data=$sql['hours'];}
else if($type=='km'){ $data=$sql['kms'];}
return $data;}	
	
function paymode($id){
	if($id =='1'){ $status = 'Unpaid';}
	else if($id =='2'){ $status = 'Paid';}
	else if($id =='3'){ $status = 'Paid';}
	return $status;
	}	
function bookConfirmed($id){
	if($id =='1'){ $status = 'Confirmed';}
	else { $status = 'Unconfirmed';}
	return $status;
	}	
function bookingid($con){
	$ID = 'RCPL';
	$lastid = mysqli_fetch_assoc(mysqli_query($con,"select `bookid` from `pt_bikebooking` order by `id` desc limit 1"));
    $olcode = $lastid['bookid']; $explode = explode($ID, $olcode ); $orderno =  $ID.''.($explode[1]+1);
	return $orderno;
	}	
	
function orderNo($con){
	$ID = 'RCPLB';
	$lastid = mysqli_fetch_assoc(mysqli_query($con,"select `bookid` from `pt_motorcyclebooking` order by `id` desc limit 1"));
    $olcode = $lastid['bookid']; $explode = explode($ID, $olcode ); $orderno =  $ID.''.($explode[1]+1);
	return $orderno;
	}
	
function orderNob($con){
	$ID = 'RCPLCBP';
	$lastid = mysqli_fetch_assoc(mysqli_query($con,"select `bookid` from `all_common_booking` order by `id` desc limit 1"));
    $olcode = $lastid['bookid']; $explode = explode($ID, $olcode ); $orderno =  $ID.''.($explode[1]+1);
	return $orderno;
	}
	

function eXxPlodeHas($simbol,$object,$obno){
	$explode = explode(''.$simbol.'',$object); 
	$result = $explode[$obno]; 
	return $result;
	}
	
 function getlatlog($address){
	$geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
	$geo = json_decode($geo, true);
	if ($geo['status'] = 'OK') {
	  $latitude = $geo['results'][0]['geometry']['location']['lat'];
	  $longitude = $geo['results'][0]['geometry']['location']['lng'];
	}
	 $latlog = $latitude.','.$longitude ;
	  return $latlog ;
	}


function bikeBookingstatus($amount,$status){
	if($amount > 0){$astats = 'Paid';}else {$astats = 'UnPaid';}
	if($status == 0){$cmstats = 'UnConfirmed';} 
	else if($status == 2){$cmstats = 'Confirmed';}else if($status == 1){$cmstats = 'Cancelled';}
	return  $astats.' '.$cmstats;
	}






































/********************** Send mail Function Start **********************************/
function bookingMailDip($con,$id,$for){
 $bookingdata = mysqli_fetch_assoc(mysqli_query($con,"select * from `pt_bikebooking` where `id`='".$id."' ")); $bookingtripmode = '';
if($bookingdata['triptype']=='2'){$bookingtripmode = localtripmode($bookingdata['tripmode'],'mode');}
else if($bookingdata['triptype']=='3'){$bookingtripmode = outstationtype($bookingdata['tripmode']);}

if($bookingdata['route']!='0'){$viaroute = $bookingdata['route'];}


 $string.='<table width="805" border="1" cellpadding="0" cellspacing="0" style="font-family: MelbourneRegular, Melbourne, Myriad Pro, Arial, Verdana, Helvetica sans-serif; font-size:15px; border:7px ridge #ccc;">
  <tr>
    <td colspan="4">
    <div style="width:210px; float:left;">&nbsp;<img src="'.LOGO.'" style="width: 200px;height: 91px;margin-top: 17px;"/></div>
    <div style="margin-top:10px; width:555px; float:left; text-align: right">&nbsp;
    <span>SCO. 98, 1st Floor Sector 47-C<br/>Chandigarh 160047(INDIA)<br/></span>
    <span>'.CONTACT.'<br/></span>
    <span>'.EMAIL.'<br/></span>
    <span><span style="float:left">ISO 9001:2008 Quality certified Travel Company</span>'.WEBSITE.'</span>
    </div>
    <div style="width:100%; background:#2E3192; color:#ffffff; clear:both; letter-spacing:2px; text-align:center; font-weight:600">
    | CAR RENTAL | BIKE RENTAL | LUXURY &amp;  WEDDING CARS | TOUR PACKAGES |</div>
    <div style="width:100%; color:#000000; margin:10px 0px 10px 0px; clear:both; text-align:center; font-weight:300">
    Dear '.$bookingdata['travellername'].',your booking ID is '.$bookingdata['bookid'].' .Request has been Successfully Processed. Car & chauffeur details will be send to you before reporting time. Thank You for Booking with Rana Cabs Pvt Ltd. </div>
    <div style="width:49.43%; border-top:1px solid #111; float:left; font-size:18px">&nbsp;Dear '.$bookingdata['travellername'].',Your Booking ID is  '.$bookingdata['bookid'].' <br/>
    </div>
    <div style="width:50%; border-top:1px solid #111; float:left; font-size:18px">&nbsp; Date : '.$bookingdata['bookingtimedate'].'</div>
    </td>
  </tr>
  <tr>
    <td style="font-size:15px; font-weight:600">&nbsp; Customer Details :</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="175">&nbsp; Name </td>
    <td width="195">&nbsp; '.$bookingdata['travellername'].'</td>
    <td width="175">&nbsp; Contact No</td>
    <td width="195">&nbsp; '.$bookingdata['tmobile'].'</td>
  </tr>
  <tr>
    <td>&nbsp; Email</td>
    <td colspan="2">&nbsp; '.$bookingdata['temail'].'</td>
    <td>&nbsp; No of Passenger: '.$bookingdata['noofpassenger'].'</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:15px; font-weight:600">&nbsp; Booking Details :</td>
    <td>&nbsp; Booking Status</td>
	<td>&nbsp; '.paymode($bookingdata['paymentmode']).' & '.bookConfirmed($bookingdata['confirmstatus']).'</td>
  </tr>
  <tr>
    <td>&nbsp; Journey Date </td>
    <td>&nbsp; '.dateViewFormat($bookingdata['pickupdate']).'</td>
    <td>&nbsp; Journey Time </td>
    <td>&nbsp; '.timeformatHiA($bookingdata['picktime']).'</td>
  </tr>
   <tr>
    <td>&nbsp; City Name </td>
    <td colspan="3">&nbsp; '.$bookingdata['thomecity'].'</td>
  </tr>
  <tr>
    <td>&nbsp; Pickup Location </td>
    <td colspan="3">&nbsp; '.$bookingdata['pickupaddress'].'</td>
  </tr>
  <tr>
    <td>&nbsp; Drop Location </td>
    <td colspan="3">&nbsp; '.$bookingdata['dropaddress'].'</td>
  </tr>';
  if($viaroute){
  $string.='<tr>
    <td>&nbsp; Via Route </td>
    <td colspan="3">&nbsp; '.$viaroute.'</td>
  </tr>';
  }
  
  $string.='<tr>
    <td>&nbsp; Booking Type  </td>
    <td>&nbsp; '.triptype($bookingdata['triptype']).' </td>
    <td>&nbsp; Trip Mode  </td>
    <td>&nbsp; '.$bookingtripmode.' </td>
  </tr>
   <tr>
    <td>&nbsp; Car Booked </td>
    <td>&nbsp; '.$bookingdata['vehiclename'].' </td>
	<td>&nbsp; Travel Days </td>
    <td>&nbsp; '.$bookingdata['useddays'].' Days</td>
  </tr>
  <tr>
    <td style="font-size:15px; font-weight:600">&nbsp; Fare Summary :</td>
    <td colspan="3">&nbsp;</td>
  </tr>';
   if($bookingdata['triptype']=='2'){
   $string.='<tr>
    <td>&nbsp; Fixed Cost  </td>
    <td>&nbsp; Rs. '.$bookingdata['fixedfare'].'</td>
    <td>&nbsp; Minimum Kms/Day  </td>
    <td>&nbsp; '.$bookingdata['basekm'].' Kms </td>
  </tr>
  <tr>
    <td>&nbsp; Per Km Charge After '.$bookingdata['basekm'].'Km </td>
    <td>&nbsp; Rs. '.$bookingdata['fareperkm'].' </td>
    <td>&nbsp; Night Charge after 9 Pm  </td>
    <td>&nbsp; Rs.'.$bookingdata['nightcharge'].'</td>
  </tr>
 
  <tr>
    <td>&nbsp; Minimum Hours  </td>
    <td>&nbsp; '.$bookingdata['basehours'].' Hours</td>
    <td>&nbsp; Extra Per Hours  </td>
    <td>&nbsp; Rs. '.$bookingdata['perhourcharge'].'/- Per Hour</td>
  </tr>
  <tr>
    <td>&nbsp; Toll Tax, Parking Tax</td>
    <td colspan="2">&nbsp; Rs. '.($bookingdata['stateentrytax'] + $bookingdata['tolltax']).'.00 <span style="float:right">Estimate Price With '.SERVICECHARGE.'% GST Charge &nbsp; </span></td>
    <td>&nbsp; Rs.'.$bookingdata['subtotal'].' </td>
  </tr>';
  }

   if($bookingdata['triptype']=='6'){
   $string.='<tr>
    <td>&nbsp; Fixed Cost/Day  </td>
    <td>&nbsp; Rs. '.$bookingdata['fixedfare'].'</td>
    <td>&nbsp; Travel Days  </td>
    <td>&nbsp; '.$bookingdata['useddays'].' Days </td>
  </tr> 
 
  <tr>
    <td>&nbsp; Toll Tax, Parking Tax</td>
    <td colspan="2">&nbsp; Rs. '.($bookingdata['stateentrytax'] + $bookingdata['tolltax']).'.00 <span style="float:right">Estimate Price With '.SERVICECHARGE.'% GST Charge &nbsp; </span></td>
    <td>&nbsp; Rs.'.$bookingdata['subtotal'].' </td>
  </tr>';
  }
  
   if($bookingdata['triptype']=='3'){
   $string.='<tr>
    <td>&nbsp; Fare Per Km </td>
    <td>&nbsp; Rs. '.$bookingdata['fareperkm'].'</td>
    <td>&nbsp; Total KMs </td>
    <td>&nbsp; '.$bookingdata['distance'].' Kms</td>
  </tr>
  <tr>
    <td>&nbsp; Minimum Kms </td>
    <td>&nbsp; '.$bookingdata['basekm'].' Kms</td>
    <td>&nbsp; Minimum Hours </td>
    <td>&nbsp; '.$bookingdata['basehours'].' Hours</td>
  </tr>
  <tr>
    <td>&nbsp; Driver Allowance  </td>
    <td>&nbsp; Rs. '.$bookingdata['drivercharge'].' </td>
    <td>&nbsp; Extra Per Km </td>
    <td>&nbsp; Rs. '.$bookingdata['fareperkm'].'</td>
  </tr>
  <tr>
    <td>&nbsp; Toll Tax, Parking Tax</td>
    <td colspan="2">&nbsp; Rs. '.($bookingdata['statetax'] + $bookingdata['tolltax']).'.00 <span style="float:right">Estimate Price With '.SERVICECHARGE.'% GST Charge &nbsp; </span></td>
    <td>&nbsp; Rs.'.$bookingdata['subtotal'].' </td>
  </tr>';
  }
   $string.='<tr>
    <td>&nbsp; Booking  Amount</td>
    <td >&nbsp; Rs. '.$bookingdata['advanceamount'].'/- '.payForMode($bookingdata['paymentmode']).'</td>
    <td ><span style="float:right">Balance Amount &nbsp; </span></td>
    <td>&nbsp; Rs.'.($bookingdata['subtotal'] - $bookingdata['advanceamount']).'/- </td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;  </td>
  </tr>
  <tr style="color: red;font-size: 14px; font-weight: 900;">
    <td colspan="4">&nbsp; Payment Details : '.$bookingdata['comment'].'</td>
  </tr>
  <tr>
    <td colspan="4"><br/>&nbsp; <p  style="font-size:15px; font-weight:600; text-align:center">&nbsp; Terms and Conditions :-<br/></p> ';
	 if($bookingdata['triptype']=='2' || $bookingdata['triptype']=='6'){
     $i=1;
	  $sql = mysqli_query($con,"select `terms` from `pt_bookingslip_terms` where `triptype` ='".$bookingdata['triptype']."' and `for`='slip'");
	while($data = mysqli_fetch_assoc($sql)){
		$string .= '<span style="clear:both; font-size:13px">&nbsp; '.$i.'). '.$data['terms'].'</span><br/>';
		$i++;}
	   } 
	 
	  if($bookingdata['triptype']=='3'){
      $string.='<span style="clear:both; font-size:13px">&nbsp; 1). If You Will Use Cab More Than '.$bookingdata['distance'].' Kms, Extra Charge as Follows After '.$bookingdata['distance'].' Kms. Rs.'.$bookingdata['fareperkm'].'.00 Per Km . </span><br/>
	  <span style="clear:both; font-size:13px">&nbsp; 2). Minimum '.$bookingdata['basekm'].' Kms will be charged per day for outstation use of car from Chandigarh. </span><br/>
	  <span style="clear:both; font-size:13px">&nbsp; 3). Driver Night Charge Rs.'.$bookingdata['drivercharge'].'/-  after 10.00 pm or before 6.30 am. </span><br/>';
	  $i=4;
	  $sql = mysqli_query($con,"select `terms` from `pt_bookingslip_terms` where `triptype` ='3' and `for`='slip'");
	while($data = mysqli_fetch_assoc($sql)){
		$string .= '<span style="clear:both; font-size:13px">&nbsp; '.$i.'). '.$data['terms'].'</span><br/>';
		$i++;}
	   } 
	 
     $string.='<br/><br/>
     
	 <span style="clear:both; font-size:13px">
	 
     <span style="clear:both; font-size:13px; font-weight:900;">&nbsp;<center> 1.	Registration No.: '.REGISTRATIONNO.', &nbsp; GST No.: '.GSTNO.', &nbsp; PAN No.: '.PANNO.'  </center></span><br/>';
	 
     $string.='<span><br/></span>
     </div>
    </td>
  </tr> 
</table>'; 


 //echo $string;
 
 $to = $bookingdata['temail'];
 $subject = MAILSUBJECT; 
 if($for=='mail'){  send_mail($to,$string,$subject,CC,FROM,MAILER,HOST,SERVERUSER,SERVERPASSWORD ); }
 if($for=='print'){return $string;}
	}

/********************** Send mail Function end **********************************/

/********************** Send mail For Duty Slip - 2 Start **********************************/
function directpaymentslip($con,$id,$for){
 $bookingdata = mysqli_fetch_assoc(mysqli_query($con,"select * from `pt_paymenttable` where `id`='".$id."' "));

 $string.='<table width="772" border="1" cellpadding="0" cellspacing="0" style="font-family: MelbourneRegular, Melbourne, Myriad Pro, Arial, Verdana, Helvetica sans-serif; font-size:15px; border:7px ridge #ccc;">
  <tr>
    <td colspan="4">
    <div style="width:210px; float:left;">&nbsp;<img src="'.LOGO.'" style="width: 190px;height: 91px;margin-top: 17px;"/></div>
    <div style="margin-top:10px; width:525px; float:left; text-align: right">&nbsp;
    <span>SCO. 98, 1st Floor Sector 47-C<br/>Chandigarh 160047(INDIA)<br/></span>
    <span>'.ADMINMOBILE.'<br/></span>
    <span>'.ADMINEMAIL.'<br/></span>
    <span><span style="float:left">ISO 9001:2008 Quality certified Travel Company</span>'.WEBSITE.'</span>
    </div>
    <div style="width:100%;  background:#2E3192; color:#ffffff;clear:both; letter-spacing:2px; text-align:center; font-weight:600">
    | CAR RENTAL | BIKE RENTAL | LUXURY &amp;  WEDDING CARS | TOUR PACKAGES |</div>
    
    <div style="width:100%; border-top:1px solid #111; float:left; font-size:18px">&nbsp; <br/> </div>
    </td>
  </tr>
  
   <tr>
    <td colspan="2">&nbsp;<span style="font-size:15px; font-weight:600"> Order ID: </span></td>
	 <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600"> '.$bookingdata['id'].'</span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;<span style="font-size:15px; font-weight:600"> Date :</span></td>
	 <td colspan="2">&nbsp; <span style="font-size:18px"> '.dateFormat($bookingdata['paydate']).'</span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600"> Customer Name :  </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">'.$bookingdata['fullname'].'</span></td>
  </tr>
   <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Customer Mobile : </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600"> '.$bookingdata['mobile'].'</span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Customer Email :   </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">'.$bookingdata['email'].'</span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Recieving Mode :   </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Online</span></td>
  </tr>
   <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Amount : </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">'.$bookingdata['amount'].'</span></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp; <span style="font-size:15px; font-weight:600">Payfor :  '.$bookingdata['payfor'].' </span></td>
  </tr>';
  
   $string.='
  <tr style="color: #153ADB;font-size: 13px; font-weight: 900;">
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;  Thanks for Us Choosing Rana Cabs Pvt Ltd™</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp; </td>
  </tr>
  <tr>
    <td colspan="4"><br/>';
     $string.='<span style="clear:both; font-size:13px; margin-left:100px">&nbsp; 1. Please check............................signed duty vouchers attached. </span><br/>
	 
     <span style="clear:both; font-size:13px; margin-left:100px">&nbsp; 2.	Mileage and time in charged from garage to garage. </span><br/>
     <span style="clear:both; font-size:13px; margin-left:100px">&nbsp; 3. All Disputes are subject to Chandigarh Jurisdiction. </span><br/>
     
	 <span style="clear:both; font-size:13px">
	 <span style="font-weight:900; float:left"> &nbsp; E. & O. E.</span> 
	 <span style="font-weight:900; float:right">   For   Rana Cabs (P) Ltd.™  &nbsp;</span> </span><br/>
     <span style="clear:both; font-size:13px">&nbsp;<center> Auth. Signature </center></span><br/>
     <span style="clear:both; font-size:13px; font-weight:900;">&nbsp;<center> 1. Registration No.: '.REGISTRATIONNO.', &nbsp; GST No.: '.GSTNO.', &nbsp; PAN No.: '.PANNO.'  </center></span><br/>';
	 
     $string.='<span><br/><br/><br/></span>
     </div>
    </td>
  </tr>
</table>';


 //echo $string;
 
 /********* sms admin----*/
 $msgadmin =  'Payment Recieved from '.$bookingdata['fullname'].', Mobile: '.$bookingdata['mobile'].', Amount: '.$bookingdata['amount'].', For '.shortLength($bookingdata['payfor'],'80','85').' on '.dateFormat($bookingdata['paydate']);

/********* sms admin end----*/

  $msgcustomer = 'Thank You for the Payment of Rs.'.$bookingdata['amount'].'/- against '.$bookingdata['payfor'].' successfull. RANA CABS';

/********* sms customer end----*/


 
 $to = $bookingdata['email'];
 $subject = 'Payment Received Slip '; 
 if($for=='mail'){  send_mail($to,$string,$subject,CC,FROM,MAILER,HOST,SERVERUSER,SERVERPASSWORD );  
  $adminmobileno = SMSADMINMOBILE;
  $sensmsd =  sendsms($adminmobileno,$msgadmin);    $sensmsd =  sendsms(eXxPlodeHas(',',$bookingdata['mobile'],'0'),$msgcustomer);
   }
 if($for=='print'){return $string;}
	}

/********************** Send mail For Duty Slip -2 end **********************************/

function carthumbnail($con,$id){
	$data = mysqli_fetch_assoc(mysqli_query($con,"select `image` from `pt_model`  where `vehiclemodel` ='".$id."' "));
	return $data['image'];
	}
	
function carcategoryfrommodel($con,$id){
	$data = mysqli_fetch_assoc(mysqli_query($con,"select `vechiclecategory` from `pt_model`  where `vehiclemodel` ='".$id."' "));
	$datacat = mysqli_fetch_assoc(mysqli_query($con,"select `category` from `pt_vehiclecategory`  where `id` ='".$data['vechiclecategory']."' "));
	$category =  $datacat['category'];
	return $category;
	}
	
function carseatfrommodel($con,$id){
	$data = mysqli_fetch_assoc(mysqli_query($con,"select `seatsegment` from `pt_model`  where `vehiclemodel` ='".$id."' "));
	$seatsegment = mysqli_fetch_assoc(mysqli_query($con,"select `seatsegment` from `pt_segment`  where `id` ='".$data['seatsegment']."' "));
	$seat =  $seatsegment['seatsegment'];
	return $seat;
	}		

function bagsfrommodel($con,$id){
	$data = mysqli_fetch_assoc(mysqli_query($con,"select `bags` from `pt_model`  where `vehiclemodel` ='".$id."' "));
	return $data['bags'];
	}

function bikethumbnail($con,$id){
	$data = mysqli_fetch_assoc(mysqli_query($con,"select `image` from `pt_bikes`  where `bikename` like '%".$id."%' "));
	return $data['image'];
	}

function bikeimages($con,$id){
	$data = mysqli_fetch_assoc(mysqli_query($con,"select `image` from `pt_bikes`  where `id`='".$id."' "));
	return $data['image'];
	}

function carimages($con,$id){
	$data = mysqli_fetch_assoc(mysqli_query($con,"select `image` from `pt_model`  where `id` ='".$id."' "));
	return $data['image'];
	}
	
function common_images($con,$name){
	$data = mysqli_fetch_assoc(mysqli_query($con,"select `imagename` from `common_images`  where `forwhatid` ='".$name."' "));
	return $data['imagename'];
	}	


/********************** Send mail For Query request **********************************/
function queryRequest($con,$id,$for){
 $bookingdata = mysqli_fetch_assoc(mysqli_query($con,"select * from `pt_request` where `id`='".$id."' "));

 $string.='<table width="758" border="1" cellpadding="0" cellspacing="0" style="font-family: MelbourneRegular, Melbourne, Myriad Pro, Arial, Verdana, Helvetica sans-serif; font-size:15px; border:7px ridge #ccc;">
  <tr>
    <td colspan="4">
    <div style="width:210px; float:left;">&nbsp;<img src="images/rana-cabs.png" style="width: 190px;height: 91px;margin-top: 17px;"/></div>
    <div style="margin-top:10px; width:525px; float:left; text-align: right">&nbsp;
    <span>SCO. 98, 1st Floor Sector 47-C<br/>Chandigarh 160047(INDIA)<br/></span>
    <span>'.ADMINMOBILE.'<br/></span>
    <span>'.ADMINEMAIL.'<br/></span>
    <span><span style="float:left">ISO 9001:2008 Quality certified Travel Company</span>'.WEBSITE.'</span>
    </div>
    <div style="width:100%;  background:#2E3192; color:#ffffff;clear:both; letter-spacing:2px; text-align:center; font-weight:600">
    | CAR RENTAL | BIKE RENTAL | LUXURY &amp;  WEDDING CARS | TOUR PACKAGES |</div>
    
    <div style="width:100%; border-top:1px solid #111; float:left; font-size:18px">&nbsp; <br/> </div>
    </td>
  </tr>
  
 
  <tr>
    <td colspan="2">&nbsp;<span style="font-size:15px; font-weight:600"> Date :</span></td>
	 <td colspan="2">&nbsp; <span style="font-size:18px"> '.dateFormat($bookingdata['date']).'</span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600"> Customer Name :  </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">'.ucw($bookingdata['name']).'</span></td>
  </tr>
   <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Customer Mobile : </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600"> '.$bookingdata['mobile'].'</span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Customer Email :   </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">'.$bookingdata['emailId'].'</span></td>
  </tr>

  <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Query For : </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">'.$bookingdata['query'].'</span></td>
  </tr>';
  
   $string.='
    <tr>
    <td colspan="4">&nbsp; </td>
  </tr>
  <tr style="color: #153ADB;font-size: 13px; font-weight: 900;">
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;  Thanks for Us Choosing Rana Cabs Pvt Ltd™</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp; </td>
  </tr>
  <tr>
    <td colspan="4"><br/>';
     $string.='<span style="clear:both; font-size:13px; margin-left:100px">&nbsp;</span><br/>
	  <span style="clear:both; font-size:13px; font-weight:900;">&nbsp;<center>This is a Computer Generated,Receipt.  </center></span><br/>';
	 
     $string.='<span><br/><br/><br/></span>
     </div>
    </td>
  </tr>
</table>';


 //echo $string;
 
 /********* sms admin----*/
 $msgadmin =  'New Query By '.shortLength($bookingdata['name'],'20','25').',Email: '.shortLength($bookingdata['emailId'],'50','55').', Mobile no.: '.$bookingdata['mobile'].', Query: '.shortLength($bookingdata['query'],'80','85');

/********* sms admin end----*/
  $adminmobileno = SMSADMINMOBILE;
  $msgcustomer = 'Thanks For Visiting Rana Cabs Website.Our Relationship Manager '.$adminmobileno.' Will Contact You Soon.';

/********* sms customer end----*/


 
 $to = $bookingdata['emailId'];
 $subject = 'Query Slip'; 
 if($for=='mail'){ /* send_mail($to,$string,$subject,CC,FROM,MAILER,HOST,SERVERUSER,SERVERPASSWORD );*/   return 'ok';
  $sensmsd =  sendsms($adminmobileno,$msgadmin);    $sensmsd =  sendsms($bookingdata['mobile'],$msgcustomer);
   }
 if($for=='print'){return $string;}
	}

/********************** Send mail For Query end **********************************/

/********************** Send mail Function for bike booking Start **********************************/
function bikebookingMailDip($con,$id,$for){
  $getdata = mysqli_fetch_assoc(mysqli_query($con,"select * from `pt_motorcyclebooking` where `id`='".$id."' "));

  $sringvalue.='<table width="788" border="1" cellpadding="0" cellspacing="0" style="font-family: MelbourneRegular, Melbourne, Myriad Pro, Arial, Verdana, Helvetica sans-serif; font-size:15px; border:7px ridge #ccc;">
  <tr>
    <td colspan="4">
    <div style="width:210px; float:left;">&nbsp;<img src="'.LOGO.'" style="width: 200px;height: 91px;margin-top: 17px;"/></div>
    <div style="margin-top:10px; width:544px; float:left; text-align: right">&nbsp;
    <span>SCO. 98, 1st Floor Sector 47-C<br/>Chandigarh 160047(INDIA)<br/></span>
    <span>'.CONTACT.'<br/></span> 
    <span>'.EMAIL.'<br/></span>
    <span><span style="float:left">ISO 9001:2008 Quality certified Travel Company</span>'.WEBSITE.'</span>
    </div>
    <div style="width:100%; background:#2E3192; color:#ffffff; clear:both; letter-spacing:2px; text-align:center; font-weight:600">
    | CAR RENTAL | BIKE RENTAL | LUXURY &amp;  WEDDING CARS | TOUR PACKAGES |</div>
    <div style="width:100%; color:#000000; margin:10px 0px 10px 0px; clear:both; text-align:center; font-weight:300">
    Dear '.$getdata['travellername'].',your booking ID is '.$getdata['bookid'].' .Request has been Successfully Processed. Car & chauffeur details will be send to you before reporting time. Thank You for Booking with Rana Cabs Pvt Ltd. </div>
    <div style="width:49.43%; border-top:1px solid #111; float:left; font-size:18px">&nbsp;Dear '.$getdata['travellername'].',Your Booking ID is  '.$getdata['bookid'].' <br/>
    </div>
    <div style="width:50%; border-top:1px solid #111; float:left; font-size:18px">&nbsp; Date : '.dateformatTimestampSlip($getdata['bookingdatetime']).'</div>
    </td>
  </tr>
   <tr>
    <td>&nbsp; Pickup Date / Time:</td>
    <td>&nbsp; '.dateeditFormatDMY($getdata['pickupdate']).', '.timeformatHiA($getdata['picktime']).'</td>
    <td>&nbsp; Order Date / Time:</td>
	<td>&nbsp; '.dateeditFormatDMY($getdata['bookingdatetime']).', '.timeformatHiA($getdata['bookingdatetime']).'</td>
   </tr>
   <tr>
    <td width="25%"><strong>&nbsp; Customer Details:</strong></td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp; Booking Status : </td>
    <td width="25%">&nbsp;'.bikeBookingstatus($getdata['advanceamount'],$getdata['cancelstatus']).'</td>
  </tr>
  <tr>
    <td width="25%">&nbsp; Customer Name: </td>
    <td width="25%">&nbsp; '.$getdata['travellername'].'</td>
    <td width="25%">&nbsp; Customer Mobile No.:</td>
    <td width="25%">&nbsp; '.$getdata['tmobile'].'</td>
  </tr>
  <tr>
    <td>&nbsp; Customer Email Id:</td>
    <td>&nbsp; '.$getdata['temail'].'</td>
    <td>&nbsp; Customer Home City:</td>
    <td>&nbsp; '.$getdata['thomecity'].'</td>
  </tr>
  <tr>
     <td>&nbsp; </td>
    <td colspan="3">&nbsp; </td>
  </tr>
  <tr>
    <td>&nbsp; Bike Name:</td>
    <td>&nbsp; '.$getdata['bikename'].'</td>
    <td>&nbsp; Total Days</td>
    <td>&nbsp; '.$getdata['useddays'].' Days</td>
  </tr>
  <tr>
    <td>&nbsp; Location :</td>
    <td colspan="3">&nbsp; '.$getdata['route'].' </td>
  </tr> 
   <tr>
    <td width="25%"><strong>&nbsp; Fare Details:</strong></td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp; Per Bike Rent:</td>
    <td>&nbsp; '.$getdata['perunitprice'].' INR</td>
    <td>&nbsp; Quantity:</td>
    <td>&nbsp; '.$getdata['units'].'</td>
  </tr>
  <tr>
    <td>&nbsp; Sub Total:</td>
    <td>&nbsp; '.$getdata['subtotal'].' INR</td>
    <td>&nbsp; Other Charges</td>
    <td>&nbsp; '.$getdata['othertax'].' INR</td>
  </tr>
  <tr>
     <td>&nbsp; GST Charge:</td>
    <td>&nbsp; '.$getdata['servicetax'].' %</td>
    <td>&nbsp; Online Charge:</td>
    <td>&nbsp; '.$getdata['onlinetax'].' %</td>
  </tr>
  <tr>
    <td>&nbsp; Grand Total:</td>
    <td>&nbsp; '.$getdata['grand'].' INR</td>
    <td>&nbsp; Discount:</td>
    <td>&nbsp; '.$getdata['discount'].' INR</td>
  </tr>
  <tr>
    <td>&nbsp; Final Total:</td>
    <td>&nbsp; '.$getdata['finaltotal'].' INR</td>
    <td>&nbsp; Advance Amount:</td>
    <td>&nbsp; '.$getdata['advanceamount'].' INR</td>
  </tr>
  <tr>
    <td>&nbsp; Rest Amount</td>
    <td>&nbsp; '.$getdata['restamount'].' INR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> 
  
  <tr>
    <td>&nbsp; Route</td>
    <td colspan="3">&nbsp; '.$getdata['route'].' </td>
  </tr> 
  
   <tr>
    <td colspan="4">
	<div style="font-weight:900; float:left;clear:both; width:100% !important"> &nbsp; Terms & Conditions.<br/></div>';
	$sql = mysqli_query($con,"select `terms` from `pt_bookingslip_terms` where `triptype` ='5' and `for`='slip'");
	while($data = mysqli_fetch_assoc($sql)){
		$sringvalue .= '<span style="clear:both; font-size:13px; margin-left:0px">&nbsp; <i class="fa fa-check-circle colr"></i>'.$data['terms'].' </span><br/>';
		}
		
     $sringvalue.='<br/><br/>
     
	 <span style="clear:both; font-size:13px">
	 <span style="font-weight:900; float:left"> &nbsp; E. & O. E.</span> 
	 <span style="font-weight:900; float:right">   For   Rana Cabs (P) Ltd.™  &nbsp;</span> </span><br/>
     <span style="clear:both; font-size:13px">&nbsp;<center> Auth. Signature </center></span><br/>
     <span style="clear:both; font-size:13px; font-weight:900;">&nbsp;<center> 1.	Registration No.: '.REGISTRATIONNO.', &nbsp; GST No.: '.GSTNO.', &nbsp; PAN No.: '.PANNO.'  </center></span><br/>';
	 
     $sringvalue.='<span><br/></span>
     </div>
    </td>
  </tr> 
</table>'; 


 //echo $sringvalue;
 
 $to = $getdata['temail'];
 $subject = 'Bike Booking Slip'; 
 if($for=='mail'){  $sendmail = send_mail($to,$sringvalue,$subject,CC,FROM,MAILER,HOST,SERVERUSER,SERVERPASSWORD ); }
 if($for=='print'){return $sringvalue;}
	}

/********************** Send mail Function end **********************************/


function allpagetype($id){
	if($id=='carpage'){ $data = 'Car';}
	else if($id=='bikepage'){ $data = 'Bike';}
	else if($id=='selfdrive'){ $data = 'Car';}
	else if($id=='bycycle'){ $data = 'Bycycle';}
	else if($id=='assesseries'){ $data = 'Assesseries';}
	return $data;
	}
	
	
	
/********************** Send mail Function Start **********************************/
function commonbookingMailDip($con,$id,$for){
  $getdata = mysqli_fetch_assoc(mysqli_query($con,"select * from `all_common_booking` where `id`='".$id."' "));

  $sringvalue.='<table width="788" border="1" cellpadding="0" cellspacing="0" style="font-family: MelbourneRegular, Melbourne, Myriad Pro, Arial, Verdana, Helvetica sans-serif; font-size:15px; border:7px ridge #ccc;">
  <tr>
    <td colspan="4">
    <div style="width:210px; float:left;">&nbsp;<img src="'.LOGO.'" style="width: 200px;height: 91px;margin-top: 17px;"/></div>
    <div style="margin-top:10px; width:555px; float:left; text-align: right">&nbsp;
    <span>SCO. 98, 1st Floor Sector 47-C<br/>Chandigarh 160047(INDIA)<br/></span>
    <span>'.CONTACT.'<br/></span>
    <span>'.EMAIL.'<br/></span>
    <span><span style="float:left">ISO 9001:2008 Quality certified Travel Company</span>'.WEBSITE.'</span>
    </div>
    <div style="width:100%; background:#2E3192; color:#ffffff; clear:both; letter-spacing:2px; text-align:center; font-weight:600">
    | CAR RENTAL | BIKE RENTAL | LUXURY &amp;  WEDDING CARS | TOUR PACKAGES |</div>
    <div style="width:100%; color:#000000; margin:10px 0px 10px 0px; clear:both; text-align:center; font-weight:300">
    Dear '.$getdata['travellername'].',your booking ID is '.$getdata['bookid'].' .Request has been Successfully Processed. Car & chauffeur details will be send to you before reporting time. Thank You for Booking with Rana Cabs Pvt Ltd. </div>
    <div style="width:49.43%; border-top:1px solid #111; float:left; font-size:18px">&nbsp;Dear '.$getdata['travellername'].',Your Booking ID is  '.$getdata['bookid'].' <br/>
    </div>
    <div style="width:50%; border-top:1px solid #111; float:left; font-size:18px">&nbsp; Date : '.$getdata['bookingdatetime'].'</div>
    </td>
  </tr>
    <tr>
    <td>&nbsp; Pickup Date:</td>
    <td>&nbsp; '.dateFormat($getdata['pickupdate']).'</td>
    <td>&nbsp; Order Date:</td>
    <td>&nbsp; '.dateeditFormatDMY($getdata['bookingdatetime']).', '.timeformatHiA($getdata['bookingdatetime']).'</td>
  </tr>
   <tr>
    <td width="25%"><strong>&nbsp; Customer Details:</strong></td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">&nbsp; Customer Name: </td>
    <td width="25%">&nbsp; '.$getdata['travellername'].'</td>
    <td width="25%">&nbsp; Customer Mobile No.:</td>
    <td width="25%">&nbsp; '.$getdata['tmobile'].'</td>
  </tr>
  <tr>
    <td>&nbsp; Customer Email Id:</td>
    <td>&nbsp; '.$getdata['temail'].'</td>
    <td>&nbsp; Customer Home City:</td>
    <td>&nbsp; '.$getdata['thomecity'].'</td>
  </tr>
  <tr>
     <td>&nbsp; Customer Address:</td>
    <td colspan="3">&nbsp; '.$getdata['taddress'].'</td>
  </tr>
  <tr>
    <td>&nbsp; '.$getdata['type'].' Name:</td>
    <td>&nbsp; '.$getdata['itemname'].'</td>
    <td>&nbsp; Total Days</td>
    <td>&nbsp; '.$getdata['useddays'].' Days</td>
  </tr>
   <tr>
    <td width="25%"><strong>&nbsp; Fare Details:</strong></td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp; Per Bike Rent:</td>
    <td>&nbsp; '.$getdata['perunitprice'].' INR</td>
    <td>&nbsp; Quantity:</td>
    <td>&nbsp; '.$getdata['units'].'</td>
  </tr>
  <tr>
    <td>&nbsp; Sub Total:</td>
    <td>&nbsp; '.$getdata['subtotal'].' INR</td>
    <td>&nbsp; Other Charges</td>
    <td>&nbsp; '.$getdata['othertax'].' INR</td>
  </tr>
  <tr>
     <td>&nbsp; GST Charge:</td>
    <td>&nbsp; '.$getdata['servicetax'].' %</td>
    <td>&nbsp; Online Charge:</td>
    <td>&nbsp; '.$getdata['onlinetax'].' %</td>
  </tr>
  <tr>
    <td>&nbsp; Grand Total:</td>
    <td>&nbsp; '.$getdata['grand'].' INR</td>
    <td>&nbsp; Discount:</td>
    <td>&nbsp; '.$getdata['discount'].' INR</td>
  </tr>
  <tr>
    <td>&nbsp; Final Total:</td>
    <td>&nbsp; '.$getdata['finaltotal'].' INR</td>
    <td>&nbsp; Advance Amount:</td>
    <td>&nbsp; '.$getdata['advanceamount'].' INR</td>
  </tr>
  <tr>
    <td>&nbsp; Rest Amount</td>
    <td>&nbsp; '.$getdata['restamount'].' INR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';
  
    $sringvalue.='<tr>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
   <td colspan="4">
	<div style="font-weight:900; float:left;clear:both; width:100% !important"> &nbsp; Terms & Conditions.<br/></div>';
	 $sringvalue.='<br/><br/>
     
	 <span style="clear:both; font-size:13px">
	 
     <span style="clear:both; font-size:13px; font-weight:900;">&nbsp;<center> 1.	Registration No.: '.REGISTRATIONNO.', &nbsp; GST No.: '.GSTNO.', &nbsp; PAN No.: '.PANNO.'  </center></span><br/>';
	 
     $sringvalue.='<span><br/></span>
     </div>
    </td>
</table>'; 


 //echo $sringvalue;
 
 $to = $getdata['temail'];
 $subject = $getdata['type'].' Booking Slip'; 
 if($for=='mail'){  /*send_mail($to,$sringvalue,$subject,CC,FROM,MAILER,HOST,SERVERUSER,SERVERPASSWORD );*/ }
 if($for=='print'){return $sringvalue;}
	}

/********************** Send mail Function end **********************************/

function avnonac($data){
	if($data=='Ac'){ $reurndata = 'AC';}
	else if($data=='Non Ac'){ $reurndata = 'Non AC';}
	return $reurndata;
	}
	
function termsConSeacrEngine($con,$id){
	$rtdata = '<ol>';
	$sql = mysqli_query($con,"select `terms` from `pt_bookingslip_terms` where `triptype` ='".$id."' and `for`='search'");
	while($data = mysqli_fetch_assoc($sql)){
		$rtdata .= "<li> ".$data['terms']."</li>";
		}
		$rtdata .= '</ol>';
	return $rtdata;
	}	

function GetcommonImageByName($con,$name,$type){
	$image = mysqli_fetch_assoc(mysqli_query($con,"select `imagename` from `common_images` where `forwhatid` = '".$name."' and `type`='".$type."' "));
	return $image['imagename'];
	}

function GetfromFare($con,$input){
	$vehicle = mysqli_fetch_assoc(mysqli_query($con,"SELECT `id` FROM `pt_model` WHERE `vehiclemodel` LIKE '%".$input."%' "));
	   $fare = mysqli_fetch_assoc(mysqli_query($con,"select `minkm`,`fareperkm` from `pt_fare` where `triptype`='3' and `vehiclemodel`='".$vehicle['id']."' "));
	  return ($fare['minkm'] * $fare['fareperkm']);
	}
	
	
function Getbbikefare($con,$input){
	$bike = mysqli_fetch_assoc(mysqli_query($con,"SELECT `id` FROM `pt_bikes` WHERE `bikename` LIKE '%".$input."%' "));
	$fare = mysqli_fetch_assoc(mysqli_query($con,"select `bikefare` from `pt_bike_fare` where `bikename` = '".$bike['id']."'  "));
	return $fare['bikefare'];
	}

function offerzone($con){
	$sql = mysqli_query($con,"SELECT * FROM `pt_marquee` WHERE `statusv`='1' ");
	while($data = mysqli_fetch_assoc($sql)){
		 $rdata.= $data['marquee'].'&nbsp; # &nbsp; ';
		}
	return $rdata;
	}

/* Encryption Code Start Here */
 function hex2bind($hexdata) {
                  $bindata = '';

                  for ($i = 0; $i < strlen($hexdata); $i += 2) {
                        $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
                  }

                  return $bindata;
                 }
				
			
				
    $iv = 'ihgfedcba9876543210HGYtRE&^%$(*&';  
    $key = '0123456789abcdefghi=+-0*&^';  

	define("KEY",$key);
	define("IV",$iv);

               

                function encrypt($str) {
  
                  $iv = IV;

                  $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);

                  mcrypt_generic_init($td, KEY, $iv);
                  $encrypted = mcrypt_generic($td, $str);

                  mcrypt_generic_deinit($td);
                  mcrypt_module_close($td);

                  return bin2hex($encrypted);
                  }

               
			   
			    function decrypt($code) {
					
                  $code = hex2bind($code);
                  $iv = IV;

                  $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);

                  mcrypt_generic_init($td, KEY, $iv);
                  $decrypted = mdecrypt_generic($td, $code);

                  mcrypt_generic_deinit($td);
                  mcrypt_module_close($td);

                  return utf8_encode(trim($decrypted));
                }

	/* Encryption Code end Here */


function insertTransactionLog($con,$fullname,$email,$amount,$taxnid,$mesagstaus,$orderno,$website,$payfor){
	$valid = mysqli_num_rows(mysqli_query($con,"select `id` from `pt_transaction_log` where `transactionid`='".$taxnid."' and `order_no`='".$orderno."'  "));
	if(empty($valid)){ $orderdatetime = date('Y-m-d H:i:s');
	$insert="INSERT INTO `pt_transaction_log`(`id`, `fullname`, `emailid`, `order_no`, `amount`, `transactionid`, `gatewaystatus`, `transactiondate`, `websitename`, `status`,`payfor`) VALUES (NULL,'".$fullname."','".$email."','".$orderno."','".$amount."','".$taxnid."','".$mesagstaus."','".$orderdatetime."','".$website."','0','".$payfor."')";
	$done = mysqli_query($con,$insert);
	if($done){$output=true; }else{ $output=false; }
	}else{ $output=false;}
	return $output;
	}	
	
	
function checkplength($str){
	if( strlen($str) > 20 ){ $output = $str.'...'; }else{ $output = $str; }
	return $output;
	}	
		
	
?>