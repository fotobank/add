<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 11.07.13
 * Time: 14:37
 * To change this template use File | Settings | File Templates.
 */

  header('Content-type: text/html; charset=windows-1251');
  set_time_limit(0);
  ini_set('display_errors', '1');
  ignore_user_abort(1);
  chdir(__DIR__.'/../../');

  require_once __DIR__.'/../config.php';
  use Framework\Core\Mail\Sender;

  if(isset($_POST['prMail']))
	 {
		$user_data = go\DB\query('SELECT * FROM `users` WHERE id = ?i', array($_SESSION['userid']), 'row');
		$letter = '������������, '.iconv('utf-8', 'windows-1251', $user_data['us_name'])."!\r\n";
		$letter .= '���-�� (��������, ��) �������� ��������� ���������� ����� ��� �����  http://'.$_SERVER['HTTP_HOST']."\r\n";
		$letter .= "���� �� �� ����������� ���������, ����������, ������ ������� ��� ������.\r\n\n";

		$letter .= "��������� ����������:\r\n";
		$letter .= "�������� � ��������� ������������� ��� ���������� � ��������� �� � �������.\r\n";
		$letter .= "����� ������� �� ������ ������� � ��������� �����, ���� ���� ��������������.\r\n";
		$letter .= "����� �� ������ ���������� ������� � ���������,\r\n";
		$letter .= "� ����� ��������� ���� ��������� ���������� ������� ����� �������� �� ������� ����.\r\n";
		$letter .= "��� ����� ���������� ��������� �� �������� ����������� �������� �� ������� ����� (�� 1% �� 3% � ����������� �� �����).\r\n";
		$letter .= "�.�. ������� �������������� �� �������� �����������, �� ��� ������ � ���������� ����������� ������� ����� ����������.\r\n\n";
		$letter .= "\t\t\t\t---------------------------------------------------\r\n";
		$letter .= "\t\t\t\t��������� ��� ���������� �����:\r\n";
		$letter .= "\t\t\t\t����������: �������� ���� ����������\r\n";
		$letter .= "\t\t\t\t������������ �����: '����������'\r\n";
		$letter .= "\t\t\t\t����� Visa �����:  5168-7555-3255-0619 \r\n";
		$letter .= "\t\t\t\t---------------------------------------------------\r\n\n";
		$letter .= "��������� ������ �� ������ ����� �������� ����� ��������� ��� ��������,\r\n";
		$letter .= "�������� ����� ������� � ����� ����������� ��� ����� ������� ������24.\r\n\n";
		$letter .= "����� �������� �������� �� E-mail mailto:aleksjurii@gmail.com\r\n";
		$letter .= "��� �� SMS �� +380-94-94-77-070 :\r\n";
		$letter .= "���� ���,\r\n";
		$letter .= "���� � ����� ��������,\r\n";
		$letter .= "����� ��������,\r\n";
		$letter .= "����� ��������,\r\n";
		$letter .= '��� �-mail � Login �� ����� http://'.$_SERVER['HTTP_HOST']." ,\r\n";
		$letter .= "����� ������������ ����� ������ ��� ���� �� ����� ���������� �� ����� ��������\r\n";
		$letter .= "� �� ������� ���������, ���������� ��� ���������� ������ ������� ����������.\r\n\n ";
		$letter .= "��������� ������� �� ������ ������ ����� E-mail mailto:aleksjurii@gmail.com ,\r\n";
		$letter .= "�n-line ����� Skype: jurii.od.ua, ��� �� �������� +380-94-94-77-070 .\r\n\n\n\n";
		$letter .= "\t\t\t\t� ���������, ������������� Creative line studio \r\n";

		$mail =  new Sender();

		$mail->from_addr = 'aleksjurii@gmail.com';
		$mail->from_name = '�������� '.$_SERVER['HTTP_HOST'];
		$mail->to        =  $user_data['email'];
		$mail->subj      = '��������� ���������� ����� ����� http://'.$_SERVER['HTTP_HOST'];
		$mail->body_type = 'text/plain';
		$mail->body      =  $letter;
		$mail->priority  = 1;
		$mail->prepare_letter();
		if($mail->send_letter() === true) {
           echo('��������� ����� � ����������� ������� �� ��� E-mail.');
    } else {
           echo('��������� �� �������.');
    }
	 }
