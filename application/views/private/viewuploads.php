<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!----------------- Main content start ------------------------->
<link rel="stylesheet" href="<?php echo base_url('assets/easyzoom/easyzoom.css');?>"  /> 

 <section class="content">
      <div class="row">
        <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>Sr. No.</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Value</th>
                    <th>Uploaded On</th> 
                    </tr>
                </thead>
                
                <tbody>
                <?php $i = '1';
				if( !is_null($list))
				 foreach($list as $key=>$value):
 
        $status = ($value['verifystatus']=='yes') ? 'no' : 'yes';
        $statustxt = ($value['verifystatus']=='yes') ? 'InActive' : 'Active';
        $btn = ($value['verifystatus']=='yes') ? 'btn-success' : 'btn-danger';
        $lock = ($value['verifystatus']=='yes') ? 'check' : 'check';
        $btnuploads = ($value['verifystatus']=='yes')?'btn-success':'btn-danger';


        $goto["page"] = "Viewuploads/?id=".$id.'&usertype='.$usertype;
        $goto["upId"] = $value['id'];
        $goto["action"] = "statusupdate";
        $goto["value"] = $status;
        $goto["table"] = "uploads";
        $goto["extraclm"] = "verifystatus";
        $goto["extraclmval"] = $status;
        ?>
                        
                        <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo CapsLetter($value['documenttype']); ?></td>
                        <td>
                        <?php echo "<img src=".uploads('uploads').$value['documentorimage']." style='width:150px; height:100px'>";?>
                        
                        </td>
           <td><?php echo $value['value'];?></td>

          <td><?php echo date('d M Y h:i A',strtotime($value['uploaddate'])); ?></td>
                 </tr>
                  
                <?php $i++; endforeach ;?>
                
                </tbody>
                
                
                <tfoot>
     			    <tr>
                    <th>Sr. No.</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Value</th>
                    <th>Uploaded On</th> 
                    </tr>
                </tfoot>
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
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url('assets/easyzoom/easyzoom.js');?>"></script>
	<script>
		// Instantiate EasyZoom instances
		var $easyzoom = $('.easyzoom').easyZoom();

		// Setup thumbnails example
		var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

		$('.thumbnails').on('click', 'a', function(e) {
			var $this = $(this);

			e.preventDefault();

			// Use EasyZoom's `swap` method
			api1.swap($this.data('standard'), $this.attr('href'));
		});

		// Setup toggles example
		var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

		$('.toggle').on('click', function() {
			var $this = $(this);

			if ($this.data("active") === true) {
				$this.text("Switch on").data("active", false);
				api2.teardown();
			} else {
				$this.text("Switch off").data("active", true);
				api2._init();
			}
		});
	</script>
</script>
