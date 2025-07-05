<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Discuss extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){ 
     	$data = array();

 

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

if($getdata['status']){
    $getdata = $getdata['data'];
        $data['metadescription'] = $getdata['metadescription'];
        $data['metasummary'] = $getdata['summary'];
        $data['metakeywords'] = $getdata['metakeyword'];
        $data['title'] = $getdata['metatitle'];
        $data['heading'] = $getdata['titleorheading'];
        $data['description'] = $getdata['content'];
}



        $this->load->view( 'includes/doctype',$data );
        $this->load->view( 'includes/meta_file',$data );
        $this->load->view( 'includes/allcss',$data );
        $this->load->view( 'includes/analytics_file',$data );
        $this->load->view( 'includes/header',$data ); 
 

		$this->load->view( 'discuss',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

		}
	
}
?>