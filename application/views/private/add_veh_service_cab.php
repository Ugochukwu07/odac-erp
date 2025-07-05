<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<?php $format = 'dd-mm-yyyy';?>
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php echo goToDashboard(); ?>
                    <div style="width:150px; float:right"> 
                    <a href="<?php echo adminurl('add_veh_service');?>" class="btn btn-sm btn-primary "><i class="fa fa-plus"></i> Add </a>  &nbsp; | &nbsp;
                    <a href="<?php echo adminurl('vehicle_service_list_cab?status='.$redirect );?>" class="btn btn-sm btn-success"><i class="fa fa-table"></i> View </a>  
                    </div>
                </div>
                <!-- /.box-header -->
<div class="box-body">
    <?php echo form_open_multipart( adminurl('Add_veh_service_cab/savedata' )); ?>
    <?php echo form_hidden('id', $id);?> 
     <?php echo form_hidden('redirect', $redirect );?> 
    <div class="row">
        <div class="col-md-7">
            <div class="row mg_top_2">
                <div class="col-lg-12" style="border: 2px solid #111111; margin-left: 20px; padding: 20px;" >

                                <div class="row">
                                <div class="form-group col-lg-6"> 
                                    <?php echo form_label('Vehicle Number', 'vehicle_con_id');?>
                                    <?php echo form_dropdown(array('name'=>'vehicle_con_id','required'=>'required','class'=>'form-control select22' ,'onChange'=>"loadVehicleData(this.value)" ),$vehiclelist,set_value('vehicle_con_id',$vehicle_con_id));?>
                                </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <?php echo form_label('Service Date', 'service_date');?>
                                        <?php echo form_input(array('name'=>'service_date','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter service date','autocomplete'=>'off','id'=>'service_date','data-date-format'=>$format,'data-date'=>'','onchange'=>"filldatemonth(this.value)"), set_value('service_date',$service_date) );?>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <?php echo form_label('Service Kms', 'service_km');?>
                                        <?php echo form_input(array('name'=>'service_km','required'=>'required','class'=>'form-control numbersOnly','placeholder'=>'Enter service km','autocomplete'=>'off','onkeyup'=>"fillkm(this.value)" ), set_value('service_km',$service_km) );?>
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <?php echo form_label('Service Details', 'service_details');?>
                                        <?php echo form_textarea(array('name'=>'service_details','rows'=>'3','required'=>'required','class'=>'form-control','placeholder'=>'Enter service details','autocomplete'=>'off' ), set_value('service_details',$service_details) );?>
                                    </div> 
                                    <div class="form-group col-lg-6"> 
                                        <?php echo form_label('Service From', 'service_taken_from');?>
                                        <?php echo form_dropdown(array('name'=>'service_taken_from','required'=>'required','class'=>'form-control','id'=>'vehicle_con_id'),['Company'=>'In Company','Out Of Company'=>'Out Of Company'],set_value('service_taken_from',$service_taken_from ));?>
                                    </div>
                                </div>
                                
                                <div class="row">
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Next Service Date', 'next_service_date');?>
                                    <?php echo form_input(array('name'=>'next_service_date','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter next service date','autocomplete'=>'off','id'=>'next_service_date','data-date-format'=>$format,'data-date'=>''), set_value('next_service_date',$next_service_date) );?>
                                </div>
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Next Service Kms', 'next_service_km');?>
                                    <?php echo form_input(array('name'=>'next_service_km','required'=>'required','class'=>'form-control numbersOnly','placeholder'=>'Ente next service km','autocomplete'=>'off','id'=>'next_service_km'), set_value('next_service_km',$next_service_km ) );?>
                                </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <?php echo form_label('Tyre & Alignment Date', 'tyre_alignment_date');?>
                                        <?php echo form_input(array('name'=>'tyre_alignment_date','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter tyre & alignment date','autocomplete'=>'off','id'=>'tyre_alignment_date','data-date-format'=>$format,'data-date'=>''), set_value('tyre_alignment_date',$tyre_alignment_date ) );?>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <?php echo form_label('Tyre & Alignment Km', 'tyre_alignment_km');?>
                                        <?php echo form_input(array('name'=>'tyre_alignment_km','required'=>'required','class'=>'form-control numbersOnly','placeholder'=>'Enter tyre & alignment km','autocomplete'=>'off','id'=>'tyre_alignment_km' ), set_value('tyre_alignment_km',$tyre_alignment_km ) );?>
                                    </div> 
                                </div>
                                
                                 <div class="row">
                                    <div class="form-group col-lg-6">
                                        <?php echo form_label('Battery Change Date', 'battery_date');?>
                                        <?php echo form_input(array('name'=>'battery_date','class'=>'form-control datepicker','placeholder'=>'Enter battery change date','autocomplete'=>'off','id'=>'battery_date','data-date-format'=>$format,'data-date'=>''), set_value('battery_date',$battery_date ) );?>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <?php echo form_label('Battery Change Details', 'battery_details');?>
                                        <?php echo form_input(array('name'=>'battery_details','class'=>'form-control','placeholder'=>'Enter battery change details','autocomplete'=>'off' ), set_value('battery_details',$battery_details ) );?>
                                    </div> 
                                </div>
                                
                                <div class="row"> 
                                    <div class="form-group col-lg-6">
                                        <?php echo form_label('Total Amount', 'amount');?>
                                        <?php echo form_input(array('name'=>'amount','required'=>'required','class'=>'form-control numbersOnly','placeholder'=>'Enter total amount','autocomplete'=>'off' ), set_value('amount',$amount ) );?>
                                    </div> 
                                </div>
                                
                                
                                
                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-3" >
                                        <?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>
                                </div>
                                
                                
<div class="col-md-3 pull-right">
<?php if( VIEW ==='yes'){ 
echo anchor( adminurl('vehicle_service_list_cab?status='.$redirect ),'Go Back',array('class'=>'btn btn-warning fa fa-sign-out'));}?>
</div>
</div>
                                                <?php echo form_close(); ?>
                                                <div class="spacer-10"></div>
                                                <!-- /.box-body -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!----------------- Main content end ------------------------->
                            </div>
                        </div>
                        <!--------- /.content-wrapper --------->
                    </div>  
                </section></div></div>
                <script>
                    function filldate( dtval, id ){
                        $('#'+id).val( dtval );
                    }
                    
    $(function () {
            $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
            });
    });
    
    function fillkm( vl ){ 
        $('#next_service_km, #tyre_alignment_km').val( ( parseInt(vl) + 10000) );
    } 


  function filldatemonth( vl ){ 
     
      $.ajax({
          type:'POST',
          url: '<?=base_url('private/Add_veh_service_cab/addMonthDates');?>',
          data:{'indate':vl},
          success: (res)=>{ 
              $('#next_service_date,#tyre_alignment_date').val(  res  );
          }
      })
        
    }
    
     function loadVehicleData( id ){
        let is_editMode = '<?=$id;?>';
        if( is_editMode === '' && id ){
            window.location.href='<?=base_url('private/add_veh_service_cab?')?>redirect=<?=$redirect?>&vehicle_con_id='+id;
        } 
    }
    
</script>