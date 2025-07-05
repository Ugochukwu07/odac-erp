<?php defined('BASEPATH') OR exit('No direct script access allowed');  $timecurrent = date('Y-m-d H:i:s'); ?>

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
                    <th>State Name</th>
                    <th>State Code</th> 
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
				  

        $goto["page"] = "Viewstate";
        $goto["upId"] = $value['id'];
        $goto["action"] = "statusupdate";
        $goto["value"] = $status;
        $goto["table"] = "state";

				?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                <td><?php echo !empty($value['statename']) ? ucwords( $value['statename']) : ''; ?> </td> 

                         <td><?php echo !empty($value['statecode']) ? $value['statecode'] : ''; ?> </td> 
                        <td><?php echo activeststus($value['status']); ?> </td>
                        <td>
		  <?php if( EDIT ==='yes'){ ?> 
          <?php echo  anchor( adminurl('Addstate/?id='.$value['id']),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','data-toggle'=>'tooltip','title'=>'Edit') ); }?>  
          
          <?php  if( EDIT ==='yes' ) { echo anchor( adminurl('Updatestatuscommon/index?utm='.utmen($goto) ),'<i class="fa fa-'.$lock.'"></i>',array('class'=>'btn btn-sm '.$btn.'','data-toggle'=>'tooltip','title'=>'Click for '.$statustxt, 'onclick' => "return confirm('Do you want ".$statustxt." this record')")); }?>
           
            
          <?php if( REMOVE ==='yes'){
          echo anchor( adminurl('viewstate/deletestate?delId='.md5($value['id']) ),'<i class="fa fa-trash"></i>',array('class'=>'btn btn-sm btn-danger','data-toggle'=>'tooltip','title'=>'Click for Delete ', 'onclick' => "return confirm('Do you want delete this record')"));
           } ?>
                  </td>
                  </tr>
                  
                <?php $i++; endforeach ;?>
                
                </tbody>
                
                
                <tfoot>
     			          <tr>
                    <th>Sr. No.</th>
                    <th>State Name</th> 
                    <th>State Code</th>
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
