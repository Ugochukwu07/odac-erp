<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property Common_model $c_model
 */
class Makebooking extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      adminlogincheck();
      $this->load->model('Common_model', 'c_model');
   }


   public function index()
   {
      $currentpage = 'makebooking';
      $data['posturl'] = adminurl($currentpage);
      $data['title'] = 'Create Booking';
      $data['place'] = 'no';

      if ($post = $this->input->post()) {
         unset($post['mysubmit']);

         if (empty($post['c_paymode'])) $post['c_paymode'] = 'paid';

         /*check customer entry start script*/
         if ($post['c_mobile']) {
            $check['uniqueid'] = trim($post['c_mobile']);
            $save['add_date'] = date('Y-m-d H:i:s');
            $save['uniqueid'] = trim($post['c_mobile']);
            $save['mobileno'] = trim($post['c_mobile']);
            $save['emailid'] = trim($post['c_email']);
            $save['fullname'] = trim($post['c_name']);
            $save['address'] = trim($post['c_address']);
            $save['status'] = 'yes';
            $update = $this->c_model->saveupdate('pt_customer', $save, $check);
            if ($update && empty($post['c_uid'])) {
               $post['c_uid'] = $update;
            }
         }
         /*check customer entry end script*/

         /* store logged in data*/
         if ($loginUser = $this->session->userdata('adminloginstatus')) {
            $post['add_by'] = $loginUser['logindata']['mobile'];
            $post['add_by_name'] = $loginUser['logindata']['fullname'];
            $post['add_by_id'] = $loginUser['logindata']['id'];
            $post['domainid'] = checkdomain('domainid');
         }

         $this->session->set_userdata('adminbooking', $post);


         // $booking = [];

         // if ($return = $this->session->userdata('adminbooking')) {
         //    $data['c_uid'] = $return['c_uid'];
         // }

         // _view('makebooking_car', $data);
         redirect(PEADEX . 'private/makebooking/bookCar');
      }


      $data['c_uid'] = '';
      $data['c_name'] = '';
      $data['c_mobile'] = '';
      $data['c_email'] = '';
      $data['c_address'] = '';
      $data['c_trip'] = '';
      $data['c_paymode'] = 'cash';
      $data['c_txn_id'] = '';
      $data['c_ad_amount'] = '0';
      $data['c_discount'] = '0';

      if ($return = $this->session->userdata('adminbooking')) {
         $data['c_uid'] = $return['c_uid'];
         $data['c_name'] = $return['c_name'];
         $data['c_mobile'] = $return['c_mobile'];
         $data['c_email'] = $return['c_email'];
         $data['c_address'] = !empty($return['c_address']) ? $return['c_address'] : '';
         $data['c_trip'] = $return['c_trip'];
         $data['c_paymode'] = $return['c_paymode'];
         $data['c_ad_amount'] = $return['c_ad_amount'];
         $data['c_discount'] = $return['c_discount'];
      }

      _view('makebooking', $data);
   }


   public function bookCar()
   {
      $data = [];

      $data['fullname'] = "Hello";
      $data['cityname'] = '';
      $data['destinationCity'] = '';
      $data['pickdatetime'] = date('Y-m-d\TH:i', strtotime('+90 minutes'));
      $data['dropdatetime'] = date('Y-m-d\TH:i', strtotime('+90 minutes'));
      $data['dropmontlydatetime'] = date('Y-m-d\TH:i', strtotime(date('Y-m-d H:i:s', strtotime($data['pickdatetime'])) . ' +30 days'));

      $session = $this->session->userdata('adminbooking');
      if ($session) {
         $data['tab'] = $session['c_trip'];
         $data['cityname'] = isset($session['sourcecity']) ? $session['sourcecity'] : '';
         $data['destinationCity'] = isset($session['destinationCity']) ? $session['destinationCity'] : '';
         $data['pickdatetime'] = isset($session['pickdatetime']) ? $session['pickdatetime'] : $data['pickdatetime'];
         $data['dropdatetime'] = isset($session['dropdatetime']) ? $session['dropdatetime'] : $data['dropdatetime'];
         $data['dropmontlydatetime'] = isset($session['dropmontlydatetime']) ? $session['dropmontlydatetime'] : $data['dropmontlydatetime'];
      } else {
         $data['tab'] = 'selfdrive'; // Default tab
      }

      /* citylist code */
      // $cityurl = API_PATH . ('api/citylist');
      $citylist = $this->getCityList();
      // $citylist = curl_apis($cityurl, 'GET');
      $data['citylist'] = array();
      if (isset($citylist['status']) && $citylist['status']) {
         $data['citylist'] = $citylist['list'];
      }

      _view('makebooking_car', $data);
   }

   public function reservation()
   {
      //get all query params to $query array
      // $query = $this->input->get();
      // print_r($query);
      // exit;

      $data = [];
      $getdata = [];


      $post['id'] = NULL;
      $post['pagetype'] = 'cms';
      $post['pageurl'] = 'reservation.html';
      $post['domainid'] = DOMAINID;
      if ($return = $this->session->userdata('adminbooking')) {
         $post['domainid'] = $return['domainid'];;
      }

      // $apiurl = base_url('api/cmsdata'); 
      // $getdata = curl_apis($apiurl,'POST', $post );  
      $data['metadescription'] = '';
      $data['metasummary'] = '';
      $data['metakeywords'] = '';
      $data['title'] = '';
      $data['heading'] = '';
      $data['description'] = '';
      $data['list'] = [];
      $data['terms'] = [];
      $data['termslist'] = ''; // Initialize termslist to prevent undefined variable error


      $data['tab'] = '';
      $data['subtab'] = '';
      $data['source'] = '';
      $data['sourcecityname'] = '';
      $data['destination'] = '';
      $data['pickdatetime'] = '';
      $data['dropdatetime'] = '';
      $data['days'] = '';



      if ($get = $this->input->get()) {

         $data['tab'] = isset($get['tabdata']) ? $get['tabdata'] : '';
         $data['subtab'] = isset($get['mode']) ? $get['mode'] : '';
         $data['source'] = isset($get['sourcecity']) ? $get['sourcecity'] : '';
         $data['sourcecityname'] = '';
         if (!empty($data['source'])) {
            $sourcearr = $this->c_model->getSingle('pt_city', ['id' => $data['source']], 'cityname');
            $data['sourcecityname'] = $sourcearr['cityname'];
         }
         $data['destination'] = isset($get['destinationCity']) ? $get['destinationCity'] : '';
         $data['pickdatetime'] = isset($get['pickdatetime']) ? $get['pickdatetime'] : '';
         $data['dropdatetime'] = isset($get['dropdatetime']) ? $get['dropdatetime'] : '';
         $data['days'] = getdays($data['pickdatetime'], $data['dropdatetime']);


         /*prepare data for search start*/
         $url = API_PATH . 'api/customer/searchvehicle';
         $method = 'POST';
         $postdata['tab'] = isset($get['tabdata']) ? $get['tabdata'] : '';
         $postdata['subtab'] = isset($get['mode']) ? $get['mode'] : '';
         $postdata['source'] = isset($get['sourcecity']) ? $get['sourcecity'] : '';
         $postdata['destination'] = isset($get['destinationCity']) ? $get['destinationCity'] : '';
         $postdata['pickdatetime'] = isset($get['pickdatetime']) ? $get['pickdatetime'] : '';
         $postdata['dropdatetime'] = isset($get['dropdatetime']) ? $get['dropdatetime'] : '';

         if ($postdata['subtab'] == 'multicity') {
            $via = isset($get['tocityvia']) ? $get['tocityvia'] : '';
            if (!empty($via)) {
               $via = implode('|', $via);
               $postdata['destination'] = $postdata['destination'] . '|' . $via;
            }
         }

         /*store uniqueid for browser visit */
         if (empty($this->session->userdata('cleanuid'))) {
            $postdata['cleanuid'] = $this->session->set_userdata(['cleanuid' => date('YmdHis') . rand(100, 999)]);
         } else {
            $postdata['cleanuid'] = $this->session->userdata('cleanuid');
         }

         //      echo $url;    
         //   echo json_encode( $postdata ); exit;

         // $buffer = curl_apis($url, $method, $postdata);
         $buffer = $this->searchvehicle($postdata);
         if (!empty($buffer['status'])) {
            $data['list'] = !empty($buffer['data']) ? $buffer['data'] : [];
            $data['terms'] = !empty($buffer['terms']) ? $buffer['terms'] : [];
         }
         // echo '<pre>';
         //             print_r($buffer); //exit;


         //set meta title and description start script
         $titleName = "Book A Cab from " . $data['sourcecityname'] . ' to ' . $data['destination'] . ' for ' . $postdata['tab'];

         $data['metadescription'] = $titleName;
         $data['metasummary'] = $titleName;
         $data['metakeywords'] = $titleName;
         $data['title'] = $titleName;

         //set meta title and description start script

      }
      /*prepare data for search end*/


      //exit;


      _view('make_booking/reservation', $data);
   }

   public function reservationForm() {
      $data = [];
      $getdata = [];

      $post['id'] = NULL;
      $post['pagetype'] = '';
      $post['pageurl'] = adminurl('makebooking/reservationForm');
      $post['domainid'] = DOMAINID;
      $data['payment_mode'] = 'advance';
      if ($return = $this->session->userdata('adminbooking')) {
         $post['domainid'] = $return['domainid'];
         $data['payment_mode_list'] = ['advance' => 'Advance Payment', 'full' => 'Full Payment', 'cash' => 'Cash'];
      } else {
         if (RAZOR_PAY_ENABLE_DISABLE == 'enable') {
            $data['payment_mode_list'] = ['advance' => 'Advance Payment', 'full' => 'Full Payment'];
         } else {
            $data['payment_mode_list'] = ['advance' => 'Advance Payment', 'full' => 'Full Payment', 'cash' => 'Cash'];
         }
      }
      $data['metadescription'] = '';
      $data['metasummary'] = '';
      $data['metakeywords'] = '';
      $data['title'] = '';
      $data['heading'] = '';
      $data['description'] = '';
      $data['result'] = [];
      $data['place'] = false;

      $post =  $this->input->get('utm');
      if (!empty($post)) {
         $reqid = base64_decode($post);
         $where['id'] = $reqid;
         $fetch = $reqid ? $this->c_model->getSingle('pt_urlsortner', $where, 'id,payload') : [];
         if (empty($fetch)) {
            redirect(adminurl('makebooking'));
         }
         $req = $fetch['payload'] ? base64_decode($fetch['payload']) : '';
         $req = json_decode($req, true);
         $req['stock'] = $reqid;
         $data['result'] = $req;
      } else {
         redirect(adminurl('makebooking'));
      }


      /*prepare data to load coupon data start*/
      $cpnw = [];
      $data['cpnlist'] = [];
      if (!empty($req)) {
         $cpnw['triptype'] = $req['triptype'];
         $cpnw['withgstamount'] = $req['withgstamount'];
         //print_r( $cpnw); exit;
         $cpnurl = API_PATH . ('api/customer/coupon/cpnlist');
         $cpnlist = curl_apis($cpnurl, 'POST', $cpnw);

         if (!empty($cpnlist['status'])) {
            $data['cpnlist'] = $cpnlist['data'];
         }
      }
      /*prepare data to load coupon data end*/
      //  echo '<pre>';
      // print_r( $data['cpnlist'] ); exit;

      /*check if any stored session is active start script*/
      $data['firstname'] = '';
      $data['lastname'] = '';
      $data['emailid'] = '';
      $data['mobileno'] = '';
      $data['bookedfrom'] = '';
      $data['offer'] = '';
      $data['advance_amount'] = '';


      if ($return = $this->session->userdata('adminbooking')) {
         $data['firstname'] = $return['c_name'];
         $data['lastname'] = '';
         $data['emailid'] = $return['c_email'];
         $data['mobileno'] = $return['c_mobile'];
         $data['bookedfrom'] = 'admin';
         $data['offer'] = $return['c_discount'];
         $data['advance_amount'] = $return['c_ad_amount'];
      } else if ($return = $this->session->userdata('frontbooking')) {
         $data['firstname'] = $return['c_name'];
         $data['lastname'] = '';
         $data['emailid'] = $return['c_email'];
         $data['mobileno'] = $return['c_mobile'];
      }
      // var_dump($data['result'], $return, $this->session->userdata('adminbooking'));
      // die;

      /*check if any stored session is active end script*/

      /*get vehicle pickup drop address */
      $data['pickupdropaddress'] = '';
      $cityData = !empty($req) ? $this->c_model->getSingle('pt_city', ['id' => $req['fromcity']], 'id,pickupdropaddress') : [];
      if (!empty($cityData)) {
         $data['pickupdropaddress'] = $cityData['pickupdropaddress'];
      }


      //set meta title and description start script
      $titleName = "Book A Cab from " . $data['pickupdropaddress'] . ' to ' . (!empty($req['destination']) ? $req['destination'] : '') . ' for ' . (!empty($req['triptype']) ? $req['triptype'] : '');

      $data['metadescription'] = $titleName;
      $data['metasummary'] = $titleName;
      $data['metakeywords'] = $titleName;
      $data['title'] = $titleName;

      _view('make_booking/form', $data);

      //set meta title and description start script


      //   $this->load->view('includes/doctype', $data);
      //   $this->load->view('includes/meta_file', $data);
      //   $this->load->view('includes/allcss', $data);
      //   $this->load->view('includes/analytics_file', $data);
      //   $this->load->view('includes/header', $data);


      //   $this->load->view('reservation_form', $data);
      //   $this->load->view('includes/footer', $data);
      //   $this->load->view('includes/all-js', $data);
      //   $this->load->view('includes/footer-bottom', $data);
   }

   public function getdetails()
   {
      $post = $this->input->post();
      $keys = 'uniqueid,emailid,fullname,id,address';
      $output = $this->c_model->getSingle('pt_customer', $post, $keys);
      echo json_encode($output);
   }

   public function reset()
   {
      $this->session->unset_userdata('adminbooking');
      redirect(adminurl('makebooking'));
   }


   /**
    * Search vehicle
    *
    * @param array $request
    * @return array
    */
   private function searchvehicle($request): array
   {
      $response = [];
      $data = [];
      $getdata = [];
      $today = date('Y-m-d H:i:s');
      // $request = getparam();


      // if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
      //    $response['status'] = FALSE;
      //    $response['message'] = 'Invalid Request!';
      //    echo json_encode($response);
      //    exit;
      // }


      /*release reserve vehicle*/
      $this->releaseVehicle();

      /****************************** Check input data start *******************/
      $tab = isset($request['tab']) ? $request['tab'] : null;
      $subtab = isset($request['subtab']) ? $request['subtab'] : null;
      $sourceid = isset($request['source']) ? $request['source'] : null;
      $destination = isset($request['destination']) ? $request['destination'] : null;
      $pickdatetime = isset($request['pickdatetime']) ? date('Y-m-d H:i:s', strtotime($request['pickdatetime'])) : null;
      $dropdatetime = isset($request['dropdatetime']) ? date('Y-m-d H:i:s', strtotime($request['dropdatetime'])) : null;


      if (empty($tab)) {
         $response['status'] = FALSE;
         $response['message'] = 'Tab is Blank!';
         return $response;
      } else if (!in_array($tab, ['bike', 'selfdrive', 'outstation', 'monthly'])) {
         $response['status'] = FALSE;
         $response['message'] = 'Allow tabs are bike,selfdrive,outstation,monthly';
         return $response;
      } else if (empty($sourceid)) {
         $response['status'] = FALSE;
         $response['message'] = 'Source ID is Blank!';
         return $response;
      } else if (empty($pickdatetime)) {
         $response['status'] = FALSE;
         $response['message'] = 'Pickup Date And Time is Blank!';
         return $response;
      } else if (empty($dropdatetime)) {
         $response['status'] = FALSE;
         $response['message'] = 'Droop Date And Time is Blank!';
         return $response;
      }


      /*calculate days */
      $days = getdays($pickdatetime, $dropdatetime);

      if (in_array($tab, ['monthly']) && (int)$days < 28) {
         $response['status'] = FALSE;
         $response['message'] = 'Please select minimum 28 days for monthly package';
         return $response;
      }


      $source = $this->getCity($sourceid);
      $cleanuid = isset($request['cleanuid']) ? $request['cleanuid'] : null;
      /*delete old records*/
      $delwhere['indate <='] = date('Y-m-d');
      if (!empty($cleanuid)) {
         $delwhere['uid'] = $cleanuid;
      }
      $cleanrecords = $this->c_model->delete('pt_urlsortner', $delwhere);



      $distance = 0;
      $travelstime = 0;
      $routes = [];
      $store = [];

      if ($tab == 'outstation') {
         $destination = rtrim($destination, '|');
         $googleApi = viadistancecalutaor($source, $destination);
         $distance = $googleApi['kms'];
         $travelstime = convertmintohour($googleApi['time']);
         if (!empty($googleApi['routes'])) {
            foreach ($googleApi['routes'] as $key => $rvalue) {
               $store['via'] = $rvalue;
               array_push($routes,  $store);
            }
         }

         if (strpos($destination, '|') !== false) {
            $destination = explode('|', $destination);
            $destination = end($destination);
         }
      }


      $fare = [];
      $where['a.status'] = 'yes';
      $where['a.fromcity'] = $sourceid;
      $where['DATE(a.validfrom) <='] = $today;
      $where['DATE(a.validtill) >='] = $today;
      $where['a.triptype'] = $tab;
      $where['d.status'] = 'yes';


      $select = 'a.*,b.model,b.image,c.category as categoryname, d.vyear, d.fueltype, d.seat';
      $from = 'pt_fare as a';

      $join[0]['table'] = 'pt_vehicle_model as b';
      $join[0]['on'] = 'a.modelid = b.id';
      $join[0]['key'] = 'LEFT';

      $join[1]['table'] = 'pt_vehicle_cat as c';
      $join[1]['on'] = 'a.category = c.id';
      $join[1]['key'] = 'LEFT';

      $join[2]['table'] = 'pt_con_vehicle as d';
      $join[2]['on'] = 'a.modelid = d.modelid';
      $join[2]['key'] = 'LEFT';


      $groupby = 'a.id';
      $orderby = null;
      $limit = null;

      $fdata = $this->c_model->joindata($select, $where, $from, $join, $groupby, $orderby, $limit);
      //print_r($fdata); exit;
      if (empty($fdata)) {
         $response['status'] = FALSE;
         $response['message'] = 'No cab available on this date for this trip!';
         return $response;
      }

      $inkeys = 'id,startdate,enddate';
      $estkm = 0;
      foreach ($fdata as $key => $value) {

         //$getmodel_assesssory = $this->c_model->getSingle('pt_con_vehicle',['modelid'=>$value['modelid'],'status'=>'yes'],'vyear,fueltype,seat',null,1);

         //check empty model list
         //if(!empty($getmodel_assesssory)){

         $countitem = 0;
         $put = [];

         $put['modelid'] = $value['modelid'];
         $put['startdate'] = $pickdatetime;
         $put['enddate'] = $dropdatetime;
         $put['days'] = $days;
         $avails = $this->checkavailibility($put);

         // print_r($avails); exit;

         $countitem = !empty($avails) ? ($avails) : 0;
         $basefare = $value['basefare'];
         $baseFareOriginal = $value['basefare'];
         /*calculate fare */
         if ($tab == 'outstation') {
            $ttldayskm = $value['minkm_day'] * $days;
            $estkm = $distance;
            if ($ttldayskm > $distance) {
               $estkm = $ttldayskm;
            }

            $basefare = (float)$value['fareperkm'] * (float)$estkm;
            $baseFareOriginal = $basefare;
         } else if ($tab == 'bike') {
            //$basefare = (float)$value['basefare'] * (float)$days;
            $baseFareOriginal = (float)$value['basefare'] * (float)$days;
            $basefare = round((float)calculatePrincipal($value['basefare']) * (float)$days); //Added on 13 November;
         } else if ($tab == 'selfdrive') {
            //$basefare = (float)$value['basefare'] * (float)$days;
            $baseFareOriginal = (float)$value['basefare'] * (float)$days;
            $basefare = round((float)calculatePrincipal($value['basefare']) * (float)$days); //Added on 13 November;
         } else if ($tab == 'monthly') {
            //$basefare = (float)$value['basefare'] * (float)$days;
            $baseFareOriginal = (float)$value['basefare'] * (float)$days;
            $basefare = round((float)calculatePrincipal($value['basefare']) * (float)$days); //Added on 13 November;
         }

         $arra['id']             = $value['id'];
         $arra['triptype']        = $value['triptype'];
         $arra['fromcity']           = $value['fromcity'];
         $arra['categoryid']        = $value['category'];
         $arra['categoryname']       = $value['categoryname'];
         $arra['modelid']          = $value['modelid'];
         $arra['model']          = $value['model'];
         $arra['basefare']          = calculatePrincipal($value['basefare']);
         $arra['vehicle_price_per_unit'] = $value['basefare'];
         $arra['fareperkm']       = $value['fareperkm'];
         $arra['minkm_day']       = $value['minkm_day'];
         $arra['drivercharge']       = $value['drivercharge'];
         $arra['nightcharge']       = $value['nightcharge'];
         $arra['googlekm']          = (string)$distance;
         $arra['estkm']          = (string)$estkm;
         $arra['esttime']          = (string)$travelstime;
         $arra['est_fare']          = (string)$basefare;
         $arra['gst']             = (string)CABGST;
         //$arra['gstamount'] 		= (string)percentage($basefare,CABGST );
         $arra['gstamount']       = round($baseFareOriginal - $basefare);
         $arra['withgstamount']    = (string) ((float)$arra['gstamount'] + (float)$basefare);
         $arra['night_from']       = !empty($value['night_from']) ? date('h:i A', strtotime($value['night_from'])) : '';
         $arra['night_till']       = !empty($value['night_from']) ? date('h:i A', strtotime($value['night_till'])) : '';
         $arra['secu_amount']       = $value['secu_amount'];
         $arra['available_cars']    = (string)($countitem ? $countitem : 0);
         $arra['days']             = (string)$days;
         $arra['source']          = $source;
         $arra['destination']       = $destination;
         $arra['route']          = $routes;
         $arra['imageurl']          = UPLOADS . $value['image'];
         $arra['segment']          = (string) !empty($value['seat']) ? $value['seat'] : '';
         $arra['yearmodel']       = (string) !empty($value['vyear']) ? $value['vyear'] : '';
         $arra['fueltype']          = (string) !empty($value['fueltype']) ? $value['fueltype'] : '';
         $arra['acstatus']          = 'ac';
         $arra['bags']             = '2';
         $arra['pickupdatetime']    = date('Y-m-d h:i A', strtotime($pickdatetime));
         $arra['dropdatetime']       = date('Y-m-d h:i A', strtotime($dropdatetime));
         $arra['subtab']          = $subtab;
         $arra['final_with_security_amount']   = (float)$value['secu_amount'] + (float)$arra['withgstamount'];

         /*delete old records*/
         $record['indate'] = date('Y-m-d');
         $record['odr'] = $arra['id'];
         $record['payload'] = base64_encode(json_encode($arra));

         if (!empty($cleanuid)) {
            $record['uid'] = $cleanuid;
         }
         $putrecords = $this->c_model->saveupdate('pt_urlsortner', $record);
         $arra['stock']          = $putrecords;
         array_push($data, $arra);
         //}//end of check model 
      }

      if (empty($data)) {
         $response['status'] = FALSE;
         $response['message'] = 'No cab available on this date for this trip!';
         return $response;
      }

      $price = array();
      foreach ($data as $key => $row) {
         $price[$key] = $row['withgstamount'];
      }
      array_multisort($price, SORT_ASC, $data);

      //$data = array_unique( $data );

      $response['status'] = true;
      $response['data'] = $data;
      $response['terms'] = $this->getterms($tab);
      $response['message'] = 'Success!';

      return $response;
   }

   /**
    * Release vehicle
    *
    * @return void
    */
   private function releaseVehicle(): void
   {
      $today = date('Y-m-d H:i:s');
      $now = date('Y-m-d H:i:s', strtotime($today . ' -15 minutes'));

      $currentDate = date('Y-m-d');

      $sql = "SELECT * FROM `pt_dateslots` WHERE `bookingid` IN( SELECT id FROM `pt_booking` WHERE `bookingdatetime` <= '" . $now . "' AND DATE(`pickupdatetime`) >= '" . $currentDate . "' AND (`attemptstatus` = 'temp' or `attemptstatus` = 'cancel') )";
      $bookdata = $this->db->query($sql);
      $getdata = $bookdata->result_array();

      if (!empty($getdata)) {
         foreach ($getdata as $key => $value) {
            $where['status'] = 'reserve';
            $where['id'] = $value['id'];
            $save = [];
            $save['status'] = 'free';
            $save['bookingid'] = '';
            $up = $this->c_model->saveupdate('pt_dateslots', $save, null, $where);
         }
      }
   }

   /**
    * Get city name
    *
    * @param int $id
    * @return string
    */
   public function getCity($id): string
   {
      $where['a.id'] = $id;
      $select = 'CONCAT(a.cityname,",",b.statename) AS cityname';
      $from = 'pt_city as a';
      $join[0]['table'] = 'pt_state as b';
      $join[0]['on'] = 'a.stateid = b.id';
      $join[0]['key'] = 'LEFT';
      $orderby = 'a.cityname ASC';
      $getdata = $this->c_model->joindata($select, $where, $from, $join);

      $arra = '';
      foreach ($getdata as $key => $value):
         $arra = (string) capitalize($value['cityname']);
      endforeach;
      return $arra;
   }


   /**
    * Check availability of vehicles
    *
    * @param array $data
    * @return int
    */
   private function checkavailibility($data): int
   {
      $startdate = date('Y-m-d', strtotime($data['startdate']));
      $enddate = date('Y-m-d', strtotime($data['enddate']));

      $sql = "SELECT COUNT(*) AS totaldays, vehicleno FROM `pt_dateslots` WHERE `dateslot` >= '" . $startdate . "' AND `dateslot` <= '" . $enddate . "' AND `modelid` = '" . $data['modelid'] . "' AND `status`='free' AND `vehicleno` IN( SELECT DISTINCT vnumber FROM pt_con_vehicle WHERE status='yes' and `modelid` = '" . $data['modelid'] . "' ) GROUP BY `vehicleno`  HAVING totaldays >= '" . $data['days'] . "' ";
      $fdata = $this->db->query($sql);
      $fdata = $fdata->num_rows();
      return  $fdata;
   }

   /**
    * Get terms and conditions
    *
    * @param string $triptype
    * @return array
    */
   private function getterms($triptype): array
   {
      $table = 'pt_booking_terms';
      $keys = 'content';
      $orderby = 'content ASC';
      $where['datacategory'] = $triptype;
      $where['status'] = 'yes';
      $where['contenttype'] = 'terms';

      $data = $this->c_model->getAll($table, $orderby, $where, $keys);
      return !empty($data) ?  $data : [];
   }

   /**
    * Get list of cities
    *
    * @return array
    */
   public function getCityList(): array
   {
      $response = array();
      $list = array();
      $data = array();

      $select = "a.id, CONCAT(a.cityname , ',',  b.statename) as cityname";
      $from = ' pt_city as a';

      $join[0]['table'] = 'pt_state as b';
      $join[0]['on'] = 'a.stateid = b.id';
      $join[0]['key'] = 'LEFT';

      $orderby = 'a.cityname ASC';

      $getdata = $this->c_model->joindata($select, null, $from, $join, null, $orderby);

      foreach ($getdata as $key => $value):
         $arra = array(
            'id' => (string) $value['id'],
            'cityname' => (string) capitalize($value['cityname'])
         );
         array_push($list, $arra);
      endforeach;

      if (!empty($list)) {
         $response['status'] = TRUE;
         $response['list'] = $list;
         $response['message'] = "Success!";
      } else {
         $response['status'] = FALSE;
         $response['message'] = "No Record matched!";
      }

      return $response;
   }
}
