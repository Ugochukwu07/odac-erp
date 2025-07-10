<?php defined('BASEPATH') or exit('No direct script access allowed');  ?>

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
          <?php echo form_open_multipart($posturl); ?>
          <input type="hidden" id="c_uid" name="c_uid" value="<?= $c_uid; ?>">
          <div class="row ">
            <div class="col-lg-6">
              <?php echo form_label('Customer Mobile', 'c_mobile'); ?>
              <?php echo form_input(array('name' => 'c_mobile', 'required' => 'required', 'class' => 'form-control numbersOnly', 'placeholder' => 'Enter 10 digit Mobile Number', 'maxlength' => '10', 'onkeyup' => 'fetch(this.value);', 'autocomplete' => 'off'), set_value('c_mobile', $c_mobile)); ?>
            </div>
          </div>


          <div class="row mg_top_1">
            <div class="col-lg-6">
              <?php echo form_label('Customer Name', 'c_name'); ?>
              <?php echo form_input(array('name' => 'c_name', 'required' => 'required', 'class' => 'form-control capital', 'placeholder' => 'Enter Customer Name', 'id' => 'c_name', 'autocomplete' => 'off'), set_value('c_name', $c_name)); ?>
            </div>
          </div>


          <div class="row mg_top_1">
            <div class="col-lg-6">
              <?php echo form_label('Customer Email', 'c_email'); ?>
              <?php echo form_input(array('name' => 'c_email', 'required' => 'required', 'class' => 'form-control small', 'placeholder' => 'Enter email address', 'id' => 'c_email', 'autocomplete' => 'off'), set_value('c_email', $c_email)); ?>
            </div>
          </div>

          <div class="row mg_top_1">
            <div class="col-lg-6">
              <?php echo form_label('Address', 'c_address'); ?>
              <?php echo form_textarea(array('name' => 'c_address', 'class' => 'form-control', 'placeholder' => 'Enter address', 'id' => 'c_address', 'rows' => '3'), set_value('c_address', '')) ?>
            </div>
          </div>


          <div class="row mg_top_1">
            <div class="col-lg-3">
              <?php echo form_label('Trip Type', 'c_trip'); ?>
              <?php echo form_dropdown(array('name' => 'c_trip', 'required' => 'required', 'class' => 'form-control select2'), ['' => '-- Select Trip Type-- ', 'bike' => 'Bike Rental', 'outstation' => 'Outstaion', 'selfdrive' => 'Self Drive', 'monthly' => 'Monthly Rental'], set_value('c_trip', $c_trip)); ?>
            </div>
            <div class="col-lg-3">
              <?php echo form_label('Payment Mode', 'c_paymode'); ?>
              <?php echo form_dropdown(array('name' => 'c_paymode', 'class' => 'form-control select2', 'autocomplete' => 'off'), get_dropdownsmulti('paymode_list', array('status' => 'Active'), 'paymode', 'mode_text_value', ' Paymode--'), set_value('c_paymode', $c_paymode)); ?>
            </div>
          </div>

          <div class="row mg_top_1">
            <div class="col-lg-6">
              <?php echo form_label('Transaction/Payment ID', 'c_ad_amount'); ?>
              <?php echo form_input(array('name' => 'c_txn_id', 'class' => 'form-control numbersOnly', 'placeholder' => 'Enter payment transaction ID', 'id' => 'c_txn_id', 'autocomplete' => 'off'), set_value('c_txn_id', $c_txn_id)); ?>
            </div>
          </div>


          <div class="row mg_top_1">
            <div class="col-lg-3">
              <?php echo form_label('Booking Amount', 'c_ad_amount'); ?>
              <?php echo form_input(array('name' => 'c_ad_amount', 'required' => 'required', 'class' => 'form-control numbersOnly', 'placeholder' => 'Enter booking amount', 'id' => 'c_ad_amount', 'autocomplete' => 'off'), set_value('c_ad_amount', $c_ad_amount)); ?>
            </div>

            <div class="col-lg-3">
              <?php echo form_label('Discount Offer', 'c_discount'); ?>
              <?php echo form_input(array('name' => 'c_discount', 'required' => 'required', 'class' => 'form-control numbersOnly', 'placeholder' => 'Enter discount', 'id' => 'c_discount', 'autocomplete' => 'off'), set_value('c_discount', $c_discount)); ?>
            </div>
          </div>




          <div class="row" style="margin-top:30px">
            <div class="col-md-3">
              <input type="submit" class="btn btn-primary" name="mysubmit" value="Submit" id="submitbtn" onclick="checkTxnId()">
            </div>
            <div class="col-md-3">
              <?php echo anchor(adminurl('makebooking/reset'), 'Reset Data', array('class' => 'btn btn-danger')); ?>
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
</section>


<script type="text/javascript">
  function fetch(val) {
    if (val.length == 10) {
      $.ajax({
        'type': 'POST',
        'url': '<?= adminurl('makebooking/getdetails') ?>',
        'data': {
          'mobileno': val
        },
        'cache': false,
        'success': function(res) {
          var obj = JSON.parse(res);
          $('#c_email').val(obj.emailid);
          $('#c_name').val(obj.fullname);
          $('#c_uid').val(obj.id);
        }
      });
    }
  }
</script>