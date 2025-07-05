</head>

<body>
<section class="top">
<div class="container">
<div class="row">
<div class="col-lg-2 col-xs-6">
<div class="phone"><img src="<?=base_url('assets/')?>images/call_ranatravels.png" width="20" height="20"><a href="tel:+91<?=SMSADMINMOBILE;?>"> +91-<?=SMSADMINMOBILE;?></a></div>
</div>

<?php if($this->session->userdata('frontbooking')){ ?>
<div class="col-lg-3 col-xs-6 pull-right viewonDesktop">
<div class="login  text-right toplogin">
<i class="fa fa-table"></i><a href="<?=base_url('dashboard/index')?>">Bookings </a> &nbsp;| <i class="fa fa-sign-out"></i><a href="<?=base_url('login/logout');?>"> Logout </a> 
</div>
</div>
<?php }else{?>
<div class="col-lg-3 col-xs-6 pull-right viewonDesktop">
<div class="login  text-right toplogin">
<i class="fa fa-sign-in"></i><a href="<?=base_url('login/index')?>"> Signin </a> &nbsp;| <i class="fa fa-sign-out"></i><a href="<?=base_url('login/signup');?>"> Signup </a> 
</div>
</div>
<?php }?>

</div>
</div>
</section>






<section>
<header class="sticky" >
<nav class="navbar bggrey header-height">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo PEADEX;?>"><img src="<?php echo DEFAULT_LOGO;?>" width="160" alt="Rana cabs Pvt Ltd." /></a> 
       <a href="tel:<?php echo SMSADMINMOBILE;?>" class="phoneicon"> <i class="fa fa-phone"></i></a>
      <a href="http://wa.me/919041412141" class="usericon"> <i class="fa fa-whatsapp"></i></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse navbar-right " id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav mgright ">
        <li class="active"><a href="<?php echo PEADEX;?>">Home <span class="sr-only">(current)</span></a></li>
        <li><a href="<?php echo PEADEX;?>car-bike-reservation.php">Rent A Car</a></li>
        <li><a href="<?php echo PEADEX;?>rent-a-bike-chandigarh.php">Rent A Bike</a></li>
        <li><a href="<?php echo PEADEX;?>self-drive-in-chandigarh.php">Self Drive</a></li>
        <li><a href="<?php echo PEADEX;?>terms-conditions.php">Terms</a></li>
        <li><a href="<?php echo PEADEX;?>contact-us.php">Contact Us</a></li>
        <!--<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>-->
      </ul>
     
     <?php /* <ul class="nav navbar-nav navbar-right">
        <li><a href="http://wa.me/919041412141" class="usericon"> <i class="fa fa-whatsapp"></i></a> </li>
        <li><a href="tel:<?php echo SMSADMINMOBILE;?>"><i class="fa fa-phone iphone"></i><span><?php echo SMSADMINMOBILE;?></span></a></li>
      </ul> */?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

 </header>
</section>