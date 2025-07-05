<?php

/********************** Send mail For Query request **********************************/
function queryRequest($data,$for){
    
     $admin_mobile = SMSADMINMOBILE;
     $care_mobile = CAREMOBILE;
     
     $admin_email = ADMINEMAIL;
     $care_email = CAREEMAIL;
     $domain_name = DOMAINNAME;
     $officeCity = 'Chandigarh';
 
     if(!empty($data['domainid'])){
         $settingData = ci()->c_model->getSingle('pt_setting',['domain_id'=>$data['domainid'] ] ,'personalmobile,caremobile,careemail,personalemail');
          if(!empty($settingData)){ 
                $admin_mobile = $settingData['personalmobile'];
                $care_mobile = $settingData['caremobile'];
                
                $admin_email = $settingData['personalemail'];
                $care_email = $settingData['careemail'];
          }
          
          $domainData = ci()->c_model->getSingle('pt_domain',['id'=>$data['domainid'] ] ,'id,domain');
          if(!empty($domainData)){ 
                $domain_name = $domainData['domain']; 
          }
     }
 

	$string = null;
 
 $string.='<table width="758" border="1" cellpadding="0" cellspacing="0" style="font-family: MelbourneRegular, Melbourne, Myriad Pro, Arial, Verdana, Helvetica sans-serif; font-size:15px; border:7px ridge #ccc;">
  <tr>
    <td colspan="4">
    <div style="width:210px; float:left;">&nbsp;<img src="'.DEFAULT_LOGO.'" style="width: 190px;height: 91px;margin-top: 17px;"/></div>
    <div style="margin-top:10px; width:525px; float:left; text-align: right">&nbsp;
    <span>SCO. 98, 1st Floor Sector 47-C<br/>Chandigarh 160047(INDIA)<br/></span>
    <span>'.$admin_mobile.'<br/></span>
    <span>'.$care_email.'<br/></span>
    <span><span style="float:left">ISO 9001:2008 Quality certified Travel Company</span>'.$domain_name.'</span>
    </div>
    <div style="width:100%;  background:#2E3192; color:#ffffff;clear:both; letter-spacing:2px; text-align:center; font-weight:600">
    | &nbsp; |</div>
    
    <div style="width:100%; border-top:1px solid #111; float:left; font-size:18px">&nbsp; <br/> </div>
    </td>
  </tr>
  
 
  <tr>
    <td colspan="2">&nbsp;<span style="font-size:15px; font-weight:600"> Date :</span></td>
	 <td colspan="2">&nbsp; <span style="font-size:18px"> '.dateFormat($data['requesttime'],'d M Y h:i A').'</span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600"> Customer Name :  </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">'.capitalize($data['name']).'</span></td>
  </tr>
   <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Customer Mobile : </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600"> '.$data['mobile'].'</span></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Customer Email :   </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">'.$data['emailid'].'</span></td>
  </tr>

  <tr>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">Query For : </span></td>
    <td colspan="2">&nbsp; <span style="font-size:15px; font-weight:600">'.$data['comment'].'</span></td>
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
 
 

 /*send to admin sms format */
     //$msgadmin = 'New Query By '.$data['name'].',Email: '.$data['emailid'].', Mobile no.: '.$data['mobile'].', Query: '.$data['comment'].' Rana Cabs Pvt. Ltd.';
     $msgadmin =  "New Query By ".$data['name'].",Email: ".$data['emailid'].", Mobile no.: ".$data['mobile'].", Service Type Query Citi ".$officeCity." Query Details : ".$data['comment']." Received Check & Confirm this Query. ".COMPANYNAME ;

/*send to client sms format */
     //$msgclient ='Thanks For Visiting Rana Cabs Website. Our Relationship Manager +91'.$admin_mobile.' Will Contact You Soon. Rana Cabs';
     $msgclient ="Dear ".capitalize($data['name'])." Your Query has been generated. Our Relationship Manager Mobile Number:+91".$admin_mobile." Will Contact You Soon. Thanks for Choosing. ".COMPANYNAME.".";

 
 $to = $data['emailid'];
 $subject = 'Query Slip for '.date('d M Y'); 
 if($for == 'both'){ 
	$mail = sendmail($to,$subject,$string); 
	$sensmsd =  sendsms($admin_mobile,$msgadmin,'1707170056017413637'); 
//	$sensmsd =  sendsms('9988824249',$msgadmin,'1707170056017413637'); 
	$sensmsd =  sendsms($data['mobile'],$msgclient,'1707170055089807892');
	return true;
}else if($for == 'sms'){
	$sensmsd =  sendsms($admin_mobile,$msgadmin,'1707170056017413637');  
	$sensmsd =  sendsms('9988824249',$msgadmin,'1707170056017413637');  
	$sensmsd =  sendsms($data['mobile'],$msgclient,'1707170055089807892');
	return true;
}else if($for=='print'){return $string;}

}

/********************** Send mail For Query end **********************************/
?>