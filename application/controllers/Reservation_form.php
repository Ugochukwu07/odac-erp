<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reservation_form extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }



  public function index()
  {
    $data = [];
    $getdata = [];




    $post['id'] = NULL;
    $post['pagetype'] = '';
    $post['pageurl'] = 'reservation_form.html';
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
        redirect(PEADEX);
      }
      $req = $fetch['payload'] ? base64_decode($fetch['payload']) : '';
      $req = json_decode($req, true);
      $req['stock'] = $reqid;
      $data['result'] = $req;
    } else {
      redirect(PEADEX);
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

    //set meta title and description start script


    $this->load->view('includes/doctype', $data);
    $this->load->view('includes/meta_file', $data);
    $this->load->view('includes/allcss', $data);
    $this->load->view('includes/analytics_file', $data);
    $this->load->view('includes/header', $data);


    $this->load->view('reservation_form', $data);
    $this->load->view('includes/footer', $data);
    $this->load->view('includes/all-js', $data);
    $this->load->view('includes/footer-bottom', $data);
  }



  public function book()
  {
    $post = $this->input->post();

    $bookurl = API_PATH . ('api/customer/Createentry/index');
    $newpost['fullname'] = isset($post['fn']) ? $post['fn'] : '';
    $newpost['mobileno'] = isset($post['mob']) ? $post['mob'] : '';
    $newpost['emailid'] = isset($post['email']) ? $post['email'] : '';
    $newpost['noofpessanger'] = isset($post['ps']) ? $post['ps'] : '';
    $newpost['pickupaddress'] = isset($post['pick']) ? $post['pick'] : '';
    $newpost['dropaddress'] = isset($post['drop']) ? $post['drop'] : '';
    $newpost['couponid'] = isset($post['cpnid']) ? $post['cpnid'] : '';
    $newpost['stock'] = isset($post['stock']) ? $post['stock'] : '';
    $newpost['domainid'] = DOMAINID;
    $newpost['apptype'] = 'w';

    $newpost['paymode'] = isset($post['paymode']) ? $post['paymode'] : '';
    $newpost['is_security_deposit'] = isset($post['is_deposit']) && $post['is_deposit'] == 'yes' ? 'yes' : 'no';


    /*check session start here*/
    $bookedfrom = 'directweb'; /*forcly added on 22 oct 2023 start to disable gateway it was blank*/
    if ($return = $this->session->userdata('adminbooking')) {
      $uid_arr = $this->c_model->getSingle('pt_customer', ['id' => $return['c_uid']], 'uniqueid,id');
      $newpost['uniqueid'] = $uid_arr['uniqueid'];
      $newpost['bookedfrom'] = 'admin';
      $newpost['offeramount'] = $return['c_discount'];
      $newpost['bookingamount'] = $return['c_ad_amount'];
      $newpost['add_by'] = $return['add_by'];
      $newpost['add_by_name'] = $return['add_by_name'];
      $newpost['bank_txn_id'] = $return['c_txn_id'];
      $newpost['apptype'] = 'A';
      $bookedfrom = 'admin';
      $newpost['domainid'] = $return['domainid'];;
    } else if ($return = $this->session->userdata('frontbooking')) {
      $uid_arr = $this->c_model->getSingle('pt_customer', ['id' => $return['c_uid']], 'uniqueid,id');
      $newpost['uniqueid'] = $uid_arr['uniqueid'];
      $newpost['bookingamount'] = isset($post['bookingamount']) ? $post['bookingamount'] : '';
      $newpost['add_by_name'] = 'Website';

      /*forcly added on 22 oct 2023 start to disable gateway*/
      if ($bookedfrom == 'directweb' && RAZOR_PAY_ENABLE_DISABLE == 'disable') {
        $newpost['bookedfrom'] = 'directweb';
        $newpost['bookingamount'] = '0';
        $newpost['paymode'] = 'cash';
      }
      /*forcly added on 22 oct 2023 start */
    }




    $res = curl_apis($bookurl, 'POST', $newpost);
    // print_r( $res );
    $data['res'] = $res;
    $data['url'] = PEADEX . 'reservation_form.html?utm=' . base64_encode($post['stock']);
    if (!empty($res['status'])) {
      unset($newpost['stock']);
      $out['res'] = $res['data'];
      $out['data'] = $newpost;

      if ($bookedfrom == 'admin') {
        $id = $res['data']['id'];
        $data['is_gateway'] = false;
        $data['url'] = PEADEX . 'private/slip/index?utm=' . md5($id);
      } else if ($bookedfrom == 'directweb' && RAZOR_PAY_ENABLE_DISABLE == 'disable') {
        $id = $res['data']['id'];
        $data['is_gateway'] = false;
        $data['url'] = PEADEX . 'slip/index?utm=' . md5($id);
      }/*else{
            $data['url'] = PEADEX.'payubiz/index?utm='.base64_encode(json_encode($out));
          }*/ else if (RAZOR_PAY_ENABLE_DISABLE == 'enable') {
        $data['is_gateway'] = true;
        $data['url'] = '';
        $data['data'] = $res['data'];
        $data['key_id'] = RAZOR_PAY_KEY_ID;
        $data['verify_url'] = base_url('reservation_form/verify');
      }
    }

    echo json_encode($data);
  }

  function verify()
  {

    $post = $this->input->post() ? $this->input->post() : $this->input->get();
    $order_id = !empty($post['order_id']) ? $post['order_id'] : '';
    $pay_id = !empty($post['payid']) ? $post['payid'] : '';
    $amount = !empty($post['amount']) ? $post['amount'] : '';

    $response = [];
    $response['status'] = false;
    $response['url'] = '';
    $response['message'] = 'Some Error Occurred';


    $apiResponse = $this->capturePayment($pay_id, $amount);
    //print_r( $apiResponse ); 

    if (!empty($apiResponse) && in_array($apiResponse['status'], ['captured'])) {
      $upwhere = [];
      $upwhere['bookingid'] = $order_id;
      $fetchbk = $this->c_model->getSingle('pt_booking', $upwhere, ' * ');

      /*prepare to insert in table*/
      $log['fullname'] = $fetchbk['name'];
      $log['emailid'] = $fetchbk['email'];
      $log['phone'] = $fetchbk['mobileno'];
      $log['order_no'] = $order_id;
      $log['amount'] =  $amount;
      $log['transactiondate'] = date('Y-m-d H:i:s');
      $log['websitename'] = DOMAINID;
      $log['status'] =  ($apiResponse['status'] == 'captured') ? 1 : 0;
      $log['payfor'] = 'booking';
      $log['gatewaystatus'] = strtolower('success');
      $log['io'] = 'O';
      $log['remark'] = $pay_id;
      $log['bank_ref_num'] = !empty($apiResponse['acquirer_data']['bank_transaction_id']) ? $apiResponse['acquirer_data']['bank_transaction_id'] : '';
      $log['bankcode'] = !empty($apiResponse['bank']) ? $apiResponse['bank'] : '';
      $this->c_model->saveupdate('pt_transaction_log', $log);

      $up = [];
      $up['attemptstatus'] = 'new';
      $up['bookingamount'] = $amount;
      $up['restamount'] = (float)$fetchbk['totalamount'] - (float)$amount;
      $update = $this->c_model->saveupdate('pt_booking', $up, null, ['id' => $fetchbk['id']]);
      if ($update) {
        $shootsms = shootsms($fetchbk, 'new');
        //$htmlmail = bookingslip($fetchbk,'adminmail'); SIFTED ON CRON
        //CHECK REDIRECTION
        //$fetchDomain = $this->c_model->getSingle('pt_domain',['id'=>$fetchbk['domainid']],'id,domain' );



        $response['status'] = true;
        $response['url'] = PEADEX . 'slip/index?utm=' . md5($fetchbk['id']) . '&for=print';
        $response['message'] = 'Success';
        echo json_encode($response);
        exit;
      }
    }

    echo json_encode($response);
    exit;
  }



  function capturePayment($order_id, $amount)
  {
    // Your Razorpay API Key and Secret
    $api_key = RAZOR_PAY_KEY_ID;
    $api_secret = RAZOR_PAY_SECRET_KEY;

    // API endpoint to capture payment
    $url = "https://api.razorpay.com/v1/payments/$order_id/capture";

    // Request data
    $data = array(
      'amount' => $amount * 100
    );

    // Convert data to JSON
    $data_json = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$api_secret");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json'
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Return the response
    return json_decode($response, true);
  }
}
