<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Webconfig extends CI_Controller{
	
	  function __construct() {
         parent::__construct();  
	     adminlogincheck();
      }
	


  public function index() {

  	
	$table = 'setting';
	$data['type'] = $this->input->get('type') ? $this->input->get('type') : '';

	$currentpage = 'webconfig'; 
	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return='.$currentpage ) );
  	}
  	/*check domain end*/ 
  	
  	
    $domain_id = checkdomain('domainid'); 
	$new_image_name = '';
	
	$data['title'] = ( $domain_id ? 'Update' : 'Add') .' Web Setting';
	
		 
	
	 
	 
	    $data['id'] = ""; 
	    $data['sms'] = ""; 
		$data['mapscript'] = ""; 
		$data['headoffice'] = ""; 
		$data['branchoffice']="";
		$data['companyname'] = ""; 
		$data['landline'] = ""; 
		$data['caremobile'] = ""; 
		$data['personalmobile']="";
		$data['careemail'] = ""; 
		$data['personalemail'] = ""; 

		$data['logo'] = ""; 
		$data['gst']="";
		$data['onlinecharge'] = ""; 
		$data['advance'] = ""; 
		$data['pan_no'] = ""; 
		$data['propwriter']="";
		$data['registration_no'] = "";
		$data['gstinno'] = "";  
		$data['facebook'] = ""; 
		$data['twitter'] = ""; 
		$data['linkedin']="";
		$data['googleplus'] = ""; 
		$data['youtube'] = ""; 
		$data['refferalvalue'] = ""; 
		$data['slipcolor']="";
		$data['sliptextcolor'] = "";
		$data['whatsupno'] = "";  
		$data['placeapi'] = ""; 
		$data['matrixapi'] = ""; 
		$data['smsuser']="";
		$data['smspassword']="";
		$data['senderid'] = ""; 
		$data['slippfix'] = ""; 
		$data['captuakey'] = ""; 
		$data['captuasecretkey']="";

		$data['custmerfirebkey'] = ""; 

		$data['status'] = "yes";
		$data['notification'] = "";
		$data['custappversion'] = ""; 
		$data['custmeraplink'] = "";
		$data['frommail'] = "";
		$data['mailer'] = "";
		$data['cc'] = "";
		$data['hostip'] = "";
		$data['mailuser'] = "";
		$data['mailpassword'] = "";
		$data['oldimage'] = ""; 
 

		$data['domain_id'] = $domain_id; 
	
	 	
	
	$oldimage = '';
	
	 if( !empty($domain_id ))
	 {
	 $corpo = $this->c_model->getSingle($table, array( 'domain_id'=>$domain_id ) );
	 
	    $data['id'] = $corpo['id'];
		$data['sms'] = $corpo['sms'];
		$data['mapscript'] =  ( $corpo['mapscript'] ); 
		$data['headoffice'] = $corpo['headoffice'];
		$data['branchoffice'] = $corpo['branchoffice']; 
		$data['companyname'] = $corpo['companyname']; 
		$data['landline'] = $corpo['landline'];
		$data['caremobile'] = $corpo['caremobile'];
		$data['personalmobile'] = $corpo['personalmobile']; 
		$data['careemail'] = $corpo['careemail']; 
		$data['personalemail'] = $corpo['personalemail']; 
		$data['logo'] = $corpo['logo'];
		$data['gst'] = $corpo['gst']; 
		$data['onlinecharge'] = $corpo['onlinecharge']; 
		$data['advance'] = $corpo['advance']; 
		$data['pan_no'] = $corpo['pan_no'];
		$data['propwriter'] = $corpo['propwriter']; 
		$data['registration_no'] = $corpo['registration_no']; 
		$data['gstinno'] = $corpo['gstinno'];
		$data['facebook'] = $corpo['facebook'];
		$data['twitter'] = $corpo['twitter']; 
		$data['linkedin'] = $corpo['linkedin'];
		$data['googleplus'] = $corpo['googleplus']; 
		$data['youtube'] = $corpo['youtube']; 
		$data['refferalvalue'] = $corpo['refferalvalue'];
		$data['slipcolor'] = $corpo['slipcolor'];
		$data['sliptextcolor'] = $corpo['sliptextcolor']; 
		$data['whatsupno'] = $corpo['whatsupno']; 
		$data['placeapi'] = $corpo['placeapi']; 
		$data['matrixapi'] = $corpo['matrixapi'];
		$data['smsuser'] = $corpo['smsuser']; 
		$data['smspassword'] = $corpo['smspassword']; 
		$data['senderid'] = $corpo['senderid']; 
		$data['slippfix'] = $corpo['slippfix']; 
		$data['captuakey'] = $corpo['captuakey'];
		$data['captuasecretkey'] = $corpo['captuasecretkey']; 
		$data['status'] = $corpo['status'];

		$data['custmerfirebkey'] = $corpo['custmerfirebkey'];  

		$data['notification'] = $corpo['notification'];   
		$data['custmeraplink'] = $corpo['custmeraplink']; 
		$data['frommail'] = $corpo['frommail'];
		$data['mailer'] = $corpo['mailer'];
		$data['cc'] = $corpo['cc'];
		$data['hostip'] = $corpo['hostip'];
		$data['mailuser'] = $corpo['mailuser'];
		$data['mailpassword'] = $corpo['mailpassword']; 
		$data['oldimage'] = $corpo['logo']; 
	 }
	 
	 $this->form_validation->set_rules('companyname','Companyname','required'); 
	 
	 if($this->form_validation->run() == false){ 
		$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
	 }
		
	 
	 if( $this->form_validation->run() != false){
		 
		$corpo = $this->input->post();

/************* image upload script start here *****************/

		 $oldimage = $corpo['oldimage'];
		 
          

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
                     $config['source_image'] = './uploads/'.$new_image_name;  
                     $config['create_thumb'] = FALSE;  
                     $config['maintain_ratio'] = true;  
                     $config['quality'] = '100%';  
                     $config['width'] = 284;  
                     $config['height'] = 186;  
                     $config['new_image'] = './uploads/'.$new_image_name;  
					 $this->load->library('image_lib', $config);  
                     $this->image_lib->resize(); 
					 $uploadstatus = true; 
                }  
				
	    /************ Delete saved image if that is exists in folder */
			  
				if(($uploadstatus == true) && $_FILES['userfile']['name'] && $oldimage ){
				$deletimagepath = ("uploads/".$oldimage."");
					if(is_file($deletimagepath) && file_exists($deletimagepath)){ 
					$unlink = unlink( $deletimagepath ); 
					}
				}
			 
		 }
		
		/************* image upload script start here *****************/


        $id = isset($corpo['id']) ? $corpo['id'] : '1';

		//$spost['sms'] = isset($corpo['sms']) ? $corpo['sms'] : NULL; 
		$spost['mapscript'] = isset($corpo['mapscript']) ? $corpo['mapscript'] : NULL;  

		$spost['headoffice'] = isset($corpo['headoffice']) ? $corpo['headoffice'] : NULL;
		$spost['branchoffice'] = isset($corpo['branchoffice']) ? $corpo['branchoffice'] : NULL;
		$spost['companyname'] = isset($corpo['companyname']) ? $corpo['companyname'] : NULL;  
		$spost['landline'] = isset($corpo['landline']) ? $corpo['landline'] : NULL;
		$spost['caremobile'] = isset($corpo['caremobile']) ? $corpo['caremobile'] : NULL;
		$spost['personalmobile'] = isset($corpo['personalmobile']) ? $corpo['personalmobile'] : NULL;  
		$spost['careemail'] = isset($corpo['careemail']) ? $corpo['careemail'] : '';
		$spost['personalemail'] = isset($corpo['personalemail']) ? $corpo['personalemail'] : NULL; 
		$spost['logo'] = !empty($new_image_name) ? $new_image_name : $oldimage;  
		$spost['gst'] = isset($corpo['gst']) ? $corpo['gst'] : NULL;
		$spost['onlinecharge'] = isset($corpo['onlinecharge']) ? $corpo['onlinecharge'] : NULL;
		$spost['advance'] = isset($corpo['advance']) ? $corpo['advance'] : NULL;
		$spost['pan_no'] = isset($corpo['pan_no']) ? $corpo['pan_no'] : NULL;
		$spost['propwriter'] = isset($corpo['propwriter']) ? $corpo['propwriter'] : NULL;
	$spost['registration_no'] = isset($corpo['registration_no']) ? $corpo['registration_no'] : NULL;
		$spost['gstinno'] = isset($corpo['gstinno']) ? $corpo['gstinno'] : NULL;
		$spost['facebook'] = isset($corpo['facebook']) ? $corpo['facebook'] : NULL;
		$spost['twitter'] = isset($corpo['twitter']) ? $corpo['twitter'] : NULL;

		$spost['linkedin'] = isset($corpo['linkedin']) ? $corpo['linkedin'] : NULL;
		$spost['googleplus'] = isset($corpo['googleplus']) ? $corpo['googleplus'] : NULL;
		$spost['youtube'] = isset($corpo['youtube']) ? $corpo['youtube'] : NULL;
		$spost['refferalvalue'] = isset($corpo['refferalvalue']) ? $corpo['refferalvalue'] : NULL;
		$spost['slipcolor'] = isset($corpo['slipcolor']) ? $corpo['slipcolor'] : NULL;
		$spost['sliptextcolor'] = isset($corpo['sliptextcolor']) ? $corpo['sliptextcolor'] : NULL;
		$spost['whatsupno'] = isset($corpo['whatsupno']) ? $corpo['whatsupno'] : NULL;
		$spost['placeapi'] = isset($corpo['placeapi']) ? $corpo['placeapi'] : NULL;
		$spost['matrixapi'] = isset($corpo['matrixapi']) ? $corpo['matrixapi'] : NULL;
		$spost['smsuser'] = isset($corpo['smsuser']) ? $corpo['smsuser'] : NULL;
		$spost['smspassword'] = isset($corpo['smspassword']) ? $corpo['smspassword'] : NULL;
		$spost['senderid'] = isset($corpo['senderid']) ? $corpo['senderid'] : NULL;
		$spost['slippfix'] = isset($corpo['slippfix']) ? $corpo['slippfix'] : NULL;
		$spost['captuakey'] = isset($corpo['captuakey']) ? $corpo['captuakey'] : NULL;
    	$spost['captuasecretkey'] = isset($corpo['captuasecretkey']) ? $corpo['captuasecretkey'] : NULL;
    	$spost['custmerfirebkey'] = isset($corpo['custmerfirebkey']) ? $corpo['custmerfirebkey'] : NULL; NULL;
		$spost['status'] = isset($corpo['status']) ? $corpo['status'] : 'yes';
		$spost['notification'] = isset($corpo['notification']) ? $corpo['notification'] : NULL;
		  
		$spost['custmeraplink'] = isset($corpo['custmeraplink']) ? $corpo['custmeraplink'] : NULL;
		$spost['frommail'] = isset($corpo['frommail']) ? $corpo['frommail'] : NULL;
		$spost['mailer'] = isset($corpo['mailer']) ? $corpo['mailer'] : NULL;
		$spost['cc'] = isset($corpo['cc']) ? $corpo['cc'] : NULL;
		$spost['hostip'] = isset($corpo['hostip']) ? $corpo['hostip'] : NULL;
		$spost['mailuser'] = isset($corpo['mailuser']) ? $corpo['mailuser'] : NULL;
		$spost['mailpassword'] = isset($corpo['mailpassword']) ? $corpo['mailpassword'] : NULL; 
 

        $postwhere = $id ? array('id'=>$id) : NULL; 
		

		$update = $this->c_model->saveupdate($table,$spost, NULL, $postwhere, NULL );	
		$this->session->set_flashdata('success',"Your data has been updated successfully!");
		

	

        if( $update ){ redirect( adminurl($currentpage)); }

   }/*end post data */

 
      
	  _view( 'webconfig', $data );
	  
   }
   
   
  
	
}
?>