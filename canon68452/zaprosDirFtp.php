<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 14.04.13
 * Time: 14:22
 * To change this template use File | Settings | File Templates.
 */

	set_time_limit(0);
	include __DIR__.'/../inc/config.php';
	include __DIR__.'/../inc/func.php';


	function showTree($folder, $space) {
		/* �������� ������ ������ ������ � ��������� ������ $folder */
		$files = scandir($folder);
		foreach($files as $file) {
			/* ����������� ������� � ������������ ������� */
			if (($file == '.') || ($file == '..')) continue;
			$f0 = $folder.'/'.$file; //�������� ������ ���� � �����
			/* ���� ��� ���������� */
			if (is_dir($f0)) {
				/* �������, ����� �������� ������, �������� ���������� */
				echo $space.$file."<br />";
				/* � ������� �������� ������� ���������� ���������� ���������� */
				showTree($f0, $space.'&nbsp;&nbsp;');
			}
			/* ���� ��� ����, �� ������ ������� �������� ����� */
			//else echo $space.$file."<br />";
		}
	}




	// $dir_name = time(); //����� � ������ ��� ����� �� ������� ������� �������
	/*$conn_ftp = @ftp_connect('your_ftp_server', 21, 5);
	if($conn_ftp) // ���������� ������ �������
		{
			$login_result = @ftp_login($conn_ftp, 'user', 'pass'); // ������ ���� ����� � ������ ��� FTP
			if($login_result) // �������� ������ � ������ ������ �������
				{
					ftp_pasv ($conn_ftp, TRUE);
					ftp_chdir ($conn_ftp, 'public_html/materials');
					//ftp_mkdir ($conn_ftp, $dir_name);
					//ftp_chmod($conn_ftp, 0777, $dir_name);
					/* ��������� ������� ��� �������� �������� */
//					showTree("./", "");

//				}
//		}

	if (isset($_POST['ftpDir']))
		{
			$ftp_host = get_param('ftp_host');
			$ftp_user = get_param('ftp_user');
			$ftp_pass = get_param('ftp_pass');
			// mysql_set_charset("utf8");
			if ($ftp_host && $ftp_user && $ftp_pass)
				{
					//���� � ����� ������������ ���� - ������� ���
					if (strstr($ftp_host, ':'))
						{
							$ftp_port = substr($ftp_host, strpos($ftp_host, ':') + 1);
							$ftp_host = substr($ftp_host, 0, strpos($ftp_host, ':'));
						}
					else
						{
							$ftp_port = 21;
						}
					//�����������
					$ftp = ftp_connect($ftp_host, $ftp_port);
					if (!$ftp)
						{
							$out = "<div class='alert alert-error'>�������� ����� ��� ���� ftp �������!'<br></div>";
							senderror($out, $id, '');
							die('�������� ����� ��� ���� ftp �������!');
						}
					//���������
					if (!ftp_login($ftp, $ftp_user, $ftp_pass))
						{
							ftp_close($ftp);
							$out = "<div class='alert alert-error'>�������� ����� ��� ������ ��� FTP �������!<br></div>";
							senderror($out, $id, '');
							die('�������� ����� ��� ������ ��� FTP �������!');
						}
					ftp_pasv($ftp, true);
					/*if (ftp_chdir($ftp, ''))
						{
							ftp_chdir($ftp, '');
						}*/

					showTree("./", "");

						}
		}
