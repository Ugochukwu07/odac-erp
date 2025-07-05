<?php //echo '<pre>'; print_r($list);?>
<div class="row">
<div class="col-xs-12 col-md-2 qauntity">For</div>
<div class="col-xs-12 col-md-3 qauntity">Quantity</div>
<div class="col-xs-12 col-md-4 qauntity">Price</div>
<div class="col-xs-12 col-md-3 qauntity">Total x Quantity</div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Fixed Fare</div>
<div class="col-xs-12 col-md-3"></div>
<div class="col-xs-12 col-md-4"><input type="text" name="" id="lfixf" onblur="update('lfixf','lfixedfare'),Local();" value="<?=$list['basefare'];?>"><em>fixed</em><span class="crox">=</span></div>
<div class="col-xs-12 col-md-3"><input type="text" name="fixedfare" id="lfixedfare" onBlur="Local();" value="<?=$list['basefare'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Days / Base Km </div>
<div class="col-xs-12 col-md-3"><input type="text" name="useddays" id="lfday" onblur="nights('lfday','lday','lnt'),Local()"  value="<?=$list['driverdays'];?>"><em>days</em></div>
<div class="col-xs-12 col-md-4"><input type="text" name="basekm" id="lbaskm" onblur="minus('lbaskm','ltotalkm','lexkm'),Local()" value="<?=$list['minkm'];?>"><em>basekm</em></div>
<div class="col-xs-12 col-md-3"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Start Km </div>
<div class="col-xs-12 col-md-3"><input type="text" name="startkm" id="lstrtkm" onblur="minus('lstrtkm','lendkm','ltotalkm'),Local()"  value="<?=$list['minkm'];?>" ><em>startkm</em><span class="crox">X</span></div>
<div class="col-xs-12 col-md-4">
<div class="row11">
<div class="col-xs-12 col-md-7" style="margin-left:-15px; margin-right:-23px">
<input type="text" name="endkm" style="width:60px" id="lendkm" onblur="minus('lstrtkm','lendkm','ltotalkm'),Local()" value="<?=$list['minkm'];?>"><em>endkm</em></div>
<div class="col-xs-12 col-md-5" style="margin-left:-15px">
<input type="text" name="calculatedkm" style="width:50px" id="ltotalkm" onblur="minus('lbaskm','ltotalkm','lexkm'),Local()" value="<?=$list['totalkm'];?>"><em>total</em></div>
</div>
</div>
<div class="col-xs-12 col-md-3"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Extra Km Charge</div>

<div class="col-xs-12 col-md-3"><input type="text" name="extrakm" id="lexkm" onblur="mult('lexkm','lperFkm','lextrakmfare'),Local()" value="<?=$list['totalkm'];?>" ><em>extrakm</em><span class="crox">X</span></div>

<div class="col-xs-12 col-md-4"><input type="text" name="fareperkm" id="lperFkm" onblur="mult('lexkm','lperFkm','lextrakmfare'),transfer()" value="<?=$list['fareperkm'];?>"><em>perkm</em><span class="crox">=</span></div>
<div class="col-xs-12 col-md-3"><input type="text" name="extrakmcharge"  id="lextrakmfare" onBlur="Local();" value="<?=$list['totalkm'];?>"></div>
</div>




<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Driver Charge</div>
<div class="col-xs-12 col-md-3"><input type="text" name="driverdays" id="lday" onblur="mult('lday','ldch','ldrivercharge'),Local()" value="<?=$list['driverdays'];?>" ><em>days</em><span class="crox">X</span></div>
<div class="col-xs-12 col-md-4"><input type="text" name="drivercharge" id="ldch" onblur="mult('lday','ldch','ldrivercharge'),Local()" value="<?=$list['drivercharge'];?>"><em>charge</em><span class="crox">=</span></div>
<div class="col-xs-12 col-md-3"><input type="text" name="totaldrivercharge" id="ldrivercharge" onBlur="Local();" value="<?=$list['totaldrivercharge'];?>"></div>
</div>




<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Night Charge</div>

<div class="col-xs-12 col-md-3"><input type="text" name="nightdays" id="lnt" onblur="mult('lnt','lntcp','lnightcharge'),Local()"  value="<?=$list['totalnights'];?>" ><em>nights</em><span class="crox">X</span></div>

<div class="col-xs-12 col-md-4"><input type="text" name="nightcharge" id="lntcp" onblur="mult('lnt','lntcp','lnightcharge'),Local()"  value="<?=$list['nightcharge'];?>"><em>charge</em><span class="crox">=</span></div>

<div class="col-xs-12 col-md-3"><input type="text" name="totalnightcharge"  id="lnightcharge" onBlur="Local();" value="<?=$list['totalnightcharge'];?>"></div>
</div>
 

<div class="row" style="display:none">
<div class="col-xs-12 col-md-2 qauntity">Other Charge</div>
<div class="col-xs-12 col-md-3"></div>
<div class="col-xs-12 col-md-4"></div>
<div class="col-xs-12 col-md-3"><input type="text" name="othercharge"  id="lothercharge" onBlur="Local();" value="<?=$list['othercharge'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Sub Total</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="subtotal"  id="lsubtotal" onblur="update('lsubtotal','lgsttotal'),Local()" value="<?=$list['gstapplyon'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">GST Charge</div>
<div class="col-xs-12 col-md-3"><input type="text" name="gst" id="lgst" onblur="gst('lgst','lgsttotal','lfinalgst'),Local()" value="<?=$list['gstpercent'];?>" >%<span class="crox">@</span></div>
<div class="col-xs-12 col-md-4"><input type="text" name="" id="lgsttotal" onblur="gst('lgst','lgsttotal','lfinalgst'),Local()" value="<?=$list['gstapplyon'];?>"><span class="crox">=</span></div>
<div class="col-xs-12 col-md-3"><input type="text" name="servicetax" id="lfinalgst" onBlur="Local();" value="<?=$list['totalgstcharge'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Toll Tax</div>
<div class="col-xs-12 col-md-3"></div>
<div class="col-xs-12 col-md-4"></div>
<div class="col-xs-12 col-md-3"><input type="text" name="tolltax" id="ltolltax" onBlur="Local();"  value="<?=$list['tollcharge'];?>"></div>
</div>


<div class="row">
<div class="col-xs-12 col-md-2 qauntity">State Entry Tax</div>
<div class="col-xs-12 col-md-3"></div>
<div class="col-xs-12 col-md-4"></div>
<div class="col-xs-12 col-md-3"><input type="text" name="statetax"  id="lstateentrytax" onBlur="Local();"  value="<?=$list['statecharge'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Gross Total</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="grand" id="lgrostotal" onBlur="Local();" value="<?=$list['grosstotal'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Discount</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="discount" id="ldiscount" onBlur="minus('ldiscount','lgrostotal','lfinaltotal'),Local();" value="<?=$list['offerprice'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Payable Amount</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="finaltotal" id="lfinaltotal" onBlur="Local();" value="<?=$list['totalamount'];?>"></div>
</div>


<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Advance Amount</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="advanceamount" id="ladvance" onBlur="Local();"  value="<?=$list['bookingamount'];?>"></div>
</div>

<div class="row">
<div class="col-xs-12 col-md-2 qauntity">Balance Amount</div>
<div class="col-xs-12 col-md-3">&nbsp;</div>
<div class="col-xs-12 col-md-4">&nbsp;</div>
<div class="col-xs-12 col-md-3"><input type="text" name="restamount" id="lrest"  value="<?=$list['restamount'];?>"></div>
</div>

                        
                        
                <script type="text/javascript">
                function Local(){
                              var fixedfare = $("#lfixedfare").val();
                              var extrakmfare = $("#lextrakmfare").val();
                              var drivercharge = $("#ldrivercharge").val();
                              var nightcharge = $("#lnightcharge").val();
                              var tolltax = $("#ltolltax").val();
                              var othercharge = $("#lothercharge").val();
                              var stateentrytax = $("#lstateentrytax").val();
                              var hourcharge = $("#ltolprhrchrge").val();
                              
                              var subtotal = parseFloat(fixedfare) + parseFloat(extrakmfare) + parseFloat(drivercharge) + parseFloat(nightcharge) + parseFloat(othercharge) + parseFloat(hourcharge) ;
                              
                              $("#lsubtotal").val(subtotal);
                              /*For Gst Charge*/
                              $("#lgsttotal").val(subtotal);
                              var gstCharge = $("#lgst").val();
                              var taxGst = gstCharge*subtotal;
                      var gst = parseInt(taxGst/100);
                      $("#lfinalgst").val(gst);
                              /*For Gst Charge*/
                               
                            var tgrostotall = parseFloat(gst) + parseFloat(subtotal) + parseFloat(tolltax) + parseFloat(stateentrytax);
                              $("#lgrostotal").val(tgrostotall);
                              var tdiscount = $("#ldiscount").val();
                              var tfinaltotal = tgrostotall - tdiscount;
                              $("#lfinaltotal").val(tfinaltotal);
                              var tadvance = $("#ladvance").val();
                              var restamount = tfinaltotal - tadvance;
                              $("#lrest").val(restamount);
                              }
                </script>        