<?php
session_start();
require_once "class_protect_picture.php";
$ppicture = new protect_picture(session_id());
?>
<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
       <title>Title here!</title>
</head>
<body>
<img SRC="./icon.gif" width="160">
<img src='./folder/test.jpg' width="160">
<img src='test.jpg' width="160">
<input type='image' src='submit.jpg' width="160">
<img alt="Text" src="filename.jpg">
<img src=example.jpg>
<img
src="filename.jpg">
</body>
</html>
<?php
$ppicture->protect();
?>
