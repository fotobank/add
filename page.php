<?php
			/**
				* Created by JetBrains PhpStorm.
				* User: Jurii
				* Date: 17.06.13
				* Time: 11:25
				* To change this template use File | Settings | File Templates.
				*/
			define ('BASEPATH', realpath(__DIR__).'/', true);
			include_once (BASEPATH.'inc/config.php');
			include_once (BASEPATH.'inc/func.php');

//   dump_r($link->referralSeed);
//			dump_r("<br>actual referral Seed:{$_SESSION['referralSeed']}<br />\n");
//			dump_r("checked link: {$_SERVER['REQUEST_URI']}<br />\n");


			if ($link->referralSeed) {
						if (($link->check($_SERVER['SCRIPT_NAME'].'?go='.trim(isset($_GET['go']) ? $_GET['go'] : '')))
										|| (isset($_GET['user']) and $_GET['user'] == $_SESSION['userForm'])
						) {

									include_once (BASEPATH.'inc/head.php');

//									print "<br>actual referral Seed:".$_SESSION['referralSeed']."<br />\n";
//									print "checked link: {$_SERVER['REQUEST_URI']}<br />\n";

									// защита страницы
									$session = check_Session::getInstance();
									$session->set('userForm', genpass(20, 2));
									$link = "/page.php?user=".$session->get('userForm');
									$form = new form_Formgenerator();
									$ok   = '<div class="drop-shadow lifted" style="margin: 20px 0 0 440px;">
			    		<div style="font-size: 24px;">Изменения записаны!</div></div>';

									//установка формы
									$form->set("title", "Пользователь:  <strong style='font-size: 28px; margin: 0 0 0 20px;'><i>".$session->get('us_name')."</i></strong>");
									$form->set("name", "userForm"); // название формы
									$form->set("action", $link); // переход на страницу обработки $link после ввода
									$form->set("linebreaks", false);
									$form->set("showDebug", true);
									$form->set("showErrors", true); // показывать ошибки
									$form->set("errorTitle", '(!) Ошибка!'); // заголовок поля с ошибками
									$form->set("divs", true); // оборачивать поля в дивы
									$form->set("html5", true);
									$form->set("sanitize", true); // очистка строки от html и php
									$form->set("placeholders", true);
									$form->set("errorPosition", "in_before"); // где выводить ошибки
									$form->set("submitMessage", $ok); // сообщение выводимое после ввода
									$form->set("showAfterSuccess", true); // показывать форму после правильного ввода
									$form->set("cleanAfterSuccess", false); // очищать поля после правильного ввода
									$form->JSprotection("36CxgD");
									$loader = $db->query('SELECT `login`, `email`,  `skype`,  `phone`,  `block`,  `mail_me`, `us_name`,  `us_surname`, `city` FROM `users` WHERE `id` = ?i',
																														array($session->get('userid')), 'row');
									$block = ($loader['block'] == 1) ? 'Для правильной работы почтовых служб, пожалуйста, указывайте свои точные данные.
																																															Ваши контактные данные будут использоваться только в пределах данного
																																															сайта и уничтожаются после удаления аккаунта.' : 'Аккаунт заблокирован!';
									unset($loader['block']);
									$form->loadData($loader);
									//mapped data loading (To hide eg. DB field names)
									// отображенных загрузки данных (например, чтобы скрыть. имена поля БД)
									$loader = Array("dbmessage" => "Загрузка");
									$map    = Array("dbmessage" => "message");
									$form->loadData($loader, $map);

									//добавить поля
									$form->addText($block);
									$form->addItem("<h2>Контактные данные:</h2>");
									$form->addField("text", "login", "Логин", true, '', 'class = "formUser"');
									$form->addField("password", "pass", "Пароль", false, '', 'class = "formUser"');
									$form->addField("password", "pass2", "Повторить пароль", false, '', 'class = "formUser"');
									$form->addField("text", "us_name", "Имя", true, '', 'class = "formUser"');
									$form->addField("text", "us_surname", "Фамилия", true, '', 'class = "formUser"');
									$form->addField("text", "phone", "Телефон", true, '', 'class = "formUser"');
									$form->addField("text", "skype", "Skype", false, '', 'class = "formUser"');
									$form->addField("text", "email", "E-mail", true, '', 'class = "formUser"');
									$form->addField("text", "city", "Город проживания", false, '', 'class = "formUser"');
									$form->addField("checkbox", "mail_me", "Разрешить администрации", false, '', " посылать Вам уведомления?");
									$form->addField("checkbox", "delUser", "Удалить пользователя", false, false, " Удаление аккаунта из базы данных.");
									$form->addField("checkbox", "terms", "Заполнено верно", true, false, " Внимательно проверьте введенные данные.");
									/**
										* валидация данных
										*/
									$form->validator("login", "loginValidator", 3, 20, "/[?a-zA-Zа-яА-Я0-9_-]{3,20}$/", "Логин может состоять из букв, цифр, дефисов и подчёркиваний.
		 																																																																																					Длина от 3 до 20 символов.");
									$form->validator("pass", "passValidator", "pass", "pass2", 8, 20, "/^[0-9a-z\_\-\!\~\*\:\<\>\+\.]+$/i", "В поле `Пароль` введены недопустимые символы<br>
		 																																							или длина меньше 8 символов.<br> Допускаются только английские символы, цифры и знаки<br>  . - _ ! ~ * : < > + ");
									$form->validator("us_name", "regExpValidator", 2, 20, "/[?a-zA-Zа-яА-Я0-9_-]{2,20}$/", "Имя может состоять из букв, цифр, дефисов и подчёркиваний.
		 																																																																																							Длина от 2 до 20 символов.");
									$form->validator("us_surname", "regExpValidator", 2, 20, "/[?a-zA-Zа-яА-Я0-9_-]{2,20}$/", "Фамилия может состоять из букв, цифр, дефисов и подчёркиваний.
		                                                                            							        Длина от 2 до 20 символов.");
									$form->validator("phone", "phoneValidator", 6, 20, "/[%a-z_@.,^=:;а-я\"*()&$#№!?<>\~`|[{}\]]/i", "неправильный ввод.<br> Пример правильного формата:
																																																																																								 +380-12-34-56-789 или 8-076-77-56-567 или 777-56-56 или 7775656");
									$form->validator("skype", "regExpValidator", 3, 20, "/[?a-zA-Zа-яА-Я0-9_-]{0,20}$/", "skype может состоять из букв, цифр, дефисов и подчёркиваний.
																																																																																								 Длина от 3 до 20 символов.");
									$form->validator("email", "regExpValidator", 4, 20, "/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", "не действительный адрес электронной почты");
									$form->validator("city", "regExpValidator", 3, 20, "/[?a-zA-Zа-яА-Я0-9_-]{0,20}$/", "название города может состоять из букв, цифр, дефисов и подчёркиваний.
		                                                        																														Длина от 3 до 20 символов.");

									/** рендер страницы */
									//	$renderData['dataDB' ] =  $db->query('select txt from content where id = ?i', array(1), 'el');
									$renderData['form'] = $form;
									$loadTwig('.twig', $renderData);
									/**
										* сохранить действительные данные для дальнейшего использования
										*/
									$result = ($form->getData());
									/**
										* рекомендуется сбросить форму после сохранения данных
										*/
									unset($form);
									/**
										* удаление аккаунта
										*/
									if (isset($result['delUser'])) {
												$db->query('DELETE FROM `users` WHERE `id`=?i', array($_SESSION['userid']));
												unset($result);
												$db->close();
												session_destroy();
												echo "<script>window.document.location.href='/index.php'</script>";
									}
									if ($result) {
												unset($result['terms']);
												if ($result['pass'] == '') {
															unset($result['pass']);
															unset($result['pass2']);
												} else {
															$result['pass'] = md5($result['pass']);
															unset($result['pass2']);
												}
												$result['mail_me'] = isset($result['mail_me']) ? $result['mail_me'] : 'off';
												$db->query('UPDATE `users` SET ?set WHERE `id`=?i', array($result, $session->get('userid')));
												$session->set('user', $result['login']);
												$session->set('us_name', $result['us_name']);
									}

						} else {
						//			print "<br>actual referral Seed:".$_SESSION['referralSeed']."<br />\n";
						//			print "<br>link invalid: {$_SERVER['REQUEST_URI']} \n";
									err_exit ('Прямой вход на данную страницу запрещен. Для входа используте кнопку "пользователь"', '/error.php');
						}

			} else {
						err_exit ('Доступ на страницу пользователя без авторизации невозможен. ', '/error.php');
			}
			include_once (BASEPATH.'inc/footer.php');