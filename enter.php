<?php
  require_once (dirname(__FILE__).'/inc/func.php');
  require_once (dirname(__FILE__).'/inc/config.php');

if(isset($_POST['login']) && !empty($_POST['login']) && !empty($_POST['password'] ))
{
  $udata = $db->query('select * from `users` where `login` = ? and `pass` = md5(?)', array($_POST['login'], $_POST['password']), 'row');
  if(!$udata)
  {
  	err_exit('Неправильный логин или пароль!');
  }
  else
  {
    if($udata['status'] == 0)
    {
    	err_exit('Login не активирован! Активируйте свой профиль с помощью письма, пришедшего на Ваш E-mail!');
    }
	    elseif ($udata['block'] == 0)
		    {
			    err_exit('Аккаунт заблокирован!');
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
      ok_exit('Вы успешно вошли на сайт!');
    }
  }
} elseif(isset($_POST['login'])) {
  err_exit('Заполнены не все поля.');
}

if(isset($_GET['logout']))
{

   $db->query('INSERT INTO `actions`(`ip`,`user_event`,`id_user`) VALUES (?string ,?i,?i)',array(Get_IP(),2, $_SESSION['userid']));
	unset($_SESSION['logged']);
	unset($_SESSION['userid']);
	unset($_SESSION['user']);
	unset($_SESSION['us_name']);
   destroySession();
   main_redir('/index.php');
}

?>