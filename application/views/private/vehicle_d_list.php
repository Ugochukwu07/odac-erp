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
                <a href="<?php echo $exporturl;?>" class="btn btn-sm btn-success pull-left"><i class="fa fa-download"></i> Download </a>
                <?php echo goToDashboard(); ?>
               <div style="width:150px; float:right">
               <a href="<?php echo adminurl('add_veh_details?redirect=total');?>" class="btn btn-sm btn-primary "><i class="fa fa-plus"></i> Add </a>&nbsp; | &nbsp;
               <a href="javascript:void(0)" onclick="openVehiclePopup();" class="btn btn-sm btn-success "><i class="fa fa-filter"></i> Filter </a>
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

<div class="modal fade" id="vehicleDetails" tabindex="-1" aria-labelledby="openModel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h4" id="openModel">Search Vehicle By Vehicle Number:  </h5> 
        </div>
        <div class="modal-body" id="pageContent">
            <?php echo form_open_multipart( adminurl('vehicle_d_list'),['method'=>'get']); ?>
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


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>  
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
  
  
  function getTotalRecordsData( qparam ){  
        $.ajax({
          url: '<?=adminurl('vehicle_d_list/getDataList?');?>'+qparam,
          type: "POST",
          data: {'is_count':'yes','start':1,'length':10},
          cache: false,
            success:function(response) {   
            $('#totalRecords' ).val( response );
            $('#totalBookings' ).html( response );
                if( response  == 0 ){
                     setTimeout( ()=>{ openVehiclePopup(); },500 );
                }
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
            "url" : '<?=adminurl('vehicle_d_list/getDataList?');?>'+newQueryParam,
            "type":'POST', 
            dataSrc : (res)=>{ 
                
              return res.data
            } 
        },
        "columns" :   [ { data: "sr_no", "name": "Sr.No.", "title": "Sr.No" },
                        { data: "id", "name": "Vehicle Details", "title": "Vehicle Details","render": vehicle_details_render },  
                        { data: "id", "name": "White Permit", "title": "White Permit","render": white_permit_render  },
                        { data: "id", "name": "Permit", "title": "Permit","render": simple_permit_render }, 
                        { data: "id", "name": "Tax", "title": "Tax","render": tax_render }, 
                        { data: "id", "name": "Fitness", "title": "Fitness","render": fitness_render },  
                        { data: "id", "name": "Insurance", "title": "Insurance","render": insurance_render },  
                        { data: "id", "name": "Polution", "title": "Polution","render": polution_render },   
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

 
            
var vehicle_details_render = ( data, type, row, meta )=>{
  var data = '';
  var tickImage = '';
  if( row.edit_verify_status === 'edit' ){
      tickImage = '<img src="<?=base_url('assets/images/red_tick.png')?>" width="20" />';
  }else if( row.edit_verify_status === 'verify' ){
      tickImage = '<img src="<?=base_url('assets/images/blue_tick.png')?>" width="20" />';
  }
  
  if(type === 'display'){ 
        data += row.model + tickImage; 
        data += '<br/><strong>'+row.vnumber+' </strong>'; 
        data += '<br/>'+row.fueltype;
        data += '<br/>('+row.vyear+')'; 
        data += '<br/><span class="spanr12" ><em><strong>Add By: <span class="spang12" > '+row.add_by_name+' | '+row.add_by_mobile+' </span></strong></em></span>'; 
        if( row.edit_by_mobile !== ''){
        data += '<br/><span class="spanr12" ><em><strong>Last Edited By: <span class="spang12" > '+row.edit_by_name+' | '+row.edit_by_mobile+' </span></strong></em></span>'; 
        }
        data += '<br/><span class="spanr12" ><em><strong>Last Edited: <span class="spang12" > '+row.edit_dated+' </span></strong></em></span>'; 
        
  }
return data;
}


var white_permit_render = ( data, type, row, meta )=>{
  var data = ''; 
  if(type === 'display'){ 
        data += '<span class="cgreen"> From : '+row.white_permit_from+' </span>'; 
        data += '<br/><span class="cred">Till : '+row.white_permit_till+'</span>'; 
        if(row.last_wpermit_edit !=='' ){
        data += '<br/><br/><span class="lastEditBtn">'+row.last_wpermit_edit+'</span>';
        }
  }
return data;
} 

var simple_permit_render = ( data, type, row, meta )=>{
  var data = ''; 
  if(type === 'display'){ 
        data += '<span class="cgreen"> From : '+row.permit_from+' </span>'; 
        data += '<br/><span class="cred">Till : '+row.permit_till+'</span>';
        if(row.last_permit_edit !=='' ){
        data += '<br/><br/><span class="lastEditBtn">'+row.last_permit_edit+'</span>';
        }
  }
return data;
}   

var tax_render = ( data, type, row, meta )=>{
  var data = ''; 
  if(type === 'display'){ 
        data += '<span class="cgreen"> From : '+row.tax_from+' </span>'; 
        data += '<br/><span class="cred">Till : '+row.tax_till+'</span>';
        if(row.last_tax_edit !=='' ){
        data += '<br/><br/><span class="lastEditBtn">'+row.last_tax_edit+'</span>';
        }
  }
return data;
} 

var fitness_render = ( data, type, row, meta )=>{
  var data = ''; 
  if(type === 'display'){ 
        data += '<span class="cgreen"> From : '+row.fitness_from+' </span>'; 
        data += '<br/><span class="cred">Till : '+row.fitness_till+'</span>'; 
        if(row.last_fitness_edit !=='' ){
        data += '<br/><br/><span class="lastEditBtn">'+row.last_fitness_edit+'</span>';
        }
  }
return data;
} 

var insurance_render = ( data, type, row, meta )=>{
  var data = ''; 
  if(type === 'display'){ 
        data += '<span class="cgreen"> From : '+row.insurence_from+' </span>'; 
        data += '<br/><span class="cred">Till : '+row.insurence_till+'</span>';
        data += '<br/><span class="cgreen">Policy No : '+row.policy_no+'</span>';
        data += '<br/><span class="cred">From : '+row.insu_company_name+'</span>';
        if(row.last_insurence_edit !=='' ){
        data += '<br/><br/><span class="lastEditBtn">'+row.last_insurence_edit+'</span>';
        }
        if(row.last_policy_no_edit !=='' ){
        data += '<br/><span class="lastEditBtn">'+row.last_policy_no_edit+'</span>';
        }
        if(row.last_insu_company_name_edit !=='' ){
        data += '<br/><span class="lastEditBtn">'+row.last_insu_company_name_edit+'</span>';
        }
        
        if(row.payment_mode !=='' ){ 
        data += '<br/><span class="cgreen">Payment Mode: '+row.payment_mode+'</span>';
        data += '<br/><span class="cred">Date: '+row.payment_date+'</span>';
        data += '<br/><span class="cgreen">Payment ID: '+row.payment_txn_id+'</span>';
        }
  }
return data;
} 

var polution_render = ( data, type, row, meta )=>{
  var data = ''; 
  if(type === 'display'){ 
        data += '<span class="cgreen"> From : '+row.polution_from+' </span>'; 
        data += '<br/><span class="cred">Till : '+row.polution_till+'</span>';
        if(row.last_polution_edit !=='' ){
        data += '<br/><br/><span class="lastEditBtn">'+row.last_polution_edit+'</span>';
        }
  }
return data;
}

  
    
                  
function action_render(data, type, row, meta){
    
    let output = '';
    if(type === 'display'){ 
      
        output += '<div style="width:88px">' ;
        if( editMode == 'yes' ){
        output += '<a href="<?=adminurl('add_veh_details')?>/?id='+row.enc_id+'&redirect=total" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit" ><i class="fa fa-edit"></i></a> | ';
        }
        
        if( removeMode == 'yes' ){
        output += '<a href="<?=adminurl('vehicle_d_list/delete')?>/?delId='+row.enc_id+'&redirect=total" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Edit"  onclick="return confirm(`Do you want delete this record`)"><i class="fa fa-trash"></i></a> | ';
        }
        
        output += '<br/><br/>'; 
        
        if(  row.edit_verify_status == 'edit' ){ 
            output += '<a href="javascript:void(0)" class="btn-sm btn-success mgbtm" data-toggle="tooltip" title="Verify Service" onclick="openEditLog(`'+row.id+'`,`edit`)" >Verify</a>'; 
        }else if( row.edit_by_mobile ){
            output += '<a href="javascript:void(0)" class="btn-sm btn-success mgbtm" data-toggle="tooltip" title="Edit History" onclick="openEditLog(`'+row.id+'`,`view`)" > <i class="fa fa-table mg_top_2"> </i></a>'; 
        }  
        
        output += '</div>'; 
      }
    return output;
} 

  </script>
  