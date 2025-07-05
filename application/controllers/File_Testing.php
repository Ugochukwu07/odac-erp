<?php defined('BASEPATH') OR exit('No direct script access allowed');

class File_Testing extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		} 
		

     public function index(){ 
         
         $start = $this->input->get('from');
         $end = $this->input->get('end');
         
         
         echo $days = getdays($start,$end); exit;
         
         
         $amount = $this->input->get('amount');
// Example usage:
//$amount = 1000; // Replace this with your actual simple interest
$rate = 18; // Replace this with your actual interest rate
$time = 1; // Replace this with your actual time in years

$principal = round( calculatePrincipal($amount, $rate ) );

echo "Principal amount is: " . $principal;
echo '<br/>';
echo "Interest amount is: " . round( $amount - $principal );
echo '<br/>';
echo "Total amount is: " . ( $amount);

     }
}?>