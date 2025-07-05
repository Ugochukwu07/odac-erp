<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php $this->load->view( adminfold('includes/all-css'));?>
 
  <script type="text/javascript">
    function goto( page ){  
	  window.location.href=('<?php echo adminurl('');?>'+page);
    }
  </script>
  <style>
    .bgd1{ background: #465562; color: #0c263e; }
    .bgd1  > .info-box-content{ color: #ffffff;}
    .info-box .progress { background: rgb(251 251 251); }
    .info-box-iconblue { background: #3c6441; }
    .iconf_bg_1{ background: #17a2b8; }
    .iconf_bg_2{ background: #3c6441; }
    .iconf_bg_3{ background: #dc3545; }
    .iconf_bg_4{ background: #f7ab00; }
    .todaysale{ font-size: 12px; line-height: 25px; }
    c
  </style>
  
 
  </head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view( adminfold('includes/header'));?>
<?php $this->load->view( adminfold('includes/menu'));?>
 <!-- Content Wrapper. Contains page content -->

<?php
$session_data = $this->session->userdata('adminloginstatus');
if(empty($session_data)){
  redirect( base_url('mylogin.html') ); exit;
}

$user_type = $session_data['user_type'];
?>


  <div class="content-wrapper"> 
    <!-- Main content -->
    <section class="content">
        
        
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h5 class="card-title">My Bookings</h5>
                </div>
            </div>
        </div>
    </div> 
        
       <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('bookingview/?type=new');">
              <span class="info-box-icon iconf_bg_1"><i class="fa fa-calendar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">New Booking</span>
                <span class="info-box-number"><?= $newbookng;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div> 
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('bookingview/?type=today');">
              <span class="info-box-icon iconf_bg_2"><i class="fa fa-calendar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Today Booking</span>
                <span class="info-box-number"><?= $todaybooking;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('bookingview/?type=upcoming');">
              <span class="info-box-icon iconf_bg_3"><i class="fa fa-calendar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Upcoming Booking</span>
                <span class="info-box-number"><?= $upcomingbooking;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor"  onClick="goto('bookingview/?type=vtpending');" >
              <span class="info-box-icon iconf_bg_4"><i class="fa fa-calendar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Vehicle Pending</span>
                <span class="info-box-number"><?= $totaldriverpending ? $totaldriverpending : '0' ;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>  

        </div>

<!-----------------  second row start   ------------------->
 <div class="row"> 
         
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor"  onClick="goto('bookingview/?type=temp');" >
              <span class="info-box-icon iconf_bg_1"><i class="fa fa-calendar"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Temp Bookings</span>
                <span class="info-box-number"><?= $totaltemp ? $totaltemp : '0' ;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div> 
          
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor"onClick="goto('bookingview/?type=cancel');" >
              <span class="info-box-icon iconf_bg_2"><i class="fa fa-thumbs-down"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Cancelled Booking</span>
                <span class="info-box-number"><?= $cancelbooking ? $cancelbooking : '0' ;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col --> 
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('bookingview/?type=hold');" >
              <span class="info-box-icon iconf_bg_3"><i class="fa fa-comments"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Hold Booking</span>
                <span class="info-box-number"><?= $holdbooking;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div> 
            </div> 
          </div>
          <!-- /.col -->

<?php //if($user_type == 'admin'){?>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('bookingview/?type=total');" >
              <span class="info-box-icon iconf_bg_4"><i class="fa fa-comments"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Entry</span>
                <span class="info-box-number"><?= $totalrecod;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        <?php //}?>

           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('bookingview/?type=run');" >
              <span class="info-box-icon iconf_bg_1"><i class="fa fa-comments"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" >Running Booking <br/> 
                <!--<span style="font-size:12px;font-weight: 600"> Total: <?= $total_cars;?>, Run: <?= $runningbooking;?>, <br/> Hold: <?= $hold_booking_cars;?>, Free: <?=$free_cars;?> </span> -->
                <!--</span>  -->
                <span class="info-box-number"><?= $runningbooking;?></span>
                
                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

<?php //if($user_type == 'admin'){?>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('bookingview/?type=total');" >
              <span class="info-box-icon iconf_bg_2"><i class="fa fa-comments"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Bussiness</span>
                <span class="info-box-number"><?= $totalbusiness;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor"  >
              <span class="info-box-icon iconf_bg_3"><i class="fa fa-comments"></i></span>

              <div class="info-box-content">
                <span class="info-box-text" style="margin-left:-17px;font-size: 12px ; font-weight:500">Today Sale/Recieved/OverDue</span>
                <span class="info-box-number">
                    <a href="javascript:void(0)" onClick="goto('bookingview/?type=todaysale');" style="color:#111111; font-size:12px" ><?= (int)$todaysale;?></a>/
                    <a href="javascript:void(0)" onClick="goto('payment_list?n=&t=<?=date('Y-m-d')?>&f=<?=date('Y-m-d', strtotime( date('Y-m-d').'-5 days'))?>&type=todaycollection');"  style="color:#111111;font-size:12px" ><?= (int)$todaycollection;?></a>/
                    <a href="javascript:void(0)" onClick="goto('bookingview/?type=totaldue');"  style="color:#111111;font-size:12px" ><?= (int)$total_due;?></a>
                    </span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor"  >
              <span class="info-box-icon iconf_bg_4"><i class="fa fa-comments"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sale Report / Role User</span>
                <span class="info-box-number">
                    <a href="javascript:void(0)" onClick="goto('report?csv_report=no&type=activecar&vehicle_no=&from=<?php echo date('Y-m-01')?>&to=<?php echo date('Y-m-d')?>');" style="color:#111111; font-size:12px" ><?= (int)$totalvehiclesale;?></a>/
                    <a href="javascript:void(0)" onClick="goto('role_business_report?from=<?=date('Y-m-01')?>&to=<?=date('Y-m-d')?>');"  style="color:#111111;font-size:12px" ><?= (int)$total_role_user;?></a>
                    </span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
<?php //if($user_type == 'admin'){?>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('bookingview/?type=edit');" >
              <span class="info-box-icon iconf_bg_1"><i class="fa fa-comments"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Edit Approval</span>
                <span class="info-box-number"><?= (int) $editbookings ;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
<?php //}?> 

 <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor"  onClick="window.open('<?=adminurl('makebooking')?>','_blank')" >
              <span class="info-box-icon iconf_bg_2"><i class="fa fa-bookmark"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Create New Booking</span>
                <span class="info-box-number"><i class="fa fa-plus"></i></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor"  onClick="goto('leads');" >
              <span class="info-box-icon iconf_bg_3"><i class="fa fa-bookmark"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Lead Request</span>
                <span class="info-box-number">---------</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
          
           <!-- /.col -->
          <?php //if($user_type == 'admin'){?>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor"  onClick="goto('bookingview/?type=complete');" >
              <span class="info-box-icon iconf_bg_4"><i class="fa fa-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Completed</span>
                <span class="info-box-number"><?= $completebooking;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col --> 
        <?php //}?>
 

        </div>
<!-----------------  fourth row start   ------------------->



<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h5 class="card-title">My Vehicles Expire Documents | 
                <?php if( (int)$doc_verification_pending > 0 ){ ?>
                 <a href="javascript:void(0)" onClick="goto('vehicle_d_list?status=verifypending');" style="color:red" ><?= (int)$doc_verification_pending;?> Edit Approval Pending</a>
                 <?php } ?> 
                </h5>
                </div>
            </div>
        </div>
    </div> 
    
    
<!-----------------  fifth row start   ------------------->
<div class="row"> 
          <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor"  onClick="goto('vehicle_doc_expires?type=white');" >
              <span class="info-box-icon iconf_bg_1"><i class="fa fa-file-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">White Permit (Expire)</span>
                <span class="info-box-number" id="white">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('vehicle_doc_expires?type=permit');" >
              <span class="info-box-icon iconf_bg_2"><i class="fa fa-file-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Permit (Expire)</span>
                <span class="info-box-number" id="permit">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('vehicle_doc_expires?type=tax');" >
              <span class="info-box-icon iconf_bg_3"><i class="fa fa-file-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Tax (Expire)</span>
                <span class="info-box-number" id="tax">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('vehicle_doc_expires?type=fitness');" >
              <span class="info-box-icon iconf_bg_4"><i class="fa fa-file-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Fitness (Expire)</span>
                <span class="info-box-number" id="fitness">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('vehicle_doc_expires?type=insurence');" >
              <span class="info-box-icon iconf_bg_1"><i class="fa fa-file-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Insurence (Expire)</span>
                <span class="info-box-number" id="insurence">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('vehicle_doc_expires?type=pollution');" >
              <span class="info-box-icon iconf_bg_2"><i class="fa fa-file-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pollution (Expire)</span>
                <span class="info-box-number" id="pollution">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('vehicle_d_list')" >
              <span class="info-box-icon iconf_bg_3"><i class="fa fa-file-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Docs</span>
                <span class="info-box-number" ><?=$totaldocs;?></span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('vehicle_pending_doc_list')" >
              <span class="info-box-icon iconf_bg_4"><i class="fa fa-file-o"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Docs</span>
                <span class="info-box-number"  id="pendingdoc">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          </div>
        
        
        <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h5 class="card-title">My Vehicles Services | 
                <?php if( (int)$carserviceeditverify > 0 ){ ?>
                 <a href="javascript:void(0)" onClick="goto('Vehicle_service_list_cab/?status=verifypending');" style="color:red" ><?= (int)$carserviceeditverify;?> Car Edit Approval</a> / 
                 <?php } if( (int) $bikeserviceeditverify > 0 ){ ?>
                 <a href="javascript:void(0)" onClick="goto('Vehicle_service_list/?status=verifypending');" style="color:red" ><?= (int)$bikeserviceeditverify;?> Bike Edit Approval</a>
                 <?php }  ?>
                </h5>
                </div>
            </div>
        </div>
    </div> 
    
          
          
          <div class="row">
          <!---------------------  service details menus Start ------------------->
            <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('Vehicle_service_list');" >
              <span class="info-box-icon iconf_bg_1"><i class="fa fa-motorcycle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Bike Service</span>
                <span class="info-box-number" id="totalbikeservice">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('Vehicle_service_list?status=pending');" >
              <span class="info-box-icon iconf_bg_2"><i class="fa fa-motorcycle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Bike Service</span>
                <span class="info-box-number" id="pendingbikeservice">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('Vehicle_service_list?status=upcoming');" >
              <span class="info-box-icon iconf_bg_3"><i class="fa fa-motorcycle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Upcoming Bike Sevrv, in 10 Days</span>
                <span class="info-box-number" id="upcomingbikeservice">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
          <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('Vehicle_claim/list?type=bike');" >
              <span class="info-box-icon iconf_bg_4"><i class="fa fa-motorcycle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Bike Insurence Claim</span>
                <span class="info-box-number" id="bikeserviceclaim">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
          
          </div>
          
          <div class="row">
          <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('Vehicle_service_list_cab')" >
              <span class="info-box-icon iconf_bg_1"><i class="fa fa-car"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Car Services</span>
                <span class="info-box-number" id="totalcarservives" >0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('Vehicle_service_list_cab?status=pending')" >
              <span class="info-box-icon iconf_bg_2"><i class="fa fa-car"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Car Services</span>
                <span class="info-box-number" id="pendingcarservives" >0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('Vehicle_service_list_cab?status=upcoming')" >
              <span class="info-box-icon iconf_bg_3"><i class="fa fa-car"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Upcoming Car Services</span>
                <span class="info-box-number"  id="upcomingcarservives">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
           <!-- /.col -->
           <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-white cursor" onClick="goto('Vehicle_claim/list?type=car')" >
              <span class="info-box-icon iconf_bg_4"><i class="fa fa-car"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Car Insurence Claim</span>
                <span class="info-box-number"  id="carserviceclaim">0</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description"> 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
        <!---------------------  service details menus End ------------------->
         
          
        </div> 
        
        
        <div class="row">
              
          <!-- <div class="col-md-3 col-sm-6 col-12">-->
          <!--  <div class="info-box bg-white cursor" onClick="goto('vehicle_service_list_cab')" >-->
          <!--    <span class="info-box-icon iconf_bg_1"><i class="fa fa-car"></i></span>-->

          <!--    <div class="info-box-content">-->
          <!--      <span class="info-box-text">Cab Service History</span>-->
          <!--      <span class="info-box-number">----------</span>-->

          <!--      <div class="progress">-->
          <!--        <div class="progress-bar" style="width: 70%"></div>-->
          <!--      </div>-->
          <!--      <span class="progress-description"> -->
          <!--      </span>-->
          <!--    </div>-->
              
          <!--  </div>-->
            
          <!--</div>-->
          
          
           
           <!--<div class="col-md-3 col-sm-6 col-12">-->
           <!-- <div class="info-box bg-white cursor" onClick="goto('vehicle_service_list')" >-->
           <!--   <span class="info-box-icon iconf_bg_2"><i class="fa fa-motorcycle"></i></span>-->

           <!--   <div class="info-box-content">-->
           <!--     <span class="info-box-text">Bike Service History</span>-->
           <!--     <span class="info-box-number">----------</span>-->

           <!--     <div class="progress">-->
           <!--       <div class="progress-bar" style="width: 70%"></div>-->
           <!--     </div>-->
           <!--     <span class="progress-description"> -->
           <!--     </span>-->
           <!--   </div>-->
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
          
        </div>





    </section> 
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view( adminfold('includes/footer'));?>
<?php $this->load->view( adminfold('includes/all-js'));?> 

<script>
    function countitem(type){
        $.ajax({
            type:'GET',
            url:'<?=adminurl('');?>vehicle_doc_expires?type='+type+'&is_count=yes', 
            success: function(res){
                $('#'+type).html(res);
            }
        })
    }
   setTimeout( function(){ countitem('white'); },300 );
   setTimeout( function(){ countitem('permit'); },600 );
   setTimeout( function(){ countitem('tax'); },700 );
   setTimeout( function(){ countitem('fitness'); },900 );
   setTimeout( function(){ countitem('insurence'); },1000 );
   setTimeout( function(){ countitem('pollution'); },1200 );  
   
   function pendingDoc( type ){
        $.ajax({
            type:'GET',
            url:'<?=adminurl('');?>Vehicle_pending_doc_list?is_count=yes', 
            success: function(res){
                $('#'+type).html(res);
            }
        })
    }
    
    setTimeout( function(){ pendingDoc('pendingdoc'); },1400 );
    
     function cabbikeservice( selector ){
        $.ajax({
            type:'GET',
            url:'<?=adminurl('');?>dashboard/countserviceitems?type='+selector, 
            success: function(res){
                $('#'+selector).html(res);
            }
        })
    }
    
    setTimeout( function(){ cabbikeservice('totalbikeservice'); },1450 );
    setTimeout( function(){ cabbikeservice('pendingbikeservice'); },1500 );
    setTimeout( function(){ cabbikeservice('upcomingbikeservice'); },1600 );
    setTimeout( function(){ cabbikeservice('pendingcarservives'); },1800 );
    setTimeout( function(){ cabbikeservice('totalcarservives'); },1900 );
    setTimeout( function(){ cabbikeservice('upcomingcarservives'); },2000 );
    
    setTimeout( function(){ cabbikeservice('bikeserviceclaim'); },2500 );
    setTimeout( function(){ cabbikeservice('carserviceclaim'); },2800 );
    
    
</script>


