<?php include ('inc/head.php');
?>
	<div id="main">


		<div style="text-align: center;">
			<div>
				<h2><b>
						<hremind>Регистрация на сайте:</hremind>
					</b></h2>
			</div>
		</div>
		<br>

		<div id="for_reg_cont">
			Регистрация необходима для хранения, покупки или бесплатного скачивания фотографий из фотобанка. Для всех
			зарегистрированных пользователей, активно принимающих участие в голосованиях за фотографии, предусмотрены
			скидочные бонусы и акции, а для пользователей, чьи фотографии набрали пять и более звездочек рейтинга в альбоме
			- бесплатная печать на профессиональном оборудовании. <br> Пожалуйста, внимательно заполните все поля и нажмите
			кнопку "отправить". Указывайте реально существующий email, на него будут приходить ссылки для скачивания
			выбранных Вами фотографий. Внимание! В целях безопасности, никому не передавайте свои логин и пароль! Пароль и
			логин могут состоять только из ЛАТИНСКИХ букв, цифр или подчеркивания. Желательно использовать пароль длиной
			больше семи символов, включающий в себя цифры, а также большие и маленькие буквы.
		</div>
		<br>

		<div id="form_reg">

			<?
			     $frm_reg='inline';
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
				{
					$rLogin = trim($_POST['rLogin']);
					$rPass = trim($_POST['rPass']);
					$rPass2 = trim($_POST['rPass2']);
					$rEmail = trim($_POST['rEmail']);
					$rName_us = trim($_POST['rName_us']);
					if ($rLogin == '')
						{
							echo("<div align='center' class='err_f_reg'>Поле 'Логин' не заполнено!</div>");
							// Логин может состоять из букв, цифр и подчеркивания
						}
					elseif (!preg_match("/^\w{3,}$/", $rLogin))
						{
							die("<div align='center' class='err_f_reg'>В поле 'Логин' введены недопустимые символы.<dr>Допускаются только латинские символы!</div>");
						}
					if ($rEmail == '')
						{
							die("<div align='center' class='err_f_reg'>Поле 'E-mail' не заполнено</div>");
							// Проверяем e-mail на корректность
						}
					elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $rEmail))
						{
							die("<div align='center' class='err_f_reg'>Указанный 'E-mail' имеет недопустимый формат</div>");
						}
					if ($rPass == '' || $rPass2 == '')
						{
							die("<div align='center' class='err_f_reg'>Поле 'Пароль' не заполнено</div>");
						}
					elseif ($rPass !== $rPass2)
						{
							die("<div align='center' class='err_f_reg'>Пароли не совпадают</div>");
							// Пароль может состоять из букв, цифр и подчеркивания
						}
					elseif (!preg_match("/^\w{3,}$/", $rPass))
						{
							die("<div align='center' class='err_f_reg'>В поле 'Пароль' введены недопустимые символы.Допускаются только латинские символы и цифры!</div>");
						}
					// В базе данных у нас будет храниться md5-хеш пароля
					$mdPassword = md5($rPass);
//   $mdPassword = $rPass;
					// А также временная метка (зачем - позже)
					$cnt = intval(mysql_result(mysql_query(
						'select count(*) cnt from users where login = \''.mysql_escape_string($rLogin).'\''), 0));
					if ($cnt > 0)
						{
							die('Пользовател с таким логином уже существует!');
						}
					$cnt = intval(mysql_result(mysql_query(
						'select count(*) cnt from users where email = \''.mysql_escape_string($rEmail).'\''), 0));
					if ($cnt > 0)
						{
							die('Пользовател с таким e-mail уже существует!');
						}
					$time = time();
					// Устанавливаем соединение с бд(не забудьте подставить ваши значения сервер-логин-пароль)
					mysql_query("INSERT INTO users (login, pass, email, us_name, timestamp)
                   VALUES ('$rLogin','$mdPassword','$rEmail','$rName_us',$time)");
					if (mysql_error() != "")
						{
							die("<div align='center' class='err_f_reg'>Пользователь с таким логином уже существует, выберите другой.</div>");
						}
					// Получаем Id, под которым юзер добавился в базу
					$id = mysql_result(mysql_query("SELECT LAST_INSERT_ID()"), 0);
// Составляем "keystring" для активации
					$key = md5(substr($rEmail, 0, 2).$id.substr($rLogin, 0, 2));
					$date = date("d.m.Y", $time);
// Компонуем письмо
					$title = 'Потвеждение регистрации на сайте Creative line studio';
					$headers = "Content-type: text/plain; charset=windows-1251\r\n";
					$headers .= "From: Администрация Creative line studio <webmaster@aleks.od.ua> \r\n";
//$headers .= "From: webmaster@aleks.od.ua <webmaster@aleks.od.ua> \r\n";
					$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
					$letter = <<< LTR
   Здравствуйте, $rName_us.
   Вы успешно зарегистрировались на Creative line studio.
   После активации аккаунта Вам станут доступны скачивание, покупка или голосование за понравившуюся фотографию.
   Так же для всех зарегистрированных пользователей предусмотрены различные бонусы и скидки.
   Ваши регистрационные данные:
      логин: $rLogin
      пароль: $rPass

   Для активации аккаунта вам следует пройти по ссылке:
   http://aleks.od.ua/activation.php?login=$rLogin&key=$key

   Данная ссылка будет доступна в течении 5 дней.

   $date
LTR;
// Отправляем письмо
					if (!mail($rEmail, $subject, $letter, $headers))
						{
							// Если письмо не отправилось, удаляем юзера из базы
							mysql_query("DELETE FROM users WHERE login='".$rLogin."' LIMIT 1");
							echo "<div align='center' class='err_f_reg'>Произошла ошибка при отправке письма. Попробуйте зарегистрироваться еще раз.</div>";
						}
					else
						{
							$frm_reg = 'none';
							echo "<div align='center' class='err_f_reg'>Вы успешно зарегистрировались в системе.
   <br>На указанный вами
   e-mail было отправлено письмо со ссылкой для активации аккаунта.
   </div>";
						}
				}

			?>

			<form action="" method="post" enctype="multipart/form-data" style="display:<?= $frm_reg ?>">
				<table>
					<tr>
						<td> Логин:</td>
						<td><input class="inp_f_reg" name="rLogin"></td>
					</tr>
					<tr>
						<td> Пароль:</td>
						<td><input class="inp_f_reg" type="password" name="rPass"></td>
					</tr>
					<tr>
						<td>Пароль ещё раз:</td>
						<td><input class="inp_f_reg" type="password" name="rPass2"></td>
					</tr>
					<tr>
						<td>Ваше имя:</td>
						<td><input name="rName_us" class="inp_f_reg" type="text"></td>
					</tr>
					<tr>
						<td>E-mail:</td>
						<td><input name="rEmail" class="inp_f_reg" type="text"></td>
					</tr>
				</table>
				<br>

				<div align="center"><input class="metall_knopka" name="ok" type="submit" value="Отправить"></div>
			</form>
		</div>
	</div>
	<div class="end_content"></div>
	</div>
<?php include ('inc/footer.php');
?>