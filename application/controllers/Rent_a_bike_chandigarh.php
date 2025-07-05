<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rent_a_bike_chandigarh extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){ 
     	$data = array();

     	$data['metadescription'] = "Royal Enfield Rental in Chandigarh, Royal Enfield Classic Rent In Chandigarh , Royal Enfield Thunderbird Rent In Chandigarh, Royal Enfield Standard 500 Rent In Chandigarh , Royal Enfield Desert Storm Rent In Chandigarh , Royal Enfield Himalayan Rent In Chandigarh , Bajaj Avenger Street 220 Rent In Chandigarh , Honda Activa Rent In Chandigarh ,Bajaj Pulsar Rent In Chandigarh, Harley  Davidson On Rent In Chandigarh , From Rana Cabs Pvt Ltd";
     	$data['metasummary'] = $data['metadescription'];
     	$data['metakeywords'] = $data['metadescription'];
     	$data['title'] = "Royal Enfield Classic Rent In Chandigarh| Royal Enfield Rental in Chandigarh | Bikes on Rent in Chandigarh"; 




        $this->load->view( 'includes/doctype',$data );
        $this->load->view( 'includes/meta_file',$data );
        $this->load->view( 'includes/allcss',$data );
        $this->load->view( 'includes/analytics_file',$data );
        $this->load->view( 'includes/header',$data );
         
     	/* get bike rental data code */
        $bikeurl = API_PATH.('api/Menulistdata');
        $bikepost['triptype'] = 'bike';
        $bikepost['limit'] = 50;
        $bikepost['orderby'] = 'ASC';

     	$bikelist = curl_apis($bikeurl,'POST',$bikepost);
     	$data['bikelist'] = array();
     	if($bikelist['status']){
     		$data['bikelist'] = $bikelist['list'];
     	} 
 

		$this->load->view( 'rent-a-bike-chandigarh',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

		}
	
}
?>