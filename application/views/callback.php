<style>label{color:#111111;} #texthtml{ color:red ; font-size: 15px}</style>
<section class="vehiclebg vehiclefixed">
  <div class="container"> 
        <div class="row loginmt60"> 
         <div class="col-lg-5 col-xs-12 col-md-3 loginview">
               <img src="<?=base_url('assets/images/login_screen.svg');?>" class="spacer20">
         </div>
         <div class="col-lg-7 col-xs-12 col-md-7 " style="background:#fff;">

           <div class="col-lg-12 ">
               
                    <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-xs-12 spacer_20  pull-left">
                    <div class="panel panel-default">
                    <div class="panel-heading"><span class="personalinfoarmation">Get in touch with us</span></div>
                    <div class="panel-body searchRentals">  
                    
                    
                    <div class="row11 ">  
                    <div class="col-lg-12 col-md-12 col-xs-12">
                    <span  id="texthtml"></span>
                    </div>
                    </div>
                
                    <div class="row11 form">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                    <label>Full Name</label>
                    <div class="form-group">
                    <input type="text" name="fullname" placeholder="Full Name"  id="firstname" value="" class="form-control"/>
                    </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xs-12">
                    <label>Mobile Number</label>
                    <div class="form-group">
                    <input type="text" placeholder="Mobile Number"  name="mobileno" value="" id="mobileno" maxlength="10" class="form-control"/>
                    </div>
                    </div>
                    
                    <div class="col-lg-12 col-md-12 col-xs-12">
                    <label>Email ID</label>
                    <div class="form-group">
                    <input type="email" placeholder="Email Address"  name="emailid" id="emailid" value="" class="form-control"/>
                    </div>
                    </div>
                    </div>
                    
                    <div class="row11">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                    <label>Choose a Service</label>
                    <div class="form-group">
                        <select name="c_trip" id="c_trip" required="required" class="form-control select22 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                        <option value="" selected="selected">-- Select Trip Type-- </option>
                        <option value="Bike Rental">Bike Rental</option>
                        <option value="Outstaion">Outstaion</option>
                        <option value="Self Drive">Self Drive</option>
                        <option value="Monthly Rental">Monthly Rental</option>
                        </select>
                    </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xs-12">
                    <label>I want a car in</label>
                    <div class="form-group">
                    <?=form_dropdown(array('name'=>'sourcecity','class'=>'form-control','id'=>'sourcecity','onchange'=>"getCityName( this.value );"),createDropdown($citylist,'id','cityname','Cityname' ) );?>
                    <input type="hidden" value="" id="sourcecity_name" name="sourcecity_name" />
                    </div>
                    </div> 
                    </div>
                    
                    
                    <div class="row11 "> 
                    <div class="col-lg-12 col-md-12 col-xs-12">
                    <label>Some Remark</label>
                    <div class="form-group">
                    <input type="text" placeholder="Enter Some remark"  name="remark" id="remark" value="" maxlength="150"  class="form-control"/>
                    </div>
                    </div>
                    </div>
                    
                    <?php $code = rand(1111,999); ?>
                    
                    <div class="row11 ">  
                    <div class="col-lg-4 col-md-4 col-xs-12">
                    <label>Enter Captua Code </label>
                    <div class="form-group">
                    <input type="text" placeholder="Enter Captua Code"  name="captua_code" value="" id="captua_code" maxlength="4" class="form-control numbersOnly"/>
                    </div>
                    </div>
                    
                    <div class="col-lg-2 col-md-2 col-xs-12">
                        <label>. </label>
                    <div class="form-group" style="font-size: 20px;
    background: #e5e5e5;
    width: 100%;
    text-align: center;
    padding: 7px;
    border-radius: 5px;  
    font-weight: 600; 
    font-size: 20px;
    -webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;">
                    <?=$code;?>
                    </div>
                    </div>
                    
                    <div class="col-md-6  pull-right col-xs-12 spacer_20">
                        <input type="hidden" name="captua_code" id="hi_captua_code" value="<?=$code?>">
                    <button type="button" onclick="postEnData();" class="search"> Get A Callback <i class="fa fa-arrow-right"></i> </button>
                    </div>
                    </div>
                    
                    
                
               
               
               <div class="form-input spacer20">&nbsp;</div> 
           </div>
           
            


         </div>
         <div class="col-lg-2 col-xs-12 col-md-0"></div>
  </div>
</div>
</section>  


<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
  
<script type="text/javascript">
  function postEnData() {
    const firstname = $('#firstname').val();
    const mobileno = $('#mobileno').val();
    const emailid = $('#emailid').val();
    const c_trip = $('#c_trip').val();
    const sourcecity = $('#sourcecity').val();
    const sourcecity_name = $('#sourcecity_name').val();
    const remark = $('#remark').val();
    const captua_code = $('#captua_code').val();
    const hi_captua_code = $('#hi_captua_code').val();
    
    if( firstname === '' ){
        return sweatalet('Please Enter Full Name');
    }
    else if( mobileno === '' ){
        return sweatalet('Please Enter 10 Digit Mobile Number');
    }
    else if( emailid === '' ){
        return sweatalet('Please Enter Valid Email Id');
    }
    else if( c_trip === '' ){
        return sweatalet('Please Select Service Type');
    }
    else if( sourcecity === '' ){
        return sweatalet('Please Select Service City');
    }
    else if( remark === '' ){
        return sweatalet('Please Enter Some Remark');
    }
    else if( captua_code !== hi_captua_code ){
        return sweatalet( 'Please Enter Valid Captua Code');
    }
    
    
    $.ajax({
      type : 'POST',
      data : {'fullname':firstname,'mobileno':mobileno,'emailid':emailid,'c_trip':c_trip,'sourcecity': sourcecity, 'sourcecity_name':sourcecity_name, 'remark':remark, 'captua_code': captua_code , 'hi_captua_code': hi_captua_code },
      url  : '<?=base_url('push_callback.php')?>',
      success : function(response){
         const obj = JSON.parse( response );
          if( !obj.status ){
              return sweatalet( obj.message );
          }else{
               sweatalet( obj.message );
               setTimeout( ()=>{ window.location.href='<?=base_url('');?>' },500 ); 
          } 
      }
    })


  }
  
  $(document).ready(function () {   
  
        jQuery('#mobileno').keyup(function () { 
		this.value = this.value.replace(/[^0-9\.]/g,'');
		});
		
		jQuery('#firstname').keyup(function () { 
		this.value = this.value.replace(/[^a-zA-Z\s]+$/g,'');
		}); 
		
		jQuery('#remark').keyup(function () {   
		this.value = this.value.replace(/[^A-Za-z0-9//,.\/\s]/g,'');
		
		});
		
  });
 
 function sweatalet( msg ){
     $('#texthtml').html( msg );
     setTimeout( ()=>{ $('#texthtml').html( '' ); },1000 ); 
 }
 
 function getCityName( id ){
     const cityname = $('#sourcecity option:selected').text();
     $('#sourcecity_name').val( cityname );
 }

</script>