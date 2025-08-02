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
 
              // Try to use mPDF if available, otherwise show HTML version
              if (file_exists(FCPATH.'vendor/autoload.php')) {
                  require_once FCPATH.'vendor/autoload.php';
                  if (class_exists('\Mpdf\Mpdf')) {
                      // Use mPDF
                      header('Content-Type: application/pdf; charset=utf-8');
                      $mpdf = new \Mpdf\Mpdf(); 
                      $filename = $fetch['bookingid'].".pdf"; 
                      $mpdf->SetFont('Arial');
                      $mpdf->SetFont('Helvetica');
                      $mpdf->SetFont('sans-serif'); 
                      $mpdf->SetTitle($filename);
                      $mpdf->setAutoTopMargin = 'pad';
                      $mpdf->autoMarginPadding = 10;
                      $mpdf->WriteHTML($html,2);
                      $mpdf->Output($filename, "I"); 
                      exit;
                  }
              } elseif (file_exists(APPPATH.'third_party/mpdf/vendor/autoload.php')) {
                  require_once APPPATH.'third_party/mpdf/vendor/autoload.php';
                  if (class_exists('\Mpdf\Mpdf')) {
                      // Use mPDF
                      header('Content-Type: application/pdf; charset=utf-8');
                      $mpdf = new \Mpdf\Mpdf(); 
                      $filename = $fetch['bookingid'].".pdf"; 
                      $mpdf->SetFont('Arial');
                      $mpdf->SetFont('Helvetica');
                      $mpdf->SetFont('sans-serif'); 
                      $mpdf->SetTitle($filename);
                      $mpdf->setAutoTopMargin = 'pad';
                      $mpdf->autoMarginPadding = 10;
                      $mpdf->WriteHTML($html,2);
                      $mpdf->Output($filename, "I"); 
                      exit;
                  }
              }
              
              // Fallback: Show HTML version with print-friendly styling
              header('Content-Type: text/html; charset=utf-8');
              echo '<!DOCTYPE html>
              <html>
              <head>
                  <meta charset="utf-8">
                  <title>Booking Slip - ' . $fetch['bookingid'] . '</title>
                  <style>
                      body { font-family: Arial, sans-serif; margin: 20px; }
                      .print-button { 
                          position: fixed; top: 20px; right: 20px; 
                          background: #007bff; color: white; padding: 10px 20px; 
                          border: none; border-radius: 5px; cursor: pointer;
                      }
                      @media print {
                          .print-button { display: none; }
                      }
                  </style>
              </head>
              <body>
                  <button class="print-button" onclick="window.print()">Print Slip</button>
                  ' . $html . '
              </body>
              </html>';
              exit;   
	  
   }


	
}
?>