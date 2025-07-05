<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Addpage extends CI_Controller{
	
	  function __construct() {
         parent::__construct(); 
		 $this->load->helper('admin_helper');
		 $this->load->model('Admin_model','ad_model');
		 $this->load->library('form_validation'); 
	     adminlogincheck();
      }
	


  public function index() {
	  
	$table = 'cms';
	$currentpage = 'Addpage';
	$data['posturl'] = $currentpage;
    $id = $this->input->get('id') ? $this->input->get('id') : '';
	 
	
	$data['title'] = ( !empty($id) ? 'Update' : 'Add') .' Page';
	
	
	 if($this->input->get('delId')){
	 	$image = $this->input->get('img') ? $this->input->get('img') : '';
	 	$image = 'uploads/'.$image;
	 	if(file_exists($image) && is_file($image) && @unlink($image)){ echo true;} 
	   $this->ad_model->delete($table,array('md5(id)'=>$this->input->get('delId')));
	   $this->session->set_flashdata('success',"Your data has been deleted successfully!");
	   redirect(adminurl('Viewpage'));
	 }
	 
	
	 
	 
	    $data['metatitle'] = ""; 
		$data['metadescription'] = ""; 
		$data['metakeyword'] = ""; 
		$data['titleorheading']="";
		$data['content'] = ""; 
		$data['pagetype'] = ""; 
		$data['subject'] = ""; 
		$data['tableid']="";
		$data['cityid'] = ""; 
		$data['days'] = ""; 
		$data['nights'] = ""; 
		$data['distance']="";
		$data['coveredcity'] = ""; 
		$data['oldprice'] = ""; 
		$data['newprice'] = ""; 
		$data['cabname']="";
		$data['status'] = "yes";
		$data['pageurl'] = ""; 
		$data['image'] = "";
		$data['oldimage'] = ""; 
		$data['id'] = '';

		$data['id'] = $id; 
	
	
	//if( $this->input->post() == true ){  
	
	
	
	
	 if( !empty($id ))
	 {
	 $corpo = $this->ad_model->getSingle($table, array( 'id'=>$id ) );
	    $data['metatitle'] = $corpo['metatitle'];
		$data['metadescription'] = $corpo['metadescription'];
		$data['metakeyword'] = $corpo['metakeyword']; 
		$data['titleorheading'] = $corpo['titleorheading'];
		$data['content'] = $corpo['content']; 
		$data['pagetype'] = $corpo['pagetype']; 
		$data['subject'] = $corpo['subject'];
		$data['tableid'] = $corpo['tableid'];
		$data['cityid'] = $corpo['cityid']; 
		$data['days'] = $corpo['days']; 
		$data['nights'] = $corpo['nights']; 
		$data['distance'] = $corpo['distance'];
		$data['coveredcity'] = $corpo['coveredcity']; 
		$data['oldprice'] = $corpo['oldprice']; 
		$data['newprice'] = $corpo['newprice']; 
		$data['cabname'] = $corpo['cabname'];
		$data['status'] = $corpo['status']; 
		$data['pageurl'] = $corpo['pageurl'];
		$data['image'] = $corpo['image']; 
		$data['oldimage'] = $corpo['image']; 
		$data['id'] = $corpo['id']; 
	 }
	 
	 $this->form_validation->set_rules('pagetype','Select pagetype','required');
	 $this->form_validation->set_rules('titleorheading','Select titleorheading','required');
	 $this->form_validation->set_rules('pageurl','pageurl is blank','required');
	 $this->form_validation->set_rules('content','Select content','required');
	 $this->form_validation->set_rules('status','Select status','required');
	 
	 if($this->form_validation->run() == false){ 
		$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
	 }
		
	 
	 if( $this->form_validation->run() != false){
		 
		$corpo = $this->input->post();

		$oldimage = $corpo['oldimage'];
		 /*image upload script start here */
		 if( isset($_FILES['userfile']['name'])){
			  if (!is_dir('uploads')) { mkdir('./uploads', 0777, true);}
			  
			    $config['upload_path'] = './uploads/';  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
                $this->load->library('upload', $config);  
                if(!$this->upload->do_upload('userfile'))  
                {  
                     $message = $this->upload->display_errors();  
					 $uploadstatus = false;
                }  
                else  
                {  
                     $data = $this->upload->data(); 
					 $new_image_name = $data["file_name"];
                     $config['image_library'] = 'gd2';  
                     $config['source_image'] = './uploads/'.$data["file_name"];  
                     $config['create_thumb'] = FALSE;  
                     $config['maintain_ratio'] = true;  
                     $config['quality'] = '100%';  
                     //$config['width'] = 200;  
                     //$config['height'] = 200;  
                     $config['new_image'] = './uploads/'.$data["file_name"];  
					 $this->load->library('image_lib', $config);  
                     $this->image_lib->resize(); 
					 $uploadstatus = true; 
                }  
				
			 /*image upload script start here */
			  
	if (!empty($uploadstatus) && ($uploadstatus == true) && !empty($_FILES['userfile']['name']) && !empty($oldimage) ){
			$deletimagepath = ("uploads/".$oldimage."");
	        if(is_file($deletimagepath) && file_exists($deletimagepath)){ $unlink = unlink( $deletimagepath ); }
			   }
			 
		 }

		 
		$spost['metatitle'] = $corpo['metatitle'];  
		$spost['metadescription'] = isset($corpo['metadescription']) ? $corpo['metadescription'] : '';  
		$spost['metakeyword'] = isset($corpo['metakeyword']) ? $corpo['metakeyword'] : '';
		$spost['titleorheading'] = isset($corpo['titleorheading']) ? $corpo['titleorheading'] : '';
		$spost['content'] = isset($corpo['content']) ? $corpo['content'] : '';  
		$spost['pagetype'] = isset($corpo['pagetype']) ? $corpo['pagetype'] : '';
		$spost['subject'] = isset($corpo['subject']) ? $corpo['subject'] : '';
		$spost['tableid'] = isset($corpo['tableid']) ? $corpo['tableid'] : '';  
		$spost['cityid'] = isset($corpo['cityid']) ? $corpo['cityid'] : '';
		$spost['days'] = isset($corpo['days']) ? $corpo['days'] : ''; 
		$spost['nights'] = isset($corpo['nights']) ? $corpo['nights'] : '';  
		$spost['distance'] = isset($corpo['distance']) ? $corpo['distance'] : '';
		$spost['coveredcity'] = isset($corpo['coveredcity']) ? $corpo['coveredcity'] : '';
		$spost['oldprice'] = isset($corpo['oldprice']) ? $corpo['oldprice'] : '';
		$spost['newprice'] = isset($corpo['newprice']) ? $corpo['newprice'] : '';
		$spost['cabname'] = isset($corpo['cabname']) ? $corpo['cabname'] : '';
		$spost['pageurl'] = !empty($corpo['pageurl']) ? seoUrl($corpo['pageurl']) : '';
		$spost['image'] = isset($new_image_name) ? $new_image_name : $oldimage; 
		


		$spost['status'] = isset($corpo['status']) ? $corpo['status'] : 'yes'; 

        if(empty($corpo['id'])){
		$spost['add_datetime'] = date('Y-m-d H:i:s');
		}   
		
		
		$id = !empty($corpo['id']) ? $corpo['id'] : NULL ;
		$postwhere = !empty($id) ? array('id'=> $id) : NULL ; 
		
		
		$checkpost['pageurl'] = seoUrl($corpo['pageurl']); 
		
		$checkitem = $this->ad_model->countitem( $table, $checkpost );
		
		
		if( !empty($id)){ 
		$ststus = $this->ad_model->saveupdate($table,$spost, NULL, $postwhere, NULL );	
		$this->session->set_flashdata('success',"Your data has been updated successfully!");
		redirect( adminurl($currentpage.'/index?id='.$id));
		
		}else if( empty($checkitem) && empty($id)){
		$ststus = $this->ad_model->saveupdate($table,$spost, NULL, NULL, NULL );
		$this->session->set_flashdata('success',"Your data has been added successfully!");
		redirect( adminurl( $currentpage )); 
		}else if( !empty($checkitem)){
		$this->session->set_flashdata('error',"Data is already exist please check the details!");
		redirect( adminurl( $currentpage ));
		}
		
		
	
	 }

	  
	  _view( 'addpage', $data );
	  
   }
   
   
  public function checkposturl(){
    $table = 'cms';
    $url = $this->input->get('pageurl');
    $checkpost['pageurl'] = $url; 
	echo $checkitem = $this->ad_model->countitem( $table, $checkpost );
  } 
  
	
}
?>