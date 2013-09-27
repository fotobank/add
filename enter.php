<?php
			define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
			require_once (BASEPATH.'/inc/func.php');
			require_once (BASEPATH.'/inc/config.php');
			$session = check_Session::getInstance();
			if (isset($_POST['login']) && !empty($_POST['login']) && !empty($_POST['password']))	{
						$udata = go\DB\query('select * from `users` where `login` = ? and `pass` = md5(?)', array($_POST['login'], $_POST['password']), 'row');
						if (!$udata)	{
									err_exit('Неправильный логин или пароль!');
						}	else	{
									if ($udata['status'] == 0)	{
												err_exit('Login не активирован! Активируйте свой профиль с помощью письма, пришедшего на Ваш E-mail!');
									}	elseif ($udata['block'] == 0)	{
												err_exit('Аккаунт заблокирован!');
									}	else	{
												startSession("", intval($udata['id']));
												$session->set('logged', true);
												$session->set('userid', intval($udata['id']));
												$session->set('user', $udata['login']);
												$session->set('us_name', $udata['us_name']);
												go\DB\query('INSERT INTO `actions`(`ip`, `user_event`, `id_user`,`brauzer`) VALUES (?string ,?i,?i,?string)',
																							array(Get_IP(), 1, $udata['id'], $_SERVER['HTTP_USER_AGENT']));
												ok_exit('Вы успешно вошли на сайт!');
									}
						}
			} elseif (isset($_POST['login'])) {
						err_exit('Заполнены не все поля.');
			}
			if (isset($_GET['logout']))	{
						go\DB\query('INSERT INTO `actions`(`ip`,`user_event`,`id_user`) VALUES (?string ,?i,?i)', array(Get_IP(), 2, $session->get('userid')));
						$session->del('logged');
						$session->del('userid');
						$session->del('user');
						$session->del('us_name');
						destroySession();
						main_redir('/index.php');
			}