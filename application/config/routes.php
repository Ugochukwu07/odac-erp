<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Welcome/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['car-bike-reservation.php'] = 'Car_bike_reservation/index/$1';
$route['rent-a-bike-chandigarh.php'] = 'Rent_a_bike_chandigarh/index/$1';
$route['self-drive-in-chandigarh.php'] = 'Self_drive_in_chandigarh/index/$1';
$route['terms-conditions.php'] = 'Terms_conditions/index/$1';
$route['contact-us.php'] = 'Contactus/index/$1';
$route['about-us.php'] = 'About_us/index/$1';
$route['today-offers.php'] = 'Today_offers/index/$1';
$route['our-assossories.php'] = 'Our_assossories/index/$1';
$route['discuss.php'] = 'Discuss/index/$1';
$route['make-a-payment.php'] = 'Our_assossories/index/$1';
$route['cancel-booking.php'] = 'Cancel_booking/index/$1';
$route['company-profile.php'] = 'Company_profile/index/$1';
$route['disclaimer-policy.php'] = 'Disclaimer_policy/index/$1';
$route['privacy-policy.php'] = 'Privacy_policy/index/$1';
$route['refund-cancellation-policy.php'] = 'Refund_cancellation_policy/index/$1';
$route['booking-details-vehicle-bike.php'] = 'Booking_details_vehicle_bike/index/$1';
$route['why-choose-us.php'] = 'Why_choose_us/index/$1';
//$route['farebreakup.php'] = 'Fb/index/$1';
$route['reservation.html'] = 'Reservation/index/$1';
$route['mylogin.html'] = 'private/login/index/$1'; 
$route['reservation_form.html'] = 'Reservation_form/index/$1';
$route['callback.html'] = 'Callback/index/$1';
$route['push_callback.php'] = 'Callback/send/$1';
$route['(:any)'] = 'Seopage/index/$1';