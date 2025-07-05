<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
 <style type="text/css">.wd5{ width: 50%; float: left; margin-right: 10px }
.wd56{ width: 45%; float: left; }
<?php if($action == 'close'){?>
.hideDiv{ display:none ;}
<?php }else{ ?> .hideActionDiv{ display:none ; } <?php } ?>
</style>
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
            <?php echo form_open_multipart( $posturl  );  //print_r($list);?> 
            <?php echo form_hidden('id', $id);?> 
            <?php echo form_hidden('redirect', $redirect);?> 
            <?php echo form_hidden('triptype', $list['triptype']);?>  
            <?php echo form_hidden('action', $action );?>  
            <input type="hidden" name="is_date_edited" id="is_date_edited" value="no" />
            
<div class="row ">  
<div class="form-group col-md-3 hideDiv">
<?php echo form_label('Guest Name', 'name');?>
<?php echo form_input(array('name'=>'name', 'id'=>'name','required'=>'required','class'=>'form-control','placeholder'=>'Enter guest name','autocomplete'=>'off'),set_value('name',$list['name']) );?> 
</div> 
<div class="form-group col-md-3 hideDiv">
<?php echo form_label('Mobile No.', 'mobileno');?>
<?php echo form_input(array('name'=>'mobileno', 'id'=>'mobileno','required'=>'required','class'=>'form-control','placeholder'=>'Enter mobileno','autocomplete'=>'off'),set_value('mobileno',$list['mobileno']) );?> 
</div> 
 
<div class="form-group col-md-3 hideDiv">
<?php echo form_label('Email Address', 'email');?>
<?php echo form_input(array('name'=>'email', 'id'=>'email','required'=>'required','class'=>'form-control','placeholder'=>'Enter guest email','autocomplete'=>'off'),set_value('email',$list['email']) );?> 
</div> 
<div class="form-group col-md-3 hideDiv">
<?php echo form_label('Bookingid', 'bookingid');?>
<?php echo form_input(array('name'=>'bookingid', 'id'=>'bookingid','required'=>'required','class'=>'form-control','placeholder'=>'Enter bookingid','autocomplete'=>'off','readonly'=>''),set_value('bookingid',$list['bookingid']) );?> 
</div> 
</div>



<div class="row">  
<div class="form-group col-md-3 hideDiv">
<?php echo form_label('Pickup City', 'pickupcity');?>
<?php echo form_input(array('name'=>'pickupcity', 'id'=>'pickupcity','required'=>'required','class'=>'form-control','placeholder'=>'Enter pickupcity','autocomplete'=>'off'),set_value('pickupcity',$list['pickupcity']) );?> 
</div> 
<div class="form-group col-md-3 hideDiv">
<?php echo form_label('Pickup Address', 'pickupaddress');?>
<?php echo form_input(array('name'=>'pickupaddress', 'id'=>'pickupaddress','required'=>'required','class'=>'form-control','placeholder'=>'Enter pickupaddress','autocomplete'=>'off'),set_value('pickupaddress',$list['pickupaddress']) );?>
</div> 
 
<div class="form-group col-md-3 hideDiv">
<?php echo form_label('Drop City', 'dropcity');?>
<?php echo form_input(array('name'=>'dropcity', 'id'=>'dropcity','required'=>'required','class'=>'form-control','placeholder'=>'Enter dropcity','autocomplete'=>'off'),set_value('dropcity',$list['dropcity']) );?> 
</div> 
<div class="form-group col-md-3 hideDiv">
<?php echo form_label('Drop Address', 'dropaddress');?>
<?php echo form_input(array('name'=>'dropaddress', 'id'=>'pickupaddress','required'=>'required','class'=>'form-control','placeholder'=>'Enter dropaddress','autocomplete'=>'off'),set_value('dropaddress',$list['dropaddress']) );?> 
</div> 
</div>

 
<div class="row">  

<div class="form-group col-md-3 hideActionDiv">
<?php echo form_label('Bookingid', 'bookingid');?>
<?php echo form_input(array('name'=>'bookingid', 'id'=>'bookingid','required'=>'required','class'=>'form-control','placeholder'=>'Enter bookingid','autocomplete'=>'off','readonly'=>''),set_value('bookingid',$list['bookingid']) );?> 
</div>

<div class="form-group col-md-3">
<?php echo form_label('Booking Date', 'bookingdate');?> <a target="_blank" href="<?=base_url('private/bookingslots?id='.$list['vehicleno'].'&from='.date('Y-m-d',strtotime($list['pickupdatetime'].'-15 days')).'&to='. date('Y-m-d',strtotime($list['dropdatetime'].' + 15 days')).'')?>" >View SLots</a> <br/>
<?php echo form_input(array('readonly'=>'readonly', 'id'=>'bookingdate','class'=>'form-control','autocomplete'=>'off'),set_value('bookingdatetime',date('m/d/Y',strtotime($list['bookingdatetime']))) );?> 
</div>

<div class="form-group col-md-3">
<?php echo form_label('Pickup Date', 'pickupdate');?><br/>
<?php echo form_input(array('name'=>'pickupdate', 'id'=>'pickupdate','required'=>'required','class'=>'form-control datepicker  wd5','placeholder'=>'Enter pickupdate','autocomplete'=>'off','onchange'=>'checkExtendedSlots(),updateDays()'),set_value('pickupdate',date('m/d/Y',strtotime($list['pickupdatetime']))) );?> 
<?php echo form_input(array('name'=>'pickuptime', 'id'=>'pickuptime','required'=>'required','class'=>'form-control timepicker wd56','placeholder'=>'Enter pickuptime','autocomplete'=>'off'),set_value('pickuptime',date('H:i:s',strtotime($list['pickupdatetime']))) );?>
</div> 
<div class="form-group col-md-3">
<?php echo form_label('Drop Date', 'dropdate');?><br/>
<?php echo form_input(array('name'=>'dropdate', 'id'=>'dropdate','required'=>'required','class'=>'form-control datepicker wd5','placeholder'=>'Enter dropdate','autocomplete'=>'off','onchange'=>'checkExtendedSlots(),updateDays()'),set_value('dropdate',date('m/d/Y',strtotime($list['dropdatetime']))) );?>
<?php echo form_input(array('name'=>'droptime', 'id'=>'droptime','required'=>'required','class'=>'form-control timepicker wd56','placeholder'=>'Enter droptime','autocomplete'=>'off'),set_value('droptime',date('H:i:s',strtotime($list['dropdatetime']))) );?>
</div> 
 
<div class="form-group col-md-3 hideDiv">
<?php echo form_label('Vehicle Model', 'modelname');?>
<?php echo form_input(array('name'=>'modelname', 'id'=>'modelname','required'=>'required','class'=>'form-control','placeholder'=>'Enter modelname','autocomplete'=>'off'),set_value('modelname',$list['modelname']) );?> 
</div> 
<div class="form-group col-md-3 hideDiv">
<?php //echo form_label('Drop Address', 'dropaddress');?>
<?php //echo form_input(array('name'=>'dropaddress', 'id'=>'pickupaddress','required'=>'required','class'=>'form-control','placeholder'=>'Enter dropaddress','autocomplete'=>'off'),set_value('dropaddress',$list['dropaddress']) );?> 
</div>
 

</div>

<style type="text/css">
.qauntity{ padding: 10px;
background: #528100;
box-shadow: 0px 0px 1px #FFF; 
color: #fff;
font-weight: bold;
}  
input{ padding:5px; margin:5px 0px 2px 0px}
.crox{ margin:10px 0px; color:#999; float:right}
em{ font-size:12px; color:#999}
.border1{ border:3px solid #F00;}
.flmenu{ height:60px !important;}
.panel-group .panel-heading + .panel-collapse > .panel-body{background:#F0F0F0;}
.ui-helper-hidden-accessible{ display:none;}
</style>

<div class="row" style="margin:5px; width: 99%;">
<div class="col-md-12" > 
<?php 
if( !empty($is_new_edit)){
    ci()->load->view( adminfold('includes/new_edit_for_all_tab'),['data'=>$list]); 
}else{ 

      if($list['triptype'] == 'selfdrive'){
      ci()->load->view( adminfold('includes/selfdrive'),['data'=>$list]); 
      }else if($list['triptype'] == 'bike'){
      ci()->load->view( adminfold('includes/bike'),['data'=>$list]);
      }else if($list['triptype'] == 'outstation'){
      //ci()->load->view( adminfold('includes/outstation'),['data'=>$list]);
      }else{
       ci()->load->view( adminfold('includes/monthly'),['data'=>$list]);   
      }
}
  ?>
</div>
</div>


<div class="row" style="margin-top:10px">
<div class="col-md-3" >  
<a class="btn btn-warning" href="<?php echo adminurl('bookingview/?type='.$redirect );?>" >Go Back</a>
</div>

<div class="col-lg-2 pull-right">   
<?php echo form_submit(array('name'=>'mysubmit','value'=>( $action=='close' ? ' Close ' : 'Update' ),'type'=>'submit','class'=>'btn btn-primary','onclick'=>"confirm('Are you Sure')") );  ?>  
</div>
            
            
<div class="col-md-3 pull-right">                 
 
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


<script type="text/javascript">
  function filldata(){
    var myStr = $('#dvrtableid option:selected').text();
  if( myStr.length > 0 ){ 
  var strArray = myStr.split("{");
  var name = strArray[0].trim(); 
  var nextArray = strArray[1];
  var nextstr = nextArray.slice(0, -1);
  var nxtstrArray = nextstr.split("-");
  var mobile = nxtstrArray[0].trim();
  var vehicle = nxtstrArray[1].trim();
  }else{ var name = ''; var mobile = ''; var vehicle = ''; }
  $('#drvname').val(name);
  $('#drvmobile').val(mobile);
  $('#vehicleno').val(vehicle);
 
  }

  function calculatedays(){
    var fromdate = $('#pickupdate').val(); 
    var dropdate = $('#dropdate').val(); 
    var date1 = new Date( fromdate ); 
    var date2 = new Date( dropdate );   
    var Difference_In_Time = date2.getTime() - date1.getTime();  
    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24) + 1; 
    $('#driverdays').val( Difference_In_Days );  
  }
  
 setTimeout(function(){ window.load = calculatedays();},1000);
 
 function updateDays(){
     calculatedays();
     var fromdate = $('#pickupdate').val();
     var pickuptime = $('#pickuptime').val();
     var dropdate = $('#dropdate').val();
     var droptime = $('#droptime').val(); 
     var days = $('#driverdays').val(); 
     var id = '<?=$list['id']?>';
     var tripType = '<?=$list['triptype']?>';
     $('#is_date_edited').val('yes');
     Local(); 
 }
 
 function checkExtendedSlots(){
     calculatedays();
     var id = '<?=$id?>';
     var fromdate = $('#pickupdate').val();
     var pickuptime = $('#pickuptime').val();
     var dropdate = $('#dropdate').val();
     var droptime = $('#droptime').val(); 
     
     $.ajax({
         type:'POST',
         data:{'id':id,'fromdate':fromdate,'pickuptime':pickuptime,'dropdate':dropdate,'droptime':droptime},
         url:'<?=base_url('private/Editbooking/checkExtendedSlots')?>',
         success: function(res ){
             var obj = JSON.parse(res);
             if( !obj.status ){
                 $('#dropdate').val( obj.dropdate );
                   setTimeout(function(){ window.load = updateDays();},500);
                   <?php //if(!empty($list['vehicleno'])){?>
                   window.open( obj.sloturl , '_blank');
                   <?php //}?>
                   
                 alert( obj.message );
             }
             
         }
     })
     
 }
 
</script>