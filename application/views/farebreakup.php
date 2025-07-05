<div class="row "><div class="col-lg-12 col-xs-12">  <p class='ext_txt'><b class="bold">Fare Breakup</b></p></div></div>
      
    <div class="row"><div class="col-lg-5 col-xs-7"><b>Approx. Roundtrip distance </b></div><div class="col-lg-7 col-xs-5">: <?=$fare['googlekm'];?> kms </div></div>  
    <div class="row"><div class="col-lg-5 col-xs-7"><b>Minimum Charged Distance </b></div><div class="col-lg-7  col-xs-5">: <?=$fare['minkm_day'];?> Kms / Day</div></div>  
    <div class="row"><div class="col-lg-4 col-xs-6"><b>Estimated Km Charge </b></div><div class="col-lg-4 col-xs-6"> <?=$fare['estkm'];?> Kms x <?=$fare['fareperkm'];?> INR/Km </div><div class="col-lg-4 col-xs-6"> =  INR. <?=$fare['est_fare'];?> /-</div></div>
    
    <div class="row"><div class="col-lg-4 col-xs-6"><b>Driver Allowance </b></div><div class="col-lg-4 col-xs-6"> INR. <?=$fare['drivercharge'];?>/Day x <?=$fare['days'];?> Day(s)  </div><div class="col-lg-4 col-xs-6"> = INR. <?php echo $fare['drivercharge']*$fare['days'];?>  /-</div></div>
    
    <div class="row"><div class="col-lg-4 col-xs-6"><b>GST </b></div><div class="col-lg-4 col-xs-6"><?=$fare['gst'];?>% On INR. <?=$fare['est_fare'];?> </div><div class="col-lg-4 col-xs-6"> = INR. <?=$fare['gstamount'];?>  /-</div></div>
    
    <div class="row"><div class="col-lg-4 col-xs-4 bold"><b>Total Cost </b></div><div class="col-lg-4 col-xs-2"> &nbsp; </div><div class="col-lg-4 col-xs-6 bold"> = INR. <?=$fare['withgstamount'];?> /-</div></div>