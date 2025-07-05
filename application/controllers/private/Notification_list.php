<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_list extends CI_Controller {
    var $pagename;
    var $table;
    public function __construct(){
		parent::__construct();
		$this->load->library('session'); 
		$this->pagename = 'notification_list';
		$this->table = 'dt_notification';
	}


public function index(){
    $mconfig = websetting();  
	$data = [];
	$data['mconfig'] 	= $mconfig; 
	$data['pagename'] 	= $this->pagename; 
	$data['title'] 		= 'Notification Listing'; 	 
	$data['subtitle'] 	= '';  




    $keys = 'id,title,imagename,status, DATE_FORMAT(add_date,"%d-%b-%Y %r") as add_date, DATE_FORMAT(modify_date,"%d-%b-%Y %r") as modify_date,usertype  ';  
    
    $getdata = array();
    $getdata = $this->cm->getAll( $this->table ,'id DESC', null, $keys );  
 
 
	$data['list'] = !empty($getdata) ? $getdata : [];
	$cssjs['datatable'] =  'yes'; 
	$cssjs['download'] =  'no';
	$cssjs['editor'] =  'no';
	$data['min'] = 'no';

    adminview( strtolower($this->pagename), $data, $cssjs );
}


public function deleterecord(){
	$post = $this->input->post(); 
	$filepath = 'writeable/uploads/';

	$catid = !empty($post['id'])?$post['id']:'';
	$oldimage = !empty($post['oldimage'])?$post['oldimage']:'';
	$delete = $this->cm->delete( $this->table ,['id'=>$catid]);
	$this->cm->delete('dt_notification_list' ,['notification_id'=>$catid]);
	if($delete){
		 $deleteimage = $filepath.$oldimage;
         if(file_exists($deleteimage) && $oldimage){ @unlink($deleteimage);}
	}

	$output['status'] = true; 
	$output['message'] = 'Data Deleted successfully!';
	$output['type'] = 'success'; 
	echo json_encode( $output );

}             

}?>