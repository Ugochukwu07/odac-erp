<!DOCTYPE html>
<html>
<head>
  <?php //echo $redirecthttp = redirectTohttps();
//echo $redirecthttp ? redirect($redirecthttp ) : ''; ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Private Panel for <?php echo PEADEXADMIN;?></title>
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
  <style>.border{ border-radius: 5px; height: 45px;}</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
      <center><img src="<?php echo DEFAULT_LOGO;?>" class="text-center" style="border-radius:20px" ></center>
    <a href="<?php echo base_url( adminfold('Login')); ?>" style="font-size: 24px; font-weight: 600; ">Sign in</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style=" padding: 0px;">
    
    <center><span style="font-size:15px; color:#999999"><?php echo notifications() ? notifications().'<br/><br/>' : '' ?></span></center> 
    <input type="hidden" id="showPassword" value="1" />
    <?=form_open( adminfold('Login') );?>
      <div class="form-group has-feedback">
   <?=form_input(array('type'=>'text','name'=>'email','class'=>'form-control border','id'=>'','placeholder'=>'Email or Mobile','max-length'=>'50','required'=>'required','autocomplete'=>'off')); ?>
       
      </div>
      <div class="form-group has-feedback">
      <?=form_input(array('type'=>'password','name'=>'password','class'=>'form-control border','id'=>'password','placeholder'=>'Password','max-length'=>'50','required'=>'required','autocomplete'=>'off')); ?>
       <span class="glyphicon glyphicon-eye form-control-feedback pointer" onclick="showPassword()" style="cursor: pointer;z-index: 10000;position: absolute; width: 45px;height: 45px; line-height: 38px;
    text-align: center;
    pointer-events: all;"><i class="fa fa-eye"></i></span>
      </div>
      <div class="row"> 
        <!-- /.col -->
        <div class="col-xs-12">
        <?=form_submit(array('type'=>'submit','class'=>'btn btn-primary btn-block border','value'=>'Sign In','style'=>"font-weight:600;font-size: 16px;background-color: #43baff;border-color: #43baff;"));?>
        </div>
        <!-- /.col -->
      </div>
     <?php  echo form_close();?>

    <div class="row">
     <div class="col-xs-12">
     <div class="social-auth-links text-center"> <br/>
      <a href="#" class="" style="color: #999999; font-weight:600"> Forgot your password?</a> 
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
function showPassword(){
    let ck = $('#showPassword').val();
    if( ck == 1){
        $("#password").attr("type", "text");
        $('#showPassword').val(0);
    }
    else if( ck == 0){
        $("#password").attr("type", "password");
        $('#showPassword').val(1);
    }
    
}


  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
