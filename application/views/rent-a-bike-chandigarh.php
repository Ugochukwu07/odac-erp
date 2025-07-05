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
             <div class="stm_top clearfix"><div class="stm_left heading-font" onClick="gotopage('<?php echo $gotourl;?>');" ><h3 class="titlh"><?=$bikedata['modelname']; ?> </h3>
              <?php if($bikedata['secu_amount'] > 0 ){?><div class="s_title">Deposit Amt: ₹ <?php echo round($bikedata['secu_amount']);?></div><?php }?>
              <div class="price"> 
             <span class="woocommerce-Price-amount amount">
             <span class="woocommerce-Price-currencySymbol"><i class="fa fa-rupee"></i></span> <?=round($bikedata['basefare']);?></span>/day + GST</div></div>
             <div class="stm_right">
             <div class="single_info stm_single_info_font_stm-rental-seats"> <span class="seat"> </span>&nbsp;<span> <?=$bikedata['seatsegment'];?> Seats</span></div>
             <div class="single_info stm_single_info_font_stm-rental-door"> <span><i class="fa fa-calendar year"> </i> </span>&nbsp; <span  class="mglr"> <?=$bikedata['modelyear'];?>  </span></div>      
             <div class="single_info stm_single_info_font_stm-rental-door"> <span class="fuelType"> </span>&nbsp; <span><?=$bikedata['fueltype'];?></span></div>
             <div class="single_info stm_single_info_font_stm-rental-door" onClick="showTerms('5');"> <span class="termmaual"> </span>&nbsp; <span>Terms</span></div>
            
             </div></div>
             <div class="stm_image" onClick="gotopage('<?php echo $gotourl;?>');"> <img src="<?=$bikedata['image'];?>" class="img-responsive" alt="" ></div> </a></div>
            </div>
             <?php $i++;} }?> 
        </div>
  </div>
</section>

    <script>
    function showTerms(id){  
	    
		 if(id==5){
			<?php// $data = termsConSeacrEngine($con,'5');?> 
		 }else{
			<?php // $data = termsConSeacrEngine($con,'3');?>  
		 }
		 $('#msgHTML').html('<?php //echo $data; ?>'); $('#msgerror').modal('show'); 
		  gototop('sticky');
		
		}
    </script> 
</body></html>
