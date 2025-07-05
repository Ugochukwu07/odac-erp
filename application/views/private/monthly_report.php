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
                    <th>Total Bookings</th> 
                    <th>Year</th>
                    <th>Month</th> 
                    <th>Total Sale</th> 
                    <th>Booking Amount</th>   
                    <th>Rest Amount</th>  
                    <th><div style="width: 100px">Action</div></th>
                    </tr>
                </thead>
                
                <tbody>
                <?php $i = 1;
				 if( !empty($list)){ //print_r($list);

				    foreach($list as $key=>$value): 
				 ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td> 
                        <td><?=$value['total_id'];?></td>
                        <td><?=$value['year'];?></td>
                        <td><?=$value['month'];?></td>
                        <td><?=$value['total_amount'];?></td>
                        <td><?=$value['booking_amount'];?></td>
                        <td><?=$value['rest_amount'];?></td>
                       
                        <td> 
                        <?php echo anchor( adminurl('bookingview/?type=monthly&f='.$value['year'].'-'.date('m',strtotime($value['month'])).'-01&t='.$value['year'].'-12-31'   ) ,'<i class="fa fa-eye"></i>',array('class'=>'btn-sm btn-warning','data-toggle'=>'tooltip', 'title'=>'Details') ); ?> 
                        </td>
                  </tr>
                  
                <?php $i++; endforeach ; }?>
                
                </tbody>
                
                
                <tfoot>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Total Bookings</th> 
                    <th>Year</th>
                    <th>Month</th> 
                    <th>Total Sale</th> 
                    <th>Booking Amount</th>   
                    <th>Rest Amount</th>  
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
      <form action="<?=adminurl('monthly_report');?>" method="get"> 
      <div class="modal-body">  

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

