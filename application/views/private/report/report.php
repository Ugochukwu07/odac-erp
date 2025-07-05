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
                      <a href="<?=base_url('private/report')?>"  class="pull-right" style='margin-left:10px;'> <i class="fa fa-refresh"></i> Reset</a>
                    </div>
                </div> 
                
                
                <!-- mannual filter  -->
                <div class="col-lg-12">
                <form action="<?=adminurl('report');?>" method="get" id="formSubmit"> 
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
              <table id="responseData"  class="table table-bordered table-striped" >
                  <thead>
                      
                      <tr>
                          <?php if($list){ foreach($list[0] as $row ){?>
                          <th><?=$row?></th> 
                          <?php }}?>
                      </tr>
                  </thead>
                  <tbody>
                      <?php if($list){ foreach($list as $key=>$RowValue ){
                      if( $key > 0 ){?>
                      <tr>
                          <?php $j = 0; foreach($RowValue as $key=>$value ){ ?>
                          <td>
                              <div style="width:100px"><?=$value?>
                              <br/> <span class="spanr12"><?php if($j==0){ echo date('l',strtotime($value)); }?> </span>
                              </div>
                          </td>
                          <?php $j++; } ?>
                      </tr>
                      <?php }}} ?>
                  </tbody>
                  
                  <!--<tfooter>-->
                  <!--    <tr>-->
                  <!--        <th>&nbsp;</th>-->
                  <!--        <th>Total</th> -->
                  <!--        <th>1500</th>-->
                  <!--        <th>1800</th>-->
                  <!--    </tr>-->
                  <!--</tfooter>-->
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
