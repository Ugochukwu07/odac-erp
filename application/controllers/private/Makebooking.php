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

         if (empty($post['c_paymode'])) {
            $post['c_paymode'] = 'paid';
         }

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

   public function bookCar() {
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
      $cityurl = API_PATH . ('api/citylist');
      $citylist = curl_apis($cityurl, 'GET');
      $data['citylist'] = array();
      if (isset($citylist['status']) && $citylist['status']) {
         $data['citylist'] = $citylist['list'];
      }

      _view('makebooking_car', $data);
   }

   public function reservation(){
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
            $buffer = curl_apis($url, $method, $postdata);
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
}
