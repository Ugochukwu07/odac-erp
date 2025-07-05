<section class="vehiclebg vehiclefixed">
  <div class="container">
        <h2 class="vehicle">Bike Rental In Chandigarh</h2>
        <div class="row">
        <?php  if(!empty($bikelist)){ $i = 1;
         foreach ($bikelist as $key => $bikedata) { 
         $gotourl = 'booking-details-vehicle-bike.php?id='.base64_encode($bikedata['modelid']); ?>
            <div class="col-lg-3 col-xs-12 col-md-3 col-sm-12 spacer20">
             <div class="stm_product_grid_single"> 
             <a href="javascript:void(0)" class="inner">
             <div class="stm_top clearfix"><div class="stm_left heading-font" onClick="gotopage('<?php echo $gotourl;?>');" ><h3 class="titlh"><?php echo $bikedata['modelname']; ?> </h3>
             <?php if($bikedata['secu_amount'] > 0 ){?><div class="s_title">Deposit Amt: ₹ <?php echo round($bikedata['secu_amount']);?></div><?php }?><div class="price">   
             <span class="woocommerce-Price-amount amount">
             <span class="woocommerce-Price-currencySymbol"><i class="fa fa-rupee"></i></span> <?php echo round($bikedata['basefare']); ?></span>/day+GST</div></div>
             <div class="stm_right">
             <div class="single_info stm_single_info_font_stm-rental-seats"> <span class="seat"> </span>&nbsp;<span> <?php echo $bikedata['seatsegment']; ?> Seats</span></div>
             <div class="single_info stm_single_info_font_stm-rental-door"> <span><i class="fa fa-calendar year"> </i></span>&nbsp; <span class="mglr"> <?=$bikedata['modelyear']; ?></span></div>      
             <div class="single_info stm_single_info_font_stm-rental-door"> <span class="fuelType"> </span>&nbsp; <span><?=$bikedata['fueltype']; ?></span></div>
             <div class="single_info stm_single_info_font_stm-rental-door" onClick="showTerms('5');"> <span class="termmaual"> </span>&nbsp; <span>Terms</span></div>
            
             </div></div>
             <div class="stm_image" onClick="gotopage('<?php echo $gotourl;?>');"> <img src="<?php echo $bikedata['image'];?>" class="img-responsive" alt="" ></div> </a></div>
            </div>
             <?php $i++;} }?> 
        </div>
  </div>
</section>


<section class="vehiclebg vehiclefixed" style="margin-top: -35px">
  <div class="container">
        <h2 class="vehicle">Self Drive Car Rental In Chandigarh</h2>
          <div class="row">
        <?php if(!empty($selfdrivelist)){ $j = 1;
        foreach ($selfdrivelist as $key => $cardata) {  
            $gotourl = 'booking-details-vehicle-bike.php?id='.base64_encode($cardata['modelid']); ?>
            <div class="col-lg-3 col-xs-12 col-md-3 spacer20" >
             <div class="stm_product_grid_single"> 
             <a href="javascript:void(0)<?php //echo  $gotourl;?>" class="inner">
             <div class="stm_top clearfix"><div class="stm_left heading-font"><h3 class="titlh" onClick="gotopage('<?php echo $gotourl;?>');"><?=$cardata['modelname']; ?> </h3>
             <?php if($cardata['secu_amount'] > 0 ){?><div class="s_title">Deposit Amt: ₹ <?php echo round($cardata['secu_amount']);?></div><?php }?>
             <div class="price">
             <span class="woocommerce-Price-amount amount"  onClick="gotopage('<?php echo $gotourl;?>');"><i class="fa fa-rupee"></i> <?=round($cardata['basefare']).' / Day+GST';?></span></div></div>
             <div class="stm_right">
             <div class="single_info stm_single_info_font_stm-rental-seats"><span class="seat"> </span>&nbsp; <span><?=$cardata['seatsegment'];?> Seats</span></div>
             <div class="single_info stm_single_info_font_stm-rental-door"> <span><i class="fa fa-calendar year"> </i> </span>&nbsp; <span  class="mglr"><?=$cardata['modelyear'];?></span></div>      
             <div class="single_info stm_single_info_font_stm-rental-door"> <span class="fuelType"> </span>&nbsp; <span><?=$cardata['fueltype'];?></span></div>
              <div class="single_info stm_single_info_font_stm-rental-door" onClick="showTerms('5');"> <span class="termmaual"> </span>&nbsp; <span >Terms</span></div>
             </div></div>
             <div class="stm_image" onClick="gotopage('<?php echo $gotourl;?>');"> <img src="<?=$cardata['image'];?>" class="img-responsive wp-post-manual" alt=""></div> </a></div>
            </div>
             <?php $j++;} }?> 
        </div>
  </div>
</section>
