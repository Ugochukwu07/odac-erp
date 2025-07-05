<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewfare extends CI_Controller{
	
	
	public  function __construct() {
         parent::__construct();  
	     adminlogincheck();
     }	

	
	 
	public function index(){

            

            $title = 'View fare';
	        $data['title'] = $title;
	        $data['list'] = array();
	        $get = $this->input->get();
	        $where = null; 
	         
		    $select = 'a.*, d.model, b.cityname, c.category'; 
		    $from = ' pt_fare as a';

		    $join[0]['table'] = 'pt_city as b';
		    $join[0]['on'] = 'a.fromcity = b.id';
		    $join[0]['key'] = 'LEFT';
		    $join[1]['table'] = 'pt_vehicle_cat as c';
		    $join[1]['on'] = 'a.category = c.id';
		    $join[1]['key'] = 'LEFT';
		    $join[2]['table'] = 'pt_vehicle_model as d';
		    $join[2]['on'] = 'a.modelid = d.id';
		    $join[2]['key'] = 'LEFT';

		    $orderby = 'a.id ASC';

		    $data['list'] = $this->c_model->joindata( $select,null, $from, $join, null,$orderby );
 
		    _viewlist( 'viewfare', $data );
 
		}


public  function delete(){
    if( $this->input->get('delId') ){
      $this->c_model->delete( 'pt_fare', array('md5(id)'=>$this->input->get('delId') ) ); 
      $this->session->set_flashdata('success',"Fare Deleted successfully!");
      $corpouid = isset($input['corpouid']) ? $input['corpouid'] : '';
      redirect( adminurl( 'viewfare' ));
            
      }
   }
  


	}
?>