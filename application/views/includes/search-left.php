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
<small><?php echo date('M d, Y',strtotime($sessiondate));?></small>
</span>
<span>
<i class="sc-icon timeInc"></i>
<small><?php echo $sessiontime;?></small>
</span>
</div>
</div>
<hr class="dark cleafix">
<?php if($tab==3){?>
<div class="locationView clearfix">
<p class="bold caps">Drop-Off Location</p>
<div class="sc-clear-5"></div>
<i class="sc-icon locationPoint"></i>
<div class="locNameInc">
<p><?php echo $_SESSION['destination'];?></p>
<span>
<i class="sc-icon startDateInc"></i>
<small><?php echo $OuttripMode;?></small>
</span>
<span>
<i class="sc-icon timeInc"></i>
<small><?php echo $dayshow;?> Days</small>
</span>
</div>
</div>
<?php } else if($tab==2){?>
<div class="locationView clearfix">
<p class="bold caps">Local Package</p>
<div class="sc-clear-5"></div>
<i class="sc-icon locationPoint"></i>
<div class="locNameInc">
<p><?php echo $local;?></p>
<span>
<i class="sc-icon startDateInc"></i>
<small>Min Km <?php echo $minkm;?></small>
</span>
<span>
<i class="sc-icon timeInc"></i>
<small><?php echo $minhours;?> Hours</small>
</span>
</div>
</div>
<?php }?>

<div class="sc-clear-30"></div>
<button class="subMitBtnInc editDetail" onclick="window.location.href='<?php echo PEADEX;?>'">
<i class="sc-icon editI"></i>
<span>Edit Details</span>
</button>
</div>


</div>
