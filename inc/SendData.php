<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 12.04.13
	 * Time: 12:55
	 * To change this template use File | Settings | File Templates.
	 */
	/*
	  Todo    - ajax скрипт восстановления пароля
	*/

	// обработка ошибок
	include (dirname(__FILE__).'/lib_mail.php');
	include (dirname(__FILE__).'/lib_ouf.php');
	include (dirname(__FILE__).'/lib_errors.php');
	$error_processor = Error_Processor::getInstance();
	include (dirname(__FILE__).'/config.php');
	include (dirname(__FILE__).'/func.php');
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	/* Проверить соединение */
	if (mysqli_connect_errno())
		{
			printf("Ошибка соединения: %s\n", mysqli_connect_error());
			exit();
		}
	$cryptinstall = '/inc/captcha/cryptographp.fct.php';
	include  'captcha/cryptographp.fct.php';

	/**
	 * @param $link
	 * @param $where
	 * @param $type
	 */
	function checkData($link, $where, $type)
		{

			$rs = mysqli_query($link, 'select * from users where '.$where);
			if (mysqli_errno($link) == 0 && mysqli_num_rows($rs) > 0)
				{
					$user_data = mysqli_fetch_assoc($rs);
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
					/* закрытие выборки */
					mysqli_free_result($rs);
					// Отправляем письмо
					if (!mail($user_data['email'], $subject, $letter, $headers))
						{
							if(isset($_SESSION['err_msg']))	$_SESSION['err_msg'] .= "Не удалось отправить письмо. Пожалуйста, попробуйте позже.<br>";
						}
					else
						{
							if(isset($_SESSION['ok_msg2']))	$_SESSION['ok_msg2'] =
								"Запрос выполнен.<br>Новый пароль отправлен на E-mail,<br> указанный Вами при регистрации.<br>";
						}
				}
			else
				{
					if(isset($_SESSION['err_msg'])) $_SESSION['err_msg'] .= "Пользователь с данным '$type' не найден.<br>";
				}
		}

	//Получаем данные
	if (isset($_SESSION['previos_data']) && md5($_POST['login'].$_POST['email'].$_POST['pkey']) != $_SESSION['previos_data'])
		{
			if (iconv("utf-8", "windows-1251", $_POST['login'].$_POST['email'].$_POST['pkey']) == "Введите Ваш логин:или E-mail:Код безопасности:")
				{
				if(isset($_SESSION['err_msg'])) $_SESSION['err_msg'] .= "Необходимо заполнить одно из полей.<br>";
				}
			else
				{
					if ($_POST['pkey'] == chk_crypt($_POST['pkey']))
						{
							$where = '';
							if (isset($_POST['login']))
								{
									$dataLogin = iconv("utf-8", "windows-1251", $_POST['login']);
									if ($dataLogin != "Введите Ваш логин:")
										{
											$login = trim(htmlspecialchars($dataLogin));
											if (!preg_match("/[?a-zA-Zа-яА-Я0-9_-]{3,16}$/", $login))
												{
													if(isset($_SESSION['err_msg2'])) 	$_SESSION['err_msg2'] .= "Логин может состоять из букв, цифр, дефисов и подчёркиваний. Длина от 3 до 16 символов.<br>";
													$where = 'false';
												}
											else
												{
													$where = ' login = \''.mysqli_escape_string($link, $login).'\'';
													$where = iconv("windows-1251", "utf-8", $where);
													checkData($link, $where, 'Login');
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
													if(isset($_SESSION['err_msg2'])) $_SESSION['err_msg2'] .= "Ошибочный 'E-mail' (пример: a@b.c)!<br>";
													$where = 'false';
												}
											else
												{
													$where = ' email = \''.mysqli_escape_string($link, $email).'\'';
													checkData($link, $where, 'E-mail');
												}
										}
								}
							if ($where == '')
								{
									if(isset($_SESSION['err_msg'])) 	$_SESSION['err_msg'] .= "Пожалуйста, заполните одно из полей!<br>";
								}
						}
					else
						{
							if(isset($_SESSION['err_msg'])) $_SESSION['err_msg'] .= "Неправильный ввод проверочного числа!<br>";
						}
				}
		}
	else
		{
			if(isset($_SESSION['err_msg'])) $_SESSION['err_msg'] = "Повторный ввод одинаковых данных!<br>";
		}
	if (isset($_SESSION['ok_msg2']))
		{
			$_SESSION['ok_msg2'] = "<p class='ttext_blue'>".$_SESSION['ok_msg2']."</p>";
			echo $_SESSION['ok_msg2'];
			unset($_SESSION['ok_msg2']);
		}
	else
		{
			if(isset($_SESSION['err_msg']))  $_SESSION['err_msg'] .= "<p class='ttext_red'>".$_SESSION['err_msg']."</p>";
			if(isset($_SESSION['err_msg2']))
				{
			echo $_SESSION['err_msg2'];
	         }
			elseif(isset($_SESSION['err_msg'])) echo $_SESSION['err_msg'];

		}
   $_SESSION['previos_data'] = md5($_POST['login'].$_POST['email'].$_POST['pkey']);
	unset($_SESSION['err_msg']);
	unset($_SESSION['err_msg2']);
	unset($_SESSION['secret_number']);
	mysqli_close($link);
?>
