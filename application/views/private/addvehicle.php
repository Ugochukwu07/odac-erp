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
            <?php echo form_hidden('oldimage', $image);?>
            
            
<div class="row">
<div class="col-md-6"> 

<div class="form-group">
<?php echo form_label('Category', 'catid');?>
<?php echo form_dropdown(array('name'=>'catid', 'required'=>'required','class'=>'form-control select22','autocomplete'=>'off'),get_dropdownsmulti('vehicle_cat',array('status'=>'yes'),'id','category',' category--'), set_value('catid',$catid) );?> 
</div>

<div class="form-group">
<?php echo form_label('Model Name', 'model');?>
<?php echo form_input(array('name'=>'model', 'value'=>set_value('model',$model),'required'=>'required','class'=>'form-control','placeholder'=>'Enter model name','autocomplete'=>'off') );?> 
</div>

<div class="form-group">
<?php echo form_label('Select Image', 'userfile');?>
<?php echo form_input(array('type'=>'file','name'=>'userfile', 'class'=>'form-control','placeholder'=>'Select Image') );?> 
</div>



         
<div class="row"> 
<div class="col-lg-6"> 
<div class="form-group">
<?php echo form_label('Status', 'status');?>
<?php echo form_dropdown(array('name'=>'status','required'=>'required','class'=>'form-control'),array(''=>'Select Status','yes'=>'Active','no'=>'InActive'),set_value('status',$status));?> 
</div>
</div>
</div>

 

<div class="row" style="margin-top:10px">
<div class="col-md-3" >  
<?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>             
</div>
<div class="col-md-3 pull-right">                 
<?php if( VIEW ==='yes'){ 
    echo  anchor( adminurl('Viewvehicle'),'Go Back',array('class'=>'btn btn-warning fa fa-sign-out') ); 
    } 
?>
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