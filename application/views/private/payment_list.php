<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
             <div class="row">
          <div class="col-lg-4"> 
          </div>

          <div class="col-lg-6">
<?php if($page > 1){
echo "<a href='".$startbtn."' class='btn-sm btn-success' data-toggle='tooltip' title='To get start Records. Click here'>First</a>";

echo "<a href='".$prebtn."' class='btn-sm btn-primary' style='margin-left:10px;' data-toggle='tooltip' title='To get Previous Records. Click here'>PREVIOUS</a>";
}

if($page!=$totalpage){ 
echo "<a href='".$nxtbtn."' class='btn-sm btn-primary' style='margin-left:10px;' data-toggle='tooltip' title='To get Next Records. Click here'> NEXT </a>";

echo "<a href='".$endbtn."' class='btn-sm btn-success' style='margin-left:10px;' data-toggle='tooltip' title='To get last Records. Click here'> Last </a>";
}?>
</div>
    <div class="col-lg-2">
    <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" class="pull-right" style='margin-left:10px;'> <i class="fa fa-filter"></i> Filter</a>
    </div>
</div>
</div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Bookingid</th>
                    <th>Trip Type</th>
                    <th>Fullname</th> 
                    <th>Mobile</th> 
                    <th>Added Date</th> 
                    <th>Collection For</th> 
                    <th>Booking Amount</th>  
                    <th><div style="width: 100px">Action</div></th>
                    </tr>
                </thead>
                
                <tbody>
                <?php $i = 1;
				 if( !empty($list))

				 foreach($list as $key=>$value):  
         $mobile = $value['add_by']; 
				 ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td> 
                        <td><?php echo $value['bookingid'];?><br/><?php echo $value['attemptstatus'];?></td>
                        <td><?=ucfirst($value['triptype']);?></td>
                        <td>
                        <span class="spanr12"> <?php echo ($mobile=='9041412141') ? 'Super Admin' : ucwords( $value['fullname'] ); ?> </span> </td>
                        <td>
                          <span class="spang12"> <?php echo  $mobile; ?> </span> 
                        </td> 

                         <td>
                        <span class="spang12">
            <em><strong><?= date('d M Y h:i: A',strtotime($value['added_on'])); ?></strong></em></span></td> 

                        <td><?php echo !empty($value['paymode']) ? ucwords($value['paymode']) : '';?></td>
                        <td>
                          <span class="spang12" ><em><strong><?php echo $value['amount'];?></strong></em></span> </td>
                          
                         
                       
                       
                  <td> 
      <?php echo  anchor( adminurl('details/?id='.md5($value['booking_id'])) ,'<i class="fa fa-eye"></i>',array('class'=>'btn-sm btn-warning','data-toggle'=>'tooltip', 'title'=>'Details') ); ?> 
                  </td>
                  </tr>
                  
                <?php $i++; endforeach ;?>
                
                </tbody>
                
                
                <tfoot>
                   <tr>
                    <th>Sr. No.</th>
                    <th>Bookingid</th>
                    <th>Trip Type</th>
                    <th>Fullname</th> 
                    <th>Mobile</th> 
                    <th>Added Date</th> 
                    <th>Collection For</th> 
                    <th>Booking Amount</th>  
                    <th><div style="width: 100px">Action</div></th>
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
<!-- Trigger the modal with a button -->




<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="/*width: 300px*/ ">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter Payment List</h4>
      </div>
      <form action="<?=adminurl('payment_list');?>" method="get"> 
      <div class="modal-body"> 
            <div class="row">
            <div class="col-lg-6">Login Name/ Login Mobile/BookingID</div> 
            <div class="col-lg-6"><input type="text" name="n" class="form-control" placeholder="Enter Login Name/ Login Mobile/BookingID" id="name" autocomplete="off" value="<?=$n;?>" ></div>
            </div>

            <div class="row mg_top_1">
            <div class="col-lg-6">From Date</div> 
            <div class="col-lg-6"><input type="date" onchange="filldate(this.value)" name="f" class="form-control" id="from" value="<?=$f;?>" ></div>
            </div>

            <div class="row mg_top_1">
            <div class="col-lg-6">To Date</div> 
            <div class="col-lg-6"><input type="date"  name="t" class="form-control" id="to" value="<?=$t;?>" ></div>
            </div> 
         
      </div>
      <div class="modal-footer">
            <div class="row">
            <div class="col-lg-4">&nbsp;</div> 
            <div class="col-lg-4"><button type="submit" class="btn btn-success" >Search</button></div> 
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></div>  
            </div>
      </div>
    </form>
    </div>

  </div>
</div>


 

<script type="text/javascript"> 
  function loaddata(){ setTimeout( function(){
    $('.sidebar-mini').addClass('sidebar-collapse');
    $("div.col-sm-12" ).addClass( "table-responsive" );

  },2000);} ;
  window.load = loaddata();

 function filldate(vl){
  $('#to').val( vl );
 }
</script>


