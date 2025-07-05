<section class="footerbg">
<footer>
<div class="container">
<div class="row">
<div class="col-lg-3 col-xs-6 col-md-3 col-sm-6">
<div class="footer-title">
<h6><span class="colored">About</span> Company</h6>
</div>
<ul>
<li><a href="<?php echo PEADEX;?>about-us.php" class="footer-botom-bar">About Us </a></li>
<li><a href="<?php echo PEADEX;?>our-assossories.php" class="footer-botom-bar">Our Company</a></li>
<li><a href="<?php echo PEADEX;?>contact-us.php" class="footer-botom-bar">Contact Us</a></li>
<li><a href="<?php echo PEADEX;?>discuss.php" class="footer-botom-bar">Our Discussion</a></li>

</ul>

</div>

<div class="col-lg-3 col-xs-6 col-md-3 col-sm-6">
<div class="footer-title">
<h6><span class="colored">Quick </span> Links</h6>
</div>
<ul>
<li><a href="<?php echo PEADEX;?>make-a-payment.php" class="footer-botom-bar">Make A Payment</a></li>
<li><a href="<?php echo PEADEX;?>why-choose-us.php" class="footer-botom-bar">Why Choose Us?</a></li>
<li><a href="<?php echo PEADEX;?>login/index" class="footer-botom-bar">Cancel Booking </a></li>
<li><a href="<?php echo PEADEX;?>today-offers.php" class="footer-botom-bar">Today Offers</a></li>

</ul>
<span id="siteseal"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=KTHjwDE8sq16mc1qPIPO4p406JNFbbtXtvBvrL6pAW1znDdHywfbszPdcQVb"></script></span>
</div>

<div class="col-lg-3 col-xs-6 col-md-3 col-sm-6">
<div class="footer-title">
<h6><span class="colored">Important</span> Links</h6>
</div>
<ul>
<li><a href="<?php echo PEADEX;?>disclaimer-policy.php" class="footer-botom-bar">Disclaimer Policy</a></li>
<li><a href="<?php echo PEADEX;?>privacy-policy.php" class="footer-botom-bar">Privacy Policy</a></li>
<li><a href="<?php echo PEADEX;?>terms-conditions.php" class="footer-botom-bar">Terms & Conditions</a></li>
<li><a href="<?php echo PEADEX;?>refund-cancellation-policy.php" class="footer-botom-bar">Cancellation & Refund Policy </a></li>
</ul>

</div>

<div class="col-lg-3 col-xs-6 col-md-3 col-sm-6">
<div class="footer-title">
<h6><span class="colored">Social</span> Network</h6>
</div>
<ul class="sociallinks">
<li> <a href="<?=FACEBOOK_S;?>" target="_blank"> <i class="fa fa-facebook"></i> </a></li>
<li> <a href="<?=TWITTER_S;?>" target="_blank"> <i class="fa fa-twitter"></i> </a></li>
<li> <a href="<?=LINKEDIN_S;?>" target="_blank"> <i class="fa fa-linkedin"></i> </a></li>
<li> <a href="<?=INSTAGRAM_S;?>" target="_blank"> <i class="fa fa-instagram"></i> </a></li>
</ul>

<div style="width:100%; clear:both;margin-top:30px">&nbsp;</div> 

<a href="<?=base_url('contact-us.php')?>" style="color:#fbfbfb;font-size: 12px;font-weight: 600;"> <span style="font-size: 22px;"><i class="fa fa-map-marker"></i> </span> View All Locations</a>

</div>

</div>
<div  id="footer-copyright"></div>
<div class="row">
<div class="col-lg-7 col-xs-12 col-md-7 col-sm-12">
<div class="copyright-text">© 2025-<?=date('Y');?> At <a href="<?=base_url('')?>">Odac24.</a><span class="divider"></span>  Designed &amp; Developed By Odac24 </div>
</div>
</div>

</div>

<div class="ccw_plugin chatbot" style="bottom:10px; left:10px;">
    <!-- style 4   chip - logo+text -->
    <div class="style4 animated no-animation ccw-no-hover-an">
        <a target="_blank" href="https://web.whatsapp.com/send?phone=91<?=WHATSUP?>&amp;text=HI Rana Cabs Pvt Ltd" class="nofocus">
            <div class="chip style-4 ccw-analytics" id="style-4" data-ccw="style-4" style="background-color: #e4e4e4; color: rgba(0, 0, 0, 0.6)">
                <img src="<?php echo PEADEX;?>assets/cli/image/whatsapp-logo-32x32.png" class="ccw-analytics" id="s4-icon" data-ccw="style-4" alt="WhatsApp">WhatsApp us</div>
        </a>
    </div>
</div>

<div class="getaCallback" >
<button class="vibrating-button" onclick="window.location.href='<?=base_url('callback.html')?>'">Get A Callback</button>
</div>

</footer>

</section>

<script>
function Viewmap() {
    $('html,body').animate({
        scrollTop: $(".viewmap").offset().top},
        'slow');
    }
	</script>
    
    <script>
$(document).ready(function(){

	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
	


});

function indexto(){
	var x = confirm("Please Create a Booking Using Software.");
  if (x){
       window.location.href="<?php echo PEADEX;?>";
	   return true;
  }
  else{
    return false;
  }
	}
	function checkMonthlyDate(){
	    
	    $.ajax({
	        type:'POST',
	        data:{'pickdate':$('#DatePickM').val() },
	        url: '<?=base_url('Welcome/checkmonthlyDate')?>',
	        success: ( res )=>{
	            $('#DateDropM').val( res );
	        }
	    })
	}
	
	
</script>

<!-- /. error modal-content start -->
  <div class="modal fade" tabindex="1" role="dialog" id="msgerror" style="z-index:9999" > 
  <div class="modal-dialog text-center">
  <div class="modal-content">
  <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <span class="modal-title phone_number">
         <span id="msgHTML"></span>
         </span>
        </div>

    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div>  
    <!-- /. error modal-content start --> 
   <?php
   if(isset($_GET['error'])){
	?>  
   <script type="text/javascript">
   $(function(){ $("#myModal").modal('show'); });
   </script> 
   <?php   
	   }
   ?> 
   
 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" id="modelwidth">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:#F00"><span id="msgHTMLquery"></span></h4>
        </div>
        <div class="modal-body">
         <div class="form_block bg_w "><?php  $captuaCode = OTP(3);?>
            <div class="title ttitliumweb">
            Query Now,  <?php echo SMSADMINMOBILE;?>
            </div>
            <form id="book nowingForm" action="<?php echo PEADEX;?>send-sms.php" class="paddingform" method="post" onsubmit="return validateQuery();">
            <input type="hidden"  name="captua1" value="<?php echo $captuaCode;?>" />
            <em></em>
            <div class="controlHolder " style="margin-top:10px"><div class="tmInput">
            <input name="name" id="qnane" type="text" value="Name..." class="lettersOnly" onFocus="if(this.value=='Name...')this.value='';" onBlur="if(this.value=='')this.value='Name...';">
            </div></div>
            
            <div class="controlHolder"><div class="tmInput">
            <input name="email" id="qemail" type="text" value="Email..."  onFocus="if(this.value=='Email...')this.value='';" onBlur="if(this.value=='')this.value='Email...';">
            </div></div>
           
            <div class="controlHolder"><div class="tmInput">
            <input name="mobileno" id="cont" type="text" value="Contact..." class="numbersOnly" onFocus="if(this.value=='Contact...')this.value='';" onBlur="if(this.value=='')this.value='Contact...';">
            </div></div>
           
            <div class="controlHolder"><div class="tmInput">
            <textarea name="Query" id="mesg"  style="color:#111; padding:2px 10px"  placeholder="Message here..." ></textarea>
            </div></div>
           
            <div class="controlHolder"><div class="tmInput">
            <input name="captua2" placeholder="Enter The Code <?php echo $captuaCode;?>" type="text" value="" >
            </div></div>
            <div class="clear"></div>
            <div class="">
            <input type="submit" class="vehiclebutton" name="sendmail" value="Submit"></div>
            
            </form>
            <div class="clear"></div>
            </div>
        </div>
       
      </div>
      
    </div>
  </div>
  
</div>

