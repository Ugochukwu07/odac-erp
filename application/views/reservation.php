<section class="mtopmobile" >
    <div class="container"> 
<?php $distancreturn = '';?>    
<div class="col-lg-12 col-xs-12 col-md-12 col-sm-12 headcab" >
<p>Book a Cab from <?=$sourcecityname.' to '.getexplode($destination,0); ?>  
<span class="serchkm">
<?php if($tab=='outstation'){ echo 'Approx google (Return) Kms: '.$distancreturn; }?> </span><span class="serchkm"> [Booking Date <?php echo $pickdatetime;?> to <?php echo $dropdatetime;?> total <?=$days;?> days   ] </span><span class="pull-right"><a href="<?php echo PEADEX;?>" class="modify">Modify</a></span></p>
</div>
<div class="col-lg-12 col-xs-12 col-md-12 col-sm-12" >
<h3><ul class="featues">
<li class="iconoicitem"><img src="<?=base_url('assets/images/');?>ok.png" width="18px"> Brand New Cars</li>
<li class="iconoicitem"><img src="<?=base_url('assets/images/');?>ok.png" width="18px"> Instant Confirmation </li>
<!--<li class="iconoicitem"><img src="<?=base_url('assets/images/');?>ok.png" width="18px"> Certified Drivers</li>-->
<li class="iconoicitem"><img src="<?=base_url('assets/images/');?>ok.png" width="18px"> Automated Billing</li>
<li class="iconoicitem"><img src="<?=base_url('assets/images/');?>ok.png" width="18px"> 24X7 Support</li>
</ul></h3>
</div>
<?php //echo  '<pre>';print_r($list); ?>

    </div>
    </section> 
    
    <section class="listing">
    <div class="container">
    <?php if(!empty($list)){?>
    <div class="row stm_rental_search_top">
    <div class="col-md-12 col-xs-12 col-lg-12">
    <h3 class="h2"><span>Search Result</span> <span class="foundcar"><?php echo count($list);?> Cars Found</span></h3>
<div class="all-bar"><div class="all-bar-made all-bar-width"></div></div>
    </div>
    </div>
    <?php  } ?>
     
    <?php  if(!empty($list)){


    if($tab=='outstation'){ $viewmap = "<span class='vhcat'><a href='javascript:void(0);' class='nostyle' onclick='Viewmap()'><i class='fa fa-street-view' style='line-height:20px'></i> View Map</a></span>";}
    // echo '<pre>';
    // print_r($list);
    foreach ($list as $key => $value):
                                # code...
                                                   
              if($tab == 'outstation'){ 
              $mainheadTag = $value['route'];
              } else {   
              $mainheadTag = $value['source'].'->'.getexplode($value['destination'],0); 
              }

             $viewFareDot = "";
             if($tab == 'outstation'){ 
                $viewFareDot = "<span class='vhcat'>Approx (Return) Kms: ".$value['googlekm']." </span> <span class='vhcat'>Estimated Time: ".$value['esttime']." </span>"; 
             } 
             
            $fareid = $value['id']; 
            $frc = $value['withgstamount']; 
            //$adrc = advanceFare( $value['est_fare'] );
            $adrc = ( $value['withgstamount'] );
            //$adrc = $value['final_with_security_amount'];
            //$frc = $value['final_with_security_amount']; 
            $security_amount = $value['secu_amount']; 
            
            $avail = '<div class="s_title" style="color:red"><em>Sold Out</em></div>';
            $booknow = '<a class="viewfared" href="javascript:void(0);">Sold Out</a>';
            $disbleDivClass = 'disablediv';
            if($value['available_cars']){
            $avail = '<div class="s_title"><em>Available '.$value['categoryname'].'s :  '.$value['available_cars'].'</em></div>';
            $booknow = '<a class="viewfared" href="javascript:void(0);" onclick="bookinglink('.$value['stock'].');">Book Now</a>';
            $disbleDivClass = '';
            }
            
            $refundableText = $security_amount > 0 ? '<span class="securitypc">Security Deposit Amt.: <i class="fa fa-rupee"></i> '.round($security_amount).'</span>' : '';
            
            echo $html ='<div class="stm_single_class_car '.$disbleDivClass.'" id="product-108"><div class="row">
    <div class="col-md-2 col-xs-5 col-lg-2 first">
    <div class="image"> 
    <img src="'.$value['imageurl'].'" class=" wp-post-image" alt="" height="181" width="300"></div></div>    
    
    <div class="col-md-4  col-md-4 col-xs-7">
    <div class="top">
    <div class="heading-font"><h3>'.$value['model'].'</h3>
    '.$avail.' 
    <div class="infos">
    <div class="single_info stm_single_info_font_stm-rental-seats"> <img src="'.PEADEX.'assets/images/seats.png" > <span>'.$value['segment'].' Seats</span></div>
    <div class="single_info stm_single_info_font_stm-rental-door"> <span><i class="fa fa-calendar yearm"> </i> </span> <span>'.$value['yearmodel'].'</span></div>
    <div class="single_info stm_single_info_font_stm-rental-door"> <span class="fuelType"> </span> <span>'.$value['fueltype'].'</span></div>
    <div class="single_info stm_single_info_font_stm-rental-ac"> <img src="'.PEADEX.'assets/images/ac.png" >  <span>'.$value['acstatus'].'</span></div></div> 
    '.$refundableText.'
    </div>
    </div> 
    </div>
    
    <div class="col-md-6 col-xs-12 col-lg-6 second">
    <div class="row"> 
    <div class="col-md-3 col-md-3 col-xs-6">
    <div class="stm-more"> <a class="viewfared" href="javascript:void(0)" onclick="showfare('.$value['stock'].');">Fare Breakup</a> </div>
    </div>
    
    <div class="col-md-3 col-md-3 col-xs-6 inclusic">
    <div class="stm-more"> <span class="amountpay"><i class="fa fa-rupee"></i> '.round(($frc)).'.00</span></div>
    Inclusive of GST 
    </div>
    
    <div class="col-md-3 col-md-3 col-xs-6">
    <div class="stm-more"> '.$booknow.'</div>
    </div>
    </div></div></div></div>';
  
  
 endforeach; }else{ ?>
    <div class="stm_notices">
    <div class="row">
    <div class="col-md-12 col-xs-12 col-lg-12">
    <img src="<?=base_url('assets/images/');?>carfoundnot.png" class="img-responsive" />
    </div>
    </div>
    </div>
      <?php  } ?>
    
    </div></div>
    
    
    
    <div class="spacer30"></div>
    </div></div>
    </section>


<script type="text/javascript"> 
function bookinglink(goparam){
    window.location.href='<?php echo PEADEX;?>login/dologin?utm='+btoa(goparam);
}   

function showfare(req){ 
    $.ajax({
        type:'POST',
        url: '<?php echo PEADEX;?>Fb/index',
        data:{ 'vall': req },
        success: function( res ){
            $("#fareSummary").html(res); 
            $("#fareshow").modal('show');
        }
    }) 
}

<?php $termslist = '';
if(!empty($terms)){
    $termslist .= '<ol>';
foreach ($terms as $key => $valueli) {
    $termslist .= '<li>'.$valueli['content'].'</li>';
}
$termslist .= '</ol>';
}
?>    
   
    </script>
    <style type="text/css">@media(min-width:780px){.modal-dialog{ width: 490px;} ol.tnc { margin: 0px !important;}} 
    @media(max-width:767px){.modal-dialog{ width: 98%;} ol.tnc { margin: 0px !important;} ol.tnc li,#fareSummary > div.row > div { font-size: 10px !important;}}
    .disablediv{ background: #c5c5c5; pointer-events: none; opacity: 0.4; } </style>
 <!-- /. Fare modal-content -->
  <div class="modal fade" tabindex="1" role="dialog" id="fareshow" > 
  <div class="modal-dialog text-center">
  <div class="modal-content">
  <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <span class="modal-title">
         <div  class="fwidth">
         <span  id="fareSummary"></span>
         <div class="row">
         <div class="col-lg-12 col-xs-12">  <p class='ext_txt'><br/><b class="bold">Extra Charges (if applicable)</b></p></div></div>  
         <?php echo '<div class="lists-inline tnc"> '.$termslist.' </div>'; ?>
         </div>
         </div>
         </div>
         </div>
         </span>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div> </div>
    <!-- /. Fare modal-content start -->  