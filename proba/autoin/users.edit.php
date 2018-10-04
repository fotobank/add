<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
$data = $SZUserMgnt->getUser($ID);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title></title>
 <LINK REL="StyleSheet" HREF="inc/admin.css" type="text/css">
</head>
<body>

<form action="users.update.php" method="post">
<input type="Hidden" name="ID" value="<?=$ID?>">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="formheader" colspan="2">Edit User</td>
  </tr>
  <tr>
    <td class="formtext">Username:</td>
    <td><input name="username" value="<?=$data[0]['username']?>"></td>
  </tr>
  <tr>
    <td class="formtext">Email:</td>
    <td><input name="email" value="<?=$data[0]['email']?>"></td>
  </tr>
  <tr>
    <td class="formtext">Level:</td>
    <td><?=$SZUserMgnt->getSelectListLevels($data[0]['level'])?></td>
  </tr>
    <td class="formtext" colspan="2"><button onclick="history.go(-1)" class="cancel">cancel</button>&nbsp;<button type="submit" class="save">save</button></td>
  </tr>
</table>
</form>
</body>
</html>

