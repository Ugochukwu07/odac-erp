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
            <?php echo form_open_multipart( adminurl('Registerdriver/?id='.$id)); ?> 
            <?php echo form_hidden('id', $id);?>  
                

<div class="row">
<div class="form-group col-lg-4">
<?php echo form_label('Fullname', 'fullname');?>
<?php echo form_input(array('name'=>'fullname', 'value'=>set_value('fullname',$fullname),'class'=>'form-control capital lettersOnly ','required'=>'required','placeholder'=>'Enter fullname....','autocomplete'=>'off') );?> 
</div> 

 
 <div class="form-group col-lg-4">
<?php echo form_label('Email id', 'email');?>
<?php echo form_input(array('name'=>'email','type'=>'email', 'value'=>set_value('email',$email),'class'=>'form-control small','required'=>'required','placeholder'=>'Enter email id....','autocomplete'=>'off') );?> 
</div>

 <div class="form-group col-lg-4">
<?php echo form_label('Aadhaar no.', 'aadhaar');?>
<?php echo form_input(array('name'=>'aadhaar', 'value'=>set_value('aadhaar',$aadhaar),'class'=>'form-control numbersOnly','placeholder'=>'Enter 12 digit aadhaar....','maxlength'=>'12','autocomplete'=>'off') );?> 
</div>

</div>


<div class="row">
<div class="form-group col-lg-2">
<?php echo form_label('Mobile no.', 'mobileno');?>
<?php echo form_input(array('name'=>'mobileno', 'value'=>set_value('mobileno',$mobileno),'class'=>'form-control numbersOnly','required'=>'required','placeholder'=>'Enter mobileno....','maxlength'=>'10','autocomplete'=>'off') );?> 
</div>

<div class="form-group col-lg-2">
<?php  echo form_label('Alternate mobile', 'alternatemobile');?>
<?php echo form_input(array('name'=>'alternatemobile','value'=>set_value('alternatemobile',$alternatemobile),'class'=>'form-control numbersOnly','placeholder'=>'Enter alt. mobile.....','maxlength'=>'10','autocomplete'=>'off') );?> 
</div>
 
<div class="form-group col-lg-4">
<?php  echo form_label('City Name', 'operationcity');?>
<?php echo form_dropdown(array('name'=>'operationcity','class'=>'form-control select22','required'=>'required','id'=>'cityid'), $citylist , set_value('operationcity',$operationcity) );?> 
</div> 

<div class="form-group col-lg-4">
<?php  echo form_label('Pin Code', 'zipcode');?>
<?php echo form_input(array('name'=>'zipcode','value'=>set_value('zipcode',$zipcode),'class'=>'form-control numbersOnly','required'=>'required','placeholder'=>'Enter pin code.....','maxlength'=>'6','autocomplete'=>'off') );?> 
</div>

</div>

<div class="row">
<div class="form-group col-lg-12">
<?php echo form_label('Address  ', 'address');?>
<?php echo form_textarea(array('name'=>'address','class'=>'form-control','required'=>'required','rows'=>'1','cols'=>'3','value'=>set_value('address',$address),'autocomplete'=>'off'));?>
</div>
</div>

<div class="row">
 
<div class="form-group col-lg-4">
<?php echo form_label('DL Number', 'dlnumber');?>
<?php echo form_input(array('name'=>'dlnumber', 'value'=>set_value('dlnumber',$dlnumber),'class'=>'form-control upper','placeholder'=>'Enter DL number....','autocomplete'=>'off') );?> 
</div> 

 
 <div class="form-group col-lg-4">
<?php echo form_label('DL Expiry', 'dlexpireon');?>
<?php echo form_input(array('name'=>'dlexpireon', 'value'=>set_value('dlexpireon',$dlexpireon),'class'=>'form-control datepicker','placeholder'=>'Enter dlexpireon....','autocomplete'=>'off') );?> 
</div>
</div>


<hr style="border:1px dashed red" />





<div class="row">
<div class="form-group col-lg-4">
<?php echo form_label('Select Vehicle ', 'vehicle_cat_id');?>
<?php echo form_dropdown(array('name'=>'vehicle_cat_id','required'=>'required','class'=>'form-control select22'), get_dropdownsmulti('pt_vehicle_model',array('status'=>'yes','catid'=>1),'id','model',' Vehicle Name---'),set_value('vehicle_cat_id',$vehicle_cat_id) );?> 
</div>

<div class="form-group col-lg-4">
<?php echo form_label('Vehicle number', 'vehicleno');?>
<?php echo form_input(array('name'=>'vehicleno', 'value'=>set_value('vehicleno',$vehicleno),'class'=>'form-control nospace upper','required'=>'required','placeholder'=>'Enter vehicleno....','autocomplete'=>'off') );?> 
</div> 

<div class="form-group col-lg-3">
<?php  echo form_label('Verify Documents', 'docs_verify');?>
<?php echo form_dropdown(array('name'=>'docs_verify','class'=>'form-control select22'), array(''=>'--select--','yes'=>'Yes','no'=>'No'),set_value('docs_verify',$docs_verify) );?> 
</div>  
 
  
</div>
 



<hr style="border:1px dotted red" />

<div class="row">

<div class="form-group col-lg-3">
<?php  echo form_label('Complete Profile', 'completeprofile');?>
<?php echo form_dropdown(array('name'=>'completeprofile','class'=>'form-control select22'), array(''=>'--select--','yes'=>'Yes','no'=>'No'),set_value('completeprofile',$completeprofile) );?> 
</div>

<div class="form-group col-lg-3">
<?php  echo form_label('Profile Status', 'status');?> 
<?php echo form_dropdown(array('name'=>'status','class'=>'form-control select22'), array(''=>'--select--','yes'=>'Active','no'=>'In-Active','blacklist'=>'Blacklist'),set_value('status',$status) );?> 
</div>  

<div class="form-group col-lg-3">
<?php  echo form_label('Duty Status', 'dutystatus');?> 
<?php echo form_dropdown(array('name'=>'dutystatus','class'=>'form-control select22'), array(''=>'--select--','on'=>'On','off'=>'Off'),set_value('dutystatus',$dutystatus) );?> 
</div> 

 
 
</div>


 
        

<div class="row" style="margin-top:10px">
<div class="col-md-3" > 
<?php $action = $this->input->get('action') ? $this->input->get('action') : ''; ?>
<?php echo !$action ? form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') ) : anchor( 'javascript:void(0)','Close Window',array('class'=>'btn btn-sm btn-danger','data-toggle'=>'tooltip','title'=>'Close Window','onclick'=>'window.close();') );  ?>             
</div>

<div class="col-md-3" >  
</div>
 
</div>                             
            
<?php echo form_close(); ?>

<div class="spacer-10"></div>
 <!-- /.box-body -->
</div>

</div></div> 
    
     
</section>  </div>