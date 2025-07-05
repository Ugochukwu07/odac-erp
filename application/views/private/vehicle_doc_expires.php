<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>.cgreen{ color: green} .cred{ color: red } 
.lastEditBtn{
    border:1px dotted red;
    padding: 5px 10px;
    border-radius: 10px;
}</style> 

<?php
$session_data = $this->session->userdata('adminloginstatus');
if(empty($session_data)){
  redirect( base_url('mylogin.html') ); exit;
}

$user_type = $session_data['user_type']; 
?>
<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <a href="<?php echo $exporturl;?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Download CSV </a>
               <?php echo goToDashboard(); ?>
               <div style="float:right; width:150px">
                    <a href="<?php echo adminurl('add_veh_details/?redirect='.$type );?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add &nbsp; </a> &nbsp; | &nbsp;
                    <a href="javascript:void(0)" onclick="openVehiclePopup();" class="btn btn-sm btn-success "><i class="fa fa-filter"></i> Filter </a>
               </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Vehicle Details</th> 
                    <th><?=$tblheading;?>(dd-mm-yyyy)</th>  
                    <th>Action</th>
                    </tr>
                </thead>
                
                <tfoot>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Vehicle Details</th> 
                    <th><?=$tblheading;?>(dd-mm-yyyy)</th>  
                    <th style="width:80px">Action</th>
                    </tr>
                </tfoot>
                
                
                <tbody>
                <?php $i = '1'; $goto = array();
        if( !empty($list))
         foreach($list as $key=>$value): 
             
            $tickImage = '';
            if( $value['edit_verify_status'] == 'edit' ){
            $tickImage = '<img src="'.base_url('assets/images/red_tick.png').'" width="20" />';
            }else if( $value['edit_verify_status'] == 'verify' ){
            $tickImage = '<img src="'.base_url('assets/images/blue_tick.png').'" width="20" />';
            }
        ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo ucwords( $value['model'] );?> <?=$tickImage?> <br/> (<strong><?php echo $value['vnumber'];?></strong>)<br/> (<?php echo $value['fueltype'];?>) (<?php echo $value['vyear'];?>)
                            <br/><span class="spanr12" ><em><strong>Added By: <span class="spang12" > <?=$value['add_by_name']?> | <?=$value['add_by_mobile']?> </span></strong></em></span> 
                            <?php if(!empty($value['edit_by_mobile'])){ ?>
                            <br/><span class="spanr12" ><em><strong>Last Edited By: <span class="spang12" > <?=$value['edit_by_name']?> | <?=$value['edit_by_mobile']?> </span></strong></em></span> 
                            <?php } ?>
                        </td> 
                        <td><span class="cred">Till: <?= dateformat($value[$keyname],'d-F-Y');?></span>
                        <?php if($value['last_edit']){?>
                        <span class="lastEditBtn"> <?= $value['last_edit']?></span>
                         <?php } ?>
                        <?php if($type=='insurence'){?> <br/>
                        <strong> Policy Number: <?php echo $value['policy_no'];?></strong> <br/>
                        <strong> From: <?php echo $value['insu_company_name'];?></strong>
                        <?php }?>
                        </td> 
                        <td>
    <?php if( EDIT ==='yes'){ ?> 
    <?php echo  anchor( adminurl('add_veh_details/?id='.md5($value['id']).'&redirect='.$type ),'<i class="fa fa-edit"></i>',array('class'=>'btn btn-sm btn-primary','data-toggle'=>'tooltip','title'=>'Edit') ); }?>  
    <br/><br/>
    <?php if( $value['edit_verify_status'] == 'edit' ){?>
    <a href="javascript:void(0)" class="btn-sm btn-success mgbtm" data-toggle="tooltip" title="Verify Service" onclick="openEditLog('<?=$value['id']?>','edit')" >Verify</a> 
    <?php }else if(!empty($value['edit_by_mobile'])){ ?>
    <a href="javascript:void(0)" class="btn-sm btn-success mgbtm" data-toggle="tooltip" title="Edit History" onclick="openEditLog('<?=$value['id']?>','view')" > <i class="fa fa-table mg_top_2"> </i></a> 
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


<div class="modal fade" id="vehicleDetails" tabindex="-1" aria-labelledby="openModel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h4" id="openModel">Search Vehicle/ By Vehicle Number:  </h5> 
        </div>
        <div class="modal-body" id="pageContent">
            <?php echo form_open_multipart( adminurl('vehicle_doc_expires' ),['method'=>'get']); ?>
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
  
  
<!-- Modal -->
<div id="myEditModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Log List</h4>
      </div> 
        <input type="hidden" name="" id="editId" value="">
      <div class="modal-body" id="editHtmlLog" style="font-size: 12px;"> 
      </div>
      <div class="modal-footer">
            <div class="row">
            <div class="col-lg-4">&nbsp;</div> 
            <div class="col-lg-4"><?php if($user_type=='admin'){?><button type="button" class="btn btn-success" onclick="verifyEditLog()" id="verifyBtn" >Verify</button><?php }?></div> 
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>  
            </div>
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
      
      function openEditLog(id, type ){
        if( type == 'edit'){
            $('#verifyBtn').show();
        }else{
             $('#verifyBtn').hide();
        }
        $('#editId').val( id );
        $('#editHtmlLog').html( '' );
        $.ajax({
            type:'POST',
            data: {'id': id},
            url: '<?=base_url('private/Add_veh_details/getEditLog')?>',
            success: ( res )=>{
                $('#editHtmlLog').html( res );
                $('#myEditModal').modal('show');
            }
        })
    }
    
    function verifyEditLog(){
        var id = $('#editId').val();
        $.ajax({
            type:'POST',
            data: {'id': id},
            url: '<?=base_url('private/Add_veh_details/verifyEditLog')?>',
            success: ( res )=>{ 
                $('#myEditModal').modal('hide');
                window.location.reload();
            }
        });
    }

<?php if( empty($list) ){?>
         setTimeout( ()=>{ openVehiclePopup(); },500 );
<?php }?>
      
  </script>
  
  
  
  