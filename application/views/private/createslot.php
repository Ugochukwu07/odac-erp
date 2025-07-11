<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Create Time Slots</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form action="<?php echo adminurl('createslot'); ?>" method="post">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="fromDate">From Date</label>
                                <input type="text" class="form-control datepicker" id="fromDate" name="fromDate" placeholder="Select From Date" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="toDate">To Date</label>
                                <input type="text" class="form-control datepicker" id="toDate" name="toDate" placeholder="Select To Date" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                             <div class="form-group">
                                <label for="toDate">&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Create Slots</button>
                             </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row --> 