<?php
include (dirname(__FILE__).'/inc/func.php');
include (dirname(__FILE__).'/inc/config.php');
include (dirname(__FILE__).'/inc/lib_ouf.php');

if(isset($_POST['login']))
{
  $udata = $db->query('select * from `users` where `login` = ? and `pass` = md5(?)', array($_POST['login'], $_POST['password']), 'row');
  if(!$udata)
  {
  	err_exit('Неправильный логин или пароль!', '/index.php');
  }
  else
  {
    if($udata['status'] == 0)
    {
    	err_exit('Login не активирован! Активируйте свой профиль с помощью письма, пришедшего на Ваш E-mail!', '/index.php');
    }
	    elseif ($udata['block'] == 0)
		    {
			    err_exit('Аккаунт заблокирован!', '/index.php');
		    }
       else
    {

		startSession("", intval($udata['id']));
      $_SESSION['logged'] = true;
      $_SESSION['userid'] = intval($udata['id']);
      $_SESSION['user'] = $udata['login'];
      $_SESSION['us_name'] = $udata['us_name'];
	   $db->query('INSERT INTO `actions`(`ip`, `user_event`, `id_user`,`brauzer`) VALUES (?string ,?i,?i,?string)',
	   array(Get_IP(),1,$udata['id'],$_SERVER['HTTP_USER_AGENT']));
      ok_exit('Вы успешно вошли на сайт!', '/index.php');
    }
  }
}

if(isset($_GET['logout']))
{

   $db->query('INSERT INTO `actions`(`ip`,`user_event`,`id_user`) VALUES (?string ,?i,?i)',array(Get_IP(),2, $_SESSION['userid']));
	unset($_SESSION['logged']);
	unset($_SESSION['userid']);
	unset($_SESSION['user']);
	unset($_SESSION['us_name']);
// session_destroy();
   destroySession();
   main_redir('/index.php');
}
err_exit('Данные для входа не введены!', '/index.php');
?>