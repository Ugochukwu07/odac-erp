<style>
    @media(max-width:767px){ #rndtlsright{ float:left !important; clear:both}  #rndtlsleft{ float:none !important} .spacer_20 { margin-top:10px !important;}  }
    @media(min-width:780px){ #rndtlsright{ float:right !important}  #rndtlsleft{ float:left !important}
	 .bikeimg img.widthch { width:97%; margin:0 auto; min-height: 322px !important;max-height: 500px !important; } }	
	.border-vd { border-bottom: 2px solid #D9D9D9; } 
    </style>

 <section class="simplebg2 vehiclefixed">
  <div class="container"> 
  <div class="row">
  <div class="col-lg-3 col-xs-12 spacer_20 leftPenal " id="rndtlsleft" >
<div class="panel">
<ul class="ulist">
<?php if(!empty($vehiclelist)){
  foreach($vehiclelist as $key=>$lstvalue ){?>

<li><a href="<?=PEADEX;?>booking-details-vehicle-bike.php?id=<?=base64_encode($lstvalue['id']);?>">
<?php if($lstvalue['catid']=='2'){ ?><i class="fa fa-motorcycle"></i> 
<?php }else if($lstvalue['catid'] =='1'){ ?><i class="fa fa-car"></i> <?php }
 echo capitalize($lstvalue['cabname']); ?></a></li>
<?php } } ?>
</ul>
</div>

<div class="spacer-20"></div>
<?php $this->load->view('includes/left_common_tab');?>
<div class="spacer-20"></div>
</div>

<div class="col-lg-9 col-xs-12 spacer_20 " >
<?php if(!empty($openlist)){ ?>
<div class="all-bar"><div class="all-bar-made all-bar-width"></div></div> 
<div class="vhwidth border-vd carpad spacer-10 bikeimg">
<?php if(!empty($openlist['image'])){ $filcheck = UPLOADS.''.$openlist['image'];?>
<center><img src="<?php echo $filcheck;?>" class="widthch" /></center>
<?php } ?>

<div class="detailswidth border-vddet carpad">
<div class="col-lg-9 col-xs-12">
<div class="row11">
<div class="col-lg-8 col-xs-12 spacer-10">
<p class="vhname"><?php echo $openlist['cabname'];?> 
<?php /*?><?php if(strlen(carcategoryfrommodel($viewcarBikedata['cityname'])) > 1){?> (
<span class="spacer-20 day" >  <?php echo carcategoryfrommodel($viewcarBikedata['cityname']); ?> </span> )
<?php }?> <?php */?></p>
</div>
</div>

</div>
<div class="col-lg-3 col-xs-12 spacer-10">
<button class="viewfared" onClick="indexto();<?php /*?>window.location.href='<?php echo PEADEX;?>dataCphaff.php?id=<?php echo $_GET['id'];?>'<?php */?>">
<span>Book Now</span>
<i class="fa fa-angle-right selectbtni"></i>
</button>
</div>
</div>

<div class="vhwidth  carpad spacer-10  padingjust">
<p class="text-justify "><?php echo $openlist['content'];?></p>
</div>
  
</div>

<?php } ?>


</div>
  </div>
  </div>
</section>

<!--seo portion-->
<h1 style="display:none"><?php echo $dataurl['summary'];?></h1>
<h2 style="display:none"><?php echo $dataurl['title'];?></h2>
<h3 style="display:none"><?php echo $dataurl['meta'];?></h3>
<!--seo portion-->
 <div class="spacer30"></div>