<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$session_data = $this->session->userdata('adminloginstatus');
if(empty($session_data)){
  redirect( base_url('mylogin.html') ); exit;
}


// RBAC-aware user type handling
$user_roles = isset($session_data['user_roles']) ? $session_data['user_roles'] : [];
$user_type = 'admin'; // Default

if (!empty($user_roles)) {
    if (in_array('Super Admin', $user_roles)) {
        $user_type = 'admin';
    } elseif (in_array('Manager', $user_roles)) {
        $user_type = 'manager';
    } elseif (in_array('User', $user_roles)) {
        $user_type = 'user';
    }
}
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
          <a href="<?php echo $exporturl;?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Download CSV </a>
          <?php echo goToDashboard(); ?>
          </div>

               <div class="col-lg-6">
                
                </div>
                    <div class="col-lg-2">
                    <!--<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" class="pull-right" style='margin-left:10px;'> <i class="fa fa-filter"></i> Filter</a>-->
                    </div>
                </div>
                </div>
            <!-- /.box-header -->
            <div class="box-body  table-responsive "> 
              <input type="hidden" id="totalRecords" value="0" > 
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
        <h4 class="modal-title">Filter <?= ucwords($leadtype);?> List</h4>
      </div>
      <form action="<?=adminurl('leads');?>" method="get">
        <input type="hidden" name="type" value="<?=$leadtype;?>">
      <div class="modal-body"> 
            <div class="row">
            <div class="col-lg-6">Name/Mobile/Email/BookingID/Vehicle No.</div> 
            <div class="col-lg-6"><input type="text" name="n" class="form-control" placeholder="Enter name/mobile/email" id="name" autocomplete="off" value="<?=$n;?>" ></div>
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

<style>
    .mgbtm{ margin-bottom:35px;}
</style>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>

const editMode = '<?=EDIT?>';
const leadtype = '<?=$leadtype?>';

let extrabrtag = '';
if(['run'].includes( leadtype )){
    extrabrtag = '<br/><br/>';
}

 
const userType = '<?=$user_type?>';

function getTotalRecordsData( qparam ){  
    $.ajax({
      url: '<?=adminurl('leads/getDataList?');?>'+qparam,
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
            "url" : '<?=adminurl('leads/getDataList?');?>'+newQueryParam,
            "type":'POST', 
            dataSrc : (res)=>{ 
                console.log( res );
              return res.data
            }
        },
        "columns" :   [ { data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
                        { data: "id", "name": "Lead ID/Domain", "title": "Lead ID/Domain","render": lead_details_render },  
                        { data: "id", "name": "Customer", "title": "Customer","render": user_details_render  },
                        { data: "id", "name": "Service Details", "title": "Service Details","render": service_details_render }, 
                        { data: "id", "name": "Add Date", "title": "Add Date","render": pickup_dates_render }, 
                        { data: "id", "name": "Picked Role Details", "title": "Picked Role Details","render": picked_details_render },  
                        { data: "id", "name": "Action", "title": "Action", "render": action_render }],
        "rowReorder": { selector: 'td:nth-child(2)' },
        "responsive": true, 
        "destroy": true,
        "searchDelay": 2000,
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
      
          output += '<div style="width:120px">'  
          
          if(  ['new'].includes( row.lead_status ) ){ 
              output += '<a href="<?=adminurl('leads/confirm')?>?id='+row.id+'&redirect='+leadtype+'" class="btn-sm btn-primary mgbtm" data-toggle="tooltip" title="Pickup Lead" onclick="return confirm(`Are You Sure`)" >Pickup Lead</a>';
         }  
          
        
        output += '</div>'; 
      }
    return output;
} 

var lead_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){
        data += row.lead_uid; 
        data += '<br/><span class="spang12" ><em><strong>'+row.domain+'</strong></em></span>';  
        data += '<br/><span class="spanr12" ><em><strong>'+row.lead_status+'</strong></em></span>';  
  }
return data;
}

var user_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += 'Name:<span class="spanr12"> '+row.full_name+'</span> <br/> ';
        if(  !['new'].includes( row.lead_status ) ){ 
            data += 'Mob:<span class="spang12"> '+row.mobile_no+'</span><br/>';  
            data += 'Email:<span class="spanr12"> '+row.email_id+'</span>';
        }else{
           data += 'Mob:<span class="spang12"> ........</span><br/>';
           data += 'Email:<span class="spanr12"> .......</span>'; 
        }
  }
return data;
}

var service_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += '<span class="spang12" ><em><strong>'+row.service_type+'</strong></em></span>  <br/>' ;
        data += '<span class="spanr12" ><em><strong>'+row.service_city_name+'</strong></em></span> ';  
  }
return data;
}

 

var pickup_dates_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += '<span class="spang12"><em><strong>'+row.added_date+'</strong></em></span> <br/>' ; 
  }
return data;
}

var picked_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        if( !['new'].includes( row.lead_status ) ){
            data += 'Name:<span class="spanr12"> '+checkNull( row.picked_by_name )+'</span> <br/> ';  
            data += 'Mob:<span class="spang12"> '+checkNull( row.picked_by_mobile )+'</span><br/>';  
            data += 'Picked On:<span class="spanr12"> '+row.pickeddate+'</span>'; 
        }
  }
return data;
}

function checkNull( vl ){
    if( typeof vl !== 'null' ){
       return vl; 
    }else{
        return '';
    }
} 

function getDateVal( vl ){
    $('#toDate').val(vl);
} 
</script> 



<script type="text/javascript"> 
  function gotofilter(){
    var type = $(".filter:checked").val(); 
     if( type.length > 0 ){ window.location.href='<?php echo adminurl('front/Searchquery/?bookingtype='.$bookingtype.'&q=');?>'+ type; }
  } 
</script>

<script type="text/javascript"> 
  function loaddata(){ setTimeout( function(){
       
    $('.sidebar-mini').addClass('sidebar-collapse');
    //$("div.col-sm-12" ).addClass( "table-responsive" ); 
document.getElementById("responseData").removeAttribute("style")
  },2000);} ;
  //window.load = loaddata();
</script>