<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 21.03.13
	 * Time: 16:11
	 * To change this template use File | Settings | File Templates.
	 */
	// ���
	$ipLog   = 'ipLogFile.txt'; // logfiles name
	$timeout = '30'; // ���������� ����� to block Ip
	$goHere  = 'index.php'; // Allowed pages name here
	function record($ip, $ipLog) // ������ ����
		{

			$log = fopen("$ipLog", "a+");
			fputs($log, $ip."][".time()."][".$_SESSION['current_album']."\n");
			fclose($log);
			//exit(0);
		}

	// chek
	function check($ip, $ipLog, $timeout) // �������� ����
		{

			//global $valid;
			$data = file("$ipLog");
			$now  = time();
			if (!isset($_SESSION['popitka']) || !is_array($_SESSION['popitka']))
				{
					$_SESSION['popitka'] = array();
				}
			if (isset($_SESSION['current_album']))
				{
					if (!isset($_SESSION['popitka'][$_SESSION['current_album']]) || $_SESSION['popitka'][$_SESSION['current_album']] < 0
						|| $_SESSION['popitka'][$_SESSION['current_album']] > 5 && $_SESSION['popitka'][$_SESSION['current_album']] != -10)
						{
							$_SESSION['popitka'][$_SESSION['current_album']] = 5;
						}
				}
			if ($data) //���� ���� ������
				{
					foreach ($data as $key => $record)
						{
							$subdata = explode("][", $record);
							if (isset($_SESSION['current_album']))
								{
									if ($ip == $subdata[0] && $now < ($subdata[1] + 60 * $timeout) && $_SESSION['current_album'] == $subdata[2])
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
											$_SESSION['popitka'][$_SESSION['current_album']] = -10;
											break;
										}
								}
							elseif (isset($_SESSION['current_album']))
								{
									if ($ip == $subdata[0] && $now > ($subdata[1] + 60 * $timeout) && $_SESSION['current_album'] == $subdata[2]
										&& $_SESSION['popitka'][$_SESSION['current_album']] <= 0
										&& $_SESSION['popitka'][$_SESSION['current_album']] > 5) // ����� ���� �����������
										{
											$_SESSION['popitka'][$_SESSION['current_album']] = 5;
										}
								}
							if (isset($subdata[1]) && ($subdata[1] + 60 * $timeout) < $now) // ������
								{
									unset($data[$key]); // ������� ������� �������, ������� ����� �������
									$data = str_replace('x0A', '', $data);
									file_put_contents($ipLog, implode('', $data)); // ��������� ���� ������, �������������� ��������� ��� � ������
								}
						}
					unset($key);
				}
			elseif (isset($_SESSION['current_album']))
				{
					if (!$data && $_SESSION['popitka'][$_SESSION['current_album']] <= 0 && $_SESSION['popitka'][$_SESSION['current_album']] > 5)
						{
							$_SESSION['popitka'][$_SESSION['current_album']] = 5;
						}
				}
			//return ($_SESSION['popitka'][$_SESSION['current_album']]);
			/*
		  echo "<pre>";
		  print_r($_SESSION.$may_view);
		  echo "</pre>";
		  */
		}

