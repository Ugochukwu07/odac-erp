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

// Load RBAC helper for hierarchy functions
if (!function_exists('get_admin_hierarchy_display')) {
    require_once APPPATH . 'helpers/rbac_helper.php';
}

$bookingType = $this->input->get('type');
$current_user_level = get_admin_hierarchy_level();
$current_user_display = get_admin_hierarchy_display();
?>


<style>
       /* Vertical line timeline */
        .timeline {
            position: absolute;
            left: -6px;
            top: 0;
            bottom: 0;
            width: 5px;
            background-color: #00BFA5;
            z-index: 0;
        }
        .timeline:before { 
        background: #ffffff; 
        }

        .step {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
        }

        .step:before {
            content: '';
            position: absolute;
            left: -34px;
            top: 0;
            width: 30px;
            height: 30px;
            background-color: white;
            border: 3px solid #ccc; 
            z-index: 1;
        }

        .step.completed:before {
            content: '✔';
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background-color: #00BFA5;
            border-color: #00BFA5;
        }

        .details {
            margin-left: 20px;
            position: relative;
            z-index: 2;
        }

        .details h4 {
            margin: 0;
            font-size: 16px;
            font-weight: normal;
        }

        .details p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .admin-verify {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .admin-verify span {
            margin-right: 5px;
            font-size: 14px;
            color: #555;
        }

        .admin-verify img {
            width: 20px;
            height: 20px;
        }
    </style>

<!----------------- Main content start ------------------------->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
             <div class="row">
          <div class="col-lg-3"> 
          <a href="<?php echo $exporturl;?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Download CSV </a>
          <?php echo goToDashboard(); ?>
          </div>
          
          <!-- Admin Hierarchy Information -->
          <div class="col-lg-9">
            <div class="alert alert-info" style="margin-bottom: 10px;">
              <i class="fa fa-info-circle"></i> 
              <strong>Admin Hierarchy:</strong> You are logged in as 
              <span class="label <?php echo get_admin_hierarchy_badge_class(); ?>"><?php echo $current_user_display; ?></span>
              
              <?php if($current_user_level == 1): ?>
                <span class="text-success">(Can track all admin activities)</span>
              <?php elseif($current_user_level == 2): ?>
                <span class="text-warning">(Can track Manager and User activities)</span>
              <?php else: ?>
                <span class="text-info">(Can track only User activities)</span>
              <?php endif; ?>
              
              <?php if($current_user_level <= 2): ?>
                <a href="<?php echo adminurl('AdminActivity'); ?>" class="btn btn-xs btn-primary pull-right">
                  <i class="fa fa-users"></i> View Admin Activity Report
                </a>
              <?php endif; ?>
            </div>
          </div>

               <div class="col-lg-7">
                <?php  if(in_array( $bookingtype , $total_sum_array_list )){?>
                <strong class="spanr12">Today</strong> Total Sale : <strong class="spanr12"><?=$total_sale_amount?> </strong>
                Total Recieved Amount : <strong class="spanr12" ><?=$total_sale_booking_amount?></strong>
                Total Rest Amount : <strong class="spanr12"><?=$total_sale_rest_amount?></strong>
                <?php if(in_array($bookingtype , ['todaysale'] )){?>
                 <a href="<?=base_url('private/bookingview/?type='.$bookingtype.'&is_rest_amount=yes')?>">View</a>
                <?php }else if(in_array($bookingtype , ['today'] )){?>
                 <a href="<?=base_url('private/bookingview?type=restamount&f='.date('Y-m-01').'&t='.date('Y-m-d'))?>">View</a>
                <?php } }?>
                
                <?php  if(in_array($bookingtype , ['run'] )){?>
                <p>
                Total Cars : <strong class="spanr12"><?=$total_cars?> </strong>
                Hold Cars : <strong class="spanr12" ><?=$hold_booking_cars?></strong>
                Running Cars: <strong class="spanr12"><?=$run_cars?></strong>
                Free Cars: <strong class="spanr12"><?=$free_cars?></strong>
                <a href="<?=base_url('private/Checkvehiclestatus/?type=car&catid=1')?>">View</a>
                </br>
                Total Bikes : <strong class="spanr12"><?=$total_bike?> </strong>
                Hold Bikes : <strong class="spanr12" ><?=$hold_booking_bike?></strong>
                Running Bikes: <strong class="spanr12"><?=$run_bike?></strong>
                Free Bikes: <strong class="spanr12"><?=$free_bike?></strong>
                <a href="<?=base_url('private/Checkvehiclestatus/?type=bike&catid=2')?>">View</a>
                </p>
                <?php }?>
                
                <!-- SHow Monthly Data-->
                <?php if(!empty($monthly_data)){
                foreach($monthly_data as $key=>$value){?>
                <br/><strong class="spanr12"><?=$value['monthname'];?> </strong>:-
                Total Sale : <strong class="spanr12"><?=$value['total'];?> </strong>
                Total Recieved Amt. : <strong class="spanr12" ><?=$value['total_bookingamount'];?></strong>
                <!--Total OverDue : <strong class="spanr12"><?=$value['total_over_due_amount'];?></strong>-->
                Total Rest Amt. : <strong class="spanr12"><?=$value['total_restamount'];?></strong>
                
                <?php $urlBookingType = 'restamount'; if( date('M')==date('M',strtotime($value['from']))){ /*$urlBookingType = 'totalsale';*/ } ?> 
                <a href="<?=base_url('private/bookingview/?type='.$urlBookingType.'&f='.$value['from'].'&t='.$value['to'])?>">View</a>
                <?php }}?>
                
                </div>
                    <div class="col-lg-2">
                    <!--<a href="javascript:void(0);" onclick="openFilter()" data-toggle="modal" data-target="#myModal" class="pull-right" style='margin-left:10px;'> <i class="fa fa-filter"></i> Filter</a>-->
                     <a href="<?=adminurl('bookingview');?>?type=<?=$bookingtype?>" class="pull-right" style='margin-left:10px;'> <i class="fa fa-filter"></i> Reset </a> &nbsp;
                     <a href="javascript:void(0);" onclick="openFilter()" class="pull-right" style='margin-left:10px;'> <i class="fa fa-filter"></i> Filter</a>
                    </div>
                </div>
                </div>
                
                <!-- mannual filter  -->
                <div class="col-lg-12">
                <form action="<?=adminurl('bookingview');?>" method="get">
                        <input type="hidden" name="type" value="<?=$bookingtype;?>">
                <div class="row" id="filterDiv" style="display:<?php echo in_array($bookingtype ,[]) ? 'block' :'none';?>"> 
                            <div class="col-lg-3">
                             
                            <?php echo form_dropdown(['name'=>'veh','class'=>'form-control select22'], $vehicle_list, set_value('veh',$veh));?>  
                            </div>
                
                            <div class="col-lg-3"> 
                            <input type="date" name="f" class="form-control" id="fromDate" onchange="getDateVal(this.value)" value="<?=$f;?>" > 
                            </div>
                
                            <div class="col-lg-3"> 
                            <input type="date"  name="t" class="form-control" id="toDate" value="<?=$t;?>" > 
                            </div> 
                          
                            <div class="col-lg-3"> 
                                <button type="submit" class="btn btn-success"  >Search</button>
                            </div>  
                </div>
                </form>
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
.tabBtn{
    width: auto;
    height: 30px;
    float: left;
    margin-right: 4px;
}
.grnicon{
    font-size:14px;
    color: green;
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
            <div class="col-lg-4"><?=form_dropdown(['name'=>'','id'=>'last_activity_text','class'=>'form-control select22'], get_dropdownsmulti('pt_booking_terms',['contenttype'=>'editapproval','status'=>'yes'],'content','content','Reason--' ) )?></div> 
            <div class="col-lg-2"> <?php if($user_type == 'admin' ) {?><button type="button" class="btn btn-success" onclick="verifyEditLog()" >Verify</button><?php } ?></div> 
            <div class="col-lg-2"> <?php if($user_type == 'admin' ) {?><button type="button" class="btn btn-success" onclick="openPaymentTrackLog('')" >Track View</button><?php } ?></div> 
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div> 
            </div>
      </div> 
    </div>

  </div>
</div> 



<!-- Take Payment Modal -->
<div id="myTakePaymentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Take Payment</h4>
      </div> 
        <input type="hidden" name="" id="booking_tbl_id" value="">
        <input type="hidden" name="" id="ad_totalrestamount" value="0"> 
      <div class="modal-body"> 
      <div class="row">
         <div class="col-lg-6">
             <label>Select Payment Mode</label>
             <select class="form-control" id="ad_paymode">
                 <option value="cash" selected >Cash</option>
                 <option value="online">Online</option>
             </select> 
         </div> 
         <div class="col-lg-6">
             <label>Enter Amount </label>
             <input type="text" id="ad_amount" value=""  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
             <span id="restAmountText" class="spanr">0</span>
         </div> 
      </div>
      </div>
      <div class="modal-footer">
            <div class="row">
            <div class="col-lg-4">&nbsp;</div> 
            <div class="col-lg-4"><button type="button" class="btn btn-success" onclick="takePaymentSubmit()" >Submit</button></div> 
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>  
            </div>
      </div> 
    </div>

  </div>
</div> 


<!-- Refund Payment Modal -->
<div id="myRefundPaymentModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Refund Payment</h4>
      </div> 
        <input type="hidden" name="" id="rfbooking_tbl_id" value="">
        <input type="hidden" name="" id="rftotalbookingamount" value="0"> 
      <div class="modal-body"> 
      <div class="row">
         <div class="col-lg-4">
             <label>Select Payment Mode</label>
             <select class="form-control" id="rf_paymode">
                 <option value="cash" selected >Cash</option>
                 <option value="online">Online</option>
             </select> 
         </div> 
         
         <div class="col-lg-4">
             <label>Enter Transaction ID</label>
             <input type="text" id="transaction_id" value="" class="form-control" oninput="this.value = this.value.replace(/[^0-9A-Za-z.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
         </div>
         
         <div class="col-lg-4">
             <label>Enter Refund Amount</label>
             <input type="text" id="rf_amount" value="" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
         </div> 
      </div>
      </div>
      <div class="modal-footer">
            <div class="row">
            <div class="col-lg-4">&nbsp;</div> 
            <div class="col-lg-4"><button type="button" class="btn btn-success" onclick="refundPaymentSubmit()" >Submit</button></div> 
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>  
            </div>
      </div> 
    </div>

  </div>
</div> 


<!-- Cancel Booking Modal -->
<div id="cancelBookingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cancel Booking</h4>
      </div> 
        <input type="hidden" name="" id="cnbooking_tbl_id" value="">  
      <div class="modal-body"> 
      <div class="row">
         <div class="col-lg-12">
             <label>Select Cancel Reason</label>
             <?=form_dropdown(['name'=>'','id'=>'cn_reason','class'=>'form-control'],$reason_list )?> 
         </div>  
      </div>
      </div>
      <div class="modal-footer">
            <div class="row">
            <div class="col-lg-4">&nbsp;</div> 
            <div class="col-lg-4"><button type="button" class="btn btn-success" onclick="cancelBookingSubmit()" id="cancelBtn" >Submit</button></div> 
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>  
            </div>
      </div> 
    </div>

  </div>
</div> 


<!-- show Cancel Booking Reason Modal -->
<div id="showCancelBookingModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Show Booking Cancel Reason</h4>
      </div> 
         
      <div class="modal-body"> 
      <div class="row">
         <div class="col-lg-12"> 
             <p id="cancelText"></p>
         </div>  
      </div>
      </div>
      <div class="modal-footer">
            <div class="row">
            <div class="col-lg-4">&nbsp;</div> 
            <div class="col-lg-4">&nbsp;</div>  
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>  
            </div>
      </div> 
    </div>

  </div>
</div> 


<!-- Take Payment Modal -->
<div id="myCloseDiscountModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Enter Forcefully Discount</h4>
      </div> 
        <input type="hidden" name="" id="cd_booking_tbl_id" value="">
        <input type="hidden" name="" id="cd_totalrestamount" value="0"> 
      <div class="modal-body"> 
      <div class="row">
          
         <div class="col-lg-6">
             <label>Enter Amount </label>
             <input type="text" id="cd_enter_amount" value=""  class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
             <span id="cdRestAmountText" class="spanr">0</span>
         </div> 
      </div>
      </div>
      <div class="modal-footer">
            <div class="row">
            <div class="col-lg-4">&nbsp;</div> 
            <div class="col-lg-4"><button type="button" class="btn btn-success" onclick="closeDiscountPaymentSubmit()" >Submit</button></div> 
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>  
            </div>
      </div> 
    </div>

  </div>
</div> 
 

<!-- show Payment Track View Modal -->
<div id="showBookingPaymentTrackModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Track Payment(s)</h4>
      </div> 
         
      <div class="modal-body"> 
      <div class="row">
         <div class="col-lg-12" id="paymentTrackText" style="width: 90%; margin: 0px 56px;" > 
             
         </div>  
      </div>
      </div>
      <div class="modal-footer">
            <div class="row">
            <div class="col-lg-4">&nbsp;</div> 
            <div class="col-lg-4">&nbsp;</div>  
            <div class="col-lg-4"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></div>  
            </div>
      </div> 
    </div>

  </div>
</div> 

<style>
    .mgbtm{ margin-bottom:35px;}
</style>

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>

const editMode = '<?=EDIT?>';
const bookingType = '<?=$bookingType?>';

let extrabrtag = '';
if(['run'].includes( bookingType )){
    extrabrtag = '<br/><br/>';
}

 
const userType = '<?=$user_type?>';

function getTotalRecordsData( qparam ){  
    $.ajax({
      url: '<?=adminurl('Bookingview/getDataList?');?>'+qparam,
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
            "url" : '<?=adminurl('Bookingview/getDataList?');?>'+newQueryParam,
            "type":'POST', 
            dataSrc : (res)=>{ 
                
              return res.data
            }
        },
        "columns" :   [ { data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
                        { data: "id", "name": "Bookingid/Triptype/Domain", "title": "Bookingid/Triptype/Domain","render": booking_details_render },  
                        { data: "id", "name": "Customer", "title": "Customer","render": user_details_render  },
                        { data: "id", "name": "Pickup/Drop City", "title": "Pickup/Drop City","render": pickup_details_render }, 
                        { data: "id", "name": "Pickup/Drop Date", "title": "Pickup/Drop Date","render": pickup_dates_render }, 
                        { data: "id", "name": "Vehicle Details", "title": "Vehicle Details","render": vehicle_details_render },  
                        { data: "id", "name": "Booked By", "title": "Booked By", "render": booked_by_render },
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
      
          output += '<div style="width:140px">' 
          if( editMode == 'yes' ){
          output += '<div class="tabBtn"><a href="<?=adminurl('details')?>/?id='+row.enc_id+'&redirect='+bookingType+'" class="btn-sm btn-warning" data-toggle="tooltip" title="Details" ><i class="fa fa-eye"></i></a> |</div>';
          }
          
          if(  ['new'].includes( row.attemptstatus ) ){ 
              output += '<div class="tabBtn"> <a href="<?=adminurl('bookingview/confirm')?>?id='+row.id+'&redirect='+bookingType+'" class="btn-sm btn-primary" data-toggle="tooltip" title="Confirm Booking" onclick="return confirm(`Are You Sure`)" ><i class="fa fa-check"></i></a> |</div>';
         }  
         
          //assign/reassign driver 
          if( ( !['cancel','complete','new','temp'].includes( row.attemptstatus ) )  ){
              let driversign = row.vehicleno ? 'fa-user' : 'fa-user';  
              let drvbtn = row.vehicleno !== '' ? 'btn-success' : 'btn-info';
              var dvrtitle = row.vehicleno ? row.vehicleno  : 'Assign Vehicle'; 
                
              output += '<div class="tabBtn"><a href="<?=adminurl('assignvehicle/index')?>?id='+row.id+'&cityid='+row.cityid+'&redirect='+bookingType+'" class="btn-sm '+drvbtn+'" target="_blank" data-toggle="tooltip" title="'+dvrtitle+'" ><i class="fa '+driversign+'"></i></a> |</div>';
          
          }
          
         if(  !['temp'].includes( row.attemptstatus ) ){ 
            output += '<div class="tabBtn"><a href="<?=adminurl('slip?utm=')?>'+row.enc_id+'&redirect='+bookingType+'" class="btn-sm btn-primary" data-toggle="tooltip" title="Print Slip" target="_blank" ><i class="fa fa-file"></i></a> |</div>';
         }
          
         if(  !['cancel','complete','temp'].includes( row.attemptstatus ) ){  
              output += '<div class="tabBtn"><a href="javascript:void(0)" class="btn-sm btn-danger" data-toggle="tooltip" title="Cancel Booking" onclick="cancelBookingModel(`'+row.id+'`)"  ><i class="fa fa-close "></i></a> |</div>';
         }  
         
         if(  !['cancel','complete','temp'].includes( row.attemptstatus ) ){  
             output += '<div class="tabBtn"><a href="<?=adminurl('editbooking?id=')?>'+row.id+'&redirect='+bookingType+'" class="btn-sm btn-info" data-toggle="tooltip" title="Edit Booking" onclick="return confirm(`Are You Sure`)" ><i class="fa fa-edit"></i></a> |</div>';
         } 
         
         if(  ['approved','run'].includes( row.attemptstatus ) ){  
             output += '<div class="tabBtn"><a href="<?=adminurl('editbooking?id=')?>'+row.id+'&redirect='+bookingType+'&action=close" class="btn-sm btn-success" data-toggle="tooltip" title="Close Booking" onclick="return confirm(`Are You Sure`)" ><i class="fa fa-check"></i></a> |</div>';
         } 
         
         
        var breakLines = '';
        if( ['cancel'].includes( row.attemptstatus ) ) {
             output += '<div class="tabBtn"><a href="<?=adminurl('bookingview/reactive?id=')?>'+row.enc_id+'&redirect='+bookingType+'" class="btn-sm btn-success" data-toggle="tooltip" title="Reactive Booking" onclick="return confirm(`Are You Sure`)" ><i class="fa fa-gear "></i> </a> | </div>';
             output += '<div class="tabBtn"><a href="<?=adminurl('bookingview/delete?id=')?>'+row.id+'&redirect='+bookingType+'" class="btn-sm btn-danger" data-toggle="tooltip" title="Delete  Booking" onclick="return confirm(`Are You Sure`)" ><i class="fa fa-trash "></i> </a> |</div>';
        } 
        
        
        if(  row.edit_verify_status == 'edit' ){  
             output += '<div class="tabBtn"><a href="javascript:void(0)" class="btn-sm btn-success" data-toggle="tooltip" title="Verify Booking" onclick="openEditLog(`'+row.id+'`)" >Verify</a> |</div>';
        } 
        
        if( row.edit_verify_status !== '' && !['temp'].includes( row.attemptstatus )  ){  
             output += '<div class="tabBtn"><a href="<?=adminurl('details/editHistory?id=')?>'+row.enc_id+'&redirect='+bookingType+'&bookid='+row.bookingid+'" class="btn-sm btn-success" data-toggle="tooltip" title="Edit History" ><i class="fa fa-table "></i> </a> |</div>';
        }
        
        
        if(  ['approved','new'].includes( row.attemptstatus ) ){  
             output += '<div class="tabBtn"><a href="javascript:void(0)" class="btn-sm btn-success" data-toggle="tooltip" title="Resend Mail SMS" onclick="reSendMailSms(`'+row.id+'`)" ><i class="fa fa-envelope"></i></a> |</div>';
        } 
        
      
        if(  ['approved','complete'].includes( row.attemptstatus ) ){  
             output += '<div class="tabBtn"> <a href="javascript:void(0)" class="btn-sm btn-warning" data-toggle="tooltip" title="Take Payment" onclick="takePayment(`'+row.id+'`,`'+row.restamount+'`)" ><i class="fa fa-rupee"></i></a> |</div>';
        }  
        
         
        if(  !['temp'].includes( row.attemptstatus ) ){  
             output += '<div class="tabBtn"> <a href="javascript:void(0)" class="btn-sm btn-warning" data-toggle="tooltip" title="Refund Payment" onclick="refundPayment(`'+row.id+'`,`'+row.bookingamount+'`)" >Refund </a> |</div>';
        } 
        
        
        if(  ['complete'].includes( row.attemptstatus ) ){  
             output += '<div class="tabBtn"><a href="javascript:void(0)" class="btn-sm btn-danger" data-toggle="tooltip" title="Re Open" onclick="reOpenBooking(`'+row.id+'`)" ><i class="fa fa-folder-open"></i></a> |</div>';
        }  
        
        if(  !['temp'].includes( row.attemptstatus ) && row.is_invoice ){ 
            output += '<div class="tabBtn"><a href="<?=adminurl('bookingview/invoice_slip?id=')?>'+row.enc_id+'" class="btn-sm btn-success" data-toggle="tooltip" title="Print Invoice Slip" target="_blank" ><i class="fa fa-cloud-download"></i></a> |</div>';
        }
        if(  ['cancel'].includes( row.attemptstatus ) && row.message ){ 
            output += '<div class="tabBtn"><a href="javascript:void(0)'+row.enc_id+'" class="btn-sm btn-primary" data-toggle="tooltip" title="Show Cancel Booking Reason" onClick="showCancelBookingModel(`'+row.message+'`)" ><i class="fa fa-comment-o"></i></a> |</div>';
        }
        
        <?php if($user_type=='admin'){?>
            if(  ['complete'].includes( row.attemptstatus ) && row.restamount > 0  ){ 
               output += '<div class="tabBtn"><a href="javascript:void(0)" onclick="openCloseDiscount(`'+row.id+'`,`'+row.restamount+'`)" class="btn-sm btn-danger" data-toggle="tooltip" title="Apply Forcely Discount"> Close Discount </a> |</div>';
            }
            
        <?php }?>
        
        if( row.bookingamount > 0  ){ 
             output += '<div class="tabBtn"><a href="javascript:void(0)" onclick="openPaymentTrackLog(`'+row.id+'`)" class="btn-sm btn-info" data-toggle="tooltip" title="Track Payment"> Track Payment </a> |</div>';
        }
        
        output += '<div class="tabBtn"><a href="<?=adminurl('bookingview/?type=total_user_bookings&u_mobile=')?>'+row.uniqueid+'" class="btn-sm btn-primary" data-toggle="tooltip" title="All Guest Bookings" ><i class="fa fa-cog"></i></a> |</div>';
        
        
        
        output += '</div>'; 
      }
    return output;
} 

var booking_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){
        var tickImage = row.edit_verify_status;
        if( row.edit_verify_status == 'edit' ){
            tickImage = '<img src="<?=base_url('assets/images/red_tick.png')?>" width="20" />';
        }else if( row.edit_verify_status == 'verify' ){
            tickImage = '<img src="<?=base_url('assets/images/blue_tick.png')?>" width="20" />';
        }
        data += row.bookingid +' '+tickImage;
        data += '<br/><span class="spanr12" ><em><strong>'+row.triptype+'</strong></em></span>' ;
        data += '<br/><span class="spang12" ><em><strong>'+row.domain+'</strong></em></span>';  
        data += '<br/><span class="spanr12" ><em><strong>'+(row.attemptstatus=='complete'?'<i class="fa fa-check-square-o grnicon"></i> Booking Closed':row.attemptstatus)+'</strong></em></span>';  
        data += '<br/><span class="spanr12" ><em><strong>Add By: <span class="spang12" > '+row.add_by+' | '+row.add_by_name+' </span></strong></em></span>'; 
        if( row.edit_by_mobile !== ''){
        data += '<br/><span class="spanr12" ><em><strong>Last Edited By: <span class="spang12" > '+row.edit_by_mobile+' | '+row.edit_by_name+' </span></strong></em></span>'; 
        }
        data += '<br/><span class="spanr12" ><em><strong>Last Activity:</strong>  <span class="spang12" >'+row.last_activity+' </span></em></span>';
        data += '<br/><span class="spanr12" ><em><strong>Verify Status:</strong>  <span class="spang12" >'+row.verify_status+' </span></em></span>'; 
  }
return data;
}

var user_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += 'Uid:<span class="spang12"> '+row.uniqueid+'</span><br/>' ;
        data += 'Name:<span class="spanr12"> '+row.name+'</span> <br/> ';  
        data += 'Mob:<span class="spang12"> '+row.mobileno+'</span><br/>';  
        data += 'Email:<span class="spanr12"> '+row.email+'</span>';
  }
return data;
}

var pickup_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += '<span class="spang12" ><em><strong>'+row.pickupcity+'</strong></em></span>  <br/>' ;
        data += '<span class="spanr12" ><em><strong>'+(row.dropcity ? row.dropcity : row.dropaddress)+'</strong></em></span> ';  
  }
return data;
}

 

var pickup_dates_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += '<span class="spanr12" ><em><strong>Pickup: <span class="spang12" > '+row.pickupdates+' </span></strong></em></span>'; 
        data += '<br/><span class="spanr12" ><em><strong>Drop: <span class="spang12" > '+row.dropdates+' </span></strong></em></span>'; 
        data += '<br/><span class="spanr12" ><em><strong>Total Days: <span class="spang12" > '+row.driverdays+' , '+row.driverdays+' x  '+row.vehicle_price_per_unit+' </span></strong></em></span>'; 
        data += '<br/><span class="spanr12" ><em><strong>Created: <span class="spang12" > '+row.bookingdates+' </span></strong></em></span>'; 
        if( row.ext_days > 0 ){
        data += '<br/><span class="spanr12" ><em><strong>Extended Days: <span class="spang12" > '+(row.total_extend_days > 0 ? row.total_extend_days : row.ext_days )+' </span></strong></em></span>';  
        }
        if(  row.ext_apply_on !==  null ){ 
        data += '<br/><span class="spanr12" ><em><strong>Extend Apply On: <span class="spang12" > '+row.ext_apply_on+' ( '+row.ext_days+' Days )</span></strong></em></span>';
        }
        if(  row.edit_date !==  null ){
        data += '<br/><span class="spanr12" ><em><strong>Last Activity On: <span class="spang12" > '+row.edit_date+' </span></strong></em></span>';
        }
        if( ['complete'].includes( row.attemptstatus ) ){ 
        data += '<br/><span class="spanr12" ><em><strong>Close Date: <span class="spang12" > '+row.close_date+' </span></strong></em></span>'; 
        }
        
        data += '<br/><span class="spanr12" ><em><strong>Lastest Recieved: <span class="spang12" > '+row.lates_recieved_amount+' </span></strong></em></span>'; 
        
        
  }
return data;
}

var vehicle_details_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        data += row.model ;
        //if( row.driverstatus == 'accept'){ 
        data += '<br/><span class="spang12"><em><strong>'+row.vehicleno+'</strong></em></span>';  
        //}
        data += '<br/><span class="spanr12" ><em><strong>Sub-Total Amt: <span class="spang12" > '+row.grosstotal+' </span></strong></em></span>'; 
        if( row.offerprice > 0 ){
        data += '<br/><span class="spanr12" ><em><strong>Discount Amt: <span class="spang12" > '+row.offerprice+' </span></strong></em></span>'; 
        }
        data += '<br/><span class="spanr12" ><em><strong>Total Amt: <span class="spang12" > '+row.totalamount+' </span></strong></em></span>'; 
        data += '<br/><span class="spanr12" ><em><strong>Received Amount: <span class="spang12" > '+row.bookingamount+' </span></strong></em></span>'; 
        
        data += '<br/><span class="spanr12" ><em><strong>Balance Amount: <span class="spang12" > '+row.restamount+' </span></strong></em></span>'; 
        if( row.ext_days > 0 ){
        data += '<br/><span class="spanr12" ><em><strong>Extend Amount: <span class="spang12" > '+((row.ext_days * row.vehicle_price_per_unit)-(row.ext_days * row.discount_per_day))+' </span></strong></em></span>'; 
        }
        
        if( row.hold_days > 0 ){
        data += '<br/><span class="spanr12" ><em><strong>Hold Days: <span class="spang12" > '+row.hold_days+' </span></strong></em></span>'; 
        }
        
  }
return data;
}

var booked_by_render = ( data, type, row, meta )=>{
  var data = '';
  if(type === 'display'){ 
        if( row.add_by_name ){
            data += '<a href="javascript:void(0)" onclick="getUserDetails(\''+row.add_by+'\')" class="btn btn-sm btn-info" title="View User Details">';
            data += '<i class="fa fa-user"></i> '+row.add_by_name;
            data += '</a>';
        } else {
            data += '<span class="text-muted">System</span>';
        }
  }
return data;
}

function getUserDetails(mobile) {
    $.ajax({
        type: 'POST',
        url: '<?=base_url('private/Users/getUserByMobile')?>',
        data: {mobile: mobile},
        success: function(response) {
            if(response.success && response.user_id) {
                window.open('<?=adminurl('Users/edit/')?>' + response.user_id, '_blank');
            } else {
                alert('User not found');
            }
        },
        error: function() {
            alert('Error fetching user details');
        }
    });
}

function getDateVal( vl ){
    $('#toDate').val(vl);
} 

function openPaymentTrackLog(id=''){
    var bid = id !=='' ? id : $('#editId').val();
    $('#paymentTrackText').html( '' );
    $.ajax({
        type:'POST',
        data: {'id': bid},
        url: '<?=base_url('private/bookingview/getPaymentTrackLog')?>',
        success: ( res )=>{
            $('#paymentTrackText').html( res );
            $('#showBookingPaymentTrackModal').modal('show');
        }
    })
}

function openEditLog(id){
    $('#editId').val( id );
    $('#editHtmlLog').html( '' );
    $.ajax({
        type:'POST',
        data: {'id': id},
        url: '<?=base_url('private/bookingview/getEditLog')?>',
        success: ( res )=>{
            $('#editHtmlLog').html( res );
            $('#myEditModal').modal('show');
        }
    })
}

function verifyEditLog(){
    var id = $('#editId').val();
    var verify_status = $('#last_activity_text option:selected').val();
    $.ajax({
        type:'POST',
        data: {'id': id,'verify_status':verify_status},
        url: '<?=base_url('private/bookingview/verifyEditLog')?>',
        success: ( res )=>{ 
            $('#myEditModal').modal('hide');
            window.location.reload();
        }
    });
}

function takePayment( id, totalamount ){ 
    $('#myTakePaymentModal').modal('show');
    $('#booking_tbl_id').val( id );
    $('#ad_totalrestamount').val( totalamount );
    $('#restAmountText').html( 'Rest Amount: '+totalamount );
}

  function takePaymentSubmit(){
        var paymode = $('#ad_paymode option:selected').val();
        var totalrestamount = $('#ad_totalrestamount').val();
        var amount = $('#ad_amount').val();
        var id = $('#booking_tbl_id').val();
        if( amount == '' || amount == 0 ){
            alert('Enter Amount'); return;
        }
        
        if( parseFloat(amount) > parseFloat(totalrestamount) ){
             alert('You can not enter amount more than rest amount , Your Rest Amount is: '+ totalrestamount ); return;
        }
        
        $.ajax({
        type:'POST',
        data: {'id': id,'amount':amount,'paymode':paymode },
        url: '<?=base_url('private/Editbooking/takepartialpayment')?>',
        success: ( res )=>{ 
            $('#myTakePaymentModal').modal('hide');
            window.location.reload();
        }
    });
  }
    
//refund amount

function refundPayment( id, bookingamount ){ 
    $('#myRefundPaymentModal').modal('show');
    $('#rfbooking_tbl_id').val( id );
    $('#rftotalbookingamount').val( bookingamount );
}
    
    function refundPaymentSubmit(){
        var paymode = $('#rf_paymode option:selected').val();
        var rftotalbookingamount = $('#rftotalbookingamount').val();
        var transaction_id = $('#transaction_id').val();
        var amount = $('#rf_amount').val();
        var id = $('#rfbooking_tbl_id').val();
        if( amount == '' || amount == 0 ){
            return alert('Enter Amount');
        }
        
        if( parseInt(amount) > parseInt( rftotalbookingamount ) ){
            return alert('Enter can not enter amount more than booking amount , Your Booking Amount is: '+ rftotalbookingamount );
        }
        
        if( confirm('Are You Sure?')){ 
            $.ajax({
            type:'POST',
            data: {'id': id,'amount':amount,'paymode':paymode, 'transaction_id': transaction_id },
            url: '<?=base_url('private/Editbooking/refundPayment')?>',
            success: ( res )=>{ 
                $('#myRefundPaymentModal').modal('hide');
                window.location.reload();
            }
            });
        }
  }
  
  function reOpenBooking( id ){
      if( confirm('Are You Sure? to open booking')){ 
            $.ajax({
            type:'POST',
            data: {'id': id },
            url: '<?=base_url('private/Editbooking/reOpenBooking')?>',
            success: ( res )=>{  
                
                window.location.reload();
            }
            });
        }
  }
  
  function reSendMailSms( id ){
      if( confirm('Are You Sure? want to send mail/sms to the guest')){ 
            $.ajax({
            type:'POST',
            data: {'id': id },
            url: '<?=base_url('private/Bookingview/reSendMailSms')?>',
            success: ( res )=>{  
                alert('SMS & Mail Sent Successfully');
            }
            });
        }
  }
    
    
function openCloseDiscount( id, restAmount ){ 
    $('#myCloseDiscountModal').modal('show');
    $('#cd_booking_tbl_id').val( id );
    $('#cd_totalrestamount').val( restAmount );
    $('#cd_enter_amount').val( restAmount );
    $('#cdRestAmountText').html( 'Total Over Due Amount: '+restAmount );
}  

  function closeDiscountPaymentSubmit(){ 
        var restAmount = $('#cd_totalrestamount').val(); 
        var amount = $('#cd_enter_amount').val();
        var id = $('#cd_booking_tbl_id').val();
        if( amount == '' || amount == 0 ){
            return alert('Enter Amount');
        }
        
        if( parseInt(amount) > parseInt( restAmount ) ){
            return alert('Enter can not enter amount more than Overdue amount , Your Overdue Amount is: '+ restAmount );
        }
        
        if( confirm('Are You Sure?')){ 
            $.ajax({
            type:'POST',
            data: {'id': id,'amount': amount },
            url: '<?=base_url('private/Bookingview/discountclose')?>',
            success: ( res )=>{ 
                if(!res){
                   return alert('Enter Amount And ID' );  
                }else{
                $('#myCloseDiscountModal').modal('hide');
                window.location.reload();
                }
            }
            });
        }
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
  
  
  
  function openFilter(){
      $('#filterDiv').toggle(500);
  }
  
  function cancelBookingModel( id ){
      $('#cnbooking_tbl_id').val( id );
      $('#cancelBookingModal').modal('show');
  }
  function cancelBookingSubmit(){
      var id = $('#cnbooking_tbl_id').val();
      var reason = $('#cn_reason option:selected').val();
      
      if( confirm('Are You Sure? want to cancel this booking')){ 
            $.ajax({
            type:'POST',
            data: {'id': id,'message':reason },
            url: '<?=base_url('private/Bookingview/cancel')?>',
            beforeSend: function(){ $('#cancelBtn').prop( 'disabled', true); },
            success: ( res )=>{
                $('#cancelBtn').prop( 'disabled', false );
                var obj = JSON.parse( res );
                if( obj.status ){
                    alert( obj.message );
                    setTimeout(()=>{ $('#id_'+id ).hide(); $('#cancelBookingModal').modal('hide') }, 500 );
                }else{
                    alert( obj.message ); 
                } 
            }
            });
        }
  } 
  
  function showCancelBookingModel( msg  ){
      $('#cancelText').text( msg );
      $('#showCancelBookingModal').modal('show');
  }
  
</script>
<script>
    setTimeout( ()=>{
        $('.select22').select2();
    }, 1200 );
</script>

