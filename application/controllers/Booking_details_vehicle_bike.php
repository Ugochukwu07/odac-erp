<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_details_vehicle_bike extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

     public function index(){ 

        $req = $this->input->get();
        $id = base64_decode($req['id']);

 
            $where['a.pagetype'] = 'vehicle';
            $where['b.triptype !='] = 'outstation';
            $where['a.tableid'] = $id; 
            $where['a.domainid'] = '2'; 

            $select = 'a.id,a.metatitle,a.metadescription,a.metakeyword,a.titleorheading,a.summary,a.subject,a.cabname,a.pageurl, a.content, b.basefare,b.category,c.image '; 
            $from = 'pt_cms as a';

            $join[0]['table'] = 'pt_fare as b';
            $join[0]['on'] = 'a.tableid = b.modelid';
            $join[0]['key'] = 'LEFT'; 

            $join[1]['table'] = 'pt_vehicle_model as c';
            $join[1]['on'] = 'a.tableid = c.id';
            $join[1]['key'] = 'LEFT';  

            $orderby =  null;

            $fetch = $this->c_model->joindata( $select,$where, $from, $join, null,$orderby,1 );
            if(empty($fetch)){
               // redirect( base_url() );
            } 
            $fetch = !empty($fetch[0])?$fetch[0]:'';
            $data['openlist'] = $fetch;

            //print_r($fetch);
 
            $where = [];
            $where['a.pagetype'] = 'vehicle';
            $where['b.triptype !='] = 'outstation';
            //$where['a.tableid !='] = $id; 
            $where['a.domainid'] = '2'; 
            $where['b.category'] = !empty($fetch['category'])?$fetch['category']:'2'; 

            $select = ' a.tableid as id,a.cabname,b.category as catid'; 
            $from = 'pt_cms as a';
            
            $join = [];
            $join[0]['table'] = 'pt_fare as b';
            $join[0]['on'] = 'a.tableid = b.modelid';
            $join[0]['key'] = 'INNER'; 

            $fetchlist = $this->c_model->joindata( $select,$where, $from, $join, null,$orderby); 
            $data['vehiclelist'] = [];
            if(!empty($fetchlist)){

             $fetchlist = $this->uniqueAssocArray($fetchlist, 'id'); 
             $data['vehiclelist'] = $fetchlist ; 
            }
     	//$data = array(); 

        $data['aboutuscontent'] = !empty($fetch['content'])?$fetch['content']:''; 
        $data['metadescription'] = !empty($fetch['metadescription'])?$fetch['metadescription']:''; 
        $data['metasummary'] = !empty($fetch['summary'])?$fetch['summary']:''; 
        $data['metakeywords'] = !empty($fetch['metakeyword'])?$fetch['metakeyword']:''; 
        $data['title'] = !empty($fetch['metatitle'])?$fetch['metatitle']:''; 

        $data['currenturl'] = getcurrenturl();



        
        $this->load->view( 'includes/doctype',$data );
        $this->load->view( 'includes/meta_file',$data );
        $this->load->view( 'includes/allcss',$data );
        $this->load->view( 'includes/analytics_file',$data );
        $this->load->view( 'includes/header',$data );      	 
 



		$this->load->view( 'booking-details-vehicle-bike',$data );
		$this->load->view( 'includes/footer',$data );
		$this->load->view( 'includes/all-js',$data );
		$this->load->view( 'includes/footer-bottom',$data );

		}


private function uniqueAssocArray($array, $uniqueKey) {
if (!is_array($array)) {
    return array();
}
$uniqueKeys = array();
foreach ($array as $key => $item) {
    $groupBy=$item[$uniqueKey];
    if (isset( $uniqueKeys[$groupBy])) { 
        $replace= false; 
    }else{
        $replace=true;
    }
    if ($replace) $uniqueKeys[$groupBy] = $item;   
}
return $uniqueKeys;
}    


 
}
?>