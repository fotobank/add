<?php
			define ('BASEPATH', realpath(__DIR__).'/', true);
			include_once (BASEPATH.'inc/head.php');
			$uname  = "";
			$uphone = "";
			$skype  = "";
			$utext  = "";
			$umail  = "";
			$umail  = "";
			$eAll   = NULL;
			$e1     = $e2 = $e3 = $e4 = $e5 = "";
			if (isset($_POST["go"])) {
						$e1    = NULL;
						$uname = trim(htmlspecialchars($_POST["uname"]));
						if (strlen($uname) == "0" || (!preg_match("/[^a-zA-Zа-яА-Я0-9_-]{3,16}$/", $uname))) {
									$e1 .= "Недопустимые символы!";
						}
						$e2    = NULL;
						$utext = trim(htmlspecialchars($_POST["utext"]));
						if (strlen($utext) == "0") {
									$e2 .= "Заполните поле 'Текст Сообщения'";
						}
						$e3    = NULL;
						$umail = trim(htmlspecialchars($_POST["umail"]));
						if ((strlen($umail) == "0") || (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i",	$umail))
						) {
									$e3 .= "Неверный E-Mail";
						}
						$e4     = NULL;
						$uphone = trim(htmlspecialchars($_POST["uphone"]));
						if ((strlen($uphone) < 5) || (preg_match("/[%a-z_@.,^=:;а-я\"*&$#№!?<>\~`|[{}\]]/i", $uphone))
						) {
									$e4 .= "Неверный телефон!";
						}
						$skype = trim(htmlspecialchars($_POST["skype"]));
						$e5    = NULL;
						$umath = trim(htmlspecialchars($_POST["umath"]));
						if ($umath != chk_crypt($umath)) {
									$e5 .= "Введено неверное контрольное число";
						}
						$eAll = $e1.$e2.$e3.$e4.$e5;
			}
			$dataDB       = $db->query('select txt from content where id = ?i', array(4), 'el');
			$dataKontakty = array(
						// данные из запроса базы данных
						'dataDB' => $dataDB,
						// ошибки
						'e1'     => $e1,
						'e2'     => $e2,
						'e3'     => $e3,
						'e4'     => $e4,
						'e5'     => $e5,
						// для сохранения данных в форме
						'uname'  => $uname,
						'uphone' => $uphone,
						'skype'  => $skype,
						'umail'  => $umail,
						'utext'  => $utext
			);

			// отправить письмо
			if (isset($_POST["go"]) && $eAll == NULL) {
						$dt = date("d F Y, H:i:s");
						// дата и время
						$mail = "aleksjurii@gmail.com";
						// e-mail куда уйдет письмо
						$title = "Сообщение с формы обратной связи aleks.od.ua";
						// заголовок(тема) письма
						$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).
											 '?=';
						$utext   = str_replace("\r\n", "<br>", $utext);
						// обрабатываем
						$mess = "<u><b>Сообщение с формы обратной связи :</b></u><br>";
						$mess .= "<b>Имя: </b> $uname<br>";
						$mess .= "<b>E-Mail:  </b> <a href='mailto:$umail'>$umail</a><br>";
						$mess .= "<b>Skype:  </b>$skype<br>";
						$mess .= "<b>Телефон:  </b>$uphone<br>";
						$mess .= "<b>Дата и Время:  </b>$dt<br><br>";
						$mess .= "<u><b>Текст сообщения:  </b></u><br><br>";
						$mess .= "$utext<br>";
						$headers = "MIME-Version: 1.0\r\n";
						$headers .= "Content-type: text/html; charset=windows-1251\r\n";
						//кодировка
						$headers .= "From: jurii@aleks.od.ua \r\n";
						// откуда письмо (необязательнакя строка)
						mail($mail, $subject, $mess, $headers);
						// отправляем
						// выводим уведомление об успехе операции и перезагружаем страничку
						echo  "<script language='Javascript' type='text/javascript'>
								 humane.success('Спасибо.<br> Ваше сообщение отправленно.');
								 function reLoad()
								 {location = \"kontakty.php\"};
								 setTimeout('reLoad()', 6000);
								 </script>";
						$renderData['kontakt_Msg'] = 'Спасибо. Ваше сообщение отправленно!';
			}
			$renderData   = array_merge($renderData, $dataKontakty);
			// рендер страницы
			$loadTwig('.twig', $renderData);
			include_once (BASEPATH.'inc/footer.php');