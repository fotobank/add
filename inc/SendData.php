<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 12.04.13
	 * Time: 12:55
	 * To change this template use File | Settings | File Templates.
	 */
	/*
	*  Todo    - ajax ������ �������������� ������
	*/
header('Content-type: text/html; charset=windows-1251');
	// ��������� ������
	include (dirname(__FILE__).'/lib_mail.php');
	include (dirname(__FILE__).'/lib_ouf.php');
	include (dirname(__FILE__).'/lib_errors.php');
	$error_processor = Error_Processor::getInstance();
	include (dirname(__FILE__).'/config.php');
	include (dirname(__FILE__).'/func.php');
//	$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	/* ��������� ���������� */
	/*if (mysqli_connect_errno())
		{
			printf("������ ����������: %s\n", mysqli_connect_error());
			exit();
		}*/
	$cryptinstall = '/inc/captcha/cryptographp.fct.php';
	include  'captcha/cryptographp.fct.php';

/**
 * @param $where
 * @param $type
 *
 * @return string
 */
function checkData($where, $type)
		{
			$db = go\DB\Storage::getInstance()->get('db-for-data');
			$user_data = NULL;
			$error = false;
try {
			$user_data = $db->query('select * from users where ?col = ?', array($type,$where),'row');
} catch (go\DB\Exceptions\Exception  $e) {
	isset($_SESSION['err_msg']) ?	$_SESSION['err_msg'] .= '������ ��� ������ � ����� ������':
                                 $_SESSION['err_msg'] = '������ ��� ������ � ����� ������';
	$error = true;
}
			if ($error != true && $user_data)
				{
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

					// ���������� ������
					if (!mail($user_data['email'], $subject, $letter, $headers))
						{
							isset($_SESSION['err_msg']) ?	$_SESSION['err_msg'] .= "�� ������� ��������� ������. ����������, ���������� �����.<br>":
						                                 $_SESSION['err_msg'] = "�� ������� ��������� ������. ����������, ���������� �����.<br>";
						}
					else
						{
							isset($_SESSION['ok_msg2']) ?
							  $_SESSION['ok_msg2'] .= "������ ��������.<br>����� ������ ��������� �� E-mail,<br> ��������� ���� ��� �����������.<br>":
						     $_SESSION['ok_msg2']  = "������ ��������.<br>����� ������ ��������� �� E-mail,<br> ��������� ���� ��� �����������.<br>";
						}
				  $ret = 'true';
				}
			else
				{
					isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "������������ � ������ '$type' �� ������.<br>":
				                                 $_SESSION['err_msg'] = "������������ � ������ '$type' �� ������.<br>";
				  $ret = 'false';
				}
		  return $ret;
		}

$_SESSION['err_msg'] = $_SESSION['err_msg2'] = $_SESSION['ok_msg2'] = '';

	//�������� ������
	if (!isset($_SESSION['previos_data']) || $_SESSION['previos_data'] != md5($_POST['login'].$_POST['email'].$_POST['pkey']))
		{
			if (iconv("utf-8", "windows-1251", $_POST['login'].$_POST['email'].$_POST['pkey']) == "������� ��� �����:��� E-mail:��� ������������:")
				{
				isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "���������� ��������� ���� �� �����.<br>":
				                              $_SESSION['err_msg'] = "���������� ��������� ���� �� �����.<br>";
				}
			else
				{
					if ($_POST['pkey'] == chk_crypt($_POST['pkey']))
						{
							if (isset($_POST['login']))
								{
									$dataLogin = iconv("utf-8", "windows-1251", $_POST['login']);
									if ($dataLogin != "������� ��� �����:")
										{
											$login = trim(htmlspecialchars($dataLogin));
											if (!preg_match("/[?a-zA-Z�-��-�0-9_-]{3,16}$/", $login))
												{
													isset($_SESSION['err_msg2']) ?
													  $_SESSION['err_msg2'] .= "����� ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 16 ��������.<br>":
												     $_SESSION['err_msg2']  = "����� ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 16 ��������.<br>";
													  $where = 'false';
												}
											else
												{
													$login = iconv("windows-1251", "utf-8", $login);
												   $where = checkData($login, 'login');
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
													isset($_SESSION['err_msg2']) ? $_SESSION['err_msg2'] .= "��������� 'E-mail' (������: a@b.c)!<br>":
												                                  $_SESSION['err_msg2'] = "��������� 'E-mail' (������: a@b.c)!<br>";
													$where = 'false';
												}
											else
												{
												  $where = checkData($email, 'email');
												}
										}
								}

						   if (empty($_POST['email']) && empty($_POST['login'])) $where = '';

							if ($where == '')
								{
									isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "����������, ��������� ���� �� �����!<br>":
								                                 $_SESSION['err_msg']  = "����������, ��������� ���� �� �����!<br>";
								}

						  if ($where == 'false')
							 {
								isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "������������ �� ������.":
								                              $_SESSION['err_msg']  = "������������ �� ������.";
							 }

						}
					else
						{
							isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "������������ ���� ������������ �����!<br>":
						                                 $_SESSION['err_msg'] = "������������ ���� ������������ �����!<br>";
						}
				}
		 }
	  elseif($_SESSION['previos_data'] == "b894200597453166c8ff8dd7d7488263")
		 {
			isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "<p class='ttext_red'>��� ����������� ������ ���������� ���������<br> ���� �� �����.</p><br>":
			                              $_SESSION['err_msg'] = "<p class='ttext_red'>��� ����������� ������ ���������� ���������<br> ���� �� �����.</p><br>";
		 }
	  else
		 {
			isset($_SESSION['err_msg']) ? $_SESSION['err_msg'] .= "<p class='ttext_red'>��������� ���� ���������� ������!</p><br>":
			                              $_SESSION['err_msg'] = "<p class='ttext_red'>��������� ���� ���������� ������!</p><br>";
		 }


	if (isset($_SESSION['ok_msg2']) && $_SESSION['ok_msg2'] != '')
		{
			$_SESSION['ok_msg2'] = "<p class='ttext_blue'>".$_SESSION['ok_msg2']."</p>";
			echo $_SESSION['ok_msg2'];
			unset($_SESSION['ok_msg2']);
		}
	else
		{
			if(isset($_SESSION['err_msg2']) && $_SESSION['err_msg2'] != '')
				{
			     echo $_SESSION['err_msg2'];
	         }
			elseif(isset($_SESSION['err_msg']) && $_SESSION['err_msg'] != '')
            {
	            echo $_SESSION['err_msg'];
            }


		}
   $_SESSION['previos_data'] = md5($_POST['login'].$_POST['email'].$_POST['pkey']);
   unset($_SESSION['err_msg']);
   unset($_SESSION['err_msg2']);
   unset($_SESSION['ok_msg2']);
	unset($_SESSION['secret_number']);
	$db->close();
?>
