<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <a href="<?php echo adminurl('Addvehicle');?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Model</th> 
                    <th>Category</th> 
                    <th>Image</th> 
                    <th>Status</th> 
                    <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                <?php $i = '1'; $goto = array();
        if( !is_null($list))
         foreach($list as $key=>$value): 
         
         $status = ($value['status']=='yes') ? 'no' : 'yes';
         $statustxt = ($value['status']=='yes') ? 'InActive' : 'Active';
         $btn = ($value['status']=='yes') ? 'btn-success' : 'btn-danger';
         $lock = ($value['status']=='yes') ? 'unlock' : 'lock';
        ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo ucwords( $value['model'] );?></td>
                        <td><?php echo $value['category'];?></td> 
                        <td><img src="<?php echo base_url('uploads/'.$value['image']); ?>" width="100" /> </td> 
                        <td><?php echo activeststus($value['status']); ?> </td>
                        <td>
    <?php if( EDIT ==='yes'){ ?> 
    <?php echo  anchor( adminurl('Addvehicle/?id='.$value['id']),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','data-toggle'=>'tooltip','title'=>'Edit') ); }?>  


    <?php if( REMOVE ==='yes'){?>
    <?php  echo  anchor( adminurl('Viewvehicle/delete?delId='.md5($value['id'])),'<i class="fa fa-trash"></i>',array('class'=>'btn btn-sm btn-danger','onclick' => "return confirm('Do you want delete this record')") ); ?> 
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
                    <th>Image</th> 
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
