<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 12.04.13
	 * Time: 12:55
	 * To change this template use File | Settings | File Templates.
	 */
	include __DIR__.'./config.php';
	include __DIR__.'./func.php';
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	/* Проверить соединение */
	if (mysqli_connect_errno())
		{
			printf("Ошибка соединения: %s\n", mysqli_connect_error());
			exit();
		}

	//Получаем данные
	if (isset($_POST[data]))
		{
			$data = $_POST[data];
			$data = iconv("utf-8", "windows-1251", $data);
			if ($data != $_SESSION['previos_data'])
				{
					$_SESSION['previos_data'] = $data;
					$subdata = explode("][", $data);
					if (isset($subdata[0]) and $subdata[0] != "Введите Ваш логин:")
						{
							$login = trim(htmlspecialchars($subdata[0]));
							if (!preg_match("/[?a-zA-Zа-яА-Я0-9_-]{3,16}$/", $login))
								{
									$_SESSION['err_msg2'] = "Логин может состоять из букв, цифр, дефисов и подчёркиваний. Длина от 3 до 16 символов.<br>";
								}
						}
					if (isset($subdata[1]) and $subdata[1] != "или E-mail:")
						{
							$email = trim(htmlspecialchars($subdata[1]));
							if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $email))
								{
									$_SESSION['err_msg'] .= "Неправильный 'E-mail'!<br>";
								}
						}

					$where = '';
					if (!empty($email))
						{
							$where = ' email = \''.mysqli_escape_string($link, $email).'\'';
						}
					elseif (!empty($login))
						{
							$where = ' login = \''.mysqli_escape_string($link, $login).'\'';
						}
					if ($data == "][")
						{
							$_SESSION['err_msg'] .= "Необходимо заполнить одно из полей.<br>";
						}
					if ($where == '')
						{
							$_SESSION['err_msg'] .= "Пожалуйста, заполните одно из полей!<br>";
						}
					else
						{
							$rs = mysqli_query($link, 'select * from users where '.$where);
							if (mysqli_errno($link) == 0 && mysqli_num_rows($rs) > 0)
								{
									$user_data = mysqli_fetch_assoc($rs);
									$title     = 'Восстановление пароля на сайте Creative line studio';
									$headers   = "Content-type: text/plain; charset=windows-1251\r\n";
									$headers .= "From: Администрация Creative line studio \r\n";
									$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
									$letter  = "Здравствуйте, $user_data[us_name]!\r\n";
									$letter .= "Кто-то (возможно, Вы) запросил восстановление пароля на сайте Creative line studio.\r\n";
									$letter .= "Данные для входа на сайт:\r\n";
									$letter .= "   логин: $user_data[login]\r\n";
									// создание нового пароля
									//$password = genpass(10, 3); // пароль с регулируемым уровнем сложности
									$password = genPassword(10);  // легкозапоминающийся пароль
									// шифровка и запись в базу
									getPassword($password, $user_data['id']) or die("Ошибка!");
									$letter .= "   пароль: $password\r\n";
									$letter .= "Если вы не запрашивали восстановление пароля, пожалуйста, немедленно свяжитесь с администрацией сайта!\r\n";
									/* закрытие выборки */
									mysqli_free_result($rs);
									// Отправляем письмо
									if (!mail($user_data['email'], $subject, $letter, $headers))
										{
											$_SESSION['err_msg'] .= "Не удалось отправить письмо. Пожалуйста, попробуйте позже.<br>";
										}
									else
										{
											$_SESSION['ok_msg2'] = "Запрос выполнен.<br>Новый пароль отправлен на Ваш E-mail.<br>";
										}
								}
							else
								{
									$_SESSION['err_msg'] .= "Пользователь не найден.<br>";
								}
						}
				}
			else
				{
					$_SESSION['err_msg'] .= "Повторный ввод одинаковых данных!<br>";
				}
		}
	$_SESSION['err_msg'] = "<p class='ttext_red'>".$_SESSION['err_msg']."</p>";
   $_SESSION['ok_msg2'] = "<p class='ttext_blue'>".$_SESSION['ok_msg2']."</p>";
	echo $_SESSION['err_msg2'].$_SESSION['err_msg'].$_SESSION['ok_msg2'];
	unset($_SESSION['err_msg']);
	unset($_SESSION['err_msg2']);
	unset($_SESSION['ok_msg2']);
	mysqli_close($link);


