<?php defined('BASEPATH') or exit('No direct Access Allowed');

class Registerdriver extends CI_controller{
	public function __construct(){
		parent::__construct(); 
		adminlogincheck();
	}

public function index(){

	$data = array();
	$currentpage = 'Registerdriver'; 
    $id = $this->input->get('id') ? $this->input->get('id') : '';

    $data['title'] = ( !empty($id) ? 'Update' : 'Register') .' Driver'; 
    $data['place'] = 'no';

    $table = 'driver';

    $data['id'] = '';
    $data['servicetype'] = '';
    $data['taxiowneruid'] = '';
    $data['uniqueid'] = ''; 
    $data['fullname'] = '';
    $data['email'] = '';
    $data['mobileno'] = '';
    $data['alternatemobile'] = '';
    $data['operationcity'] = '';
    $data['join_date'] = '';
 
    $data['completeprofile'] = 'no';
    $data['loginstatus'] = 'no';
    $data['dlnumber'] = '';
    $data['dlexpireon'] = '';
    $data['vehicle_cat_id'] = '';  
    $data['status'] = 'yes'; 
    $data['address'] = ''; 
    $data['zipcode'] = '';
    $data['dutystatus'] = 'off';
    $data['vehicleno'] = '';
    $data['termaccept'] = '';
    $data['aadhaar'] = '';
    $data['docs_verify'] = 'no';  

    $data['stateid'] = '';

    $data['id'] = $id;

	if($id){
    $dbdata = $this->c_model->getSingle( $table , array('id'=>$id) );
	$data['id'] = $dbdata['id'];  
    $data['uniqueid'] = $dbdata['uniqueid'];
    $data['fullname'] = $dbdata['fullname'];
    $data['email'] =  $dbdata['email'];
    $data['mobileno'] =  $dbdata['mobileno'];
    $data['alternatemobile'] =  $dbdata['alternatemobile'];
    $data['operationcity'] =  $dbdata['operationcity'];
    $data['join_date'] =  $dbdata['join_date'];
    $data['completeprofile'] =  $dbdata['completeprofile'];
    $data['loginstatus'] =  $dbdata['loginstatus'];
    $data['dlnumber'] = $dbdata['dlnumber'];
    $data['dlexpireon'] = $dbdata['dlexpireon'] && ($dbdata['dlexpireon']!='0000-00-00') ? date('m/d/Y',strtotime($dbdata['dlexpireon'])) : '';
    $data['vehicle_cat_id'] = $dbdata['vehicle_cat_id'];
    $data['status'] = $dbdata['status'];
    $data['address'] = $dbdata['address']; 
    $data['zipcode'] = $dbdata['zipcode'];
    $data['dutystatus'] = $dbdata['dutystatus'];
    $data['vehicleno'] = $dbdata['vehicleno'];
    $data['termaccept'] = $dbdata['termaccept'];
    $data['aadhaar'] = $dbdata['aadhaar'];
    $data['docs_verify'] = $dbdata['docs_verify'];
	}


$id ? $this->form_validation->set_rules('uniqueid', 'uniqueid', 'required',array('required'=>'Uniqueid is Blank.')) : '';

$this->form_validation->set_rules('fullname', 'fullname', 'required',array('required'=>'fullname is Blank.'));
$this->form_validation->set_rules('mobileno','mobileno','required',array('required'=>'Mobileno is Blank.'));

$this->form_validation->set_rules('vehicleno','vehicleno','required',array('required'=>'Vehicleno is Blank.'));

$this->form_validation->set_rules('vehicle_cat_id','vehicle_cat_id','required',array('required'=>'Vehicle Category is Blank.'));

$this->form_validation->set_rules('operationcity','operationcity','required',array('required'=>'City is Blank.'));



if($this->form_validation->run() == false){ 
$this->session->set_flashdata('error',strip_tags( validation_errors() ) );
}

	 if( $this->form_validation->run() != false){
		 
		$dbdata = $this->input->post(); 

		   
		$sdbdata['uniqueid'] = !empty($dbdata['uniqueid']) ? $dbdata['uniqueid'] : $dbdata['mobileno'];
		$sdbdata['fullname'] =  $dbdata['fullname'];
		$sdbdata['email'] =  $dbdata['email'];
		$sdbdata['mobileno'] =  $dbdata['mobileno'];
		$sdbdata['alternatemobile'] =  $dbdata['alternatemobile'];
		$sdbdata['operationcity'] =  $dbdata['operationcity'];
		$sdbdata['completeprofile'] = $dbdata['completeprofile'];
		$sdbdata['dlnumber'] =  $dbdata['dlnumber'];
		if($dbdata['dlexpireon']){
			$newdate = str_replace('/', '-', $dbdata['dlexpireon']);
		$sdbdata['dlexpireon'] = date('Y-m-d',strtotime($newdate));
		}
		
		$sdbdata['vehicle_cat_id'] = $dbdata['vehicle_cat_id']; 
		!$id ? ( $sdbdata['join_date'] = date('Y-m-d G:i:s') ) : ''; 
		$sdbdata['status'] = ($data['status'] == 'blacklist') ? 'blacklist' : $dbdata['status'];
		$sdbdata['address'] = trim($dbdata['address']); 
		 
		$sdbdata['zipcode'] = $dbdata['zipcode'];
		$sdbdata['dutystatus'] = ($dbdata['dutystatus'] == 'on') ? 'on' : 'off';
		$sdbdata['vehicleno'] = strtoupper($dbdata['vehicleno']); 
		$sdbdata['aadhaar'] =  $dbdata['aadhaar']; 
		$sdbdata['docs_verify'] = ($dbdata['docs_verify'] == 'yes') ? 'yes' : 'no';

		$checkpost['uniqueid'] = (strlen($sdbdata['uniqueid']) == 10) ? $sdbdata['uniqueid'] : null;  
		$checkitem = $this->c_model->countitem( $table, $checkpost ) ;
		
		 
		$postwhere = array( 'id'=> $id );
		 
		if( $id && $dbdata['uniqueid'] ){
		$ststus = $this->c_model->saveupdate( $table, $sdbdata, NULL, $postwhere, NULL );	
		$this->session->set_flashdata('success',"Profile updated successfully!");
		//redirect( adminurl( $currentpage.'/?id='.$id ));
		
		}else if( !$checkitem && !$id ){
		$ststus = $this->c_model->saveupdate( $table, $sdbdata, $sdbdata, NULL, NULL );
		$this->session->set_flashdata('success',"Profile added successfully!");
		  
		}else if( $checkitem ){
		$this->session->set_flashdata('error',"Mobile no is already exist please use another mobile no!");
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



	_view('registerdriver',$data);
}

}
?>