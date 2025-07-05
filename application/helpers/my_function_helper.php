<?php //defined('BASEPATH') or exit("No Direct Access Allowed!");

if(!function_exists('ci')){ 
	function ci(){ $ci = & get_instance(); return $ci; }
}

function chk_password_expression($str) {
       if (1 !== preg_match("/^.*(?=.{6,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $str)){
        $this->form_validation->set_message('chk_password_expression', '%s must be at least 6 charascters and must contain at least one lower case letter, one upper case letter and one digit');
        return FALSE;
        }else{
        return TRUE;
        }
} 


function adminurl($path){ return base_url('private/'.$path); }
	
function adminfold($path){ return ('private/'.$path); }


function adminlogincheck(){ 
	$logincheck = ci()->session->userdata('adminloginstatus'); 
	if(!$logincheck['checklogin']){ ci()->session->sess_destroy();  redirect( PEADEX.'mylogin.html' );  }  
}

function checkdomain($key=null){
	$arr = ci()->session->userdata('checkdomain'); 
	return (!empty($key) && !empty($arr)) ? $arr[$key] : $arr;
}

/* notifications script start */
function notifications(){
	$output = '';
   if(ci()->session->flashdata('error')){
       $output = ci()->session->flashdata('error');
   }else if(ci()->session->flashdata('warning')){
       $output = ci()->session->flashdata('warning');
   }else if(ci()->session->flashdata('success')){
       $output = ci()->session->flashdata('success');
   }
   return $output;
}
/* notifications script end */



if(!function_exists('_view')){
function  _view($page,$data = null){
	        ci()->load->view( adminfold('includes/all-css'),$data);
	        ci()->load->view( adminfold('includes/header'),$data);
	        ci()->load->view( adminfold('includes/menu'),$data);
	        ci()->load->view( adminfold('includes/heading'),$data); 
		    ci()->load->view( adminfold($page),$data );
		    ci()->load->view( adminfold('includes/footer'),$data );
		    ci()->load->view( adminfold('includes/all-js'),$data );
		    ci()->load->view( adminfold('includes/datetime-picker'),$data );
	 }
}

if(!function_exists('_viewlist')){	
 function  _viewlist($page,$data = null){
	        ci()->load->view( adminfold('includes/all-css'),$data);
	        ci()->load->view( adminfold('includes/header'),$data);
	        ci()->load->view( adminfold('includes/menu'),$data);
	        ci()->load->view( adminfold('includes/heading'),$data); 
		    ci()->load->view( adminfold($page),$data );
		    ci()->load->view( adminfold('includes/footer'),$data ); 
		    ci()->load->view( adminfold('includes/all-data-listing-js'),$data ); 

	 }	 
}
/*** start drop down  function script ****/ 	
if(!function_exists('get_dropdownsmulti')){
  function get_dropdownsmulti($table,$where = null,$key = null,$name = null,$type=false )
  {
	  if(!is_null($where)){
	  $rows=ci()->db->order_by($name.' asc')->get_where($table,$where)->result_array();
	  }else{
	  $rows=ci()->db->order_by($name.' asc')->get($table)->result_array();
	  }
	  $return = array();
	  $return['']="--- Select ".$type;
	  if(!empty($rows))
	  { 
	  	foreach($rows as $row)
		{
		 $return[$row[$key]]=$row[$name];
		}
	  }
	 return $return;
  }
}

/*** start drop down  function script ****/ 	
if(!function_exists('get_dropdownsmultitxt')){
  function get_dropdownsmultitxt($table,$where = null,$key = null,$name = null,$type=false, $select_keys=null, $extrakeyname = null  )
  {
      $selectKeys = '';
      if(!empty($key)){
        $selectKeys = $key.',';  
      }
      if(!empty($name)){
        $selectKeys .= $name.',';  
      }
      if(!empty($select_keys)){
        $selectKeys .= $select_keys;  
      }
      
	  if(!empty($where)){
	  $rows=ci()->db->select($selectKeys)->order_by($name.' asc')->get_where($table,$where)->result_array();
	  }else{
	  $rows=ci()->db->select($selectKeys)->order_by($name.' asc')->get($table)->result_array();
	  }
	  
	 // echo ci()->db->last_query(); exit;
	   
	  $return = array();
	  $return['']="--- Select ".$type;
	  
	  $text_key = !empty($extrakeyname) ? $extrakeyname : $name;
	  if(!empty($rows))
	  { 
	  	foreach($rows as $row)
		{ 
		 $return[$row[$key]]=$row[$text_key];
		}
	  }
	 return $return;
  }
}


if(!function_exists('nullv')){
  function nullv( $str ){ 
  	return $str > 0 ? $str : 0;
  }
 }	

if(!function_exists('createDropdown')){
  function createDropdown($rows,$key,$name,$type=false )
  { 
	  $return = array();
	  $type ? $return['']="--- Select ".$type:null;
	  if(!empty($rows))
	  { 
	  	foreach($rows as $row)
		{
		 $return[$row[$key]]=$row[$name];
		}
	  }
	 return $return;
  }
}

 

if(!function_exists('activeststus')){
function activeststus( $status ){
	return ( $status =='yes' ) ? 'Active' : (( $status =='block' ) ? 'Blocked' : 'Inactive');
	}
}	
	
function datetime( $data ){
	return date('d M Y h:i A',strtotime($data ));
	}	
	
function dateformat( $data,$format ){
	return date($format,strtotime($data ));
	}	

 function statusv($data){
	$return .= '<option value="">---select---</option>';
	$return .= '<option '.( $data == 'yes' || $data == '' ? 'selected' : '' ).'  value="yes">Active</option>';
	$return .= '<option '.( $data == 'no' ? 'selected' : '' ).'  value="no">In Active</option>';
	return  $return;
	}

function capitalize( $str ){
	$str = strtolower( $str );
	$str = ucwords( $str );
	return $str;
	}	

if(!function_exists('fetchall')){
  function fetchall($table, $where , $keys = null, $orderby = null ){
  	if( !is_null($keys) && !empty($keys)){ $row = ci()->db->select($keys);}
  	if( !is_null($orderby)){ $row = ci()->db->order_by( $orderby ); }
	$row = ci()->db->get_where($table,$where);
	$row = $row->result_array();
	   return $row;
   }
}

/**************  sms format start *********************/


if(!function_exists('sendsms')){
function sendsms($mobile,$message, $TemplateID = null){
	
	$str = urlencode($message);
	$mobile = preg_replace('!\\r?\\n!', "", $mobile); 
    	$url = 'http://nimbusit.biz/api/SmsApi/SendSingleApi?UserID='.trim( SMSUSERNAME ).'&Password='.trim( SMSPASSWORD ).'&SenderID='.trim( SENDERID ).'&Phno='.$mobile.'&Msg='.$str.'&EntityID='.trim( SMSENTITYID ).'&TemplateID='.$TemplateID;
	    $ch = curl_init();                       // initialize CURL 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_MAXREDIRS , 10);
        $output = curl_exec($ch);
        curl_close($ch);      
  
   return true; 
}
}

 
/******************* sms format  start **********************/


if(!function_exists( 'getdays' )){	
function getdays($start,$end){ 
$start_n = strtotime(  date('Y-m-d',strtotime($start)) );
$end_n = strtotime(  date('Y-m-d',strtotime($end)) );
$days_between = ceil(abs($end_n - $start_n) / 86400);
return ( date('Y-m-d',strtotime($start)) != date('Y-m-d',strtotime($end))) ? ( $days_between + 1 ) : 1;	
}
}


function gettimedeffrence($start,$end){
		$to_time = strtotime($end);
		$from_time = strtotime($start);
        $diff = round(abs($to_time - $from_time) / 60,2). " minute";
        return  $diff;
	}

	
function tripstartendotp($array,$type){
	$smsbody = SMSPREFIX."! Your ".$type." trip OTP is:".$array['otp'] ;
	$mobile = $array['mobile'];
	$output = strlen($mobile) == 10 ? simplesms($mobile,$smsbody) : '' ;
	return  !empty($output) ? true : false;
	}	


/* ------------------  google matrix api start  -----------------*/
function googleMatrixApi($source,$destination ){
    $Api = GGOGLEMATRIX; 
	$distance = '';
	$duration = '';	  
	$origin = !empty($source) ?  urlencode($source) : null;
	$destination = !empty($destination) ?  urlencode($destination) : null;
	$urlf = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$origin.'&destinations='.$destination.'&mode=driving&language=en-US&key='.$Api.'';
	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $urlf);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
	$jsondata = curl_exec($curl);
    curl_close($curl);
	$data = json_decode($jsondata, true);
	
	$output['sourcecity'] = '';
	$output['destinationcity'] = '';
	$output['distance_text'] = '';
	$output['distance_value'] = '';
	$output['time_text'] = '';
	$output['time_value'] = '';
 
if( $data['status'] == 'OK'){ 
$output['sourcecity'] = $data['origin_addresses'][0];
$output['destinationcity'] = $data['destination_addresses'][0];
$output['distance_text'] = isset($data['rows'][0]['elements'][0]['distance']['text'])?$data['rows'][0]['elements'][0]['distance']['text']:false;
$output['distance_value'] = isset($data['rows'][0]['elements'][0]['distance']['value'])?$data['rows'][0]['elements'][0]['distance']['value']:false;
$output['time_text'] = isset($data['rows'][0]['elements'][0]['duration']['text'])?$data['rows'][0]['elements'][0]['duration']['text']:false;
$output['time_value'] = isset($data['rows'][0]['elements'][0]['duration']['value'])?$data['rows'][0]['elements'][0]['duration']['value']:false;
}
return  $output;
}


if(!function_exists('viadistancecalutaor')){
function viadistancecalutaor($source,$destination){
$allcitylist = $source.'|'.$destination; 
$waypoint = explode('|',$allcitylist);
$lastcity =  end( $waypoint );
if( $lastcity != $source ){
$waypoint[] = $source;
}

 $kms = '';
 $time = '';
 $routes = [];
 
$count = count( $waypoint );
$i = 1;
foreach( $waypoint as $key => $value){

			if( $i < $count ){
			$source = $waypoint[$key];
			$destination = $waypoint[$key+1];
			$arraydist = googleMatrixApi( $source, $destination ); 
			$tempkm = ($arraydist['distance_value']); 
			$kms = ((int)$kms + (int)$tempkm);
			$temptime = $arraydist['time_value'];
			$time = ((int)$time + (int)$temptime);
			}

	$i++;
} 

$data = [];
$data['kms'] = round($kms/1000);
$data['time'] = round($time/60);
$data['routes'] = $waypoint;
 return $data;
}
}
/* ------------------  google matrix api end -----------------*/




if(!function_exists('viacitybypipe')){

	function viacitybypipe( $via ){
     $output = ''; 
     if(!is_null($via)){
     	foreach ($via as $value) {
     		$output .= $value.'|';
     	}
     }

     $output= rtrim($output,'|');
     return $output;
      
	}
}



if(!function_exists('getftcharray')){
  function getftcharray($table, $where, $name, $limit = null){
	  if( !is_null( $limit ) ){ ci()->db->limit( $limit );  }
	$row = ci()->db->get_where($table,$where);
	$row = $row->row_array();
	   if(!empty($row)){
	     return $row[$name];
	   }
  }
}


if(!function_exists('fetchrow')){
  function fetchrow($table, $where,$keys = null ){
  	if( !is_null($keys) && !empty($keys)){ $row = ci()->db->select($keys);}
	$row = ci()->db->get_where($table,$where);
	$row = $row->row_array();
	   return $row;
   }
}


if(!function_exists('checkfile')){ 
	function checkfile($str){
		return ( $str && file_exists( ROOTPATH.'/uploads/'.$str) );
	}
}



if(!function_exists('profile_upload')){ 
  function profile_upload($base64, $name = null ) 
  {
	if (!is_dir('uploads')) { mkdir('./uploads', 0777, true);}
    $img = imagecreatefromstring(base64_decode($base64));
    if ($img != false) 
	{
        $imageName = ( !is_null($name) ? $name : time().rand(100,999) ) . '.jpg'; 
        $path = './uploads/'.$imageName;
        if (imagejpeg($img, $path)){
            return $imageName;
        }else{
            return false;
       }
    }else{ return false; }
  }
}

 
 /**************** Curl Section  section start ***************** */	
function curl_apis($url,$method,$array = null ,$header = null,$time = null){
	
	if($method == 'POST'){  $jsonstring = json_encode($array); }
	
	$curl = curl_init();
    if(!is_null($time)){ $timeout = $time;}else{ $timeout = 50; }
    curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HEADER, FALSE);
	curl_setopt($curl, CURLOPT_POST, $method);
	if($method == 'POST'){  curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonstring); }
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
	
	if($method == 'POST'){ curl_setopt($curl, CURLOPT_POST, TRUE); }
	if(!is_null($header)){ curl_setopt($curl, CURLOPT_HTTPHEADER, $header); }
   
    $jsondata = curl_exec($curl);
    curl_close($curl);
	$data = json_decode($jsondata, TRUE);
	return $data;
}	

/********************** Curl Section section end ***************** */	


if(!function_exists('utmen')){
  function utmen($str){
     return  base64_encode( json_encode( $str ) );
  }
}

if(!function_exists('utmde')){
  function utmde($str){
     return  json_decode( base64_decode( $str ) , true );
  }
}

function allerrors(){
        // Turn off error reporting
        error_reporting(0);
        
        // Report runtime errors
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        
        // Report all errors
        error_reporting(E_ALL);
        
        // Same as error_reporting(E_ALL);
        ini_set("error_reporting", E_ALL);
        
        // Report all errors except E_NOTICE
        error_reporting(E_ALL & ~E_NOTICE);
}

function getparam($prefix = null){
	 $output = false;
	 $request_data = file_get_contents('php://input');
	 if( !empty($request_data) ){
      $requestJson = json_decode($request_data,TRUE); 
	 $output = !empty($prefix) ? $requestJson[$prefix] : $requestJson ;
	 }
	  return  ( !empty($output) )  ? $output : '';
}

function multitosingle($simbol,$str){
	$str = preg_replace("/".$simbol."+/", $simbol,$str);
	return rtrim($str,$simbol);
}	



/*** start drop down  function script ****/ 	
if(!function_exists('get_driverassignlist'))
{
  function get_driverassignlist($table,$where = null,$keyid=null ){
  	  $keys = 'id,uniqueid,fullname,vehicleno,mobileno';
  	  if(is_null($keyid)){ $keyid = 'uniqueid';}
      ci()->db->select($keys);
	  if(!is_null($where)){
	  $rows = ci()->db->order_by('fullname ASC')->get_where($table,$where)->result_array();
	  }
	  $return = array();
	  $return['']="-- Select Driver --";
	  if(!empty($rows))
	  { 
	  	foreach($rows as $row)
		{
		 $return[$row[$keyid]] = ucwords($row['fullname']).' &nbsp; { '.$row['mobileno'].'  -  '.$row['vehicleno'].' }';
		}
	  }
	 return $return;
  }
}	


/*php mailer start */
function sendmail($to,$subject,$message ,$file = null,$replyto = null ){
	            
	            $hostname = $_SERVER['HTTP_HOST'];
	            $ip = gethostbyname($hostname);

                if($ip != '127.0.0.1'){
				ci()->load->library('email');
				
				$config['protocol'] = 'smtp';
				$config['smtp_host'] = FHOST ;
				$config['smtp_user'] = FSERVERUSER ;
				$config['smtp_pass'] = FPASSWORD ;
				$config['smtp_port'] = 587;
				
				$config['charset'] = 'utf-8'; 
				$config['wordwrap'] = TRUE;

				$config['wrapchars'] = 76;
				$config['priority'] = 1;
				$config['mailtype'] = 'html';
				//$config['smtp_crypto'] = 'tls';
				
				
				$from = FROMMAIL ; 
				$mailer = FMAILER;
				$cc = FCC ;
				$bcc = ''; 
				
				ci()->load->library('email',$config); 

                ci()->email->set_newline("\r\n");
                ci()->email->set_header('MIME-Version', '1.0; charset=utf-8');
                ci()->email->set_header('Content-type', 'text/html');
	 
				
				ci()->email->from( $from, $mailer );
				ci()->email->to( $to , $mailer );
				!empty($cc) ? ci()->email->cc( $cc , $mailer) : '';
				if( !is_null($replyto)){  ci()->email->reply_to($replyto , $mailer ); }
				!empty($bcc) ? ci()->email->bcc( $bcc , $mailer) : '';
				ci()->email->subject( $subject );
				if( !is_null($file)){ ci()->email->attach( $file );}
				ci()->email->message( $message );
				
				if( ci()->email->send() ) {
				return true;
				} else {
				return false;
				//echo ci()->email->print_debugger();
				}
			}else{ return false;}
				
}
/*php mailer end */


function twoDecimal($value){
    $decimal = number_format((float)$value,2,'.','');
	return $decimal;
}
	 
function percentage($value,$percent){
	 return ( $value * $percent) / 100;
	 } 
function withnpercent($value,$percent){
	 $output = $value + ( $value * $percent) / 100;
	  return $output;
} 

  
 


function getexplode($str,$position ){
	$str = rtrim($str,',');
	$explode = explode(',',$str);
	return $explode[$position];
	}
	
function getdropcityname( $str , $simbol = null ){
	$str = rtrim($str,'|');
	$explode = explode('|',$str);
	$simb = $simbol ? $simbol : ', ';
	$output = '';
	if( !is_null($explode)){
	foreach($explode as $value):
	 /*$output .= getfirstname($value,'0' ).$simb; */
	 !empty($value) ? ($output .= trim($value).$simb) : NULL; 
	endforeach;
	}
	$output = rtrim($output,$simb);
	return $output; 
	}

function destinationcityname( $str ){
	$str = getdropcityname($str);
	$explode = strpos($str,',') !== false ? explode(',',$str) : '';
	$output = ( !is_null($explode) && !empty($explode) ) ? end( $explode ) : $str;
	return $output; 
	}	

function drawroute( $str ,$simbol){
	$output = strpos($str,'|') !== false ? getdropcityname($str,$simbol) : '';
	return $output;
	}

function getdestroute($dropaddress){ 
$route = array(); $newroute = array();
if( strpos( $dropaddress, '|') !== false ){
$route1 = rtrim($dropaddress,'|');
$route = explode('|', $route1);
//$dropaddress = array_shift($route); /*to get first city*/
$dropaddress = end($route); /*to get last city*/
$j = 1;
 foreach ($route as $key => $rtvalue) {
 	if(!empty($rtvalue) && ($dropaddress != $rtvalue)){
  	 array_push($newroute, array('location'=> trim($rtvalue)) ) ;
  	}
  	 $j++;
  } 
}

$output['destination'] = trim($dropaddress);
$output['route'] = $newroute ? $newroute : array();
return $output;
}	
	

if(!function_exists('trimfilter')){
function trimfilter($str){
	$str = trim($str);
	$str = rtrim($str,',');
	$str = ltrim($str,',');
	return $str;
}
}



if(!function_exists('termlist')){ 
function termlist( $datacategory = null,$contenttype = null ){
	$wherear['status'] = 'yes';
	if(!is_null($datacategory)){ $wherear['datacategory'] = $datacategory;}
	if(!is_null($contenttype)){ $wherear['contenttype'] = $contenttype;} 
	$arrayy = fetchall( 'booking_terms' , $wherear ,'content as points,contenttype' );
	$output = array();  
	if( !is_null( $arrayy )){ 
	foreach( $arrayy as $key=>$value):
	$arr = array('point'=>(string) $value['points'],'ctype'=>(string) $value['contenttype'] );
	array_push($output,$arr);  
	endforeach;
	
	}
	return $output;

}
}




function hourtoMin($str){
	$data = '';
	$newstring = preg_replace('/\s+/', '', $str); 
	$posmin = $str ? strpos($newstring, 'mins','1') : ''; 
	$poshours = $str ? strpos($newstring, 'hours','1') : '';  
	
	$explodehr = explode("hours",$newstring);
	$explodemin = explode("mins",$newstring);
	
	if($poshours > 0 && $posmin > 0 ){
		$data = $explodehr[0]*60 + $explodehr[1];
	}else if($poshours > 0 ){
	$data = $explodehr[0]*60;
	}else if($posmin > 0 ){
	$data = $explodemin[0];
	}
	return $data;
	}
	
function hourtoMincolumn($str){ 
	$explodehr = explode(":",$str);
	return $explodehr[0]*60 + $explodehr[1];
	}	
	 

function getbysimbolmulti($arraydata,$simbol,$keyname = null,$prenext = null){
	$output = ''; 
	
	if( !is_null($keyname)){
		
	foreach($arraydata as $key=>$value):
	    if( !is_null($prenext)){
	    $output .= $prenext.''.($value[$keyname]).''.$prenext.''.$simbol.'';
		}else{
			$output .= ($value[$keyname]).''.$simbol.'';
			}
	endforeach;
	
	}else{
		
	foreach($arraydata as $value):
	     if( !is_null($prenext)){ 
		 $output .= $prenext.''.($value).''.$prenext.''.$simbol.'';
		 }else{
			 $output .= ($value).''.$simbol.'';
			 }
	endforeach;
	
	}
	
	return rtrim($output,',');
	}		
/*** end drop down function script ****/ 


if(!function_exists('uploads')){		
function uploads($folder){
	return base_url().$folder.'/';
	}	
}

 
if(!function_exists('uploadlists')){
	
function uploadlists( $wherearray ){
	
	$array = fetchall('uploads', $wherearray );
	$output = array(); 
	 
	if( !is_null( $array )){ 
	foreach( $array as $value):
	$arr = array('documenttype'=>(string) ($value['documenttype']),
	'verifystatus'=> (string)$value['verifystatus'],
	'image'=> (string) ( $value['documentorimage'] ? base_url('uploads/'.$value['documentorimage']) : ''),
	'uploaddate'=> (string) date('d M Y h:i A',strtotime($value['uploaddate'])),);
	array_push($output,$arr);  
	endforeach;
	
	}
	return $output;

}
}
 
if(!function_exists('empty_table')){
	function empty_table( $table ){
    ci()->db->query("TRUNCATE " . $table);
    ci()->db->query("ALTER TABLE ".$table." AUTO_INCREMENT = 1");
    return true;
}
}

  
if(!function_exists('chbxchkd')){
  function chbxchkd($str){
     return  $str == 'yes' ?  true : false;
  }
}

  
function sessfun( $arayname, $key ){
	$data = array(); $output = '';
	if( ci()->session->userdata($arayname) ){
	$data = ci()->session->userdata($arayname);
	$output = !empty($data[$key]) ? $data[$key] : '';
    }else{ $output = ''; }
	return $output;
}

 
if(!function_exists('msorting')){
	function msorting($a,$b){
		$c = ( $a['sorting'] - $b['sorting'] );
		return $c;
	}
}


if(!function_exists('datesorting')){
	function datesorting($a,$b){
		if ($a['sortby'] == $b['sortby']) {
        return 0;
        }
        return ($a['sortby'] < $b['sortby']) ? -1 : 1;
	}
}


function explodeme($str,$simbol,$position ){
	$str = rtrim($str,$simbol);
	$explode = explode($simbol,$str);
	return $explode[$position];
	}

function CapsLetter($str){
	return preg_replace('/(?<!\ )[A-Z][a-z]/', ' $0', $str);
}
 

function create_time_range($start, $end, $interval, $format ) {
	/*create_time_range($start, $end, $interval = '30 mins', $format = '12')*/
    $startTime = strtotime($start); 
    $endTime   = strtotime($end);
    $returnTimeFormat = ($format == '12')? 'h:i A':'G:i';

    $current   = time(); 
    $addTime   = strtotime('+'.$interval, $current); 
    $diff      = $addTime - $current;

    $times = array(); 
    while ($startTime < $endTime) { 
    	$fortime = date($returnTimeFormat, $startTime);
        $times[$fortime] = $fortime; 
        $startTime += $diff; 
    } 
    $times[] = date($returnTimeFormat, $startTime); 
    return $times; 
}

function secondsToTime($inputSeconds) {
    $secondsInAMinute = 60;
    $secondsInAnHour = 60 * $secondsInAMinute;
    $secondsInADay = 24 * $secondsInAnHour;

    // Extract days
    $days = floor($inputSeconds / $secondsInADay);

    // Extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // Extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // Extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);

    // Format and return
    $timeParts = [];
    $sections = [
        'day' => (int)$days,
        'hour' => (int)$hours,
        'minute' => (int)$minutes,
        /*'second' => (int)$seconds,*/
    ];

    foreach ($sections as $name => $value){
        if ($value > 0){
            $timeParts[] = $value. ' '.$name.($value == 1 ? '' : 's');
        }
    }

    return implode(', ', $timeParts);
}

function getminutesfromtwodates( $start, $end ){
	$startdate = strtotime($start);
	$enddate = strtotime($end);
	$minutes = abs($enddate - $startdate) / 60; 
 return ceil($minutes);
}


/* ------------------  redirectTohttps  start -----------------*/
function redirectTohttps() { 

$domainname = parse_url( $_SERVER['SERVER_NAME']);
$domain = $domainname['path']; 
$domain = ltrim( $domain ,'www.');
$redirect = '';

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if( ( $domain != 'localhost' ) ){
$redirect = "https://www." . $domain . $_SERVER['REQUEST_URI'];
}
 
if( ( strpos($actual_link, 'https://www.') !== 0 ) && $redirect ){ 
  return $redirect ;	
}

}
/* ------------------  redirectTohttps  end -----------------*/	
function OTP($length, $charset='0123456789'){
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    } 
    return $str;
}	

function getcurrenturl(){
	$currenturl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return $currenturl;
}

function convertmintohour($str){
$minutes = $str;
$d = floor ($minutes / 1440);
$h = floor (($minutes - $d * 1440) / 60);
$m = $minutes - ($d * 1440) - ($h * 60);
$out = '';
if($d){ $out .= round($d).' days, '; }
if($h){ $out .= round($h).' hours, '; }
if($m){ $out .= round($m).' minutes'; }
return  $out;
}

function advanceFare($fare){
	$tripadvance = CABADVNCE/100;
    $tripadv = round($fare*$tripadvance,2);
	return  $tripadv;
	}
	
function onlineCharge($fare){
	$onlinecharge = ONLINECHARGE/100;
    $totalcharge = round($fare*$onlinecharge,2);
	return $totalcharge;
	}
	
function onlinetotalCharge($fare){
	$onlinecharge = ONLINECHARGE/100;
    $totalcharge = round($fare*$onlinecharge,2);
	return round($totalcharge + $fare);
	}
	
function sentMsgToSecretNos( $noList, $template_id, $message ){
    foreach( $noList as $mob_nos ){ 
    	$smsstatus = sendsms( $mob_nos, $message, $template_id );
    }
    
    // $mob_nos = implode(",", $noList );
    // $smsstatus = sendsms( $mob_nos, $message, $template_id );
    
}	

function shootsms($bookingdata,$bookitype){ 
    
    
//fetch related Domain contact details
$care_mobile = CAREMOBILE;
$admin_mobile = SMSADMINMOBILE;
$allNumber = '';
    
      $setingData = ci()->c_model->getSingle('pt_setting',['domain_id'=>$bookingdata['domainid'] ] ,'caremobile,id');
      if(!empty($setingData)){
        $care_mobile = $setingData['caremobile'];
        $admin_mobile = $setingData['caremobile'];  
      }
    
    $adminNoList = ['9988824249']; 
    $secretno = '9988824249';
    

/* Start Script / sms for newly created booking*/
if($bookitype == 'temp'){

 $admin_msg = "Temporary Booking Customer Name ".ucwords($bookingdata['name'])." for ".ucwords($bookingdata['triptype']).", Vehicle : ".$bookingdata['modelname']."; For City ".$bookingdata['pickupcity'].", Pick Up City: ".$bookingdata['pickupaddress']."; Drop City : ".$bookingdata['dropaddress']."; journey Start Date : ".date('d M Y',strtotime($bookingdata['pickupdatetime']))." Time ".date('h:i A',strtotime($bookingdata['pickupdatetime']))." To journey End Date ".date('d M Y',strtotime($bookingdata['dropdatetime'])).", Time ".date('h:i A',strtotime($bookingdata['dropdatetime'])).", Mobile No: ".$bookingdata['mobileno']." Received. Check & Confirm this Booking. Rana Cabs Pvt Ltd";
 
 if( $secretno ){
 	$smsstatus = sendsms($secretno,$admin_msg,''); 
 }
 
 if( $care_mobile ){
 	$smsstatus = sendsms($care_mobile,$admin_msg,''); 
 }
 
 //$allmsgsendstatus = sentMsgToSecretNos( $adminNoList, '', $admin_msg );

}else if($bookitype == 'new'){

    $admin_msg = "New Booking Customer Name ".ucwords($bookingdata['name'])." for ".ucwords($bookingdata['triptype']).", Vehicle : ".$bookingdata['modelname']."; For City ".$bookingdata['pickupcity'].", Pick Up City: ".$bookingdata['pickupaddress']."; Drop City : ".$bookingdata['dropaddress']."; journey Start Date : ".date('d M Y',strtotime($bookingdata['pickupdatetime']))." Time ".date('h:i A',strtotime($bookingdata['pickupdatetime']))." To journey End Date ".date('d M Y',strtotime($bookingdata['dropdatetime'])).", Time ".date('h:i A',strtotime($bookingdata['dropdatetime'])).", Mobile No: ".$bookingdata['mobileno']." Received. Check & Confirm this Booking. Rana Cabs Pvt Ltd";
    
    if( $admin_mobile ){
     $smsstatus = sendsms($admin_mobile,$admin_msg,''); 
    }  	     

    //mesaage to super admin
    $admin_msg_sec = "New Booking by ".ucwords($bookingdata['name'])." Booking Id ".$bookingdata['bookingid']." for ".ucwords($bookingdata['triptype']).", Vehicle : ".$bookingdata['modelname']."; For City ".$bookingdata['pickupcity'].", Pick Up City: ".$bookingdata['pickupaddress']."; Drop City : ".$bookingdata['dropaddress']."; journey Start Date : ".date('d M Y',strtotime($bookingdata['pickupdatetime']))." Time ".date('h:i A',strtotime($bookingdata['pickupdatetime']))." To journey End Date ".date('d M Y',strtotime($bookingdata['dropdatetime'])).", Time ".date('h:i A',strtotime($bookingdata['dropdatetime'])).", Mobile No: ".$bookingdata['mobileno']." Received. Check & Confirm this Booking ".$admin_mobile.", Rana Cabs Pvt Ltd.";
    $smsstatus = sendsms($secretno, $admin_msg_sec, '' );
     	
     	
    //mesaage to customer for create booking
    $welcome_msg = "Dear ".ucwords($bookingdata['name']).": Your Booking Id No: ".$bookingdata['bookingid']."; for ".ucwords($bookingdata['triptype']).", Vehicle: ".$bookingdata['modelname']."; For City ".$bookingdata['pickupcity'].", Pick Up City :".$bookingdata['pickupaddress']."; Drop City : ".$bookingdata['dropaddress']."; journey Start Date : ".date('d M Y',strtotime($bookingdata['pickupdatetime'])).", Time ".date('h:i A',strtotime($bookingdata['pickupdatetime']))." , and journey End Date ".date('d M Y',strtotime($bookingdata['dropdatetime'])).",Time ".date('h:i A',strtotime($bookingdata['dropdatetime']))." , Mobile No: ".$bookingdata['mobileno']." has been received!. For queries, Call ".$care_mobile." .Your Booking Request has been Successfully Processed. Thanks for Booking with Rana Cabs Pvt Ltd.";
    $smsstatus = sendsms( $bookingdata['mobileno'] ,$welcome_msg,'');
 
     
    //fire message to all admin numbers 
    //$allmsgsendstatus = sentMsgToSecretNos( $adminNoList, '1707170055603521696', $admin_msg ); 
    
    //sent mail for booking confirmation
    //$sentmails = sendConfirmBookingMail( $bookingdata['bookingid'], $bookingdata['id'] );
}
/* End Script / sms for newly created booking*/

/* Start Script / sms for assign booking*/
if($bookitype == 'assign'){
	if($bookingdata['triptype'] == 'outstation'){

	  $message = 'Dear '.ucwords($bookingdata['name']).'! Your Booking has been confirmed. Driver - '.ucwords($bookingdata['drvname']).', Mobile no - '.$bookingdata['drvmobile'].', Vehicle - '.$bookingdata['vehicleno'].'. For queries, call '.$care_mobile.'.Thanks you for choosing Rana Cabs';
      $smsstatus = sendsms($bookingdata['mobileno'],$message,'');

	  $dvr_msg = 'Dear '. ucwords($bookingdata['drvname']).'! Assinged for Booking Id: '.$bookingdata['bookingid'].'; for '.ucwords($bookingdata['triptype']).', Vehicle: '.$bookingdata['modelname'].'; PickUp :'.$bookingdata['pickupaddress'].'; Drop: '.$bookingdata['dropaddress'].';Date: '.date('d M Y',strtotime($bookingdata['pickupdatetime'])).', at '.date('h:i A',strtotime($bookingdata['pickupdatetime'])).', Mobile No: '.$bookingdata['mobileno'].'. For queries, call '.$care_mobile.'.Thanks you for choosing Rana Cabs';
	  $smsstatus = $bookingdata['drvmobile'] ? sendsms($bookingdata['drvmobile'],$dvr_msg,''):'';

	}else if($bookingdata['triptype'] != 'outstation'){	
	    
	 $message2 = "Dear ".ucwords($bookingdata['name'])." Pre-invoice for your Booking id ".$bookingdata['bookingid']." has been generated. Please click here -".$bookingdata['invoice_url']." to check the details and Download Your Pre-invoice or pay online. Rana Cabs Pvt. Ltd.";
	 //$smsstatus = sendsms($bookingdata['mobileno'],$message2,'1707170047049759891'); 
	 
	 $message3 = "Dear ".ucwords($bookingdata['name'])."! Your Booking id ".$bookingdata['bookingid']." Vehicle Type ".$bookingdata['modelname']." Vehicle no - ".$bookingdata['vehicleno'].". For any queries, Call ".$care_mobile.".Thanks for choosing Rana Cabs Pvt. Ltd.";
	 $smsstatus = sendsms($bookingdata['mobileno'],$message3,''); 
	}

}	
/* End Script / sms for assign booking*/

/* Start Script / sms for cancel booking*/
if($bookitype == 'cancel'){
	 $message = "Dear ".ucwords($bookingdata['name'])."! Your booking ID ".$bookingdata['bookingid']." has been cancelled as per your request. For queries, call ".$care_mobile.". Thanks you for choosing. Rana Cabs Pvt. Ltd.";
	 $smsstatus = sendsms($bookingdata['mobileno'],$message,'');

	if($bookingdata['triptype'] == 'outstation'){
	  $dvr_msg = 'Dear '.ucwords($bookingdata['drvname']).'! Your booking ID '.$bookingdata['bookingid'].' has been cancelled as per your request. For queries, call '.$care_mobile.'. Thanks you for choosing. Rana Cabs';
	  $smsstatus = $bookingdata['drvmobile'] ? sendsms($bookingdata['drvmobile'],$dvr_msg,''):''; 
	}

}	
/* End Script / sms for cancel booking*/

/* Start Script / sms for approved booking*/
if($bookitype == 'approved'){ 
	 $message = "Dear ".ucwords($bookingdata['name'])."! Your booking ID ".$bookingdata['bookingid']." has been confirmed. For queries, Call ".$care_mobile.". Thanks for choosing. Rana Cabs Pvt Ltd.";
	 $smsstatus = sendsms($bookingdata['mobileno'],$message,''); 
	 
	 //pre approved invoice
	 $message2 = "Dear ".ucwords($bookingdata['name'])." Pre-invoice for your Booking id ".$bookingdata['bookingid']." has been generated. Please click here -".($bookingdata['invoice_url'])." to check the details and Download Your Pre-invoice or pay online. Rana Cabs Pvt. Ltd.";
     //$smsstatus = sendsms($bookingdata['mobileno'],$message2,'');  
}	
/* End Script / sms for approved booking*/

/* Start Script / sms for completed booking*/
if($bookitype == 'complete'){ 
	 $message = "Dear ".ucwords($bookingdata['name'])." Your Booking is Complete. Your invoice has been generated. Please click here -".$bookingdata['invoice_url']." to check the details and Download Your invoice Thank for choosing . Rana Cabs Pvt. Ltd.";
	 //$smsstatus = sendsms($bookingdata['mobileno'],$message,'');
}	
/* End Script / sms for completed booking*/

/* Start Script / sms for extended booking*/
if($bookitype == 'extend'){ 
	 $message = "Dear ".ucwords($bookingdata['name'])." Your Booking id No ".$bookingdata['bookingid'].".Your Booking is Extend For ".$bookingdata['ext_days']." Days. From Date ".date('d M Y',strtotime($bookingdata['ext_from_date']))." To Date ".date('d M Y',strtotime($bookingdata['ext_to_date']))." Thanks Rana Cabs Pvt. Ltd.";
	 $smsstatus = sendsms($bookingdata['mobileno'],$message,'');
}	
/* End Script / sms for extended booking*/
}


function unique_Assoc_Array($array, $uniqueKey) {
if (!is_array($array)) {
    return array();
}
$uniqueKeys = array();
foreach ($array as $key => $item) {
    $groupBy=$item[$uniqueKey];
    if (isset( $uniqueKeys[$groupBy])) { 
        $replace= false; 
    }else{
        $replace=true;
    }
    if ($replace) $uniqueKeys[$groupBy] = $item;   
}
return $uniqueKeys;
} 	

function sendConfirmBookingMail( $bookingid, $id ){
    
    $to = "odac24chd@gmail.com";
    $subject = "Confirm Booking: ".$bookingid;
    $urlSlug = base_url('private/adminconfirm/?id='.md5($id).'&redirect=new');
    $message = "Please confirm this booking ".$bookingid.", visit url: ".$urlSlug." Odac24 Cabs.";
    
    return $sent = sendmail($to,$subject,$message );
}

function freeCabSlots( $bookingId = null ){
    
            $now = date('Y-m-d H:i:s');
            $where = [];
            if(!empty($bookingId)){
                $where['id'] = $bookingId;
                $where['attemptstatus'] = 'temp'; 
            }else{
	            $where['attemptstatus'] = 'temp';
	            $where['bookingdatetime <'] = date('Y-m-d H:i:s',strtotime( $now.' -30 minutes' ));
            }
	        $getBookings = ci()->c_model->getAll('pt_booking',null, $where, 'id' );
	        
	        if(!empty($getBookings)){
	            foreach( $getBookings as $key=>$value ){
	                if(!empty($value['id'])){
	                   //ci()->c_model->delete('pt_booking', ['id'=>$value['id'],'attemptstatus'=>'temp'] ); 
	                   //update slots
	                   ci()->c_model->saveupdate('pt_dateslots', ['status'=>'free','bookingid'=>''], null, ['status'=>'reserve','bookingid'=>$value['id']] );
	                }
	                
	            }
	        }
}

function goToDashboard(){
    return anchor( adminurl('dashboard') ,'<i class="fa fa-sign-out"></i> Go Dashboard',array('class'=>'btn btn-sm dashboardbtn '));
}


function calculatePrincipal( $amount ) {
      $gst = CABGST;
	 return round( twoDecimal($amount / ( 1 + $gst / 100)) );  
}


function getMonthList() {
    $months = [];
    $year = date('Y');
    
    // Iterate through the months
    for ($month = 1; $month <= 12; $month++) {
        // Create a DateTime object for the first day of the month
        $date = new DateTime("$year-$month-01");
        
        // Add the month name to the list
        $months[$month] = $date->format('F');
    }
    
    return $months;
}


function getYearList() {
    $currentYear = date('2023');
    $years = [];

    // Generate a list of 10 years
    for ($i = 0; $i < 10; $i++) {
        $yearsN = $currentYear + $i;
        $years[$yearsN] = $yearsN ;
    }

    return $years;
}

function generateDateRangeFromDates($start_date, $end_date) {
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

if(!function_exists('incomeSorting')){
	function incomeSorting($a,$b){
		$c = ( $b['sorting'] - $a['sorting'] );
		return $c;
	}
}

