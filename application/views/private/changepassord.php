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
            
<div class="row">
<div class="col-md-6"> 

 

<div class="form-group">
<?php echo form_label('User name', 'username');?>
<?php echo form_input(array('type'=>'email','name'=>'username', 'value'=>set_value('username',$username),'class'=>'form-control','maxlength'=>'150','placeholder'=>'Enter email id...') );?> 
</div>

<div class="form-group">
<?php echo form_label('Password ', 'password');?>
<?php echo form_input(array('name'=>'password', 'class'=>'form-control','maxlength'=>'150','placeholder'=>'Enter password...') );?> 
</div>
 
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