<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Addvehicle extends CI_Controller{
	
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
         $this->load->model('Common_model', 'c_model');
         $this->load->library('form_validation');
         $this->load->library('session');
         $this->load->library('upload');
         $this->load->library('image_lib');
     }	


  public function index() {
	 
	$currentpage = 'Addvehicle'; 
	$data['posturl'] = adminurl($currentpage.'/');

	$table = 'pt_vehicle_model';
    $id = $this->input->get('id') ? $this->input->get('id') : '';
	 
	
	$data['title'] = ( !empty($id) ? 'Update' : 'Add') .' Model Name ';
	
	
	 
	    $data['model'] = ""; 
	    $data['catid'] = "";  
		$data['status'] = "yes"; 
		$data['image'] = "";
		$data['thumbnail'] = ""; 
		$data['id'] = $id; 
		 
	
		
	
	 if( !empty($id ))
	 {
	    $dbdistpost = $this->c_model->getSingle($table, array( 'id'=>$id ) );
	    $data['id'] = $dbdistpost['id']; 
		$data['model'] = $dbdistpost['model'];  
	    $data['catid'] = $dbdistpost['catid'];   
		$data['status'] = $dbdistpost['status']; 
		$data['image'] = $dbdistpost['image'];   
	 }


	 	 
	$this->form_validation->set_rules('catid','Select Category name ','required');
	$this->form_validation->set_rules('model','Enter model name','required'); 

	if($this->form_validation->run() == false){ 
	$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
	}
		
	 


	 if( $this->form_validation->run() != false){
		 
		$dbdistpost = $this->input->post();

        $oldimage = $dbdistpost['oldimage'];

        /*image upload script start here */
		 if( isset($_FILES['userfile']['name'])){
			  if (!is_dir('uploads')) { mkdir('./uploads', 0777, true);}
			  
			  $extension = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			  $randon_numbers = date('YmdHis');
		      $newfile = $randon_numbers.'.'.$extension; 
		      
		      if( in_array($extension,['webp']) && move_uploaded_file( $_FILES["userfile"]["tmp_name"] , "./uploads/".$newfile ) ){ 
		         $postimage = $newfile;
		         $uploadstatus = true;
		      }else{
			  
			    $config['upload_path'] = './uploads/';  
                $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';  
                $config['overwrite'] = TRUE;  
		        $config['file_name'] = $newfile; 
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
                     $config['image_library'] = 'gd2';  
                     $config['source_image'] = './uploads/'.$data["file_name"];  
                     $config['create_thumb'] = false;  
                     $config['maintain_ratio'] = true;  
                     $config['quality'] = '100%';  
                     //$config['width'] = 'auto';  
                     //$config['height'] = 'auto';  
                     $config['new_image'] = './uploads/'.$data["file_name"];  
					 $this->load->library('image_lib', $config);  
                     $this->image_lib->resize(); 
					 $uploadstatus = true; 
                }  
		      }
				
			 /*image upload script start here */
			  
	if (!empty($uploadstatus) && ($uploadstatus == true) && !empty($_FILES['userfile']['name']) && !empty($oldimage) ){
			$deletimagepath = ("uploads/".$oldimage."");
	        if(is_file($deletimagepath) && file_exists($deletimagepath)){ 
	        	$unlink = @unlink( $deletimagepath ); }
			   }
		 }


		 
	    $spost['catid'] = $dbdistpost['catid'];
	    $spost['image'] = !empty($uploadstatus) ? $postimage : $oldimage ;  
		$spost['status']= isset($dbdistpost['status']) ? $dbdistpost['status'] : 'yes'; 
		$spost['model'] = $dbdistpost['model'];  
		$status = $dbdistpost['status'];  

		$spost = $this->security->xss_clean($spost);
		
		$id = !empty($dbdistpost['id']) ? $dbdistpost['id'] : NULL ;
		$postwhere = !empty($id) ? array('id'=> $id) : NULL ; 
		
		
		$checkpost['catid'] = $dbdistpost['catid'];
		$checkpost['model'] = $dbdistpost['model'];
		
		$checkitem = $this->c_model->countitem( $table, $checkpost );
		
		
		if( $id ){
		$status = $this->c_model->saveupdate( $table, $spost, NULL, $postwhere, NULL );
        log_activity('vehicle_model_updated', 'Updated vehicle model: ' . $spost['model'], $id, $table);
		$this->session->set_flashdata('success',"Data updated successfully!");
		redirect( adminurl( $currentpage.'/?id='.$id));
		
		}else if( empty($checkitem) && empty($id)){
		$status = $this->c_model->saveupdate( $table, $spost, NULL, NULL, NULL );
        if($status) {
            log_activity('vehicle_model_added', 'Added new vehicle model: ' . $spost['model'], $status, $table);
        }
		$this->session->set_flashdata('success',"Data added successfully!");
		redirect( adminurl( $currentpage )) ;
		  
		}else if( !empty($checkitem)){
		$this->session->set_flashdata('error',"Data is already exist!");
		redirect( adminurl( $currentpage )) ;
		}
		
		
	
	 }
 
      

   
	  _view( 'addvehicle', $data );
	  
   }
   
   
  
	
}
?>