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
	function showTree($file_list)
		{

			foreach ($file_list as $file)
				{
					/* ����������� ������� � ������������ ������� */
					if (($file == '.') || ($file == '..'))
						{
							continue;
						}
					/* ���� ��� ���������� */
					$last = substr($file, -1);
					if ($last == ":")
						{
							/* �������, ����� �������� ������, �������� ���������� */
							$file = substr($file,0 , -1).'/';
							echo $file."<br />";
						}
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
					//�������� ������ ������ � �����
					//					$file_list = ftp_nlist($ftp, $album_data['ftp_folder']);
					$file_list    = ftp_rawlist($ftp, '/fotoarhiv/', true);
					$fileListSort = array_multisort($file_list);
					showTree($file_list);
					ftp_close($ftp);
				}
		}
