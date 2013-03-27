<?php 
if (isset($_GET['num'])) {
	$dirname = 'images';
	$file = (string) $_GET['num'];
	$file = 'id'.$file.'.jpg';
	$file = $dirname . DIRECTORY_SEPARATOR . trim($file);
	if (is_file($file)) {
		//header('Content-Description: File Transfer');
		//header('Content-Type: application/octet-stream');
		//header('Content-Disposition: attachment; filename=' . basename($file));
		/*header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));*/
		header('Content-type: image/jpg');		
		readfile($file);
		exit();
	}
}