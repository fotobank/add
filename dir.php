<?php 
include (dirname(__FILE__).'/inc/config.php');
include (dirname(__FILE__).'/inc/func.php');
require (dirname(__FILE__).'/inc/i_resize.php');
require (dirname(__FILE__).'/inc/lib_ouf.php');
if (isset($_GET['num'])) {

   $file = (string) $_GET['num'];
	$file = 'id'.$file.'.jpg';
	$rs = $db->query('SELECT a.*, p.id_album FROM albums a, photos p WHERE p.img = ? && p.id_album = a.id LIMIT 1',array($file),'row');
	$foto_folder = $rs['foto_folder'];
	$watermark = $rs['watermark'];
	$ip_marker = $rs['ip_marker'];
	$sharping = $rs['sharping'];
   $quality = $rs['quality'];
	$dirname = $foto_folder.$rs['id'].'/';

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