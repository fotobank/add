<?php
require('inc/header.inc.php');
require('inc/auth.inc.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title></title>
 <LINK REL="StyleSheet" HREF="inc/admin.css" type="text/css">
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>Welcome to the password protected area!</td>
  </tr>
  <tr>
    <td align="right"><a href="logout.php">Logout</a></td>
  </tr>
</table>

<form name="formet" action="page.changepassword.php" method="post">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="formheader" colspan="2">Change Password</td>
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
    <td class="formtext">Old Password:</td>
    <td><input name="old_password" type="Password"></td>
  </tr>
  <tr>
    <td class="formtext" colspan="2"><button onclick="history.go(-1)" class="cancel">cancel</button>&nbsp;<button type="submit" class="save">save</button></td>
  </tr>
</table>
</form>
</body>
</html>

