<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Slip extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     $this->pagename = 'Slip';
	     $this->table = 'pt_booking'; 
     }	


  public function index() { 

      $post['id'] = NULL;
      $post['pagetype'] = 'cms';
      $post['pageurl'] = 'about-us';
      $post['domainid'] = DOMAINID;
      $apiurl = API_PATH.('api/cmsdata'); 
      $getdata = curl_apis($apiurl,'POST', $post ); 

      $data['metadescription'] = '';
      $data['metasummary'] = '';
      $data['metakeywords'] = '';
      $data['title'] = '';
      $data['heading'] = '';
      $data['description'] = '';


     
     /*destroy booking session start*/
     if($this->session->userdata('frontbooking')){
      //$this->session->unset_userdata('frontbooking') ;
     }
     /*destroy booking session end*/


     $where['md5(id)'] = $this->input->get('utm');
     $fetch = $this->c_model->getSingle($this->table,$where,'*' );

 
    //  if(empty($fetch)){
    //     redirect( PEADEX );
    //  }else if($fetch['attemptstatus']=='temp'){
    //   redirect( PEADEX );
    //  }

     /* mail sms start script*/
      $for = !empty($this->input->get('for'))?$this->input->get('for'):'print';
      if($fetch && ($for == 'mail')){
        //$shootsms = shootsms($fetch,'new');
        //$html = bookingslip($fetch,'mail'); it was set in api/shootsmsmail.php file using cron
        redirect( PEADEX.'private/slip/index?utm='.$this->input->get('utm').'&for=print' );
        exit;
      }
     /* mail sms end script*/
     
     

   
            // if(  strtotime($fetch['bookingdatetime'])  >=  strtotime( INVOICE_PRINT_NEW_FORMAT ) ){ 
            //   $this->load->helper('slip_new');
            //   $html = bookingslipnew($fetch,'print');  
            // }else{
              $this->load->helper('slip');
              $html = bookingslip($fetch,'print');  
            //} 
 
              header('Content-Type: text/html; charset=utf-8');
              require_once APPPATH.'/third_party/mpdf/vendor/autoload.php'; 

              $mpdf = new \Mpdf\Mpdf(); 

              $filename = $fetch['bookingid'].".pdf"; 

              $mpdf->SetFont('Arial');
              $mpdf->SetFont('Helvetica');
              $mpdf->SetFont('sans-serif'); 
              $mpdf->SetTitle($filename);

              $mpdf->setAutoTopMargin = 'pad';
              $mpdf->autoMarginPadding = 10;

              $mpdf->WriteHTML($html,2);
              // download!  use D , for view use I
              $mpdf->Output($filename, "I"); 

              exit;   
	  
   }


	
}
?>