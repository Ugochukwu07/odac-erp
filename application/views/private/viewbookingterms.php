<?php defined('BASEPATH') OR exit('No direct script access allowed');  $timecurrent = date('Y-m-d H:i:s'); ?>

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
             <div class="box-header pull-right">
              <a href="<?php echo adminurl('Addbookingterms');?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Triptype / Domain</th>
                    <th width="50%">Content</th> 
                    <th>Status</th> 
                    <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                <?php $i = '1';
				if( !is_null($list))
				 foreach($list as $key=>$value): ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['datacategory']; ?> <br>
                          <span class="spang"><?=$value['domain'];?></span></td>
                        <td><?php echo ( $value['content'] ); ?> </td>  
                        <td><?php echo activeststus($value['status']); ?> </td>
                        <td>
  <?php if( EDIT ==='yes'){ ?> 
  <?php echo  anchor( adminurl('Addbookingterms/index?id='.$value['id']),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary') ); ?> |  
  <?php } if( REMOVE ==='yes'){?>
  <?php echo  anchor( adminurl('Addbookingterms/delete?delId='.md5($value['id'])),'<i class="fa fa-trash"></i>',array('class'=>'btn btn-sm btn-danger','onclick' => "return confirm('Do you want delete this record')") ); ?>
  <?php } ?>
                  </td>
                  </tr>
                  
                <?php $i++; endforeach ;?>
                
                </tbody>
                
                
                <tfoot>
     			    <tr>
                    <th>Sr. No.</th>
                    <th>Triptype / Domain</th>
                    <th>Content</th>  
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
