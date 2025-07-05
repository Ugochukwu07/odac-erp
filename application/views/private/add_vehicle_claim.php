<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<?php $format = 'dd-mm-yyyy';?>
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?=goToDashboard();?>
                </div>
                <!-- /.box-header -->
<div class="box-body">
    <?php echo form_open_multipart( adminurl('Vehicle_claim/savedata' )); ?>
    <?php echo form_hidden('id', $id);?> 
    <?php echo form_hidden('redirect', $redirect );?> 
    <?php echo form_hidden('company_id', $company_id );?> 
    <?php echo form_hidden('insu_company_name', $insu_company_name );?> 
    <div class="row">
        <div class="col-md-12">
            <div class="row mg_top_2">
                <div class="col-lg-12">

                                <div class="row">
                                <div class="form-group col-lg-4"> 
                                    <?php echo form_label('Vehicle Number', 'vehicle_con_id');?>
                                    <?php echo form_dropdown(array('name'=>'vehicle_con_id','required'=>'required','class'=>'form-control select22' ,'id'=>'vehicle_con_id','onchange'=>"getPolicyNo()"),$vehiclelist,set_value('vehicle_con_id',$vehicle_con_id));?>
                                </div>
                        
                                <div class="form-group col-lg-4">
                                    <?php echo form_label('Claim Date', 'claim_date');?>
                                    <?php echo form_input(array('name'=>'claim_date','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter claim date','autocomplete'=>'off','data-date-format'=>$format,'data-date'=>''), set_value('claim_date',$claim_date) );?>
                                </div>
                                <div class="form-group col-lg-4">
                                    <?php echo form_label('Claim Amount', 'amount');?>
                                    <?php echo form_input(array('name'=>'amount','required'=>'required','class'=>'form-control numbersOnly','placeholder'=>'Enter claim amount','autocomplete'=>'off','id'=>'amount'), set_value('amount',$amount) );?>
                                </div> 
                                </div> 
                                
                                
                                 <div class="row">
                                <div class="form-group col-lg-4"> 
                                    <?php echo form_label('Policy Number', 'policy_no');?>
                                    <?php echo form_input(array('name'=>'policy_no','required'=>'required','class'=>'form-control','id'=>'policy_no'),set_value('policy_no',$policy_no));?>
                                <span style="font=size:12px;color:red" ><?=$insu_company_name ?></span>
                                </div>
                        
                                <div class="form-group col-lg-4">
                                    <?php echo form_label('Policy Valid From', 'policy_valid_from');?>
                                    <?php echo form_input(array('name'=>'policy_valid_from','id'=>'policy_valid_from','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter policy valid from','autocomplete'=>'off','data-date-format'=>$format,'data-date'=>'','onchange'=>"filldate( this.value, 'policy_valid_till')"), set_value('policy_valid_from',$policy_valid_from ) );?>
                                </div>
                                
                                <div class="form-group col-lg-4">
                                    <?php echo form_label('Policy Valid Till', 'policy_valid_till');?>
                                    <?php echo form_input(array('name'=>'policy_valid_till','id'=>'policy_valid_till','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter policy valid till','autocomplete'=>'off','data-date-format'=>$format,'data-date'=>''), set_value('policy_valid_till',$policy_valid_till ) );?>
                                </div>
                                
                                </div> 
                                
                                
                                
                                <div class="row">  
                                <div class="form-group col-lg-4">
                                    <?php echo form_label('Claim Sequence', 'claim_sequence');?>
                                    <?php echo form_input(array('name'=>'claim_sequence','required'=>'required','class'=>'form-control numbersOnly','placeholder'=>'Enter claim sequence','autocomplete'=>'off','id'=>'claim_sequence'), set_value('claim_sequence',$claim_sequence) );?>
                                </div>
                                
                               
                                <div class="form-group col-lg-4">
                                    <?php echo form_label('Is Claim Cleared', 'claim_cleared');?>
                                    <?php echo form_dropdown(array('name'=>'claim_cleared','required'=>'required','class'=>'form-control select22','id'=>'claim_cleared'),['no'=>'No','yes'=>'Yes'], set_value('claim_cleared',$claim_cleared) );?>
                                </div>
                                
                                <div class="form-group col-lg-4">
                                    <?php echo form_label('Clear Claim Date', 'clear_claim_date');?>
                                    <?php echo form_input(array('name'=>'clear_claim_date','rows'=>'2','class'=>'form-control datepicker','placeholder'=>'Enter claim clear date','autocomplete'=>'off','data-date-format'=>$format,'data-date'=>''), set_value('clear_claim_date',$clear_claim_date) );?>
                                </div> 
                                
                                </div> 
                                
                                <div class="row">
                                <div class="form-group col-lg-12">
                                    <?php echo form_label('Claim Details', 'claim_details');?>
                                    <?php echo form_textarea(array('name'=>'claim_details','class'=>'form-control','placeholder'=>'Enter claim details','autocomplete'=>'off','id'=>'claim_details'), set_value('claim_details',$claim_details) );?>
                                </div>
                                 
                                </div> 
                                  
                                 
                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-3" >
                                        <?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>
                                    </div>
<div class="col-md-3 pull-right">
<?php if( VIEW ==='yes'){ 
echo anchor( adminurl('Vehicle_claim/list?type='.$redirect ),'Go Back',array('class'=>'btn btn-warning fa fa-sign-out'));}?>
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
                            
                        function getPolicyNo(){
                            let vehiclConId = $('#vehicle_con_id').val();  
                            let id = '<?=$id?>';
                            if( id === '' && vehiclConId ){
                            window.location.href='<?=adminurl('vehicle_claim?redirect='.$redirect)?>&vehicle_con_id='+vehiclConId;
                            }
                        }    
                            
                    </script>