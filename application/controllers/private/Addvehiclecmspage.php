<?php defined('BASEPATH') OR exit('No direct script access allowed');
  
class Addvehiclecmspage extends CI_Controller{
	
	 function __construct() {
         parent::__construct(); 
	     adminlogincheck();
	     $this->pagename = 'Addvehiclecmspage';
      }
	


  public function index() {
	
	$currentpage = $this->pagename; 
	$data['pagename'] = $this->pagename;

	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return='.$currentpage ) );
  	}
  	/*check domain end*/ 


	$table = 'pt_cms';
    $id = $this->input->get('id') ? $this->input->get('id') : '';
	 
	
	$data['title'] = ( !empty($id) ? 'Update' : 'Add') .' Vehicle Page For { '.checkdomain('domain').' }';
	
	 
	    $data['id'] = ''; 
		$data['metatitle'] = '';
		$data['metadescription'] = ''; 
		$data['metakeyword'] = ''; 
		$data['titleorheading'] = '';
		$data['summary'] = '';
		$data['content'] = '';
		$data['pagetype'] = '';
		$data['subject'] = '';
		$data['tableid'] = '';
		$data['cityid'] = '';
		$data['oldprice'] = '';
		$data['newprice'] = '';
		$data['cabname'] = '';
		$data['status'] = 'yes';
		$data['pageurl'] = '';
		$data['domainid'] = checkdomain('domainid');  
	
		
	
	 if( !empty($id ))
	 {
	    $dbstate = $this->c_model->getSingle($table, array( 'id'=>$id ) );
	    $data['id'] = $dbstate['id']; 
		$data['metatitle'] = $dbstate['metatitle'];
		$data['metadescription'] = $dbstate['metadescription']; 
		$data['metakeyword'] = $dbstate['metakeyword'];  
		$data['titleorheading'] = $dbstate['titleorheading'];  
		$data['summary'] = $dbstate['summary'];
		$data['content'] = $dbstate['content'];
		$data['pagetype'] = $dbstate['pagetype'];
		$data['subject'] = $dbstate['subject'];
		$data['tableid'] = $dbstate['tableid'];
		$data['cityid'] = $dbstate['cityid'];
		$data['oldprice'] = $dbstate['oldprice'];
		$data['newprice'] = $dbstate['newprice'];
		$data['cabname'] = $dbstate['cabname'];
		$data['status'] = $dbstate['status'];
		$data['pageurl'] = $dbstate['pageurl'];
		$data['domainid'] = $dbstate['domainid'];   
	 }
	 



if( $this->input->post() ){

$this->form_validation->set_rules('titleorheading','titleorheading','required');
$this->form_validation->set_rules('tableid','tableid','required');
$this->form_validation->set_rules('metatitle','metatitle','required' );
$this->form_validation->set_rules('metadescription','metadescription','required' );
$this->form_validation->set_rules('metakeyword','metakeyword','required');
$this->form_validation->set_rules('content','content','required' ); 
	 
	 if($this->form_validation->run() == false){ 
		$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
	 }
		
}	 
	


	 if( $this->form_validation->run() != false){
		 
		$dbpost = $this->input->post();
		//print_r($dbpost ); exit;
		 
	    $spost['domainid'] = trim($dbpost['domainid']);
	    $spost['metatitle'] = trim($dbpost['metatitle']);
		$spost['metadescription'] = trim($dbpost['metadescription']); 
		$spost['metakeyword'] = trim($dbpost['metakeyword']);  
		$spost['titleorheading'] = trim($dbpost['titleorheading']);  
		$spost['summary'] = trim($dbpost['summary']);
		$spost['content'] = trim($dbpost['content']);
		$spost['pagetype'] = trim($dbpost['pagetype']);
		//$spost['subject'] = $dbpost['subject'];
		$spost['tableid'] = $dbpost['tableid'];
		//$spost['cityid'] = $dbpost['cityid'];
		//$spost['oldprice'] = $dbpost['oldprice'];
		//$spost['newprice'] = $dbpost['newprice'];
		$spost['cabname'] = $dbpost['cabname']; 
		$spost['pageurl'] =  str_replace(' ', '-', strtolower(trim($dbpost['titleorheading']))) ;  


		empty($dbpost['id']) ? ($spost['add_datetime'] = date('Y-m-d H:i:s') ) : ''; 
		$spost['status']= isset($dbpost['status']) ? $dbpost['status'] : 'yes';    
		
		
		$id = !empty($dbpost['id']) ? $dbpost['id'] : NULL ;
		$postwhere = !empty($id) ? array('id'=> $id) : NULL ; 
		
 
		$checkpost['tableid'] = $spost['tableid'];
		$checkpost['pagetype'] = $dbpost['pagetype'];
		$checkpost['domainid'] = trim($dbpost['domainid']);
		
		$checkitem = $this->c_model->countitem( $table, $checkpost ); 

		//print_r($spost); exit;
		
		if( !empty($id)){
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, $postwhere, NULL );	
		$this->session->set_flashdata('success',"Your data has been updated successfully!");
		redirect( adminurl( $currentpage.'/?id='.$id));
		
		}else if( empty($checkitem) && empty($id)){
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, NULL, NULL );
		$this->session->set_flashdata('success',"Your data has been added successfully!");
		  
		}else if( !empty($checkitem)){
		$this->session->set_flashdata('error',"Data is already exist please check the details!");
		redirect( adminurl( $currentpage ));
		}
		
		
	
	 }
 
      
	  _view( 'addvehiclecmspage', $data );
	  
   }
   
   
	
}
?>