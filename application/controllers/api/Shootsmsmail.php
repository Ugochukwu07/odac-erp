<?php defined("BASEPATH") OR exit("No Direct Access Allowed!");

class Shootsmsmail extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		    $this->load->helper('slip');
            header("Pragma: no-cache");
            header("Cache-Control: no-cache");
            header("Expires: 0"); 
		} 
	
	public function index(){ 
	    
	    $where = []; 
	    $where['crontab'] = 0;
	    $where['attemptstatus'] = 'new';
	    $getdata = $this->c_model->getSingle('pt_booking',$where,'*',null, 1 );
	    
	    if(!empty($getdata)){ 
    	    $up = $this->c_model->saveupdate('pt_booking',['crontab'=>1],null,['id'=>$getdata['id']]);
    	    
    	     /*******shifted on confirm booking on 26-Nov-2023 Start *********/
    	    $html = bookingslip($getdata,'adminmail');
    	     /*******shifted on confirm booking on 26-Nov-2023 End *********/
    	     if($getdata['apptype'] != 'A' ){
    	         //$shootsms = shootsms($getdata,'new');  
    	     } 
           
	    }
              
              
        echo  true;  
                
	}
	
	
}