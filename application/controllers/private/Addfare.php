<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Addfare extends CI_Controller{ 
	
     public function __construct() {
         parent::__construct();  
	       adminlogincheck();
     }	



  public function index() {
	 
	    $currentpage = 'Addfare'; 
      $table = 'fare';

      $input = $this->input->get() ? $this->input->get() : '';  
      $id = isset($input['id']) ? $input['id'] : '';
      $triptype = isset($input['triptype']) ? $input['triptype'] : '';
      
	 
	
	    $data['title'] = ($id ? 'Update' : 'Add') .' Price';
	
	
      
      $data['triptype'] = isset($input['triptype']) ? $input['triptype'] : $triptype ;
      $data['fromcity'] = "";
      $category = $triptype == 'bike' ? 2 : 1;
      $data['category'] = $category;
      $data['modelid'] = "";
      $data['validfrom'] = ""; 
      $data['validtill'] = "";
      $data['basefare'] = "";
      $data['fareperkm'] = "";
      $data['minkm_day'] = "";
      $data['drivercharge'] = "";
      $data['nightcharge'] = "";
      $data['night_from'] = "22:00:00";
      $data['night_till'] = "06:00:00";
      $data['secu_amount'] = "";
      $data['add_by'] = "";
      $data['add_date'] = "";
      $data['status'] = "yes"; 
       
		$data['id'] = $id; 
		$status = '';
	
		
	
	 if( !empty($id ))
	 {
	    $dbget = $this->c_model->getSingle($table, array( 'id'=>$id ) );
	    $data['id'] = $dbget['id']; 
      $data['triptype'] = $dbget['triptype'];
      $triptype = $dbget['triptype'];
	    $data['fromcity'] = $dbget['fromcity']; 
      $data['category'] = $dbget['category']; 
      $data['modelid'] = $dbget['modelid']; 
      $data['validfrom'] = $dbget['validfrom']; 
      $data['validtill'] = $dbget['validtill']; 
      $data['basefare'] = $dbget['basefare']; 
      $data['fareperkm'] = $dbget['fareperkm']; 
      $data['minkm_day'] = $dbget['minkm_day']; 
      $data['drivercharge'] = $dbget['drivercharge']; 
      $data['nightcharge'] = $dbget['nightcharge']; 
      $data['night_from'] = $dbget['night_from']; 
      $data['night_till'] = $dbget['night_till']; 
      $data['add_by'] = $dbget['add_by']; 
      $data['add_date'] = $dbget['add_date'];
      $data['secu_amount'] = $dbget['secu_amount'];
	}


   $data['posturl'] = adminurl($currentpage.'?triptype=').$triptype; 
	


 
    $this->form_validation->set_rules('fromcity', 'fromcity', 'required',array('required'=>'Pickupcity is Blank.'));
    $this->form_validation->set_rules('triptype', 'triptype', 'required',array('required'=>'Triptype is Blank.'));
    $this->form_validation->set_rules('modelid', 'modelid', 'required',array('required'=>'Model name is Blank.')); 
    if($this->input->post('triptype')!='outstation'){
    $this->form_validation->set_rules('basefare', 'basefare', 'required',array('required'=>'Basefare is Blank.'));
    }else{
         
    $this->form_validation->set_rules('fareperkm', 'fareperkm', 'required',array('required'=>'fareperkm is Blank.'));
    $this->form_validation->set_rules('minkm_day', 'minkm_day', 'required',array('required'=>'minkm per day is Blank.'));
    $this->form_validation->set_rules('validfrom', 'validfrom', 'required',array('required'=>'Validfrom is Blank.'));
    $this->form_validation->set_rules('validtill', 'validtill', 'required',array('required'=>'Validtill is Blank.'));
    }
	 
    if($this->form_validation->run() == false){ 
		$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
    }
		
	 



	 if( $this->form_validation->run() != false){
		 
	$dbpost = $this->input->post();
		  
      $spost['fromcity'] = isset($dbpost['fromcity']) ? $dbpost['fromcity'] :NULL;
      $spost['triptype'] = isset( $dbpost['triptype']) ? $dbpost['triptype'] : NULL; 
      $spost['category'] = isset($dbpost['category']) ? $dbpost['category'] : NULL;
      $spost['modelid'] = isset($dbpost['modelid']) ? $dbpost['modelid'] : NULL;  
       
      $spost['validfrom'] = isset($dbpost['validfrom']) ? date('Y-m-d',strtotime( $dbpost['validfrom'])) : NULL; 
      $spost['validtill'] = isset($dbpost['validtill']) ? date('Y-m-d',strtotime($dbpost['validtill'])) : NULL; 
      $spost['basefare'] = isset($dbpost['basefare']) ? $dbpost['basefare'] : 0; 
      $spost['minkm_day'] = isset($dbpost['minkm_day']) ? $dbpost['minkm_day'] : 0; 
      $spost['fareperkm'] = isset($dbpost['fareperkm']) ? $dbpost['fareperkm'] :0;  
      $spost['drivercharge'] = isset($dbpost['drivercharge']) ? $dbpost['drivercharge'] : 0; 
      $spost['nightcharge'] = isset($dbpost['nightcharge']) ? $dbpost['nightcharge'] : 0;    
      $spost['status'] = isset($dbpost['status']) ? $dbpost['status'] : 'no';
      empty($dbpost['id']) ? ($spost['add_date'] = date('Y-m-d H:i:s') ) : '';

       $spost['night_from'] = isset($dbpost['night_from']) ? date('H:i:s',strtotime( $dbpost['night_from'])) : NULL; 

      $spost['night_till'] = isset($dbpost['night_till']) ? date('H:i:s',strtotime( $dbpost['night_till'])) : NULL; 
      $spost['secu_amount'] = isset($dbpost['secu_amount']) ? $dbpost['secu_amount'] : 0;
		
		
		$id = !empty($dbpost['tableid']) ? $dbpost['tableid'] : NULL ;
		$postwhere = !empty($id) ? array('id'=> $id) : NULL ; 
		$checkitem = '';

    $checkwher['fromcity'] = $spost['fromcity'];
    $checkwher['triptype'] = $spost['triptype'];
    $checkwher['category'] = $spost['category'];
    $checkwher['modelid'] = $spost['modelid'];
    $checkitem = $this->c_model->countitem( $table, $checkwher );
 
		
		if( $id ){
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, $postwhere, NULL );	
		$this->session->set_flashdata('success',"Fare updated successfully!");
		redirect( $data['posturl'].'&id='.$id);
		
		}else if( empty($checkitem) && empty($id)){
		$ststus = $this->c_model->saveupdate( $table, $spost, NULL, NULL, NULL );
		$this->session->set_flashdata('success',"Fare added successfully!");
		  
		}else if( $checkitem ){
		$this->session->set_flashdata('error',"Data is already exist please check the details!"); 
		}
		
		
	
	 }
 
      
 
	/*get city list */
        $selectcity = 'a.id, CONCAT(a.cityname ,",", b.statename) AS cityname'; 
        $from = ' pt_city as a'; 
        $join[0]['table'] = 'pt_state as b';
        $join[0]['on'] = 'a.stateid = b.id';
        $join[0]['key'] = 'LEFT';  
        $orderby = 'a.cityname ASC'; 
        $citylist = $this->c_model->joindata( $selectcity,null, $from, $join, null,$orderby );  

	    $data['citylist'] = createDropdown($citylist , 'id', 'cityname', 'City name'); 
  /*get city list */

  $modellist = $this->c_model->getAll('pt_vehicle_model','model ASC',array('catid'=>$category),'id,model');
  $data['modellist'] = createDropdown($modellist , 'id', 'model', 'Model name');

	  _view( 'addfare', $data );
	  
   }
   

}
?>