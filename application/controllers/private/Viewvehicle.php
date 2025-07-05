<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Viewvehicle extends CI_Controller{
	
     function __construct() {
         parent::__construct();  
	     adminlogincheck();
     }	
	
	 
	public function index(){

		    $data['title'] = 'View Model ';
		    $select = 'a.*, b.category ';
		    $orderby = 'a.model ASC';
		    $from = ' pt_vehicle_model as a';

		    $join[0]['table'] = 'pt_vehicle_cat as b';
		    $join[0]['on'] = 'a.catid = b.id';
		    $join[0]['key'] = 'LEFT';
		    $data['list'] = $this->c_model->joindata( $select, null, $from, $join, null, $orderby );
 
			 
		    _viewlist( 'viewvehicle', $data ); 
		}

	 public function delete() { 
	 	    $table = 'pt_vehicle_model';
	        $getid = $this->input->get() ? $this->input->get('delId') : array();  
	        $where['md5(id)'] = $getid;
	        /* delete image start*/
	        $image = $this->c_model->getRow($table, $where ,'image' );
	        $deletimagepath = ("uploads/".$image."");
	        if(is_file($deletimagepath) && file_exists($deletimagepath)){ 
	        	$unlink = @unlink( $deletimagepath ); 
	        }
			  


	        /* delete image start*/
		    $status = $getid ? $this->c_model->delete( $table, $where ) : '';
		    $message = $getid && $status ? 'Data Deleted Successfully' :'Some Error Occured';
		$this->session->set_flashdata('error', $message ); 
		    redirect( adminurl('Viewvehicle'));
	    
   }  
   

	}
?>