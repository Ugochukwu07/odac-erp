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
                    <a href="<?php echo adminurl('view_company');?>" class="btn btn-sm btn-succaess"><i class="fa fa-plus"></i> View </a>  
                    </div>
                </div>
                <!-- /.box-header -->
<div class="box-body">
    <?php echo form_open_multipart( $posturl ); ?>
    <?php echo form_hidden('id', $id);?> 
    <div class="row">
        <div class="col-md-7">
            <div class="row mg_top_2">
                <div class="col-lg-12" style="border: 2px solid #111111; margin-left: 20px; padding: 20px;">

                                <div class="row">
                                <div class="form-group col-lg-12"> 
                                    <?php echo form_label('Company Name', 'company_name');?>
                                    <?php echo form_input(array('name'=>'company_name','required'=>'required','class'=>'form-control','id'=>'company_name'), set_value('company_name',$company_name ) );?>
                                </div>
                                </div> 
                               
                                
                                <div class="form-group">
                                     <?php echo form_label('Status', 'status');?>
                                     <?php echo form_dropdown( array('name'=>'status','required'=>'required','class'=>'form-control'), array(''=>'---Select Status---','Active'=>'Active','Inactive'=>'InActive'),set_value('status',$status));?> 
                                </div> 
                                
                                
                            <div class="row" style="margin-top:10px">
                            <div class="col-md-3" >
                                <?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>
                            </div>
                            <div class="col-md-3 pull-right">
                            <?php if( VIEW ==='yes'){ echo anchor( adminurl('view_company') ,'Go Back',array('class'=>'btn btn-warning fa fa-sign-out'));}?>
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
   
    </script>