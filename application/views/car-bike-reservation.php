<section class="vehiclebg vehiclefixed">
  <div class="container">
        <h2 class="vehicle">Car Rental In Chandigarh</h2>
        <div class="row">
        <?php  if(!empty($carlist)){ $i = 1;
         foreach ($carlist as $key => $cardata) { 
         $gotourl = 'booking-details-vehicle-bike.php?id='.base64_encode($cardata['modelid']); ?>
            <div class="col-lg-3 col-xs-12 col-md-3 spacer20"  onClick="gotopage('<?php echo $gotourl;?>');">
             <div class="stm_product_grid_single" > 
             <a href="javascript:void(0)" class="inner">
             <div class="stm_top clearfix"><div class="stm_left heading-font"><h3 class="titlh"><?=$cardata['modelname'];?> </h3>
             <div class="price">
             <span class="woocommerce-Price-amount amount"  onClick="gotopage('<?php echo $gotourl;?>');" ><i class="fa fa-rupee"></i> <?=(int)$cardata['fareperkm'];?> / KM &nbsp;</span></div></div>
             <div class="stm_right">
             <div class="single_info stm_single_info_font_stm-rental-seats"><span class="seat"> </span>&nbsp; <span><?=$cardata['seatsegment'];?> Seats</span></div>
            <div class="single_info stm_single_info_font_stm-rental-door"> <span><i class="fa fa-calendar year"> </i> </span>&nbsp; <span  class="mglr"><?=$cardata['modelyear'];?></span></div>   <div class="single_info stm_single_info_font_stm-rental-door"> <span class="fuelType"> </span>&nbsp; <span><?=$cardata['fueltype'];?></span></div>
              <div class="single_info stm_single_info_font_stm-rental-door" onClick="showTerms('5');"> <span class="termmaual"> </span>&nbsp; <span >Terms</span></div>
             </div></div>
             <div class="stm_image"> <img src="<?=$cardata['image'];?>" class="img-responsive wp-post-manual" alt=""></div> </a></div>
            </div>
             <?php $i++;} } ?> 
        </div>
  </div>
</section>

    <script>
    function showTerms(id){  
	    
		 if(id==5){
			<?php  //$data = termsConSeacrEngine($con,'5');?> 
		 }else{
			<?php  //$data = termsConSeacrEngine($con,'3');?>  
		 }
		 $('#msgHTML').html('<?php //echo $data; ?>'); $('#msgerror').modal('show'); 
		  gototop('sticky');
		
		}
    </script> 
</body></html>
