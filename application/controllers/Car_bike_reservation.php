<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Car_bike_reservation extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){ 
     	$data = array();
     	$data['metadescription'] = "Audi Car Hire In Chandigarh , Wedding Car Hire Chandigarh, Audi Q5, Audi A4, BMW-5-Series, BMW-3-Series, Mercedes-S-Class, Mercedes-E-Class, Honda City, Toyota Camry, Toyota Corolla, Toyota Fortuner, Range Rover and lots of Cars available for rental or hire purpose in Chandigarh, Rana Cabs Pvt Ltd™ 9041412141";
     	$data['metasummary'] = $data['metadescription'];
     	$data['metakeywords'] = $data['metadescription'];
     	$data['title'] = "Audi Car Hire In Chandigarh| Audi Car Rental in Chandigarh| Luxury Audi Car Rental For wedding"; 




        $this->load->view( 'includes/doctype',$data );
        $this->load->view( 'includes/meta_file',$data );
        $this->load->view( 'includes/allcss',$data );
        $this->load->view( 'includes/analytics_file',$data );
        $this->load->view( 'includes/header',$data );
         
     	/* get bike rental data code */
        $carurl = API_PATH.('api/Menulistdata');
        $carpost['triptype'] = 'outstation';
        $carpost['limit'] = 8;
        $carpost['orderby'] = 'ASC';

     	$carlist = curl_apis($carurl,'POST',$carpost);
     	$data['carlist'] = array();
     	if($carlist['status']){
     		$data['carlist'] = $carlist['list'];
     	} 
 

		$this->load->view( 'car-bike-reservation',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

		}
	
}
?>