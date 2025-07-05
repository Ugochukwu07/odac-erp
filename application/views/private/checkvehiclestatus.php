<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $format = 'dd-mm-yyyy';?>
<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
                <div class="col-lg-3">
                <a href="<?php echo $exporturl;?>" class="btn btn-sm btn-success pull-left"><i class="fa fa-download"></i> Download </a>
                <?php echo goToDashboard(); ?>
                </div>
                <div class="col-lg-3 pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Model Name</th> 
                    <th>Vehicle No</th> 
                    <th>Status</th> 
                    <th>Booking No</th> 
                    <th>Pickup Date</th> 
                    <th>Drop Date</th> 
                    </tr>
                </thead>
                
                <tbody>
                    <?php $i = 1;  
                        if( !empty($list))
                        foreach($list as $key=>$value): 
                    ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo ucwords( $value['model'] );?></td>
                        <td><?php echo $value['vnumber'];?></td> 
                        <td><?=$value['status'];?> </td>
                        <td><?=$value['bookingid'];?> </td>
                        <td><?= (!empty($value['bookingid']) ? $value['pickup'] : '');?> </td>
                        <td><?= (!empty($value['bookingid']) ? $value['drop'] : '');?> </td> 
                  </tr>
                  
                <?php $i++; endforeach ;?>
                
                </tbody>
                
                
                <tfoot>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Model Name</th> 
                    <th>Vehicle No</th> 
                    <th>Status</th> 
                    <th>Booking No</th> 
                    <th>Pickup Date</th> 
                    <th>Drop Date</th> 
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
        <h4 class="modal-title">Create Vehicle Slots </h4>
      </div>
      <form >
        <input type="hidden" name="type" id="v_con_id" value="">
      <div class="modal-body"> 

            <div class="row mg_top_1">
            <div class="col-lg-6">From Date</div> 
            <div class="col-lg-6">
                <?php echo form_input(array('name'=>'fromDate','type'=>'date','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter from date','autocomplete'=>'off','id'=>'fromDate','data-date-format'=>$format,'data-date'=>''), set_value('fromDate',date('d-m-Y') ) );?>
                </div>
            </div>

            <div class="row mg_top_1">
            <div class="col-lg-6">To Date</div> 
            <div class="col-lg-6">
                 <?php echo form_input(array('name'=>'toDate','type'=>'date','required'=>'required','class'=>'form-control datepicker','placeholder'=>'Enter to date','autocomplete'=>'off','id'=>'toDate','data-date-format'=>$format,'data-date'=>''), set_value('toDate',date('d-m-Y', strtotime( date('Y-m-d') .' +2 Years') ) ) );?>
                 </div>
            </div> 
         
      </div>
      <div class="modal-footer">
            <div class="row">
            <div class="col-lg-4">&nbsp;</div> 
            <div class="col-lg-4"><button type="button" class="btn btn-success" id="slotBtn" onclick="createSlots()" >Create Slots</button></div> 
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></div>  
            </div>
      </div>
    </form>
    </div>

  </div>
</div> 

