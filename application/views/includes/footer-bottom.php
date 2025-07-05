<script src="<?php echo PEADEX;?>assets/cli/js/custom.js"></script>
<script src="<?php echo PEADEX;?>assets/cli/js/datetimepicker.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GGOGLEPLACEKEY;?>&libraries=places&callback=initAutocomplete" defer="defer" async></script>
<script>function shownow(id){if(id==2){document.getElementById("addshowbutton").style.display="";}else{document.getElementById("addshowbutton").style.display="none";}}</script>
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