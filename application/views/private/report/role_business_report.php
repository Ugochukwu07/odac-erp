<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$session_data = $this->session->userdata('adminloginstatus');
if(empty($session_data)){
  redirect( base_url('mylogin.html') ); exit;
}

$user_type = $session_data['user_type'];
$bookingType = $this->input->get('type');



function thousandsCurrencyFormat($num) {

  if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

  }

  return $num;
}

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
                      <a href="<?=base_url('private/role_business_report?')?>from=<?php echo date('Y-m-01')?>&to=<?php echo date('Y-m-d')?>"  class="pull-right" style='margin-left:10px;'> <i class="fa fa-refresh"></i> Reset</a>
                    </div>
                </div> 
                
                
                <!-- mannual filter  -->
                <div class="col-lg-12">
                <form action="<?=adminurl('role_business_report');?>" method="get" id="formSubmit"> 
                <input type="hidden" value="no" id="csv_report" name="csv_report">
                <div class="row" id="filterDiv" style="display: block;?>">  
                            
                            <div class="col-lg-3"> 
                            <?php echo form_dropdown(['name'=>'user_id','class'=>'form-control select22','id'=>'user_id'], $role_user_list, set_value('user_id',$user_id));?>  
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
                          <th>Full Name</th> 
                          <th>Mobile No</th> 
                          <th>Date From</th> 
                          <th>Date Till</th> 
                          <th>Total Bookings</th> 
                          <th>Total Bussiness</th> 
                      </tr>
                  </thead>
                  <tbody>
                      <?php $roleUserList = [];  $roleBookingList = []; $roleSaleList = []; 
                      if($list){ $i = 1; foreach($list as $key=>$RowValue ){ 
                      $roleUserList[] = $RowValue['name']; 
                      $roleBookingList[] = (int)$RowValue['total_bookings'];
                      $roleSaleList[] = (int) thousandsCurrencyFormat($RowValue['total_sum']);
                      
                      ?> 
                      <tr> 
                          <td><?=$i;?></td> 
                          <td><?=$RowValue['name'];?></td> 
                          <td><?=$RowValue['mobile_no'];?></td> 
                          <td><?=$RowValue['from'];?></td> 
                          <td><?=$RowValue['to'];?></td> 
                          <td><?=$RowValue['total_bookings'];?>   &nbsp;  &nbsp; 
                           <a href="<?=base_url('private/bookingview/?type=total_role_bookings&role_mobile='.$RowValue['mobile_no'].'&ids='.$RowValue['ids'])?>" > <i class="fa fa-eye"></i> View Bookings</a>
                           </td> 
                          <td><?=$RowValue['total_sum'];?></td> 
                      </tr>
                      <?php $i++; }} ?>
                  </tbody>
                   
              </table>
            </div>
            
            
            <!-- /.Draw Chart Start Script  -->
            <div class="card-body"> 
                    <h3 class="card-title">Sales Report</h3>
                    <div class="chart">
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div> 
            </div>
            <!-- /.Draw Chart End Script  -->

 

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


<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script> 

<script src="<?=base_url('assets/admin/dist/js/chart.min.js')?>"></script>

<?php ?>

<script>
    $(function () {

    var areaChartData = {
          
      labels  : <?=json_encode( $roleUserList );?>,
      datasets: [
        {
          label               : 'Total Business in Thousand(s)',
          backgroundColor     : 'rgba(51,122,181,1)',
          borderColor         : 'rgba(51,122,181,1)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(51,122,181,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(51,122,181,1)',
          data                : <?=json_encode($roleSaleList)?>
        },
        {
          label               : 'Total Bookings',
          backgroundColor     : 'rgba(3, 33, 60, 1)',
          borderColor         : 'rgba(3, 33, 60, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(3, 33, 60, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(3, 33, 60, 1)',
          data                : <?=json_encode($roleBookingList)?>
        },
      ]
    }

     
    
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d');
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    });
    
    
    
    
    
    
    });
</script>


<?php //exit; ?>

