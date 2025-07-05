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
            <?=form_open_multipart( $posturl,['method'=>'post'] );?>
            <?=form_hidden('id', $id );?>  
            
            
<div class="row"> 

<div class="col-md-3"> 
<div class="form-group">
<?php echo form_label('User Full Name', 'fullname');?>
<?php echo form_input(array('name'=>'fullname','class'=>'form-control lettersOnly', 'id'=>'fullname' ,'placeholder'=>'Enter full name...','autocomplete'=>'off','maxlength'=>'100','required'=>'required'),set_value('fullname',$fullname) );?>
</div>
</div>

<div class="col-md-3"> 
<div class="form-group">
<?php echo form_label('User Mobile', 'mobile');?>
<?php echo form_input(array('name'=>'mobile','class'=>'form-control numbersOnly', 'id'=>'mobile' ,'placeholder'=>'Enter mobile number...','autocomplete'=>'off','maxlength'=>'10','required'=>'required'),set_value('mobile',$mobile) );?>
</div>
</div>

<div class="col-md-3"> 
<div class="form-group">
<?php echo form_label('Password', 'password');?>
<?php echo form_input(array('name'=>'password','class'=>'form-control', 'id'=>'password' ,'placeholder'=>'Enter password...','autocomplete'=>'off','required'=>'required'),set_value('password',$password) );?>
</div>
</div>


<div class="col-md-3"> 
<div class="form-group">
<?php echo form_label('Status', 'status');?>
<?php echo form_dropdown(array('name'=>'status','required'=>'required','class'=>'form-control'),array(''=>'Select Status','yes'=>'Active','no'=>'InActive'),set_value('status',$status));?> 
</div>
</div>

</div>
 


<div class="row">
<div class="col-md-12"> 
<div class="form-group">
<?php echo form_label('Select Menu', 'menuids');?>
<?php echo form_dropdown(array('name'=>'menuids[]','class'=>'form-control select22','id'=>'menuids' ,'multiple'=>'multiple','required'=>'required'),$menu_list,set_value('menuids',$menuids));?> 
</div>
</div>
</div>




<div class="row" style="margin-top:10px">
<div class="col-md-3" >  
<?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>             
</div>
<div class="col-md-3 pull-right">                 
<?php if( VIEW ==='yes'){ 
    echo  anchor( adminurl('roll_team_list'),'View',array('class'=>'btn btn-sm btn-success fa fa-sign-out') ); 
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

<script type="text/javascript">
function selectCity(id,name) {
  $("#search-box").val(name);
  $("#citynameid").val(id);
  $("#suggesstion-box").hide();
}
</script>