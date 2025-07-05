<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Self_drive_in_chandigarh extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){ 
     	$data = array();

     	$data['metadescription'] = "Self Driver Car rental Service in Chandigarh, Audi Luxury Car On Rent Chandigarh, Audi Rent In Chandigarh, Audi On Rent in Chandigarh, Chandigarh Audi On Rent, From Rana Cabs Pvt Ltd";
     	$data['metasummary'] = $data['metadescription'];
     	$data['metakeywords'] = $data['metadescription'];
     	$data['title'] = "Self Driver Car rental Service in Chandigarh| Audi Luxury Car On Rent Chandigarh| Audi Rent In Chandigarh|Audi On Rent in Chandigarh|Chandigarh Audi On Rent ";




        $this->load->view( 'includes/doctype',$data );
        $this->load->view( 'includes/meta_file',$data );
        $this->load->view( 'includes/allcss',$data );
        $this->load->view( 'includes/analytics_file',$data );
        $this->load->view( 'includes/header',$data );
         
     	/* get bike rental data code */
        $selfurl = API_PATH.('api/Menulistdata');
        $selfpost['triptype'] = 'selfdrive';
        $selfpost['limit'] = 50;
        $selfpost['orderby'] = 'ASC';

     	$selflist = curl_apis( $selfurl,'POST',$selfpost );
     	$data['selflist'] = array();
     	if($selflist['status']){
     		$data['selflist'] = $selflist['list'];
     	} 
 

		$this->load->view( 'self-drive-in-chandigarh',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

		}
	
}
?>