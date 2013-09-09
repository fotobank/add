<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 21.03.13
	 * Time: 16:11
	 * To change this template use File | Settings | File Templates.
	 */

  // обработка ошибок
	require_once (__DIR__.'/../classes/autoload.php');
	autoload::getInstance();


	// бан
	function record($ipLog='ipLogFile.txt', $timeout='30') // запись бана
		{
		   $session = check_Session::getInstance();
			$log = fopen("$ipLog", "a+");
			fputs($log, Get_IP()."][".time()."][".$session->get('current_album')."\n");
			fclose($log);


		  $mail_mes = "Внимание - ".dateToRus( time(), '%DAYWEEK%, j %MONTH% Y, G:i' )." - зафиксированн подбор пароля для альбома \"".
			            $_SESSION['current_album']."\", пользователь - \"".$session->get('us_name')."\" c Ip:".Get_IP().
			            " забанен на ".$timeout." минут!";

		  $error_processor = Error_Processor::getInstance();
		  $error_processor->log_evuent($mail_mes,"");

		  $mail            = new Mail_sender;
		  $mail->from_addr = "webmaster@aleks.od.ua";
		  $mail->from_name = "aleks.od.ua";
		  $mail->to        = "aleksjurii@gmail.com";
		  $mail->subj      = "Подбор пароля";
		  $mail->body_type = 'text/html';
		  $mail->body      = $mail_mes;
		  $mail->priority  = 1;
		  $mail->prepare_letter();
		  $mail->send_letter();

		}

	// chek
	function check($ipLog ='ipLogFile.txt', $timeout = '30') // проверка бана
		{
		   $session = check_Session::getInstance();
			$data = file("$ipLog");
			$now  = time();
		   $current_album = $session->get('current_album');
			if (!$session->has("popitka") || !is_array($_SESSION['popitka']))
				{
					$_SESSION['popitka'] = array();
				}
			if ( $session->has("current_album") )
				{
					if (!$session->has("popitka/$current_album") || $session->get("popitka/$current_album") < 0
						|| $session->get("popitka/$current_album") > 5 && $session->get("popitka/$current_album") != -10)
						{
						   $session->set("popitka/$current_album", 5);
						}
				}
			if ($data) //если есть хоть одна запись
				{
					foreach ($data as $key => $record)
						{
							$subdata = explode("][", $record);

						  // показ остаточного времени
									if (Get_IP() == $subdata[0] && $now < ($subdata[1] + 60 * $timeout) && $current_album == $subdata[2])
										{
											$begin = ((($subdata[1] + 60 * $timeout) - $now) / 60);
										   $min = intval($begin);
										   $sec = round((($begin - $min)*60),2);
										   $session->set("popitka/$current_album", -10);

										   return json_encode(array('min' => $min,'sec' => $sec));
										   break;
										}

						  // время бана закончилось
									if (Get_IP() == $subdata[0] && $now > ($subdata[1] + 60 * $timeout) && $current_album == $subdata[2]
										&& $session->get("popitka/$current_album") <= 0 && $session->get("popitka/$current_album") > 5 )

										{
										  $session->set("popitka/$current_album", 5);
										}

						  // чистка
									if (isset($subdata[1]) && ($subdata[1] + 60 * $timeout) < $now)
										{
											unset($data[$key]); // убираем элемент массива, который нужно удалить
											$data = str_replace('x0A', '', $data);
											file_put_contents($ipLog, implode('', $data)); // сохраняем этот массив, предварительно объединив его в строку
										}
						}
					unset($key);
				}
			elseif ($session->has("current_album"))
				{
					if (!$data && $session->get("popitka/$current_album") <= 0 && $session->get("popitka/$current_album") > 5)
						{
						  $session->set("popitka/$current_album", 5);
						}
				}
			return true;
		}
