<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
             <div class="row">
                  <div class="col-lg-2"> 
                  <!--<a href="<?php echo $exporturl;?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Download CSV </a>-->
                   <?php echo goToDashboard(); ?>
                  </div>

                    <div class="col-lg-8"> 
                    Total Sale : <strong class="spanr12"><?=$total_sale?> </strong>
                    Total Recieved Amount : <strong class="spanr12" ><?=$total_advance?></strong>
                    Total Rest Amount : <strong class="spanr12"><?=$total_rest?></strong> 
                    Extend Amount : <strong class="spanr12"><?=$total_extend?></strong> 
                    </div>
                    
                    <div class="col-lg-2 pull-right"> 
                    <a href="javascript:void(0)" onclick="openPopup();" class="btn btn-sm btn-success "><i class="fa fa-filter"></i> Filter </a>
                    <a href="<?=adminurl('sale_list?type=today')?>" class="btn btn-sm btn-Primary ">Today </a>
                    </div>
                </div>
                </div>
            <!-- /.box-header -->
            <div class="box-body  table-responsive ">  
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>User Details</th>
                    <th>Month Year</th> 
                    <th>Amount Details</th>
                    <th>Total Bookings</th>  
                    <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $i = 1;  
                        if( !empty($list)){
                        foreach($list as $key=>$value): 
                    ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?=$value['add_by_name']?> <br/> <?=$value['add_by']?></td> 
                        <td><?=date('F',strtotime( $value['year'].'-'.$value['month'].'-01' ))?>, <?=$value['year']?></td> 
                        <td>Total: <?=$value['total_amount']?>, 
                            <br/>Recieved Amount: <?=$value['advance_amount']?>,  
                            <br/>Rest Amount: <?=$value['rest_amount']?>,
                            <br/>Extended Amount: <?=$value['extend_amount']?>
                        </td>
                        <td><?=$value['no_of_bookings']?> </td> 
                        <td>
          <?php if( EDIT ==='yes'){ ?> 
          <?php //echo anchor( adminurl('roll_team_add/?id='.md5($value['id'])),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','data-toggle'=>'tooltip','title'=>'Edit') ); ?>    
          <?php } ?>
                  </td>
                  </tr>
                  
                <?php $i++; endforeach ; }?>
                
                </tbody>
                
                
                <tfoot>
                    <tr>
                    <th>Sr. No.</th>
                    <th>User Details</th>
                    <th>Month Year</th> 
                    <th>Amount Details</th>
                    <th>Total Bookings</th>  
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



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 300px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter List</h4>
      </div>
      <form action="<?=adminurl('sale_list');?>" method="get">
        <input type="hidden" name="type" value="<?=$bookingtype;?>">
      <div class="modal-body"> 
            <div class="row">
            <div class="col-lg-6">User List</div> 
            <div class="col-lg-6">
                <?=form_dropdown(['name'=>'uid','class'=>'form-control select22','id'=>'uid'], $userlist, set_value('uid',$uid) );?>
            </div>
            </div>

            <div class="row mg_top_1">
            <div class="col-lg-6">Select Month</div> 
            <div class="col-lg-6"><?=form_dropdown(['name'=>'month','class'=>'form-control select22','id'=>'month'], getMonthList(), set_value('month',$month) );?></div>
            </div>

            <div class="row mg_top_1">
            <div class="col-lg-6">Select Year</div> 
            <div class="col-lg-6"><?=form_dropdown(['name'=>'year','class'=>'form-control select22','id'=>'year'], getYearList(), set_value('year',$year) );?></div>
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

<script>
    function openPopup(){
        $('#myModal').modal('show');
    }
</script>

