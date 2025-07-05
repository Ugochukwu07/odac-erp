<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Today_offers extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){ 
     	$data = array();

        $post['id'] = NULL;
        $post['pagetype'] = 'cms';
        $post['pageurl'] = 'today-offers';
        $post['domainid'] = DOMAINID;
        $apiurl = API_PATH.('api/cmsdata'); 
        $getdata = curl_apis($apiurl,'POST', $post ); 

     	$data['metadescription'] = 'Todays Offers at Rana Cabs Private Limited';
     	$data['metasummary'] = 'Todays Offers at Rana Cabs Private Limited';
     	$data['metakeywords'] = 'Todays Offers at Rana Cabs Private Limited';
     	$data['title'] = 'Todays Offers at Rana Cabs Private Limited';
        $data['heading'] = 'Todays Offers at Rana Cabs Private Limited';
        $data['description'] = 'Todays Offers at Rana Cabs Private Limited';

if($getdata['status']){
    $getdata = $getdata['data'];
        $data['metadescription'] = $getdata['metadescription'];
        $data['metasummary'] = $getdata['summary'];
        $data['metakeywords'] = $getdata['metakeyword'];
        $data['title'] = $getdata['metatitle'];
        $data['heading'] = $getdata['titleorheading'];
        $data['description'] = $getdata['content'];
}


        /*prepare data to load coupon data start*/ 
        $cpnw = [];
        $data['cpnlist'] = [];
        
          
          $cpnurl = API_PATH.('api/customer/coupon/cpnlist');
          $cpnlist = curl_apis($cpnurl,'POST', $cpnw );  
          
          if( !empty($cpnlist['status'])){
          $data['cpnlist'] = $cpnlist['data']; 
          }
          
        //  echo '<pre>';
        //  print_r($data); exit;
 
        /*prepare data to load coupon data end*/


        $this->load->view( 'includes/doctype',$data );
        $this->load->view( 'includes/meta_file',$data );
        $this->load->view( 'includes/allcss',$data );
        $this->load->view( 'includes/analytics_file',$data );
        $this->load->view( 'includes/header',$data ); 
 

		$this->load->view( 'today_offers',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

		}
	
}
?>