</head>
<?php
$session_data = $this->session->userdata('adminloginstatus');
if(empty($session_data)){
  redirect( base_url('mylogin.html') ); exit;
}


/* set session check out system Start */
$timeout = 600;
if(isset($session_data) && isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    redirect( base_url('mylogin.html') ); exit;
    exit;
}

$_SESSION['last_activity'] = time();
/* Set session check out System End */




$user_type = $session_data['user_type'];
$loginUserName = $session_data['user_full_name'].' ( '.ucwords($user_type).' )';

?>

<body class="hold-transition skin-blue sidebar-mini" onLoad="viewmsg();">
<div class="wrapper">
<header class="main-header ">
    <!-- Logo -->
    <?php /*<a href="<?php echo adminurl('Dashboard');?>" class="logo"> 
      <span class="logo-mini"><b>A</b>RC</span> 
      <span class="logo-lg"> <center><?php echo PEADEXADMIN;?></center></span>
    </a>*/?>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button--> 

      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="pull-left headermenu">
        <h3 style="color: #fff"><?= checkdomain('domain');?> |  <?php echo isset($title) ? $title : '';?>  
        </h3>
      </div>

 
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
          </li>

          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
          </li>

          <li class="dropdown tasks-menu open">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
          </li>

        
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i>
              <span class="hidden-xs"><?php echo $loginUserName;?></span>
            </a>
            <ul class="dropdown-menu">  
              <li class="user-footer"> 
                <?php if($user_type=='admin'){?>
                  <a href="<?php echo adminurl('Changepassword');?>" class="btn btn-default btn-flat">Change Password</a> 
                  <a href="<?php echo adminurl('webconfig');?>" class="btn btn-default btn-flat">Web Config</a>
                  <?php }else{?>
                  <a href="<?php echo adminurl('Changerolepassword');?>" class="btn btn-default btn-flat">Change Password</a> 
                  <?php }?>
                  <a href="<?php echo adminurl('Changedomain');?>" class="btn btn-default btn-flat">Change Domain</a>
                  <a href="<?php echo adminurl('websettings');?>" class="btn btn-default btn-flat">Address Settings</a>
                  <a href="<?php echo adminurl('Logout');?>" class="btn btn-default btn-flat">Sign out</a> 
                   
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>