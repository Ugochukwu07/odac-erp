<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $format = 'dd-mm-yyyy';?>
<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
                <div class="col-lg-3">
                <?php echo goToDashboard(); ?>
                </div>
                <div class="col-lg-3 pull-right">
                    <a href="<?php echo adminurl('Configurevehicle?redirect=viewvehiclelist');?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add </a>
                    <a href="javascript:void(0);" onclick="openDateFilter('')" style='margin-left:10px;'> <i class="fa fa-filter"></i> Add All Vehicle Slots</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Model</th> 
                    <th>Category</th> 
                    <th>Vehicleno/Year/Fuel</th> 
                    <th>Booking Slot</th>
                    <th>Create Slots</th>
                    <th>Service History</th>
                    <th>Slots Range</th> 
                    <th>Status</th> 
                    <th style="width:100px">Action</th>
                    </tr>
                </thead>
                
                <tbody>
                <?php $i = 1; $goto = array();
        if( !empty($list))
         foreach($list as $key=>$value): 
        ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo ucwords( $value['model'] );?> (<?php echo $value['seat'];?>)</td>
                        <td><?php echo $value['category'];?></td> 
                        <td><?=$value['vnumber'].' / '.$value['vyear'].' / '.$value['fueltype'];?> </td> 
                        <td> <?php echo anchor( adminurl('bookingslots/?id='. ($value['vnumber'])),'<i class="fa fa-calendar"></i>',array('class'=>'btn btn-sm btn-success','data-toggle'=>'tooltip','title'=>'Booking Slots') );?> </td> 
                         
                        <td> 
                        <?php if( $value['status'] == 'yes' ){ ?>
                        <a href="javascript:void(0)" onclick="openDateFilter('<?=$value['id']?>')" class="btn btn-sm btn-warning" data-toggle='tooltip' title = 'Create Slots'><i class="fa fa-dashboard"></i></a>
                        <?php } ?>
                        
                        <?php //if( $value['status'] == 'yes' ){ echo anchor( adminurl('Createslot/?id='.$value['id'].'&year='.date('Y').'&month='.date('m').'&isnext=yes'  ),'<i class="fa fa-dashboard"></i>',array('class'=>'btn btn-sm btn-warning','data-toggle'=>'tooltip','title'=>'Create Slots') ); } ?>
                        </td>
                        
                        <td>  
                        <?php if( $value['vnumber'] == 1 ){
                        echo anchor( adminurl('vehicle_service_list/?vcid='. md5($value['id'])),'<i class="fa fa-calendar"></i>',array('class'=>'btn btn-sm btn-info','data-toggle'=>'tooltip','title'=>'Service History') );
                        }else{
                        echo anchor( adminurl('vehicle_service_list_cab/?vcid='. md5($value['id'])),'<i class="fa fa-calendar"></i>',array('class'=>'btn btn-sm btn-info','data-toggle'=>'tooltip','title'=>'Service History') );
                        }
                        ?>
                        </td>
                        
                        <td><?php echo date('d-F-Y',strtotime($value['startdate'])); ?>/<br/><?php echo date('d-F-Y',strtotime($value['enddate'])); ?></td>
                        <td><?php echo activeststus($value['status']); ?> <br/>
                        <?php if( in_array($value['status'],['yes','no'])){?>
                         <a href="javascript:void(0)" onclick="blockVehicle('<?=$value['id']?>')" class="btn btn-sm btn-danger" data-toggle='tooltip' title = 'Block Vehicle'><i class="fa fa-close"></i></a>
                        <?php }else{ ?>
                        <a href="javascript:void(0)"  class="btn btn-sm btn-success" data-toggle='tooltip' title = 'Vehicle'><i class="fa fa-check"></i></a>
                        <?php } ?>
                        </td>
                        <td>
    <?php if( EDIT ==='yes'){ ?> 
    <?php echo anchor( adminurl('Configurevehicle/?id='.$value['id'].'&redirect=viewvehiclelist'),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','data-toggle'=>'tooltip','title'=>'Edit') ); }?>  

    <?php if( REMOVE ==='yes'){?>
    <?php  echo  anchor( adminurl('Viewvehiclelist/delete?delId='.md5($value['id'])),'<i class="fa fa-trash"></i>',array('class'=>'btn btn-sm btn-danger','onclick' => "return confirm('Do you want delete this record')") ); ?> 
    <?php } ?>
                  </td>
                  </tr>
                  
                <?php $i++; endforeach ;?>
                
                </tbody>
                
                
                <tfoot>
                    <tr>
                     <th>Sr. No.</th>
                    <th>Model</th> 
                    <th>Category</th> 
                    <th>Vehicleno/Year/Fuel</th> 
                    <th>Booking Slot</th>
                    <th>Create Slots</th>
                    <th>Service History</th>
                    <th>Slots Range</th> 
                    <th>Status</th> 
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


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    function openDateFilter( id ){
        $('#myModal').modal('show');
        $('#v_con_id').val( id );
        $('#slotBtn').removeAttr('disabled');
    }
    
     $(function () {
            $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
            });
     });
  
                      
                        
  function createSlots(){
     let id = $('#v_con_id').val();
     let fromDate = $('#fromDate').val();
     let toDate = $('#toDate').val();
    //  if( id == '' ){
    //      alert('Id is Blank'); return;
    //  }
     if( fromDate == '' ){
         alert('From Date is Blank'); return;
     }
     else if( toDate == '' ){
         alert('To Date is Blank'); return;
     }
     
     $.ajax({
         type:'post',
         url: '<?=adminurl('Createslot/index')?>',
         data:{'id':id, 'fromDate': fromDate,'toDate': toDate },
         beforeSend: ()=>{ $('#slotBtn').attr('disabled'); },
         success: (res)=>{
             $('#slotBtn').removeAttr('disabled');
             setTimeout( ()=>{ window.location.reload(); },500 );
         }
     })
  }   
  
  function blockVehicle(id){
      if( confirm('Are You Sure?') ){
            $.ajax({
            type:'post',
            url: '<?=adminurl('Viewvehiclelist/blockVehicle')?>',
            data:{'id':id }, 
            success: (res)=>{
               window.location.reload();
            }
            })
      }
  }
</script>

