</head>

<body>
<!-- Top Bar -->
<section class="top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2 col-xs-6">
                <div class="phone">
                    <img src="<?=base_url('assets/')?>images/call_ranatravels.png" width="20" height="20" alt="Phone">
                    <a href="tel:+91<?=SMSADMINMOBILE;?>"> +91-<?=SMSADMINMOBILE;?></a>
                </div>
            </div>

            <?php if($this->session->userdata('frontbooking')){ ?>
            <div class="col-lg-3 col-xs-6 pull-right viewonDesktop">
                <div class="login text-right toplogin">
                    <i class="fa fa-table"></i><a href="<?=base_url('dashboard/index')?>">Bookings </a> &nbsp;| <i class="fa fa-sign-out"></i><a href="<?=base_url('login/logout');?>"> Logout </a> 
                </div>
            </div>
            <?php }else{?>
            <div class="col-lg-3 col-xs-6 pull-right viewonDesktop">
                <div class="login text-right toplogin">
                    <i class="fa fa-sign-in"></i><a href="<?=base_url('login/index')?>"> Signin </a> &nbsp;| <i class="fa fa-sign-out"></i><a href="<?=base_url('login/signup');?>"> Signup </a> 
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</section>

<!-- Main Navigation -->
<header class="sticky">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="<?php echo PEADEX;?>">
                <img src="<?php echo DEFAULT_LOGO;?>" width="160" alt="Rana cabs Pvt Ltd." />
            </a>
            
            <!-- Mobile Icons -->
            <div class="d-lg-none">
                <a href="tel:<?php echo SMSADMINMOBILE;?>" class="phoneicon">
                    <i class="fa fa-phone"></i>
                </a>
                <a href="http://wa.me/919041412141" class="usericon">
                    <i class="fa fa-whatsapp"></i>
                </a>
            </div>
            
            <!-- Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mgright">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo PEADEX;?>">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PEADEX;?>car-bike-reservation.php">Rent A Car</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PEADEX;?>rent-a-bike-chandigarh.php">Rent A Bike</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PEADEX;?>self-drive-in-chandigarh.php">Self Drive</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PEADEX;?>terms-conditions.php">Terms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PEADEX;?>contact-us.php">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>