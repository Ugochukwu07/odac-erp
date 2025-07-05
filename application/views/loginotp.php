<section class="vehiclebg vehiclefixed">
  <div class="container"> 
        <div class="row loginmt60">
         <div class="col-lg-2 col-xs-12 col-md-3 loginview"></div>
         <div class="col-lg-5 col-xs-12 col-md-3 loginview">
               <img src="<?=base_url('assets/images/login_screen.svg');?>" class="spacer20">
         </div>
         <div class="col-lg-3 col-xs-12 col-md-3 " style="background:#fff;">

           <div class="col-lg-12 spacer50">
               <div class="form-input">
                   <input type="text" name="username" class="form-control" placeholder="Mobile Number.." id="username" onkeyup="this.value=this.value.replace(/[^\d]/,'')" autocomplete="off" maxlength="10" />
               </div>

               <div class="form-input loginmt" style="display: none;" id="otpdiv">
                   <input type="otp" name="otp" class="form-control" placeholder="enter 4 digit OTP" id="otp" maxlength="4" onkeyup="this.value=this.value.replace(/[^\d]/,'')" autocomplete="off" />
               </div>

               

               <div class="form-input loginmt">
                   <button class="loginbtn" onclick="sendotp();" id="otpbtn" > Send OTP </button>
               </div> 

               <div class="form-input loginmt" style="display: none;" id="lbtn">
                   <button class="loginbtn" onclick="checkOtp();" id="sbtn" > LOGIN </button>
               </div> 
              

               <div class="form-input loginmt">
                   <span style="color: #111; font-weight: 900; display: none; cursor: pointer;" id="resend" onclick="sendotp();">Resend OTP</span>
               </div>
 
               <div class="form-input spacer20">&nbsp;</div>

           </div>


         </div>
         <div class="col-lg-2 col-xs-12 col-md-0"></div>
  </div>
</div>
</section>  

<script type="text/javascript">
  var checkOtp = function(){
    var u,p,response;
    u = $('#otp').val();  
    $.ajax({
      type : 'POST',
      data : {'otp':u,'utm':'<?=$utm?>'},
      url  : '<?=base_url('login/motp')?>',
      success : function(response){
         var status = response.trim();
         if( status == 'gotourl'){
             window.location.href='<?=base_url('reservation_form.html?utm='.$utm)?>'; 
          return;
         }else if( status == 'dashboard' ){
            window.location.href='<?=base_url('dashboard/index')?>'; 
            showBtn( status );
         }else if( status == 'expire' ){ 
            showBtn( 'OTP Expired' ); 
         }else if( status == 'repeat' ){ 
            window.location.href='<?=base_url('login/otplogin?utm='.$utm)?>';
         }

       
          
      }
    })


  }
  var showBtn = function(msg){
    $('#sbtn').html(msg); 
    $('#sbtn').css('background-color','red'); 
    setTimeout(function(){ 
      $('#sbtn').html('LOGIN'); 
      $('#sbtn').css('background-color','#F0C540'); },3000);
  }


var sendotp = function(){
    var u,p,response;
    u = $('#username').val(); 
    $('#username').hide();
    $('#lbtn').show();
    $('#otpbtn').hide(); 
    $('#otpdiv').show();
    $.ajax({
      type : 'POST',
      data : {'mob':u,'utm':'<?=$utm?>'},
      url  : '<?=base_url('login/sendotp')?>',
      success : function(response){
         var status = response.trim();
         if( status == 'sent' ){
            $('#resend').show();
         }else if( status == 'nouser' ){
             window.location.href='<?=base_url('login/signup?utm='.$utm)?>';
         }else if( status == 'nomob' ){ 
            showBtn( 'Username required' ); 
            $('#username').show();
         }

       
          
      }
    })


  }

</script>
