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
                  <th>Title</th>
                  <th>Coupon Code</th> 
                  <th>Amount</th> 
                  <th>Type</th>
                  <th>From</th>
                  <th>To</th> 
                  <th>Status</th> 
                  <th><div style="width:70">Action</div></th>
                </tr>
                </thead>
                
                <tbody>
                <?php $i = 1; if(!empty($list) ){
                echo '<pre>'; 
                 // print_r($list); exit;
                  foreach($list as $key=>$value):  
                ?>
                  <tr id="hide<?php echo $value['id'];?>">
                  <td><?php echo $i; ?></td>
                  <td><?php echo $value['trippackage']; ?></td>
                  <td><?php echo $value['titlename']; ?></td> 
                  <td><?php echo $value['couponcode']; ?></td>
                  <td><?php echo $value['cpnvalue']; ?> </td>
                  <td><?php echo $value['valuetype']; ?></td>
                  <td><?=date('d-M-Y',strtotime($value['validfrom']))?> </td> 
                  <td><?=date('d-M-Y',strtotime($value['validto']))?> </td>  
                  <td><?php echo !empty($value['status']) ? $value['status'] : ''; ?> </td>
                  <td>
<?php if( EDIT ==='yes'){ ?> 
<?php echo  anchor( adminurl('addcoupon/index?id='.md5($value['id'])),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','title'=>'Edit Click Here') ); ?> |  
<?php } if( REMOVE ==='yes'){?>
<?php echo  anchor( adminurl('viewcoupon/delete?delId=').md5($value['id']),'<i class="fa fa-trash"></i>',array('class'=>'btn btn-sm btn-danger','title'=>'Delete Here','onclick'=>'return confirm("Are you sure")') ); ?>
 
<?php } ?>
 </td>
                </tr>
                  
                <?php $i++; endforeach ; }?>
                
                </tbody>
                
                
          <tfoot>
                 <tr>
                  <th>Sr. No.</th> 
                  <th>Trip Type</th>
                  <th>Title</th>
                  <th>Coupon Code</th> 
                  <th>Amount</th> 
                  <th>Type</th>
                  <th>From</th>
                  <th>To</th> 
                  <th>Status</th> 
                  <th><div style="width:70">Action</div></th>
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
