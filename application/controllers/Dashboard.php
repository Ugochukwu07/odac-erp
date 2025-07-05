<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

public function index(){  

	$userdata = $this->session->userdata('frontbooking');
	
	if(empty($userdata)){
      redirect( PEADEX );
	}

	$id 		= $userdata['c_uid'];
	$uniqueid 	= $userdata['c_mobile'];

	 

        $data = []; 

        
        $where['uniqueid'] = $uniqueid; 
        $where['attemptstatus !='] = 'temp'; 
 		$fetch = $this->c_model->getAll('pt_booking','id ASC',$where,'*' );
 		$data['list'] = $fetch; 
	 		   

     	$data['metadescription'] = '';
     	$data['metasummary'] = '';
     	$data['metakeywords'] = '';
     	$data['title'] = 'Booking List'; 
        
        

		$this->load->view( 'includes/doctype',$data );
		$this->load->view( 'includes/meta_file',$data );
		$this->load->view( 'includes/allcss',$data );
		$this->load->view( 'includes/analytics_file',$data );
		$this->load->view( 'includes/header',$data ); 

		$this->load->view( 'dashboard',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

}



	
}
?>