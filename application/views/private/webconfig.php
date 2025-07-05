<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
 
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <!--<h3 class="box-title"></h3>-->
               </div>
    
           
           
            <!-- /.box-header -->
            <div class="box-body">
            <?php echo form_open_multipart( adminurl( 'Webconfig' )); ?> 
            <?php echo form_hidden('id', $id);?>  
            <?php echo form_hidden('oldimage', $oldimage);?>
            <?php echo form_hidden('status', $status);?>    
            
            
<div class="row">
<div class="col-md-12"> 



<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Landline', 'landline');?>
<?php echo form_input(array('name'=>'landline','class'=>'form-control numbersOnly','placeholder'=>'landline....'),set_value('landline',$landline));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Care mobile', 'caremobile');?>
<?php echo form_input(array('name'=>'caremobile','class'=>'form-control','placeholder'=>'caremobile....'),set_value('caremobile',$caremobile));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Company mobile', 'personalmobile');?>
<?php echo form_input(array('name'=>'personalmobile','class'=>'form-control numbersOnly','placeholder'=>'company mobile....'),set_value('personalmobile',$personalmobile));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Care email', 'careemail');?>
<?php echo form_input(array('type'=>'email','name'=>'careemail','class'=>'form-control emailOnly','placeholder'=>'careemail....'),set_value('careemail',$careemail));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Company email', 'personalemail');?>
<?php echo form_input(array('type'=>'email','name'=>'personalemail','class'=>'form-control emailOnly','placeholder'=>'company email....'),set_value('personalemail',$personalemail));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Whatsup no', 'whatsupno');?>
<?php echo form_input(array('name'=>'whatsupno','class'=>'form-control numbersOnly','placeholder'=>'whatsup no....','maxlength'=>10),set_value('whatsupno',$whatsupno));?> 
</div>
</div>


<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('GST Percentage', 'gst');?>
<?php echo form_input(array('name'=>'gst','class'=>'form-control','placeholder'=>'gst....','maxlength'=>5),set_value('gst',$gst));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('GSTIN no', 'gstinno');?>
<?php echo form_input(array('name'=>'gstinno','class'=>'form-control','placeholder'=>'gstinno....'),set_value('gstinno',$gstinno));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Online charge Percentage', 'onlinecharge');?>
<?php echo form_input(array('name'=>'onlinecharge','class'=>'form-control','placeholder'=>'onlinecharge....','maxlength'=>5),set_value('onlinecharge',$onlinecharge));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Advance Booking Amount Percentage', 'advance');?>
<?php echo form_input(array('name'=>'advance','class'=>'form-control','placeholder'=>'advance....'),set_value('advance',$advance));?> 
</div>
</div>

 

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Pan no', 'pan_no');?>
<?php echo form_input(array('name'=>'pan_no','class'=>'form-control','placeholder'=>'pan_no....','maxlength'=>10 ),set_value('pan_no',$pan_no));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Propwriter', 'propwriter');?>
<?php echo form_input(array('name'=>'propwriter','class'=>'form-control','placeholder'=>'propwriter....'),set_value('propwriter',$propwriter));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Registration_no', 'registration_no');?>
<?php echo form_input(array('name'=>'registration_no','class'=>'form-control','placeholder'=>'registration_no....'),set_value('registration_no',$registration_no));?> 
</div>
</div>



<div class="row">
<div class="col-md-12 form-group">
<?php echo form_label('Company name', 'companyname');?>
<?php echo form_input(array('name'=>'companyname','class'=>'form-control alphanimericOnly','placeholder'=>'companyname....'),set_value('companyname',$companyname));?> 
</div>
</div>



<div class="row">
<div class="col-md-12 form-group"> 
<?php echo form_label('Head office (Corporate Office):', 'headoffice');?>
<?php echo form_textarea(array('name'=>'headoffice','class'=>'form-control address','placeholder'=>'headoffice....','rows'=>2),set_value('headoffice',$headoffice));?>
</div>
</div>

<div class="row">
<div class="col-md-12 form-group"> 
<?php echo form_label('Branch office (Registered Office):', 'branchoffice');?>
<?php echo form_textarea(array('name'=>'branchoffice','class'=>'form-control address','placeholder'=>'branchoffice....','rows'=>2),set_value('branchoffice',$branchoffice));?>
</div>
</div>

<div class="row">
<div class="col-md-12 form-group"> 
<?php echo form_label('Google Map Embeded Code :', 'mapscript');?>
<?php echo form_textarea( array('name'=>'mapscript','class'=>'form-control','rows'=>'2') , $mapscript  ); ?>
</div>
</div>


<div class="row">
<div class="col-md-12 form-group"> 
<?php echo form_label('Facebook :', 'facebook');?>
<?php echo form_textarea(array('name'=>'facebook','class'=>'form-control','placeholder'=>'facebook....','rows'=>2),set_value('facebook',$facebook));?>
</div>
</div>

<div class="row">
<div class="col-md-12 form-group"> 
<?php echo form_label('Twitter :', 'twitter');?>
<?php echo form_textarea(array('name'=>'twitter','class'=>'form-control','placeholder'=>'twitter....','rows'=>2),set_value('twitter',$twitter));?>
</div>
</div>

<div class="row">
<div class="col-md-12 form-group"> 
<?php echo form_label('Linkedin :', 'linkedin');?>
<?php echo form_textarea(array('name'=>'linkedin','class'=>'form-control','placeholder'=>'linkedin....','rows'=>2),set_value('linkedin',$linkedin));?>
</div>
</div>

<div class="row">
<div class="col-md-12 form-group"> 
<?php echo form_label('Instagram :', 'googleplus');?>
<?php echo form_textarea(array('name'=>'googleplus','class'=>'form-control','placeholder'=>'Instagram....','rows'=>2),set_value('googleplus',$googleplus));?>
</div>
</div>

<div class="row">
<div class="col-md-12 form-group"> 
<?php echo form_label('Youtube :', 'youtube');?>
<?php echo form_textarea(array('name'=>'youtube','class'=>'form-control','placeholder'=>'youtube....','rows'=>2),set_value('youtube',$youtube));?>
</div>
</div>






<?php $display = !empty( $this->input->get('type') ) ? $this->input->get('type') : ''; ?>
<div style="display:<?php echo ( $display == 'duplex' ) ? 'block' : 'none'; ?>">

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Refferal value', 'refferalvalue');?>
<?php echo form_input(array('name'=>'refferalvalue','class'=>'form-control numbersOnly','placeholder'=>'refferalvalue....','maxlength'=>3),set_value('refferalvalue',$refferalvalue));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Slipcolor', 'slipcolor');?>
<?php echo form_input(array('name'=>'slipcolor','class'=>'form-control','placeholder'=>'slipcolor....'),set_value('slipcolor',$slipcolor));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Slip text color', 'sliptextcolor');?>
<?php echo form_input(array('name'=>'sliptextcolor','class'=>'form-control','placeholder'=>'sliptextcolor....'),set_value('sliptextcolor',$sliptextcolor));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Slip prefix', 'slippfix');?>
<?php echo form_input(array('name'=>'slippfix','class'=>'form-control','placeholder'=>'Slip pfix....'),set_value('slippfix',$slippfix));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Google Place api', 'placeapi');?>
<?php echo form_input(array('name'=>'placeapi','class'=>'form-control','placeholder'=>'placeapi....'),set_value('placeapi',$placeapi));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Google Matrix api', 'matrixapi');?>
<?php echo form_input(array('name'=>'matrixapi','class'=>'form-control','placeholder'=>'matrixapi....'),set_value('matrixapi',$matrixapi));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('SMS key', 'smsuser');?>
<?php echo form_input(array('name'=>'smsuser','class'=>'form-control','placeholder'=>'smsuser....'),set_value('smsuser',$smsuser));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('SMS password', 'smspassword');?>
<?php echo form_input(array('name'=>'smspassword','class'=>'form-control','placeholder'=>'smspassword....'),set_value('smspassword',$smspassword));?> 
</div>
</div> 

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('SMS sender id', 'senderid');?>
<?php echo form_input(array('name'=>'senderid','class'=>'form-control','placeholder'=>'senderid....'),set_value('senderid',$senderid));?> 
</div>
</div>





 
<div class="row">
<div class="col-md-12 form-group">
<?php echo form_label('Captuakey :', 'captuakey');?>
<?php echo form_textarea(array('name'=>'captuakey','class'=>'form-control','placeholder'=>'captuakey....','rows'=>2),set_value('captuakey',$captuakey));?>
</div>
</div>


<div class="row">
<div class="col-md-12 form-group"> 
<?php echo form_label('Captuasecretkey', 'captuasecretkey');?>
<?php echo form_textarea(array('name'=>'captuasecretkey','class'=>'form-control','placeholder'=>'captuasecretkey....','rows'=>2),set_value('captuasecretkey',$captuasecretkey));?> 
</div>
</div>


<div class="row">
<div class="col-md-12 form-group">
<?php echo form_label('Custmer app firebase key', 'custmerfirebkey');?>
<?php echo form_textarea(array('name'=>'custmerfirebkey','class'=>'form-control','placeholder'=>'Custmer app firebase key....','rows'=>2),set_value('custmerfirebkey',$custmerfirebkey));?> 
</div>
</div>



<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Custmer app version', 'custappversion');?>
<?php echo form_input(array('name'=>'custappversion','class'=>'form-control','placeholder'=>'Custmer app version....'),set_value('custappversion',$custappversion));?> 
</div>
</div>


<div class="row">
<div class="col-md-12 form-group"> 
<?php echo form_label('Customer app download link', 'custmeraplink');?>
<?php echo form_textarea(array('name'=>'custmeraplink','class'=>'form-control','placeholder'=>'Taxi partner app version....','rows'=>2),set_value('custmeraplink',$custmeraplink));?> 
</div>
</div>
 

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('From mail', 'frommail');?>
<?php echo form_input(array('name'=>'frommail','class'=>'form-control','placeholder'=>'frommail....'),set_value('frommail',$frommail));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Mailer', 'mailer');?>
<?php echo form_input(array('name'=>'mailer','class'=>'form-control','placeholder'=>'Mailer....'),set_value('mailer',$mailer));?> 
</div>
</div>


<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('CC', 'cc');?>
<?php echo form_input(array('name'=>'cc','class'=>'form-control','placeholder'=>'cc....'),set_value('cc',$cc));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Host IP', 'hostip');?>
<?php echo form_input(array('name'=>'hostip','class'=>'form-control','placeholder'=>'Host IP....'),set_value('hostip',$hostip));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Email user name', 'mailuser');?>
<?php echo form_input(array('name'=>'mailuser','class'=>'form-control','placeholder'=>'Mailuser....'),set_value('mailuser',$mailuser));?> 
</div>
</div>

<div class="row">
<div class="col-md-3 form-group"> 
<?php echo form_label('Email password', 'mailpassword');?>
<?php echo form_input(array('name'=>'mailpassword','class'=>'form-control','placeholder'=>'Email password....'),set_value('mailpassword',$mailpassword));?> 
</div>
</div>


 

<div class="row"> 
<div class="col-md-3 form-group">
<?php echo form_label('Notification', 'notification');?>
<?php echo form_dropdown(array('name'=>'notification','required'=>'required','class'=>'form-control select22'),array('yes'=>'Active','no'=>'InActive'),set_value('notification',$notification));?> 
</div>
</div>
 
 

</div><!-- end setting by admin -->

<div class="row"> 
<div class="col-md-3 form-group">
<?php echo form_label('Select Logo Image', 'userfile');?>
<?php echo form_input(array('type'=>'file','name'=>'userfile', 'class'=>'form-control','placeholder'=>'Select Logo Image') );?> 
</div>
</div>

 

<div class="row" style="margin-top:10px">
<div class="col-md-3" >  
<?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>             
</div>
  
</div>                             
            
<?php echo form_close(); ?>

<div class="spacer-10"></div>
 <!-- /.box-body -->
</div>

</div></div></div>
    
    
<!----------------- Main content end ------------------------->

</div></div>
<!--------- /.content-wrapper --------->
</div>
</section>