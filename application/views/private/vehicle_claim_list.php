<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
             <div class="row">
                  <div class="col-lg-4"> 
                  <a href="<?php echo $exporturl;?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Download CSV </a>
                   <?php echo goToDashboard(); ?>
                  </div>

               <div class="col-lg-5">
                 
                </div>
                    <div class="col-lg-2 pull-right">
                    <a href="<?=base_url('private/vehicle_claim?redirect='.$redirect )?>"  class=" btn btn-primary" style='margin-left:10px;'> <i class="fa fa-plus"></i> Add</a>&nbsp; | &nbsp;
                    <a href="javascript:void(0)" onclick="openVehiclePopup();" class="btn btn-sm btn-success "><i class="fa fa-filter"></i> Filter </a>
                    </div>
                </div>
                </div>
            <!-- /.box-header -->
            <div class="box-body  table-responsive "> 
              <input type="hidden" id="totalRecords" value="0" >
              <!--<table class="table table-striped table-bordered display nowrap" id="responseData"></table>-->
              <table id="responseData"  class="table table-bordered table-striped" ></table>
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


<style>
   table.dataTable {
    clear: both;
    margin-top: 6px!important;
    margin-bottom: 6px!important;
    max-width: none!important;
    border-collapse: separate!important;
    border-spacing: 0
}

table.dataTable td,
table.dataTable th {
    box-sizing: content-box
}

table.dataTable td.dataTables_empty,
table.dataTable th.dataTables_empty {
    text-align: center
}

table.dataTable.nowrap td,
table.dataTable.nowrap th {
    white-space: nowrap
}

div.dataTables_wrapper div.dataTables_length label {
    font-weight: 400;
    text-align: left;
    white-space: nowrap
}

div.dataTables_wrapper div.dataTables_length select {
    width: auto;
    display: inline-block
}

div.dataTables_wrapper div.dataTables_filter {
    text-align: right
}

div.dataTables_wrapper div.dataTables_filter label {
    font-weight: 400;
    white-space: nowrap;
    text-align: left
}

div.dataTables_wrapper div.dataTables_filter input {
    margin-left: .5em;
    display: inline-block;
    width: auto
}

div.dataTables_wrapper div.dataTables_info {
    padding-top: .85em;
    white-space: nowrap
}

div.dataTables_wrapper div.dataTables_paginate {
    margin: 0;
    white-space: nowrap;
    text-align: right
}

div.dataTables_wrapper div.dataTables_paginate ul.pagination {
    margin: 2px 0;
    white-space: nowrap;
    justify-content: flex-end
}

div.dataTables_wrapper div.dataTables_processing {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 200px;
    margin-left: -100px;
    margin-top: -26px;
    text-align: center;
    padding: 1em 0
}

table.dataTable thead>tr>td.sorting,
table.dataTable thead>tr>td.sorting_asc,
table.dataTable thead>tr>td.sorting_desc,
table.dataTable thead>tr>th.sorting,
table.dataTable thead>tr>th.sorting_asc,
table.dataTable thead>tr>th.sorting_desc {
    padding-right: 30px
}

table.dataTable thead>tr>td:active,
table.dataTable thead>tr>th:active {
    outline: none
}

table.dataTable thead .sorting,
table.dataTable thead .sorting_asc,
table.dataTable thead .sorting_asc_disabled,
table.dataTable thead .sorting_desc,
table.dataTable thead .sorting_desc_disabled {
    cursor: pointer;
    position: relative
}

table.dataTable thead .sorting:after,
table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc_disabled:after,
table.dataTable thead .sorting_desc_disabled:before {
    position: absolute;
    bottom: .9em;
    display: block;
    opacity: .3
}

table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc_disabled:before {
    top: 2px;
    right: 1em;
    content: "\2191"
}

table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_desc_disabled:after {
    top: 2px;
    right: .5em;
    content: "\2193"
}

table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_desc:after {
    opacity: 1
}

table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc_disabled:after {
    opacity: 0
}

div.dataTables_scrollHead table.dataTable {
    margin-bottom: 0!important
}

div.dataTables_scrollBody table {
    border-top: none;
    margin-top: 0!important;
    margin-bottom: 0!important
}

div.dataTables_scrollBody table thead .sorting:after,
div.dataTables_scrollBody table thead .sorting:before,
div.dataTables_scrollBody table thead .sorting_asc:after,
div.dataTables_scrollBody table thead .sorting_asc:before,
div.dataTables_scrollBody table thead .sorting_desc:after,
div.dataTables_scrollBody table thead .sorting_desc:before {
    display: none
}

div.dataTables_scrollBody table tbody tr:first-child td,
div.dataTables_scrollBody table tbody tr:first-child th {
    border-top: none
}

div.dataTables_scrollFoot>.dataTables_scrollFootInner {
    box-sizing: content-box
}

div.dataTables_scrollFoot>.dataTables_scrollFootInner>table {
    margin-top: 0!important;
    border-top: none
}

@media screen and (max-width:767px) {
    div.dataTables_wrapper div.dataTables_filter,
    div.dataTables_wrapper div.dataTables_info,
    div.dataTables_wrapper div.dataTables_length,
    div.dataTables_wrapper div.dataTables_paginate {
        text-align: center
    }
}

table.dataTable.table-sm>thead>tr>th {
    padding-right: 20px
}

table.dataTable.table-sm .sorting:before,
table.dataTable.table-sm .sorting_asc:before,
table.dataTable.table-sm .sorting_desc:before {
    top: 5px;
    right: .85em
}

table.dataTable.table-sm .sorting:after,
table.dataTable.table-sm .sorting_asc:after,
table.dataTable.table-sm .sorting_desc:after {
    top: 5px
}

table.table-bordered.dataTable td,
table.table-bordered.dataTable th {
    border-left-width: 0
}

table.table-bordered.dataTable td:last-child,
table.table-bordered.dataTable th:last-child {
    border-right-width: 0
}

div.dataTables_scrollHead table.table-bordered,
table.table-bordered.dataTable tbody td,
table.table-bordered.dataTable tbody th {
    border-bottom-width: 0
}

div.table-responsive>div.dataTables_wrapper>div.row {
    margin: 0
}

div.table-responsive>div.dataTables_wrapper>div.row>div[class^=col-]:first-child {
    padding-left: 0
}

div.table-responsive>div.dataTables_wrapper>div.row>div[class^=col-]:last-child {
    padding-right: 0
}
.table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
    border-top: 0;
    background: #018b1f;
    color: #fff;
}
</style>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 300px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter <?= ucwords($bookingtype);?> List</h4>
      </div>
      <form action="<?=adminurl('bookingview');?>" method="get">
        <input type="hidden" name="type" value="<?=$bookingtype;?>">
      <div class="modal-body"> 
            <div class="row">
            <div class="col-lg-6">Name/Mobile/Email/BookingID/Vehicle No.</div> 
            <div class="col-lg-6"><input type="text" name="n" class="form-control" placeholder="Enter name/mobile/email/bookingID/vehicleno" id="name" autocomplete="off" value="<?=$n;?>" ></div>
            </div>

            <div class="row mg_top_1">
            <div class="col-lg-6">From Date</div> 
            <div class="col-lg-6"><input type="date" name="f" class="form-control" id="fromDate" onchange="getDateVal(this.value)" value="<?=$f;?>" ></div>
            </div>

            <div class="row mg_top_1">
            <div class="col-lg-6">To Date</div> 
            <div class="col-lg-6"><input type="date"  name="t" class="form-control" id="toDate" value="<?=$t;?>" ></div>
            </div> 
         
      </div>
      <div class="modal-footer">
            <div class="row">
            <div class="col-lg-4">&nbsp;</div> 
            <div class="col-lg-4"><button type="submit" class="btn btn-success" >Search</button></div> 
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button></div>  
            </div>
      </div>
    </form>
    </div>

  </div>
</div> 


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>

const editMode = '<?=EDIT?>'; 
 
const userType = '<?=$user_type?>';

function getTotalRecordsData( qparam ){  
    $.ajax({
      url: '<?=adminurl('Vehicle_claim/getDataList?');?>'+qparam,
      type: "POST",
      data: {'is_count':'yes','start':1,'length':10},
      cache: false,
        success:function(response) {   
        $('#totalRecords' ).val( response );
        $('#totalBookings' ).html( response );
          if( response ){  
            loadCityData( qparam );
           
          }
        }
      }); 
} 


$(document).ready(function() { 
  let qparam = (new URL(location)).searchParams;
  getTotalRecordsData( qparam ); 
  loaddata();
   $('#responseData').removeAttr('style');
});



 
function loadCityData( qparam ){

    $('#responseData').html('');
    var newQueryParam = qparam+'&recordstotal='+$('#totalRecords').val();
    $('#responseData').DataTable({
        "processing" : true,
        "serverSide": true,
        "ajax" : {
            "url" : '<?=adminurl('Vehicle_claim/getDataList?');?>'+newQueryParam,
            "type":'POST', 
            dataSrc : (res)=>{ 
                
              return res.data
            }
        },
        "columns" :   [ { data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
                        { data: "id", "name": "Vehicle Details", "title": "Vehicle Details","render": cab_details_render },  
                        { data: "id", "name": "Claim Details", "title": "Claim Details","render": claim_details_render  },
                        { data: "id", "name": "Claim Clear Details", "title": "Claim Clear Details","render": claim_reponse_details_render }, 
                        { data: "id", "name": "Policy Details", "title": "Policy Details","render": policy_details_render }, 
                        { data: "id", "name": "Claim Remark", "title": "Claim Remark","render": claim_remark_render }, 
                        { data: "add_date", "name": "Add Date", "title": "Add Date" }, 
                        { data: "id", "name": "Action", "title": "Action", "render": action_render }],
        "rowReorder": { selector: 'td:nth-child(2)' },
        "responsive": true, 
        "destroy": true,
        "searchDelay": 1000,
        "searching": true, 
        //"pagingType": 'simple_numbers',
        "rowId": (a)=>{ return 'id_' + a.id; }, 
        "iDisplayLength": 10,
        "order": [[ 4, "asc" ]], 
    }); 

} 



function action_render(data, type, row, meta){
    
    let output = '';
    if(type === 'display'){ 
      
          output += '<div style="width:100px">' 
          if( editMode == 'yes'  ){
          output += '<a href="<?=adminurl('Vehicle_claim')?>/?id='+row.enc_id+'&redirect=<?=$redirect?>" class="btn-sm btn-warning" data-toggle="tooltip" title="Edit" ><i class="fa fa-edit"></i></a> | ';
          output += '<a href="<?=adminurl('Vehicle_claim/delete?delId=')?>'+row.enc_id+'&redirect=<?=$redirect?>" class="btn-sm btn-danger" data-toggle="tooltip" title="Delete" onclick="return confirm(`Are You Sure`)" ><i class="fa fa-gear mg_top_2"></i> </a>  |  ';
          output += '<br/><a href="<?=adminurl('Vehicle_claim/?vehicle_con_id=')?>'+row.vehicle_con_id+'&redirect=<?=$redirect?>" class="btn-sm btn-primary" data-toggle="tooltip" title="Add New"  ><i class="fa fa-plus mg_top_2"></i> </a>  |  ';
          } 
          
          output += '</div>'; 
      }
    return output;
} 

 

var cab_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += '<strong>Model</strong>:<span class="spang12"> '+row.model+'</span><br/>' ;
        data += '<strong>Category</strong>:<span class="spanr12"> '+row.category+'</span> <br/> ';  
        data += '<strong>Fuel/Year</strong>:<span class="spang12"> '+row.fueltype+' ( '+row.vyear+' )</span><br/>';  
        data += '<strong>Vehicle No</strong>:<span class="spanr12"> '+row.vnumber+'</span>';
  }
return data;
}


var claim_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += '<strong>Claim Date</strong>:<span class="spang12"> '+row.claim_date+'</span><br/>' ;
        data += '<strong>Claim Sequence</strong>:<span class="spang12"> '+row.claim_sequence+'</span><br/>' ;
        data += '<strong>Claim Amount</strong>:<span class="spanr12"> '+row.amount+'</span> ';  
  }
return data;
}

var policy_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += '<strong>Policy No.</strong>:<span class="spang12"> '+row.policy_no+'</span><br/>' ;
        data += '<strong>Valid From</strong>:<span class="spang12"> '+row.policy_valid_from+'</span><br/>' ;
        data += '<strong>Valid Till</strong>:<span class="spanr12"> '+row.policy_valid_till+'</span> <br/>';
        data += '<strong>From</strong>:<span class="spang12"> '+row.insu_company_name+'</span><br/>' ;
  }
return data;
}

var claim_reponse_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += '<strong>Claim Clear Status</strong>:<span class="spang12"> '+row.claim_cleared+'</span><br/>' ;
        if(row.claim_cleared === 'yes'){
         data += '<strong>Claim Clear On</strong>:<span class="spang12"> '+row.clear_claim_date+'</span>' ;   
        }  
  }
return data;
}
 

var claim_remark_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += '<span class="spang12">'+row.claim_details+'</span> ' ; 
  }
return data;
}

 

function getDateVal( vl ){
    $('#toDate').val(vl);
} 
</script> 



<script type="text/javascript"> 
  
</script>

<script type="text/javascript"> 
  function loaddata(){ setTimeout( function(){
       
    $('.sidebar-mini').addClass('sidebar-collapse');
    //$("div.col-sm-12" ).addClass( "table-responsive" ); 
document.getElementById("responseData").removeAttribute("style")
  },2000);} ;
  //window.load = loaddata();
</script>


<div class="modal fade" id="vehicleDetails" tabindex="-1" aria-labelledby="openModel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h4" id="openModel">Search Bike Service History By Vehicle Number:  </h5> 
        </div>
        <div class="modal-body" id="pageContent">
            <?php echo form_open_multipart( adminurl('Vehicle_claim/list' ),['method'=>'get']); ?>
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
  
  