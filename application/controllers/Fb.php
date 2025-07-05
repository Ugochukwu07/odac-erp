<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fb extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		} 

     public function index(){ 
       	$data = array();
        $post =  $this->input->post(); 
        if(!empty($post)){
         $reqid = ($post['vall']);
         $where['id'] = $reqid;
         $fetch = $reqid ? $this->c_model->getSingle('pt_urlsortner', $where ,'id,payload') : [];
         $req = $fetch['payload'] ? base64_decode($fetch['payload']):'';
         $req = json_decode($req,true);
        }



        $data['fare'] = $req;
        
       $triptype = $req['triptype'];
       if($triptype == 'selfdrive'){
        $loadpage = 'farebreakup-selfdrive';
       }else if($triptype == 'bike'){
        $loadpage = 'farebreakup-bike';
       }else if($triptype == 'outstation'){
        $loadpage = 'farebreakup';
       }else if($triptype == 'monthly'){
        $loadpage = 'farebreakup-monthly';
       }else{
         $loadpage = 'farebreakup-monthly';  
       }

       $this->load->view($loadpage,$data);
     }	
}
?>