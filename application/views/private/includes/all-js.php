<!-- jQuery 3 -->
<script src="<?php echo base_url('assets'); ?>/admin/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets'); ?>/admin/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/admin/select2/dist/js/select2.full.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>$.widget.bridge('uibutton', $.ui.button); </script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets'); ?>/admin/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url('assets'); ?>/admin/raphael/raphael.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/admin/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets'); ?>/admin/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets'); ?>/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets'); ?>/admin/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('assets'); ?>/admin/moment/min/moment.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/admin/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets'); ?>/admin/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets'); ?>/admin/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('assets'); ?>/admin/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets'); ?>/admin/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets'); ?>/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url('assets'); ?>/admin/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets'); ?>/admin/dist/js/demo.js"></script>
<script src="<?php echo base_url('assets'); ?>/admin/custom-js.js"></script>
<?php if( !isset($place)){ ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GGOGLEPLACEKEY;?>&libraries=places&callback=initAutocomplete" defer="defer" async></script>
<?php } ?>

<script type="text/javascript">
	$(document).ready(function () {   
  
        jQuery('.numbersOnly').keyup(function () { 
		this.value = this.value.replace(/[^0-9\.]/g,'');
		});
		
		jQuery('.lettersOnly').keyup(function () { 
		this.value = this.value.replace(/[^a-zA-Z\s]+$/g,'');
		});
		
		jQuery('.alphanimericOnly').keyup(function () {   
		this.value = this.value.replace(/[^A-Za-z0-9.\/\s]/g,'');
		});
		
		jQuery('.address').keyup(function () {   
		this.value = this.value.replace(/[^A-Za-z0-9//,.\/\s]/g,'');
		
		});

		jQuery('.nospace').keyup(function () {   
		this.value = this.value.replace(/[^A-Za-z0-9]+$/g,'');
		});

		jQuery('.upper').keyup(function () {   
		this.value = this.value.toUpperCase();
		});

		jQuery('.capital').keyup(function () {  
		var str = this.value;
		this.value = str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
		});

		jQuery('.small').keyup(function () {   
		this.value = this.value.toLowerCase();
		});

		
		}); 
</script>