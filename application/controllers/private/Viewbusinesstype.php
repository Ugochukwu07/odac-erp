<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewbusinesstype extends CI_Controller{
	
	 function __construct() {
         parent::__construct();  
	     adminlogincheck();
      }
	


  public function index() {
	
	        $data['title'] = 'View Business Type';
		    $data['list'] = $this->c_model->getAll('businesstype',null,null);
			 
		    _viewlist( 'viewbusinesstype', $data );
	    
   }

}
?>