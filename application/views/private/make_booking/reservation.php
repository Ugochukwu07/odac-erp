<?php

use Razorpay\Api\Api;

 defined('BASEPATH') or exit('No direct script access allowed');  ?>
<style>
<?php
//invlude reservation.css
require_once(APPPATH . '../assets/cli/css/modern/reservation.css');
?>
</style>
<?php echo "<pre>";
// var_dump($list);
echo "</pre>";
?>
<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-7 mx-auto my-auto">
    <div class="box box-primary">
        <div class="header box-header">
            <h1 class="search-header">Search Result <?php echo count($list); ?> Cars Found</h1>
            <div class="header-underline"></div>
            <p>Book a Cab from <?= $sourcecityname . ' to ' . getexplode($destination, 0); ?> [Booking Date <?= date('jS F, Y h:i A', strtotime($pickdatetime)); ?> to <?= date('jS F, Y h:i A', strtotime($dropdatetime)); ?> total <?= $days; ?> days ] </p>
        </div>

        <div class="car-grid box-body">
            <!-- Alto k10 - Sold Out -->
            <div class="car-card sold-out">
                <div class="car-image">🚗</div>
                <div class="car-details">
                    <h3 class="car-name">Alto k10</h3>
                    <div class="availability-status status-sold-out">Sold Out</div>
                    <div class="car-specs">
                        <span class="spec-item">
                            <span class="spec-icon">💺</span>
                            5 Seats
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">📅</span>
                            2019
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">⛽</span>
                            Petrol
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">❄️</span>
                            AC
                        </span>
                    </div>
                    <div class="security-deposit">Security Deposit Amt.: ₹ 5000</div>
                </div>
                <div class="car-actions">
                    <div class="price-section">
                        <div class="price">₹ 1200.00</div>
                        <div class="gst-note">Inclusive of GST</div>
                    </div>
                    <div class="button-group">
                        <button class="btn btn-secondary btn-disabled">FARE BREAKUP</button>
                        <button class="btn btn-primary btn-disabled">SOLD OUT</button>
                    </div>
                </div>
            </div>

            <!-- i10 Grand neos -->
            <div class="car-card">
                <div class="car-image">🚗</div>
                <div class="car-details">
                    <h3 class="car-name">i10 Grand neos</h3>
                    <div class="availability-status status-available">Available Cabs: 1</div>
                    <div class="car-specs">
                        <span class="spec-item">
                            <span class="spec-icon">💺</span>
                            5 Seats
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">📅</span>
                            2022
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">⛽</span>
                            Petrol
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">❄️</span>
                            AC
                        </span>
                    </div>
                    <div class="security-deposit">Security Deposit Amt.: ₹ 5000</div>
                </div>
                <div class="car-actions">
                    <div class="price-section">
                        <div class="price">₹ 1500.00</div>
                        <div class="gst-note">Inclusive of GST</div>
                    </div>
                    <div class="button-group">
                        <button class="btn btn-secondary">FARE BREAKUP</button>
                        <button class="btn btn-primary">BOOK NOW</button>
                    </div>
                </div>
            </div>

            <!-- I 20 -->
            <div class="car-card">
                <div class="car-image">🚗</div>
                <div class="car-details">
                    <h3 class="car-name">I 20</h3>
                    <div class="availability-status status-available">Available Cabs: 2</div>
                    <div class="car-specs">
                        <span class="spec-item">
                            <span class="spec-icon">💺</span>
                            5 Seats
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">📅</span>
                            2019
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">⛽</span>
                            Petrol
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">❄️</span>
                            AC
                        </span>
                    </div>
                    <div class="security-deposit">Security Deposit Amt.: ₹ 5000</div>
                </div>
                <div class="car-actions">
                    <div class="price-section">
                        <div class="price">₹ 1800.00</div>
                        <div class="gst-note">Inclusive of GST</div>
                    </div>
                    <div class="button-group">
                        <button class="btn btn-secondary">FARE BREAKUP</button>
                        <button class="btn btn-primary">BOOK NOW</button>
                    </div>
                </div>
            </div>

            <!-- Swift -->
            <div class="car-card">
                <div class="car-image">🚗</div>
                <div class="car-details">
                    <h3 class="car-name">Swift</h3>
                    <div class="availability-status status-available">Available Cabs: 2</div>
                    <div class="car-specs">
                        <span class="spec-item">
                            <span class="spec-icon">💺</span>
                            5 Seats
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">📅</span>
                            2022
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">⛽</span>
                            Petrol
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">❄️</span>
                            AC
                        </span>
                    </div>
                    <div class="security-deposit">Security Deposit Amt.: ₹ 5000</div>
                </div>
                <div class="car-actions">
                    <div class="price-section">
                        <div class="price">₹ 1800.00</div>
                        <div class="gst-note">Inclusive of GST</div>
                    </div>
                    <div class="button-group">
                        <button class="btn btn-secondary">FARE BREAKUP</button>
                        <button class="btn btn-primary">BOOK NOW</button>
                    </div>
                </div>
            </div>

            <!-- Toyota Urban Cruiser AT -->
            <div class="car-card">
                <div class="car-image">🚗</div>
                <div class="car-details">
                    <h3 class="car-name">Toyota Urban Cruiser AT</h3>
                    <div class="availability-status status-available">Available Cabs: 1</div>
                    <div class="car-specs">
                        <span class="spec-item">
                            <span class="spec-icon">💺</span>
                            5 Seats
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">📅</span>
                            2025
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">⛽</span>
                            Petrol
                        </span>
                        <span class="spec-item">
                            <span class="spec-icon">❄️</span>
                            AC
                        </span>
                    </div>
                    <div class="security-deposit">Security Deposit Amt.: ₹ 5000</div>
                </div>
                <div class="car-actions">
                    <div class="price-section">
                        <div class="price">₹ 2000.00</div>
                        <div class="gst-note">Inclusive of GST</div>
                    </div>
                    <div class="button-group">
                        <button class="btn btn-secondary">FARE BREAKUP</button>
                        <button class="btn btn-primary">BOOK NOW</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>