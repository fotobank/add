<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 21.03.13
	 * Time: 16:11
	 * To change this template use File | Settings | File Templates.
	 */

  // ��������� ������
  require_once (__DIR__.'/lib_mail.php');
  require_once (__DIR__.'/lib_ouf.php');
  require_once (__DIR__.'/lib_errors.php');



	// ���
	function record($ipLog='ipLogFile.txt', $timeout='30') // ������ ����
		{
		   $session = checkSession::getInstance();
			$log = fopen("$ipLog", "a+");
			fputs($log, Get_IP()."][".time()."][".$session->get('current_album')."\n");
			fclose($log);


		  $mail_mes = "������������� ������ ������ ��� ������� \"".$_SESSION['current_album'].
			"\", ������������ - \"".$session->get('us_name')."\" c Ip:".Get_IP()." ������� �� ".$timeout." �����!";

		  $error_processor = Error_Processor::getInstance();
		  $error_processor->log_evuent($mail_mes,"");

		  $mail            = new Mail_sender;
		  $mail->from_addr = "webmaster@aleks.od.ua";
		  $mail->from_name = "aleks.od.ua";
		  $mail->to        = "aleksjurii@gmail.com";
		  $mail->subj      = "������ ������";
		  $mail->body_type = 'text/html';
		  $mail->body      = $mail_mes;
		  $mail->priority  = 1;
		  $mail->prepare_letter();
		  $mail->send_letter();

		}

	// chek
	function check($ipLog ='ipLogFile.txt', $timeout = '30') // �������� ����
		{
		   $session = checkSession::getInstance();
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
			if ($data) //���� ���� ���� ���� ������
				{
					foreach ($data as $key => $record)
						{
							$subdata = explode("][", $record);

						  // ����� ����������� �������
									if (Get_IP() == $subdata[0] && $now < ($subdata[1] + 60 * $timeout) && $current_album == $subdata[2])
										{
											$begin = intval((($subdata[1] + 60 * $timeout) - $now) / 60);
											if ($begin == 1 || $begin == 21)
												{
													$okonc = '�';
												}
											elseif ($begin == 2 || $begin == 3 || $begin == 4 || $begin == 22 || $begin == 23 || $begin == 24)
												{
													$okonc = '�';
												}
											else
												{
													$okonc = '';
												}
											echo "<h2>�������� $begin �����$okonc</h2>";
										  $session->set("popitka/$current_album", -10);
											break;
										}

						  // ����� ���� �����������
									if (Get_IP() == $subdata[0] && $now > ($subdata[1] + 60 * $timeout) && $current_album == $subdata[2]
										&& $session->get("popitka/$current_album") <= 0
										&& $session->get("popitka/$current_album") > 5 )
										{
										  $session->set("popitka/$current_album", 5);
										}

						  // ������
									if (isset($subdata[1]) && ($subdata[1] + 60 * $timeout) < $now)
										{
											unset($data[$key]); // ������� ������� �������, ������� ����� �������
											$data = str_replace('x0A', '', $data);
											file_put_contents($ipLog, implode('', $data)); // ��������� ���� ������, �������������� ��������� ��� � ������
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
		}
