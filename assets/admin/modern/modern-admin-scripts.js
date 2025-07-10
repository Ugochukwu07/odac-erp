/**
 * Modern Admin Scripts for Odeac
 * Bootstrap 5.3.2 compatible with vanilla JavaScript
 * Replaces jQuery dependencies with modern ES6+ code
 */

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    initializeAdminComponents();
    initializeFormValidation();
    initializeDataTables();
    initializeDatePickers();
    initializeSelect2();
    initializeCharts();
    initializeNotifications();
    initializeSearch();
    initializeMobileMenu();
    initializePerformanceMonitoring();
});

/**
 * Initialize all admin components
 */
function initializeAdminComponents() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Initialize modals
    const modalTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="modal"]'));
    modalTriggerList.forEach(function (modalTriggerEl) {
        modalTriggerEl.addEventListener('click', function(e) {
            e.preventDefault();
            const targetModal = document.querySelector(this.getAttribute('data-bs-target'));
            if (targetModal) {
                const modal = new bootstrap.Modal(targetModal);
                modal.show();
            }
        });
    });

    // Initialize dropdowns
    const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });

    // Initialize collapse
    const collapseElementList = [].slice.call(document.querySelectorAll('.collapse'));
    collapseElementList.map(function (collapseEl) {
        return new bootstrap.Collapse(collapseEl, {
            toggle: false
        });
    });
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Real-time validation
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('was-validated')) {
                validateField(this);
            }
        });
    });
}

/**
 * Validate individual form field
 */
function validateField(field) {
    const isValid = field.checkValidity();
    const feedback = field.parentNode.querySelector('.invalid-feedback');
    
    if (isValid) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        if (feedback) feedback.style.display = 'none';
    } else {
        field.classList.remove('is-valid');
        field.classList.add('is-invalid');
        if (feedback) feedback.style.display = 'block';
    }
}

/**
 * Initialize DataTables (if available)
 */
function initializeDataTables() {
    if (typeof $.fn.DataTable !== 'undefined') {
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
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            pageLength: 25,
            order: [[0, 'desc']]
        });
    }
}

/**
 * Initialize Date Pickers
 */
function initializeDatePickers() {
    // Date picker initialization
    const datePickers = document.querySelectorAll('.datepicker');
    datePickers.forEach(picker => {
        if (typeof $.fn.datepicker !== 'undefined') {
            $(picker).datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                orientation: 'bottom auto'
            });
        }
    });

    // Date range picker
    const dateRangePickers = document.querySelectorAll('.daterangepicker');
    dateRangePickers.forEach(picker => {
        if (typeof $.fn.daterangepicker !== 'undefined') {
            $(picker).daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        }
    });
}

/**
 * Initialize Select2
 */
function initializeSelect2() {
    if (typeof $.fn.select2 !== 'undefined') {
        // Basic select2
        $('.select2').select2({
            minimumResultsForSearch: Infinity,
            width: '100%'
        });

        // Searchable select2
        $('.select2-searchable').select2({
            width: '100%',
            placeholder: 'Select an option...'
        });

        // Multiple select2
        $('.select2-multiple').select2({
            width: '100%',
            placeholder: 'Select options...',
            allowClear: true
        });
    }
}

/**
 * Initialize Charts
 */
function initializeCharts() {
    // Morris.js charts
    if (typeof Morris !== 'undefined') {
        // Line chart
        const lineChart = document.getElementById('line-chart');
        if (lineChart) {
            new Morris.Line({
                element: 'line-chart',
                resize: true,
                data: [
                    {y: '2011 Q1', item1: 2666},
                    {y: '2011 Q2', item1: 2778},
                    {y: '2011 Q3', item1: 4912},
                    {y: '2011 Q4', item1: 3767},
                    {y: '2012 Q1', item1: 6810},
                    {y: '2012 Q2', item1: 5670},
                    {y: '2012 Q3', item1: 4820},
                    {y: '2012 Q4', item1: 15073},
                    {y: '2013 Q1', item1: 10687},
                    {y: '2013 Q2', item1: 8432}
                ],
                xkey: 'y',
                ykeys: ['item1'],
                labels: ['Item 1'],
                lineColors: ['#0e5074'],
                hideHover: 'auto'
            });
        }

        // Area chart
        const areaChart = document.getElementById('area-chart');
        if (areaChart) {
            new Morris.Area({
                element: 'area-chart',
                resize: true,
                data: [
                    {y: '2011 Q1', item1: 2666, item2: 2666},
                    {y: '2011 Q2', item1: 2778, item2: 2294},
                    {y: '2011 Q3', item1: 4912, item2: 1969},
                    {y: '2011 Q4', item1: 3767, item2: 3597},
                    {y: '2012 Q1', item1: 6810, item2: 1914},
                    {y: '2012 Q2', item1: 5670, item2: 4293},
                    {y: '2012 Q3', item1: 4820, item2: 3795},
                    {y: '2012 Q4', item1: 15073, item2: 5967},
                    {y: '2013 Q1', item1: 10687, item2: 4460},
                    {y: '2013 Q2', item1: 8432, item2: 5713}
                ],
                xkey: 'y',
                ykeys: ['item1', 'item2'],
                labels: ['Item 1', 'Item 2'],
                lineColors: ['#0e5074', '#F9570B'],
                hideHover: 'auto'
            });
        }

        // Donut chart
        const donutChart = document.getElementById('donut-chart');
        if (donutChart) {
            new Morris.Donut({
                element: 'donut-chart',
                resize: true,
                colors: ['#0e5074', '#F9570B', '#28a745', '#17a2b8', '#ffc107'],
                data: [
                    {label: 'Download Sales', value: 12},
                    {label: 'In-Store Sales', value: 30},
                    {label: 'Mail-Order Sales', value: 20}
                ],
                hideHover: 'auto'
            });
        }
    }

    // Sparkline charts
    if (typeof $.fn.sparkline !== 'undefined') {
        $('.sparkline').each(function() {
            const $this = $(this);
            $this.sparkline('html', $this.data());
        });
    }
}

/**
 * Initialize Notifications
 */
function initializeNotifications() {
    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Toast notifications
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
    toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl);
    });
}

/**
 * Initialize Search Functionality
 */
function initializeSearch() {
    const searchInputs = document.querySelectorAll('.search-input');
    
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const targetClass = this.getAttribute('data-target');
            const targetElements = document.querySelectorAll('.' + targetClass);
            
            targetElements.forEach(element => {
                const text = element.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    element.style.display = '';
                } else {
                    element.style.display = 'none';
                }
            });
        });
    });
}

/**
 * Initialize Mobile Menu
 */
function initializeMobileMenu() {
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.main-sidebar');
    const overlay = document.createElement('div');
    
    overlay.className = 'sidebar-overlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1010;
        display: none;
    `;
    
    document.body.appendChild(overlay);
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('show');
            overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        });
        
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.style.display = 'none';
        });
    }
    
    // Close sidebar on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991) {
            sidebar.classList.remove('show');
            overlay.style.display = 'none';
        }
    });
}

/**
 * Initialize Performance Monitoring
 */
function initializePerformanceMonitoring() {
    // Monitor page load performance
    window.addEventListener('load', function() {
        if ('performance' in window) {
            const perfData = performance.getEntriesByType('navigation')[0];
            const loadTime = perfData.loadEventEnd - perfData.loadEventStart;
            
            // Log performance data (can be sent to analytics)
            console.log('Page load time:', loadTime + 'ms');
        }
    });

    // Monitor AJAX performance
    if (typeof $ !== 'undefined') {
        $(document).ajaxStart(function() {
            document.body.classList.add('loading');
        });
        
        $(document).ajaxStop(function() {
            document.body.classList.remove('loading');
        });
    }
}

/**
 * Utility Functions
 */

// Input masking
function initializeInputMasks() {
    if (typeof $.fn.inputmask !== 'undefined') {
        // Date masks
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
        
        // Money masks
        $('[data-mask]').inputmask();
        
        // Phone masks
        $('.phone-mask').inputmask('(999) 999-9999');
        
        // Currency masks
        $('.currency-mask').inputmask('currency', {
            prefix: '$',
            groupSeparator: ',',
            radixPoint: '.',
            autoGroup: true,
            digits: 2,
            digitsOptional: false,
            placeholder: '0'
        });
    }
}

// Input validation patterns
function initializeInputValidation() {
    const inputs = document.querySelectorAll('input[data-pattern]');
    
    inputs.forEach(input => {
        const pattern = input.getAttribute('data-pattern');
        const regex = new RegExp(pattern);
        
        input.addEventListener('input', function() {
            const value = this.value;
            if (value && !regex.test(value)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
}

// File upload preview
function initializeFileUpload() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const preview = this.parentNode.querySelector('.file-preview');
            
            if (file && preview) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = `<div class="alert alert-info">Selected file: ${file.name}</div>`;
                }
            }
        });
    });
}

// Export functionality
function exportTable(tableId, format = 'csv') {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    let data = [];
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const rowData = [];
        const cells = row.querySelectorAll('td, th');
        cells.forEach(cell => {
            rowData.push(cell.textContent.trim());
        });
        data.push(rowData.join(','));
    });
    
    const csvContent = data.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `${tableId}_export.csv`;
    a.click();
    window.URL.revokeObjectURL(url);
}

// Print functionality
function printElement(elementId) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Print</title>
                <link rel="stylesheet" href="${window.location.origin}/assets/admin/modern/modern-admin-theme.css">
                <style>
                    body { margin: 0; padding: 20px; }
                    .no-print { display: none !important; }
                </style>
            </head>
            <body>
                ${element.outerHTML}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// Initialize all utility functions
document.addEventListener('DOMContentLoaded', function() {
    initializeInputMasks();
    initializeInputValidation();
    initializeFileUpload();
});

// Global utility functions
window.AdminUtils = {
    exportTable,
    printElement,
    showNotification: function(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        const container = document.querySelector('.toast-container') || document.body;
        container.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', function() {
            container.removeChild(toast);
        });
    }
}; 