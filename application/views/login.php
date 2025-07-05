<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User Login</title>
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
    <a href="<?=$posturl;?>"><b>Login with Mobile</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    
   
    
    
      <div class="form-group has-feedback">
      <?=form_input(array('type'=>'text','name'=>'mobile','class'=>'form-control','id'=>'mobileno','placeholder'=>'Enter 10 Digit Mobile Number','maxlength'=>'10','required'=>'required','autocomplete'=>'off')); ?>
       <span class="glyphicon glyphicon-phone form-control-feedback"></span>
      </div> 
      <div class="row"> 
        <!-- /.col -->
        <div class="col-xs-12">
          <button class="btn btn-primary btn-block btn-flat" onclick="checklogin()" id="btns" ><span id="submitbtn">Send OTP</span></button> 
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

  $('#mobileno').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
  });

 function checklogin(){
  var mob = $('#mobileno').val();
  var utm = '<?=$utm;?>';
  if(!mob){ alert('Mobile Number is Blank!'); return;  }
  else if(mob.length != 10 ){ alert('Enter 10 Digit Mobile Number!'); return;  }
  $.ajax({
    type:'POST',
    url:'<?=PEADEX.'login/sendotp'?>',
    data:{'mob':mob,'utm':utm},
    beforeSend:function(){ $('#submitbtn').html('Sending Message..'); $('#btns').attr('disabled',true); },
    success:function(res){  
      var obj = JSON.parse( JSON.stringify(res));
        if(obj.status){
          var gurl = obj.gotourl ;  
          window.location.href = ''+gurl;
        }else{ alert('Some Error Occured!');}
    }
  });
 } 

</script>
</body>
</html>
