<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){ 
         
        $addressid = $this->input->get('addressid');
        
     	$data = array();
     	$data['metadescription'] = '';
     	$data['metasummary'] = '';
     	$data['metakeywords'] = '';
     	$data['title'] = ''; 
     	$data['list'] = $this->c_model->getAll('pt_address_office_list','sortby ASC',null,'id,working_hours,working_days,office_type,city_name,address_name,mobile_numbers,map_script,sortby,email_address,whats_app'); 
     	
    //  	echo '<pre>';
    //  	print_r($data['list']); exit;
    
        $data['s_address'] = "";
        $data['s_phone_list'] = explode(',',"9888412141,9988412141");
        $data['s_whatsapp_list'] =  explode(',',"9888412141,9988412141");
        $data['s_map_script'] = "";
        $data['office_type_heading'] = "Chandigarh UT (Head Office)";
        $data['s_email'] = ADMINEMAIL;
        $data['working_days'] = 'Monday-Saturday';
        $data['working_hours'] = '10AM-10PM';
        
        foreach( $data['list'] as $key=>$value ){
            if( (!empty( $addressid ) && $addressid == $value['id']) || ($value['sortby'] == 1)  ){
                $data['s_address'] = $value['address_name'] ;
                $data['s_phone_list'] = explode(',', $value['mobile_numbers']  );
                $data['s_whatsapp_list'] =  explode(',', $value['whats_app']  );
                $data['s_map_script'] = $value['map_script'] ;
                $data['office_type_heading'] = $value['city_name'] ." ( ".$value['office_type']." )";
                $data['s_email'] = $value['email_address'] ;
                $data['working_days'] = $value['working_days'] ;
                $data['working_hours'] = $value['working_hours'] ;
            } 
        }
        
        
        
        $data['metadescription'] = 'Ranacabs Pvt Ltd: Address: '.$data['s_address'];
     	$data['metasummary'] = 'Ranacabs Pvt Ltd: Address: '.$data['s_address'];
     	$data['metakeywords'] = 'Ranacabs Pvt Ltd: Address: '.$data['s_address'];
     	$data['title'] = 'Ranacabs Pvt Ltd: Address: '.$data['s_address'];
     	
        
        

		$this->load->view( 'includes/doctype',$data );
		$this->load->view( 'includes/meta_file',$data );
		$this->load->view( 'includes/allcss',$data );
		$this->load->view( 'includes/analytics_file',$data );
		$this->load->view( 'includes/header',$data ); 

		$this->load->view( 'contactus',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

		}


		public function save(){ 
     	 
         $post = $this->input->post();
         $post = $this->security->xss_clean($post);
         $post['domainid'] = DOMAINID;
   
         $url = base_url('api/Contactusquery');
         $curl = curl_apis( $url,'POST',$post ); 
         if( $curl['status'] ){
         	$this->session->set_flashdata( $curl['message'] ); 
         }else if( !$curl['status'] ){
         	$this->session->set_flashdata( $curl['message'] ); 
         }
         
          
         redirect( base_url('contact-us.php') );


		}
	
}
?>