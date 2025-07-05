<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Slip extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
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