<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Addbanner extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
	     $this->pagename = 'Addbanner';
	     $this->table = 'pt_uploads';
     }	


  public function index() { 

  	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return='.$currentpage ) );
  	}
  	/*check domain end*/ 

	$data['posturl'] = adminurl($this->pagename.'/uploads');

	$table = $this->table;
    $id = $this->input->get('id') ? $this->input->get('id') : '';
	 
	
	$data['title'] = 'Upload Banner';

	$data['id'] = '';
	$data['oldimage'] = '';
	$data['status'] = 'yes';
	$data['usertype'] = 'mobile';

	if( $id ){
     $old_dta = $this->c_model->getSingle($table,['md5(id)'=>$id,'documenttype'=>'BN'],'*');
     $data['id'] = $old_dta['id'];
	 $data['oldimage'] = $old_dta['documentorimage'];
	 $data['status'] = $old_dta['status'];
	 $data['usertype'] = $old_dta['usertype'];
	}
	 

   
	  _view( 'addbanner', $data );
	  
   }


 public  function uploads(){
 	$post = $this->input->post();

        $oldimage = $post['oldimage'];
        $usertype = $post['usertype'];

        /*image upload script start here */
		 if( isset($_FILES['userfile']['name'])){
			  if (!is_dir('uploads')) { mkdir('./uploads', 0777, true);}
			  
			    $config['upload_path'] 	 = './uploads/';  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['remove_spaces'] = TRUE;
           		$config['file_name']  = 'BN_'.date('YmdHis').'.'. pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);;  
                $this->load->library('upload', $config);  
                if(!$this->upload->do_upload('userfile'))  
                {  
                     $message = $this->upload->display_errors();  
					 $uploadstatus = false;
                }  
                else  
                {  
                     $data = $this->upload->data(); 
					 $postimage = $data["file_name"];
                     $configg['image_library'] = 'gd2';  
                     $configg['source_image'] = './uploads/'.$data["file_name"];  
                     $configg['create_thumb'] = false;  
                     $configg['maintain_ratio'] = true;  
                     $configg['quality'] = '100%'; 
                     if($usertype == 'mobile'){
                     $configg['width'] = 500;  
                     $configg['height'] = 300;
                     } 
                       
                     $configg['new_image'] = './uploads/'.$data["file_name"];  
					 $this->load->library('image_lib', $configg);  
                     $this->image_lib->resize(); 
                     $this->image_lib->clear(); 
					 $uploadstatus = true; 
                }  
				
			 /*image upload script start here */
			  
	if (!empty($uploadstatus) && ($uploadstatus == true) && !empty($_FILES['userfile']['name']) && !empty($oldimage) ){
			$deletimagepath = ("uploads/".$oldimage."");
	        if(is_file($deletimagepath) && file_exists($deletimagepath)){ 
	        	$unlink = @unlink( $deletimagepath ); }
			   }
		 }



		$id = $post['id'];

		 
	    $spost['tableid'] = checkdomain('domainid');
	    $spost['usertype'] = $usertype;
	    $spost['documentorimage'] = $postimage;
	    $spost['documenttype'] = 'BN';
	    $spost['uploaddate'] = date('Y-m-d H:i:s');
	    $spost['add_by'] = 'NA';
	    $spost['verifystatus'] = 'yes';
	    $spost['status'] = $post['status']; 

		$spost = $this->security->xss_clean($spost);
		
		$upwh = null;
		if( $id ){
			$upwh['id'] = $id;
		} 
		 
		 
		$update = $this->c_model->saveupdate( $this->table , $spost, NULL, $upwh );
		
		
		if( $update && $id ){
		$this->session->set_flashdata('success',"Banner uploaded successfully!");
		redirect( adminurl( $this->pagename.'/?id='.md5($id)));
		
		}else if( $update && !$id){ 
		$this->session->set_flashdata('success',"Banner uploaded successfully!");
		redirect( adminurl( $this->pagename )) ;
		  
		}else if( !$update ){
		$this->session->set_flashdata('error',"Some error Occured!");
		redirect( adminurl( $this->pagename )) ;
		}
		
		
	 
 } 
   
   
  
	
}
?>