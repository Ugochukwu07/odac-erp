<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Createxml extends CI_Controller{
	
	public function __construct(){
		parent::__construct();  
		}
	
	  

    public function index(){

    $baseurl = base_url();

    $priority = '1.00';
    $gmtformat = date('c',time()); 

    $output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

     	$fetch = $this->c_model->getAll('pt_cms',null,['status'=>'yes','domainid'=>'2'],'pagetype,tableid,pageurl');
        //echo '<pre>';
        //print_r($fetch);
        $bikedetailsurl = 'booking-details-vehicle-bike.php?id=';
        foreach ($fetch as $key => $value) {
            $output .='<url>'."\n";
            if($value['pagetype'] == 'seo'){
            $output .='<loc>'.$baseurl.$this->clean(trim($value['pageurl'])).'</loc>'."\n";   
            }else if($value['pagetype'] == 'vehicle'){
            $output .='<loc>'.$baseurl.$bikedetailsurl.base64_encode($value['tableid']).'</loc>'."\n";
            }
            
            $output .='<lastmod>'.$gmtformat.'</lastmod>'."\n";
            $output .='<priority>'.$priority.'</priority>'."\n";
            $output .='</url>'. "\n\n";
        }



/*static page start here */
$static = []; 
$static[] = '';
$static[] = 'car-bike-reservation.php';
$static[] = 'rent-a-bike-chandigarh.php';
$static[] = 'self-drive-in-chandigarh.php';
$static[] = 'terms-conditions.php';
$static[] = 'contact-us.php'; 
$static[] = 'disclaimer-policy.php';
$static[] = 'privacy-policy.php';
$static[] = 'refund-cancellation-policy.php';
$static[] = 'our-assossories.php';
$static[] = 'why-choose-us.php';
foreach ($static as $key => $values) {
    $output .='<url>'."\n";
    $output .='<loc>'.$baseurl.$values.'</loc>'."\n";
    $output .='<lastmod>'.$gmtformat.'</lastmod>'."\n";
    $output .='<priority>'.$priority.'</priority>'."\n";
    $output .='</url>'. "\n\n";
}

/*static page end here */




$output .='</urlset>';




$filepath = $baseurl;
$filename = 'sitemap.xml'; 
if(is_file($filename) && file_exists($filename)){
    @unlink($filename);
}

header('Content-type: text/xml');
file_put_contents($filename, $output);


 }

private function clean($string) {
   $string = str_replace(' ', '-', $string); 
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
} 
        
	
}
?>