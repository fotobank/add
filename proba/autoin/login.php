<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title></title>
 <LINK REL="StyleSheet" HREF="inc/admin.css" type="text/css">
</head>
<body>

<form action="login.verify.php" method="post">
<input type="Hidden" name="rememberme" value="0">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="formheader" colspan="2">Webpage Login</td>
  </tr>
  <tr>
    <td class="formtext">Username:</td>
    <td><input name="username"></td>
  </tr>
  <tr>
    <td class="formtext">Password:</td>
    <td><input name="password" type="Password">&nbsp;<button type="submit" class="save">login</button></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="Checkbox" name="rememberme" value="1" class="radiocheck"> Remember me</td>
  </tr>
  <tr>
    <td height="50"></td>
  </tr>
  <tr>
    <td class="formtext">Administrator:</td>
    <td>L/P: admin/admin</td>
  </tr>
  <tr>
    <td class="formtext">Normal User:</td>
    <td>L/P: standard/standard</td>
  </tr>
</table>
</form>
</body>
</html>
