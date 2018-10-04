<?php
session_start();
if($_REQUEST['active'] == 'yes'){// Have they used the login form
require_once('login.cls.php'); // Load Class into memory
$passport = new Passport; // connect to memeory
$passport->login($_POST['user'], $_POST['pass'], 'rjky6t5bg437', 'r5kjp9lk'); // handle login

if(isset($_SESSION['userid'])){// what to do when users are loged in

}
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post">
<input type="hidden" name="active" value="yes" />
<table width="208" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="117"><div align="right">Username:</div></td>
    <td width="144"><input type="text" name="user" /></td>
  </tr>
  <tr>
    <td><div align="right">Password:</div></td>
    <td><input type="password" name="pass" id="pass" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">
      <input type="submit" value="Login" />
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}
?>