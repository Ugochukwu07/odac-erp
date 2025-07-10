<!-- jQuery 3 (Keep for legacy plugins) -->
<script src="<?php echo base_url('assets'); ?>/admin/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap 5.3.2 Bundle (includes Popper.js) -->
<script src="<?php echo base_url('assets'); ?>/admin/modern/bootstrap-5.3.2.min.js"></script>

<!-- Modern Admin Scripts -->
<script src="<?php echo base_url('assets'); ?>/admin/modern/modern-admin-scripts.js"></script>

<!-- Legacy jQuery Plugins - Keep for backward compatibility -->
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets'); ?>/admin/jquery-ui/jquery-ui.min.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url('assets'); ?>/admin/select2/dist/js/select2.full.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>$.widget.bridge('uibutton', $.ui.button); </script>

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

<!-- Legacy AdminLTE App (Keep for existing functionality) -->
<script src="<?php echo base_url('assets'); ?>/admin/dist/js/adminlte.min.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url('assets'); ?>/admin/dist/js/pages/dashboard.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets'); ?>/admin/custom-js.js"></script>

<!-- Google Maps API -->
<?php if( !isset($place)){ ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GGOGLEPLACEKEY;?>&libraries=places&callback=initAutocomplete" defer="defer" async></script>
<?php } ?>

<!-- Enhanced jQuery functionality for existing code -->
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

		// Enhanced form validation
		$('form').on('submit', function() {
			var isValid = true;
			$(this).find('input[required], select[required], textarea[required]').each(function() {
				if (!$(this).val()) {
					$(this).addClass('is-invalid');
					isValid = false;
				} else {
					$(this).removeClass('is-invalid').addClass('is-valid');
				}
			});
			return isValid;
		});

		// Enhanced table functionality
		$('.table-sortable th').click(function() {
			var table = $(this).parents('table').eq(0);
			var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
			this.asc = !this.asc;
			if (!this.asc) {
				rows = rows.reverse();
			}
			for (var i = 0; i < rows.length; i++) {
				table.append(rows[i]);
			}
		});

		function comparer(index) {
			return function(a, b) {
				var valA = getCellValue(a, index), valB = getCellValue(b, index);
				return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
			};
		}

		function getCellValue(row, index) {
			return $(row).children('td').eq(index).text();
		}

		// Enhanced search functionality
		$('.table-search').on('keyup', function() {
			var value = $(this).val().toLowerCase();
			$('.table-searchable tbody tr').filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
			});
		});

		// Enhanced modal functionality
		$('.modal-trigger').click(function(e) {
			e.preventDefault();
			var target = $(this).data('target');
			$(target).modal('show');
		});

		// Enhanced dropdown functionality
		$('.dropdown-toggle').dropdown();

		// Enhanced tooltip functionality
		$('[data-toggle="tooltip"]').tooltip();

		// Enhanced popover functionality
		$('[data-toggle="popover"]').popover();

		// Auto-hide alerts
		$('.alert-dismissible').delay(5000).fadeOut();

		// Enhanced file upload
		$('input[type="file"]').change(function() {
			var fileName = $(this).val().split('\\').pop();
			$(this).next('.custom-file-label').html(fileName);
		});

		// Enhanced date picker
		$('.datepicker').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy',
			todayHighlight: true,
			orientation: 'bottom auto'
		});

		// Enhanced select2
		$('.select2').select2({
			minimumResultsForSearch: Infinity,
			width: '100%'
		});

		$('.select2-searchable').select2({
			width: '100%',
			placeholder: 'Select an option...'
		});

		// Enhanced data tables
		if ($.fn.DataTable) {
			$('.datatable').DataTable({
				responsive: true,
				language: {
					search: "Search:",
					lengthMenu: "Show _MENU_ entries",
					info: "Showing _START_ to _END_ of _TOTAL_ entries",
					infoEmpty: "Showing 0 to 0 of 0 entries",
					infoFiltered: "(filtered from _MAX_ total entries)",
					paginate: {
						first: "First",
						last: "Last",
						next: "Next",
						previous: "Previous"
					}
				},
				pageLength: 25,
				order: [[0, 'desc']]
			});
		}

		// Enhanced charts
		if (typeof Morris !== 'undefined') {
			// Initialize charts if they exist
			$('.morris-chart').each(function() {
				var chartType = $(this).data('chart-type');
				var chartData = $(this).data('chart-data');
				var chartOptions = $(this).data('chart-options') || {};
				
				if (chartType && chartData) {
					chartOptions.element = this;
					chartOptions.data = chartData;
					new Morris[chartType](chartOptions);
				}
			});
		}

		// Performance monitoring
		$(window).on('load', function() {
			if ('performance' in window) {
				var perfData = performance.getEntriesByType('navigation')[0];
				var loadTime = perfData.loadEventEnd - perfData.loadEventStart;
				console.log('Admin page load time:', loadTime + 'ms');
			}
		});

		// Enhanced mobile menu
		$('.sidebar-toggle').click(function(e) {
			e.preventDefault();
			$('.main-sidebar').toggleClass('show');
			$('body').toggleClass('sidebar-open');
		});

		// Close sidebar when clicking outside on mobile
		$(document).click(function(e) {
			if ($(window).width() <= 991) {
				if (!$(e.target).closest('.main-sidebar, .sidebar-toggle').length) {
					$('.main-sidebar').removeClass('show');
					$('body').removeClass('sidebar-open');
				}
			}
		});

		// Enhanced responsive behavior
		$(window).resize(function() {
			if ($(window).width() > 991) {
				$('.main-sidebar').removeClass('show');
				$('body').removeClass('sidebar-open');
			}
		});
		
		}); 
</script>