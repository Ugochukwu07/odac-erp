<div class="spacer20"></div>
    <section>
    <div class="container">
    <div class="row">
    <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12" >
  <center>
    <?php if($status=='success'){?>
    <img src="<?=base_url('assets/images/check-mark.jpg');?>">
    <?php }else if($status=='failure'){?>
    <img src="<?=base_url('assets/images/check-mark.jpg');?>">
    <?php }?>

    <?php if($for=='booking'){?>
    <h3><b>Congratulations! Your Booking process was successfull.</h3>
    <h4>Your Booking ID : <?php echo $txndata['bookingid'];?></h4>
    <a href="<?=$href;?>" target='_blank'>Click Here to Download</a>
    <?php }else{?>

    <?php }?>


  </center>
    </div>
    </div>
    </div>
    </section>


 <section>
    <div class="container">
    
    </div>
 </section>
 <div class="spacer30"></div>