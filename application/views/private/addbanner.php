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
            <?php echo form_hidden('oldimage', $oldimage);?>
            
            
<div class="row">
<div class="col-md-6"> 

<div class="form-group">
<?php echo form_label('Select Image', 'userfile');?>
<?php echo form_input(array('type'=>'file','name'=>'userfile', 'class'=>'form-control','placeholder'=>'Select Image') );?> 
</div>



         
<div class="row"> 
<div class="col-lg-6"> 
<div class="form-group">
<?php echo form_label('Device Type', 'usertype');?>
<?php echo form_dropdown(array('name'=>'usertype','required'=>'required','class'=>'form-control'),array(''=>'Select Device Type','mobile'=>'Mobile','desktop'=>'Desktop'),set_value('usertype',$usertype));?> 
</div>
</div>

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
    echo  anchor( adminurl('Viewbanner'),'View',array('class'=>'btn btn-success fa fa-sign-out') ); 
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