<?php defined('BASEPATH') or exit('No direct Access Allowed');

class Adsearch extends CI_controller{
	public function __construct(){
		parent::__construct(); 
		adminlogincheck();
	}

public function index(){

	$data = array(); 

    $type = $this->input->get('type') ? $this->input->get('type') : '';

   

    $data['type'] =  $type;
    $data['posturl'] =  $type; 
    $data['target'] = '';
    $data['uniqueid'] = '';

    $posturl = '';
    $data['param'] = array();
    $data['requestparam'] = 'operationcity'; 

      





	/* driver search start */
     if( $type == 'driver' ){
     $posturl = 'Viewdriver';
     $data['param']['filterby'] = 'city';
     $data['requestparam'] = 'requestparam'; 
     $data['uniqueid'] = 'uniqueid';
     $data['label'] = 'Aadhaar No/Mobileno/Full name';
     }
    /* driver search end */


    /* driver search start */
     else if( $type == 'customer' ){
     $posturl = 'front/Customerlist';
     $data['param']['filterby'] = 'city';
     $data['requestparam'] = 'requestparam'; 
     }
    /* driver search end */

 
     /* driver war room search start */
     else if( $type == 'dvrwaroom' ){
     $posturl = 'front/Warroomdriver';
     $data['param']['filterby'] = 'city';
     $data['requestparam'] = 'requestparam';
     $data['param']['action'] = 'track'; 
     $data['target'] = "_blank";
     $type = 'Driver War room ';
     }
    /* driver war room search end */

     /* driver war room list search start */
     else if( $type == 'dvrlistmap' ){
     $posturl = 'front/Warroomlist';
     $data['param']['filterby'] = 'city';
     $data['requestparam'] = 'requestparam';
     $data['target'] = "_blank"; 
     $type = 'Driver List ';
     }
    /* driver war room list search end */

     /* fare list search start */
     else if( $type == 'faresearch' ){
     $posturl = 'Viewcabfare';
     $data['param']['filterby'] = 'city';
     $data['requestparam'] = 'requestparam';
     $data['target'] = "_blank"; 
     $type = 'Fare List ';
     }
    /* fare list search  search end */


//echo $type; 

    $data['title'] = 'Search '. ucwords($type);  
	$data['posturl'] = adminurl($posturl);

	_view('adsearch',$data);
}

}
?>