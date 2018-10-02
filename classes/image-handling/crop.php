<?php
require_once("image.class.php");
if(isset($_POST["x"])) {
	$x = $_POST["x"];
	$y = $_POST["y"];
	$width = $_POST["width"];
	$height = $_POST["height"];
	// crop
	$img = new image();
	$img->source("resize.jpg");
	$img->crop($x,$y,$width,$height);
	$img->create("crop.jpg");
	// resize
	$img->source("crop.jpg");
	$img->resize(300);
	$img->watermark("wm.gif",30,"bottom","right");
	$img->create("crop.jpg");
}
?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>crop</title>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.jcrop.js"></script>
<link rel="stylesheet" href="js/jquery.jcrop.css" type="text/css" />
<script language="Javascript">
	jQuery(document).ready(function() {
		jQuery('#cropbox').Jcrop({
			onChange: show_coords,
			onSelect: show_coords,
			aspectRatio: 4/3,
			setSelect: [20,20,320,240]
		});

	});
	function show_coords(c) {
		jQuery('#x').val(c.x);
		jQuery('#y').val(c.y);
		jQuery('#x2').val(c.x2);
		jQuery('#y2').val(c.y2);
		jQuery('#w').val(c.w);
		jQuery('#h').val(c.h);
	};
</script>
</head>
<body>
<center>
<?php if(file_exists("resize.jpg")) : ?>
	<img src="resize.jpg" id="cropbox" /><br>
	<form method="post" enctype="multipart/form-data">
		<input type="hidden" name="x" id="x" />
		<input type="hidden" name="y" id="y" />
		<input type="hidden" name="width" id="w" />
		<input type="hidden" name="height" id="h" />
		<input type="submit" value="Crop">
	</form>
<?php else : ?>
	<meta http-equiv="refresh" content="0;url=resize.php">
<?php endif; ?>
<?php if(file_exists("crop.jpg")) : ?>
	<br>croped image<br>
	<img src="crop.jpg">
<?php endif; ?>
</center>
</body>
</html>