<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bookinguploads extends CI_Controller{
	var $pagename;
	var $table;
	 function __construct() {
         parent::__construct();   
	     adminlogincheck();
	     $this->pagename = 'Bookinguploads';
	     $this->table = 'pt_uploads';
     }	


  public function index() { 
  	$data = [];

  	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return='.$currentpage ) );
  	}
  	/*check domain end*/ 

	$data['posturl'] = adminurl($this->pagename.'/uploads');

	$table = $this->table;
    $id = $this->input->get('id') ? $this->input->get('id') : '';
	 
	
	$data['title'] = 'Upload Booking Documents';
	$data['bkid'] = $id;

	$data['doclist'][0]['documenttype'] = 'adhf';
	$data['doclist'][0]['documentname'] = 'Aadhar Image(Front)';
	$data['doclist'][0]['image'] = '150x100.png';
	$data['doclist'][1]['documenttype'] = 'adhb';
	$data['doclist'][1]['documentname'] = 'Aadhar Image(Back)';
	$data['doclist'][1]['image'] = '150x100.png';
	$data['doclist'][2]['documenttype'] = 'photo';
	$data['doclist'][2]['documentname'] = 'User Photo';
	$data['doclist'][2]['image'] = '150x100.png';
	$data['doclist'][3]['documenttype'] = 'dlf';
	$data['doclist'][3]['documentname'] = 'DL Image(Front)';
	$data['doclist'][3]['image'] = '150x100.png';
    $data['doclist'][4]['documenttype'] = 'dlb';
	$data['doclist'][4]['documentname'] = 'DL Image(Back)';
	$data['doclist'][4]['image'] = '150x100.png';



$upload_data = [];
$where = [];
$where['tableid'] = $id;
$where['usertype'] = checkdomain('domainid'); 
$upload_data = $this->c_model->getAll($table,null,$where,'documentorimage,documenttype,tableid'); 
$data['list'] = !empty($upload_data) ? $upload_data : [];
	 
	 
//echo '<pre>';
//print_r( $upload_data );exit;
   
	  _view( 'bookinguploads', $data );
	  
   }


 public  function uploads(){
 	    $post = $this->input->post(); 

		$tableid = $post['tableid'];
		$documenttype = $post['documenttype']; 
		$usertype = checkdomain('domainid');
		$filename = 'userfile'.$documenttype;
		$upfilename = $_FILES[$filename]['name'];
		$folder = 'uploads';

		$oldimage = $post['oldimage']; 

        /*image upload script start here */
	if(!$upfilename){
		$this->session->set_flashdata('success',"Please select an image!");
		redirect( adminurl( $this->pagename.'/?id='.$tableid ));
		exit;
	}

	if (!is_dir($folder)) { mkdir('./'.$folder, 0777, true);}

	if (!empty($oldimage)  && !empty($upfilename) ){
			$deletimagepath = ($folder."/".$oldimage."");
	        if(is_file($deletimagepath) && file_exists($deletimagepath)){ 
	        	$unlink = @unlink( $deletimagepath ); 
	        }
	}



			  
			  
			    $config['upload_path'] 	 = './'.$folder.'/';  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['remove_spaces'] = TRUE;
           		$config['file_name']  = $tableid.'_'.$documenttype.'_'.$usertype.'.'. pathinfo($upfilename, PATHINFO_EXTENSION);  
                $this->load->library('upload', $config);  
                if(!$this->upload->do_upload( $filename ))  
                {  
					$message = $this->upload->display_errors(); 
					$this->session->set_flashdata('success',$message );
					redirect( adminurl( $this->pagename.'/?id='.$tableid ));
					exit; 
                }  
                else  
                {  
                     $data = $this->upload->data(); 
					 $postimage = $data["file_name"];
                     $configg['image_library'] = 'gd2';  
                     $configg['source_image'] = './'.$folder.'/'.$data["file_name"];  
                     $configg['create_thumb'] = false;  
                     $configg['maintain_ratio'] = true;  
                     $configg['quality'] = '100%';  
                     $configg['new_image'] = './'.$folder.'/'.$data["file_name"];  
					 $this->load->library('image_lib', $configg);  
                     $this->image_lib->resize(); 
                     $this->image_lib->clear();  
                }   

		 
		  /*image upload script start here */ 



	    $spost['tableid'] = $tableid;
	    $spost['usertype'] = $usertype;
	    $spost['documentorimage'] = $postimage;
	    $spost['documenttype'] = $documenttype;
	    $spost['uploaddate'] = date('Y-m-d H:i:s');
	    $spost['add_by'] = 'NA';
	    $spost['verifystatus'] = 'yes';
	    $spost['status'] = 'yes'; 

		$spost = $this->security->xss_clean($spost);
		
		$upwh = null; $where = [];
		if(  $tableid && $documenttype && $usertype ){
			$where['tableid'] = $tableid;
			$where['usertype'] = $usertype;
			$where['documenttype'] = $documenttype;
			$fetch = $this->c_model->getSingle('pt_uploads', $where, ' * ' );
			if(!empty($fetch)){ $upwh['id'] = $fetch['id']; }
		} 
		 
		 
		$update = $this->c_model->saveupdate('pt_uploads' , $spost, NULL, $upwh );
		
		
		if( $update && $tableid ){
		$this->session->set_flashdata('success',"Images uploaded successfully!");
		redirect( adminurl( $this->pagename.'/?id='.$tableid ));
		
		}else if( !$update ){
		$this->session->set_flashdata('error',"Some error Occured!");
		redirect( adminurl( $this->pagename )) ;
		}
		
		
	 
 } 
   
   
  
	
}
?>