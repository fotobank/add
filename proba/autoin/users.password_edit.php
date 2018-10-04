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
 <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
 <!--
 function generate(obj) {
   if (obj.checked) {
     document.all.formet.new_password.disabled = true;
     document.all.formet.confirm_password.disabled = true;
   } else {
     document.all.formet.new_password.disabled = false;
     document.all.formet.confirm_password.disabled = false;
   }
 }
 //-->
 </SCRIPT>
</head>
<body>

<form name="formet" action="users.password_update.php" method="post">
<input type="Hidden" name="ID" value="<?=$ID?>">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="formheader" colspan="2">Change Password For <?=$data[0]['username']?></td>
  </tr>
  <tr>
    <td class="formtext">New Password:</td>
    <td><input name="new_password" type="Password"></td>
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

