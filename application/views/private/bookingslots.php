<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!----------------- Main content start ------------------------->
<script type="text/javascript">
    function filldate( d ){
        $('#todate').val( d );
    }
</script>
<style type="text/css">
    th.week-days, td.date { width: 140px; text-align: center; } 
    td.date{ border: 1px solid #ccc; padding: 5px; } 
    .reserve, .book{color: red; font-weight: 900}
    .bookingid{font-size:11px;}
</style>
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
    <form method="get" action="<?=base_url('private/bookingslots');?>">
        <div class="row">
            <div class="col-lg-4">
                <select name="id" class="form-control select22">
                    <?php if(!empty($vlist)){
                        foreach($vlist as $key=>$row){?>
                            <option value="<?=$row['vnumber'];?>" <?=($row['vnumber']==$id)?'selected':'';?>><?=$row['vehicle'];?></option>
                    <?php } }?>
                </select>
            </div>
            <div class="col-lg-2">
                <input type="date" value="<?=$from;?>" class="form-control" onchange="filldate(this.value)" name="from">
            </div>
            <div class="col-lg-2">
                <input type="date" value="<?=$to;?>" class="form-control" id="todate" name="to">
            </div>
            <div class="col-lg-2">
                <input type="submit" class="btn btn-primary" value="Search">
            </div>
            <div class="col-lg-2">
                <a href="<?=base_url('private/Viewvehiclelist');?>" class="btn btn-warning">Go Back</a>
            </div>
        </div>
    </form>
               
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                  <?php
                  echo $calendar;
                  ?> 
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
