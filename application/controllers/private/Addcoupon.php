<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Addcoupon extends CI_Controller{ 

	 function __construct() {
         parent::__construct(); 
	     adminlogincheck();
	     $this->pagename = 'Addcoupon';
      } 



  public function index() {  
	 $currentpage = $this->pagename;  
	 $table = 'coupon'; 
	 $data['pagename'] = 'Coupon'; 
     $id = $this->input->get('id') ? $this->input->get('id') : ''; 
	

	$data['title'] = ( !empty($id) ? 'Update' : 'Add') .' Coupon';

	

	 

	    $data['trippackage'] = "";  
	    $data['titlename']=""; 
		$data['couponcode']="";  
		$data['cpnvalue']="";  
		$data['valuetype']=""; 
		$data['validfrom']="";
		$data['validto']="";
		$data['status']="yes";
		$data['couponimage']="";
		$data['minamount']="";
		$data['maxdiscount']="";
		$data['add_datetime']="";
		$data['add_by']="";
		$data['cityid']= "";
		$data['cpn_description']= "";

		$data['id'] = $id;   

		

	

	 if( !empty( $id )){

	    $dbcoupon = $this->c_model->getSingle($table, ['md5(id)'=>$id ] );

	    $data['trippackage'] = $dbcoupon['trippackage']; 
	    $data['titlename'] = $dbcoupon['titlename']; 
		$data['couponcode'] = $dbcoupon['couponcode'];
		$data['cpnvalue'] = $dbcoupon['cpnvalue']; 
		$data['valuetype'] = $dbcoupon['valuetype'];
		$data['validfrom'] = date('m/d/Y',strtotime($dbcoupon['validfrom']));
		$data['validto'] = date('m/d/Y',strtotime($dbcoupon['validto']));  
		$data['status'] = $dbcoupon['status']; 
		$data['couponimage'] = $dbcoupon['couponimage'];
		$data['minamount'] = $dbcoupon['minamount']; 
		$data['maxdiscount'] = $dbcoupon['maxdiscount'];
		$data['add_datetime'] = $dbcoupon['add_datetime'];
		$data['add_by'] = $dbcoupon['add_by']; 
		$data['cityid'] = $dbcoupon['cityid'];
		$data['id'] = $dbcoupon['id']; 
		$data['cpn_description']= $dbcoupon['cpn_description'];

	 }

	 
 
	 $this->form_validation->set_rules('trippackage','Select Trip Type ','required'); 
	 $this->form_validation->set_rules('couponcode','Enter coupon code ','required');	 
	 $this->form_validation->set_rules('cpnvalue','Enter coupon value ','required'); 
	 $this->form_validation->set_rules('valuetype','Select value type ','required'); 
	 $this->form_validation->set_rules('cpn_description','Coupon Description','required'); 
	 

	 if($this->form_validation->run() == false){  
		$this->session->set_flashdata('error',strip_tags( validation_errors() ) ); 
	 }

		

	 

	 if( $this->form_validation->run() != false){ 
		$post = $this->input->post(); 
		$oldimage = $post['oldimage'];  
		/*image upload script start here */

		 if( isset($_FILES['userfile']['name'])){
			  if (!is_dir('uploads')) { mkdir('./uploads', 0777, true);}
			    $config['upload_path'] = './uploads/';  
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
                $this->load->library('upload', $config);  
                if(!$this->upload->do_upload('userfile')){  
                     $message = $this->upload->display_errors(); 
                }else{  

                     $data = $this->upload->data(); 
					 $new_image_name = $data["file_name"];
                     $config['image_library'] = 'gd2';  
                     $config['source_image'] = './uploads/'.$data["file_name"]; 
                     $config['create_thumb'] = FALSE;  
                     $config['maintain_ratio'] = true;  
                     $config['quality'] = '90%'; 
                     $config['width'] = 200;  
                     $config['height'] = 200;  
                     $config['new_image'] = './uploads/'.$data["file_name"];  
					 $this->load->library('image_lib', $config);  
                     $this->image_lib->resize();
                     $this->image_lib->clear();  
                }  
 
			 /*image upload script start here */  

	       if (!empty($uploadstatus) && !empty($_FILES['userfile']['name']) && !empty($oldimage) ){
			$deletimagepath = ("uploads/".$oldimage."");
	            if(is_file($deletimagepath) && file_exists($deletimagepath)){ 
	        	$unlink = unlink( $deletimagepath ); }
		   }

			 

   }



		 

	    $spost['trippackage'] = $post['trippackage'];  
	    $spost['titlename'] = $post['titlename'];  
		$spost['couponcode'] = strtoupper( $post['couponcode'] ); 
		$spost['cpnvalue'] = $post['cpnvalue'];  
		$spost['valuetype'] = $post['valuetype'];  
		$spost['validfrom'] = date('Y-m-d',strtotime($post['validfrom']));   
		$spost['validto'] = date('Y-m-d',strtotime($post['validto']));   
		$spost['couponimage'] = ( isset($uploadstatus) && !empty($uploadstatus) ) ? $new_image_name : $oldimage ; 

		$spost['minamount'] = $post['minamount'];  
		$spost['maxdiscount'] = $post['maxdiscount'];  
		$spost['add_datetime'] = date('Y-m-d H:i:s');  
		$spost['status']= isset($post['status']) ? $post['status'] : 'yes'; 
		$spost['cpn_description'] = $post['cpn_description'];
		
         
        $id = NULL; 
		$postwhere = NULL;
		$checkitem = false;
        if( !empty($post['id']) ){
		$id = $post['id']; 
		$postwhere = ['id'=> $id]; 
        }
        else{
			$checkpost['trippackage'] = $post['trippackage']; 
			$checkpost['couponcode'] = strtoupper($post['couponcode']); 
			$checkpost['cpnvalue'] = $post['cpnvalue']; 
			$checkpost['valuetype'] = $post['valuetype'];  

			$checkitem = $this->c_model->countitem( $table, $checkpost ); 
    		if( $checkitem ){
    		$this->session->set_flashdata('error',"Data is already exist please check the details!");
    		redirect( adminurl( $currentpage ));
    		}

        }
        
        // echo '<pre>'; echo $id;
        // print_r($spost); exit;
		

		 

		if( $id ){ 
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, $postwhere, NULL );	 
		$this->session->set_flashdata('success',"Your data has been updated successfully!"); 
		redirect( adminurl( $currentpage.'/?id='.md5($id) ) );  
		}else if( empty($checkitem) && empty($id)){ 
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, NULL, NULL ); 
		$this->session->set_flashdata('success',"Your data has been added successfully!"); 
		}  

	

	 }

   
	  _view( 'addcoupon', $data );

	  

   }

   

   

  

	

}

?>