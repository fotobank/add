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
	$data = $_POST[data];
	$subdata = explode("][", $data);
	if (isset($subdata[0]))
		{
			$login = $subdata[0];
		}
	if (isset($subdata[1]))
		{
			$email = $subdata[1];
		}
	//��� ��� ��� ������ �������� � ��������� UTF ��� �������������
	//�� ����� �������������� � ������ ���������
	//$data = iconv("utf-8", "windows-1251", $data);
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
			$_SESSION['err_msg'] = "���������� ��������� ���� �� �����.";
		}
	if ($where != '')
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
					$password = mt_rand(1,10).mt_rand(10,50).mt_rand(50,100).mt_rand(100,1000) * 3;
					// �������� � ������ � ����
					getPassword($password,$user_data['id']) or die("������!") ;
					$letter .= "   ������: $password\r\n";
					$letter .= "���� �� �� ����������� �������������� ������, ����������, ���������� ��������� � �������������� �����!\r\n";
					/* �������� ������� */
					mysqli_free_result($rs);
					// ���������� ������
					if (!mail($user_data['email'], $subject, $letter, $headers))
						{
							$_SESSION['err_msg'] = "�� ������� ��������� ������. ����������, ���������� �����.";
						}
					else
						{
							$_SESSION['ok_msg2'] = "������ ��������.<br>����� ������ ��������� �� ��� E-mail.";
						}
				}
			else
				{
					$_SESSION['err_msg'] = "������������ �� ������.";
				}
		}
	echo $_SESSION['err_msg'].$_SESSION['ok_msg2'];
	unset($_SESSION['err_msg']);
	unset($_SESSION['ok_msg2']);
	mysqli_close($link);

