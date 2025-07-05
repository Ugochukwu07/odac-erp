<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){ 
     	$data = array();
     	$data['metadescription'] = '';
     	$data['metasummary'] = '';
     	$data['metakeywords'] = '';
     	$data['title'] = '';
     	$data['tab'] = '';
     	$data['ttypemulti'] = '';
     	$data['cityname'] = '';
     	$data['for'] = '';
     	$data['pickdatetime'] = date('d-m-Y h:i A', strtotime('+90 minutes'));
     	$data['dropdatetime'] = date('d-m-Y h:i A', strtotime('+90 minutes'));
     	$data['dropmontlydatetime'] = date('d-m-Y h:i A' ,strtotime( date('Y-m-d H:i:s',strtotime($data['pickdatetime'])).' +30 days' )); 

        /*check admin session data start script*/
        if($admindata = $this->session->userdata('adminbooking')){
            $data['tab'] = $admindata['c_trip'];
        }
        /*check admin session data start end*/

        
        /* citylist code */
        $cityurl = API_PATH.('api/citylist');
     	$citylist = curl_apis($cityurl,'GET');
     	$data['citylist'] = array();
     	if($citylist['status']){
     		$data['citylist'] = $citylist['list'];
     	}


     	/* get bike rental data code */
        $bikeurl = API_PATH.('api/Menulistdata');
        $bikepost['triptype'] = 'bike';
        $bikepost['limit'] = 8;
        $bikepost['orderby'] = 'ASC';

     	$bikelist = curl_apis($bikeurl,'POST',$bikepost);
     	$data['bikelist'] = array();
     	if($bikelist['status']){
     		$data['bikelist'] = $bikelist['list'];
     	}


     	/* get selfdrive car rental data code */
        $selfdriveurl = API_PATH.('api/Menulistdata');
        $selfpost['triptype'] = 'selfdrive';
        $selfpost['limit'] = 8;
        $selfpost['orderby'] = 'ASC';

     	$selfdrivelist = curl_apis($selfdriveurl,'POST',$selfpost);
     	$data['selfdrivelist'] = array();
     	if($selfdrivelist['status']){
     		$data['selfdrivelist'] = $selfdrivelist['list'];
     	}
     	
        /* about-us data code */
        $abouturl = API_PATH.('api/cmsdata');
        $aboutpost['pagetype'] = 'cms';
        $aboutpost['pageurl'] = 'index';
        $aboutpost['domainid'] = DOMAINID;
        $aboutpost['id'] = null;

        $aboutlist = curl_apis($abouturl,'POST',$aboutpost); 
        $data['aboutuscontent'] = false;
        if($aboutlist['status']){
            $data['aboutuscontent'] = $aboutlist['data']['content']; 
            $data['metadescription'] = $aboutlist['data']['metadescription'];
            $data['metasummary'] = $aboutlist['data']['summary'];
            $data['metakeywords'] = $aboutlist['data']['metakeyword'];
            $data['title'] = $aboutlist['data']['metatitle']; 
        } 

     	


		$this->load->view( 'includes/doctype',$data );
		$this->load->view( 'includes/meta_file',$data );
		$this->load->view( 'includes/allcss',$data );
		$this->load->view( 'includes/analytics_file',$data );
		$this->load->view( 'includes/header',$data );
		$this->load->view( 'includes/software',$data );
		$this->load->view( 'includes/why-coose-us',$data );

		$this->load->view( 'includes/vehicle-category',$data );
		$this->load->view( 'includes/what-our-client-says',$data );
		$this->load->view( 'includes/about-us',$data );
		$this->load->view( 'includes/paragraph',$data );
		$this->load->view( 'includes/have-a-question',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

		}
		
		
		function checkmonthlyDate(){
		    $pickdate = $this->input->post('pickdate');
		    echo date('d-m-Y h:i A' ,strtotime( date('Y-m-d H:i:s',strtotime($pickdate)).' +30 days' ));
		}
		
		
		function testm(){
		    
		    $message = "Dear Rana Sir, To Confirm Booking slip with Booking id RCPL2023040519030961, please click on https://ranatravelschandigarh.com?1&redirect=new, to Confirm Booking Slip. Thanks Rana Cabs Pvt Ltd.";
		    $TemplateID = '1707168059057395735';
		    $message = "Dear Rana Sir, To Confirm Booking slip with Booking id RCPL20, please click on abc, to Confirm Booking Slip. Thanks Rana Cabs Pvt Ltd.";
		    
		  //echo sendsms('9041412141',$message, $TemplateID );
		}
	
}
?>