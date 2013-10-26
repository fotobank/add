<?php 
if (isset($_GET['num'])) {
	$file = 'images/id'.trim($_GET['num']).'.jpg';
	if (is_file($file)) {
		header('Content-type: image/jpg');		
		readfile($file);
	}
}