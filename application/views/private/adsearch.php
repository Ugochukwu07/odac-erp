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
            <?php echo form_open_multipart( $posturl ,array('method'=>'get','target'=>$target )); ?>
            <?php if( !is_null($param)){
              foreach ($param as $key => $value) {
                echo form_hidden( $key  ,$value );
              }
            }

            ?>  
  
<div class="row">
<div class="form-group col-lg-3">
<?php  echo form_label('State Name', 'stateid');?>
<?php echo form_dropdown(array('name'=>'stateid','class'=>'form-control select22','onchange'=>'getdistrict()','id'=>'stateid'), get_dropdownsmulti('state',null,'id','statename',' State name---') );?> 
</div>

<div class="form-group col-lg-4">
<?php  echo form_label('City Name', $requestparam);?>
<?php $cityddr =  array(''=>'-- Select city name---'); ?>
<?php echo form_dropdown(array('name'=>$requestparam,'class'=>'form-control select22','id'=>'cityid'), $cityddr );?> 
</div> 
 
<?php if($uniqueid){?> 
<div class="form-group col-lg-4">
<?php echo form_label($label, $uniqueid);?> 
<?php echo form_input(array('name'=>$uniqueid,'class'=>'form-control','id'=>'uniqueid','placeholder'=>$label) );?> 
</div> 
<?php }?> 

<div class="col-md-3" style="margin-top: 24px" > 
<?php echo form_submit('mysubmit','Search', array('class'=>'btn btn-primary') ) ;  ?>   
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

function getdistrict(){
  var stateid = $('#stateid').val(); 
if( stateid.length > 0 ){ 
  $.ajax({
    url: "<?php echo adminurl('ajax/Cityfromstateid/index');?>",
    type: "POST",
    data: "stateid="+stateid,
    cache: false,
    success: function( response ) {  
      $('#cityid').html( response ); 
      }
    });

  }else{  $('#cityid').html( );   }

}
</script>