<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payubiz extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
    $this->load->helper('slip');
		}
	
	  

public function index(){  

        $raw = $this->input->get()?$this->input->get():$this->input->post();


        $post = json_decode( base64_decode($raw['utm']),true );
      

      $productinfo = $post['res']['id'];
      $amount = (float)$post['res']['restamount'] + (float)$post['res']['onlinecharge'];
      $firstname = $post['data']['fullname'];
      $email = $post['data']['emailid'];
      $phone = $post['data']['mobileno'];
      $orderid = $post['res']['orderid'];
      $successurl = PEADEX.'payubiz/responsep';
      $failureurl = PEADEX.'payubiz/responsep';
      /* Payments made easy. */



      /*prepare to insert in log table*/
      $log['fullname'] = $firstname ;
      $log['emailid'] = $email;
      $log['order_no'] = $orderid;
      $log['amount'] = $amount;
      $log['transactiondate'] = date('Y-m-d H:i:s' ); 
      $log['websitename'] = DOMAINID;
      $log['status'] = 0;
      $log['payfor'] = 'booking';
      $log['gatewaystatus'] = 'request';
      $log['io'] = 'I';
      $this->c_model->saveupdate('pt_transaction_log',$log );


      /* call payubiz library . */
      require_once APPPATH .'third_party/payu_libs/payu.php';

      /* Payment Gateway Code start Here . */
      pay_page( ['key' => PAYUKEY, 'txnid' => $orderid, 'amount' => $amount,
      'firstname' => $firstname, 'email' => $email, 'phone' => $phone,
      'productinfo' => $productinfo, 'surl' => $successurl, 'furl' => $failureurl ], 
      PAYUSALT ,$successurl,$failureurl );
      /* Payment Gateway Code end Here . */




}



public function responsep(){ 
 

  $ip = $this->get_client_ip();

  //if($ip != '47.9.90.255' ){
  //   redirect( PEADEX );
  //}

 
  $post = $this->input->get()?$this->input->get():$this->input->post();  

  if(empty($post)){ 
    redirect( PEADEX );
    
  }

  $orderid = !empty($post['txnid'])?$post['txnid']:false;
  $productinfo = !empty($post['productinfo'])?$post['productinfo']:'';
  $amount = !empty($post['amount'])?$post['amount']:'';
  if(!$orderid){ 
    redirect( PEADEX );
  }


//check transaction status is it closed or not
 $fetchtxndetails = $this->c_model->getSingle('pt_transaction_log',['status'=>0,'gatewaystatus'=>'request','order_no'=>$post['txnid']],' * ' );
    if(empty($fetchtxndetails)){ 
    redirect( PEADEX );
    }
  
//check booking order in our database
$upwhere = [];
$upwhere['bookingid'] = $orderid;
$upwhere['id'] = $productinfo;
 $fetchbk = $this->c_model->getSingle('pt_booking',$upwhere,' * ' );
  
  if(empty($fetchbk)){ 
    redirect( PEADEX );
  }

 $status = strtoupper($post['status']);

  /*prepare to insert in table*/
  $log['fullname'] = $post['firstname'];
  $log['emailid'] = $post['email'];
  $log['phone'] = $post['phone'];
  $log['order_no'] = $post['txnid'];
  $log['amount'] = $post['amount'];
  $log['transactiondate'] = date('Y-m-d H:i:s',strtotime($post['addedon'])); 
  $log['websitename'] = $fetchbk['domainid'];
  $log['status'] = ($status == 'SUCCESS')?1:0;
  $log['payfor'] = 'booking';
  $log['gatewaystatus'] = strtolower($status);
  $log['io'] = 'O';
  $log['remark'] = $post['error_Message']?$post['error_Message']:'O';
  $log['bank_ref_num'] = !empty($post['bank_ref_num']) ? $post['bank_ref_num'] : '';
  $log['bankcode'] = !empty($post['bankcode']) ? $post['bankcode'] : '';
  $this->c_model->saveupdate('pt_transaction_log',$log, null, ['order_no'=>$post['txnid']] );


  //echo '<pre>';
  //print_r($post); exit;


 
  
  $up['attemptstatus'] = 'temp';
  if( in_array( strtoupper($status), ['SUCCESS','PENDING'])){ 
    
        $up['attemptstatus'] = 'new';
        $up['bookingamount'] = $amount; 
        $up['restamount'] = (float)$fetchbk['totalamount'] - (float)$amount; 
        $update = $this->c_model->saveupdate('pt_booking',$up,null, $upwhere);
        if($update){ 
           $shootsms = shootsms($fetchbk,'new');
           $htmlmail = bookingslip($fetchbk,'mail');
           //CHECK REDIRECTION
           $fetchDomain = $this->c_model->getSingle('pt_domain',['id'=>$fetchbk['domainid']],'id,domain' );
           $gotourl = 'payumsg/index?utm='.md5($productinfo).'&msg='.rawurlencode($post['error_Message']).'&for=booking'; 
                //if(!empty($fetchDomain['domain']) && ($fetchDomain['domain'] != 'www.ranatravelschandigarh.com') ){
                //   $url = 'http://'.$fetchDomain['domain'].'/'.$gotourl;
                //}
                //else {
                $url = PEADEX.$gotourl;  
                //}
           
           redirect( $url );
          exit;
        }
    
    $url = PEADEX.'payumsg/index?msg='.$post['error_Message'];
    redirect( $url );
    exit;
  }else if( $status == 'FAILURE' ){
      $url = PEADEX.'payumsg/index?msg='.$post['error_Message'];
    redirect( $url );
    exit;
  }

  




}



private function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}



	
}
?>