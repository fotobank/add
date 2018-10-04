<?php
if($_REQUEST['active'] == "yes"){
require_once('server.cls.php');
$passport = new Passport;
if($passport->create_acc($_POST['user'], $_POST['pass'], $_POST['email'], $_POST['site'])){
echo ' Account Created ';
}else{
echo 'Eather username or email address has been used';
}

}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Account</title>
</head>

<body>
<form action="" method="post">
<input type="hidden" name="active" value="yes" />
<table width="276" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="132"><div align="right">Username</div></td>
    <td width="144"><input type="text" name="user" /></td>
  </tr>
  <tr>
    <td><div align="right">Password</div></td>
    <td><input type="password" name="pass" id="pass" /></td>
  </tr>
  <tr>
    <td><div align="right">Email Address</div></td>
    <td><input type="text" name="email" id="email" /></td>
  </tr>
  <tr>
    <td><div align="right">Web Site</div></td>
    <td><input type="text" name="site" id="site" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">
      <input type="submit" value="Create Account" />
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}
?>