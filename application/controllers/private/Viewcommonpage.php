<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewcommonpage extends CI_Controller{
	
	  function __construct() {
         parent::__construct();  
		  adminlogincheck();
      }
	


  public function index() {

  	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return=Viewcommonpage' ) );
  	}
  	/*check domain end*/
	
	        $data['title'] = 'View Booking Terms';

	        $select = 'a.*, b.domain '; 
		    $from = ' pt_booking_terms as a';

		    $join[0]['table'] = 'pt_domain as b';
		    $join[0]['on'] = 'a.domain = b.id';
		    $join[0]['key'] = 'LEFT'; 

		    $orderby = 'a.domain ASC';

		    $data['list'] = $this->c_model->joindata( $select,null, $from, $join, null,$orderby ); 

		    
			 
		    _viewlist( 'viewbookingterms', $data );
	    
   }
   

}
?>