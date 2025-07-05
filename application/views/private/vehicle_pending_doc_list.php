<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
                <a href="<?php echo $exporturl;?>" class="btn btn-sm btn-success pull-left"><i class="fa fa-download"></i> Download </a>
                <?php echo goToDashboard(); ?>
                <div style="float:right; width:150px">
               <a href="<?php echo adminurl('Configurevehicle?redirect=ptotal');?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> Add </a> &nbsp; | &nbsp;
                <a href="javascript:void(0)" onclick="openVehiclePopup();" class="btn btn-sm btn-success "><i class="fa fa-filter"></i> Filter </a>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Model</th> 
                    <th>Category</th> 
                    <th>Vehicleno/Year/Fuel</th> 
                    <th>Status</th> 
                    <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                <?php $i = '1'; $goto = array();
        if( !is_null($list))
         foreach($list as $key=>$value): 
        ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo ucwords( $value['model'] );?> (<?php echo $value['seat'];?>)</td>
                        <td><?php echo $value['category'];?></td> 
                        <td><?=$value['vnumber'].' / '.$value['vyear'].' / '.$value['fueltype'];?> </td>  
                        <td><?php echo activeststus($value['status']); ?> </td>
                        <td>
    <?php if( EDIT ==='yes'){  echo  anchor( adminurl('add_veh_details?vehicle_con_id='.$value['id'].'&redirect=ptotal'),'<i class="fa fa-upload"></i>',array('class'=>'btn btn-sm btn-primary','data-toggle'=>'tooltip','title'=>'Add Docs') ); }?>  
 
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


<div class="modal fade" id="vehicleDetails" tabindex="-1" aria-labelledby="openModel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h4" id="openModel">Search Vehicle/ By Vehicle Number:  </h5> 
        </div>
        <div class="modal-body" id="pageContent">
            <?php echo form_open_multipart( adminurl('vehicle_pending_doc_list' ),['method'=>'get']); ?>
            <input type="hidden" name="type" value="<?=$redirect;?>" />
                <div class="row">
                <div class="form-group col-lg-6"> 
                <?php echo form_label('Select Vehicle Number', 'vcid');?>
                <?php echo form_dropdown(array('name'=>'vcid','class'=>'form-control select22','onchange'=>"removeMval()",'id'=>'vcid'),$vehiclelist,set_value('vcid',$vcid));?>
                </div>
                
                <div class="form-group col-lg-6"> 
                <?php echo form_label(' OR Enter Vehicle Number', 'vcid2');?>
                <?php echo form_input(array('name'=>'vcid2','class'=>'form-control','placeholder'=>'Enter Vehicle Number','id'=>'vcid2','onkeyup'=>"removesval()"), set_value('vcid2',$vcid2) );?>
                </div>
                
                <div class="col-md-2" >
                <?php echo form_submit( array('class'=>'btn btn-primary','value'=>'Search') );  ?>
                </div>
                
                <div class="col-md-2 pull-left" >
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                </div>
                
                 
                </div>
                                
                                
                <?php echo form_close(); ?>
                <div class="spacer-10"></div>
        
        </div>
        
      </div>
    </div>
  </div>
  
  
  <script>
      function openVehiclePopup(){
          $('#vehicleDetails').modal('show');
      }
      function closeModal(){
          $('#vehicleDetails').modal('hide');
      }
      
      function removeMval(){
          $('#vcid2').val('');
      }
      
      function removesval(){
          $('#vcid').val('');
      } 
      
      
   </script>



<!--<script src="https://www.ranatravelschandigarh.com/assets/admin/select2/dist/js/select2.full.min.js"></script>-->
<!--  <script>-->
<!--    $(function () {-->
<!--            $('.select2').select2({ minimumResultsForSearch: Infinity});-->
<!--            $('.select22').select2();-->
<!--    }); -->
<!--  </script>-->
  