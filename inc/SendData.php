<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 12.04.13
	 * Time: 12:55
	 * To change this template use File | Settings | File Templates.
	 */
	/*
	*  Todo    - ajax скрипт восстановления пароля
	*/
header('Content-type: text/html; charset=windows-1251');
	// обработка ошибок
	include (dirname(__FILE__).'/lib_mail.php');
	include (dirname(__FILE__).'/lib_ouf.php');
	include (dirname(__FILE__).'/lib_errors.php');
	$error_processor = Error_Processor::getInstance();
	include (dirname(__FILE__).'/config.php');
	include (dirname(__FILE__).'/func.php');
//	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	/* Проверить соединение */
	/*if (mysqli_connect_errno())
		{
			printf("Ошибка соединения: %s\n", mysqli_connect_error());
			exit();
		}*/
	$cryptinstall = '/inc/captcha/cryptographp.fct.php';
	include  'captcha/cryptographp.fct.php';

/**
 * @param $where
 * @param $type
 *
 * @return string
 */
function checkData($where, $type)
		{
			$db = go\DB\Storage::getInstance()->get('db-for-data');
			$user_data = NULL;
			$error = false;
try {
			$user_data = $db->query('select * from users where ?col = ?', array($type,$where),'row');
} catch (go\DB\Exceptions\Exception  $e) {
	isset($_SESSION['err_msg']) ?	$_SESSION['err_msg'] .= 'Ошибка при работе с базой данных':
                                 $_SESSION['err_msg'] = 'Ошибка при работе с базой данных';
	$error = true;
}
			if ($error != true && $user_data)
				{
					$title     = 'Восстановление пароля на сайте Creative line studio';
					$headers   = "Content-type: text/plain; charset=windows-1251\r\n";
					$headers .= "From: Администрация Creative line studio \r\n";
					$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
					$letter  = "Здравствуйте,".iconv('utf-8', 'windows-1251', $user_data['us_name'])."!\r\n";
					$letter .= "Кто-то (возможно, Вы) запросил восстановление пароля на сайте Creative line studio.\r\n";
					$letter .= "Данные для входа на сайт:\r\n";
					$letter .= "   логин: ".iconv('utf-8', 'windows-1251', $user_data['login'])."\r\n";
					// создание нового пароля
					//$password = genpass(10, 3); // пароль с регулируемым уровнем сложности
					$password = genPassword(10); // легкозапоминающийся пароль
					// шифровка и запись в базу
					getPassword($password, $user_data['id']) or die("Ошибка!");
					$letter .= "   пароль: $password\r\n";
					$letter .= "Если вы не запрашивали восстановление пароля, пожалуйста, немедленно свяжитесь с администрацией сайта!\r\n";

					// Отправляем письмо
					if (!mail($user_data['email'], $subject, $letter, $headers))
						{
							isset($_SESSION['err_msg']) ?	$_SESSION['err_msg'] .= "Не удалось отправить письмо. Пожалуйста, попробуйте позже.<br>":
						                                 $_SESSION['err_msg'] = "Не удалось отправить письмо. Пожалуйста, попробуйте позже.<br>";
						}
					else
						{
							isset($_SESSION['ok_msg2']) ?
							  $_SESSION['ok_msg2'] .= "Запрос выполнен.<br>Новый пароль отправлен на E-mail,<br> указанный Вами при регистрации.<br>":
						     $_SESSION['ok_msg2']  = "Запрос выполнен.<br>Новый пароль отправлен на E-mail,<br> указанный Вами при регистрации.<br>";
						}
				  $ret = 'true';
				}
			else
				{
					isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "Пользователь с данным '$type' не найден.<br>":
				                                 $_SESSION['err_msg'] = "Пользователь с данным '$type' не найден.<br>";
				  $ret = 'false';
				}
		  return $ret;
		}

$_SESSION['err_msg'] = $_SESSION['err_msg2'] = $_SESSION['ok_msg2'] = '';

	//Получаем данные
	if (!isset($_SESSION['previos_data']) || $_SESSION['previos_data'] != md5($_POST['login'].$_POST['email'].$_POST['pkey']))
		{
			if (iconv("utf-8", "windows-1251", $_POST['login'].$_POST['email'].$_POST['pkey']) == "Введите Ваш логин:или E-mail:Код безопасности:")
				{
				isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "Необходимо заполнить одно из полей.<br>":
				                              $_SESSION['err_msg'] = "Необходимо заполнить одно из полей.<br>";
				}
			else
				{
					if ($_POST['pkey'] == chk_crypt($_POST['pkey']))
						{
							if (isset($_POST['login']))
								{
									$dataLogin = iconv("utf-8", "windows-1251", $_POST['login']);
									if ($dataLogin != "Введите Ваш логин:")
										{
											$login = trim(htmlspecialchars($dataLogin));
											if (!preg_match("/[?a-zA-Zа-яА-Я0-9_-]{3,16}$/", $login))
												{
													isset($_SESSION['err_msg2']) ?
													  $_SESSION['err_msg2'] .= "Логин может состоять из букв, цифр, дефисов и подчёркиваний. Длина от 3 до 16 символов.<br>":
												     $_SESSION['err_msg2']  = "Логин может состоять из букв, цифр, дефисов и подчёркиваний. Длина от 3 до 16 символов.<br>";
													  $where = 'false';
												}
											else
												{
													$login = iconv("windows-1251", "utf-8", $login);
												   $where = checkData($login, 'login');
												}
										}
								}
							if (isset($_POST['email']))
								{
									$dataEmail = iconv("utf-8", "windows-1251", $_POST['email']);
									if ($dataEmail != "или E-mail:")
										{
											$email = trim(htmlspecialchars($dataEmail));
											if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $email))
												{
													isset($_SESSION['err_msg2']) ? $_SESSION['err_msg2'] .= "Ошибочный 'E-mail' (пример: a@b.c)!<br>":
												                                  $_SESSION['err_msg2'] = "Ошибочный 'E-mail' (пример: a@b.c)!<br>";
													$where = 'false';
												}
											else
												{
												  $where = checkData($email, 'email');
												}
										}
								}

						   if (empty($_POST['email']) && empty($_POST['login'])) $where = '';

							if ($where == '')
								{
									isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "Пожалуйста, заполните одно из полей!<br>":
								                                 $_SESSION['err_msg']  = "Пожалуйста, заполните одно из полей!<br>";
								}

						  if ($where == 'false')
							 {
								isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "Пользователь не найден.":
								                              $_SESSION['err_msg']  = "Пользователь не найден.";
							 }

						}
					else
						{
							isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "Неправильный ввод проверочного числа!<br>":
						                                 $_SESSION['err_msg'] = "Неправильный ввод проверочного числа!<br>";
						}
				}
		 }
	  elseif($_SESSION['previos_data'] == "b894200597453166c8ff8dd7d7488263")
		 {
			isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "<p class='ttext_red'>Для напоминания пароля необходимо заполнить<br> одно из полей.</p><br>":
			                              $_SESSION['err_msg'] = "<p class='ttext_red'>Для напоминания пароля необходимо заполнить<br> одно из полей.</p><br>";
		 }
	  else
		 {
			isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "<p class='ttext_red'>Повторный ввод одинаковых данных!</p><br>":
			                              $_SESSION['err_msg'] = "<p class='ttext_red'>Повторный ввод одинаковых данных!</p><br>";
		 }


	if (isset($_SESSION['ok_msg2']) && $_SESSION['ok_msg2'] != '')
		{
			$_SESSION['ok_msg2'] = "<p class='ttext_blue'>".$_SESSION['ok_msg2']."</p>";
			echo $_SESSION['ok_msg2'];
			unset($_SESSION['ok_msg2']);
		}
	else
		{
			if(isset($_SESSION['err_msg2']) && $_SESSION['err_msg2'] != '')
				{
			     echo $_SESSION['err_msg2'];
	         }
			elseif(isset($_SESSION['err_msg']) && $_SESSION['err_msg'] != '')
            {
	            echo $_SESSION['err_msg'];
            }


		}
   $_SESSION['previos_data'] = md5($_POST['login'].$_POST['email'].$_POST['pkey']);
   unset($_SESSION['err_msg']);
   unset($_SESSION['err_msg2']);
   unset($_SESSION['ok_msg2']);
	unset($_SESSION['secret_number']);
	$db->close();
?>
