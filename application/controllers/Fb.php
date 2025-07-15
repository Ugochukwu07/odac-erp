<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Common_model $c_model
 */
class Fb extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Common_model', 'c_model');
		} 

     public function index(){ 
       	$data = array();
        $post =  $this->input->post(); 
        $req = array();
        
        if(!empty($post) && isset($post['vall'])){
         $reqid = ($post['vall']);
         $where['id'] = $reqid;
         $fetch = $reqid ? $this->c_model->getSingle('pt_urlsortner', $where ,'id,payload') : [];
         
         if($fetch && isset($fetch['payload']) && !empty($fetch['payload'])){
             $req = base64_decode($fetch['payload']);
             $req = json_decode($req, true);
             
             // Ensure $req is an array
             if(!is_array($req)){
                 $req = array();
             }
         }
        }

        $data['fare'] = $req;
        
        // Set default triptype if not available
        $triptype = isset($req['triptype']) ? $req['triptype'] : 'selfdrive';
        
        if($triptype == 'selfdrive'){
            $loadpage = 'farebreakup-selfdrive';
        }else if($triptype == 'bike'){
            $loadpage = 'farebreakup-bike';
        }else if($triptype == 'outstation'){
            $loadpage = 'farebreakup';
        }else if($triptype == 'monthly'){
            $loadpage = 'farebreakup-monthly';
        }else{
            $loadpage = 'farebreakup-selfdrive';  // Default to selfdrive
        }

        $this->load->view($loadpage,$data);
     }	
}
?>