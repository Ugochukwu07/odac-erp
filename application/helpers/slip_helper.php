<?php 

/********************** Send mail Function Start **********************************/
function bookingslip($arr,$for){
 $booking = $arr;
 $bookingtripmode = '';
 
 
     $admin_mobile = SMSADMINMOBILE;
     $care_mobile = CAREMOBILE;
     
     $admin_email = ADMINEMAIL;
     $care_email = CAREEMAIL;
     $domain_name = DOMAINNAME;
     $head_office = HEADOFFICE;
 
     if(!empty($booking['domainid'])){
         $settingData = ci()->c_model->getSingle('pt_setting',['domain_id'=>$booking['domainid'] ] ,'personalmobile,caremobile,careemail,personalemail,headoffice');
          if(!empty($settingData)){ 
                $admin_mobile = $settingData['personalmobile'];
                $care_mobile = $settingData['caremobile'];
                
                $admin_email = $settingData['personalemail'];
                $care_email = $settingData['careemail'];
                $head_office = $settingData['headoffice'];
          }
          
          $domainData = ci()->c_model->getSingle('pt_domain',['id'=>$booking['domainid'] ] ,'id,domain');
          if(!empty($domainData)){ 
                $domain_name = $domainData['domain']; 
          }
     }
     
    
    $vehicleNo =  $booking['driverstatus'] == 'accept' ? $booking['modelname'].', '.$booking['vehicleno'] :''; 

//echo '<pre>';
 //print_r( $booking);

if($booking['routes']!='0'){$viaroute = $booking['routes'];}

 $string = '<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,400,400i,700,700i,800,800i,900,900i&display=swap">
</head>

<body>';

 $string.='<table width="805" border="1" cellpadding="0" cellspacing="0" style="font-family: MelbourneRegular, Melbourne, Myriad Pro, Arial, Verdana, Helvetica sans-serif; font-size:15px; border:7px ridge #ccc;">
  <tr>
    <td colspan="4" style="border:0px solid red">


    <div style="width:100%;">
     <table width="100%" border="0" cellpadding="10" cellspacing="0" >
      <tr>
        <td width="30%"> <img src="'.DEFAULT_LOGO.'" style="width: 180px;height: auto;margin-top:1px;"/> </td>
        <td width="40%" style="text-align:center;">
        <p><center>ISO 9001:2008 Quality certified Travel Company</center></p> 
        </td>
        <td width="40%" style="text-align:right; padding-right:10px"> 
        <p><img src="'.PEADEX.'/assets/images/marker.png" width="20px"> '.$head_office.'<br/>
      <img src="'.PEADEX.'/assets/images/whatsup.png" width="20px"> '.$care_mobile.'<br/>
      <img src="'.PEADEX.'/assets/images/emaillogo.png" width="20px"> '.$care_email.'</p> </td>
      </tr>
    </table>
    </div> 




    
    <div style="width:100%; color:#000000; margin:10px 0px 0px 0px; clear:both; text-align:center; font-weight:300">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" >
        <tr>
        <td colspan="2" style="background:#2E3192; text-align:center;">
<div style="width:100%; max-width:100%; float:left;  color:#ffffff;   letter-spacing:2px;  font-weight:bold">
     &nbsp;</div>
        </td>
        </tr>

      <tr>
        <td width="50%"> <p>
            &nbsp; Name: '.ucwords($booking['name']).' <br/>
            &nbsp; E-mail : '.strtolower($booking['email']).' <br/>
            &nbsp; Mobile No: '.$booking['mobileno'].' <br/>
            &nbsp; Vehicle Type: '.$vehicleNo.' 
            </p>
        </td>
         <td> <p>
              &nbsp; Booking No : '.$booking['bookingid'].' <br/>
              &nbsp; Booking Date : '.date('d-M-Y h:i A',strtotime($booking['bookingdatetime'])).' <br/>
              &nbsp; Journey Start On: '.date('d-M-Y h:i A',strtotime($booking['pickupdatetime'])).' <br/>
              &nbsp; Journey End On : '.date('d-M-Y',strtotime($booking['dropdatetime'])).' <br/>
              &nbsp; Booking Type: '.ucfirst($booking['triptype']).' 
            </p>
        </td>
      </tr>
    </table>
     </div>
    </td>
  </tr>





  <tr>
    <td colspan="4" style="border:0px solid red">


    <div style="width:100%; font-size:12px">
     <table width="100%" border="1" cellpadding="10" cellspacing="0" >
      <tr>
        <th width="">Sr</th>
        <th width="">Vehicle</th>
        <th width="">Unit</th>
        <th width="">Durations</th>
        <th width="">Rent/(KM*INR)</th>
        <th width="">Total</th>
      </tr>';

if(in_array($booking['triptype'], ['selfdrive','bike','monthly'])){
    
    $perUnitPrice = 0;
    // if( $booking['vehicle_price_per_unit'] > 0 ){
    //   $perUnitPrice = $booking['vehicle_price_per_unit']; 
    // }else {
      // $perUnitPrice = twodecimal( ( $booking['grosstotal'] / $booking['driverdays'] ) - ( $booking['totalgstcharge'] / $booking['driverdays'] ) ); 
    
    //}


   
   if( strtotime( date('Y-m-d',strtotime($booking['bookingdatetime'])) ) >=  strtotime('2023-11-22') && !empty($booking['vehicle_price_per_unit'])){
       $totalBaseFare = $booking['vehicle_price_per_unit'] * $booking['driverdays'];  
       $perUnitPrice = $booking['vehicle_price_per_unit'];
   }
   else if( strtotime( date('Y-m-d',strtotime($booking['bookingdatetime'])) ) <  strtotime('2023-11-13')){
       $totalBaseFare = $booking['basefare'] * $booking['driverdays'];  
       $perUnitPrice = $booking['basefare'];
   }else{
       $totalBaseFare = $booking['grosstotal'];
       $perUnitPrice = twodecimal( ( $booking['grosstotal'] / $booking['driverdays'] ));
   }
   
   
   
    $string .= '<tr>
        <td>1</td>
        <td>'.$booking['modelname'].'</td>
        <td>1</td>
        <td>'.$booking['driverdays'].' Days</td>
        <td>'.$perUnitPrice.'</td>
        <td>'.twodecimal($totalBaseFare) .'</td>
      </tr>';

  }


  if(in_array($booking['triptype'], ['outstation'])){

    $string .= '<tr>
        <td>1</td>
        <td>'.$booking['modelname'].'</td>
        <td>1</td>
        <td>'.$booking['driverdays'].' Days</td>
        <td>'.$booking['totalkm'].' * '.$booking['fareperkm'].' </td>
        <td>'.twodecimal($booking['totalkm']*$booking['fareperkm']) .'</td>
      </tr>';

  }


if( strtotime( date('Y-m-d',strtotime($booking['bookingdatetime'])) ) >= strtotime('2023-11-22') ){
    $string.='
       <tr>
        <td>&nbsp;</td>
        <td>Sub-Total</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>'.$booking['gstapplyon'].'</td>
        <td>&nbsp;</td>
      </tr>';
      
      
      $string.='
       <tr>
        <td>&nbsp;</td>
        <td>GST '.($booking['gstpercent']).'%  </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>'.twodecimal($booking['totalgstcharge']).'</td>
        <td>&nbsp;</td> 
      </tr>';
      
       $string.=' <tr>
        <td>2</td>
        <td>Total</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>'.$booking['grosstotal'].'</td>
        <td>'.$booking['grosstotal'].'</td>
      </tr>
      ';
    
        if(!empty($booking['offerprice']) && $booking['offerprice'] > 0){
         $string.=' <tr>
            <td>&nbsp;</td>
            <td>Discount</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>  -'.$booking['offerprice'].'</td>
          </tr>';
        }
    
        if(!empty($booking['bookingamount']) && $booking['bookingamount'] > 0 ){
         $string.=' <tr>
            <td>3</td>
            <td>Advance Booking Amount</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td> -'.$booking['bookingamount'].'</td>
          </tr>';
        }
    
    
        if(!empty($booking['restamount'])){
         $string.=' <tr>
            <td>4</td>
            <td>Balance Amount</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>'.$booking['restamount'].'</td>
          </tr>';
        }
    


}else {
    $string.=' <tr>
        <td>&nbsp;</td>
        <td>Subtotal</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>'.$booking['estimatedfare'].'</td>
      </tr>

       <tr>
        <td>&nbsp;</td>
        <td>GST '.($booking['gstpercent']).'% ( Included )</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>'.twodecimal($booking['totalgstcharge']).'</td>
      </tr>';
      
       $string.=' <tr>
        <td>2</td>
        <td>Total</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td> '.$booking['grosstotal'].' </td>
        <td>'.$booking['grosstotal'].'</td>
      </tr>
      ';

        if(!empty($booking['offerprice']) && $booking['offerprice'] > 0){
         $string.=' <tr>
            <td>&nbsp;</td>
            <td>Discount</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>  -'.$booking['offerprice'].'</td>
            <td>  -'.$booking['offerprice'].'</td>
          </tr>';
        }
    
        if(!empty($booking['bookingamount']) && $booking['bookingamount'] > 0 ){
         $string.=' <tr>
            <td>3</td>
            <td>Advance Booking Amount</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>  -'.$booking['bookingamount'].' </td>
            <td> -'.$booking['bookingamount'].'</td>
          </tr>';
        }
    
    
        if(!empty($booking['restamount'])){
         $string.=' <tr>
            <td>4</td>
            <td>Balance Amount</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>'.$booking['restamount'].'</td>
            <td>'.$booking['restamount'].'</td>
          </tr>';
        }
    

}
      
      

     



$string.='



    </table>
    </div> 
  </td>
  </tr>





   
  <tr>
    <td colspan="1" width="150px" style="font-size:15px; font-weight:600">&nbsp; Booking Status :</td>
	  <td colspan="3" >&nbsp; '.paymode($booking['bookingamount']).' & '.ucfirst(bookConfirmed($booking['attemptstatus'])).'</td>
  </tr>';
  if(!empty($booking['routes'])){
    $routes_arra = json_decode($booking['routes'],true);
    $routes = '';
  	foreach ($routes_arra as $key=>$uvalue) {
  	 $routes .= $uvalue['via'].'->';
  	}
  $string.='<tr>
    <td colspan="1" >&nbsp; Route </td>
    <td colspan="3" >&nbsp; '.rtrim($routes,'->').'</td>
  </tr>';
  }else{
$string.='<tr>
    <td colspan="1">&nbsp; Via Route </td>
    <td colspan="3">&nbsp; '.$booking['pickupaddress'].' To '.($booking['dropcity']?$booking['dropcity']:$booking['pickupaddress']).'</td>
  </tr>';
    }
  
  
  
   $string.='
  <tr style="text-align:left !important">
    <td colspan="4" style="">
     <div style="width:100%; color:#000000; margin:10px 0px 0px 0px; clear:both; text-align:center; font-weight:300">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" > 

      <tr><td> ';
      
      $string.=' <p> <br/> &nbsp;<b>Terms and Conditions :-</b><br/> ';
      $i = 1;
	  $termslist = gettermsslip($booking['triptype']);  
	 foreach ($termslist as $key => $tvalue) {  
              	$string .= '<span style="font-size:13px;">&nbsp; '.$i.'). '.$tvalue['content'].'</span><br/>';
              	$i++;}
     $string.='   </p>';
    $string.='</td>
      </tr>
     </table>
    </div>
    ';  
	    
	 
     $string.='<br/>
     
	 <span style="clear:both; font-size:13px">
	 
     <span style="clear:both; font-size:13px; font-weight:900;">&nbsp;<center> 1.	Registration No.: '.REGISTRATIONNO.', &nbsp; GST No.: '.GSTIN.', &nbsp; PAN No.:   </center></span><br/>';
	 
     $string.='<span><br/></span>
     </div>
    </td>
  </tr> 

  <tr>
  <td colspan="4" style="padding:10px "> 
    Dear '.$booking['name'].',your booking ID is '.$booking['bookingid'].' .Request has been Successfully Processed. Thank You for Booking with '.COMPANYNAME.'. 
    </td>
  </tr>
</table>';

$string .= '<br> <br> <br>   
<div style="clear: both; margin-bottom: 20px">&nbsp;</div>

</div></body></html>'; 


 //echo $string;
 
 $to = $booking['email'];
 $subject = FMAILER; 
 if($for=='adminmail'){  
      $to = "odac24chd@gmail.com";
      return $mailstatus = sendmail($to,$subject,$string );
 }
 else if($for=='mail' && ($to != 'abc@gmail.com') ){  
  return $mailstatus = sendmail($to,$subject,$string );
 }
 
 if($for=='print'){return $string;}

    
}

/********************** Send mail Function end **********************************/


function gettermsslip( $triptype ){
  $table = 'pt_booking_terms';
  $keys = 'content';
  $orderby = 'content ASC';
  $where['datacategory'] = $triptype;
  $where['status'] = 'yes';
  $where['contenttype'] = 'terms';

$data = ci()->c_model->getAll( $table, $orderby, $where ,$keys);
return !empty($data) ?  $data : [];
}


function paymode($bookingamount = false){
  if($bookingamount > 0 ){ $status = 'Paid';}
  else{ $status = 'Unpaid';} 
  return $status;
  }
   
  
function bookConfirmed($status = false){
  if($status == 'new'){ $status = 'Unconfirmed';}
  else if($status == 'cancel'){ $status = 'Cancelled';}
  else { $status = 'Confirmed';}
  return $status;
  }


 

?>