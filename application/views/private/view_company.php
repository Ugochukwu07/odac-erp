<?php defined('BASEPATH') OR exit('No direct script access allowed');  $timecurrent = date('Y-m-d H:i:s'); ?>

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
                <?php echo goToDashboard(); ?>
                <div style="width:150px; float:right"> 
                <a href="<?php echo adminurl('add_company');?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add </a>  
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Insurance  Company Name</th> 
                    <th>Status</th> 
                    <th>Add Date</th> 
                    <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $i = '1'; $goto = array();
    				if( !empty($list))
    				    foreach($list as $key=>$value):  
    				?>
                    
                    <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo !empty($value['company_name']) ? ucwords( $value['company_name']) : ''; ?> </td>  
                    <td><?php echo ucwords($value['status']); ?> </td>
                    <td><?php echo date('d-M-Y',strtotime($value['add_date'])); ?> </td>
                    <td>
                    <?php if( EDIT ==='yes'){ ?> 
                    <?php echo  anchor( adminurl('Add_company/?id='.md5($value['id']) ),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','data-toggle'=>'tooltip','title'=>'Edit') ); }?>  
                    
                    
                    <?php if( REMOVE ==='yes'){
                    echo anchor( adminurl('view_company/deletestate?delId='.md5($value['id']) ),'<i class="fa fa-trash"></i>',array('class'=>'btn btn-sm btn-danger','data-toggle'=>'tooltip','title'=>'Click for Delete ', 'onclick' => "return confirm('Do you want delete this record')"));
                    } ?>
                    </td>
                    </tr>
                  
                <?php $i++; endforeach ;?>
                
                </tbody>
                
                
                <tfoot>
     			    <tr>
                    <th>Sr. No.</th>
                    <th>Insurance  Company Name</th>  
                    <th>Status</th>
                    <th>Add Date</th>
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