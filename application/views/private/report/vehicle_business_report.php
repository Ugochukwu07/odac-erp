<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$session_data = $this->session->userdata('adminloginstatus');
if(empty($session_data)){
  redirect( base_url('mylogin.html') ); exit;
}

$user_type = $session_data['user_type'];
$bookingType = $this->input->get('type');
?>

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
             <div class="row">
          <div class="col-lg-4">  
          <?php echo goToDashboard(); ?>
          </div>

               <div class="col-lg-6"> 
                
                </div>
                    <div class="col-lg-2">
                      <a href="<?=base_url('private/vehicle_business_report?')?>from=<?php echo date('Y-m-01')?>&to=<?php echo date('Y-m-d')?>"  class="pull-right" style='margin-left:10px;'> <i class="fa fa-refresh"></i> Reset</a>
                    </div>
                </div> 
                
                
                <!-- mannual filter  -->
                <div class="col-lg-12">
                <form action="<?=adminurl('vehicle_business_report');?>" method="get" id="formSubmit"> 
                <input type="hidden" value="no" id="csv_report" name="csv_report">
                <div class="row" id="filterDiv" style="display: block;?>"> 
                
                            <div class="col-lg-3"> 
                            <?php echo form_dropdown(['name'=>'type','class'=>'form-control select22','onchange'=>"getVehicleList( this.value )"],[''=>'--select one--','active'=>'Active Car/Bike','block'=>'Blocked Car/Bike','activecar'=>'Active Cars','blockedcars'=>'Blocked Cars','activebike'=>'Active Bikes','blockedbike'=>'Blocked Bikes','car'=>'All Cars Only','bike'=>'All Bikes Only'], set_value('type',$type) );?>  
                            </div>
                            
                            <div class="col-lg-3"> 
                            <?php echo form_dropdown(['name'=>'vehicle_no','class'=>'form-control select22','id'=>'vehicle_no'], $vehicle_list, set_value('vehicle_no',$vehicle_no));?>  
                            </div>
                
                            <div class="col-lg-2"> 
                            <input type="date" name="from" class="form-control" id="fromDate" onchange="getDateVal(this.value)" value="<?=$from;?>" > 
                            </div>
                
                            <div class="col-lg-2"> 
                            <input type="date"  name="to" class="form-control" id="toDate" value="<?=$to;?>" > 
                            </div> 
                          
                            <div class="col-lg-2"> 
                                <button type="submit" class="btn btn-success" onClick="exportReport('no')" >View</button> 
                                <button type="button" class="btn btn-success" onClick="exportReport('yes')" >Export</button> 
                            </div>  
                </div>
                </form>
                </div>
            <!-- /.box-header -->
            <div class="box-body  table-responsive ">   
              <table id="responseData"  class="table table-bordered table-striped table-responsive" >
                  <thead> 
                      <tr> 
                          <th>Sr. No</th> 
                          <th>Vehicle No</th> 
                          <th>Vehicle Name</th> 
                          <th>Total Bussiness</th> 
                      </tr>
                  </thead>
                  <tbody>
                      <?php if($list){ $i = 1; foreach($list as $key=>$RowValue ){ ?> 
                      <tr> 
                          <td><?=$i;?></td> 
                          <td><?=$RowValue['vehicle_no'];?></td> 
                          <td><?=$RowValue['vehicle_name'];?></td> 
                          <td><?=$RowValue['total'];?></td> 
                      </tr>
                      <?php $i++; }} ?>
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
<!-- Trigger the modal with a button -->

 
<script type="text/javascript"> 
  function loaddata(){ setTimeout( function(){
       
    $('.sidebar-mini').addClass('sidebar-collapse');
    //$("div.col-sm-12" ).addClass( "table-responsive" ); 
document.getElementById("responseData").removeAttribute("style")
  },2000);} ;
 //window.load = loaddata(); 
  
  function openFilter(){
      $('#filterDiv').toggle(500);
  }
</script>
<script>
     function getVehicleList( type ){
         if( type !=='' ){
             $('#vehicle_no').html('');
             $.ajax({
                 type:'POST',
                 url:'<?=base_url('private/Report/getVehicleList')?>',
                 data:{'type': type},
                 success: function( res){
                     $('#vehicle_no').html( res );
                 }
                 
             })
         }
     }
     
     function exportReport( type ){
                $('#csv_report').val( type );
                $('#formSubmit').submit();
    }
</script>