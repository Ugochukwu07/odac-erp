 <?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_list extends CI_Controller{
	
	  function __construct() {
         parent::__construct(); 
		  adminlogincheck();
      }
	


  public function index() {

			$data = [];
			$output = []; 

	        $title = 'Payment List';
	        $data['title'] = $title;
	        $data['list'] = [];
			$data['totalrows'] = 0;
	        $get = $this->input->get();
	        $pagename = 'payment_list';
	        

			 
			$where = []; 
			   
			$data['totalpage'] = NULL;
			$data['page'] = NULL;
			$data['prebtn'] = NULL;
			$data['nxtbtn'] = NULL;
			$data['startbtn'] = NULL;
			$data['endbtn'] = NULL;
 
			 
			
	//$where['a.attemptstatus'] = $bookingtype;
	
$like = null;
$likekey = null;
$likeaction = null; 

/*filter script start here*/
$n = isset($get['n']) && !empty($get['n'])?trim($get['n']):false;
$f = isset($get['f']) && !empty($get['f'])?trim($get['f']):false;
$t = isset($get['t']) && !empty($get['t'])?trim($get['t']):false;
$type =  !empty($get['type'])?trim($get['type']):'';
$data['n'] = $n;
$data['f'] = $f;
$data['t'] = $t;
$ismobile = filter_var($n,FILTER_SANITIZE_NUMBER_INT); 
if( strlen($ismobile) == 10 ){
$where['a.add_by'] = $ismobile;
}else if( strpos($n, 'RCPL') !== FALSE ){
$where['c.bookingid'] = $n;
}else if(!empty($n)){
$like = $n;
$likekey = 'b.fullname';
$likeaction = 'both';
}

if(!empty($f) && !empty($t) ){
$where['DATE(a.added_on) >='] = $f;
$where['DATE(a.added_on) <='] = $t;
}
/*filter script start here*/


if($type == 'todaycollection'){
     $where[" c.attemptstatus  NOT IN('cancel','temp','reject')"] = NULL;  
}


$select = 'b.fullname,a.*,c.bookingid,c.triptype,c.attemptstatus';
$from = 'pt_payment_log as a'; 
$join[0]['table'] = 'pt_roll_team_user as b';
$join[0]['on'] = 'a.add_by = b.mobile';
$join[0]['key'] = 'LEFT';

$join[1]['table'] = 'pt_booking as c';
$join[1]['on'] = 'a.booking_id = c.id';
$join[1]['key'] = 'LEFT';

$groupby  = null;
$orderby = 'a.id DESC';
$limit = null;

$in_not_in = null; 


$getdata = $this->c_model->joindata( $select, $where, $from, $join, $groupby,$orderby,$limit,$in_not_in,$like,$likekey,$likeaction);
//echo $this->db->last_query(); exit;
 
			
			if( !empty($getdata) ){ 
				 $data['list'] = $getdata;
				 $data['totalrows'] = count($getdata);
			}
  	        /*********************check user type ******************************/
 
//  echo '<pre>'; print_r($getdata);
// exit;


	  


	   $data['title'] = $title .' &nbsp; [ <span style="font-size:12px;color:red">   Total Records: '.$data['totalrows'].' </span>]'; 
		     
 
			 
		    _viewlist( $pagename, $data ); 
 
	    
   }
 

}
?>