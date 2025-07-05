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
    <?php echo form_open_multipart( adminurl('Addcoupon/' )); ?>
    <?php echo form_hidden('id', $id);?>
    <?php echo form_hidden('oldimage', $couponimage );?>
    <div class="row">
        <div class="col-md-6">
            <div class="row mg_top_2">
                <div class="col-lg-12">

                    <div class="form-group">

                                    <?php echo form_label('Trip Type', 'trippackage');?>
                                    <?php echo form_dropdown(array('name'=>'trippackage','required'=>'required','class'=>'form-control'),array(''=>'Select Trip Type','outstation'=>'Outstation','selfdrive'=>'Selfdrive','bike'=>'Bike','monthly'=>'Monthly'),set_value('trippackage',$trippackage));?>
                                </div>


                                <div class="form-group">
                                    <?php echo form_label('Title Name', 'titlename');?>
                                    <?php echo form_input(array('name'=>'titlename', 'value'=>set_value('package',$titlename),'required'=>'required','class'=>'form-control','placeholder'=>'Enter title name','autocomplete'=>'off') );?>
                                </div>
                                
                                <div class="row">
                                <div class="col-md-12 form-group"> 
                                <?php echo form_label('Coupon Description :', 'cpn_description');?>
                                <?php echo form_textarea(array('name'=>'cpn_description','class'=>'form-control','placeholder'=>'coupon description....','rows'=>2,'required'=>'required'),set_value('cpn_description',$cpn_description));?>
                                </div>
                                </div>

                                <div class="form-group">
                                    <?php echo form_label('Coupon Code', 'couponcode');?>
                                    <?php echo form_input(array('name'=>'couponcode', 'value'=>set_value('couponcode',$couponcode),'required'=>'required','class'=>'form-control text-uppercase','placeholder'=>'Enter coupon code','autocomplete'=>'off') );?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('Value Type', 'valuetype');?>
                                    <?php echo form_dropdown(array('name'=>'valuetype','required'=>'required','class'=>'form-control'),array(''=>'Select Value Type','fixed'=>'Fixed','percent'=>'Percentage'),set_value('valuetype',$valuetype));?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('Coupon Value', 'cpnvalue');?>
                                    <?php echo form_input(array('name'=>'cpnvalue', 'value'=>set_value('cpnvalue',$cpnvalue),'required'=>'required','class'=>'form-control numbersOnly','placeholder'=>'Enter coupon value','autocomplete'=>'off') );?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('Minimum Amount', 'minamount');?>
                                    <?php echo form_input(array('name'=>'minamount', 'value'=>set_value('minamount',$minamount),'required'=>'required','class'=>'form-control numbersOnly','placeholder'=>'Enter Min amount','autocomplete'=>'off') );?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('Maximum Discount', 'maxdiscount');?>
                                    <?php echo form_input(array('name'=>'maxdiscount', 'value'=>set_value('maxdiscount',$maxdiscount),'required'=>'required','class'=>'form-control numbersOnly','placeholder'=>'Enter maximum discount','autocomplete'=>'off') );?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('From Date', 'validfrom');?>
                                    <?php echo form_input(array('name'=>'validfrom', 'value'=>set_value('validfrom',$validfrom),'required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter from date','autocomplete'=>'off','onchange'=>"filldate(this.value)") );?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('To Date', 'validto');?>
                                    <?php echo form_input(array('name'=>'validto', 'id'=>'validto', 'value'=>set_value('validto',$validto),'required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter end date','autocomplete'=>'off') );?>
                                </div>
                                <div class="form-group">
                                    <?php ////echo form_label('Select Coupon Image', 'couponimage');?>
                                    <?php //echo form_input(array('type'=>'file','name'=>'userfile', 'class'=>'form-control','placeholder'=>'Select coupon Image') );?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('Status', 'status');?>
                                    <?php echo form_dropdown(array('name'=>'status','required'=>'required','class'=>'form-control'),array(''=>'Select Status','yes'=>'Active','no'=>'InActive'),set_value('status',$status));?>
                                </div>
                                <div class="row" style="margin-top:10px">
                                    <div class="col-md-3" >
                                        <?php echo form_submit('mysubmit', ( !empty($id) ? 'Update' : 'Submit' ), array('class'=>'btn btn-primary') );  ?>
                                    </div>
<div class="col-md-3 pull-right">
<?php if( VIEW ==='yes'){ 
echo anchor( adminurl('Viewcoupon'),'View',array('class'=>'btn btn-primary fa fa-sign-out'));}?>
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
                    function filldate( vlk ){
                        $('#validto').val( vlk );
                    }
                </script>