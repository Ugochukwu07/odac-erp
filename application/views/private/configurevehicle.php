<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
 
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
                <?php echo goToDashboard(); ?>
               </div>
    
           
           
            <!-- /.box-header -->
            <div class="box-body">
            <?php echo form_open_multipart( $posturl  ); ?> 
            <?php echo form_hidden('id', $id);?> 
            <?php echo form_hidden('redirect', $redirect );?> 
            
            
<div class="row">
<div class="col-md-6"> 

<div class="form-group">
<?php echo form_label('Model Name', 'modelid');?>
<?php echo form_dropdown(array('name'=>'modelid', 'required'=>'required','class'=>'form-control select22','autocomplete'=>'off'),get_dropdownsmulti('pt_vehicle_model',array('status'=>'yes'),'id','model',' model name--'), set_value('modelid',$modelid) );?> 
</div>

<div class="row"> 
<div class="col-lg-6"> 
<div class="form-group">
<?php echo form_label('Vehicle Number', 'vnumber');?>
<?php echo form_input(array('name'=>'vnumber', 'value'=>set_value('vnumber',$vnumber),'required'=>'required','class'=>'form-control','placeholder'=>'Enter vehicle Number','autocomplete'=>'off') );?> 
</div>
</div>
<div class="col-lg-6"> 
<div class="form-group">
<?php echo form_label('Seat Segment', 'seat');?>
<?php echo form_input(array('name'=>'seat', 'value'=>set_value('seat',$seat),'required'=>'required','class'=>'form-control','placeholder'=>'Enter seat segment','autocomplete'=>'off') );?> 
</div>
</div>
</div>


<div class="row"> 
<div class="col-lg-6"> 
<div class="form-group">
<?php echo form_label('Fueltype', 'fueltype');?>
<?php echo form_dropdown(array('name'=>'fueltype', 'required'=>'required','class'=>'form-control select22','autocomplete'=>'off'),array(''=>'--Select fueltype--','Petrol'=>'Petrol','Diesel'=>'Diesel'), set_value('fueltype',$fueltype) );?> 
</div>
</div>
<div class="col-lg-6"> 
<div class="form-group">
<?php echo form_label('Model Year', 'vyear');?>
<?php echo form_input(array('name'=>'vyear', 'value'=>set_value('vyear',$vyear),'required'=>'required','class'=>'form-control','placeholder'=>'Enter model Year','autocomplete'=>'off') );?>
</div></div>
</div>

 
         
<div class="row"> 
<div class="col-lg-6"> 
<div class="form-group">
<?php echo form_label('Status', 'status');?>
<?php echo form_dropdown(array('name'=>'status','required'=>'required','class'=>'form-control'),array(''=>'Select Status','yes'=>'Active','no'=>'InActive','block'=>'Blocked'),set_value('status',$status));?> 
</div>
</div>
</div>

 

<div class="row" style="margin-top:10px">
<div class="col-md-3" >  
<?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>             
</div>
<div class="col-md-3 pull-right">                 
<?php if( VIEW ==='yes'){ 
        if( $redirect == 'viewvehiclelist'){
             echo  anchor( adminurl('viewvehiclelist'),'Go Back',array('class'=>'btn btn-warning fa fa-sign-out') );
        }else{
             echo  anchor( adminurl('vehicle_pending_doc_list'),'Go Back',array('class'=>'btn btn-warning fa fa-sign-out') );
        }
        
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