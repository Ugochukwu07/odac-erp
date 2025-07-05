<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_profile_image extends CI_Controller {
 
    public function __construct(){
		parent::__construct(); 
		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");
		header("Content-Type: application/json");  
	}


public function index(){  

		

		$response = [];
		$data = [];
		$up_where = null;

		if( ($_SERVER['REQUEST_METHOD'] != 'POST') ){ 
				$response['status'] = FALSE;
				$response['message']= 'Bad request!';   
				echo json_encode( $response );
				exit;
		}




		$request = $_POST;		 
		$user_id = !empty($request['user_id'])?$request['user_id']:null;  
		$image_name =  'image' ; 
		$filename = !empty($_FILES['filename']['name']) ? $_FILES['filename']['name'] : FALSE;
				
				  
            
			if( !$user_id ){
				$response['status'] = FALSE;
				$response['message'] = 'User ID is blank!'; 
				echo json_encode( $response );
				exit;
			}else if( !$image_name ){ 
				$response['status'] = FALSE;
				$response['message'] = 'Image name is blank!'; 
				echo json_encode( $response );
				exit;
			}else if( !$filename ){ 
				$response['status'] = FALSE;
				$response['message'] = 'Choose a file!'; 
				echo json_encode( $response );
				exit;
			}
  


			$target_folder = "uploads"; 
			$oldimage = false;
			$uploadstatus = false;
			$new_image_name = '';
			
			$where['id'] = $user_id;   
			$newkeys = 'id,'.$image_name;
			$doc_arr = $this->c_model->getSingle('pt_customer', $where, $newkeys );

			if( empty($doc_arr) ){
				$response['status'] = FALSE;
				$response['message'] = 'User not exists!'; 
				echo json_encode( $response );
				exit;
			} 


			if(!empty($doc_arr)){
				$oldimage = $doc_arr[$image_name];  
			} 


 			 $checkfile = $_FILES['filename']['name'];
			 $ext = pathinfo($checkfile, PATHINFO_EXTENSION);

			 $config['upload_path'] = './'.$target_folder.'/';  
                $config['allowed_types'] = 'jpg|jpeg|png';  
                $config['encrypt_name'] = false; 
                $config['overwrite'] = TRUE;
                $config['file_name'] = 'user_'.$image_name.'_'.date('Y_m_d_H_i_s').'.'.$ext;
                $this->load->library('upload', $config);  
                if(!$this->upload->do_upload('filename'))  
                {  
                        $message = strip_tags( $this->upload->display_errors() );  
						$response['status'] = FALSE;
						$response['message']= $message;  
						echo json_encode( $response );
						exit;
                }  
                else  
                {  
                     $data = $this->upload->data(); 
                     $new_image_name = $data["file_name"];  
                     $config1['image_library'] = 'gd2';  
                     $config1['source_image'] = './'.$target_folder.'/'.$data["file_name"];  
                     $config1['create_thumb'] = FALSE;  
                     $config1['maintain_ratio'] = true;
                     $config1['remove_spaces'] = true;  
                     $config1['quality'] = '100%';
                     $config1['width'] = 300; 
                     $config1['height'] = 300; 
                     $config1['new_image'] = './'.$target_folder.'/'.$data["file_name"];  
				 $this->load->library('image_lib', $config1); 
                     $this->image_lib->initialize($config1); 
                     $this->image_lib->resize(); 
                     $this->image_lib->clear();
					 $uploadstatus = true; 
                } 
		 
		 /*image upload script end here */ 	    
			  
					if ( $uploadstatus && !empty($oldimage) )
					{
					    $delimg = $target_folder."/".$oldimage ;
					 	if(is_file($delimg) && file_exists($delimg)){ 
					 		$DEL = unlink( $delimg );
					 	} 
					}



			/*check uploaded Document in directory start script*/
			$checkimg = $target_folder."/".$new_image_name ;
			if( is_file($checkimg) && file_exists($checkimg)){ 

				$post[$image_name] = $new_image_name; 

				$saveupdate = $this->c_model->saveupdate( 'pt_customer', $post, null, $where );
				if($saveupdate){  
				$response['status']= TRUE; 
				$response['data'] = ['image_path' => UPLOADS.$new_image_name];
				$response['message'] = ucwords($image_name).' updated successfully';
				}else{
				$response['status']= FALSE;
				$response['message']= 'Some error Occured!';
				}  
			}else{
			$response['status']= FALSE;
			$response['message']= 'Some Error during Image Upload, Please Try Again!';
			}	
			/*check uploaded Document in directory end script*/	  
 
 
		echo json_encode( $response );
}
 
 
}
?>