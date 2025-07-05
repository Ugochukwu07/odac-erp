<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewcmspage extends CI_Controller{
	
	  function __construct() {
         parent::__construct();  
		  adminlogincheck();
      }
	


  public function index() {
      
      $currentpage = 'Viewcmspage';
      $domainarray = checkdomain() ;
       
      
       
   
  	  
	
	        $data['title'] = 'View CMS Page';

			$where['pagetype'] = 'cms' ;
            if( !empty($domainarray['domainid']) ){
            $where['a.domainid'] = $domainarray['domainid'] ;
            }

	        $select = 'a.id,LEFT(a.metatitle,50) as metatitle,LEFT(a.metadescription,50) as metadescription,a.metakeyword,a.titleorheading,a.summary,a.pagetype,a.subject,a.tableid,a.cityid,a.cabname,a.add_datetime,a.status,a.pageurl,a.image,a.domainid,LEFT(a.content,250) as content, b.domain '; 
		    $from = 'pt_cms as a';

		    $join[0]['table'] = 'pt_domain as b';
		    $join[0]['on'] = 'a.domainid = b.id';
		    $join[0]['key'] = 'LEFT'; 

		    $orderby = 'a.domainid ASC';

		    $data['list'] = $this->c_model->joindata( $select,$where, $from, $join, null,$orderby ); 
//print_r($data['list']);
//exit;
		    
			 
		    _viewlist( 'viewcmspage', $data );
	    
   }



  public function deleteitem(){
  	$id = $this->input->get('delId');
  	$this->c_model->delete('pt_cms',['md5(id)'=>$id]);
  	$this->session->set_flashdata('success','Data Deleted Successfully!');
  	redirect( adminurl('Viewcmspage'));
  } 
   

}
?>