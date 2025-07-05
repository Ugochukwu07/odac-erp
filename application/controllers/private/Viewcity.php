<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewcity extends CI_Controller{
	
	 function __construct() {
         parent::__construct();  
	     adminlogincheck();
      }
	

  public function index() {
	 
	        $data['title'] = 'View City';
		    $data['list'] = $this->c_model->getAll('city');
			 
		    _viewlist( 'viewcity', $data );
	    
   }
   

}
?>