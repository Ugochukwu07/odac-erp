<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Make_a_payment extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){ 
     	$data = array();


        $getdata = $this->c_model->getSingle('pt_cms',['pagetype'=>'Privacy Policy'],' * ');

     	$data['metadescription'] = $getdata['metadescription'];
     	$data['metasummary'] = $getdata['summary'];
     	$data['metakeywords'] = $getdata['metakeyword'];
     	$data['title'] = $getdata['metatitle'];
        $data['heading'] = $getdata['titleorheading'];
        $data['description'] = $getdata['content']; 




        $this->load->view( 'includes/doctype',$data );
        $this->load->view( 'includes/meta_file',$data );
        $this->load->view( 'includes/allcss',$data );
        $this->load->view( 'includes/analytics_file',$data );
        $this->load->view( 'includes/header',$data ); 
 

		$this->load->view( 'common_contents',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

		}
	
}
?>