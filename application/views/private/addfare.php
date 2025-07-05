<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 
 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
               
               </div>
    
           
           
            <!-- /.box-header -->
            <div class="box-body">
			<?php echo form_open( $posturl ); ?> 
      <input type="hidden" name="tableid" value="<?php echo $id; ?>"> 
      <input type="hidden" name="category" value="<?php echo $category; ?>"> 

 
<div class="row">
<div class="col-xs-12 col-lg-6 col-md-6" style="border-right:2px solid #ccc">
 
<div class="row mg_top_1">
   <div class="col-lg-6">Fare For :</div>
      <div class="col-lg-6">
         <?php echo form_dropdown(array('name'=>'triptype','required'=>'required','onchange'=>'farefor()','id'=>'triptype','class'=>'form-control select22'),array(''=>'--Select Fare For--','outstation'=>'Outstation','selfdrive'=>'Selfdrive','bike'=>'Bike Rental','monthly'=>'Monthly'),set_value('triptype',$triptype ) );?>
      </div>
       </div>

<div class="row mg_top_2 clearfix" >
<div class="col-lg-6"><?php echo form_label('Pickup City :', 'fromcity');?></div>
<div class="col-lg-6">
<?php echo form_dropdown(array('name'=>'fromcity','required'=>'required','id'=>'fromcity','class'=>'form-control select22'),$citylist,set_value('fromcity',$fromcity ) );?> 
     </div>
       </div>


 <div class="row mg_top_1">
   <div class="col-lg-6">Model Name :</div>
      <div class="col-lg-6">
         <?php echo form_dropdown(array('name'=>'modelid','required'=>'required','id'=>'modelid','class'=>'form-control select22'),$modellist,set_value('modelid',$modelid ) );?>
      </div>
       </div>

<div class="row mg_top_1">
   <div class="col-lg-6">Valid From Date :</div>
      <div class="col-lg-6">
         <input name="validfrom" type="text" data-date-format="dd-mm-yyyy" title="Enter StartDate" value="<?php if( !empty( $validfrom )){ echo date('d-m-Y', strtotime($validfrom)); }else{ echo date('d-m-Y');}?>" id="" class="required datepicker form-control"/>
      </div>
       </div>

 <div class="row mg_top_1">
   <div class="col-lg-6">Valid Till Date :</div>
      <div class="col-lg-6">
         <input name="validtill" type="text" data-date-format="dd-mm-yyyy" title="Enter EndDate" value="<?php if(!empty( $validtill )){ echo date('d-m-Y', strtotime($validtill)); }else{ echo date('d-m-Y',strtotime('+5 year'));}?>"  class="required datepicker form-control"/>
      </div>
       </div>
               

      
<div class="row mg_top_2">
   <div class="col-lg-6">Status</div>
     <div class="col-lg-6">
     <select name="status" class="form-control select22"><?php echo statusv( $status );?></select>
     </div>
     </div>
    
</div><!---left div end here-->



<div class="col-xs-12 col-lg-5 col-md-5" >
  <h4>Fare Chart</h4><hr/>
 
 <?php if($triptype !='outstation'){?> 
 <div class="row mg_top_1">
  <div class="col-lg-6"> <?php if($triptype=='monthly'){ echo 'Per Day Fare'; }else{ echo 'Base Fare';}?> :</div>
    <div class="col-lg-6"> <input name="basefare" type="text" class="form-control numbersOnly" title="Enter Fare Per Kms"  value="<?php echo nullv($basefare);?>" id="basefare" />  </div>
      </div> 
<?php }else{?>


<div class="row mg_top_1 hidedt">
  <div class="col-lg-6">Fare per km :</div>
    <div class="col-lg-6"> <input name="fareperkm" type="text" class="form-control numbersOnly" title="Enter Fare Per Kms" required value="<?php echo nullv($fareperkm);?>" id="fareperkm" />  </div>
      </div> 


<div class="row mg_top_1 hidedt">
  <div class="col-lg-6">Fixed-min kms :</div>
    <div class="col-lg-6"> <input name="minkm_day" type="text" class="form-control numbersOnly" title="Enter Fixed Kms" value="<?php echo nullv($minkm_day);?>" id="minkm_day" />  </div>
      </div>

 
 
 <div class="row mg_top_1 hidedt">
  <div class="col-lg-6">Driver charge/day :</div>
    <div class="col-lg-6"><input name="drivercharge" type="text" title="Enter Driver charge/day"  value="<?php echo nullv($drivercharge);?>" required class="form-control numbersOnly" id="drivercharge" />   </div>
      </div>

     
 <div class="row mg_top_1 hidedt">
  <div class="col-lg-6">Night charge/night :</div>
    <div class="col-lg-6"><input name="nightcharge" type="text" title="Night Charges Extra" value="<?php echo nullv($nightcharge);?>"  class="form-control numbersOnly" id="nightcharge" />   </div>
      </div>  
        
<div class="row mg_top_1 hidedt">
   <div class="col-lg-4">Night charges on :</div>
      <div class="col-lg-8">
      <div class="row">
      <div class="col-lg-6">
      <input name="night_from" type="text" title="Enter StartTime" value="<?php echo date('h:i A',strtotime($night_from ));?>" id="time" class="timepicker form-control"/>
      </div>
      <div class="col-lg-6">
      <input name="night_till" type="text" title="Enter EndTime" value="<?php  echo date('h:i A',strtotime($night_till ));?>" id="time1" class="timepicker form-control"/></div></div></div>
       </div>  
 
    <?php } ?>  

  <div class="row mg_top_1">
  <div class="col-lg-6">Refundable Amount :</div>
    <div class="col-lg-6"> <input name="secu_amount" type="text" class="form-control numbersOnly" title="Enter Refundable Amount"  value="<?php echo nullv($secu_amount);?>" id="secu_amount" />  </div>
      </div> 

</div><!---right div end here-->
</div>


<div class="row" style="margin-top:50px">
		<?php if( $id == ''){?>
        <div class="col-lg-4"><input name="submit" type="submit" value="Submit" class="btn btn-primary"/></div>
        <?php }else if( $id){?>
        <div class="col-lg-4"><input name="submit" type="submit" value="Update Fare" class="btn btn-success"/></div>
        <?php } ?>
        <div class="col-lg-4"><a href="<?=adminurl('viewfare');?>" class="btn btn-warning">Go Back</a></div>
 </div>  
 
</div></div></div></div></div>
</section>
<!--------- /.content-wrapper --------->





 <?php if( $id ){?>
<script>
$(function() {
$('#mform input').attr('readonly', 'readonly');
$('#mform select').attr('disabled',true);
$('#mform input[type="radio"]').attr('disabled',true);
$('#mform input[type="checkbox"]').attr('disabled',true);

});
</script>
<?php } ?>

 
<script type="text/javascript"> 
  function farefor(){
    var ab = $('#triptype').val();
     window.location.href='<?=adminurl('Addfare?triptype=');?>'+ab;
  }
 
</script>