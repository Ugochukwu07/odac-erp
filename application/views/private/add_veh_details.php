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
                </div>
                <!-- /.box-header -->
<div class="box-body">
    <?php echo form_open_multipart( adminurl('Add_veh_details/savedata' )); ?>
    <?php echo form_hidden('id', $id);?>
    <?php echo form_hidden('redirect', $redirect );?>
    <input type="hidden" id="insu_company_name" name="insu_company_name" value="<?=$insu_company_name?>" >
    <div class="row">
        <div class="col-md-7">
            <div class="row mg_top_2">
                <div class="col-lg-12" style="border: 2px solid #111111; margin-left: 20px; padding: 20px;">

                                <div class="row">
                                <div class="form-group col-lg-6"> 
                                    <?php echo form_label('Vehicle Number', 'vehicle_con_id');?>
                                    <?php echo form_dropdown(array('name'=>'vehicle_con_id','required'=>'required','class'=>'form-control select22','id'=>'vehicle_con_id'),$vehiclelist,set_value('vehicle_con_id',$vehicle_con_id));?>
                                </div>
                                </div>


                                <div class="row">
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('White Permit From', 'white_permit_from');?>
                                    <?php echo form_input(array('name'=>'white_permit_from','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter white permit from date','autocomplete'=>'off','onchange'=>"filldate(this.value,'white_permit_till')",'data-date-format'=>$format,'data-date'=>''), set_value('white_permit_from',$white_permit_from) );?>
                                </div>
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('White Permit To', 'white_permit_till');?>
                                    <?php echo form_input(array('name'=>'white_permit_till','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter white permit till date','autocomplete'=>'off','id'=>'white_permit_till','data-date-format'=>$format,'data-date'=>''), set_value('white_permit_till',$white_permit_till) );?>
                                </div>
                                </div>
                                
                                <div class="row">
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Permit From', 'permit_from');?>
                                    <?php echo form_input(array('name'=>'permit_from','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter permit from date','autocomplete'=>'off','onchange'=>"filldate(this.value,'permit_till')",'data-date-format'=>$format,'data-date'=>''), set_value('permit_from',$permit_from) );?>
                                </div>
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Permit To', 'permit_till');?>
                                    <?php echo form_input(array('name'=>'permit_till','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Ente permrit till date','autocomplete'=>'off','id'=>'permit_till','data-date-format'=>$format,'data-date'=>''), set_value('permit_till',$permit_till) );?>
                                </div>
                                </div>
                                
                                
                                <div class="row">
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Tax Valid From', 'tax_from');?>
                                    <?php echo form_input(array('name'=>'tax_from','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter tax from date','autocomplete'=>'off','onchange'=>"filldate(this.value,'tax_till')",'data-date-format'=>$format,'data-date'=>''), set_value('tax_from',$tax_from ) );?>
                                </div>
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Tax Valid To', 'tax_till');?>
                                    <?php echo form_input(array('name'=>'tax_till','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter tax till date','autocomplete'=>'off','id'=>'tax_till','data-date-format'=>$format,'data-date'=>''), set_value('tax_till',$tax_till) );?>
                                </div>
                                </div>
                                
                                <div class="row">
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Fitness From', 'fitness_from');?>
                                    <?php echo form_input(array('name'=>'fitness_from','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter fitness from date','autocomplete'=>'off','onchange'=>"filldate(this.value,'fitness_till')",'data-date-format'=>$format,'data-date'=>''), set_value('fitness_from',$fitness_from) );?>
                                </div>
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Fitness To', 'fitness_till');?>
                                    <?php echo form_input(array('name'=>'fitness_till','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter fitness till date','autocomplete'=>'off','id'=>'fitness_till','data-date-format'=>$format,'data-date'=>''), set_value('fitness_till',$fitness_till) );?>
                                </div>
                                </div>
                                
                                <div class="row">
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Insurence From', 'insurence_from');?>
                                    <?php echo form_input(array('name'=>'insurence_from','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter insurence from date','autocomplete'=>'off','onchange'=>"filldate(this.value,'insurence_till')",'data-date-format'=>$format,'data-date'=>''), set_value('insurence_from',$insurence_from) );?>
                                </div>
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Insurence To', 'insurence_till');?>
                                    <?php echo form_input(array('name'=>'insurence_till','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter insurence till date','autocomplete'=>'off','id'=>'insurence_till','data-date-format'=>$format,'data-date'=>''), set_value('white_permit_till',$insurence_till) );?>
                                </div>
                                </div>
                                <div class="row">
                                <div class="form-group col-lg-6"> 
                                    <?php echo form_label('Company Name', 'company_id');?>
                                    <?php echo form_dropdown(array('name'=>'company_id','required'=>'required','class'=>'form-control select22','id'=>'company_id','onchange'=>"getCompanyName( this.value )"),$companylist,set_value('company_id',$company_id ));?>
                                </div>
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Policy Number', 'policy_no');?>
                                    <?php echo form_input(array('name'=>'policy_no','required'=>'required','class'=>'form-control','placeholder'=>'Enter policy number','autocomplete'=>'off','id'=>'policy_no'), set_value('policy_no',$policy_no ) );?>
                                </div>  
                                </div>
                                
                                <div class="row">
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Pollution From', 'polution_from');?>
                                    <?php echo form_input(array('name'=>'polution_from','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter pollution from date','autocomplete'=>'off','onchange'=>"filldate(this.value,'polution_till')",'data-date-format'=>$format,'data-date'=>''), set_value('polution_from',$polution_from) );?>
                                </div>
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Pollution To', 'polution_till');?>
                                    <?php echo form_input(array('name'=>'polution_till','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter pollution till date','autocomplete'=>'off','id'=>'polution_till','data-date-format'=>$format,'data-date'=>''), set_value('polution_till',$polution_till) );?>
                                </div>
                                </div>
                                
                                <div class="row">
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Insurence Payment Mode', 'payment_mode');?>
                                    <?php echo form_dropdown(array('name'=>'payment_mode', 'required'=>'required','class'=>'form-control select22','autocomplete'=>'off'),[''=>'--Select Insurence Payment Mode','Cash'=>'Cash','Online'=>'Online','Cheque'=>'Cheque'], set_value('payment_mode',$payment_mode ) );?> 
                                </div>
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Payment Date', 'payment_date');?>
                                    <?php echo form_input(array('name'=>'payment_date','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter payment date','autocomplete'=>'off','id'=>'payment_date','data-date-format'=>$format,'data-date'=>''), set_value('payment_date',$payment_date) );?>
                                </div>
                                </div>
                                
                                <div class="row">
                                <div class="form-group col-lg-6">
                                    <?php echo form_label('Payment Txn ID', 'payment_txn_id');?>
                                    <?php echo form_input(array('name'=>'payment_txn_id', 'required'=>'required','class'=>'form-control','autocomplete'=>'off','id'=>'payment_txn_id'), set_value('payment_txn_id',$payment_txn_id ) );?> 
                                </div>
                                <div class="form-group col-lg-6">
                                </div>
                                </div>
                                
                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-3" >
                                        <?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>
                                    </div>
<div class="col-md-3 pull-right">
<?php if( VIEW ==='yes'){ 
    if( $redirect == 'total' ){
        $goto = adminurl('vehicle_d_list?type='.$redirect );
    }else if( $redirect == 'ptotal' ){
        $goto = adminurl('vehicle_pending_doc_list?type='.$redirect );
    }else{
        $goto =  adminurl('vehicle_doc_expires?type='.$redirect );
    }
echo anchor( $goto ,'Go Back',array('class'=>'btn btn-warning fa fa-sign-out'));}?>
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
                
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>
        function filldate( dtval, id ){
            $('#'+id).val( dtval );
        }
        
        $(function () {
        $('.datepicker').datepicker({
        format: 'dd/mm/yyyy'
        });
        });
        
        function getCompanyName( id ){
            let companyName = $('#company_id option:selected').text();
            $('#insu_company_name').val( companyName );
        } 
   
    </script>
    
    
    
    