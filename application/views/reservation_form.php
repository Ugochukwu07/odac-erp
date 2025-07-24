<?php   
// echo '<pre>';
// print_r($result); 
    $fareid = $result['id']; 
    $dayshow = $result['days']; 
    $tab = $result['triptype']; 
    $tax = $result['gst']; 
    
    
    
    $calculatedfare = (float)$result['est_fare'];
    
    $servicetax = (float)$result['gstamount']; 
    $totalfare = (float)$result['withgstamount']; 
    $onlineCharge = round(onlineCharge($totalfare)); 
    $withonlinecharge = (float)$totalfare + (float)$onlineCharge ; 
    $refundable_amount =  (float)$result['secu_amount'];
    
    $advance_amount =  advanceFare( $withonlinecharge ); 

    
    $vechimodelname = $result['model'];  
    
    $vehicledetails = []; 
    $carImage = $result['imageurl']; 
            /*ITENARARY*/   
    $cityname = $result['source'];  
    $route = current(explode(',',$result['source'])).' <span style="font-family:times new roman"> → </span> '.current(explode(',',$result['destination']));
?>


<style type="text/css">
    label {
    color: #111;
}
.secuAmt{ display:none; }
</style>
<section class="listing">
    
    
    <div class="container">
    
    <div class="row">
    <!--/.left side portion start -->
    <div class="col-md-4 col-xs-12 col-lg-4">
    <div class="row">
    <div class="col-lg-12 col-xs-12 spacer_20 leftPenal headingpart">
    <div class="panel-heading"><span class="personalinfoarmation">Your Booking Details</span>
    <div class="rentalborder clearfix" ></div></div>
    
    <div class="row">
    <div class="col-lg-12 col-xs-12  leftPenal headingpart">
    <div class="heading-font"> 
    
    <div class="panel rentalpanel">
    <span class="totalrenINr">Itinerary</span> <span class="pull-right totalrenINr"><?= $route;?> </span><br/>
<span class="totalrenINr">Pickup Date</span> <span class="pull-right totalrenINr"><?php echo $result['pickupdatetime'];?> </span><br/>
<span class="totalrenINr">Return Date</span> <span class="pull-right totalrenINr"> <?php echo $result['dropdatetime'];?> </span><br/>
<span class="totalrenINr">Vehicle Model</span> <span class="pull-right totalrenINr"> <?php echo $vechimodelname; ?> </span><br/>
<span class="totalrenINr">Total Rental Price</span> <span class="pull-right totalrenINr">INR <?php echo twoDecimal($totalfare);?> </span><br/>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    
    <div class="row">
    <div class="col-lg-12 col-xs-12  leftPenal headingpart">
    <div class="heading-font"> 
    
<div class="panel rentalpanel">
<div class="rentalborder clearfix" ></div>
<span class="totalrenINr">Rental Cost</span> <span class="pull-right totalrenINr">INR <?php echo twoDecimal($calculatedfare);?> </span><br/>
<span class="totalrenINr">GST Charge</span> <span class="pull-right totalrenINr">INR <?php echo twoDecimal($servicetax);?> </span><br/>
<span class="totalrenINr">Estimated Rental Cost</span> <span class="pull-right totalrenINr">INR <?php echo twoDecimal($totalfare);?> </span><br/>

<span id="discoutcontshow" style="display:<?=$offer?'block':'none';?>">
<div class="clearfix" style="border:1px solid #F5F5F5" ></div>
<span class="totalrenINrpay">Discount Amount</span> <span class="pull-right totalrenINrpay">INR <em id="discountAmount"><?=twoDecimal($offer);?></em> </span><br/>
<span class="totalrenINr">After Discount Cost</span> <span class="pull-right totalrenINr">INR <em id="discountHtmlValue"><?=twoDecimal(((float)$withonlinecharge - (float)$offer));?></em> </span><br/>
</span>


<div class="rentalborder clearfix" ></div>
<?php if(!$offer){?>
<span class="totalrenINrpay">Online Charge ( <?php echo ONLINECHARGE;?>% ) </span> <span class="pull-right totalrenINrpay">INR <em id="onlineChrge"><?=twoDecimal($onlineCharge);?></em> </span>
<div class="rentalborder clearfix" ></div>
<?php }?>
<span class="totalrentaINr">Final Amount</span> <span class="pull-right totalrenINr">INR <em id="paynow"><?=$offer?twoDecimal(((float)$withonlinecharge - (float)$offer)):twoDecimal($withonlinecharge);?></em> </span>

<div class="rentalborder clearfix secuAmt"  ></div>
<span class="totalrenINr secuAmt">Security Deposit Amount</span> <span class="pull-right totalrenINr secuAmt">INR <em id="securityDepositAmount" ><?=twoDecimal( $refundable_amount );?></em> </span><br/>


<div class="rentalborder clearfix" ></div>
<span class="totalrenINr">Pay Now</span> <span class="pull-right totalrenINr">INR <em id="payableAmount"><?=twoDecimal( $advance_amount );?></em> </span><br/>



 
<div class="pull-left totalrenINrpay" style="clear: both; margin-top: 20px;display:<?=$offer?'none':'block';?>"><a href="javascript:void(0);" style="color:#0A68C2;" id="showDivC">Offer Zone</a></div>
<div style="border-bottom:1px solid #136F9F; width:100%;" class="clearfix"></div>
<div class="spacer-20"></div>
<style type="text/css">
.cpnh{ font-size: 13px;color: #222; font-weight: 600; }
.prcd{border-radius: 5px;background: #e1f2ed; padding: 2px 10px; font-weight: 400;}
.clbl{ width: 95%; margin-left: 18px; cursor: pointer;} 
</style>
<div class="row11" id="showcontentt"> 
<?php if($cpnlist && !$offer){ foreach($cpnlist as $key=>$value):?> 
<label class="clbl" onclick="applycoupon('<?=$value['id']?>','<?=$value['couponcode']?>','<?=$value['maxdiscount'];?>');"><div class="row11">       
<div class="col-lg-1 col-md-1 col-xs-1"><input type="radio" class="form-control" name="cpn" value="<?=$value['id'];?>" style="width: 18px;"></div> 
<div class="col-lg-10 col-md-10 col-xs-10">
<span class="cpnh"><?=$value['titlename'];?> Upto र <?=$value['maxdiscount'];?> Discount</span> <br/>
<span class="totalrenINr prcd">Promocode: <b><?=$value['couponcode'];?></b></span>
</div></div> </label> 
<?php endforeach;}?>
</div>
<span class="col-lg-12 spacer-20">&nbsp;</span>

</div>
</div>
</div></div></div>
    <!--/.left side portion end -->
     
     
  <!--/.right side portion start -->
   <div class="col-md-8 col-xs-12 col-lg-8">
    <div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12 spacer_20  pull-left">
<div class="panel panel-default">
<div class="panel-heading"><span class="personalinfoarmation">Personal Information</span><span class="pull-right cursor changetaxi" onClick="window.history.go(-1);" > <i class="fa fa-backward "></i> &nbsp;Change Vehicle</span></div>
<div class="panel-body searchRentals">
<!--<form onSubmit="return checkFormData();" action="#" >-->
    <input type="hidden" name="" id="cpnid"> 
<div class="row11 form">
<div class="col-lg-6 col-md-6 col-xs-12">
<label>First Name</label>
<div class="form-group">
<input type="text" name="customerFirstname" placeholder="First Name"  id="firstname" value="<?=$firstname;?>" class="form-control lettersOnly"/>
</div>
</div>

<div class="col-lg-6 col-md-6 col-xs-12">
<label>Last Name</label>
<div class="form-group">
<input type="text" placeholder="Last Name" name="customerSecondname" id="lastname" class="form-control lettersOnly" value="<?=$lastname;?>" />
</div>
</div>

<div class="col-lg-6 col-md-6 col-xs-12">
<label>Email</label>
<div class="form-group">
<input type="text" placeholder="Email Address"  name="customeremail" id="emailid" value="<?=$emailid;?>" class="form-control"/>
</div>
</div>
</div>

<div class="row11">
<div class="col-lg-6 col-md-6 col-xs-12">
<label>Mobile Number</label>
<div class="form-group">
<input type="text" placeholder="Mobile Number"  name="mobileno1" value="<?=$mobileno;?>" id="mobileno1" maxlength="10" class="form-control numbersOnly"/>
</div>
</div>

<?php /*?><div class="col-lg-3 col-xs-12">
<label>Alternate Mobile.</label>
<div class="form-group">
<input type="text" placeholder="Mobile Number 2" name="mobileno2" class="form-control numbersOnly" value="<?php echo eXxPlodeHas(',',$bookingdata['tmobile'],'1'); ?>" maxlength="10" id="mobileno2" />
</div>
</div><?php */?>

<div class="col-lg-6 col-md-6 col-xs-12">
<label>Passengers</label>
<div class="form-group">
<input type="text" placeholder="Passengers" id="passnger" value="1"  name="passnger" class="form-control numbersOnly"/>
</div>
</div>

<div class="col-lg-6 col-md-6 col-xs-12">
<label>Country Name</label>
<div class="form-group">
<select name="country" class="form-control" id="country" >
<option value="">Country...</option>
<option value="Afganistan">Afghanistan</option>
<option value="Albania">Albania</option>
<option value="Algeria">Algeria</option>
<option value="American Samoa">American Samoa</option>
<option value="Andorra">Andorra</option>
<option value="Angola">Angola</option>
<option value="Anguilla">Anguilla</option>
<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
<option value="Argentina">Argentina</option>
<option value="Armenia">Armenia</option>
<option value="Aruba">Aruba</option>
<option value="Australia">Australia</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="Bahamas">Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh">Bangladesh</option>
<option value="Barbados">Barbados</option>
<option value="Belarus">Belarus</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bermuda">Bermuda</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
<option value="Bonaire">Bonaire</option>
<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
<option value="Botswana">Botswana</option>
<option value="Brazil">Brazil</option>
<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
<option value="Brunei">Brunei</option>
<option value="Bulgaria">Bulgaria</option>
<option value="Burkina Faso">Burkina Faso</option>
<option value="Burundi">Burundi</option>
<option value="Cambodia">Cambodia</option>
<option value="Cameroon">Cameroon</option>
<option value="Canada">Canada</option>
<option value="Canary Islands">Canary Islands</option>
<option value="Cape Verde">Cape Verde</option>
<option value="Cayman Islands">Cayman Islands</option>
<option value="Central African Republic">Central African Republic</option>
<option value="Chad">Chad</option>
<option value="Channel Islands">Channel Islands</option>
<option value="Chile">Chile</option>
<option value="China">China</option>
<option value="Christmas Island">Christmas Island</option>
<option value="Cocos Island">Cocos Island</option>
<option value="Colombia">Colombia</option>
<option value="Comoros">Comoros</option>
<option value="Congo">Congo</option>
<option value="Cook Islands">Cook Islands</option>
<option value="Costa Rica">Costa Rica</option>
<option value="Cote DIvoire">Cote D'Ivoire</option>
<option value="Croatia">Croatia</option>
<option value="Cuba">Cuba</option>
<option value="Curaco">Curacao</option>
<option value="Cyprus">Cyprus</option>
<option value="Czech Republic">Czech Republic</option>
<option value="Denmark">Denmark</option>
<option value="Djibouti">Djibouti</option>
<option value="Dominica">Dominica</option>
<option value="Dominican Republic">Dominican Republic</option>
<option value="East Timor">East Timor</option>
<option value="Ecuador">Ecuador</option>
<option value="Egypt">Egypt</option>
<option value="El Salvador">El Salvador</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Estonia">Estonia</option>
<option value="Ethiopia">Ethiopia</option>
<option value="Falkland Islands">Falkland Islands</option>
<option value="Faroe Islands">Faroe Islands</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="French Guiana">French Guiana</option>
<option value="French Polynesia">French Polynesia</option>
<option value="French Southern Ter">French Southern Ter</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Germany">Germany</option>
<option value="Ghana">Ghana</option>
<option value="Gibraltar">Gibraltar</option>
<option value="Great Britain">Great Britain</option>
<option value="Greece">Greece</option>
<option value="Greenland">Greenland</option>
<option value="Grenada">Grenada</option>
<option value="Guadeloupe">Guadeloupe</option>
<option value="Guam">Guam</option>
<option value="Guatemala">Guatemala</option>
<option value="Guinea">Guinea</option>
<option value="Guyana">Guyana</option>
<option value="Haiti">Haiti</option>
<option value="Hawaii">Hawaii</option>
<option value="Honduras">Honduras</option>
<option value="Hong Kong">Hong Kong</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India" selected >India</option>
<option value="Indonesia">Indonesia</option>
<option value="Iran">Iran</option>
<option value="Iraq">Iraq</option>
<option value="Ireland">Ireland</option>
<option value="Isle of Man">Isle of Man</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan">Kazakhstan</option>
<option value="Kenya">Kenya</option>
<option value="Kiribati">Kiribati</option>
<option value="Korea North">Korea North</option>
<option value="Korea Sout">Korea South</option>
<option value="Kuwait">Kuwait</option>
<option value="Kyrgyzstan">Kyrgyzstan</option>
<option value="Laos">Laos</option>
<option value="Latvia">Latvia</option>
<option value="Lebanon">Lebanon</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libya">Libya</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Macau">Macau</option>
<option value="Macedonia">Macedonia</option>
<option value="Madagascar">Madagascar</option>
<option value="Malaysia">Malaysia</option>
<option value="Malawi">Malawi</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
<option value="Marshall Islands">Marshall Islands</option>
<option value="Martinique">Martinique</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Mayotte">Mayotte</option>
<option value="Mexico">Mexico</option>
<option value="Midway Islands">Midway Islands</option>
<option value="Moldova">Moldova</option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montserrat">Montserrat</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar">Myanmar</option>
<option value="Nambia">Nambia</option>
<option value="Nauru">Nauru</option>
<option value="Nepal">Nepal</option>
<option value="Netherland Antilles">Netherland Antilles</option>
<option value="Netherlands">Netherlands (Holland, Europe)</option>
<option value="Nevis">Nevis</option>
<option value="New Caledonia">New Caledonia</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="Niue">Niue</option>
<option value="Norfolk Island">Norfolk Island</option>
<option value="Norway">Norway</option>
<option value="Oman">Oman</option>
<option value="Pakistan">Pakistan</option>
<option value="Palau Island">Palau Island</option>
<option value="Palestine">Palestine</option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Phillipines">Philippines</option>
<option value="Pitcairn Island">Pitcairn Island</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Puerto Rico">Puerto Rico</option>
<option value="Qatar">Qatar</option>
<option value="Republic of Montenegro">Republic of Montenegro</option>
<option value="Republic of Serbia">Republic of Serbia</option>
<option value="Reunion">Reunion</option>
<option value="Romania">Romania</option>
<option value="Russia">Russia</option>
<option value="Rwanda">Rwanda</option>
<option value="St Barthelemy">St Barthelemy</option>
<option value="St Eustatius">St Eustatius</option>
<option value="St Helena">St Helena</option>
<option value="St Kitts-Nevis">St Kitts-Nevis</option>
<option value="St Lucia">St Lucia</option>
<option value="St Maarten">St Maarten</option>
<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
<option value="Saipan">Saipan</option>
<option value="Samoa">Samoa</option>
<option value="Samoa American">Samoa American</option>
<option value="San Marino">San Marino</option>
<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
<option value="Saudi Arabia">Saudi Arabia</option>
<option value="Senegal">Senegal</option>
<option value="Serbia">Serbia</option>
<option value="Seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Singapore">Singapore</option>
<option value="Slovakia">Slovakia</option>
<option value="Slovenia">Slovenia</option>
<option value="Solomon Islands">Solomon Islands</option>
<option value="Somalia">Somalia</option>
<option value="South Africa">South Africa</option>
<option value="Spain">Spain</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sudan">Sudan</option>
<option value="Suriname">Suriname</option>
<option value="Swaziland">Swaziland</option>
<option value="Sweden">Sweden</option>
<option value="Switzerland">Switzerland</option>
<option value="Syria">Syria</option>
<option value="Tahiti">Tahiti</option>
<option value="Taiwan">Taiwan</option>
<option value="Tajikistan">Tajikistan</option>
<option value="Tanzania">Tanzania</option>
<option value="Thailand">Thailand</option>
<option value="Togo">Togo</option>
<option value="Tokelau">Tokelau</option>
<option value="Tonga">Tonga</option>
<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
<option value="Tunisia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
<option value="Tuvalu">Tuvalu</option>
<option value="Uganda">Uganda</option>
<option value="Ukraine">Ukraine</option>
<option value="United Arab Erimates">United Arab Emirates</option>
<option value="United Kingdom">United Kingdom</option>
<option value="United States of America">United States of America</option>
<option value="Uraguay">Uruguay</option>
<option value="Uzbekistan">Uzbekistan</option>
<option value="Vanuatu">Vanuatu</option>
<option value="Vatican City State">Vatican City State</option>
<option value="Venezuela">Venezuela</option>
<option value="Vietnam">Vietnam</option>
<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
<option value="Wake Island">Wake Island</option>
<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
<option value="Yemen">Yemen</option>
<option value="Zaire">Zaire</option>
<option value="Zambia">Zambia</option>
<option value="Zimbabwe">Zimbabwe</option>
</select>
</div>
</div>


</div>

<div class="row11">
<div class="col-lg-12 col-md-12 col-xs-12">
<label>Street address (Pick-up Address)</label>
<div class="form-group">
<input type="text" placeholder="Pick-up Address" id="pickaddress"  name="location1" class="form-control address" value="<?=$result['source'];?>" />
</div>
</div>
<div class="col-lg-12 col-md-12 col-xs-12">
<label>Drop-off Address</label>
<div class="form-group">
<input type="text" placeholder="Drop-off Address"<?php if(in_array($tab,['selfdrive','bike'])){?> readonly="readonly" <?php }else{ echo $result['destination'];}?> value="<?php if(in_array($tab,['selfdrive','bike'])){ echo $pickupdropaddress;;}else{ echo $result['destination'];} ?>" id="dropaddress"  name="location2" class="form-control address"/>
</div>
</div>
</div>



<div class="row11 spacer-20">
<div class="col-lg-12 col-xs-12">
    <label>
    <input type="checkbox" name="security_amount" id="security_amount" value="yes" onclick="applyPaymode();" >
    <span class="totalrenINr">Pay Security Deposit Amount</span> <span class=" totalrenINr">INR <?php echo twoDecimal($refundable_amount);?> </span>
    </label>
 </div>
</div>
 
 

<div class="row11 spacer-20">
<div class="col-lg-5 col-xs-12">
    <div class="row11">
    <div class="col-lg-3 col-xs-4"><span><img src="<?=PEADEX;?>assets/images/godaddy-secured.jpg"></span></div>
    <div class="col-lg-6 col-xs-6 spacer-20">
    <span class="personalinfoarmation">100%</span><br/>
    <span>Secure Transaction</span>
    </div>
    </div>
</div>
<div class="col-lg-6 col-xs-12">
<div class="spacer-20"></div>
<div class="row11">
    <div class="col-lg-6 col-xs-12">
    <?php echo form_dropdown(['name'=>'payment_mode','id'=>'payment_mode','class'=>'form-control','onchange'=>"applyPaymode()"],$payment_mode_list,set_value('payment_mode',$payment_mode)); ?>
</div>
<div class="col-lg-6 col-xs-12">
    <button class="viewfared" onclick="grabbook();" id="submitBtn" >
    <span id="proceed"><?=$bookedfrom?'Proceed':'Proceed To Payment';?> &nbsp; </span>
    <i class="fa fa-angle-right selectbtni"></i>
    </button>
</div>
</div>
</div>
</div>


<!-- </form> -->


</div>
</div>
</div>
</div>
</div>
  <!--/.right side portion end --> 
</div>
 
    
<div class="spacer30"></div>
</div> 
</section>
    

<script type="text/javascript">
function applycoupon(id,cpn,dis) {  
    $("#discoutcontshow").show(); 
    $("#defaultload").show();   
    $("#discountAmount").html( parseInt(dis).toFixed(2) );
    var aftdis = ('<?=$totalfare?>'-dis).toFixed(2);
    $("#discountHtmlValue").html( aftdis );
    var online = '<?=ONLINECHARGE;?>'; 
    var ofull = parseInt(aftdis*online/100);  
    $('#onlineChrge').html( ofull.toFixed(2) );
    var fnl = parseInt(aftdis) + (+ofull);
    $('#paynow').html( fnl.toFixed(2)); 
    $('#cpnid').val( id );  
    setTimeout( ()=>{ applyPaymode();}, 500 );
}

$(function(){ $("#showDivC").click(function(){ $('#showcontentt').show(); });  });

function checkFormData() { 
     var x = $('#firstname').val(); var y = $('#lastname').val(); var z = $('#emailid').val(); 
     var ax = $('#mobileno1').val(); var ay = $('#mobileno2').val(); var az = $('#passnger').val();  
    if ( x == ""){ $('#msgHTML').html('First Name is Blank!'); $('#msgerror').modal('show');  return false; } 
   // if ( y == "") { $('#msgHTML').html('Last Name is Blank!'); $('#msgerror').modal('show'); return false; }
    if (z == "") { $('#msgHTML').html('Email Id is Blank!'); $('#msgerror').modal('show'); return false; }
    if (ax == "") { $('#msgHTML').html('Mobile Number is Blank!'); $('#msgerror').modal('show'); return false; }
    if (az == "") { $('#msgHTML').html('No. Of Passengers Are Blank!'); $('#msgerror').modal('show'); return false; }
    return true;
    }

function grabbook(){
    var STOCK = '<?=$result['stock'];?>';
    var fname = $('#firstname').val() +' '+ $('#lastname').val();
    var email = $('#emailid').val();
    var mobileno = $('#mobileno1').val();
    var passnger = $('#passnger').val();
    var country = $('#country').val();
    var pick = $('#pickaddress').val();
    var drop = $('#dropaddress').val();
    var cpnid = $('#cpnid').val();
    var paymode = $('#payment_mode option:selected').val();  
    var is_deposit = $('#security_amount:checked').val();
    var bookingamount = parseInt( $('#payableAmount').text() ); 
    
    $('#submitBtn').prop('disabled', true );
   
    //return;
    
    if( checkFormData() ){
        $.ajax({
            type: 'POST',
            url: '<?=PEADEX.'reservation_form/book'?>',
            data: {'stock':STOCK,'fn':fname,'email':email,'mob':mobileno,'ps':passnger,'cn':country,'pick':pick,'drop':drop,'cpnid':cpnid,'is_deposit':is_deposit,'paymode': paymode,'bookingamount':bookingamount },
            beforeSend: function(){ 
                $('#proceed').html('Please Wait..');
                $("#proceed").attr('disabled', true);
            },
            success: function(res){
                var obj = JSON.parse(res);
                if( obj.url !== '' && !obj.is_gateway ){
                window.location.href = obj.url; 
                }else{
                    const dataR = obj.data;
                    var keyId = obj.key_id; 
                    LoadRazorpay( keyId, dataR.gateway_amount , dataR.payid, dataR.name, dataR.email, dataR.mobile, dataR.orderid, obj.verify_url  );
                }
            }
        });
    }
}     
 

function applyPaymode(){
    var paymode = $('#payment_mode option:selected').val();  
    var is_deposit = $('#security_amount:checked').val(); 
    var securityAmount = '<?=$refundable_amount?>';
    var advPercent = '<?=CABADVNCE?>';
    var fullAmount = '<?=$withonlinecharge?>';
    var discountAmount = parseInt( $('#discountAmount').text() );
    var afterDiscountPrice = parseFloat( fullAmount ) - parseFloat( discountAmount );
    var payableAmount = parseInt(afterDiscountPrice*advPercent/100); 
    
    var finalPayAmount = afterDiscountPrice;
    if( paymode === 'online'){
        finalPayAmount = payableAmount; 
    }
     
    var amountToShow = parseFloat( ( is_deposit === 'yes') ? (parseFloat( finalPayAmount ) + parseFloat( securityAmount )) : finalPayAmount ) ; 
    
    if( is_deposit === 'yes'){
        $('.secuAmt').show(); 
    }else{
        $('.secuAmt').hide(); 
    } 
     
    $('#payableAmount').html( amountToShow.toFixed(2) );  
}
</script> 
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>

function verifyId( orderid, payid, verifyUrl, amount ){
    
     $.ajax({
            type: 'POST',
            url: verifyUrl,
            data: {'order_id': orderid , 'payid': payid, 'amount':amount }, 
            beforeSend: ()=>{ $('#proceed').html('Proccessing...'); },
            success: function(res){
                console.log( res );
                var obj = JSON.parse(res);
                if( obj.url !== '' ){
                    window.location.href = obj.url; 
                }else{
                    alert( obj.message );
                }
            }
        });
}


function LoadRazorpay( keyId, amount , payid, fullName, emailId,phoneNo, orderId, verifyUrl ){ 
    
    var options = {
    "key": keyId, 
    "amount":  amount*100,
    "currency": "INR",
    "name": "<?=COMPANYNAME;?>",
    "description": "Cab Booking Amount for order ID: "+orderId,
    "image": "<?=LOGO?>",
    "order_id": "", 
    "handler": function (response){
        verifyId( orderId, response.razorpay_payment_id, verifyUrl, amount );
        console.log( response ); 
    },
    "prefill": { 
        "name": fullName, 
        "email": emailId, 
        "contact": phoneNo  
    },
    "notes": {
        "address": "<?=HEADOFFICE?>"
    },
    "theme": {
        "color": "#3399cc"
    }
};
var rzp1 = new Razorpay(options);
  rzp1.open();
rzp1.on('payment.failed', function (response){
        alert(response.error.code);
        // alert(response.error.description);
        // alert(response.error.source);
        // alert(response.error.step);
        // alert(response.error.reason);
        // alert(response.error.metadata.order_id);
        // alert(response.error.metadata.payment_id);
});

   
}
</script>

</body></html>
