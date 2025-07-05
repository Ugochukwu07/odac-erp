<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="description" content="" />
    
    
<?php defined('BASEPATH') OR exit('No direct script access allowed');
 $details = $data[0];
 $redirect = $this->input->get('redirect');
?>
<title>Booking ID: <?=$details['bookingid']?></title>
    <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/responsive.css">
  
  <link rel="stylesheet" href="https://www.ranatravelschandigarh.com/assets/admin/select2/dist/css/select2.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"></head>
<style>@media(max-width:767px){ .mt20{ margin-top:20px; } }</style>
 </head>
 
<body class="page1" id="top" >

<section class="top">
<div class="container">

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
            <div class="col-lg-12">
            
            <div class="row">
            <div class="col-lg-12 col-xs-12"><strong>---------------Customer Details :---------------</strong></div> 
            </div>
            <div class="row">
            <div class="col-lg-4 col-xs-12">Name :</div>
            <div class="col-lg-8 col-xs-12"><?php echo ucwords($details['name']);?></div>
            </div>
            
            <div class="row">
            <div class="col-lg-4 col-xs-12">Email :</div>
            <div class="col-lg-8 col-xs-12"><?php echo $details['email'];?></div>
            </div>

            <div class="row">
            <div class="col-lg-4 col-xs-12">Mobile no. :</div>
            <div class="col-lg-8 col-xs-12"><?php echo $details['mobileno'];?></div>
            </div>

            <div class="row">
            <div class="col-lg-4 col-xs-12">Login Mobile no. :</div>
            <div class="col-lg-8 col-xs-12"><?php echo $details['uniqueid'];?></div>
            </div>
            
                 
            <hr/>
            <div class="row">
            <div class="col-lg-12 col-xs-12"><strong>----------------Booking Details :--------------</strong></div> 
            </div>

            <div class="row">
            <div class="col-lg-4 col-xs-12"><strong>Booking ID :</strong></div>
            <div class="col-lg-8 col-xs-12"><strong><?php echo $details['bookingid'];?></strong></div>
            </div>

            <div class="row">
            <div class="col-lg-4 col-xs-12"><strong>Trip Type :</strong></div>
            <div class="col-lg-8 col-xs-12"><strong><?php echo $details['triptype'];?></strong></div>
            </div>

            <div class="row">
            <div class="col-lg-4 col-xs-12"><strong>Domain Name :</strong></div>
            <div class="col-lg-8 col-xs-12"><strong><?php echo $details['domain'];?></strong></div>
            </div>
            

            <div class="row">
            <div class="col-lg-4 col-xs-12"><strong>Booking Status : </strong></div>
            <div class="col-lg-8 col-xs-12"><strong> <span style="color:#0C3"><?php echo ucwords($details['attemptstatus']);?></span></strong></div>
            </div>

            

            <div class="row">
            <div class="col-lg-4 col-xs-12">Booking Date & Time :</div>
            <div class="col-lg-8 col-xs-12"><?php echo date('d-M-Y h:i A',strtotime($details['bookingdatetime']));?> </div>
            </div>

            <div class="row">
            <div class="col-lg-4 col-xs-12">Pickup Date & Time :</div>
            <div class="col-lg-8 col-xs-12"><?php echo date('d-M-Y h:i A',strtotime($details['pickupdatetime']));?> </div>
            </div>

         
            <div class="row">
            <div class="col-lg-4 col-xs-12">Drop Date & Time :</div>
            <div class="col-lg-8 col-xs-12"><?php echo date('d-M-Y h:i A',strtotime($details['dropdatetime']));?> </div>
            </div>

             
 

 
            
            <div class="row">
            <div class="col-lg-4 col-xs-12">Pickup Address :</div>
            <div class="col-lg-8 col-xs-12"><?php echo $details['pickupaddress'];?></div>
            </div>
          
               
            <div class="row">
            <div class="col-lg-4 col-xs-12">Drop Off Address :</div>
            <div class="col-lg-8 col-xs-12"><?php echo $details['dropaddress'];?></div>
            </div>

            <div class="row">
            <div class="col-lg-4 col-xs-12">Route :</div>
            <div class="col-lg-8 col-xs-12">
                <?php 
                if(!empty($details['routes'])){
                $routes_arra = json_decode($details['routes'],true);
                $routes = '';
                foreach ($routes_arra as $key=>$uvalue) {
                $routes .= $uvalue['via'].'->';
                }
                echo $routes; 
                }?> 
            </div>
            </div>
                 

            <div class="row">
            <div class="col-lg-4 col-xs-12">Vehicle Model :</div>
            <div class="col-lg-8 col-xs-12"><?php echo $details['model'];?></div>
            </div>     

            <div class="row">
            <div class="col-lg-4 col-xs-12">Vehicle No :</div>
            <div class="col-lg-8 col-xs-12"><?php echo $details['vehicleno'];?></div>
            </div>

            
 

           
            
            
            
            
            <hr/>
            <div class="row">
            <div class="col-lg-12 col-xs-12"><strong>-----------------Driver Details :----------------</strong></div> 
            </div>

            <div class="row">
            <div class="col-lg-4 col-xs-12"><strong>Driver Name :</strong></div>
            <div class="col-lg-8 col-xs-12"><strong><?php echo $details['drvname'];?></strong></div>
            </div>
            
            
            <div class="row">
            <div class="col-lg-4 col-xs-12">Driver Mobile No :</div>
            <div class="col-lg-8 col-xs-12"><?php echo $details['drvmobile'];?></div>
            </div>
 

            

            
            <hr/>
            <div class="row">
            <div class="col-lg-12 col-xs-12"><strong>--------------------Fare Details :-----------------</strong></div> 
            </div>

<?php
if(in_array($details['triptype'], ['selfdrive','bike'])){
$basefare = twodecimal($details['basefare'] * $details['driverdays']);
}else{
 $basefare = twodecimal($details['totalkm']*$details['fareperkm']);
}

$estimatedfare = round($details['estimatedfare']);
$cgst = ($details['gstpercent']/2);
$cgsttotal = twodecimal($details['totalgstcharge']/2);
$utgst = ($details['gstpercent']/2);
$utgsttotal = twodecimal($details['totalgstcharge']/2);

$totalamount =  $details['totalamount'];
$offerprice = $details['offerprice'];

$bookingamount = $details['bookingamount'];
$restamount = $details['restamount'];
 
?>
       

        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Base fare :</strong></div>
        <div class="col-lg-4 col-xs-12"><?php
        if(in_array($details['triptype'], ['selfdrive','bike'])){
echo twodecimal($details['basefare']).' INR * ' .$details['driverdays'].' Days';
}else{
 echo twodecimal($details['totalkm']) .' Km * '.$details['fareperkm'].' INR';
}

        ?></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($basefare);?></strong>
        </div>
        </div>


<?php if(in_array($details['triptype'], ['outstation'])){?>
        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Total Km Fare :</strong></div>
        <div class="col-lg-4 col-xs-12">(  <?=$details['estimatedkm'];?> km x <i class="fa fa-rupee"></i> <?= $details['fareperkm'];?> )</div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($details['estimatedkm']*$details['fareperkm']);?></strong>
        </div>
        </div>
    <?php }?>


        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Sub Total Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($estimatedfare);?></strong>
        </div>
        </div>


        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>CGST Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"> ( <?= $cgst;?>% @ <i class="fa fa-rupee"></i> <?= twodecimal($estimatedfare);?> )</div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($cgsttotal);?></strong>
        </div>
        </div>

        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>UTGST Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"> ( <?= $cgst;?>% @ <i class="fa fa-rupee"></i> <?= twodecimal($estimatedfare);?> )</div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($cgsttotal);?></strong>
        </div>
        </div>



        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Total Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($totalamount);?></strong>
        </div>
        </div>


<?php if($details['totaldrivercharge'] > 0){ ?>
        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Total Driver Charge :</strong></div>
        <div class="col-lg-4 col-xs-12"></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($details['totaldrivercharge']);?></strong>
        </div>
        </div>
<?php } ?>

<?php if($details['totalnightcharge'] > 0){ ?>
        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Total Night Charge :</strong></div>
        <div class="col-lg-4 col-xs-12"></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($details['totalnightcharge']);?></strong>
        </div>
        </div>
<?php } ?>

 
 
 
 

<?php if($details['offerprice'] > 0){ ?>
        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Offer Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($details['offerprice']);?></strong>
        </div>
        </div>
<?php } ?>


<?php if($details['bookingamount'] > 0){ ?>
        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Booking Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($details['bookingamount']);?></strong>
        </div>
        </div>
<?php } ?>



<?php if($details['restamount']){ ?>
        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Rest Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($details['restamount']);?></strong>
        </div>
        </div>
<?php } ?>



  



            

            <hr/>   

<?php if($details['apptype'] == 'A'){?>
            <div class="row">
            <div class="col-lg-12 col-xs-12"><strong>--------------------Roll User Details :----------------</strong></div> 
            </div>
            <div class="row">
            <div class="col-lg-4 col-xs-12">Name :</div>
            <div class="col-lg-8 col-xs-12"><?php echo ($details['add_by']=='9041412141') ? 'Super Admin' : ucwords($details['roll_fullname']);?></div>
            </div>  

            <div class="row">
            <div class="col-lg-4 col-xs-12">Login Mobile no. :</div>
            <div class="col-lg-8 col-xs-12"><?php echo $details['add_by'];?></div>
            </div>

            <div class="row">
            <div class="col-lg-4 col-xs-12">Booking Amount :</div>
            <div class="col-lg-8 col-xs-12"><?php echo $details['ad_booking_amount'];?></div>
            </div>
<?php }?>

             <hr/>        
           </div>
           
           
           
           <div class="col-lg-12"> 
            
            <div class="tab-pane active" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red" title="Pickup Date">
                        <a href="javascript:void(0);" data-toggle="tooltip" title="Pickup Date" style="color:#fff;"><?php echo dateformat($details['pickupdatetime'],'d M, Y');?></a>
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <?php if(empty($details['routes'])){?>
                   <li>
                    <i class="fa fa-map-marker bg-aqua"></i>
                      <div class="timeline-item"> 
                      <h3 class="timeline-header no-border"> <?php echo $details['pickupaddress'];?> </h3>
                    </div>
                  </li>
                  <?php }?>
                    
                  <?php 
                if(!empty($details['routes'])){
                $routes_arra = json_decode($details['routes'],true); 
                foreach ($routes_arra as $key=>$uvalue) {?> 
                  <li>
                    <i class="fa fa-map-marker bg-aqua"></i>
                      <div class="timeline-item"> 
                      <h3 class="timeline-header no-border"> <?=$uvalue['via'];?></h3>
                    </div>
                  </li>
                   <?php }}else{?>
                    <li>
                    <i class="fa fa-map-marker bg-aqua"></i>
                      <div class="timeline-item"> 
                      <h3 class="timeline-header no-border"> <?=$details['dropcity'];?></h3>
                    </div>
                  </li>
                   <?php }?>
                   
                   
                  
                  <!-- timeline time label -->
                  <?php if($details['dropdatetime']){?>
                  <li class="time-label">
                        <span class="bg-green">
                          <a href="javascript:void(0);" data-toggle="tooltip" title="Drop Date" style="color:#fff;"><?php echo dateformat($details['dropdatetime'],'d M, Y');?></a>
                        </span>
                  </li>
              <?php } ?>
                 
                  <!-- END timeline item -->
                  <li><i class="fa fa-clock-o bg-gray"></i></li>
                </ul>
                
                
              
              </div>
              
           </div>
           
           </div>

            
            
            
           <!--  Booking Progress  ststus start-->
           <div class="container" style="clear:both; margin-top: 50px; margin-bottom: 50px">
           <div class="row"> 
            <div class="col-lg-5 col-xs-12">  
                <?php if( ($details['attemptstatus'] == 'new')){?>
                 <a class="btn btn-primary btn-lg" style="width:100%" href="<?php echo adminurl('adminconfirm/confirm/?id='.$details['id'].'&redirect='.$redirect );?>" onclick="return confirm('Are You Sure?')">Confirm</a>
                <?php }?>
            </div>  
             
            <div class="col-lg-5 col-xs-12 mt20">  
            <?php if(!in_array($details['attemptstatus'], ['complete']) ){?>
            <a class="btn btn-danger btn-lg" style="width:100%" href="<?php echo adminurl('adminconfirm/cancel/?id='.$details['id'].'&redirect='.$redirect );?>" onclick="return confirm('Are You Sure?')" >Cancel</a>
            <?php }?>
            </div>
            </div> 
           
            
          <!--  Booking Progress  ststus end--> 
            </div>
            </div>
            </div>
            
            
            
            
            
       
              
              </div>
            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    
         
</div>


<!----------------- Main content end ------------------------->
    
    
    
 </div>
<!--------- /.content-wrapper --------->

 
