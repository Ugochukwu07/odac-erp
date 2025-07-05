<div class="row "><div class="col-lg-12 col-xs-12">  <p class='ext_txt'><b class="bold">Fare Breakup</b></p></div></div> 
 
   <div class="row"><div class="col-lg-6 col-xs-7"><b>Minimum Charged Per Bike </b></div><div class="col-lg-6  col-xs-5">: <?=$fare['basefare'];?> INR / Bike</div></div>   
   <div class="row"><div class="col-lg-4 col-xs-6"><b>Estimated Charge </b></div><div class="col-lg-5 col-xs-6"> <?=$fare['basefare'];?> INR x 1 Bike(s) x <?=$fare['days'];?> Day(s) </div><div class="col-lg-3 col-xs-6"> =  INR. <?=$fare['est_fare'];?> /-</div></div>
    
    <div class="row"><div class="col-lg-5 col-xs-6"><b>GST </b></div><div class="col-lg-4 col-xs-6"><?=$fare['gst'];?>% On INR. <?=$fare['est_fare'];?> </div><div class="col-lg-3 col-xs-6"> = INR. <?=$fare['gstamount'];?>  /-</div></div>
    
    <div class="row"><div class="col-lg-5 col-xs-4"><b class="bold">Total Cost </b></div><div class="col-lg-4 col-xs-2"> &nbsp; </div><div class="col-lg-3 col-xs-6 bold"> = INR. <?=$fare['withgstamount'];?> /-</div></div>
   