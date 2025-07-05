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
<?php echo form_label('Parent Menu Name', 'parent_id');?>
<?php echo form_dropdown(array('name'=>'parent_id','class'=>'form-control select22','id'=>'parent_id','onchange'=>'getlavel(this.value)'),$menu_list,set_value('parent_id',$parent_id));?> 
</div>
</div>


<div class="col-md-3"> 
<div class="form-group">
<?php echo form_label('Menu Name', 'menu_name');?>
<?php echo form_input(array('name'=>'menu_name','class'=>'form-control', 'id'=>'fullname' ,'placeholder'=>'Enter menu name...','autocomplete'=>'off','maxlength'=>'200'),set_value('menu_name',$menu_name) );?>
</div>
</div>


<div class="col-md-3"> 
<div class="form-group">
<?php echo form_label('Menu Level', 'menu_level');?>
<?php echo form_dropdown(array('name'=>'menu_level','class'=>'form-control select22','id'=>'menu_level'),$level_list,set_value('menu_level',$menu_level));?> 
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
<?php echo form_label('Menu Url', 'menu_url');?>
<?php echo form_input(array('name'=>'menu_url','class'=>'form-control', 'id'=>'menu_url' ,'placeholder'=>'Enter menu url','autocomplete'=>'off'),set_value('menu_url',$menu_url) );?>
</div>
</div>
 
</div>
  


<div class="row" style="margin-top:10px">
<div class="col-md-3" >  
<?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>             
</div>
<div class="col-md-3 pull-right">                 
<?php if( VIEW ==='yes'){ 
    echo  anchor( adminurl('menu_list'),'View',array('class'=>'btn btn-sm btn-success fa fa-sign-out') ); 
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

function getlavel(id){
  $("#menu_level").val('').trigger('change'); 
 $.ajax({
  type:'POST',
  data:{'id':id},
  url:'<?=adminurl('menu_item/getlavel');?>',
  success:(res)=>{
    $("#menu_level").removeAttr("selected");
    $("#menu_level").val(res).trigger('change'); 
  }

 });
}
</script>