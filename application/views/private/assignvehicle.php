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
            <?php echo form_open_multipart( $posturl  ); ?> 
            <?php echo form_hidden('id', $id);?> 
            <?php echo form_hidden('redirect', $redirect);?> 
            <?php echo form_hidden('triptype', $triptype);?>  
            
<div class="row">
<div class="col-md-6"> 
<?php if($triptype =='outstation'){?>
<div class="form-group">
<?php echo form_label('Select Driver', 'dvrtableid');?>
<?php echo form_dropdown(array('name'=>'dvrtableid', 'required'=>'required','class'=>'form-control select22','autocomplete'=>'off','id'=>'dvrtableid','onchange'=>'filldata()'),get_driverassignlist('driver',['status'=>'yes'],'id'), set_value('dvrtableid',$dvrtableid) );?> 
</div>  

<div class="form-group">
<?php echo form_label('Driver Name', 'drvname');?>
<?php echo form_input(array('name'=>'drvname', 'id'=>'drvname','required'=>'required','class'=>'form-control','placeholder'=>'Enter driver name','autocomplete'=>'off'),set_value('drvname',$drvname) );?> 
</div>

<div class="form-group">
<?php echo form_label('Driver Mobile No.', 'drvmobile');?>
<?php echo form_input(array('name'=>'drvmobile', 'id'=>'drvmobile','required'=>'required','class'=>'form-control','placeholder'=>'Enter driver mobile','autocomplete'=>'off'),set_value('drvmobile',$drvmobile) );?> 
</div>

<div class="form-group">
<?php echo form_label('Vehicle No.', 'vehicleno');?>
<?php echo form_input(array('name'=>'vehicleno', 'id'=>'vehicleno','required'=>'required','class'=>'form-control','placeholder'=>'Enter vehicleno','autocomplete'=>'off'),set_value('vehicleno',$vehicleno) );?> 
</div>

<?php }else{?>

<div class="form-group">
<?php echo form_label('Select Vehicle Number', 'vehicleno');?>
<?php echo form_dropdown(array('name'=>'vehicleno', 'required'=>'required','class'=>'form-control select22','autocomplete'=>'off',),createDropdown($vehiclelist,'vnumber','vnumber','Select Vehicle no' ), set_value('vehicleno',$vehicleno) );?> 
</div>
<?php } ?>

  

<div class="row" style="margin-top:10px">
<div class="col-md-3" >  
<?php echo form_submit('mysubmit', 'Submit', array('class'=>'btn btn-primary') );  ?>             
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
</script>