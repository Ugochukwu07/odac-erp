<?php defined('BASEPATH') OR exit('No direct script access allowed');  $timecurrent = date('Y-m-d H:i:s'); $interval = '300';  ?>

<!----------------- Main content start ------------------------->
<section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
             <div class="row">
          <div class="col-lg-4"> 
          </div>

          <div class="col-lg-6"></div>
    <div class="col-lg-2">
     
    </div>
</div>
</div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Full Name/Email/Mobile</th>
                    <th>Login Details</th> 
                    <th>Vehicle/Vehicle No</th> 
                    <th>City</th>
                    <th><div style="width: 100px">Status</div></th> 
                    <th>Bookings</th>   
                    <th><div style="width: 100px">Action </div></th>
                    </tr>
                </thead>
                
                <tbody>
                <?php $i = '1'; $goto = array();


				if( !empty($list) && !is_null($list)){
				 foreach($list as $key=>$value): 

          $uniqueid = strlen($value['uniqueid']) == 12 ? $value['uniqueid'] : '';
				 
				 $status = ($value['status']=='yes') ? 'no' : 'yes';
				 $statustxt = ($value['status']=='yes') ? 'InActive' : 'Active';
				 $btn = ($value['status']=='yes') ? 'btn-success' : 'btn-danger'; 
         $btnuploads = ($value['completeprofile']=='yes')?'btn-success':'btn-danger';
				 
         $timedeff = gettimedeffrence($value['sendotpat'],$timecurrent); 
       
 
$cityname = getftcharray('city', array('id'=>$value['operationcity']), 'cityname');
        ?>
                        
          <tr>
          <td class="<?php echo ($value['status']=='blacklist') ? 'blklstimage' : '';?>"><?php echo $i; ?></td>
          <td><?php echo ucwords($value['fullname']); ?><br/> 
          <span class="spanr">Email: <?= $value['email'];?></span><br/> 
          <span class="spang">Mob: <?= $value['mobileno'];?></span><br/> 
          <span class="spang">Aadhaar: <?= $value['aadhaar'];?></span>
          </td>

          <td> <span class="spang">UID: <?= $value['uniqueid'];?></span><br/>
            <span class="spang">Login Id: </span> 
          <span class="spanr"><?= $value['mobileno'];?></span><br/> 
          <span class="spang">OTP: </span>
          <span class="spanr"><?php echo ( $timedeff <= 2) ? $value['otp'] : '' ; ?></span> 
          </td> 
          <td><span class="spanr"> <?= $value['vehicleno'];?></span></td>
                     

          <td> <?= $cityname; ?></td> 
          <td> <span class="spang">Duty:</span> <span class="spanr"><?= $value['dutystatus']; ?></span><br/>
          <span class="spang">Login: </span><span class="spanr"><?= $value['loginstatus']; ?></span><br/>
          <span class="spang">Profile:</span><span class="spanr"> <?= activeststus($value['status']); ?></span>
          </td>
                    
          <td><br/> <?php echo anchor( adminurl('front/bookinglist/?bookingtype=total&filterby=dvruniqueid&requestparam='.$value['uniqueid'] ),'<i class="fa fa-file-o"></i> <i class="fa fa-external-link"></i>',array('class'=>' btn-sm btn-info','data-toggle'=>'tooltip','title'=>'View Booking log','target'=>'_blank') ); ?>
          </td>
          
                        <td> 
		     <?php if( EDIT ==='yes'){ ?> 
           
          <?php echo anchor( adminurl('registerdriver/?id='.$value['id'] ),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','data-toggle'=>'tooltip','title'=>'Edit','target'=>'_blank') ); }?> 

          <?php echo anchor( adminurl('viewdriver/deleteit/?id='.md5($value['id']) ),'<i class="fa fa-trash"></i>',array('class'=>'btn btn-sm btn-danger','data-toggle'=>'tooltip','title'=>'Delete','onclick'=>'checkdel();') ); ?>
<br/><br/> 
           
                  </td>
                  </tr>
            
                <?php $i++; endforeach ; }?>
                
                </tbody>
                
                
                <tfoot>
     			         <tr>
                    <th>Sr. No.</th>
                    <th>Full Name/Email/Mobile</th>
                    <th>Login Details</th> 
                    <th>Vehicle/Vehicle No <br/>Trip Type</th> 
                    <th>City</th>
                    <th><div style="width: 100px">Status</div></th> 
                    <th>Bookings</th> 
                    <th>Action</th>
                    </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<!----------------- Main content end ------------------------->
    
    
    
 </div>
<!--------- /.content-wrapper --------->