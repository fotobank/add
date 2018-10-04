<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title></title>
 <LINK REL="StyleSheet" HREF="inc/admin.css" type="text/css">
 <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
 <!--
 function generate(obj) {
   if (obj.checked) {
     document.all.formet.password.disabled = true;
     document.all.formet.confirm_password.disabled = true;
   } else {
     document.all.formet.password.disabled = false;
     document.all.formet.confirm_password.disabled = false;
   }
 }
 //-->
 </SCRIPT>
</head>
<body>

<form name="formet" action="users.add.php" method="post">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="formheader" colspan="2">Add User</td>
  </tr>
  <tr>
    <td class="formtext">Username:</td>
    <td><input name="username"></td>
  </tr>
  <tr>
    <td class="formtext">Email:</td>
    <td><input name="email"></td>
  </tr>
  <tr>
    <td class="formtext">Level:</td>
    <td><?=$SZUserMgnt->getSelectListLevels()?></td>
  </tr>
  <tr>
    <td class="formtext">Password:</td>
    <td><input name="password" type="Password"></td>
  </tr>
  <tr>
    <td class="formtext">Confirm Password:</td>
    <td><input name="confirm_password" type="Password"></td>
  </tr>
  <tr>
    <td></td>
    <td align="right"><input onclick="generate(this);" type="Checkbox" name="generate_password" value="1" class="radiocheck"> Generate Random Password</td>
  </tr>
  <tr>
    <td class="formtext" colspan="2"><button onclick="history.go(-1)" class="cancel">cancel</button>&nbsp;<button type="submit" class="save">save</button></td>
  </tr>
</table>
</form>
</body>
</html>

