<?php
require_once("image.class.php");
if(isset($_FILES["imagem"])) {
	$img = new image;
	$img->source($_FILES["imagem"]);
	// validade
	$img->validate_extension();
	$img->validate_dimension(4000,4000);
	$img->validate_size(2000);
	// get errors
	$erros = $img->error();
	if(count($erros) == 0) {
		$img->resize(800,NULL);
		$img->watermark("watermark.gif",60,"bottom","right");
		$img->create("resize.jpg");
	}
}
?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>resize</title>
</head>
<body>
<center>
	<form method="post" enctype="multipart/form-data">
		select a image
		<input name="imagem" type="file" size="25">
		<input type="submit" value="Submit">
	</form>
	<br>
	<?php if(isset($erros) && count($erros) != 0) : ?>
		<?php foreach($erros as $erro) : ?>
			<font color="#FF0000"><?php echo $erro ?></font><br>
		<?php endforeach; ?>
		<br>
	<?php endif; ?>
	<?php if(file_exists("resize.jpg")) : ?>
		<a href="crop.php">click here to crop the image</a><br>
		<br>
		<img src="resize.jpg">
	<?php endif ?>
</center>
</body>
</html>