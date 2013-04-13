<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 12.04.13
	 * Time: 12:55
	 * To change this template use File | Settings | File Templates.
	 */
	// ��������� ������
	include __DIR__.'./lib_mail.php';
	include __DIR__.'./lib_ouf.php';
	include __DIR__.'./lib_errors.php';
	$error_processor = Error_Processor::getInstance();
	include __DIR__.'./config.php';
	include __DIR__.'./func.php';
	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	/* ��������� ���������� */
	if (mysqli_connect_errno())
		{
			printf("������ ����������: %s\n", mysqli_connect_error());
			exit();
		}
	if ($_SESSION['secret_number'] == "")
		{
			$_SESSION['secret_number'] = "ABCD";
		}
	if (isset($_POST['comtext']))
		{
			if ($_SESSION["secret_number"] != $_POST['pkey'])
				{
					?><h1>Error</h1><?php
				}
			else
				{
					echo "Errors 2";
				}
		}
	/**
	 * @param $link
	 * @param $where
	 * @param $type
	 */
	function checkData($link, $where, $type)
		{

			$rs = mysqli_query($link, 'select * from users where '.$where);
			if (mysqli_errno($link) == 0 && mysqli_num_rows($rs) > 0)
				{
					$user_data = mysqli_fetch_assoc($rs);
					$title     = '�������������� ������ �� ����� Creative line studio';
					$headers   = "Content-type: text/plain; charset=windows-1251\r\n";
					$headers .= "From: ������������� Creative line studio \r\n";
					$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
					$letter  = "������������,".iconv('utf-8', 'windows-1251', $user_data['us_name'])."!\r\n";
					$letter .= "���-�� (��������, ��) �������� �������������� ������ �� ����� Creative line studio.\r\n";
					$letter .= "������ ��� ����� �� ����:\r\n";
					$letter .= "   �����: ".iconv('utf-8', 'windows-1251', $user_data['login'])."\r\n";
					// �������� ������ ������
					//$password = genpass(10, 3); // ������ � ������������ ������� ���������
					$password = genPassword(10); // ������������������� ������
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
							$_SESSION['ok_msg2'] =
								"������ ��������.<br>����� ������ ��������� �� E-mail,<br> ��������� ���� ��� �����������.<br>";
						}
				}
			else
				{
					$_SESSION['err_msg'] .= "������������ � ������ '$type' �� ������.<br>";
				}
		}

	//�������� ������
	if ($_POST['login'].$_POST['email'].$_POST['pkey'] != $_SESSION['previos_data'])
		{
			$_SESSION['previos_data'] = $_POST['login'].$_POST['email'].$_POST['pkey'];
			if (iconv("utf-8", "windows-1251", $_POST['login'].$_POST['email'].$_POST['pkey']) == "������� ��� �����:��� E-mail:��� ������������:")
				{
					$_SESSION['err_msg'] .= "���������� ��������� ���� �� �����.<br>";
				}
			else
				{
					if ($_POST['pkey'] == $_SESSION["secret_number"])
						{
							$where = '';
							if (isset($_POST['login']))
								{
									$dataLogin = iconv("utf-8", "windows-1251", $_POST['login']);
									if ($dataLogin != "������� ��� �����:")
										{
											$login = trim(htmlspecialchars($dataLogin));
											if (!preg_match("/[?a-zA-Z�-��-�0-9_-]{3,16}$/", $login))
												{
													$_SESSION['err_msg2'] .= "����� ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 16 ��������.<br>";
													$where = 'false';
												}
											else
												{
													$where = ' login = \''.mysqli_escape_string($link, $login).'\'';
													$where = iconv("windows-1251", "utf-8", $where);
													checkData($link, $where, 'Login');
												}
										}
								}
							if (isset($_POST['email']))
								{
									$dataEmail = iconv("utf-8", "windows-1251", $_POST['email']);
									if ($dataEmail != "��� E-mail:")
										{
											$email = trim(htmlspecialchars($dataEmail));
											if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $email))
												{
													$_SESSION['err_msg2'] .= "��������� 'E-mail' (������: a@b.c)!<br>";
													$where = 'false';
												}
											else
												{
													$where = ' email = \''.mysqli_escape_string($link, $email).'\'';
													checkData($link, $where, 'E-mail');
												}
										}
								}
							if ($where == '')
								{
									$_SESSION['err_msg'] .= "����������, ��������� ���� �� �����!<br>";
								}
						}
					else
						{
							$_SESSION['err_msg'] .= "������������ ���� ������������ �����!<br>";
						}
				}
		}
	else
		{
			$_SESSION['err_msg'] .= "��������� ���� ���������� ������!<br>";
		}
	if (isset($_SESSION['ok_msg2']))
		{
			$_SESSION['ok_msg2'] = "<p class='ttext_blue'>".$_SESSION['ok_msg2']."</p>";
			echo $_SESSION['ok_msg2'];
			unset($_SESSION['ok_msg2']);
		}
	else
		{
			$_SESSION['err_msg'] = "<p class='ttext_red'>".$_SESSION['err_msg']."</p>";
			echo $_SESSION['err_msg2'].$_SESSION['err_msg'];
		}
	unset($_SESSION['err_msg']);
	unset($_SESSION['err_msg2']);
	unset($_SESSION['secret_number']);
	mysqli_close($link);

