<section class="bannerbg background-centered">
  <div class="container">
    <div class="row pds">
      <!---/.left offer portion start-->
      <div class="col-lg-6 col-xs-12 col-md-12 col-sm-12" id="coupnd">
        <div class="baloon">
          <div class="inner">
            <h1><span style="color: #ffffff;">&nbsp;10%</span></h1>
            <h2><span style="color: #273f44;">OFF</span></h2>
            <h4>Use Code: CAB10 / BIKE10</h4>
            <p class="stm-hidden"></p>
          </div> <i class="stm-rental-baloon_tail"></i>
        </div>
      </div>
      <!---/.left offer portion end-->

      <!---/.right portion start-->
      <div class="col-lg-6 col-xs-12 col-md-12 col-sm-12">
        <!-- Nav tabs -->
        <div class="bgyellow searchshadow">
          <div class="row">
            <div class="col-lg-12 col-xs-12">

              <ul class="nav nav-tabs" role="tablist">
                <li class="<?php if ($tab == 'selfdrive' || $tab == '') {
                              echo 'active';
                            } ?>"><a href="#SelfDrive" aria-controls="SelfDrive" role="tab" data-toggle="tab"><i class=" fa fa-map-marker"></i>&nbsp; Self Drive Car </a></li>
                <li class="<?php if ($tab == 'outstation') {
                              echo 'active';
                            } ?>"><a href="#Outstation" aria-controls="Outstation" role="tab" data-toggle="tab"><i class=" fa fa-taxi"></i>&nbsp; Taxi Service</a></li>
                <li class="<?php if ($tab == 'bike') {
                              echo 'active';
                            } ?>"><a href="#Bike" aria-controls="Bike" role="tab" data-toggle="tab"><i class=" fa fa-motorcycle"></i> Rent A Bike</a></li>
                <li class="<?php if ($tab == 'monthly') {
                              echo 'active';
                            } ?>"><a href="#Monthly" aria-controls="Monthly" role="tab" data-toggle="tab"><i class=" fa fa-map-marker"></i>&nbsp; Monthly Rental </a></li>
              </ul>

            </div>

            <div class="col-lg-12 col-xs-12 pad_sift">
              <!-- tab-content start here  -->
              <div class="tab-content">

                <div role="tabpanel" class="tab-pane <?php if ($tab == 'selfdrive' || $tab == '') {
                                                        echo 'active';
                                                      } ?>" id="SelfDrive">
                  <form action="<?php echo PEADEX; ?>reservation.html" method="get">
                    <input type="hidden" name="tabdata" value="selfdrive" />

                    <div class="row ">

                      <div class="col-md-6 col-xs-12">
                        <label>I want a Car in</label>
                        <div class="form-group">
                          <?= form_dropdown(array('name' => 'sourcecity', 'class' => 'form-control'), createDropdown($citylist, 'id', 'cityname', 'Cityname'), set_value('sourcecity', $cityname)); ?>

                        </div>
                      </div>


                      <div class="col-md-6  col-xs-12">
                        <label>For</label>
                        <div class="form-group">
                          <input type="text" id="autocity2" name="destinationCity" class="form-control" value="<?php echo $for; ?>" onFocus="geolocate();" placeholder="e.g. <?php echo $for; ?>" required autocomplete="off">
                        </div>
                      </div>
                    </div>

                    <div class="row spacer_10 ">
                      <div class="col-md-6  col-xs-6">
                        <label>Pick-up Date/Time</label>
                        <div class="form-group">
                          <?= form_input(array('name' => 'pickdatetime', 'class' => 'form-control datetimepickerbike1', 'id' => 'DatePickS', 'required' => 'required', 'placeholder' => 'Pick Up Date', 'onchange' => "putdvalue('DatePickS','DateDropS')"), set_value('pickdatetime', $pickdatetime)); ?>
                        </div>
                      </div>


                      <div class="col-md-6  col-xs-6 ">
                        <label>Drop-off Date/Time</label>
                        <div class="form-group">
                          <?= form_input(array('name' => 'dropdatetime', 'class' => 'form-control datetimepickerbike2', 'id' => 'DateDropS', 'required' => 'required', 'placeholder' => 'Drop Off Date/Time'), set_value('dropdatetime', $dropdatetime)); ?>
                        </div>
                      </div>
                    </div>

                    <div class="row ">

                      <div class="col-md-6  pull-right col-xs-12 spacer_10">
                        <button type="submit" name="searchselfdrive" class="search"> Search A Cab <i class="fa fa-arrow-right"></i> </button>
                      </div>
                    </div>
                  </form>
                </div><!-- end tab-pane -->

                <div role="tabpanel" class="tab-pane <?php if ($tab == 'outstation') {
                                                        echo 'active';
                                                      } ?>" id="Outstation">
                  <form action="<?php echo PEADEX; ?>reservation.html" method="get">
                    <input type="hidden" name="tabdata" value="outstation" />

                    <div class="row">
                      <div class="col-md-12 col-xs-12 radio">
                        <input type="radio" name="mode" value="oneway" id="1" required onClick="shownow(1)" <?php if ($ttypemulti == 'oneway'  || $ttypemulti == '') {
                                                                                                              echo 'checked';
                                                                                                            } ?>>
                        <label class="rdo" for="1">One Way </label>

                        <input type="radio" name="mode" value="roundtrip" id="2" required onClick="shownow(1)" <?php if ($ttypemulti == 'roundtrip') {
                                                                                                                  echo 'checked';
                                                                                                                } ?>>
                        <label class="rdo " for="2"> Round Trip </label>

                        <input type="radio" name="mode" value="multicity" id="3" onClick="shownow(2)" <?php if ($ttypemulti == 'multicity') {
                                                                                                        echo 'checked';
                                                                                                      } ?>>
                        <label class="rdo " for="3"> Multi City </label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6 col-xs-12">
                        <label>I want a car in</label>
                        <div class="form-group">
                          <?= form_dropdown(array('name' => 'sourcecity', 'class' => 'form-control'), createDropdown($citylist, 'id', 'cityname', 'Cityname'), set_value('sourcecity', $cityname)); ?>
                        </div>
                      </div>

                      <div class="col-md-6 col-xs-10">
                        <label>To</label>
                        <div class="form-group">
                          <?= form_input(array('name' => 'destinationCity', 'class' => 'form-control', 'id' => 'autocity1', 'required' => 'required', 'placeholder' => 'e.g. manali...', 'onFocus' => 'geolocate();', 'autocomplete' => 'off'), set_value('for', $for)); ?>

                          <div onClick="extraadd();" id="addshowbutton" style="display: none">
                            <div class="addbutton pull-left" title="Add More City">&nbsp; + </div>
                          </div>
                        </div>
                      </div>

                    </div>



                    <div class="row">
                      <div class="col-md-12 col-xs-12">
                        <span class="expandinput"></span>
                      </div>
                    </div>


                    <div class="row clearfix ">
                      <div class="col-md-6  col-xs-12">
                        <label>Travel Date</label>
                        <div class="form-group">
                          <?= form_input(array('name' => 'pickdatetime', 'class' => 'form-control width datepickerAcon', 'id' => 'picdateO', 'required' => 'required', 'placeholder' => 'Pick Up Date', 'onchange' => "putdvalue('picdateO','DateDropO')"), set_value('pickdatetime', $pickdatetime)); ?>
                        </div>
                      </div>



                      <div class="col-md-6  col-xs-6 ">
                        <label>Drop-off Date/Time</label>
                        <div class="form-group">
                          <?= form_input(array('name' => 'dropdatetime', 'class' => 'form-control datetimepickerbike2', 'id' => 'DateDropO', 'required' => 'required', 'placeholder' => 'Drop Off Date/Time'), set_value('dropdatetime', $dropdatetime)); ?>
                        </div>
                      </div>
                    </div>

                    <div class="row clearfix ">
                      <div class="col-md-6 pull-right searchbtn col-xs-12">
                        <button type="submit" name="searchAcon" class="search">Search Cab<i class="fa fa-arrow-right"></i> </button>
                      </div>
                    </div>
                  </form>


                </div><!-- end tab-pane -->

                <div role="tabpanel" class="tab-pane <?php if ($tab == 'bike') {
                                                        echo 'active';
                                                      } ?>" id="Bike">
                  <form action="<?php echo PEADEX; ?>reservation.html" method="get">
                    <input type="hidden" name="tabdata" value="bike" />

                    <div class="row ">

                      <div class="col-md-6 col-xs-12">
                        <label>I want a Bike in</label>
                        <div class="form-group">
                          <?= form_dropdown(array('name' => 'sourcecity', 'class' => 'form-control'), createDropdown($citylist, 'id', 'cityname', 'Cityname'), set_value('sourcecity', $cityname)); ?>
                        </div>
                      </div>


                      <div class="col-md-6  col-xs-12">
                        <label>For</label>
                        <div class="form-group">
                          <?= form_input(array('name' => 'destinationCity', 'class' => 'form-control', 'id' => 'autocity2', 'required' => 'required', 'placeholder' => 'e.g. manali...', 'onFocus' => 'geolocate();', 'autocomplete' => 'off'), set_value('for', $for)); ?>
                        </div>
                      </div>
                    </div>

                    <div class="row spacer_10 ">
                      <div class="col-md-6  col-xs-6">
                        <label>Pick-up Date/Time</label>
                        <div class="form-group">
                          <?= form_input(array('name' => 'pickdatetime', 'class' => 'form-control datetimepickerbike1', 'id' => 'DatePickB', 'required' => 'required', 'placeholder' => 'Pick Up Date', 'onchange' => "putdvalue('DatePickB','DateDropB')"), set_value('pickdatetime', $pickdatetime)); ?>
                        </div>
                      </div>


                      <div class="col-md-6  col-xs-6 ">
                        <label>Drop-off Date/Time</label>
                        <div class="form-group">
                          <?= form_input(array('name' => 'dropdatetime', 'class' => 'form-control datetimepickerbike2', 'id' => 'DateDropB', 'required' => 'required', 'placeholder' => 'Drop Off Date/Time'), set_value('dropdatetime', $dropdatetime)); ?>
                        </div>
                      </div>
                    </div>

                    <div class="row ">

                      <div class="col-md-6  pull-right col-xs-12 spacer_10">
                        <button type="submit" name="searchbike" class="search"> Search A Bike <i class="fa fa-arrow-right"></i> </button>
                      </div>
                    </div>
                  </form>
                </div><!-- end tab-pane -->

                <div role="tabpanel" class="tab-pane <?php if ($tab == 'monthly') {
                                                        echo 'active';
                                                      } ?>" id="Monthly">
                  <form action="<?php echo PEADEX; ?>reservation.html" method="get">
                    <input type="hidden" name="tabdata" value="monthly" />

                    <div class="row ">

                      <div class="col-md-6 col-xs-12">
                        <label>I want a Car in</label>
                        <div class="form-group">
                          <?= form_dropdown(array('name' => 'sourcecity', 'class' => 'form-control'), createDropdown($citylist, 'id', 'cityname', 'Cityname'), set_value('sourcecity', $cityname)); ?>

                        </div>
                      </div>


                      <div class="col-md-6  col-xs-12">
                        <label>For</label>
                        <div class="form-group">
                          <input type="text" id="autocity2" name="destinationCity" class="form-control" value="<?php echo $for; ?>" onFocus="geolocate();" placeholder="e.g. <?php echo $for; ?>" required autocomplete="off">
                        </div>
                      </div>
                    </div>

                    <div class="row spacer_10 ">
                      <div class="col-md-6  col-xs-6">
                        <label>Pick-up Date/Time</label>
                        <div class="form-group">
                          <?= form_input(array('name' => 'pickdatetime', 'class' => 'form-control datetimepickermonth1', 'id' => 'DatePickM', 'required' => 'required', 'placeholder' => 'Pick Up Date', 'onchange' => "checkMonthlyDate()"), set_value('pickdatetime', $pickdatetime)); ?>
                        </div>
                      </div>


                      <div class="col-md-6  col-xs-6 ">
                        <label>Drop-off Date/Time</label>
                        <div class="form-group">
                          <?= form_input(array('name' => 'dropdatetime', 'class' => 'form-control datetimepickermonth2', 'id' => 'DateDropM', 'required' => 'required', 'placeholder' => 'Drop Off Date/Time'), set_value('dropdatetime', $dropmontlydatetime)); ?>
                        </div>
                      </div>
                    </div>

                    <div class="row ">

                      <div class="col-md-6  pull-right col-xs-12 spacer_10">
                        <button type="submit" name="searchmonthly" class="search"> Search A Cab <i class="fa fa-arrow-right"></i> </button>
                      </div>
                    </div>
                  </form>
                </div><!-- end tab-pane -->


              </div>

            </div><!-- end tab-content -->
          </div>

        </div>
      </div>

      <!---right portion end-->
    </div>
  </div>
</section>