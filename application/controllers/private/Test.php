<?php defined('BASEPATH') or exit('No Access');

class Test extends CI_Controller{
	
function getPreviousThreeMonths() {
    $currentMonth = date('Y-m-d'); 
    $previousMonths = array();    
    
    for ($i = 1; $i <= 4; $i++) { 
          $endMonth = $i == 1 ? $currentMonth : end( $previousMonths );
          $previousMonth = date('Y-m-d', strtotime( $endMonth."  -28 days"));
          $previousMonths[] = $previousMonth; 
    } 
    return $previousMonths;
}


	public function index(){
		$list = $this->getPreviousThreeMonths();
		echo '<pre>';
		print_r($list );

	}
}

?>