<?php
// echo '<pre>';
// print_r($result); 
$fareid = $result['id'];
$dayshow = $result['days'];
$tab = $result['triptype'];
$tax = $result['gst'];

$calculatedfare = (float)$result['est_fare'];
$servicetax = (float)$result['gstamount'];
$totalfare = (float)$result['withgstamount'];
$onlineCharge = round(onlineCharge($totalfare));
$withonlinecharge = (float)$totalfare + (float)$onlineCharge;
$refundable_amount = (float)$result['secu_amount'];
$advance_amount = advanceFare($withonlinecharge);

$vechimodelname = $result['model'];
$vehicledetails = [];
$carImage = $result['imageurl'];
/*ITENARARY*/
$cityname = $result['source'];
$route = current(explode(',', $result['source'])) . ' <span style="font-family:times new roman"> → </span> ' . current(explode(',', $result['destination']));
?>

    <style>
        :root {
            --primary-50: #f0f9ff;
            --primary-100: #e0f2fe;
            --primary-200: #bae6fd;
            --primary-300: #7dd3fc;
            --primary-400: #38bdf8;
            --primary-500: #0ea5e9;
            --primary-600: #0284c7;
            --primary-700: #0369a1;
            --primary-800: #075985;
            --primary-900: #0c4a6e;
            --secondary-50: #f8fafc;
            --secondary-100: #f1f5f9;
            --secondary-200: #e2e8f0;
            --secondary-300: #cbd5e1;
            --secondary-400: #94a3b8;
            --secondary-500: #64748b;
            --secondary-600: #475569;
            --secondary-700: #334155;
            --secondary-800: #1e293b;
            --secondary-900: #0f172a;
            --neutral-white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --black: #000000;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --info: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
        }

        .booking-layout {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 32px;
            margin-top: 24px;
        }

        .booking-details {
            background: var(--neutral-white);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .booking-details h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--gray-900);
        }

        .booking-summary {
            margin-bottom: 24px;
        }

        .booking-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding: 8px 0;
        }

        .booking-item:not(:last-child) {
            border-bottom: 1px solid var(--gray-100);
        }

        .booking-label {
            font-weight: 500;
            color: var(--gray-600);
        }

        .booking-value {
            font-weight: 600;
            color: var(--gray-900);
        }

        .cost-breakdown {
            background: var(--gray-50);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .cost-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .cost-item:last-child {
            margin-bottom: 0;
            padding-top: 8px;
            border-top: 1px solid var(--gray-200);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .final-amount {
            background: var(--primary-50);
            border: 2px solid var(--primary-200);
            border-radius: 8px;
            padding: 16px;
            text-align: center;
            margin-bottom: 20px;
        }

        .final-amount .amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-700);
        }

        .offer-zone {
            color: var(--primary-600);
            text-decoration: underline;
            cursor: pointer;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .coupon-section {
            background: var(--gray-50);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            display: none;
        }

        .coupon-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: border-color 0.2s ease;
        }

        .coupon-item:hover {
            border-color: var(--primary-400);
        }

        .coupon-item:last-child {
            margin-bottom: 0;
        }

        .coupon-radio {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-600);
        }

        .coupon-content {
            flex: 1;
        }

        .coupon-title {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 4px;
        }

        .coupon-code {
            background: var(--primary-100);
            color: var(--primary-700);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .personal-info {
            background: var(--neutral-white);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .change-vehicle {
            color: var(--primary-600);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 6px;
        }

        .form-input {
            padding: 12px;
            border: 1px solid var(--gray-300);
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px var(--primary-100);
        }

        .form-select {
            padding: 12px;
            border: 1px solid var(--gray-300);
            border-radius: 6px;
            font-size: 1rem;
            background-color: var(--neutral-white);
            cursor: pointer;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .checkbox-input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-600);
        }

        .checkbox-label {
            font-size: 0.875rem;
            color: var(--gray-700);
        }

        .payment-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: var(--gray-50);
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .security-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .security-icon {
            width: 20px;
            height: 20px;
            background: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 12px;
        }

        .security-text {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .payment-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .proceed-button {
            background: var(--primary-600);
            color: var(--neutral-white);
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .proceed-button:hover {
            background: var(--primary-700);
        }

        .proceed-button:disabled {
            background: var(--gray-400);
            cursor: not-allowed;
        }

        .secuAmt {
            display: none;
        }

        @media (max-width: 768px) {
            .booking-layout {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .payment-section {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }

            .payment-controls {
                flex-direction: column;
            }
        }
    </style>
    <div class="container">
        <div class="booking-layout" id="booking-form" 
             data-total-fare="<?= $totalfare ?>"
             data-online-charge="<?= ONLINECHARGE ?>"
             data-security-amount="<?= $refundable_amount ?>"
             data-advance-percent="<?= CABADVNCE ?>"
             data-full-amount="<?= $withonlinecharge ?>"
             data-stock="<?= $result['stock'] ?>"
             data-book-url="<?= PEADEX . 'reservation_form/book' ?>"
             data-company-name="<?= COMPANYNAME ?>"
             data-company-logo="<?= LOGO ?>"
             data-company-address="<?= HEADOFFICE ?>">
            <!-- Left Section: Booking Details -->
            <div class="booking-details">
                <h2>Your Booking Details</h2>

                <div class="booking-summary">
                    <div class="booking-item">
                        <span class="booking-label">Itinerary</span>
                        <span class="booking-value"><?= $route; ?></span>
                    </div>
                    <div class="booking-item">
                        <span class="booking-label">Pickup Date</span>
                        <span class="booking-value"><?php echo $result['pickupdatetime']; ?></span>
                    </div>
                    <div class="booking-item">
                        <span class="booking-label">Return Date</span>
                        <span class="booking-value"><?php echo $result['dropdatetime']; ?></span>
                    </div>
                    <div class="booking-item">
                        <span class="booking-label">Vehicle Model</span>
                        <span class="booking-value"><?php echo $vechimodelname; ?></span>
                    </div>
                </div>

                <div class="cost-breakdown">
                    <div class="cost-item">
                        <span>Rental Cost</span>
                        <span>INR <?php echo twoDecimal($calculatedfare); ?></span>
                    </div>
                    <div class="cost-item">
                        <span>GST Charge</span>
                        <span>INR <?php echo twoDecimal($servicetax); ?></span>
                    </div>
                    <div class="cost-item">
                        <span>Estimated Rental Cost</span>
                        <span>INR <?php echo twoDecimal($totalfare); ?></span>
                    </div>

                    <div id="discoutcontshow" style="display:<?= $offer ? 'block' : 'none'; ?>">
                        <div class="cost-item">
                            <span>Discount Amount</span>
                            <span>INR <em id="discountAmount"><?= twoDecimal($offer); ?></em></span>
                        </div>
                        <div class="cost-item">
                            <span>After Discount Cost</span>
                            <span>INR <em id="discountHtmlValue"><?= twoDecimal(((float)$withonlinecharge - (float)$offer)); ?></em></span>
                        </div>
                    </div>

                    <?php if (!$offer) { ?>
                        <div class="cost-item">
                            <span>Online Charge (<?php echo ONLINECHARGE; ?>%)</span>
                            <span style="color: var(--primary-600); cursor: pointer;">INR <em id="onlineChrge"><?= twoDecimal($onlineCharge); ?></em></span>
                        </div>
                    <?php } ?>

                    <div class="cost-item">
                        <span>Final Amount</span>
                        <span>INR <em id="paynow"><?= $offer ? twoDecimal(((float)$withonlinecharge - (float)$offer)) : twoDecimal($withonlinecharge); ?></em></span>
                    </div>

                    <div class="cost-item secuAmt">
                        <span>Security Deposit Amount</span>
                        <span>INR <em id="securityDepositAmount"><?= twoDecimal($refundable_amount); ?></em></span>
                    </div>

                    <div class="cost-item">
                        <span>Pay Now</span>
                        <span>INR <em id="payableAmount"><?= twoDecimal($advance_amount); ?></em></span>
                    </div>
                </div>

                <div class="final-amount">
                    <div>Pay Now</div>
                    <div class="amount">INR <em id="payableAmountDisplay"><?= twoDecimal($advance_amount); ?></em></div>
                </div>

                <div class="offer-zone" id="showDivC" style="display:<?= $offer ? 'none' : 'block'; ?>">Offer Zone</div>

                <div class="coupon-section" id="showcontentt">
                    <?php if ($cpnlist && !$offer) {
                        foreach ($cpnlist as $key => $value): ?>
                            <div class="coupon-item" onclick="applycoupon('<?= $value['id'] ?>','<?= $value['couponcode'] ?>','<?= $value['maxdiscount']; ?>');">
                                <input type="radio" class="coupon-radio" name="cpn" value="<?= $value['id']; ?>">
                                <div class="coupon-content">
                                    <div class="coupon-title"><?= $value['titlename']; ?> Upto ₹<?= $value['maxdiscount']; ?> Discount</div>
                                    <div class="coupon-code">Promocode: <b><?= $value['couponcode']; ?></b></div>
                                </div>
                            </div>
                    <?php endforeach;
                    } ?>
                </div>
            </div>

            <!-- Right Section: Personal Information -->
            <div class="personal-info">
                <div class="form-header">
                    <h2>Personal Information</h2>
                    <a href="javascript:void(0);" class="change-vehicle" onclick="window.history.go(-1);">← Change Vehicle</a>
                </div>

                <form>
                    <input type="hidden" name="" id="cpnid">

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="customerFirstname" placeholder="First Name" id="firstname" value="<?= $firstname; ?>" class="form-input lettersOnly" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" placeholder="Last Name" name="customerSecondname" id="lastname" class="form-input lettersOnly" value="<?= $lastname; ?>" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="text" placeholder="Email Address" name="customeremail" id="emailid" value="<?= $emailid; ?>" class="form-input" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" placeholder="Mobile Number" name="mobileno1" value="<?= $mobileno; ?>" id="mobileno1" maxlength="10" class="form-input numbersOnly" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Passengers</label>
                            <input type="text" placeholder="Passengers" id="passnger" value="1" name="passnger" class="form-input numbersOnly" />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country Name</label>
                            <select name="country" class="form-select" id="country">
                                <option value="">Country...</option>
                                <option value="Afganistan">Afghanistan</option>
                                <option value="Albania">Albania</option>
                                <option value="Algeria">Algeria</option>
                                <option value="American Samoa">American Samoa</option>
                                <option value="Andorra">Andorra</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="Aruba">Aruba</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Belize">Belize</option>
                                <option value="Benin">Benin</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Bonaire">Bonaire</option>
                                <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Brazil">Brazil</option>
                                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                <option value="Brunei">Brunei</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Canada">Canada</option>
                                <option value="Canary Islands">Canary Islands</option>
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Cayman Islands">Cayman Islands</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Chad">Chad</option>
                                <option value="Channel Islands">Channel Islands</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Christmas Island">Christmas Island</option>
                                <option value="Cocos Island">Cocos Island</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Congo">Congo</option>
                                <option value="Cook Islands">Cook Islands</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Cote DIvoire">Cote D'Ivoire</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Curaco">Curacao</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="East Timor">East Timor</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Falkland Islands">Falkland Islands</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Finland">Finland</option>
                                <option value="France">France</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="French Southern Ter">French Southern Ter</option>
                                <option value="Gabon">Gabon</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Germany">Germany</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Great Britain">Great Britain</option>
                                <option value="Greece">Greece</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Guadeloupe">Guadeloupe</option>
                                <option value="Guam">Guam</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Hawaii">Hawaii</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Iceland">Iceland</option>
                                <option value="India" selected>India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Iran">Iran</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Isle of Man">Isle of Man</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Japan">Japan</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Korea North">Korea North</option>
                                <option value="Korea Sout">Korea South</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Laos">Laos</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libya">Libya</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Macau">Macau</option>
                                <option value="Macedonia">Macedonia</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Mayotte">Mayotte</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Midway Islands">Midway Islands</option>
                                <option value="Moldova">Moldova</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Nambia">Nambia</option>
                                <option value="Nauru">Nauru</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Netherland Antilles">Netherland Antilles</option>
                                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                <option value="Nevis">Nevis</option>
                                <option value="New Caledonia">New Caledonia</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niger">Niger</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Niue">Niue</option>
                                <option value="Norfolk Island">Norfolk Island</option>
                                <option value="Norway">Norway</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Palau Island">Palau Island</option>
                                <option value="Palestine">Palestine</option>
                                <option value="Panama">Panama</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Peru</option>
                                <option value="Phillipines">Philippines</option>
                                <option value="Pitcairn Island">Pitcairn Island</option>
                                <option value="Poland">Poland</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Republic of Montenegro">Republic of Montenegro</option>
                                <option value="Republic of Serbia">Republic of Serbia</option>
                                <option value="Reunion">Reunion</option>
                                <option value="Romania">Romania</option>
                                <option value="Russia">Russia</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="St Barthelemy">St Barthelemy</option>
                                <option value="St Eustatius">St Eustatius</option>
                                <option value="St Helena">St Helena</option>
                                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                <option value="St Lucia">St Lucia</option>
                                <option value="St Maarten">St Maarten</option>
                                <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                                <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                                <option value="Saipan">Saipan</option>
                                <option value="Samoa">Samoa</option>
                                <option value="Samoa American">Samoa American</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Serbia">Serbia</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="Singapore">Singapore</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Somalia">Somalia</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Spain">Spain</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Swaziland">Swaziland</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Syria">Syria</option>
                                <option value="Tahiti">Tahiti</option>
                                <option value="Taiwan">Taiwan</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tanzania">Tanzania</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Togo">Togo</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Erimates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States of America">United States of America</option>
                                <option value="Uraguay">Uruguay</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Vatican City State">Vatican City State</option>
                                <option value="Venezuela">Venezuela</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                <option value="Wake Island">Wake Island</option>
                                <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                                <option value="Yemen">Yemen</option>
                                <option value="Zaire">Zaire</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label">Street address (Pick-up Address)</label>
                            <input type="text" placeholder="Pick-up Address" id="pickaddress" name="location1" class="form-input address" value="<?= $result['source']; ?>" />
                        </div>
                        <div class="form-group full-width">
                            <label class="form-label">Drop-off Address</label>
                            <input type="text" placeholder="Drop-off Address" <?php if (in_array($tab, ['selfdrive', 'bike'])) { ?> readonly="readonly" <?php } else {
                                                                                                                                                        echo $result['destination'];
                                                                                                                                                    } ?> value="<?php if (in_array($tab, ['selfdrive', 'bike'])) {
                                                                                                                                                                    echo $pickupdropaddress;;
                                                                                                                                                                } else {
                                                                                                                                                                    echo $result['destination'];
                                                                                                                                                                } ?>" id="dropaddress" name="location2" class="form-input address" />
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" name="security_amount" id="security_amount" value="yes" onclick="applyPaymode();" class="checkbox-input">
                        <label for="security_amount" class="checkbox-label">Pay Security Deposit Amount INR <?php echo twoDecimal($refundable_amount); ?></label>
                    </div>

                    <div class="payment-section">
                        <div class="security-info">
                            <div class="security-icon">🔒</div>
                            <div>
                                <div style="font-weight: 500; color: var(--gray-900);">100%</div>
                                <div class="security-text">Secure Transaction</div>
                            </div>
                        </div>
                        <div class="payment-controls">
                            <?php echo form_dropdown(['name' => 'payment_mode', 'id' => 'payment_mode', 'class' => 'form-select', 'onchange' => "applyPaymode()"], $payment_mode_list, set_value('payment_mode', $payment_mode)); ?>
                            <button class="proceed-button" onclick="grabbook();" id="submitBtn">
                                <span id="proceed"><?= $bookedfrom ? 'Proceed' : 'Proceed To Payment'; ?></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>