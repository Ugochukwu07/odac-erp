<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){ 
     	$data = [];
        $getdata = [];


        $post['id'] = NULL;
        $post['pagetype'] = 'cms';
        $post['pageurl'] = 'reservation.html';
        $post['domainid'] = DOMAINID;
        if($return = $this->session->userdata('adminbooking') ){  
              $post['domainid'] = $return['domainid']; ;
        } 
        
       // $apiurl = base_url('api/cmsdata'); 
       // $getdata = curl_apis($apiurl,'POST', $post );  
        $data['metadescription'] = '';
        $data['metasummary'] = '';
        $data['metakeywords'] = '';
        $data['title'] = '';
        $data['heading'] = '';
        $data['description'] = '';
        $data['list'] = [];
        $data['terms'] = [];


        $data['tab'] = '';
        $data['subtab'] = '';
        $data['source'] = ''; 
        $data['sourcecityname'] = ''; 
        $data['destination'] = '';
        $data['pickdatetime'] = '';
        $data['dropdatetime'] = '';
        $data['days'] = '';



        if($get = $this->input->get()){ 

       $data['tab'] = isset($get['tabdata'])?$get['tabdata']:'';
       $data['subtab'] = isset($get['mode'])?$get['mode']:'';
       $data['source'] = isset($get['sourcecity'])?$get['sourcecity']:''; 
       $data['sourcecityname'] = '';
       if( !empty($data['source'])){
       $sourcearr =$this->c_model->getSingle('pt_city',['id'=>$data['source']],'cityname');
       $data['sourcecityname'] = $sourcearr['cityname'];
       } 
       $data['destination'] =isset($get['destinationCity'])?$get['destinationCity']:'';
       $data['pickdatetime'] = isset($get['pickdatetime'])?$get['pickdatetime']:'';
       $data['dropdatetime'] = isset($get['dropdatetime'])?$get['dropdatetime']:'';
       $data['days'] = getdays($data['pickdatetime'],$data['dropdatetime']);


       /*prepare data for search start*/
       $url = API_PATH.'api/customer/searchvehicle';
       $method = 'POST';
       $postdata['tab'] = isset($get['tabdata'])?$get['tabdata']:'';
       $postdata['subtab'] = isset($get['mode'])?$get['mode']:'';
       $postdata['source'] = isset($get['sourcecity'])?$get['sourcecity']:''; 
       $postdata['destination'] =isset($get['destinationCity'])?$get['destinationCity']:'';
       $postdata['pickdatetime'] = isset($get['pickdatetime'])?$get['pickdatetime']:'';
       $postdata['dropdatetime'] = isset($get['dropdatetime'])?$get['dropdatetime']:'';
       
       if($postdata['subtab'] == 'multicity'){
        $via = isset($get['tocityvia'])?$get['tocityvia']:'';
            if(!empty($via)){
                $via = implode('|', $via);
                $postdata['destination'] = $postdata['destination'].'|'.$via;
            } 
       }

       /*store uniqueid for browser visit */ 
       if(empty($this->session->userdata('cleanuid'))){ 
        $postdata['cleanuid'] = $this->session->set_userdata(['cleanuid'=>date('YmdHis').rand(100,999)]);
       }else{ $postdata['cleanuid'] = $this->session->userdata('cleanuid'); }
    
//      echo $url;    
//   echo json_encode( $postdata ); exit;
           $buffer = curl_apis( $url, $method, $postdata );
           if(!empty($buffer['status'])){
            $data['list'] = !empty($buffer['data'])?$buffer['data']:[];
            $data['terms'] = !empty($buffer['terms'])?$buffer['terms']:[];
           }
// echo '<pre>';
//             print_r($buffer); //exit;
  
  
        //set meta title and description start script
        $titleName = "Book A Cab from ".$data['sourcecityname'].' to '.$data['destination'].' for '.$postdata['tab'];
        
        $data['metadescription'] = $titleName;
        $data['metasummary'] = $titleName;
        $data['metakeywords'] = $titleName;
        $data['title'] = $titleName;
        
        //set meta title and description start script

        }
        /*prepare data for search end*/
 

//exit;


        $this->load->view( 'includes/doctype',$data );
        $this->load->view( 'includes/meta_file',$data );
        $this->load->view( 'includes/allcss',$data );
        $this->load->view( 'includes/analytics_file',$data );
        $this->load->view( 'includes/header',$data ); 
 

		$this->load->view( 'reservation',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

		}
	
}
?>