<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payumsg extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

public function index(){  
  
        $post = $this->input->get()?$this->input->get():$this->input->post();
        

        $for = !empty($post['for'])?$post['for']:'';
        $utm = !empty($post['utm'])?$post['utm']:'';

        $data = [];
        $data['utm'] = $utm;
        $data['for'] = $for;
        $data['txndata'] = '';
        $data['status'] = 'failure';
        $data['href'] = '#';

        if($utm && ($for=='booking')){
        $where['md5(id)'] = $utm; 
 		$fetch = $this->c_model->getSingle('pt_booking',$where,'id,bookingid' );
 		$data['txndata'] = $fetch; 
	 		if( !$fetch ){
	 			//redirect( PEADEX );
	 		} 
	 	$data['status'] = 'success';
 		$data['href'] = PEADEX.'slip/index?utm='.$utm.'&for=print';
        }

       

        
     	$data['metadescription'] = '';
     	$data['metasummary'] = '';
     	$data['metakeywords'] = '';
     	$data['title'] = ''; 
        
        

		$this->load->view( 'includes/doctype',$data );
		$this->load->view( 'includes/meta_file',$data );
		$this->load->view( 'includes/allcss',$data );
		$this->load->view( 'includes/analytics_file',$data );
		$this->load->view( 'includes/header',$data ); 

		$this->load->view( 'payumsg',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

}



	
}
?>