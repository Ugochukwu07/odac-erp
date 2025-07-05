<div class="form_block bg_w shadoww"><?php  $captuaCode = OTP(3);?>
<div class="title ttitliumweb">
Query Now, <?php echo SMSADMINMOBILE;?>
</div>
<form id="book nowingForm" action="<?php echo PEADEX;?>send-sms.php" class="paddingform" method="post">
<input type="hidden"  name="captua1" value="<?php echo $captuaCode;?>" />
<em></em>
<div class="controlHolder" style="margin-top:5px"><div class="tmInput">
<input name="name" placeholder="" type="text" value="Name..." onFocus="if(this.value=='Name...')this.value='';" onBlur="if(this.value=='')this.value='Name...';">
</div></div>

<div class="controlHolder"><div class="tmInput">
<input name="email" placeholder="" type="text" value="Email..." onFocus="if(this.value=='Email...')this.value='';" onBlur="if(this.value=='')this.value='Email...';">
</div></div>

<div class="controlHolder"><div class="tmInput">
<input name="mobileno" placeholder="" type="text" value="Contact..." onFocus="if(this.value=='Contact...')this.value='';" onBlur="if(this.value=='')this.value='Contact...';">
</div></div>

<div class="controlHolder"><div class="tmInput">
<textarea name="Query"  style="color:#111; padding:2px 10px"  onFocus="if(this.value=='Message here...')this.value='';" onBlur="if(this.value=='')this.value='Message here...';" placeholder="Message here..." >
</textarea>
</div></div>

<div class="controlHolder"><div class="tmInput">
<input name="captua2" placeholder="Enter The Code <?php echo $captuaCode;?>" type="text" value="" >
</div></div>
<div class="clear"></div>
<div class="">
<input type="submit" class="vehiclebutton" name="sendmail" value="Submit"></div>

</form>
<div class="clear"></div>
</div>