<div class="panel panel-default">
<div class="panel-heading"><span>Your Rental Details</span></div>
<div class="panel-body searchRentals">
<div class="locationView clearfix">
<p class="bold caps">Pickup Location</p>
<div class="sc-clear-5"></div>
<i class="sc-icon locationPoint"></i>
<div class="locNameInc">
<p><?php echo $cityhead;?></p>
<span>
<i class="sc-icon startDateInc"></i>
<small><?php echo date('M d, Y',strtotime($sessionpickdate));?></small>
</span>
<span>
<i class="sc-icon timeInc"></i>
<small><?php echo $sessionpicktime;?></small>
</span>
</div>
</div>
<hr class="dark cleafix">

<div class="locationView clearfix">
<p class="bold caps">Drop-Off Location</p>
<div class="sc-clear-5"></div>
<i class="sc-icon locationPoint"></i>
<div class="locNameInc">
<p><?php echo $_SESSION['destination'];?></p>
<span>
<i class="sc-icon startDateInc"></i>
<small><?php echo date('M d, Y',strtotime($sessiondropdate));?></small>
</span>
<span>
<i class="sc-icon timeInc"></i>
<small><?php echo $sessiondroptime;?></small>
</span>
</div>
</div>

<div class="sc-clear-30"></div>
<button class="subMitBtnInc editDetail" onclick="window.location.href='<?php echo PEADEX;?>'">
<i class="sc-icon editI"></i>
<span>Edit Details</span>
</button>
</div>


</div>
