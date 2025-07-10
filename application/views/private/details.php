<?php defined('BASEPATH') OR exit('No direct script access allowed');
 $details = $data[0];
 $redirect = $this->input->get('redirect');
?>
<?php
$session_data = $this->session->userdata('adminloginstatus');
if(empty($session_data)){
  redirect( base_url('mylogin.html') ); exit;
}


// RBAC-aware user type handling
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
?>

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
            <div class="col-lg-12 col-xs-12"><strong>-------------------------Customer Details :---------------------</strong></div> 
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
            <div class="col-lg-12 col-xs-12"><strong>-------------------------Booking Details :---------------------</strong></div> 
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
            <div class="col-lg-12 col-xs-12"><strong>-------------------------Driver Details :---------------------</strong></div> 
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
            <div class="col-lg-12 col-xs-12"><strong>-------------------------Fare Details :---------------------</strong></div> 
            </div>

            <?php
            if(in_array($details['triptype'], ['selfdrive','bike','monthly'])){
            $basefare = twodecimal($details['basefare'] * $details['driverdays']);
            }else{
             $basefare = twodecimal($details['totalkm']*$details['fareperkm']);
            }
            
            $estimatedfare = round($details['estimatedfare']);
            $cgst = ($details['gstpercent']);
            $cgsttotal = twodecimal($details['totalgstcharge']);
            //$utgst = ($details['gstpercent']/2);
            //$utgsttotal = twodecimal($details['totalgstcharge']/2);
            
            $totalamount =  $details['totalamount'];
            $offerprice = $details['offerprice'];
            
            $bookingamount = $details['bookingamount'];
            $restamount = $details['restamount'];
            
            $is_edited_on26Nov2023 = false;
            if( strtotime( date('Y-m-d',strtotime($details['bookingdatetime'])) ) >=  strtotime('2023-11-26') && !empty($details['vehicle_price_per_unit'])){
	        $is_edited_on26Nov2023  = true; 
	        $estimatedfare = round($details['gstapplyon']);
	        $totalamount =  $details['totalamount'] + $details['offerprice'];
	        }
	   
             
            ?>
       



    <?php if( $is_edited_on26Nov2023 ){?>
    <div class="row">
            <div class="col-lg-4 col-xs-12"><strong>Base fare :</strong></div>
            <div class="col-lg-4 col-xs-12">
                <?php $baseFareAmount = 0;
                    if(in_array($details['triptype'], ['selfdrive','bike','monthly'])){
                    echo twodecimal($details['vehicle_price_per_unit']).' INR * ' .$details['driverdays'].' Days';
                    $baseFareAmount = twodecimal( $details['vehicle_price_per_unit'] * $details['driverdays'] );
                    }else{
                    echo twodecimal($details['totalkm']) .' Km * '.$details['fareperkm'].' INR';
                    $baseFareAmount = twodecimal( $details['totalkm'] * $details['fareperkm'] );
                    }
                ?>
            </div>
            <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal( $baseFareAmount);?></strong>
            </div>
            </div>
    <?php }else{?>
            <div class="row">
            <div class="col-lg-4 col-xs-12"><strong>Base fare :</strong></div>
            <div class="col-lg-4 col-xs-12">
                <?php
                    if(in_array($details['triptype'], ['selfdrive','bike','monthly'])){
                    echo twodecimal($details['basefare']).' INR * ' .$details['driverdays'].' Days';
                    }else{
                    echo twodecimal($details['totalkm']) .' Km * '.$details['fareperkm'].' INR';
                    }
                ?>
            </div>
            <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($basefare);?></strong>
            </div>
            </div>
    <?php }?>



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
        <div class="col-lg-4 col-xs-12"><strong>GST Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"> ( <?= $cgst;?>% @ <i class="fa fa-rupee"></i> <?= twodecimal($estimatedfare);?> )</div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($cgsttotal);?></strong>
        </div>
        </div> 


        <?php if($details['othercharge'] > 0){ ?>
                <div class="row">
                <div class="col-lg-4 col-xs-12"><strong>Other Charge :</strong></div>
                <div class="col-lg-4 col-xs-12"></div>
                <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($details['othercharge']);?></strong>
                </div>
                </div>
        <?php } ?>


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
        <div class="col-lg-4 col-xs-12"><strong>Discount Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($details['offerprice']);?></strong>
        </div>
        </div>
<?php } ?>


<?php if($details['bookingamount'] > 0){ ?>
        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Total Recieved Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($details['bookingamount']);?></strong>
        </div>
        </div>
<?php } ?>



<?php if($details['restamount']){ ?>
        <div class="row">
        <div class="col-lg-4 col-xs-12"><strong>Balance Amount :</strong></div>
        <div class="col-lg-4 col-xs-12"></div>
        <div class="col-lg-4 col-xs-12"><strong><i class="fa fa-rupee"></i> <?= twodecimal($details['restamount']);?></strong>
        </div>
        </div>
<?php } ?>



  



            

            <hr/>   

<?php if($details['apptype'] == 'A'){?>
            <div class="row">
            <div class="col-lg-12 col-xs-12"><strong>-------------------------Role User Details :---------------------</strong></div> 
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
           <div class="container" style="clear:both; margin-top: 50px;">
           <div class="row"> 
            
            <?php if( ($details['attemptstatus'] == 'new') ){?>
                <div class="col-lg-2">  
                 <a class="btn btn-primary" href="<?php echo adminurl('bookingview/confirm/?id='.$details['id'].'&redirect='.$redirect );?>" onclick="return confirm('Are You Sure?')">Confirm Booking</a>
               </div>
            <?php }?>
            
            
            <div class="col-lg-2"> 
            <a class="btn btn-primary" href="<?php echo adminurl('editbooking/?id='.$details['id'].'&redirect='.$redirect );?>" onclick="return confirm('Are You Sure?')">Edit Booking</a>
            </div>

            <?php if( !in_array($details['attemptstatus'], ['complete']) ){?>
                <div class="col-lg-2"> 
                <a class="btn btn-danger" href="<?php echo adminurl('bookingview/cancel/?id='.$details['id'].'&redirect='.$redirect );?>" onclick="return confirm('Are You Sure?')" >Cancel</a>
                </div> 
            <?php }?>
            

            <?php if(in_array($details['attemptstatus'], ['approved']) && !in_array($details['attemptstatus'], ['cancel','new','complete']) ){?>
            <div class="col-lg-2"> 
            <a class="btn btn-success" href="<?php echo adminurl('bookingview/close/?id='.$details['id'].'&redirect='.$redirect );?>" onclick="return confirm('Are You Sure?')">Close Booking</a>
            </div>
            <?php }?>
            
            
            <?php if( !in_array($details['attemptstatus'], ['complete','temp']) ){ ?>
            <div class="col-lg-2">
               <a class="btn btn-primary" href="<?php echo adminurl('bookinguploads/index?id='.$details['id'].'&usertype=booking');?>" target="_blank">Uploads</a> 
            </div>
            <?php } ?>
                
               
            <div class="col-lg-2">
               <a class="btn btn-success" href="<?php echo adminurl('slip?utm='.md5($details['id']).'&for=print');?>" target="_blank">Print Slip</a> 
            </div>
            
            
            <div class="col-lg-2">   
                 <a class="btn btn-warning" href="<?php echo adminurl('bookingview/?type='.$redirect );?>" >GO Back</a>
            </div>
            
            

            </div>
            
            <div class="row" style="margin-top:50px">  
                <div class="col-lg-2"></div>  
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

 
