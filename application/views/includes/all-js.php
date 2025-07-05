
<script src="<?php echo PEADEX;?>assets/cli/js/jquery-1.12.0.js"  type="text/javascript"></script>
<script src="<?php echo PEADEX;?>assets/cli/js/bootstrap.min.js"  type="text/javascript"></script>

<script>
function Viewmap() {
    $('html,body').animate({
        scrollTop: $(".viewmap").offset().top},
        'slow');
    }

function gototop(id) {
    $('html,body').animate({
        scrollTop: $('.'+id).offset().top},
        'slow');
}
</script>
    
    <script>
$(document).ready(function(){

/* scroll and fixed header */
	var navbar = $('.sticky');
    $(window).scroll(function () {
	 if (window.innerWidth > 960) {
        if ($(this).scrollTop() > 156) {
            navbar.addClass("fixed-nav");
        } else {
            navbar.removeClass("fixed-nav");
        }
		} else {
            nav.removeClass("fixed-nav");
        }
});
/* scroll and fixed header */


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

function gotopage(id){
	window.location.href="<?php echo PEADEX;?>"+id;
}
</script>
