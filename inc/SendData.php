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
	if(isset($_POST[data])
		{
	if	($_POST[data] != $_SESSION['previos_data'])
		{
	$data = $_POST[data];
	$_SESSION['previos_data'] = $_POST[data];
	$data = iconv("utf-8", "windows-1251", $data);
	$subdata = explode("][", $data);


	if (isset($subdata[0]) and $subdata[0] != "Введите Ваш логин:")
		{
			$login = trim(htmlspecialchars($subdata[0]));
			if (strlen($login) == "0")
				{
					$_SESSION['err_msg'] .= "Недопустимые символы в поле 'Ваш логин'<br>";
				}
		}

	if (isset($subdata[1]) and $subdata[1] != "или E-mail:")
		{
			$email = trim(htmlspecialchars($subdata[1]));
			if ((strlen($email) == "0") || (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i",$email)))
				{
					$_SESSION['err_msg'] .= "Неверный E-mail<br>";
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
			$_SESSION['err_msg'] = "Необходимо заполнить одно из полей.";
		}
	if ($where == '')
		{
			$_SESSION['err_msg'] = "Заполните одно из полей!";
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
					$password = mt_rand(1,10).mt_rand(10,50).mt_rand(50,100).mt_rand(100,1000) * 3;
					// шифровка и запись в базу
					getPassword($password,$user_data['id']) or die("Ошибка!") ;
					$letter .= "   пароль: $password\r\n";
					$letter .= "Если вы не запрашивали восстановление пароля, пожалуйста, немедленно свяжитесь с администрацией сайта!\r\n";
					/* закрытие выборки */
					mysqli_free_result($rs);
					// Отправляем письмо
					if (!mail($user_data['email'], $subject, $letter, $headers))
						{
							$_SESSION['err_msg'] = "Не удалось отправить письмо. Пожалуйста, попробуйте позже.";
						}
					else
						{
							$_SESSION['ok_msg2'] = "Запрос выполнен.<br>Новый пароль отправлен на Ваш E-mail.";
						}
				}
			else
				{
					$_SESSION['err_msg'] = "Пользователь не найден.";
				}
		}
		} else {$_SESSION['err_msg'] = "Повторный ввод одинаковых данных!"; }
		}
	echo $_SESSION['err_msg'].$_SESSION['ok_msg2'];
	unset($_SESSION['err_msg']);
	unset($_SESSION['ok_msg2']);
	mysqli_close($link);

