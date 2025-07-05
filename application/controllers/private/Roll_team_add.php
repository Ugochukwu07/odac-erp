<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Roll_team_add extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
	     $this->pagename = 'roll_team_add';
		 $this->table = 'pt_roll_team_user';
      }	


 


public function index(){
  	  
	$data = []; 
	$data['pagename'] = $this->pagename;  

	$data['posturl'] =  adminurl( $this->pagename.'/saverecord' );
	$data['id'] =  '';
	$data['fullname'] =  ''; 
	$data['mobile'] =  ''; 
	$data['password'] =  ''; 
	$data['cityids'] =  []; 
	$data['menuids'] =  ['1']; 
	$data['status'] =  'yes'; 


	$post = $this->input->post()?$this->input->post():$this->input->get(); 
	$id =  !empty($post['id']) ?  trim($post['id']) : false;   
	$data['title'] = 'Add/Edit Team Member'; 	 
	$data['subtitle'] =  ''; 


    if(!empty($id)){
    	$keys = '*';
    	$plist = $this->c_model->getSingle( $this->table ,['md5(id)'=>$id], $keys );  
		$data['id'] 		=  $plist['id'];
		$data['fullname'] 	=  ucwords( strtolower($plist['fullname']) );
		$data['mobile'] 	=  $plist['mobile'];    
		$data['password'] 	=  $plist['password']; 
		$data['cityids'] = !empty($plist['cityids']) ? explode(',', $plist['cityids']) :''; 
		$data['menuids'] 	=  !empty($plist['menuids']) ? explode(',', $plist['menuids']) :''; 
		$data['status'] 	=  $plist['status']; 
    } 

    $data['placeapi'] = 'no';

    $data['city_list'] =  [];
    $data['menu_list'] =  get_dropdownsmulti('pt_menu_list',['menu_level'=>1],'id','menu_name',' Menu--');

    _view( strtolower( $this->pagename ), $data );
}





public function saverecord(){
	$post = $this->input->post(); 

	$id = !empty($post['id'])?$post['id']:'';
	$where = null; 

	$check  = [];
	$save   = []; 
	  
	$save['mobile'] 		=  trim($post['mobile']); 
	$check 					=  $save;  
	$save['fullname'] 		=  trim($post['fullname']); 
	$save['password'] 		=  trim($post['password']);
	$save['en_password'] 	=  md5( trim($post['password']) );
	$save['cityids'] 	= !empty($post['cityids'])?implode(',', $post['cityids'] ):'';
	$save['menuids'] 	= !empty($post['menuids'])?implode(',', $post['menuids'] ):'';
	$save['status'] 		=  trim($post['status']);
	
	 

	if(!empty($id)){
		$where['id'] = $id;
		$check =  null;
	}

	if(empty($id)){
		$save['add_date'] = date('Y-m-d H:i:s');
	}

 
	$insertid = $this->c_model->saveupdate( $this->table , $save, $check, $where ); 
	 
	if(!$id && $insertid){  
		$this->session->set_flashdata('success','Data added successfully!');
		redirect( adminurl($this->pagename) );
	}else if($id){
		$this->session->set_flashdata('success','Data updated successfully!');
		redirect( adminurl($this->pagename).'?id='.md5($id) );
	}else if(!$insertid){
		$this->session->set_flashdata('error','Duplicate Entry!');
		redirect( adminurl($this->pagename) );
	}
	 
}




}?>