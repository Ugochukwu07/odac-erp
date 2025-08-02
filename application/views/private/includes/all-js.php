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



<?php

    //check if page link is private/makebooking/reservationForm
    /**
     * Check if the current page link is 'private/makebooking/reservationForm'
     * and execute custom logic if true.
     *
     * This uses CodeIgniter's URI class to determine the current controller and method.
     * Adjust the logic below as needed for your use case.
     */
    $CI = &get_instance();
    $controller = $CI->uri->segment(2); // 'makebooking'
    $method = $CI->uri->segment(3);     // 'reservationForm'
    var_dump($controller, $method);

    if ($controller === 'makebooking' && $method === 'reservationForm') {
?>
    <script type="text/javascript">

        //get reservation form data from local storage
        var reservationForm = localStorage.getItem('reservation_form');
        console.log(reservationForm);
        if (reservationForm) {
            var obj = JSON.parse(reservationForm);
            console.log(obj);
        }

        function applycoupon(id, cpn, dis) {
            $("#discoutcontshow").show();
            $("#defaultload").show();
            $("#discountAmount").html(parseInt(dis).toFixed(2));
            
            // Get total fare from a data attribute or default to 0
            var totalfare = parseFloat($('#booking-form').data('total-fare') || 0);
            var aftdis = (totalfare - dis).toFixed(2);
            $("#discountHtmlValue").html(aftdis);
            
            // Get online charge from data attribute or default to 1
            var online = parseFloat($('#booking-form').data('online-charge') || 1);
            var ofull = parseInt(aftdis * online / 100);
            $('#onlineChrge').html(ofull.toFixed(2));
            var fnl = parseInt(aftdis) + (+ofull);
            $('#paynow').html(fnl.toFixed(2));
            $('#cpnid').val(id);
            setTimeout(() => {
                applyPaymode();
            }, 500);
        }

        $(function() {
            $("#showDivC").click(function() {
                $('#showcontentt').show();
            });
        });

        function checkFormData() {
            var x = $('#firstname').val();
            var y = $('#lastname').val();
            var z = $('#emailid').val();
            var ax = $('#mobileno1').val();
            var ay = $('#mobileno2').val();
            var az = $('#passnger').val();
            if (x == "") {
                $('#msgHTML').html('First Name is Blank!');
                $('#msgerror').modal('show');
                return false;
            }
            // if ( y == "") { $('#msgHTML').html('Last Name is Blank!'); $('#msgerror').modal('show'); return false; }
            if (z == "") {
                $('#msgHTML').html('Email Id is Blank!');
                $('#msgerror').modal('show');
                return false;
            }
            if (ax == "") {
                $('#msgHTML').html('Mobile Number is Blank!');
                $('#msgerror').modal('show');
                return false;
            }
            if (az == "") {
                $('#msgHTML').html('No. Of Passengers Are Blank!');
                $('#msgerror').modal('show');
                return false;
            }
            return true;
        }

        function grabbook() {
            var STOCK = $('#booking-form').data('stock') || '';
            var fname = $('#firstname').val() + ' ' + $('#lastname').val();
            var email = $('#emailid').val();
            var mobileno = $('#mobileno1').val();
            var passnger = $('#passnger').val();
            var country = $('#country').val();
            var pick = $('#pickaddress').val();
            var drop = $('#dropaddress').val();
            var cpnid = $('#cpnid').val();
            var paymode = $('#payment_mode option:selected').val();
            var is_deposit = $('#security_amount:checked').val();
            var bookingamount = parseInt($('#payableAmount').text() || 0);

            $('#submitBtn').prop('disabled', true);

            var body = {
                        'stock': STOCK,
                        'fn': fname,
                        'email': email,
                        'mob': mobileno,
                        'ps': passnger,
                        'cn': country,
                        'pick': pick,
                        'drop': drop,
                        'cpnid': cpnid,
                        'is_deposit': is_deposit,
                        'paymode': paymode,
                        'bookingamount': bookingamount
                    };
                

            if (checkFormData()) {
                $.ajax({
                    type: 'POST',
                    url: $('#booking-form').data('book-url') || '/reservation_form/book',
                    data: body,
                    beforeSend: function() {
                        $('#proceed').html('Please Wait..');
                        $("#proceed").attr('disabled', true);
                    },
                    success: function(res) {
                        var obj = JSON.parse(res);
                        console.log(obj.url);
                        //add obj.res to local storage
                        localStorage.setItem('reservation_form', JSON.stringify(obj.res));
                        if (obj.url !== '' && !obj.is_gateway) {
                            window.location.href = obj.url;
                        } else {
                            const dataR = obj.data;
                            var keyId = obj.key_id;
                            LoadRazorpay(keyId, dataR.gateway_amount, dataR.payid, dataR.name, dataR.email, dataR.mobile, dataR.orderid, obj.verify_url);
                        }
                    }
                });
            }
        }


        function applyPaymode() {
            var paymode = $('#payment_mode option:selected').val();
            var is_deposit = $('#security_amount:checked').val();
            
            // Get values from data attributes or use defaults
            var securityAmount = parseFloat($('#booking-form').data('security-amount') || 0);
            var advPercent = parseFloat($('#booking-form').data('advance-percent') || 100);
            var fullAmount = parseFloat($('#booking-form').data('full-amount') || 0);
            
            var discountAmount = parseInt($('#discountAmount').text() || 0);
            var afterDiscountPrice = parseFloat(fullAmount) - parseFloat(discountAmount);
            var payableAmount = parseInt(afterDiscountPrice * advPercent / 100);

            var finalPayAmount = afterDiscountPrice;
            if (paymode === 'online') {
                finalPayAmount = payableAmount;
            }

            var amountToShow = parseFloat((is_deposit === 'yes') ? (parseFloat(finalPayAmount) + parseFloat(securityAmount)) : finalPayAmount);

            if (is_deposit === 'yes') {
                $('.secuAmt').show();
            } else {
                $('.secuAmt').hide();
            }

            $('#payableAmount').html(amountToShow.toFixed(2));
            $('#payableAmountDisplay').html(amountToShow.toFixed(2));
        }
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        function verifyId(orderid, payid, verifyUrl, amount) {

            $.ajax({
                type: 'POST',
                url: verifyUrl,
                data: {
                    'order_id': orderid,
                    'payid': payid,
                    'amount': amount
                },
                beforeSend: () => {
                    $('#proceed').html('Proccessing...');
                },
                success: function(res) {
                    console.log(res);
                    var obj = JSON.parse(res);
                    if (obj.url !== '') {
                        window.location.href = obj.url;
                    } else {
                        alert(obj.message);
                    }
                }
            });
        }


        function LoadRazorpay(keyId, amount, payid, fullName, emailId, phoneNo, orderId, verifyUrl) {

            var options = {
                "key": keyId,
                "amount": amount * 100,
                "currency": "INR",
                "name": $('#booking-form').data('company-name') || 'Car Rental',
                "description": "Cab Booking Amount for order ID: " + orderId,
                "image": $('#booking-form').data('company-logo') || '',
                "order_id": "",
                "handler": function(response) {
                    verifyId(orderId, response.razorpay_payment_id, verifyUrl, amount);
                    console.log(response);
                },
                "prefill": {
                    "name": fullName,
                    "email": emailId,
                    "contact": phoneNo
                },
                "notes": {
                    "address": $('#booking-form').data('company-address') || ''
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            rzp1.on('payment.failed', function(response) {
                alert(response.error.code);
                // alert(response.error.description);
                // alert(response.error.source);
                // alert(response.error.step);
                // alert(response.error.reason);
                // alert(response.error.metadata.order_id);
                // alert(response.error.metadata.payment_id);
            });


        }
    </script>
<?php
}

?>
