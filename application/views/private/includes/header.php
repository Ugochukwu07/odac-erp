</head>
<?php
/*
 | Fix header dropdown behavior
 | - Remove temporary debug background styling that affected dropdown layout
 | - Keep head closing tag intact; all required CSS is loaded from `all-css.php`
 */
?>
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




// Get user roles from session (RBAC-aware)
$user_roles = isset($session_data['user_roles']) ? $session_data['user_roles'] : [];
$primary_role = !empty($user_roles) ? $user_roles[0] : 'User'; // Use first role as primary
$loginUserName = $session_data['user_full_name'].' ( '.ucwords($primary_role).' )';

// For backward compatibility, set user_type based on roles
$user_type = 'admin'; // Default
if (!empty($user_roles)) {
    if (in_array('Super Admin', $user_roles)) {
        $user_type = 'admin';
    } elseif (in_array('Manager', $user_roles)) {
        $user_type = 'manager';
    } elseif (in_array('User', $user_roles)) {
        $user_type = 'user';
    }
}

// Make RBAC helper functions available in views
if (!function_exists('has_permission')) {
    require_once APPPATH . 'helpers/rbac_helper.php';
}

?>

<body class="hold-transition skin-blue sidebar-mini" onLoad="viewmsg();">
<div class="wrapper">
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo adminurl('Dashboard');?>" class="navbar-brand">
      <span class="logo-mini"><b>O</b>DE</span> 
      <span class="logo-lg"><?php echo COMPANYNAME;?></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-expand-lg navbar-static-top">
      <div class="container-fluid">
        <!-- Sidebar toggle button--> 
        <button class="navbar-toggler sidebar-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Header Menu -->
        <div class="navbar-nav me-auto">
          <div class="headermenu">
            <h3 style="color: #fff; margin: 0;"><?= checkdomain('domain');?> | <?php echo isset($title) ? $title : '';?></h3>
          </div>
        </div>

        <!-- Navbar Custom Menu -->
        <div class="navbar-nav ms-auto">
          <!-- Messages: style can be found in dropdown.less-->
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-envelope-o"></i>
              <span class="badge bg-success">4</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Message 1</a></li>
              <li><a class="dropdown-item" href="#">Message 2</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">View all messages</a></li>
            </ul>
          </div>

          <!-- Notifications -->
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o"></i>
              <span class="badge bg-warning">10</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Notification 1</a></li>
              <li><a class="dropdown-item" href="#">Notification 2</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">View all notifications</a></li>
            </ul>
          </div>

          <!-- Tasks -->
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-flag-o"></i>
              <span class="badge bg-danger">9</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Task 1</a></li>
              <li><a class="dropdown-item" href="#">Task 2</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">View all tasks</a></li>
            </ul>
          </div>

          <!-- User Account: style can be found in dropdown.less -->
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-user"></i>
              <span class="d-none d-lg-inline"><?php echo $loginUserName;?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li class="dropdown-header">User Menu</li>
              <?php if($user_type=='admin'){?>
                <li><a class="dropdown-item" href="<?php echo adminurl('Changepassword');?>"><i class="fa fa-key me-2"></i>Change Password</a></li>
                <li><a class="dropdown-item" href="<?php echo adminurl('webconfig');?>"><i class="fa fa-cog me-2"></i>Web Config</a></li>
              <?php }else{?>
                <li><a class="dropdown-item" href="<?php echo adminurl('Changerolepassword');?>"><i class="fa fa-key me-2"></i>Change Password</a></li>
              <?php }?>
              <li><a class="dropdown-item" href="<?php echo adminurl('Changedomain');?>"><i class="fa fa-globe me-2"></i>Change Domain</a></li>
              <li><a class="dropdown-item" href="<?php echo adminurl('websettings');?>"><i class="fa fa-map-marker me-2"></i>Address Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?php echo adminurl('Logout');?>"><i class="fa fa-sign-out me-2"></i>Sign out</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>