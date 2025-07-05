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
            <?php //echo form_open_multipart('admin/Viewcorpoemployee/index/'); ?> 
            
            
<div class="row">
<div class="col-md-4"> 
           
<div class="form-group">
<?php echo form_label('State Name', 'stateid');?>
<?php echo form_dropdown(array('name'=>'stateid','class'=>'form-control select22','id'=>'stateid'),get_dropdownsmulti('state',null,'id','statename',' State Name') );?> 
</div>
</div>


<div class="col-md-3" >  
<div class="spacer-10">&nbsp;</div>
<?php echo form_submit('mysubmit', 'Search City', array('class'=>'btn btn-primary','onClick'=>'goto()' ) );  ?>             
</div>
</div>                             
            
<?php //echo form_close(); ?>

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
function goto(){ 
	var stateid = $('#stateid').val(); 
	if( stateid.length > 0 ){
		window.location.href='<?php echo adminurl('Viewcity/?stateid=');?>'+stateid;
	}else{ alert('Please select state name');}
	
	}

</script>