<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User OTP</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin'); ?>/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin'); ?>/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin'); ?>/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin'); ?>/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin'); ?>/plugins/iCheck/square/blue.css">
 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?=$posturl;?>"><b>Enter 4 Digit OTP</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    
   
    
    
      <div class="form-group has-feedback">
      <?=form_input(array('type'=>'text','name'=>'otp','class'=>'form-control','id'=>'otp','placeholder'=>'Enter 4 Digit OTP','maxlength'=>'4','required'=>'required','autocomplete'=>'off')); ?>
       <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div> 
      <div class="row"> 
        <!-- /.col -->
        <div class="col-xs-6">
          <button class="btn btn-primary btn-block btn-flat" onclick="checkotp()" id="btns" ><span id="submitbtn">Submit</span></button> 
        </div>

         <div class="col-xs-6 text-right">
           <button class="btn btn-block btn-flat" onclick="resendotp()" id="btnr" disabled ><span id="resendotp">Resend OTP</span></button> 
        </div>
        <!-- /.col -->
      </div>
    
    
  </div>


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/admin'); ?>/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/admin'); ?>/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/admin'); ?>/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });

  $('#otp').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
  });

 function checkotp(){
  var otp = $('#otp').val();
  var utm = '<?=$utm;?>';
  if(!otp){ alert('OTP is Blank!'); return;  }
  else if(otp.length != 4 ){ alert('Enter 4 Digit OTP send at your Registered Mobile Number!'); return;  }
  $.ajax({
    type:'POST',
    url:'<?=PEADEX.'login/motp'?>',
    data:{'otp':otp,'utm':utm},
    beforeSend:function(){ $('#submitbtn').html('Processing..'); 
    $('#btns').attr('disabled',true); },
    success:function(res){  
      var obj = JSON.parse( JSON.stringify(res));
        if(obj.status){
          var gurl = obj.gotourl ;  
          window.location.href = ''+gurl;
        }else{ alert(obj.msg);}

        $('#btnr').removeAttr('disabled',false);
        $('#btns').removeAttr('disabled',false);
        $('#submitbtn').html('Submit');
        $('#otp').val('');
    }
  });
 } 


  function resendotp(){ 
  var utm = '<?=$utm;?>';
  $.ajax({
    type:'POST',
    url:'<?=PEADEX.'login/resendotp'?>',
    data:{'utm':utm},
    beforeSend:function(){ $('#btnr').html('Processing..'); 
    $('#btnr').attr('disabled',true); },
    success:function(res){   
         alert('OTP send Successfully at your registered mobile number!');  
        $('#btnr').html('Resend OTP');
    }
  });
 } 

</script>
</body>
</html>
