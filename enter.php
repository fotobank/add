<?php
include 'inc/config.php';
include 'inc/func.php';

if(isset($_POST['login']))
{  $rs = mysql_query('select * from users where login = \''.mysql_escape_string($_POST['login']).'\' and pass = \''.mysql_escape_string($_POST['password']).'\'');
  if(mysql_num_rows($rs) == 0)
  {  	err_exit('Неправильный логин или пароль!', '/index.php');  }
  else
  {  	$udata = mysql_fetch_assoc($rs);
    if($udata['status'] == 0)
    {    	err_exit('Для начала активируйте свой логин через e-mail!', '/index.php');    }
    else
    {      $_SESSION['logged'] = true;
      $_SESSION['userid'] = intval($udata['id']);
      $_SESSION['user'] = $udata['login'];
      $_SESSION['us_name'] = $udata['us_name'];
      ok_exit('Вы успешно вошли на сайт!', '/index.php');
    }
  }}

if(isset($_GET['logout']))
{	unset($_SESSION['logged']);
	unset($_SESSION['userid']);
	unset($_SESSION['user']);
	unset($_SESSION['us_name']);
	session_destroy();
  main_redir('/index.php');
}
err_exit('Данные для входа не введены!', '/index.php');
?>