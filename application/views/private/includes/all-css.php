<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo COMPANYNAME;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Bootstrap 5.3.2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/modern/bootstrap-5.3.2.min.css">
  
  <!-- Modern Admin Theme -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/modern/modern-admin-theme.css">
  
  <!-- Font Awesome 4.7.0 (Load after other CSS to ensure proper precedence) -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/font-awesome/css/font-awesome.min.css">
  
  <!-- Admin Compatibility Layer -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/modern/admin-compatibility.css">
  
  <!-- Legacy Support - Keep for backward compatibility -->
  <!-- Ionicons (for existing icons) -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/Ionicons/css/ionicons.min.css">
  
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/morris.js/morris.css">
  
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/jvectormap/jquery-jvectormap.css">
  
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/bootstrap-daterangepicker/daterangepicker.css">
  
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- Legacy responsive CSS -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/responsive.css">
  
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/admin/select2/dist/css/select2.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <!-- Custom styles for specific components -->
  <style>
    /* Ensure proper spacing for admin layout */
    body { 
      font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #ecf0f5;
    }
    
    /* Fix for existing admin components */
    .main-header .navbar {
      margin-left: 250px;
    }
    
    .content-wrapper {
      margin-left: 250px;
      min-height: calc(100vh - 60px);
      background-color: #ecf0f5;
    }
    
    /* Ensure proper z-index for modals */
    .modal {
      z-index: 1050;
    }
    
    .modal-backdrop {
      z-index: 1040;
    }
    
    /* Fix for dropdown menus */
    .dropdown-menu {
      z-index: 1000;
    }
    
    /* Ensure proper styling for existing forms */
    .form-control:focus {
      border-color: #0e5074;
      box-shadow: 0 0 0 0.2rem rgba(14, 80, 116, 0.25);
    }
    
    /* Fix for existing buttons */
    .btn-primary {
      background-color: #0e5074;
      border-color: #0e5074;
    }
    
    .btn-primary:hover {
      background-color: #0a3a5a;
      border-color: #0a3a5a;
    }
    
    /* Ensure Font Awesome icons display properly */
    .fa {
      display: inline-block !important;
      font: normal normal normal 14px/1 FontAwesome !important;
      font-size: inherit !important;
      text-rendering: auto !important;
      -webkit-font-smoothing: antialiased !important;
      -moz-osx-font-smoothing: grayscale !important;
    }
    
    /* Ensure icon containers have proper styling */
    .info-box-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: inline-block;
      text-align: center;
      line-height: 60px;
      font-size: 24px;
      color: white;
      margin-right: 15px;
    }
  </style>