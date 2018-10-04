<?php
require('inc/header.inc.php');
require('inc/auth.inc.php');
$data = $SZUserMgnt->getPreferences();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title></title>
 <LINK REL="StyleSheet" HREF="inc/admin.css" type="text/css">
</head>
<body>
<form action="settings.update.php" method="post">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="formheader" colspan="2">SZUserMgnt Mail Settings</td>
  </tr>
  <tr>
    <td class="formtext">Sender Name:</td>
    <td><input name="mail_sender_name" value="<?=$data[0]['mail_sender_name']?>"></td>
  </tr>
  <tr>
    <td class="formtext">Email:</td>
    <td><input name="mail_sender_email" value="<?=$data[0]['mail_sender_email']?>"></td>
  </tr>
  <tr>
    <td class="formtext">New Account Subject:</td>
    <td><input name="new_account_header" value="<?=$data[0]['new_account_header']?>"></td>
  </tr>
  <tr>
    <td class="formtext">New Account Body:<br></td>
    <td><textarea name="new_account_body"><?=$data[0]['new_account_body']?></textarea></td>
  </tr>
  <tr>
    <td class="formtext">Password Reminder Subject:</td>
    <td><input name="pwd_remind_header" value="<?=$data[0]['pwd_remind_header']?>"></td>
  </tr>
  <tr>
    <td class="formtext">Password Reminder Body:</td>
    <td><textarea name="pwd_remind_body"><?=$data[0]['pwd_remind_body']?></textarea></td>
  </tr>
  <tr>
    <td class="formtext" colspan="2"><button onclick="history.go(-1)" class="cancel">cancel</button>&nbsp;<button type="submit" class="save">save</button></td>
  </tr>
</table>
</form>
<br>
<br>
<a href="users.list.php">Administration</a> | <a href="users.levels.list.php">Security Levels</a> | <a href="settings.php">Settings</a>
</body>
</html>

