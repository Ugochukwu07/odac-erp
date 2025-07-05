<?php 
header('Content-type: text/xml');
  $baseurl = "https://www.ranatravelschandigarh.com/";
 
define('DB_HOST', 'localhost');
define('DB_NAME','ranacxih_chandigarh');
define('DB_USER','ranacxih_chandig');
define('DB_PASSWORD','Rana$@%#FSRW874^%@%$$h');

$con = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die("Unable to connect to database");

 function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}



 
 
 
  $output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
 

?>
  <?php $query = "SELECT `pageurl` FROM `pt_add_pages` WHERE  `statusv`=1 and `pageurl`!='' LIMIT 0, 50000";
    $result = mysqli_query($con,$query);
    $res = array();
 
    while($resultSet = mysqli_fetch_array($result)) { 
 
 if(!empty($resultSet['pageurl'])) { 
 
 $output .='<url>
  <loc>'.$baseurl."".clean(trim($resultSet['pageurl'])).'</loc>
</url>';

}  } 
    
	
	$query2 = "select `id` from `pt_add_pages` where `pageurl`='0' and `pageurl`!='' and (`pagetype`='bikepage' or `pagetype`='carpage') LIMIT 0, 50000";
    $result2 = mysqli_query($con,$query2);
    
 
    while($resultSet2 = mysqli_fetch_array($result2)) { 
 
 if(!empty($resultSet2['id'])) { 
 
 $output .='<url>
  <loc>'.$baseurl."booking-details-vehicle-bike.php?id=".base64_encode($resultSet2['id']).'</loc>
</url>';

}  } 

	$query3 = "select `id` from `pt_add_pages` where  `pagetype`='selfdrive' LIMIT 0, 50000";
    $result3 = mysqli_query($con,$query3);
    
 
    while($resultSet3 = mysqli_fetch_array($result3)) { 
 
 if(!empty($resultSet3['id'])) { 
 
 $output .='<url>
  <loc>'.$baseurl."booking-details-selfdrive.php?id=".base64_encode($resultSet3['id']).'</loc>
</url>';

}  } 

$output .='</urlset>';


$filepath = "http://www.ranatravelschandigarh.com/";
 $filename = 'sitemap.xml';
file_put_contents($filename, $output);
@mysqli_close($con);
?>
