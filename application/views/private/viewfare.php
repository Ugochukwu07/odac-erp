<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!----------------- Main content start ------------------------->
<section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header"> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th> 
                  <th>Trip Type</th>
                  <th>Vehicle</th>
                  <th>Category</th> 
                  <th>Pickup City </th> 
                  <th>Base Fare</th>
                  <th>Sec_Amt</th>
                  <th>PerKM</th>
                  <th>Min Km</th> 
                  <th>Status</th> 
                  <th><div style="width:70">Action</div></th>
                </tr>
                </thead>
                
                <tbody>
                <?php $i = '1'; if(!is_null($list) ){ 
                  foreach($list as $key=>$value):  
                ?>
                  <tr id="hide<?php echo $value['id'];?>">
                  <td><?php echo $i; ?></td>
                  <td><?php echo $value['triptype']; ?></td>
                  <td><?php echo $value['model']; ?></td> 
                  <td><?php echo $value['category']; ?></td>
                  <td><?php echo $value['cityname']; ?> </td>
                  <td><?php echo $value['basefare']; ?></td>
                   <td> <?php if($value['secu_amount'] > 0){ echo $value['secu_amount']; } ?> </td> 
                  <td><?php echo $value['fareperkm']; ?> </td>
                  <td><?php echo $value['minkm_day']; ?> </td>  
                  <td><?php echo !empty($value['status']) ? $value['status'] : ''; ?> </td>
                  <td>
<?php if( EDIT ==='yes'){ ?> 
<?php echo  anchor( adminurl('Addfare/index?id=').$value['id'].'&triptype='.$value['triptype'],'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','title'=>'Edit Click Here') ); ?> |  
<?php } if( REMOVE ==='yes'){?>
<?php echo  anchor( adminurl('viewfare/delete?delId=').md5($value['id']),'<i class="fa fa-trash"></i>',array('class'=>'btn btn-sm btn-danger','title'=>'Delete Here','onclick'=>'return confirm("Are you sure")') ); ?>
 
<?php } ?>
 </td>
                </tr>
                  
                <?php $i++; endforeach ; }?>
                
                </tbody>
                
                
                <tfoot>
          <tr>
                  <th>Sr. No.</th> 
                  <th>Trip Type</th>
                  <th>Vehicle</th>
                  <th>Category</th> 
                  <th>Pickup City </th> 
                  <th>Base Fare</th>
                  <th>Sec_Amt</th>
                  <th>PerKM</th>
                  <th>Min Km</th> 
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
 
<script type="text/javascript">

 function getfaredetails(id){
     var options = {
        "backdrop" : "static",
        "show":true
       }
   
    $.ajax({
            type: "POST",
             url: "<?php echo base_url('admin/ajax/Faresummary')?>",
            data: "tableid="+id ,
       beforeSend: function() { $('#loadfare').html('<img src="<?php echo base_url('assets/images/loadergif.gif');?>" width="50" height="50" />' ); },
            success: function (data) { 
       $('#faresummary').modal(options);
       $('#loadfare').html( data );
            }
        });
   }  
</script>

 <!-- /.  modal-content start -->
            <div class="modal fade" tabindex="1" role="dialog" id="faresummary" > 
            <div class="modal-dialog text-center" style="width:54% !important">
            <div class="modal-content">
            <div class="modal-header">
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <span class="modal-title phone_number">
            <span id="loadfare"></span>
            </span>
            </div>
            
            </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
            </div>  
   <!-- /.  modal-content end -->
