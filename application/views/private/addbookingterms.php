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
            <?php echo form_open_multipart( $posturl ); ?> 
            <?php echo form_hidden('id', $id);?>   
            <?php echo form_hidden('contenttype', 'terms');?> 
            
            
<div class="row">
<div class="col-md-6"> 
 
<div class="form-group">
<?php echo form_label('Select Triptype', 'datacategory');?>
<?php echo form_dropdown(array('name'=>'datacategory', 'class'=>'form-control select22','required'=>'required','id'=>'datacategory'),array(''=>'---Select Trip Type---','outstation'=>'Outstation','selfdrive'=>'Selfdrive','bike'=>'Bikerental','monthly'=>'Monthly Rental'),set_value('datacategory',$datacategory) );?> 
</div>

<div class="form-group">
<?php echo form_label('Content', 'content');?>
<?php echo form_input(array('name'=>'content','value'=>set_value('content',$content ), 'class'=>'form-control' ,'placeholder'=>'Content...','title'=>'Content...','autocomplete'=>'off'));?>
</div>

 
<div class="form-group">
<?php echo form_label('Status', 'status');?>
<?php echo form_dropdown(array('name'=>'status','required'=>'required','class'=>'form-control select22'),array(''=>'Select Status','yes'=>'Active','no'=>'InActive'),set_value('status',$status));?> 
</div>

 
<div class="row" style="margin-top:10px">
<div class="col-md-3" >  
<?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>             
</div>
<div class="col-md-3 pull-right">                 
<?php if( VIEW ==='yes'){ 
		echo  anchor( adminurl('Viewbookingterms'),'View',array('class'=>'btn btn-sm btn-success fa fa-sign-out') ); 
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