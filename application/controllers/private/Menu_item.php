<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_item extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();  
	     adminlogincheck();
	     $this->pagename = 'menu_item';
		 $this->table = 'pt_menu_list';
      }	


 


public function index(){

	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return='.$this->pagename ) );
  	}
  	/*check domain end*/ 

	$this->createMenuFile();

  	
	$data = []; 
	$data['pagename'] = $this->pagename;  

	$data['posturl']  = adminurl( $this->pagename.'/saverecord' );
	$data['id'] =  '';
	$data['menu_name'] =  ''; 
	$data['parent_id'] =  ''; 
	$data['menu_level'] =  ''; 
	$data['menu_url'] =  ''; 
	$data['status'] =  'yes'; 


	$post = $this->input->post()?$this->input->post():$this->input->get(); 
	$id =  !empty($post['id']) ?  trim($post['id']) : false;   
	$data['title'] = 'Add/Edit Menu'; 	 
	$data['subtitle'] =  ''; 


    if(!empty($id)){
    	$keys = '*';
    	$plist = $this->c_model->getSingle( $this->table ,['md5(id)'=>$id], $keys );  
		$data['id'] 		=  $plist['id'];
		$data['menu_name'] 	=  ucwords( strtolower($plist['menu_name']) );
		$data['parent_id'] 	=  $plist['parent_id'];    
		$data['menu_level'] =  $plist['menu_level'];  
		$data['menu_url'] 	=  strtolower($plist['menu_url']);    
		$data['status'] 	=  $plist['status']; 
    } 

    $data['placeapi'] = 'no';

    $data['menu_list'] =  get_dropdownsmulti( $this->table ,['menu_level <'=>'3'],'id','menu_name',' Menu Name---');
    $data['level_list'] = ['1'=>'Level 1','2'=>'Level 2','3'=>'Level 3'];

    _view( strtolower( $this->pagename ), $data );
}





public function saverecord(){
	$post = $this->input->post(); 

	$id = !empty($post['id'])?$post['id']:'';
	$where = null; 

	$check  = [];
	$save   = []; 
	
	$save['menu_name'] 		=  ucwords( strtolower(trim($post['menu_name'])) );
	$save['menu_url'] 		=  strtolower( trim($post['menu_url']) ); 
	$check 					=  $save;   
	$save['parent_id'] 		=  (int) trim($post['parent_id']); 
	$save['menu_level'] 	=  trim($post['menu_level']); 
	$save['status'] 		=  trim($post['status']);
	
	 

	if(!empty($id)){
		$where['id'] = $id;
		$check =  null;
	}  

 
	$insertid = $this->c_model->saveupdate( $this->table , $save, $check, $where ); 
	$this->createMenuFile();

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


function getlavel(){
	$post = $this->input->post();
	$getdata = $this->c_model->getSingle( $this->table ,['id'=>$post['id']],'menu_level,id');
	$level = 0;

	if(!empty($getdata)){
		$level = $getdata['menu_level'];
	}
	echo $level + 1;
}

function createMenuFile(){
    $getdata = $this->c_model->getAll( $this->table );
	$file_path = 'uploads/menu/';
	if(!is_dir($file_path)){ mkdir($file_path,777,true);}
	$filename = 'menulist.txt';
	$full_filepath = $file_path.$filename;
 		if(!empty($getdata)){
 			@unlink( $full_filepath );
			file_put_contents($full_filepath, json_encode($getdata) );
 		}
 		return $getdata;
}




}?>