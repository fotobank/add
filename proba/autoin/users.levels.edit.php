<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
$data = $SZUserMgnt->getLevelInfo($ID);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title></title>
 <LINK REL="StyleSheet" HREF="inc/admin.css" type="text/css">
</head>
<body>

<form name="formet" action="users.levels.update.php" method="post">
<input type="Hidden" name="ID" value="<?=$ID?>">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="formheader" colspan="2">Edit Level</td>
  </tr>
  <tr>
    <td class="formtext">Level:</td>
    <td><input name="level" value="<?=$data[0]['level']?>"></td>
  </tr>
  <tr>
    <td class="formtext">Name:</td>
    <td><input name="level_name" value="<?=stripslashes($data[0]['level_name'])?>"></td>
  </tr>
  <tr>
    <td class="formtext" colspan="2"><button onclick="history.go(-1)" class="cancel">cancel</button>&nbsp;<button type="submit" class="save">save</button></td>
  </tr>
</table>
</form>
</body>
</html>

