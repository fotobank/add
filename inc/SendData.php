<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 12.04.13
	 * Time: 12:55
	 * To change this template use File | Settings | File Templates.
	 */
	include __DIR__.'./config.php';
	include __DIR__.'./func.php';
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	/* ��������� ���������� */
	if (mysqli_connect_errno())
		{
			printf("������ ����������: %s\n", mysqli_connect_error());
			exit();
		}

	//�������� ������
	if (isset($_POST[data]))
		{
			$data = $_POST[data];
			$data = iconv("utf-8", "windows-1251", $data);
			if ($data != $_SESSION['previos_data'])
				{
					$_SESSION['previos_data'] = $data;
					$subdata = explode("][", $data);
					if (isset($subdata[0]) and $subdata[0] != "������� ��� �����:")
						{
							$login = trim(htmlspecialchars($subdata[0]));
							if (!preg_match("/[?a-zA-Z�-��-�0-9_-]{3,16}$/", $login))
								{
									$_SESSION['err_msg2'] = "����� ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 16 ��������.<br>";
								}
						}
					if (isset($subdata[1]) and $subdata[1] != "��� E-mail:")
						{
							$email = trim(htmlspecialchars($subdata[1]));
							if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $email))
								{
									$_SESSION['err_msg'] .= "������������ 'E-mail'!<br>";
								}
						}

					$where = '';
					if (!empty($email))
						{
							$where = ' email = \''.mysqli_escape_string($link, $email).'\'';
						}
					elseif (!empty($login))
						{
							$where = ' login = \''.mysqli_escape_string($link, $login).'\'';
						}
					if ($data == "][")
						{
							$_SESSION['err_msg'] .= "���������� ��������� ���� �� �����.<br>";
						}
					if ($where == '')
						{
							$_SESSION['err_msg'] .= "����������, ��������� ���� �� �����!<br>";
						}
					else
						{
							$rs = mysqli_query($link, 'select * from users where '.$where);
							if (mysqli_errno($link) == 0 && mysqli_num_rows($rs) > 0)
								{
									$user_data = mysqli_fetch_assoc($rs);
									$title     = '�������������� ������ �� ����� Creative line studio';
									$headers   = "Content-type: text/plain; charset=windows-1251\r\n";
									$headers .= "From: ������������� Creative line studio \r\n";
									$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
									$letter  = "������������, $user_data[us_name]!\r\n";
									$letter .= "���-�� (��������, ��) �������� �������������� ������ �� ����� Creative line studio.\r\n";
									$letter .= "������ ��� ����� �� ����:\r\n";
									$letter .= "   �����: $user_data[login]\r\n";
									// �������� ������ ������
									//$password = genpass(10, 3); // ������ � ������������ ������� ���������
									$password = genPassword(10);  // ������������������� ������
									// �������� � ������ � ����
									getPassword($password, $user_data['id']) or die("������!");
									$letter .= "   ������: $password\r\n";
									$letter .= "���� �� �� ����������� �������������� ������, ����������, ���������� ��������� � �������������� �����!\r\n";
									/* �������� ������� */
									mysqli_free_result($rs);
									// ���������� ������
									if (!mail($user_data['email'], $subject, $letter, $headers))
										{
											$_SESSION['err_msg'] .= "�� ������� ��������� ������. ����������, ���������� �����.<br>";
										}
									else
										{
											$_SESSION['ok_msg2'] = "������ ��������.<br>����� ������ ��������� �� ��� E-mail.<br>";
										}
								}
							else
								{
									$_SESSION['err_msg'] .= "������������ �� ������.<br>";
								}
						}
				}
			else
				{
					$_SESSION['err_msg'] .= "��������� ���� ���������� ������!<br>";
				}
		}
	$_SESSION['err_msg'] = "<p class='ttext_red'>".$_SESSION['err_msg']."</p>";
   $_SESSION['ok_msg2'] = "<p class='ttext_blue'>".$_SESSION['ok_msg2']."</p>";
	echo $_SESSION['err_msg2'].$_SESSION['err_msg'].$_SESSION['ok_msg2'];
	unset($_SESSION['err_msg']);
	unset($_SESSION['err_msg2']);
	unset($_SESSION['ok_msg2']);
	mysqli_close($link);


