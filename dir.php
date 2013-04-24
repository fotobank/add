<?php 
include (dirname(__FILE__).'/inc/config.php');
include (dirname(__FILE__).'/inc/func.php');
require (dirname(__FILE__).'/inc/i_resize.php');
if (isset($_GET['num'])) {

   $file = (string) $_GET['num'];
	$file = 'id'.$file.'.jpg';	
	$file_id = mysql_escape_string($file);		
	$rs = mysql_query("SELECT a.*, p.id_album FROM albums a, photos p WHERE p.img = '$file_id' && p.id_album = a.id LIMIT 1");
	$foto_folder = mysql_result( $rs, 0, foto_folder );
	$watermark = mysql_result( $rs, 0, watermark );
	$ip_marker = mysql_result( $rs, 0, ip_marker );
	$sharping = mysql_result( $rs, 0, sharping );
   $quality = mysql_result( $rs, 0, quality );
	$dirname = $foto_folder.mysql_result( $rs, 0, id ).'/';	
	$file_in = substr(($dirname),1) . $file;
	
	//var_dump ($dirname);
	$file_out = $file_in;
  if ($watermark == '1' || $ip_marker == '1') {
	    $file_out = 'tmp/'.$file;	   	    
      imageresize($file_out,$file_in,600,450,$quality,$watermark,$ip_marker,$sharping);
	if (is_file($file_out)) {		
		// отключен для защиты
		header('Content-type: image/jpg');
		readfile($file_out);		
		unlink($file_out); 		 			
	 }	
   }	 	
		// отключен для защиты
		header('Content-type: image/jpg');
		readfile($file_out);
		  
  exit();
}