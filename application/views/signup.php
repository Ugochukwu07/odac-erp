<section class="vehiclebg vehiclefixed">
  <div class="container">
        <h2 class="vehicle">&nbsp;</h2>
        <div class="row spacer60">
         <div class="col-lg-2 col-xs-12 col-md-3"></div>
         <div class="col-lg-5 col-xs-12 col-md-3 loginview">
               <img src="<?=base_url('assets/images/login_screen.svg');?>" class="spacer20">
         </div>
         <div class="col-lg-3 col-xs-12 col-md-3 " style="background:#fff;">

           <div class="col-lg-12 spacer50">
               <div class="form-input">
                   <input type="text" id="firstname" class="form-control" placeholder="Firstname *" autocomplete="off"  />
               </div>

               <div class="form-input loginmt">
                   <input type="email" id="email" class="form-control" placeholder="Email *" autocomplete="off" required="required" />
               </div>

              <div class="form-input loginmt">
                 <input type="text" id="mobile" class="form-control" placeholder="Mobile Number *" onkeyup="this.value=this.value.replace(/[^\d]/,'')" autocomplete="off" maxlength="10" />
              </div>

              <div class="form-input loginmt">
                   <input type="text" id="password" class="form-control" placeholder="Password *" autocomplete="off" />
               </div> 
                

               <div class="form-input spacer20">
                   <button class="loginbtn" onclick="singUp()" id="sbtn" > SIGNUP </button>
               </div>

               <div class="form-input spacer10">
                   <center style="color: #111;"><a href="<?=base_url('login/index?utm='.$utm);?>">Back To Login</a></center>
               </div> 
               
               <div class="form-input spacer20">&nbsp;</div>

           </div>


         </div>
         <div class="col-lg-2 col-xs-12 col-md-0"></div>
  </div>
</div>
</section>  

<script type="text/javascript">
  var singUp = function(){
    var e,f,m,p,response;
    f = $('#firstname').val();
    e = $('#email').val();
    m = $('#mobile').val();
    p = $('#password').val();  
    $.ajax({
      type : 'POST',
      data : {'f':f,'e':e,'m':m,'p':p},
      url  : '<?=base_url('login/register')?>',
      success : function(response){
        var status = response.trim();
         if( status != 'done'){
          showBtn( status );
          return;
         }
         window.location.href='<?=base_url('login/index?utm='.$utm)?>';
      }
    })


  }
  var showBtn = function(msg){
    $('#sbtn').html(msg); 
    $('#sbtn').css('background-color','red'); 
    setTimeout(function(){ 
      $('#sbtn').html('SIGNUP'); 
      $('#sbtn').css('background-color','#F0C540'); },3000);
  }
</script>
