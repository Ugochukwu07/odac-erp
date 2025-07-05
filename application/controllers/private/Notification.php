<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {
   var $pagename;
  var $table;
    public function __construct(){
		parent::__construct();
		$this->load->library('session'); 
		$this->pagename = 'notification';
		$this->table = 'dt_notification';
	}


public function index(){
    $mconfig = websetting();  
	$data = [];
	$data['mconfig'] = $mconfig;
	$data['pagename'] = $this->pagename;  
	

	$data['posturl'] =  base_url( ADMINPATH ).$this->pagename.'/saverecord';
	$data['id'] =  '';
	$data['push'] =  '';
	$data['imagename'] =  '';
	$data['usertype'] =  ''; 
	$data['notititle'] =  '';
	$data['description'] =  ''; 
	$data['status'] =  'yes'; 


    $post = $this->input->post()?$this->input->post():$this->input->get(); 
    $id =  !empty($post['id']) ?  trim($post['id']) : false;   
    $data['title'] = 'Add/Edit Notification'; 	 
	$data['subtitle'] =  ''; 
	$data['push'] =  !empty($post['push']) ?  trim($post['push']) : '';  


    if(!empty($id)){
    	$plist = $this->cm->getSingle( $this->table ,['md5(id)'=>$id],' * ');  
		$data['id'] =  $plist['id'];
		$data['imagename'] 	=  $plist['imagename'];
		$data['usertype'] 	=  $plist['usertype'];
		$data['notititle'] 	=  $plist['title']; 
		$data['description']=  $plist['description']; 
		$data['status'] 	=  $plist['status'];  
    }




	$cssjs['datatable'] =  'no'; 
	$cssjs['download'] =  'no';
	$cssjs['editor'] =  'no';
	$cssjs['select2'] =  'no';
	$data['min'] = 'no'; 

    adminview( strtolower( $this->pagename ), $data, $cssjs );
}





public function saverecord(){
	$post = $this->input->post();  

	$filename = !empty($_FILES['file']['name'])?$_FILES['file']['name']:null;

	$oldimage = !empty($post['oldimage'])?$post['oldimage']:''; 

	$id = !empty($post['id'])?$post['id']:'';
	$where = null; 

	$check  = [];
	$save 	= []; 
	  
	$title 		 = str_replace("'", '`', ucwords( trim($post['notititle']) ) ) ; 
	$save['title'] 			= $title; 
	$save['usertype'] 		= strtolower( trim($post['usertype']) ); 
	$check 					=  $save; 
	$description = str_replace("'", '`', ucwords( trim($post['description']) ) ) ;
	$save['description'] = $description; 
	
	$save['status'] 		=  trim($post['status']); 
	$save['modify_date']	=  date('Y-m-d H:i:s'); 

	if(empty($id)){
	$save['add_date'] 		= date('Y-m-d H:i:s');
	} 

	if(!empty($id)){
	$where['id'] = $id;
	$this->cm->delete('dt_notification_list',['notification_id'=>$id]);
	$check =  null;
	} 

 
	$insertid = $this->cm->saveupdate( $this->table , $save, $check, $where );

	 

    /*image upload script start here */ 
    if( $insertid || $id ){
		$filepath = 'writeable/uploads/';
		$foldername = 'writeable/uploads'; 
		$target_file = $filepath.$filename;
		$ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
		$newfile = date('YmdHis').'_avatar.'.$ext;
		$imgdata = $this->upload_panfile('file',$foldername,$filename,$newfile); 
		if($imgdata['status'] && $imgdata['newfilename']){
	     $deleteimage = $filepath.$oldimage;
	     if(file_exists($deleteimage) && $oldimage){ @unlink($deleteimage);}
	     $save = []; $where = [];
	     $save['imagename'] = $imgdata['newfilename'];
	    
			$where['id'] = $id ? $id : $insertid; 
	        $imgupdate = !empty($where['id'])?$this->cm->saveupdate( $this->table ,$save,null,$where):'';
		}
    }
	/*image upload script end here */


	 
	if(!$id && $insertid){  
		$this->session->set_flashdata('success','Data added successfully!');
		redirect( ADMINPATH.$this->pagename.'?id='.md5($insertid).'&push=yes' );
	}else if($id){
		$this->session->set_flashdata('success','Data updated successfully!');
		redirect( ADMINPATH.$this->pagename.'?id='.md5($id).'&push=yes' );
	}else if(!$insertid){
		$this->session->set_flashdata('error','Duplicate Entry!');
		redirect( ADMINPATH.$this->pagename );
	}
	 
}



private function upload_panfile($file,$folder,$filename,$newfile){
				$response = [];
				$response['status'] = false;
				$response['newfilename'] = '';
				$response['message'] = '';
				$new_image_name = '';

				if(!is_dir($folder)){ mkdir($folder,0777,true); }  

                $config['upload_path'] = './'.$folder.'/';  
                $config['allowed_types'] = 'jpeg|jpg|png';  
                $config['overwrite'] = TRUE;  
                $config['file_name'] = $newfile;  

                $this->load->library('upload', $config);  
                if(!$this->upload->do_upload($file)){  
                     $message = $this->upload->display_errors();   
                     $response['status'] = false;
                     $response['message'] = strip_tags($message);  
                }else{  
                     $data = $this->upload->data();  
					 $response['status'] = true;
					 $response['newfilename'] = $data["file_name"]; 
					 $response['message'] = 'uploaded'; 
                }  
                
              return $response; 
         }  


public function pushnotification(){
 	$mconfig = websetting();
 	$this->load->helper('pushnotification_helper');
	$post = $this->input->post()?$this->input->post():$this->input->get();
	
	$id = $post['id'];
	$start = $post['start'];
	$limit = $post['limit'];

	if(!$id){
  		echo 'id is blank'; exit;
	}

	$offerdata = $this->cm->getSingle('dt_notification',['id'=>$id],'*'); 

	$usertype = $offerdata['usertype'];

	$data = [];
	$data['status'] 	= false;
	$data['id'] 		= (string)$id;
	$data['start'] 		= (string)($start + 1);
	$data['limit'] 		= (string)$limit;
	$data['ids'] 		= '';

	$serverkey = FIREBASE_API_KEY_PARTNER;
    if($usertype == 'user'){
	$serverkey = FIREBASE_API_KEY;
    }
	

	 
	$keys = '';
	$tablename = 'dt_astrologer';
	if($usertype == 'user'){
	$tablename = 'dt_users';
	}
	
	$where = [];
	$where['fcm_id !='] 	 = ''; 
	$where['profile_status'] = 'active';
	$keys = 'id,fcm_id';
	
	 
	
	$limit 				= $limit;
	$start 				= $start * $limit;
	$orderby 			= 'ASC';
	$orderbykey			= 'id';
	$whereor 			= null;
	$whereorkey 		= null;
	$like 				= null;
	$likekey 			= null;
	$getorcount 		= 'get';
	$infield 			= null;
	$invalue 			= null;
	$keys 				= $keys;
	$groupby 			= null;

	$res = $this->cm->getfilter($tablename,$where,$limit,$start,$orderby,$orderbykey,$whereor,$whereorkey,$like,$likekey,$getorcount,$infield,$invalue,$keys,$groupby );

	$msgarray = [];
	$msgarray['title'] 		= ucwords($offerdata['title']);
	$msgarray['message'] 	= !empty($offerdata['description'])?$offerdata['description']:$offerdata['title'];
	$msgarray['image'] 		= $offerdata['imagename'] ? UPLOADS.$offerdata['imagename']: UPLOADS.$mconfig['logo']; 
	 
 

	if(!empty($res)){
	$data['status'] 	= true;
	$deviceid = '';
	foreach ($res as $key => $value) {
		if(!empty($value['fcm_id']) && (strlen($value['fcm_id']) > 30 )){
			$deviceid .= $value['fcm_id'].',';
				$save = [];
		 	  	$save['user_id'] = $value['id'];
		 	  	$save['user_type'] = $usertype;
		 	  	$save['notification_id'] = $id;
		 	  	$save['title'] = $msgarray['title'];
		 	  	$save['chat_content'] = $msgarray['message'];
		 	  	$save['image_path'] = $offerdata['imagename'];
		 	  	$save['is_seen'] = 0;
		 	  	$save['add_date'] = date('Y-m-d H:i:s');
		 	  	$this->cm->saveupdate('dt_notification_list',$save);
		} 
	}
	$firebaseids = rtrim($deviceid,','); 

	/*send notification start script*/  
		$sendnoti = pushnotifications($firebaseids,$msgarray, $serverkey );  
	/*send notification end script*/ 

	}



	/*send notification for onesignal server start script*/   
	//$response =  $this->sendMessage($msgarray['title'],$msgarray['image'],$msgarray['message'] ); 
	//$data['status'] = false;
	/*send notification onesignal server end script*/
	

	/*save records according to user wise start*/
	// $user_list = $this->cm->getAll('dt_users',null,['profile_status'=>'active'],'id');
	// if(!empty($user_list)){
	// 	 foreach ($user_list as $key => $value) {
	// 	 	  $save = [];
	// 	 	  $save['user_id'] = $value['id'];
	// 	 	  $save['notification_id'] = $id;
	// 	 	  $save['is_seen'] = 0;
	// 	 	  $this->cm->saveupdate('dt_notification_list',$save);
	// 	 }
	// }
	

	echo json_encode($data);
}	


function sendMessage($title,$logo,$msg){
    $content = array(
        "en" => $title
        );

    $fields = array(
        'app_id' => " ",
        'included_segments' => array('All'),
        'data' => array('foo'=>$msg),
        'large_icon' =>$logo,
        'contents' => $content
    );

    $fields = json_encode($fields); 

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic  '));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
 


 
}?>