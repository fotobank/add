<?php session_start(); ?>
<html>
<head>
<title>captcha</title>
</head>
<body>
<?php
if($_SESSION['secret_number']==""){
	$_SESSION['secret_number'] = "ABCD";
}
if(isset($_POST['comtext'])){
	if($_SESSION["secret_number"] != $_POST['pkey']){
		?><h1>Error</h1><?php
}
else{
	echo "Errors 2";
}
}
?>
<form name="product" action="message.php" method="post">
<table width="100%" border="0">
<tr>
<td><p>Имя пользователя:</p></td>
<td><input name="username" type="text" value="<? print($_POST['username']);?>" size="72"></td>
</tr>
<tr>
<td><p>Комментарий:</p></td>
<td><textarea cols="56" name="comtext" rows="20" wrap="virtual">
<? print(stripslashes($_POST['comtext'])); ?></textarea></td>
</tr>
<tr>
<td><p>Код безопасности:</p></td>
<td><input name="pkey" type="text" value="" size="50"><img src="captcha.php"></td>
</tr>
</table>
<p><input type="submit" value="Сохранить"></p>
</form>
</body>
</html>
