<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 14.04.13
	 * Time: 14:22
	 * To change this template use File | Settings | File Templates.
	 */
	set_time_limit(0);
	include (dirname(__FILE__).'/../inc/config.php');
	include (dirname(__FILE__).'/../inc/func.php');

	/**
	 * @param $file_list
	 */
	function showSelector($file_list)
		{

			foreach ($file_list as $file)
				{
					/* Отбрасываем текущий и родительский каталог */
					if (($file == '.') || ($file == '..') || ($file == ""))
						{
							continue;
						}
					/* Если это директория */
					$last = substr($file, -1);
					if ($last == ":")
						{
							/* Выводим, убирая у последей директории разделительный знак ":" */
							if (next($file_list))
								{
									$file = substr($file, 0, -1);
									echo $file;
								}
							else
								{
									echo $file;
								}
						}
				}
		}

	if (isset($_POST['ftpDir']))
		{
			$ftp_host = get_param('ftp_host');
			$ftp_user = get_param('ftp_user');
			$ftp_pass = get_param('ftp_pass');
			// mysql_set_charset("utf8");
			if ($ftp_host && $ftp_user && $ftp_pass)
				{
					//Если в хосте присутствует порт - выделим его
					if (strstr($ftp_host, ':'))
						{
							$ftp_port = substr($ftp_host, strpos($ftp_host, ':') + 1);
							$ftp_host = substr($ftp_host, 0, strpos($ftp_host, ':'));
						}
					else
						{
							$ftp_port = 21;
						}
					//Соединяемся
					$ftp = ftp_connect($ftp_host, $ftp_port);
					if (!$ftp)
						{
							$out = "<div class='alert alert-error'>Неверный адрес или порт ftp сервера!'<br></div>";
							senderror($out, $id, '');
							die('Неверный адрес или порт ftp сервера!');
						}
					//Логинимся
					if (!ftp_login($ftp, $ftp_user, $ftp_pass))
						{
							ftp_close($ftp);
							$out = "<div class='alert alert-error'>Неверный логин или пароль для FTP сервера!<br></div>";
							senderror($out, $id, '');
							die('Неверный логин или пароль для FTP сервера!');
						}
					ftp_pasv($ftp, true);
					//Получаем список файлов в папке
					$file_list    = ftp_rawlist($ftp, '/fotoarhiv/', true);
					$fileListSort = array_multisort($file_list);
					showSelector($file_list);
					ftp_close($ftp);
				}
		}
