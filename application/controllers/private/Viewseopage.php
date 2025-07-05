<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewseopage extends CI_Controller{
	
	  function __construct() {
         parent::__construct();  
		  adminlogincheck();
      }
	


  public function index() {

  	/*check domain start*/
    if(  !checkdomain() ){
  		redirect( adminurl('Changedomain?return=Viewseopage' ) );
  	}
  	/*check domain end*/
	
	        $data['title'] = 'View SEO Page';

	        $where['pagetype'] = 'seo';
	        $select = 'a.*, b.domain '; 
		    $from = ' pt_cms as a';

		    $join[0]['table'] = 'pt_domain as b';
		    $join[0]['on'] = 'a.domainid = b.id';
		    $join[0]['key'] = 'LEFT'; 

		    $orderby = 'a.domainid ASC';

		    $data['list'] = $this->c_model->joindata( $select,$where, $from, $join, null,$orderby ); 

		    
			 
		    _viewlist( 'viewseopage', $data );
	    
   }


  public function deleteitem(){
  	$id = $this->input->get('delId');
  	$this->c_model->delete('pt_cms',['md5(id)'=>$id]);
  	$this->session->set_flashdata('success','Data Deleted Successfully!');
  	redirect( adminurl('Viewseopage'));
  } 
   

}
?>