<?php
include (dirname(__FILE__).'/inc/config.php');
include (dirname(__FILE__).'/inc/func.php');

if(isset($_POST['login']))
{
  $rs = $db->query('select * from `users` where `login` = ? and `pass` = md5(?)', array($_POST['login'], $_POST['password']), 'row');
  if(!$rs)
  {
  	err_exit('������������ ����� ��� ������!', '/index.php');
  }
  else
  {
  	$udata = $rs;
    if($udata['status'] == 0)
    {
    	err_exit('Login �� �����������! ����������� ���� ������� � ������� ������, ���������� �� ��� E-mail!', '/index.php');
    }
    else
    {
      $_SESSION['logged'] = true;
      $_SESSION['userid'] = intval($udata['id']);
      $_SESSION['user'] = $udata['login'];
      $_SESSION['us_name'] = $udata['us_name'];
      ok_exit('�� ������� ����� �� ����!', '/index.php');
    }
  }
}

if(isset($_GET['logout']))
{
	unset($_SESSION['logged']);
	unset($_SESSION['userid']);
	unset($_SESSION['user']);
	unset($_SESSION['us_name']);
	session_destroy();
  main_redir('/index.php');
}
err_exit('������ ��� ����� �� �������!', '/index.php');
?>