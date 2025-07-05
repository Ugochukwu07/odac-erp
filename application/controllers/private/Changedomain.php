<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Changedomain extends CI_Controller{
	
	public function __construct(){
		parent::__construct(); 
		adminlogincheck();
	}


  public function index() {
	
	$currentpage = 'Changedomain'; 
	$data['posturl'] = adminurl( $currentpage ).'/';
	
	$data['title'] = 'Select Domain'; 

	$data['domain'] = '';
	$data['domainid'] = checkdomain('domainid');
	$data['return'] = '';

	if($return = $this->input->get('return')){
    		$data['return'] = $return;
    }

	
    if($this->input->post('domain')){
    	$post = $this->input->post();
     
    	unset($post['mysubmit']);
    	$arrayName = array('checkdomain' => $post  );
    	$this->session->set_userdata( $arrayName ); 
    	$data['domain'] = $post['domain'];
    	if($return = $this->input->post('return')){
    		redirect( adminurl($return) );
    	}
    }
    
    /** Set Default Domain Session Start Script**/
    if( empty($this->session->userdata( 'checkdomain' )) ){
        	$arrayName = array('checkdomain' => ['domain'=>'odac24.in','domainid'=>'2']  );
    	    $this->session->set_userdata( $arrayName ); 
    	    redirect( adminurl('dashboard') ); exit;
    }
    /** Set Default Domain Session end Script**/

    /*create xml file*/
    $runxml = file_get_contents( base_url('Createxml/index'));
	 
	  _view( 'changedomain', $data );
	  
   }
   
   
  
	
}
?>