<?php defined('BASEPATH') or exit('No direct script access allowed');  ?>

<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-7 mx-auto my-auto">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header text-center with-border border-bottom">
          <h3 class="box-title">Make Booking - <?php echo ucfirst($tab); ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body w-full">

          <?php if ($tab == 'selfdrive' || $tab == ''): ?>
            <!-- Self Drive Car Form -->
            <?php echo form_open_multipart(adminurl('makebooking/reservation'), ['method' => 'get'] ); ?>
            <input type="hidden" name="tabdata" value="selfdrive" />

            <div class="row">
              <div class="col-md-6 mt-3 col-xs-12">
                <label>I want a Car in</label>
                <div class="form-group">
                  <?= form_dropdown(array('name' => 'sourcecity', 'class' => 'form-control'), createDropdown($citylist, 'id', 'cityname', 'Cityname'), set_value('sourcecity', $cityname)); ?>
                </div>
              </div>
              <div class="col-md-6 mt-3 col-xs-12">
                <label>For</label>
                <div class="form-group">
                  <input type="text" id="autocity2" name="destinationCity" class="form-control" value="<?php echo $destinationCity; ?>" onFocus="geolocate();" placeholder="e.g. Chandigarh" required autocomplete="off">
                </div>
              </div>
            </div>

            <div class="row spacer_10">
              <div class="col-md-6 mt-3 col-xs-6">
                <label>Pick-up Date/Time</label>
                <div class="form-group">
                  <input type="datetime-local" name="pickdatetime" class="form-control" id="DatePickS" required placeholder="Pick Up Date" value="<?= $pickdatetime; ?>">
                </div>
              </div>
              <div class="col-md-6 mt-3 col-xs-6">
                <label>Drop-off Date/Time</label>
                <div class="form-group">
                  <input type="datetime-local" name="dropdatetime" class="form-control" id="DateDropS" required placeholder="Drop Off Date/Time" value="<?= $dropdatetime; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <input type="submit" class="btn btn-primary" name="searchselfdrive" value="Search A Cab" id="submitbtn">
              </div>
              <div class="col-md-6 mt-3 text-end">
                <?php echo anchor(adminurl('makebooking/reset'), 'Reset Data', array('class' => 'btn btn-danger')); ?>
              </div>
            </div>
            <?php echo form_close(); ?>

          <?php elseif ($tab == 'outstation'): ?>
            <!-- Outstation/Taxi Service Form -->
            <?php echo form_open_multipart(adminurl('makebooking/reservation'), ['method' => 'get']); ?>
            <input type="hidden" name="tabdata" value="outstation" />

            <div class="row my-4">
              <div class="col-md-4 col-xs-12 radio">
                <input type="radio" name="mode" value="oneway" id="1" required onClick="shownow(1)" checked>
                <label class="rdo" for="1">One Way </label>
              </div>

              <div class="col-md-4 col-xs-12 radio">
                <input type="radio" name="mode" value="roundtrip" id="2" required onClick="shownow(1)">
                <label class="rdo " for="2"> Round Trip </label>
              </div>

              <div class="col-md-4 col-xs-12 radio">
                <input type="radio" name="mode" value="multicity" id="3" onClick="shownow(2)">
                <label class="rdo " for="3"> Multi City </label>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mt-3 col-xs-12">
                <label>I want a car in</label>
                <div class="form-group">
                  <?= form_dropdown(array('name' => 'sourcecity', 'class' => 'form-control'), createDropdown($citylist, 'id', 'cityname', 'Cityname'), set_value('sourcecity', $cityname)); ?>
                </div>
              </div>
              <div class="col-md-6 mt-3 col-xs-10">
                <label>To</label>
                <div class="form-group">
                  <?= form_input(array('name' => 'destinationCity', 'class' => 'form-control', 'id' => 'autocity1', 'required' => 'required', 'placeholder' => 'e.g. manali...', 'onFocus' => 'geolocate();', 'autocomplete' => 'off'), set_value('destinationCity', $destinationCity)); ?>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mt-3 col-xs-12">
                <label>Travel Date</label>
                <div class="form-group">
                  <input type="datetime-local" name="pickdatetime" class="form-control" id="DatePickS" required placeholder="Pick Up Date" value="<?= $pickdatetime; ?>">
                </div>
              </div>
              <div class="col-md-6 mt-3 col-xs-6">
                <label>Drop-off Date/Time</label>
                <div class="form-group">
                  <input type="datetime-local" name="dropdatetime" class="form-control" id="DateDropS" required placeholder="Drop Off Date/Time" value="<?= $dropdatetime ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <input type="submit" class="btn btn-primary" name="searchAcon" value="Search Cab" id="submitbtn">
              </div>
              <div class="col-md-6 mt-3 text-end">
                <?php echo anchor(adminurl('makebooking/reset'), 'Reset Data', array('class' => 'btn btn-danger')); ?>
              </div>
            </div>
            <?php echo form_close(); ?>

          <?php elseif ($tab == 'bike'): ?>
            <!-- Bike Rental Form -->
            <?php echo form_open_multipart(adminurl('makebooking/reservation'), ['method' => 'get']); ?>
            <input type="hidden" name="tabdata" value="bike" />

            <div class="row">
              <div class="col-md-6 mt-3 col-xs-12">
                <label>I want a Bike in</label>
                <div class="form-group">
                  <?= form_dropdown(array('name' => 'sourcecity', 'class' => 'form-control'), createDropdown($citylist, 'id', 'cityname', 'Cityname'), set_value('sourcecity', $cityname)); ?>
                </div>
              </div>
              <div class="col-md-6 mt-3 col-xs-12">
                <label>For</label>
                <div class="form-group">
                  <?= form_input(array('name' => 'destinationCity', 'class' => 'form-control', 'id' => 'autocity2', 'required' => 'required', 'placeholder' => 'e.g. manali...', 'onFocus' => 'geolocate();', 'autocomplete' => 'off'), set_value('destinationCity', $destinationCity)); ?>
                </div>
              </div>
            </div>

            <div class="row spacer_10">
              <div class="col-md-6 mt-3 col-xs-6">
                <label>Pick-up Date/Time</label>
                <div class="form-group">
                  <input type="datetime-local" name="pickdatetime" class="form-control" id="DatePickB" required placeholder="Pick Up Date" value="<?= $pickdatetime; ?>">
                </div>
              </div>
              <div class="col-md-6 mt-3 col-xs-6">
                <label>Drop-off Date/Time</label>
                <div class="form-group">
                  <input type="datetime-local" name="dropdatetime" class="form-control" id="DateDropB" required placeholder="Drop Off Date/Time" value="<?= $dropdatetime; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <input type="submit" class="btn btn-primary" name="searchbike" value="Search A Bike" id="submitbtn">
              </div>
              <div class="col-md-6 mt-3 text-end">
                <?php echo anchor(adminurl('makebooking/reset'), 'Reset Data', array('class' => 'btn btn-danger')); ?>
              </div>
            </div>
            <?php echo form_close(); ?>

          <?php elseif ($tab == 'monthly'): ?>
            <!-- Monthly Rental Form -->
            <?php echo form_open_multipart(adminurl('makebooking/reservation'), ['method' => 'get']); ?>
            <input type="hidden" name="tabdata" value="monthly" />

            <div class="row">
              <div class="col-md-6 mt-3 col-xs-12">
                <label>I want a Car in</label>
                <div class="form-group">
                  <?= form_dropdown(array('name' => 'sourcecity', 'class' => 'form-control'), createDropdown($citylist, 'id', 'cityname', 'Cityname'), set_value('sourcecity', $cityname)); ?>
                </div>
              </div>
              <div class="col-md-6 mt-3 col-xs-12">
                <label>For</label>
                <div class="form-group">
                  <input type="text" id="autocity2" name="destinationCity" class="form-control" value="<?php echo $destinationCity; ?>" onFocus="geolocate();" placeholder="e.g. Chandigarh" required autocomplete="off">
                </div>
              </div>
            </div>

            <div class="row spacer_10">
              <div class="col-md-6 mt-3 col-xs-6">
                <label>Pick-up Date/Time</label>
                <div class="form-group">
                  <input type="datetime-local" name="pickdatetime" class="form-control" id="DatePickM" required placeholder="Pick Up Date" value="<?= $pickdatetime; ?>">
                </div>
              </div>
              <div class="col-md-6 mt-3 col-xs-6">
                <label>Drop-off Date/Time</label>
                <div class="form-group">
                  <input type="datetime-local" name="dropdatetime" class="form-control" id="DateDropM" required placeholder="Drop Off Date/Time" value="<?= $dropmontlydatetime; ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <input type="submit" class="btn btn-primary" name="searchmonthly" value="Search A Cab" id="submitbtn">
              </div>
              <div class="col-md-6 mt-3 text-end">
                <?php echo anchor(adminurl('makebooking/reset'), 'Reset Data', array('class' => 'btn btn-danger')); ?>
              </div>
            </div>
            <?php echo form_close(); ?>

          <?php else: ?>
            <!-- Default Form (if no tab specified) -->
            <?php echo form_open_multipart(adminurl('makebooking/reservation'), ['method' => 'get']); ?>
            <div class="row">
              <div class="col-lg-6 mb-3">
                <?php echo form_label('I want a Car in', 'cityname'); ?>
                <?php echo form_dropdown(array('name' => 'cityname', 'class' => 'form-control select2', 'autocomplete' => 'off'), createDropdown($citylist, 'id', 'cityname', 'Cityname'), set_value('cityname', $cityname)); ?>
              </div>
              <div class="col-lg-6 mb-3">
                <?php echo form_label('For', 'destinationCity'); ?>
                <?php echo form_input(array('name' => 'destinationCity', 'required' => 'required', 'class' => 'form-control', 'placeholder' => 'Eg. Chandigarh', 'maxlength' => '40', 'autocomplete' => 'off'), set_value('destinationCity', $destinationCity)); ?>
              </div>
            </div>
            <div class="row" style="margin-top:30px">
              <div class="col-md-6">
                <input type="submit" class="btn btn-primary" name="mysubmit" value="Submit" id="submitbtn" onclick="checkTxnId()">
              </div>
              <div class="col-md-6 mt-3 text-end">
                <?php echo anchor(adminurl('makebooking/reset'), 'Reset Data', array('class' => 'btn btn-danger')); ?>
              </div>
            </div>
            <?php echo form_close(); ?>
          <?php endif; ?>

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

  function shownow(val) {
    // Function for handling radio button changes in outstation form
    if (val == 1) {
      // Handle one way and round trip
    } else if (val == 2) {
      // Handle multi city
    }
  }

  function geolocate() {
    // Function for geolocation (placeholder)
  }

  function putdvalue(pickId, dropId) {
    // Function to set drop date based on pick date
    var pickDate = $('#' + pickId).val();
    if (pickDate) {
      // Add logic to set drop date
    }
  }

  function checkMonthlyDate() {
    // Function to check monthly date validation
    var pickDate = $('#DatePickM').val();
    if (pickDate) {
      // Add logic for monthly date validation
    }
  }
</script>