<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<?php $format = 'dd-mm-yyyy';?>
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
        <div class="col-md-12">
            <div class="row mg_top_2">
                <div class="col-lg-12">

                                <div class="row">
                                <div class="form-group col-lg-4"> 
                                    <?php echo form_label('Office Type', 'office_type');?>
                                    <?php echo form_input(array('name'=>'office_type','required'=>'required','class'=>'form-control alphanimericOnly','placeholder'=>'Office Like Branch,Corporate etc','autocomplete'=>'off' ), set_value('office_type',$office_type) );?>
                                </div>
                                
                                <div class="form-group col-lg-4"> 
                                    <?php echo form_label('City Name', 'city_name');?>
                                    <?php echo form_input(array('name'=>'city_name','required'=>'required','class'=>'form-control alphanimericOnly','placeholder'=>'Enter city name','autocomplete'=>'off' ), set_value('city_name',$city_name) );?>
                                </div>
                                
                                <div class="form-group col-lg-4"> 
                                    <?php echo form_label('Mobile Numbers', 'mobile_numbers');?>
                                    <?php echo form_input(array('name'=>'mobile_numbers','required'=>'required','class'=>'form-control','placeholder'=>'Enter mobile numbers','autocomplete'=>'off' ), set_value('mobile_numbers',$mobile_numbers) );?>
                                </div>
                                
                                
                                <div class="form-group col-lg-4"> 
                                    <?php echo form_label('Whatsapp Numbers', 'whats_app');?>
                                    <?php echo form_input(array('name'=>'whats_app','required'=>'required','class'=>'form-control','placeholder'=>'Enter whatsapp numbers','autocomplete'=>'off' ), set_value('whats_app',$whats_app) );?>
                                </div>
                                
                                
                                <div class="form-group col-lg-4"> 
                                    <?php echo form_label('Email Address', 'email_address');?>
                                    <?php echo form_input(array('name'=>'email_address','required'=>'required','class'=>'form-control','placeholder'=>'Enter email addresses','autocomplete'=>'off' ), set_value('email_address',$email_address) );?>
                                </div>
                                
                                <div class="form-group col-lg-4"> 
                                    <?php echo form_label('Address Sequence', 'sortby');?>
                                    <?php echo form_input(array('name'=>'sortby','required'=>'required','class'=>'form-control numbersOnly','placeholder'=>'Enter address order by','autocomplete'=>'off' ), set_value('sortby',$sortby) );?>
                                </div>
                                
                                <div class="form-group col-lg-4"> 
                                    <?php echo form_label('Working Hours', 'working_hours');?>
                                    <?php echo form_input(array('name'=>'working_hours','required'=>'required','class'=>'form-control','placeholder'=>'Enter working hours','autocomplete'=>'off' ), set_value('working_hours',$working_hours) );?>
                                </div>
                                
                                
                                <div class="form-group col-lg-4"> 
                                    <?php echo form_label('Working Days', 'working_days');?>
                                    <?php echo form_input(array('name'=>'working_days','required'=>'required','class'=>'form-control','placeholder'=>'Enter working days','autocomplete'=>'off' ), set_value('working_days',$working_days) );?>
                                </div>
                                
                                </div>

                                
                                <div class="row">
                                <div class="col-md-12 form-group"> 
                                <?php echo form_label('Address', 'address_name');?>
                                <?php echo form_textarea(array('name'=>'address_name','class'=>'form-control','placeholder'=>'address_name....','rows'=>2),set_value('address_name',$address_name));?>
                                </div>
                                </div>
                                
                                <div class="row">
                                <div class="col-md-12 form-group"> 
                                <?php echo form_label('Google Map Embeded Code :', 'map_script');?>
                                <?php echo form_textarea( array('name'=>'map_script','class'=>'form-control','rows'=>'2') , $map_script ); ?>
                                </div>
                                </div>


                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-3" >
                                        <?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>
                                    </div>
<div class="col-md-3 pull-right">
<?php if( VIEW ==='yes'){ 
echo anchor( adminurl('websettings/list'),'View List',array('class'=>'btn btn-primary fa fa-sign-out'));}?>
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
                </script>