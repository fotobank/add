<?php
define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
include (BASEPATH.'/inc/config.php');
include (BASEPATH.'/inc/func.php');
require (BASEPATH.'/inc/i_resize.php');

if (isset($_GET['num'])) {

	$file = 'id'.trim($_GET['num']).'.jpg';
	$rs = go\DB\query('SELECT a.*, p.id_album FROM albums a, photos p WHERE p.img = ? && p.id_album = a.id LIMIT 1',array($file),'row');
	$foto_folder = $rs['foto_folder'];
	$watermark = $rs['watermark'];
	$ip_marker = $rs['ip_marker'];
	$sharping = $rs['sharping'];
  $quality = $rs['quality'];
	$dirname = $foto_folder.$rs['id'].'/';
	$file_in = substr(($dirname), 1) . $file;
	


  if ($watermark == '1' || $ip_marker == '1') {

		$file_out = 'tmp/'. $file;
		imageresize($file_out,$file_in,600,450,$quality,$watermark,$ip_marker,$sharping);

		 if (is_file($file_out)) {
			  header("Content-type: image/jpg");
			  readfile($file_out);
			  unlink($file_out);
			}

  } else {

		header('Content-type: image/jpg');
		readfile($file_in);
  }
  exit();
}