<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>.cgreen{ color: green} .cred{ color: red }</style>

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header"> 
                <div style="width:150px; float:right"> 
               <a href="<?php echo adminurl('websettings');?>" class="btn btn-sm btn-primary "><i class="fa fa-plus"></i> Add </a>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Office Details</th> 
                    <th>Address</th>  
                    <th>Add Date</th> 
                    <th>Action</th>
                    </tr>
                </thead>
                
                <tfoot>
                    <tr>
                     <th>Sr. No.</th>
                    <th>Office Details</th> 
                    <th>Address</th>  
                    <th>Add Date</th> 
                    <th style="width:150px" >Action</th>
                    </tr>
                </tfoot>
                
                
                <tbody>
                <?php $i = 1;
        if( !empty($list))
         foreach($list as $key=>$value): 
        ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $value['office_type'];?><br/> (<strong><?php echo $value['city_name'];?></strong>)<br/> (<?php echo $value['mobile_numbers'];?>)</td> 
                        <td><?php echo $value['address_name'];?></td>  
                        <td><?= date('d-M-Y',strtotime($value['add_date']) );?> </td> 
                         <td>
    <?php if( EDIT ==='yes'){ ?> 
    <?php echo  anchor( adminurl('Websettings/?id='.md5($value['id'])),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','data-toggle'=>'tooltip','title'=>'Edit') ); }?>  


    <?php if( REMOVE ==='yes'){?>
    <?php  echo  anchor( adminurl('Websettings/deleteitem?delId='.md5($value['id']) ),'<i class="fa fa-trash"></i>',array('class'=>'btn btn-sm btn-danger','onclick' => "return confirm('Do you want delete this record')") ); ?> 
    <?php } ?>
                  </td>
                  </tr>
                  
                <?php $i++; endforeach ;?>
                
                </tbody>
                
                
                
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
 