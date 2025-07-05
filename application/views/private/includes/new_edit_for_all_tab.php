<?php //echo '<pre>'; print_r($list);?>
<style>
    .bold{font-weight:600; line-height: 41px;}
    .borderbt{ border-bottom: 1px dotted #111111; }
    .lht{ line-height: 41px; }
</style>

<div class="row" style="border: 2px solid #645d5d; padding: 20px;">
    <div class="col-xs-12 col-md-12 ">

<div class="row">
<div class="col-xs-12 col-md-2 bold ">For</div>
<div class="col-xs-12 col-md-3 bold">Quantity</div>
<div class="col-xs-12 col-md-4 bold">Price</div>
<div class="col-xs-12 col-md-3 bold">Total x Quantity</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 borderbt lht">Days / Base fare </div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" name="driverdays" readonly id="driverdays" onblur="Local()" onkeyup="Local()"  value="<?=$list['driverdays'];?>"><em>days</em></div>
<div class="col-xs-12 col-md-4 borderbt"><input type="text" name="vehicle_price_per_unit" readonly id="basefare" onblur="Local()" onkeyup="Local()" value="<?=$list['vehicle_price_per_unit'];?>"><em>basfare/day</em></div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" name="estimatedfare" id="estimatedfare" onblur="Local();" value="<?=($list['driverdays']*$list['vehicle_price_per_unit']);?>"></div>
</div>


<div class="row">
<div class="col-xs-12 col-md-2 borderbt lht">GST Charge</div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" name="gstpercent" id="gstpercent" onblur="Local()" value="<?=$list['gstpercent'];?>" >%<span class="crox">@</span></div>
<div class="col-xs-12 col-md-4 borderbt"><input type="text" name="gstapplyon" readonly id="gstapplyon" onblur="Local();" value="<?=$list['gstapplyon'];?>"><em>Sub-Total</em><span class="crox">=</span></div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" name="totalgstcharge" readonly id="totalgstcharge" onblur="Local();" value="<?=$list['totalgstcharge'];?>"></div>
</div>

<div class="row" >
<div class="col-xs-12 col-md-2 lht borderbt">Other Charge</div>
<div class="col-xs-12 col-md-3 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-4 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="othercharge"  id="othercharge" onblur="Local();" value="<?=$list['othercharge'];?>"></div>
</div>


<div class="row">
<div class="col-xs-12 col-md-2 lht borderbt">Total</div>
<div class="col-xs-12 col-md-3 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-4 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" name="grosstotal" id="grosstotal" readonly onblur="Local();" value="<?=$list['grosstotal'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 borderbt lht">Discount/Per Day </div>
<div class="col-xs-12 col-md-3 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-4 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" name="discount_per_day" id="discount_per_day" onblur="Local();" value="<?=$list['discount_per_day'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 borderbt lht">Discount</div>
<div class="col-xs-12 col-md-3 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-4 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" name="offerprice" id="offerprice" onblur="Local();" value="<?=$list['offerprice'];?>" readonly ></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 borderbt lht">Payable Amount</div>
<div class="col-xs-12 col-md-3 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-4 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" name="totalamount" id="totalamount" onBlur="Local();" value="<?=$list['totalamount'];?>"></div>
</div>


<div class="row">
<div class="col-xs-12 col-md-2 borderbt lht">Booking  Amount</div>
<div class="col-xs-12 col-md-3 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-4 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" name="bookingamount" id="bookingamount" onBlur="Local();"  value="<?=$list['bookingamount'];?>" readonly ></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 borderbt lht ">Balance Amount</div>
<div class="col-xs-12 col-md-3 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-4 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" onblur="roundoff()" name="restamount" id="restamount"  value="<?=$list['restamount'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 borderbt lht ">Refund Amount</div>
<div class="col-xs-12 col-md-3 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-4 borderbt lht">&nbsp;</div>
<div class="col-xs-12 col-md-3 borderbt"><input type="text" onblur="checkRefund()" name="refund_amount" id="refund_amount"  value="<?=$list['refund_amount'];?>"></div>
</div>


</div></div>

                        
                        
<script type="text/javascript">

function calculatePrincipal( amount, gst ) { 
	 return  roundToDecimalPlaces( parseFloat( amount / ( 1 + gst / 100)) );  
}

function roundToDecimalPlaces(value) { 
  return Math.round(value);
}


        function Local(){
					var discount_per_day = $("#discount_per_day").val();
					var driverdays 		= $("#driverdays").val();
					var basefare	 	= $("#basefare").val(); 
					var gstpercent	 	= $("#gstpercent").val(); 
					
					var subDiscounttotal = (parseFloat(driverdays) * parseFloat(discount_per_day) ).toFixed(2);
					$("#offerprice").val( subDiscounttotal );
					
					
					var offerprice 		= parseFloat($("#offerprice").val()); 
					var othercharge 	= parseFloat($("#othercharge").val()); 
					
					var subtotal = (parseFloat(driverdays) * parseFloat(basefare) ).toFixed(2);
					$("#estimatedfare").val( subtotal );
					

					/*For Gst Charge*/ 
					var principleAmount = ( calculatePrincipal( subtotal, gstpercent ) ).toFixed(2);
					
	                var gst = ( roundToDecimalPlaces(subtotal - principleAmount) ).toFixed(2);
	                 
	                $("#totalgstcharge").val( gst );
	                $("#gstapplyon").val( principleAmount );
					/*For Gst Charge*/
					
					var newSubtotal = parseFloat(subtotal) + parseFloat(othercharge) ;
					   
					$("#grosstotal").val(newSubtotal); 
					var totalamount = ( newSubtotal - offerprice ).toFixed(2);;
					$("#totalamount").val( totalamount);
					var bookingamount = $("#bookingamount").val();
					var restamount = (parseFloat(totalamount) - parseFloat(bookingamount)).toFixed(2);
					$("#restamount").val( restamount ); 
					}

		function roundoff(){
			var totalamount 	= $("#totalamount").val();
			var bookingamount	= $("#bookingamount").val(); 
			var restamount	    = $("#restamount").val(); 
			if( (totalamount < bookingamount) && (restamount !=0) ){
				//var extraamount = parseFloat(totalamount) - parseFloat(bookingamount);
				//$("#othercharge").val( Math.abs(extraamount) );
				setTimeout(function(){ Local();},1000);
			}
		}	
		
		function checkRefund(){
		    var bookingamount	= $("#bookingamount").val(); 
		    var refund_amount	= $("#refund_amount").val(); 
		    if( parseFloat( refund_amount ) > parseFloat( bookingamount ) ){
		        $("#refund_amount").val( 0 );
		        alert('Sorry! You can not enter refund amount more than booking Amount');
		    }
		    
		}
</script>        