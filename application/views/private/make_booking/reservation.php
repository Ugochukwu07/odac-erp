<?php

use Razorpay\Api\Api;

defined('BASEPATH') or exit('No direct script access allowed');  ?>
<style>
    <?php
    //invlude reservation.css
    require_once(APPPATH . '../assets/cli/css/modern/reservation.css');
    ?>
</style>

<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-10 mx-auto my-auto">
            <div class="box box-primary">
                <div class="header box-header">
                    <h1 class="search-header">Search Result <?php echo count($list); ?> Cars Found</h1>
                    <div class="header-underline"></div> <br /> <br />
                    <h4>Book a Cab from <?= $sourcecityname . ' to ' . getexplode($destination, 0); ?> <br /> [Booking Date <?= date('jS F, Y h:i A', strtotime($pickdatetime)); ?> to <?= date('jS F, Y h:i A', strtotime($dropdatetime)); ?> total <?= $days; ?> days ] </h4>
                </div>

                <div class="car-grid box-body">
                    <?php if (!empty($list)) { ?>
                        <?php
                        if ($tab == 'outstation') {
                            $viewmap = "<span class='vhcat'><a href='javascript:void(0);' class='nostyle' onclick='Viewmap()'><i class='fa fa-street-view' style='line-height:20px'></i> View Map</a></span>";
                        }

                        foreach ($list as $key => $value):
                            if ($tab == 'outstation') {
                                $mainheadTag = $value['route'];
                            } else {
                                $mainheadTag = $value['source'] . '->' . getexplode($value['destination'], 0);
                            }

                            $viewFareDot = "";
                            if ($tab == 'outstation') {
                                $viewFareDot = "<span class='vhcat'>Approx (Return) Kms: " . $value['googlekm'] . " </span> <span class='vhcat'>Estimated Time: " . $value['esttime'] . " </span>";
                            }

                            $fareid = $value['id'];
                            $frc = $value['withgstamount'];
                            $adrc = ($value['withgstamount']);
                            $security_amount = $value['secu_amount'];

                            $avail = '<div class="availability-status status-sold-out">Sold Out</div>';
                            $booknow = '<button class="btn btn-primary btn-disabled">Sold Out</button>';
                            $fareButton = '<button class="btn btn-secondary btn-disabled">FARE BREAKUP</button>';
                            $cardClass = 'car-card sold-out';

                            if ($value['available_cars']) {
                                $avail = '<div class="availability-status status-available">Available ' . $value['categoryname'] . 's: ' . $value['available_cars'] . '</div>';
                                $booknow = '<button class="btn btn-primary" onclick="bookinglink(' . $value['stock'] . ');">BOOK NOW</button>';
                                $fareButton = '<button class="btn btn-secondary" onclick="showfare(' . $value['stock'] . ');">FARE BREAKUP</button>';
                                $cardClass = 'car-card';
                            }

                            $refundableText = $security_amount > 0 ? '<div class="security-deposit">Security Deposit Amt.: ₹ ' . round($security_amount) . '</div>' : '';
                        ?>

                            <div class="<?= $cardClass ?>" id="product-<?= $value['id'] ?>">
                                <div class="car-image">
                                    <?php if (file_exists($value['imageurl'])) { ?>
                                        <img src="<?= $value['imageurl'] ?>" class="wp-post-image" alt="<?= $value['model'] ?>">
                                    <?php } else { ?>
                                        🚗
                                        <!-- <img src="<?= base_url('assets/images/'); ?>carfoundnot.png" class="img-responsive" width="80" height="80" /> -->
                                    <?php } ?>
                                </div>
                                <div class="car-details">
                                    <h3 class="car-name"><?= $value['model'] ?></h3>
                                    <?= $avail ?>
                                    <div class="car-specs">
                                        <span class="spec-item">
                                            <span class="spec-icon">💺</span>
                                            <?= $value['segment'] ?> Seats
                                        </span>
                                        <span class="spec-item">
                                            <span class="spec-icon">📅</span>
                                            <?= $value['yearmodel'] ?>
                                        </span>
                                        <span class="spec-item">
                                            <span class="spec-icon">⛽</span>
                                            <?= $value['fueltype'] ?>
                                        </span>
                                        <span class="spec-item">
                                            <span class="spec-icon">❄️</span>
                                            <?= $value['acstatus'] ?>
                                        </span>
                                    </div>
                                    <?= $refundableText ?>
                                </div>
                                <div class="car-actions">
                                    <div class="price-section">
                                        <div class="price">₹ <?= round($frc) ?>.00</div>
                                        <div class="gst-note">Inclusive of GST</div>
                                    </div>
                                    <div class="button-group">
                                        <?= $fareButton ?>
                                        <?= $booknow ?>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php } else { ?>
                        <div class="stm_notices">
                            <div class="row">
                                <div class="col-md-12 col-xs-12 col-lg-12">
                                    <img src="<?= base_url('assets/images/'); ?>carfoundnot.png" class="img-responsive" />
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Test button for debugging -->
<div class="text-center mt-3">
    <button type="button" class="btn btn-info" onclick="testModal()">Test Modal</button>
</div>

<!-- Modal moved outside main content to avoid z-index conflicts -->
<div class="modal fade" id="fareshow" tabindex="-1" aria-labelledby="fareModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fareModalLabel">Fare Breakdown</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="fareSummary">
                    <!-- Fare details will be loaded here -->
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <p class='ext_txt'><br /><b class="bold">Extra Charges (if applicable)</b></p>
                    </div>
                </div>
                <?php echo '<div class="lists-inline tnc"> ' . $termslist . ' </div>'; ?>
            </div>
        </div>
    </div>
</div>
<!-- /. Fare modal-content end -->

<script type="text/javascript">
    // Wait for jQuery to be available
    function waitForJQuery(callback) {
        if (typeof jQuery !== 'undefined') {
            callback();
        } else {
            setTimeout(function() {
                waitForJQuery(callback);
            }, 100);
        }
    }

    waitForJQuery(function() {
        // Now jQuery is available
        console.log('jQuery is loaded, version:', $.fn.jquery);
        
        function bookinglink(goparam) {
            window.location.href = '<?php echo PEADEX; ?>login/dologin?utm=' + btoa(goparam);
        }

        function showfare(req) {
            console.log('showfare called with:', req);
            
            // Show loading state first
            $("#fareSummary").html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading fare details...</div>');
            
            // Bootstrap 5 modal initialization
            const modalElement = document.getElementById('fareshow');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            
            $.ajax({
                type: 'POST',
                url: '<?php echo PEADEX; ?>Fb/index',
                data: {
                    'vall': req
                },
                dataType: 'html',
                timeout: 10000,
                success: function(res) {
                    console.log('AJAX success, response length:', res.length);
                    if (res && res.trim() !== '') {
                        $("#fareSummary").html(res);
                    } else {
                        $("#fareSummary").html('<div class="alert alert-warning">No fare details available for this vehicle.</div>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.error('Response:', xhr.responseText);
                    $("#fareSummary").html('<div class="alert alert-danger">Error loading fare details. Please try again later.</div>');
                }
            });
        }

        function testModal() {
            console.log('Test modal function called');
            console.log('Modal element exists:', $('#fareshow').length);
            
            $("#fareSummary").html('<div class="alert alert-info">This is a test modal content</div>');
            
            // Bootstrap 5 modal initialization
            const modalElement = document.getElementById('fareshow');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }

        // Debug modal events - Bootstrap 5 syntax
        $(document).ready(function() {
            console.log('Document ready, setting up modal events');
            
            const modalElement = document.getElementById('fareshow');
            
            modalElement.addEventListener('show.bs.modal', function () {
                console.log('Modal show event triggered');
            });
            
            modalElement.addEventListener('shown.bs.modal', function () {
                console.log('Modal shown event triggered');
                // Force z-index after modal is shown
                $(this).css('z-index', '9999');
                $('.modal-backdrop').css('z-index', '9998');
            });
            
            modalElement.addEventListener('hide.bs.modal', function () {
                console.log('Modal hide event triggered');
            });
            
            // Test if modal can be shown manually
            modalElement.addEventListener('click', function() {
                console.log('Modal clicked');
            });
        });

        // Make functions globally available
        window.bookinglink = bookinglink;
        window.showfare = showfare;
        window.testModal = testModal;
    });

    <?php $termslist = '';
    if (!empty($terms)) {
        $termslist .= '<ol>';
        foreach ($terms as $key => $valueli) {
            $termslist .= '<li>' . $valueli['content'] . '</li>';
        }
        $termslist .= '</ol>';
    }
    ?>
</script>
<style type="text/css">
    @media(min-width:780px) {
        .modal-dialog {
            width: 490px;
        }

        ol.tnc {
            margin: 0px !important;
        }
    }

    @media(max-width:767px) {
        .modal-dialog {
            width: 98%;
        }

        ol.tnc {
            margin: 0px !important;
        }

        ol.tnc li,
        #fareSummary>div.row>div {
            font-size: 10px !important;
        }
    }

    .sold-out {
        background: #c5c5c5;
        pointer-events: none;
        opacity: 0.4;
    }

    /* Fix modal z-index issues */
    .modal {
        z-index: 9999 !important;
        position: fixed !important;
    }
    
    .modal-backdrop {
        z-index: 9998 !important;
    }
    
    .modal-dialog {
        z-index: 10000 !important;
        position: relative !important;
    }
    
    /* Ensure modal content is above backdrop */
    .modal-content {
        position: relative !important;
        z-index: 10001 !important;
    }
    
    /* Override any conflicting z-index from admin theme */
    .content-wrapper .modal {
        z-index: 9999 !important;
    }
    
    .sidebar-overlay {
        z-index: 1010 !important;
    }
    
    /* Force modal to be on top of everything */
    #fareshow {
        z-index: 9999 !important;
    }
    
    #fareshow .modal-dialog {
        z-index: 10000 !important;
    }
    
    #fareshow .modal-content {
        z-index: 10001 !important;
    }
    
    /* Ensure body doesn't interfere */
    body.modal-open {
        overflow: hidden !important;
    }
    
    /* Override any admin theme modal styles */
    .skin-blue .modal {
        z-index: 9999 !important;
    }
</style>