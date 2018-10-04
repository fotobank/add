<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title></title>
 <LINK REL="StyleSheet" HREF="inc/admin.css" type="text/css">
</head>
<body>

<form name="formet" action="users.levels.add.php" method="post">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="formheader" colspan="2">Add Level</td>
  </tr>
  <tr>
    <td class="formtext">Level:</td>
    <td><input name="level"></td>
  </tr>
  <tr>
    <td class="formtext">Name:</td>
    <td><input name="level_name"></td>
  </tr>
  <tr>
    <td class="formtext" colspan="2"><button onclick="history.go(-1)" class="cancel">cancel</button>&nbsp;<button type="submit" class="save">save</button></td>
  </tr>
</table>
</form>
</body>
</html>

