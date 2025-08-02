<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Slip extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     // adminlogincheck(); // Commented out to allow slip generation without admin login
	     $this->pagename = 'Slip';
	     $this->table = 'pt_booking';
	     
     }	


  public function index() { 
     
     /*destroy booking session start*/
     if($this->session->userdata('adminbooking')){
      $this->session->unset_userdata('adminbooking') ;
     }
     /*destroy booking session end*/


     $where['md5(id)'] = $this->input->get('utm');
     $fetch = $this->c_model->getSingle($this->table,$where,'*' );

     if(empty($fetch)){
        redirect( PEADEX );
     } 

     /* mail sms start script*/
     $for = !empty($this->input->get('for'))?$this->input->get('for'):'print';
      if($fetch && $for == 'mail'){
        //$shootsms = shootsms($fetch,'new');
        //$html = bookingslip($fetch,'mail'); // this part set in api/shootsmsmail.php on cron job
        redirect( PEADEX.'private/slip?utm='.$this->input->get('utm').'&for=print' );
        exit;
      } 
     /* mail sms end script*/
    //  echo '<pre>';
    //  print_r( $fetch );
     
    //  echo strtotime($fetch['bookingdatetime']);
    //  echo '<br/>'.strtotime('2024-04-26 14:37:52');

            // if(  strtotime($fetch['bookingdatetime'])  >=  strtotime( INVOICE_PRINT_NEW_FORMAT ) ){ 
            //   $this->load->helper('slip_new');
            //   $html = bookingslipnew($fetch,$for);  
            // }else{
              $this->load->helper('slip');
              $html = bookingslip($fetch,$for);  
           // }
            
           // exit;
               

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