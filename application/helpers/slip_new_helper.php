<?php 

/********************** Send mail Function Start **********************************/
function bookingslipnew($arr,$for){
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
    
    $getAllFareChart = ci()->c_model->getAll('pt_booking_amount',null, ['booking_id'=>$booking['id'] ] );
    
    $getAllDeposits = ci()->c_model->getAll('pt_payment_log',null, ['booking_id'=>$booking['id'] ] );
    
    $allCreditDebitREcords = [];
    //prepare Credit/Extended Records 
    
    if(!empty($getAllFareChart)){
        foreach( $getAllFareChart as $key=>$pvalue ){
            $push = [];
            $push['per_vehicle_price'] = $pvalue['per_vehicle_price'];
            $push['total_days'] = $pvalue['total_days'];
            $push['total_amount'] = $pvalue['total_amount'];
            $push['booking_amount'] = $pvalue['booking_amount'];
            $push['rest_amount'] = $pvalue['rest_amount'];
            $push['from_date'] = $pvalue['from_date'];
            $push['to_date'] = $pvalue['to_date'];
            $push['add_date'] = $pvalue['add_date'];
            $push['pay_type'] = $pvalue['pay_type'];
            $push['credit_debit'] = 'credit';
            $push['sortby'] = strtotime($pvalue['add_date']);
            array_push( $allCreditDebitREcords, $push );
        }
    }
    
    //Prepare Debit Records 
    if(!empty($getAllDeposits)){
        foreach( $getAllDeposits as $key=>$pvalue ){
            $push = [];
            $push['per_vehicle_price'] = '';
            $push['total_days'] = '';
            $push['total_amount'] = '';
            $push['booking_amount'] = $pvalue['amount'];
            $push['rest_amount'] = '';
            $push['from_date'] = '';
            $push['to_date'] = '';
            $push['add_date'] =  $pvalue['added_on'];
            $push['pay_type'] = $pvalue['paymode'];
            $push['sortby'] = strtotime($pvalue['added_on']);
            $push['credit_debit'] = $pvalue['paymode']== 'refund' ? $pvalue['paymode'] : 'debit';
            array_push( $allCreditDebitREcords, $push );
        }
    }


usort( $allCreditDebitREcords , 'datesorting');
// echo '<pre>';
// print_r( $allCreditDebitREcords); 
//  print_r( $getAllFareChart);  
//   print_r( $getAllDeposits); 
// exit;

if($booking['routes']!='0'){$viaroute = $booking['routes'];}

 $string = '<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
 
 
</head>

<body style="font-family: serif; font-size: 10pt;">';

 $string.='<table width="805" border="1" cellpadding="0" cellspacing="0" style="font-family: MelbourneRegular, Melbourne, Myriad Pro, Arial, Verdana, Helvetica sans-serif; font-size:15px; border:7px ridge #ccc;">
  <tr>
    <td colspan="4" style="border:0px solid red">


    <div style="width:100%;">
     <table width="100%" border="0" cellpadding="10" cellspacing="0" >
      <tr>
        <td width="30%"> <img src="'.LOGO.'" style="width: 180px;height: auto;margin-top:1px;"/> </td>
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
                    
                </div>
            </td>
            </tr>
        </table>
    </div> 
</td>
</tr>


<tr>
    <td colspan="4" style="border:0px solid red">
        <div style="width:100%; ">
        <table width="100%" border="0" cellpadding="5" cellspacing="0" >
            <tr>
            <td width="50%" style=" text-align:left; margin-top:50px">
            <br/> 
                <div style="width:100%; color:#000000; text-align:left; font-weight:600; border-bottom: 1px dashed #000000">
                <span>CUSTOMER DETAILS</span>
                </div>   
 
                    <table width="100%">
                        <tr>
                            <td width="50%">Name:</td>
                            <td width="50%">'.ucwords($booking['name']).'</td> 
                        </tr>
                        <tr>
                            <td>E-mail:</td>
                            <td>'.strtolower($booking['email']).'</td> 
                        </tr>
                        <tr>
                            <td>Mobile No:</td>
                            <td>'.$booking['mobileno'].'</td> 
                        </tr>
                    </table>
            </td>
            <td width="50%" style="text-align:left;">
                <div style="width:100%; color:#000000; text-align:left; font-weight:600; border-bottom: 1px dashed #000000">
                    <span>BOOKING DETAILS</span>
                    </div>   
                 
                    <table>
                        <tr>
                            <td>Booking No:</td>
                            <td>'.$booking['bookingid'].'</td> 
                        </tr>
                        <tr>
                            <td>Booking Date:</td>
                            <td>'.date('d-M-Y h:i A',strtotime($booking['bookingdatetime'])).'</td> 
                        </tr>
                        
                        <tr>
                            <td>Booking Type:</td>
                            <td>'.ucfirst($booking['triptype']).'</td> 
                        </tr> 
                        
                    </table> 
                     <br/> 
            </td>
            </tr>
        </table>
    </div> 
</td>
</tr>




<tr>
    <td colspan="4" style="border:0px solid red">
        <div style="width:100%;">
        <table width="100%" border="0" cellpadding="5" cellspacing="0" >
            <tr>
            <td width="50%" style=" text-align:left;">
                <div style="width:100%; color:#000000; text-align:left; font-weight:600; border-bottom: 1px dashed #000000">
                <span>ASSET DETAILS &nbsp; &nbsp; &nbsp;</span>
                </div>   
 
                <table>
                    <tr>
                        <td>Vehicle No:</td>
                        <td>'.$booking['vehicleno'].'</td>
                    </tr>
                    <tr>
                        <td>Model:</td>
                        <td>'.$booking['modelname'].'</td>
                    </tr> 
                </table>
            </td>
            <td style="text-align:left;">
                <div style="width:100%; color:#000000; text-align:left; font-weight:600; border-bottom: 1px dashed #000000">
                    <span>&nbsp;</span>
                    </div>   
                 
                    <table>
                    <tr>
                    <td>Asset Type:</td>
                    <td>Passenger Commercial </td>
                    </tr>
                    <tr>
                    <td>Manufacturing Year:</td>
                    <td>2024</td>
                    </tr> 
                    </table>
                   
            </td>
            </tr>
        </table>
         <br/><br/><br/>
    </div> 
</td>
</tr>

 
 

<tr>
    <td colspan="4" style="border-bottom: 1px dashed #000000; border-top: 1px dashed #000000">
        <div style="width:100%; color:#000000; clear:both; font-weight:300; margin-top:20px">
            <table width="100%" border="0" cellpadding="5" cellspacing="5" >
                <tr>
                    <td width="50%" style="text-align:center;">
                    <div style="width:100%; color:#000000;">
                        <span>BILLED TRANSACTIONS</span>
                    </div> 
                    </td>
                </tr>
            </table>
        </div> 
 </td>
</tr>  


 <tr>
    <td colspan="4" style="border:0px solid red"> 

            <div style="width:100%; font-size:12px">
                   
                 <table width="100%" border="0" cellpadding="10" cellspacing="0" >
                	<tbody>
                		<tr> 
                			<td colspan="2" style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Date</td>
                			<td colspan="3" style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Particulars    </td>
                			<td rowspan="2" style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Rent</td>
                			<td rowspan="2" style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Receipt</td>
                			<td rowspan="2" style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Arrears</td>
                		</tr>
                		<tr>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">From date</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">To date</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Transaction</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Cheque No/Date</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Description</td>
                		</tr>';
                		
                	
                	
                       $perUnitPrice = 0;
                        
                       
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
                       
                       $discountAmount = (int)$booking['offerprice'];
   
   
                    if(!empty($allCreditDebitREcords)){
                        foreach( $allCreditDebitREcords as $key=>$frvalue ){
                             
                            if( $frvalue['credit_debit'] == 'credit' ){ 
                		    
              
                		    $string .= '<tr>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">'.date('d/m/Y',strtotime($frvalue['from_date'])).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">'.date('d/m/Y',strtotime($frvalue['to_date'])).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">'.($key==0?'Sale':'Extend').'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right">'.(int)( $frvalue['total_days'] ).' x '.twoDecimal( $frvalue['per_vehicle_price'] ).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right">'.twoDecimal( $frvalue['total_days']*$frvalue['per_vehicle_price'] ).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">'.twoDecimal( (($frvalue['total_days']*$frvalue['per_vehicle_price']) - $discountAmount) ).'</td>
                		    </tr>';
                            }
                            
                            
                            if($discountAmount > 0 && $key == 0 ){
                            $string .= '<tr>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Discount</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right">- '.twoDecimal( $discountAmount ).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                		    </tr>';
                            }
                            
                            if( $frvalue['credit_debit'] == 'debit' ){
                            
                            $string .= '<tr>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Received</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">'.date('d/m/Y',strtotime($frvalue['add_date'])).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right">'.twoDecimal( $frvalue['booking_amount'] ).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                		    </tr>';
                            }
                            
                            if( $frvalue['credit_debit'] == 'refund' ){
                            
                            $string .= '<tr>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Refund</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">'.date('d/m/Y',strtotime($frvalue['add_date'])).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right"></td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000; text-align:right">- '.twoDecimal( $frvalue['booking_amount'] ).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;"></td>
                		    </tr>';
                            }
                            
                        }
                        
                    } 
                		
                		
                		$string .= '<tr>
                			<td colspan="5" style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">Total</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;  text-align:right">'.twoDecimal($booking['totalamount']).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">'.twoDecimal($booking['bookingamount']).'</td>
                			<td style="border-bottom: 1px dashed #000000; border-right: 1px dashed #000000;">'.twoDecimal($booking['restamount']).'</td>
                		</tr>
                	</tbody>
                </table> 


            </div>
      </td>
</tr>';
      

 



$string.='  


<tr>
    <td colspan="4" style="border-bottom: 1px dashed #000000; ">
        <div style="width:100%; color:#000000; clear:both; font-weight:300; margin-top:20px">
            <table width="100%" border="0" cellpadding="5" cellspacing="5" >
                <tr>
                    <td width="50%" style="text-align:center;">
                    <div style="width:100%; color:#000000;">
                        <span&nbsp;span>
                    </div> 
                    </td>
                </tr>
            </table>
            
        </div> 
 </td>
</tr>  



   
  <tr>
    <td colspan="1" width="150px" style="font-size:15px; font-weight:600"><br/>&nbsp; Booking Status :</td>
	  <td colspan="3" ><br/><br/>&nbsp; '.paymode($booking['bookingamount']).' & '.ucfirst(bookConfirmed($booking['attemptstatus'])).'</td>
  </tr>';
  if(!empty($booking['routes'])){
    $routes_arra = json_decode($booking['routes'],true);
    $routes = '';
  	foreach ($routes_arra as $key=>$uvalue) {
  	 $routes .= $uvalue['via'].'->';
  	}
  $string.='<tr>
    <td colspan="1" ><br/>&nbsp; Route </td>
    <td colspan="3" ><br/>&nbsp; '.rtrim($routes,'->').'</td>
  </tr>';
  }else{
$string.='<tr>
    <td colspan="1"><br/>&nbsp; Via Route </td>
    <td colspan="3"><br/>&nbsp; '.$booking['pickupaddress'].' To '.($booking['dropcity']?$booking['dropcity']:$booking['pickupaddress']).'</td>
  </tr>';
    }
  
  
  
   $string.='
  <tr style="text-align:left !important">
    <td colspan="4" style="">
     
    ';  
	    
	 
     //$string.='<br/>
     
	 //<span style="clear:both; font-size:13px">
	 
    // <span style="clear:both; font-size:13px; font-weight:900;">&nbsp;<center> 1.	Registration No.: '.REGISTRATIONNO.', &nbsp; GST No.: '.GSTIN.', &nbsp; PAN No.:   </center></span><br/>';
	 
     $string.='<span><br/></span>
     </div>
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
      //return $mailstatus = sendmail($to,$subject,$string );
 }
 else if($for=='mail' && ($to != 'abc@gmail.com') ){  
     //return $mailstatus = sendmail($to,$subject,$string );
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