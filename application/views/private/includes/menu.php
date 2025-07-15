<?php
$session_data = $this->session->userdata('adminloginstatus');
if(empty($session_data)){
  redirect( base_url('mylogin.html') ); exit;
}

// RBAC-aware user type and menu handling
$user_roles = isset($session_data['user_roles']) ? $session_data['user_roles'] : [];
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

// For now, use the old menu system but make it RBAC-aware
// TODO: Convert to use permissions instead of menu IDs
$user_menu_ids = !empty($session_data['logindata']['menuids']) ? $session_data['logindata']['menuids'] : '';
$user_menu_ids = !empty($user_menu_ids) ? explode(',', $user_menu_ids) : [];

// Make RBAC helper functions available in views
if (!function_exists('has_permission')) {
    require_once APPPATH . 'helpers/rbac_helper.php';
}

$segment = strtolower( ci()->uri->segment(2) );
$getmenu_list = file_get_contents('uploads/menu/menulist.txt');
$menu_ids_list = [];
$is_url_ckecked = false;
if(!empty($getmenu_list)){
  $getmenu_list = json_decode( $getmenu_list , true );
  foreach ($getmenu_list as $key => $menuvalue) {
     $collect_ids = [];
     $menu_ids_list[] = $menuvalue['id'];
         if($user_type == 'roll'){ 
           if( $segment == $menuvalue['menu_url'] ){
                  $parent_id = $menuvalue['parent_id'];
                  $collect_ids[] = $menuvalue['id'];
                  $collect_ids[] = $parent_id;
                  $x = 1;
                  $level = $menuvalue['menu_level'];
                  do{
                   $parent_id = get_parent_id_s($getmenu_list,$parent_id);
                   if(!empty($parent_id)){
                     $collect_ids[] = $parent_id;
                   } 
                  $x++;
                  }while( $x < $level); 

       $is_exists = (count(array_intersect($user_menu_ids, $collect_ids))) ? true : false; 
                  if(!$is_exists){ 
                    redirect( adminurl('dashboard') );
                    exit;
                  }
                  
           }
         }
  }
}


if($user_type == 'admin'){
$user_menu_ids = $menu_ids_list;
}

if(!function_exists('get_parent_id_s')){
    function get_parent_id_s($listdata,$id){ 
        $collect_id = '';
        foreach ($listdata as $key => $value) {
           if($value['id']==$id && $value['parent_id']!= 0 ){
              $collect_id = $value['parent_id']; 
                  break;          
           }
        }
        return $collect_id;
    } 
}

?>


  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="image">
         <center><img src="<?php echo DEFAULT_LOGO;?>" class="text-center" style="" ></center>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
     <?php if( in_array(1, $user_menu_ids)){ ?>    
     <li><a href="<?php echo adminurl('dashboard');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
     <?php }?>
   

<?php if( in_array(2, $user_menu_ids)){ ?>
<li class="treeview listings">
          <a href="javascript:void(0)">
            <i class="fa fa-briefcase"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

        <ul class="treeview-menu">
                        
                <li class="treeview">
                          <a href="javascript:void(0);"><i class="fa fa-circle-o"></i>Location
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                <ul class="treeview-menu">
                <li><a href="<?php echo adminurl('Addcity');?>"><i class="fa fa-circle-o"></i> Add City</a></li>
                <li><a href="<?php echo adminurl('Viewcity');?>"><i class="fa fa-circle-o"></i> View City</a></li>
                <li><a href="<?php echo adminurl('Addstate');?>"><i class="fa fa-circle-o"></i> Add State</a></li>
                <li><a href="<?php echo adminurl('Viewstate');?>"><i class="fa fa-circle-o"></i> View State</a></li>  
                </ul> 
                </li>  



                <?php if( in_array(8, $user_menu_ids)){ ?>
                <li class="treeview">
                          <a href="javascript:void(0);"><i class="fa fa-circle-o"></i>Vehicle
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                <ul class="treeview-menu">
                <li><a href="<?php echo adminurl('Addvehicle');?>"><i class="fa fa-circle-o"></i> Add Vehicle</a></li>
                <li><a href="<?php echo adminurl('Viewvehicle');?>"><i class="fa fa-circle-o"></i> View Vehicle</a></li>
                <li><a href="<?php echo adminurl('Configurevehicle');?>"><i class="fa fa-circle-o"></i> Add Vehicle Number</a></li>
                <li><a href="<?php echo adminurl('Viewvehiclelist');?>"><i class="fa fa-circle-o"></i> Vehicle List</a></li>  
                </ul>
                </li> 
                <?php }?>
                
                <?php if( in_array(8, $user_menu_ids)){ ?>
                <li class="treeview">
                          <a href="javascript:void(0);"><i class="fa fa-circle-o"></i>Insurance Company
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                <ul class="treeview-menu">
                <li><a href="<?php echo adminurl('Add_company');?>"><i class="fa fa-circle-o"></i> Add Company</a></li>
                <li><a href="<?php echo adminurl('View_company');?>"><i class="fa fa-circle-o"></i> View Company</a></li>  
                </ul>
                </li> 
                <?php }?>


                <?php if( in_array(13, $user_menu_ids)){ ?>
                <li class="treeview">
                          <a href="javascript:void(0);"><i class="fa fa-circle-o"></i>Booking Terms
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                <ul class="treeview-menu">
                <li><a href="<?php echo adminurl('Addbookingterms');?>"><i class="fa fa-circle-o"></i> Add </a></li>
                <li><a href="<?php echo adminurl('Viewbookingterms');?>"><i class="fa fa-circle-o"></i> View </a></li>  
                </ul>
                </li> 
                <?php }?>
                
                <?php if( in_array(66, $user_menu_ids)){ ?>
                <li class="treeview">
                          <a href="javascript:void(0);"><i class="fa fa-circle-o"></i>Booking Cancel Terms
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                <ul class="treeview-menu">
                <li><a href="<?php echo adminurl('Cancelterms');?>"><i class="fa fa-circle-o"></i> Add </a></li>
                <li><a href="<?php echo adminurl('Cancelterms/view');?>"><i class="fa fa-circle-o"></i> View </a></li>  
                </ul>
                </li> 
                <?php }?>


                <?php if( in_array(16, $user_menu_ids)){ ?>
                <li class="treeview">
                          <a href="javascript:void(0);"><i class="fa fa-circle-o"></i>Edit Approval Reason
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                <ul class="treeview-menu">
                <li><a href="<?php echo adminurl('Editapprovalreason');?>"><i class="fa fa-circle-o"></i> Add </a></li>
                <li><a href="<?php echo adminurl('Editapprovalreason/view');?>"><i class="fa fa-circle-o"></i> View </a></li>  
                </ul>
                </li> 
                <?php }?>



                <?php if( in_array(19, $user_menu_ids)){ ?>
                <li class="treeview">
                          <a href="javascript:void(0);"><i class="fa fa-circle-o"></i>Upload Banner
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                <ul class="treeview-menu">
                <li><a href="<?php echo adminurl('Addbanner');?>"><i class="fa fa-circle-o"></i> Add </a></li>
                <li><a href="<?php echo adminurl('Viewbanner');?>"><i class="fa fa-circle-o"></i> View </a></li>  
                </ul>
                </li>
                <?php }?>
  
        </ul>       
        </li>  
        
<?php }?>


<?php if( in_array(22, $user_menu_ids)){ ?>
<li class="treeview">
                  <a href="javascript:void(0);"><i class="fa fa-rupee"></i>Price Master
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo adminurl('Addfare');?>"><i class="fa fa-circle-o"></i> Add Fare</a></li>
                <li><a href="<?php echo adminurl('Viewfare');?>"><i class="fa fa-circle-o"></i> View Fare</a></li>
                <li><a href="<?php echo adminurl('Addcoupon');?>"><i class="fa fa-circle-o"></i> Add Coupon</a></li>
                <li><a href="<?php echo adminurl('Viewcoupon');?>"><i class="fa fa-circle-o"></i> View Coupon</a></li> 
            </ul>
            </li>
<?php }?>


<?php if( in_array(27, $user_menu_ids)){ ?>
<li class="treeview listings">
    <a href="javascript:void(0);">
    <i class="fa fa-table"></i> <span>Driver</span>
    <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
    <li><a href="<?php echo adminurl('Registerdriver');?>"><i class="fa fa-circle-o"></i> Add Driver</a></li>
    <li><a href="<?php echo adminurl('Viewdriver?filterby=&requestparam=&uniqueid=');?>"><i class="fa fa-circle-o"></i> View Driver</a></li>   
    </ul>
 </li>
<?php }?>
 

<?php if( in_array(30, $user_menu_ids)){ ?>
<li class="treeview listings">
    <a href="javascript:void(0);">
    <i class="fa fa-table"></i> <span>Bookings</span>
    <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="<?php echo adminurl('Bookingview/?type=new');?>"><i class="fa fa-dashboard"></i> <span> New </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=approved');?>"><i class="fa fa-dashboard"></i> <span> Approved </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=today');?>"><i class="fa fa-dashboard"></i> <span> Today </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=upcoming');?>"><i class="fa fa-dashboard"></i> <span> Upcoming </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=driverpending');?>"><i class="fa fa-dashboard"></i> <span> Driver Pending </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=assigneddriver');?>"><i class="fa fa-dashboard"></i> <span> Driver Assigned </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=run');?>"><i class="fa fa-dashboard"></i> <span> Running </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=cancel');?>"><i class="fa fa-dashboard"></i> <span> Cancel </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=reject');?>"><i class="fa fa-dashboard"></i> <span> Rejected </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=complete');?>"><i class="fa fa-dashboard"></i> <span> Completed </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=temp');?>"><i class="fa fa-dashboard"></i> <span> Bounce Booking </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=restamount');?>"><i class="fa fa-dashboard"></i> <span> Rest Amount Bookings </span></a></li>
        <li><a href="<?php echo adminurl('Bookingview/?type=refund');?>"><i class="fa fa-dashboard"></i> <span> Refund Amount Bookings </span></a></li>
    </ul>
 </li>
<?php }?>



<?php if( in_array(32, $user_menu_ids)){ ?>
  <li><a href="<?php echo adminurl('customerlist');?>"><i class="fa fa-table"></i> <span>Customer List</span></a></li>
<?php }?>

<?php if( in_array(33, $user_menu_ids)){ ?>
     <li class="treeview listings">
          <a href="#">
            <i class="fa fa-briefcase"></i> <span>CMS Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        <ul class="treeview-menu">
            <li class="treeview">
                  <a href="javascript:void(0);"><i class="fa fa-circle-o"></i>Add Vehicle CMS Page
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
            <ul class="treeview-menu">
            <li><a href="<?php echo adminurl('Addvehiclecmspage');?>"><i class="fa fa-circle-o"></i> Add </a></li>
            <li><a href="<?php echo adminurl('Viewvehiclecms');?>"><i class="fa fa-circle-o"></i> View </a></li> 
            </ul>
            </li> 

            <li class="treeview">
                  <a href="javascript:void(0);"><i class="fa fa-circle-o"></i>Other Pages
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
            <ul class="treeview-menu">
            <li><a href="<?php echo adminurl('Addcmspage');?>"><i class="fa fa-circle-o"></i> Add </a></li>
            <li><a href="<?php echo adminurl('Viewcmspage');?>"><i class="fa fa-circle-o"></i> View </a></li>
            </ul>
            </li>
            <li class="treeview">
                  <a href="javascript:void(0);"><i class="fa fa-circle-o"></i>SEO Pages
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
            <ul class="treeview-menu">
            <li><a href="<?php echo adminurl('addseopage');?>"><i class="fa fa-circle-o"></i> Add </a></li>
            <li><a href="<?php echo adminurl('Viewseopage');?>"><i class="fa fa-circle-o"></i> View </a></li>
            </ul>
            </li>  
        </ul>
     </li>
     <?php }?>


<?php if( in_array(43, $user_menu_ids)){ ?>
<li><a href="<?php echo adminurl('makebooking');?>"><i class="fa fa-table"></i> <span>Create Booking</span></a></li>
<?php }?>


<?php if( in_array(44, $user_menu_ids)){ ?>
<li><a href="<?php echo adminurl('createslot');?>"><i class="fa fa-table"></i> <span>Create Slot</span></a></li>
<?php }?>

<?php if( in_array(45, $user_menu_ids)){ ?>
<li class="treeview listings">
    <a href="javascript:void(0);">
    <i class="fa fa-table"></i> <span>Role User</span>
    <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
    <li><a href="<?php echo adminurl('roll_team_add');?>"><i class="fa fa-circle-o"></i> Add User</a></li>
    <li><a href="<?php echo adminurl('roll_team_list');?>"><i class="fa fa-circle-o"></i> View User</a></li>   
    </ul>
 </li>
<?php }?>

<?php if(has_permission('user_management') || has_permission('role_management') || is_admin()){ ?>
<li class="treeview listings">
    <a href="javascript:void(0);">
    <i class="fa fa-users"></i> <span>User & Role Management</span>
    <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
    <?php if(has_permission('role_management') || is_admin()){ ?>
        <li><a href="<?php echo adminurl('Roles');?>"><i class="fa fa-circle-o"></i> Manage Roles</a></li>
    <?php }?>
    <?php if(has_permission('user_management') || is_admin()){ ?>
        <li><a href="<?php echo adminurl('Users');?>"><i class="fa fa-circle-o"></i> Manage Users</a></li>
    <?php }?>
    <?php if(has_permission('admin_activity_tracking') || is_admin()){ ?>
        <li><a href="<?php echo adminurl('AdminActivity');?>"><i class="fa fa-circle-o"></i> Admin Activity Tracking</a></li>
    <?php }?>
    </ul>
 </li>
<?php }?>

<?php if( in_array(48, $user_menu_ids)){ ?>
<li><a href="<?php echo adminurl('payment_list?n=&f='.date('Y-m-d',strtotime( date('Y-m-d').' -7 days')).'&t='.date('Y-m-d') );?>"><i class="fa fa-table"></i> <span>Payment List</span></a></li>
<?php }?>

<?php if( in_array(48, $user_menu_ids)){ ?>
<li><a href="<?php echo adminurl('sale_list?type=today');?>"><i class="fa fa-table"></i> <span>Sales List</span></a></li>
<?php }?>

<?php if( in_array(49, $user_menu_ids)){ ?>
<li class="treeview listings">
    <a href="javascript:void(0);">
    <i class="fa fa-table"></i> <span>Vehicle Documents</span>
    <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
    <li><a href="<?php echo adminurl('add_veh_details');?>"><i class="fa fa-circle-o"></i> Add Docs</a></li>
    <li><a href="<?php echo adminurl('vehicle_d_list');?>"><i class="fa fa-circle-o"></i> View Docs</a></li> 
    <li><a href="<?php echo adminurl('vehicle_pending_doc_list');?>"><i class="fa fa-circle-o"></i> Pending Docs</a></li>  
    </ul>
 </li>
<?php }?>

<?php if( in_array(54, $user_menu_ids)){ ?>
<li class="treeview listings">
    <a href="javascript:void(0);">
    <i class="fa fa-table"></i> <span>Bike Services </span>
    <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
    <li><a href="<?php echo adminurl('add_veh_service' );?>"><i class="fa fa-circle-o"></i> Add Bike Service Details</a></li> 
    <li><a href="<?php echo adminurl('vehicle_service_list');?>"><i class="fa fa-circle-o"></i> View BikeService List</a></li>    
    </ul>
 </li>
<?php }?>

<?php if( in_array(58, $user_menu_ids)){ ?>
<li class="treeview listings">
    <a href="javascript:void(0);">
    <i class="fa fa-table"></i> <span>Cab Services </span>
    <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
    <li><a href="<?php echo adminurl('add_veh_service_cab' );?>"><i class="fa fa-circle-o"></i> Add Cab Service Details</a></li> 
    <li><a href="<?php echo adminurl('vehicle_service_list_cab');?>"><i class="fa fa-circle-o"></i> View Cab Service List</a></li>    
    </ul>
 </li>
<?php }?>

<?php if( in_array(63, $user_menu_ids)){ ?>
<li class="treeview listings">
    <a href="javascript:void(0);">
    <i class="fa fa-table"></i> <span>Reports </span>
    <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
    </a>
    <ul class="treeview-menu">
    <li><a href="<?php echo adminurl('report' );?>?csv_report=no&type=activecar&vehicle_no=&from=<?php echo date('Y-m-01')?>&to=<?php echo date('Y-m-d')?>"><i class="fa fa-circle-o"></i>Sale Report</a></li> 
    <li><a href="<?php echo adminurl('vehicle_business_report?');?>from=<?php echo date('Y-m-01')?>&to=<?php echo date('Y-m-d')?>"><i class="fa fa-circle-o"></i>Vehicle Business Report</a></li>    
    <li><a href="<?php echo adminurl('role_business_report?');?>from=<?php echo date('Y-m-01')?>&to=<?php echo date('Y-m-d')?>"><i class="fa fa-circle-o"></i>Role User Business Report</a></li>    
    </ul>
 </li>
<?php }?>

</ul>
    </section>
    <!-- /.sidebar -->
  </aside>