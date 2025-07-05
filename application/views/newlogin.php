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

               <div class="form-input loginmt">
                   <input type="password" name="password" class="form-control" placeholder="Password.." id="password" autocomplete="off" />
               </div>

               <div class="form-input loginmt">
                   <label style="color: #111"><input type="checkbox" name="is_remember" />&nbsp; Rememeber</label>
               </div>

               <div class="form-input ">
                   <button class="loginbtn" onclick="checkLogin();" id="sbtn" > LOGIN </button>
               </div>

               <div class="form-input spacer10">
                   <center style="color: #111; font-weight: 900">OR</center>
               </div>

               <div class="form-input spacer10">
                <a href="<?=base_url('login/otplogin?utm='.$utm);?>" class="loginbtn"> LOGIN WITH OTP </a> 
               </div>

               <div class="form-input spacer20">
                   <span style="color: #111; font-weight: 900">Don't have an account?</span>
               </div>

               <div class="form-input spacer10">
                   <a href="<?=base_url('login/signup?utm='.$utm);?>" class="loginbtn" style="background: #7aa147"> SIGNUP </a>
               </div>
               <div class="form-input spacer20">&nbsp;</div>

           </div>


         </div>
         <div class="col-lg-2 col-xs-12 col-md-0"></div>
  </div>
</div>
</section>  

<script type="text/javascript">
  var checkLogin = function(){
    var u,p,response;
    u = $('#username').val();
    p = $('#password').val();  
    $.ajax({
      type : 'POST',
      data : {'u':u,'p':p,'utm':'<?=$utm?>' },
      url  : '<?=base_url('login/loginwithpassowrd')?>',
      success : function(response){
         var status = response.trim();
         if( status == 'gotourl'){
             window.location.href='<?=base_url('reservation_form.html?utm='.$utm)?>'; 
          return;
         }else if( status == 'dashboard' ){
            window.location.href='<?=base_url('dashboard/index')?>'; 
            showBtn( status );
         }else if( status == 'novalid' ){ 
            showBtn( 'Invalid username/password' ); 
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
</script>
