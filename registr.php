<?php
 include (dirname(__FILE__).'/inc/head.php');
  if(!isset($_SESSION['logged'])) {


	 ?>
 <div id="main">
 <?
 $rLogin = 'Имя для входа (Login)';
 $rPass = '';
 $rPass2 = '';
 $rEmail = 'Рабочий E-mail';
 $rSkype = 'Не обязательно';
 $rPhone = 'Можно ввести потом';
 $rName_us = 'Настоящее имя';
 if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	 $rLogin   = trim($_POST['rLogin']);
	 $rPass    = trim($_POST['rPass']);
	 $rPass2   = trim($_POST['rPass2']);
	 $rEmail   = trim($_POST['rEmail']);
	 $rName_us = trim($_POST['rName_us']);
	 $rPhone   = trim($_POST['rPhone']);
	 $rSkype   = trim($_POST['rSkype']);
	 $rPkey    = trim($_POST['rPkey']);
	 $rIp      = Get_IP();
	 if ($rLogin != 'Псевдоним для входа')
		{
		 if (preg_match("/[?a-zA-Zа-яА-Я0-9_-]{3,20}$/", $rLogin))
			{
			 if ($rEmail != 'Рабочий E-mail')
				{
				 if ($rName_us != 'Настоящее имя' || preg_match("/[?a-zA-Zа-яА-Я0-9_-]{2,20}$/", $rName_us))
					{
					 if (preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $rEmail))
						{
						 if ($rPass != '' || $rPass2 != '')
							{
							 if ($rPass === $rPass2)
								{
								 if (preg_match("/^[0-9a-z\_\-\!\~\*\:\<\>\+\.]{8,20}$/i", $rPass))
									{
									 $mdPassword = md5($rPass);
									 $cnt        = intval($db->query('select count(*) cnt from users where login = ?string',array($rLogin),'el'));

									 if ($cnt <= 0)
										{
										 $cnt = intval($db->query('select count(*) cnt from users where email = ?string',
											array($rEmail),
											'el'));
										 if ($cnt <= 0)
											{
											 if ($rPhone == 'Можно ввести потом')
												{
												 $rPhone = '';
												}
											 if ((strlen($rPhone) == '')
												|| (strlen($rPhone) >= 7)
												 && (!preg_match("/[%a-z_@.,^=:;а-я\"*()&$#№!?<>\~`|[{}\]]/i",
													$rPhone))
											 )
												{
												 if ($rSkype == 'Не обязательно')
													{
													 $rSkype = '';
													}
												 $time = time();
// проверка капчи
												 if ($rPkey == chk_crypt($rPkey))
													{
// Устанавливаем соединение с бд(не забудьте подставить ваши значения сервер-логин-пароль)
													 try
														{
// Получаем Id, под которым юзер добавился в базу
														 $id = $db->query('INSERT INTO users (login, pass, email, us_name, timestamp, ip, phone, skype)
                             VALUES (?,?,?,?,?i,?,?,?)',
															array($rLogin, $mdPassword, $rEmail, $rName_us, $time, $rIp, $rPhone, $rSkype),
															'id');
														}
													 catch (go\DB\Exceptions\Exception  $e)
														{
														 trigger_error("Ошибка при работе с базой данных во время регистрации пользователя! Файл - registr.php.");
														 $err_msg = "Ошибка при работе с базой данных!";
														 die("<div align='center' class='err_f_reg'>Ошибка при работе с базой данных!</div>");
														}
// Составляем "keystring" для активации
													 $key  = md5(substr($rEmail, 0, 2).$id.substr($rLogin,
														0,
														2));
													 $date = date("d.m.Y", $time);
// Компонуем письмо
													 $title   = 'Потвеждение регистрации на сайте Creative line studio';
													 $headers = "Content-type: text/plain; charset=windows-1251\r\n";
													 $headers .= "From: Администрация Creative line studio <webmaster@aleks.od.ua> \r\n";
													 $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title,
														"w",
														"k")).'?=';
													 $letter = <<< LTR
													  Здравствуйте, $rName_us.
													  Вы успешно зарегистрировались на Creative line studio.
													  После активации аккаунта Вам станут доступны скачивание, покупка или голосование за понравившуюся фотографию.
													  Так же для всех зарегистрированных пользователей предусмотрены различные бонусы и скидки.
													  Ваши регистрационные данные:
														  логин: $rLogin
														  пароль: $rPass

													  Для активации аккаунта вам следует пройти по ссылке:
													  http://$_SERVER[HTTP_HOST]/activation.php?login=$rLogin&key=$key

													  Данная ссылка будет доступна в течении 5 дней.

													  $date
LTR;
												  // Отправляем письмо
													 if (!mail($rEmail,
														$subject,
														$letter,
														$headers)
													 )
														{
														 // Если письмо не отправилось, удаляем юзера из базы
														 $db->query('DELETE FROM users WHERE login= (?string) LIMIT 1',
															array($rLogin));
														 $err_msg = "Произошла ошибка при отправке письма.<br> Попробуйте зарегистрироваться еще раз.";
														}
													 else
														{
														 unset ($err_msg);

														  echo "<div align='center' class='drop-shadow lifted' style='position: relative; margin:40px 0 0 280px;
														                 padding-bottom: 3px; padding-left: 20px; padding-right: 20px;'>
                                                     Вы успешно зарегистрировались в системе.
																 <br>На указанный вами e-mail было отправлено письмо со ссылкой для активации аккаунта.
																 </div><div style='clear: both;'></div>";
														  print "<script language='Javascript' type='text/javascript'>
																	<!--
																   humane.timeout = (10000);
                     humane.success('Спасибо.<br>Вы успешно зарегистрировались в системе.<br>На указанный вами e-mail было отправлено письмо со ссылкой для активации аккаунта.');
																	function reLoad()
																	{location = \"registr.php\"};
																	setTimeout('reLoad()', 14000);
																	-->
																	</script>";
														}
													}
												 else
													{
													 $err_msg = "Неправильны ввод проверочного числа!";
													}

												}
											 else
												{
												 $err_msg = "Телефон указан неправильно! (должно быть больше 6 цифр)";
												}
											}
										 else
											{
											 $err_msg
												= "Пользователь с таким E-mail уже существует!<br>Нажмите на восстановление пароля или зарегистрируйтесь на другой E-mail.";
											}
										}
									 else
										{
										 $err_msg = "Пользователь с таким логином уже существует!";
										}

									}
								 else
									{
									 $err_msg = "В поле `Пароль` введены недопустимые символы<br> или длина меньше 8 символов.<br> Допускаются только английские символы, цифры и знаки<br>  . - _ ! ~ * : < > + ";
									}
								}
							 else
								{
								 $err_msg = "Пароли не совпадают!";
								}
							}
						 else
							{
							 $err_msg = "Поле `Пароль` не заполнено!";
							}
						}
					 else
						{
						 $err_msg = "Указанный `E-mail` имеет недопустимый формат!";
						}

					}
				 else
					{
					 $err_msg = "Заполните поле `Ваше имя`!";
					}
				}
			 else
				{
				 $err_msg = "Поле `E-mail` не заполнено!";
				}

			}
		 else
			{
			 $err_msg = "Логин может состоять из букв, цифр, дефисов и подчёркиваний.<br> Длина от 3 до 20 символов.";
			}
		}
	 else
		{
		 $err_msg = "Поле `Логин` не заполнено!";
		}

	 if (isset($err_msg))
		{
		  ?>
		  <script language='Javascript' type='text/javascript'>
				      humane.timeout = (6000);
				      humane.error('Ошибка!<br><?=$err_msg?>');
			         </script>
		  <?
		}
	}

 ?>
 <div id="form_reg" style="margin-top: 40px;">
	<div class="cont-list" style="margin: 0 0 10px 80px">
	 <div class="drop-shadow curved curved-vt-2">
		<h2><b><span style="color: #001591">Регистрация на сайте:</span></b></h2>
	 </div>
	</div>
	<br><br>

	<form action="" method="post" enctype="multipart/form-data">
	 <table>
		<tr>
		 <td> Логин:*</td>
		 <td>
			<input name="rLogin" class="inp_f_reg" title="Логин может состоять из букв, цифр, дефисов и подчёркиваний. Длина от 3 до 16 символов." value="<?= $rLogin ?>" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td> Пароль:*</td>
		 <td>
			<input name="rPass" class="inp_f_reg" type="password" title="Длина От 8 до 20 символов. Допускаются только английские буквы, цифры и слеующие знаки:  . - _ ! ~ * : < > + " maxlength="20" value="<?= $rPass ?>" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>Пароль ещё раз:*</td>
		 <td>
			<input name="rPass2" class="inp_f_reg" type="password" title="Повторить пароль" maxlength="20" value="<?= $rPass2 ?>" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>Ваше имя:*</td>
		 <td>
			<input name="rName_us" class="inp_f_reg" type="text" title="Как к Вам обращаться?" value="<?= $rName_us ?>" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>E-mail:*</td>
		 <td>
			<input name="rEmail" class="inp_f_reg" type="text" title="E-mail, на который прийдут ссылки для скачивания фотографий" value="<?= $rEmail ?>" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>Skype:</td>
		 <td>
			<input name="rSkype" class="inp_f_reg" type="text" title="Для быстрой связи (заполнять не обязательно)" value="<?= $rSkype ?>" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>Телефон:</td>
		 <td>
			<input name="rPhone" class="inp_f_reg" type="text" title="Для заказа фотографий обязательно( можно ввести потом )" onkeyup="parseField(this.name)"
			 value="<?= $rPhone ?>" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td style="padding-right: 30px">Проверочный код:*</td>
		 <td>
			<input name="rPkey" id="captcha" class="inp_f_reg" type="text" title="Цифры внизу. Если не видны, нажмите на колечко со стрелками" value="Защита от спама" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>Обновить:</td>
		 <td>
			<div style="margin: 10px 0 -10px 30px;"><?php dsp_crypt('cryptographp.cfg.php', 1); ?></div>
		 </td>
		</tr>
	 </table>
	 <br>

	 <div align="center"><input class="metall_knopka" name="ok" type="submit" value="Отправить"></div>
	</form>
 </div>
 </div>
 <div class="cont-list" style="margin: 0 0 0 10%;">
	<div class="drop-shadow lifted" style="padding: 15px 25px 3px 25px;">
	 <p id="for_reg_cont">
		Регистрация необходима для хранения, покупки или бесплатного скачивания фотографий из фотобанка. Для всех
		зарегистрированных пользователей, активно принимающих участие в голосованиях за фотографии, предусмотрены скидочные
		бонусы и акции, а для пользователей, чьи фотографии набрали пять и более звездочек рейтинга в альбоме - специальное
		предложение. </p>

	 <p id="for_reg_cont">Пожалуйста, внимательно заполните все поля и нажмите кнопку "отправить". Указывайте реально
		существующий email, на него будут приходить ссылки для скачивания выбранных Вами фотографий. Внимание! В целях
		безопасности, никому не передавайте свои логин и пароль! Пароль и логин могут состоять только из ЛАТИНСКИХ букв,
		цифр или подчеркивания. Желательно использовать пароль длиной больше восьми символов, включающий в себя цифры, а
		также большие и маленькие буквы. Поля, отмеченные звездочкой, заполнять обязательно.</p>
	</div>
 </div>
	 <?
  } else {
	 echo "<script type='text/javascript'>window.document.location.href='/index.php'</script>";
  }
	 ?>
 <div class="end_content"></div>
 </div>

  <script type='text/javascript'>
	 function parseField(id){
		var obj = '[name="'+id+'"]';
		var str = new String(jQuery(obj).val());
		if(str.match(/[^0-9-_]+/gi)){

		  jQuery(obj).css({'border-color':'#980000','background-color':'#EDCECE'});
		  jQuery(obj).val(str.replace(/[^0-9-_]+/gi,''));

		  setTimeout(function(){jQuery(obj).css({'border-color':'#85BFF2','background-color':'#FFFFFF'});},1000)
		}
	 }
  </script>

<?php include ('inc/footer.php');
?>