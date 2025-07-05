<div class="row "><div class="col-lg-12 col-xs-12">  <p class='ext_txt'><b class="bold">Fare Breakup</b></p></div></div> 
<?php if($fare['triptype'] == 'selfdrive'){ /*echo '<pre>'; print_r($fare);*/ ?>
   <div class="row"><div class="col-lg-6 col-xs-7"><b>Minimum Charged Per Car </b></div><div class="col-lg-6  col-xs-5">: <?php echo $fare['basefare'];?> INR / Car</div></div>   
   <div class="row"><div class="col-lg-4 col-xs-6"><b>Estimated Charge </b></div><div class="col-lg-5 col-xs-6"> <?php echo $fare['basefare'];?> INR x <?php echo $fare['days']; ?> Day(s) </div><div class="col-lg-3 col-xs-6"> =  INR. <?php echo $fare['est_fare'];?> /-</div></div>
    
    <div class="row"><div class="col-lg-5 col-xs-6"><b>GST </b></div><div class="col-lg-4 col-xs-6"><?php echo ($fare['gst']);?>% On INR. <?php echo $fare['est_fare'];?> </div><div class="col-lg-3 col-xs-6"> = INR. <?php echo $fare['gstamount'];?>  /-</div></div>
    <div class="row"><div class="col-lg-5 col-xs-4"><b class="bold">Total Cost </b></div><div class="col-lg-4 col-xs-2"> &nbsp; </div><div class="col-lg-3 col-xs-6 bold"> = INR. <?php echo $fare['withgstamount'];?> /-</div></div> 
<?php }?> 