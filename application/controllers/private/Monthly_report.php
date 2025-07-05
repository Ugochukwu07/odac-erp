 <?php defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly_report extends CI_Controller{
	
	  function __construct() {
         parent::__construct(); 
		  adminlogincheck();
      }
	


  public function index() {

			$data = [];  

	        $title = 'Monthly Report';
	        $data['title'] = $title;
	        $data['list'] = [];
			$data['totalrows'] = 0;
	        $get = $this->input->get();
	        $pagename = 'monthly_report';
	       
		 
 
			 
			
        
        $where = '';

        /*filter script start here*/
        $n = isset($get['n']) && !empty($get['n'])?trim($get['n']):false;
        $f = isset($get['f']) && !empty($get['f'])?trim($get['f']):false;
        $t = isset($get['t']) && !empty($get['t'])?trim($get['t']):false;
        $data['n'] = $n;
        $data['f'] = $f;
        $data['t'] = $t; 
        
        if(!empty($f) && !empty($t) ){
        $where .= "(YEAR(`pickupdatetime`) >=  ".date('Y',strtotime($f))." AND MONTH(`pickupdatetime`) >= '".date('m',strtotime($f))."') "; 
        $where .= " AND (YEAR(`pickupdatetime`) <= ".date('Y',strtotime($t))." AND MONTH(`pickupdatetime`) <= '".date('m',strtotime($t))."') "; 
        }else{
          $where .= "(YEAR(`pickupdatetime`) >= ".date('Y')." AND MONTH(`pickupdatetime`) >= '".date('m')."') ";     
        }
        /*filter script start here*/
 
        $sqlQuery = "SELECT 
                    COUNT(id) AS total_id,
                    YEAR(`pickupdatetime`) AS year,
                    MONTHNAME(`pickupdatetime`) AS month,
                    SUM(`totalamount`) AS total_amount,
                    SUM(`bookingamount`) AS booking_amount,
                    SUM(`restamount`) AS rest_amount
                    FROM 
                    pt_booking
                    WHERE 
                    attemptstatus NOT IN ('cancel', 'temp') AND 
                    ".$where."
                    GROUP BY 
                    YEAR(`pickupdatetime`), MONTH(`pickupdatetime`)
                    ORDER BY 
                    YEAR(`pickupdatetime`), MONTH(`pickupdatetime`);
                    ";
                    
                //   echo $sqlQuery;
                //     exit;
 
        $getdata = $this->db->query( $sqlQuery )->result_array();
 
			 
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