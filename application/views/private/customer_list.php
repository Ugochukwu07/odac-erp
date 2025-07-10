<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>.cgreen{ color: green} .cred{ color: red }</style>
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
?>

<style>
.lastEditBtn{
    border:1px dotted red;
    padding: 5px 10px;
    border-radius: 10px;
}
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
    padding-right: 10px
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
    padding-right: 10px
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


<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
                <!--<a href="<?php echo $exporturl;?>" class="btn btn-sm btn-success pull-left"><i class="fa fa-download"></i> Download </a>-->
                <?php echo goToDashboard(); ?>
               <div style="width:150px; float:right">
               
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
 

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>  
<script>
  
  
  function getTotalRecordsData( qparam ){  
        $.ajax({
          url: '<?=adminurl('customerlist/getDataList?');?>'+qparam,
          type: "POST",
          data: {'is_count':'yes','start':1,'length':10},
          cache: false,
            success:function(response) {   
            $('#totalRecords' ).val( response );
            $('#totalBookings' ).html( response ); 
                loadCityData( qparam );   
            }
          }); 
    } 

$(document).ready(function() { 
   let qparam = (new URL(location)).searchParams;
   getTotalRecordsData( qparam );  
   $('#responseData').removeAttr('style');
});
 
 
const editMode = '<?=EDIT?>';
const removeMode = '<?=REMOVE?>';

function loadCityData( qparam ){

    $('#responseData').html('');
    var newQueryParam = qparam+'&recordstotal='+$('#totalRecords').val();
    $('#responseData').DataTable({
        "processing" : true,
        "serverSide": true,
        "ajax" : {
            "url" : '<?=adminurl('customerlist/getDataList?');?>'+newQueryParam,
            "type":'POST', 
            dataSrc : (res)=>{ 
                
              return res.data
            } 
        },
        "columns" :   [ { data: "sr_no", "name": "Sr.No.", "title": "Sr.No" },
                        { data: "id", "name": "Guest Name", "title": "Guest Name","render": guest_name_render  },  
                        { data: "id", "name": "Mobile", "title": "Mobile","render": guest_unique_render  },
                        { data: "id", "name": "Email", "title": "Email","render": guest_email_render }, 
                        { data: "id", "name": "Register Date", "title": "Register Date","render": add_date_render },
                        { data: "id", "name": "Status", "title": "Status","render": status_render }, 
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

 
            
var guest_unique_render = ( data, type, row, meta )=>{
    var data = ''; 
    if(type === 'display'){ 
    data += '<strong>'+row.uniqueid+' </strong>'; 
    }
    return data;
}

var guest_name_render = ( data, type, row, meta )=>{
    var data = ''; 
    if(type === 'display'){ 
    data += '<strong>'+row.fullname+' </strong>'; 
    }
    return data;
}

var guest_email_render = ( data, type, row, meta )=>{
    var data = ''; 
    if(type === 'display'){ 
    data += '<strong>'+row.emailid+' </strong>'; 
    }
    return data;
}


var add_date_render = ( data, type, row, meta )=>{
    var data = ''; 
    if(type === 'display'){ 
    data += '<strong>'+row.add_date+' </strong>'; 
    }
    return data;
}

var status_render = ( data, type, row, meta )=>{
    var data = ''; 
    if(type === 'display'){ 
    data += '<strong>'+(row.status==='yes'?'Active' : 'InActive')+' </strong>'; 
    }
    return data;
}

  
    
                  
function action_render(data, type, row, meta){
    
    let output = '';
    if(type === 'display'){ 
      
        output += '<div style="width:88px">' ;
        if( editMode == 'yes' ){
        //output += '<a href="<?=adminurl('add_veh_details')?>/?id='+row.enc_id+'&redirect=total" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit" ><i class="fa fa-edit"></i></a> | ';
        }  
        
        output += '</div>'; 
      }
    return output;
} 

  </script>
  