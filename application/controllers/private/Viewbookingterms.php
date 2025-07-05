<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewbookingterms extends CI_Controller{
	
	  function __construct() {
         parent::__construct();  
		  adminlogincheck();
      }
	


  public function index() {
	
	        $data['title'] = 'View Booking Terms';

	        $select = 'a.*, b.domain '; 
		    $from = ' pt_booking_terms as a';
		    
		    $where = [];
		    $where['a.contenttype'] = 'terms';

		    $join[0]['table'] = 'pt_domain as b';
		    $join[0]['on'] = 'a.domain = b.id';
		    $join[0]['key'] = 'LEFT'; 

		    $orderby = 'a.domain ASC';

		    $data['list'] = $this->c_model->joindata( $select, $where, $from, $join, null,$orderby );  
		    
			 
		    _viewlist( 'viewbookingterms', $data );
	    
   }
   

}
?>