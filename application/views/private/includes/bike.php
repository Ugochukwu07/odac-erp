<?php //echo '<pre>'; print_r($list);?>
<div class="row">
<div class="col-xs-12 col-md-2 qauntity">For</div>
<div class="col-xs-12 col-md-3 qauntity">Quantity</div>
<div class="col-xs-12 col-md-4 qauntity">Price</div>
<div class="col-xs-12 col-md-3 qauntity">Total x Quantity</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Days / Base fare </div>
<div class="col-xs-12 col-md-3"><input type="text" name="driverdays" id="driverdays" onblur="Local()"  value="<?=$list['driverdays'];?>"><em>days</em></div>
<div class="col-xs-12 col-md-4"><input type="text" name="basefare" id="basefare" onblur="Local()" value="<?=$list['basefare'];?>"><em>basfare/day</em></div>
<div class="col-xs-12 col-md-3"><input type="text" name="estimatedfare" id="estimatedfare" onblur="Local();" value="<?=$list['estimatedfare'];?>"></div>
</div>


<div class="row">
<div class="col-xs-12 col-md-2 qauntity">GST Charge</div>
<div class="col-xs-12 col-md-3"><input type="text" name="gstpercent" id="gstpercent" onblur="Local()" value="<?=$list['gstpercent'];?>" >%<span class="crox">@</span></div>
<div class="col-xs-12 col-md-4"><input type="text" name="gstapplyon" id="gstapplyon" onblur="Local();" value="<?=$list['estimatedfare'];?>"><span class="crox">=</span></div>
<div class="col-xs-12 col-md-3"><input type="text" name="totalgstcharge" id="totalgstcharge" onblur="Local();" value="<?=$list['totalgstcharge'];?>"></div>
</div>

<div class="row" style="display:none">
<div class="col-xs-12 col-md-2 qauntity">Other Charge</div>
<div class="col-xs-12 col-md-3"></div>
<div class="col-xs-12 col-md-4"></div>
<div class="col-xs-12 col-md-3"><input type="text" name="othercharge"  id="othercharge" onblur="Local();" value="<?=$list['othercharge'];?>"></div>
</div>


<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Gross Total</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="grosstotal" id="grosstotal" onblur="Local();" value="<?=$list['grosstotal'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Discount</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="offerprice" id="offerprice" onblur="Local();" value="<?=$list['offerprice'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Payable Amount</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="totalamount" id="totalamount" onBlur="Local();" value="<?=$list['totalamount'];?>"></div>
</div>


<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Booking Amount</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="bookingamount" id="bookingamount" onBlur="Local();"  value="<?=$list['bookingamount'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Balance Amount</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" onblur="roundoff()" name="restamount" id="restamount"  value="<?=$list['restamount'];?>"></div>
</div>

                        
                        
<script type="text/javascript">
        function Local(){
					var driverdays 		= $("#driverdays").val();
					var basefare	 	= $("#basefare").val(); 
					var gstpercent	 	= $("#gstpercent").val(); 
					var offerprice 		= parseFloat($("#offerprice").val());
					var othercharge 	= $("#othercharge").val();
					
					var subtotal = parseFloat(driverdays) * parseFloat(basefare);
					$("#estimatedfare").val( subtotal );
					$("#gstapplyon").val( subtotal );

					/*For Gst Charge*/ 
					var taxGst = gstpercent*subtotal;
	                var gst = parseInt(taxGst/100);
	                $("#totalgstcharge").val(gst);
					/*For Gst Charge*/
					 
				    var grosstotal = parseFloat(gst) + parseFloat(subtotal) + parseFloat(othercharge) ;
					$("#grosstotal").val(grosstotal); 
					var totalamount = grosstotal - offerprice;
					$("#totalamount").val(totalamount);
					var bookingamount = $("#bookingamount").val();
					var restamount = parseFloat(totalamount) - parseFloat(bookingamount);
					$("#restamount").val(restamount); 
					}

		function roundoff(){
			var totalamount 	= $("#totalamount").val();
			var bookingamount	= $("#bookingamount").val(); 
			var restamount	    = $("#restamount").val(); 
			if( (totalamount < bookingamount) && (restamount !=0) ){
				var extraamount = parseFloat(totalamount) - parseFloat(bookingamount);
				$("#othercharge").val( Math.abs(extraamount) );
				setTimeout(function(){ Local();},1000);
			}
		} 
                </script>        