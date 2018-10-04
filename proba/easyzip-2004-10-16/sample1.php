<?

	require("class.easyzip.php");

	$z = new EasyZIP;
	$z -> addFile("peta.bmp");

	$z -> addFile("access.mdb");
	$z -> addFile("guide.pdf");
	
	//$z -> zipFile("package.zip");
	$z -> splitFile("split_pack.zip", 1048576);
?>