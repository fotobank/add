<?php 
if (isset($_GET['file'])) {
	$dirname = 'download';
	$file = (string) $_GET['file'];
	$file = $dirname . DIRECTORY_SEPARATOR . trim($file);
	if (is_file($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit();
	}
}