<?php
/**
	* Created by JetBrains PhpStorm.
	* User: Jurii
	* Date: 07.06.13
	* Time: 5:03
	* To change this template use File | Settings | File Templates.
   *
	* ������ ���� ������������� ����������� ���������� ��� ���������
	* � �������� ������, ������������� ������� �������� ������������,
	* ������������� ������ ������������ ���������.
	* -----------------------------------------------------------------
	* ��� ������ ������� ������� ���������� ���������� SOAP-����������.
	*
	*/

// ��� ������ ������������ � ��������� UTF-8
  header ('Content-type: text/html; charset=utf-8');


  if(isset($_POST['sendSMS']))
	 {
		$zakaz = trim($_POST['sendSMS']);
		$number = trim($_POST['number']);

		// ��������� ����������� ���������� SOAP
		if (!extension_loaded('soap')){
		  echo "Error!! Extensions SOAP is not loaded.";
		}

// ������������ � �������
  $client = new SoapClient ('http://turbosms.in.ua/api/wsdl.html');

// ������ �����������
  $auth = Array (
	 'login' => 'fotobank',
	 'password' => 'fotoBank_27'
  );

// �������������� �� �������
  $result = $client->Auth ($auth);

// ��������� �����������
  echo $result->AuthResult . ''.'<br>';

// ������ ��� ��������
  $sms = Array (
	 'sender' => 'aleks.od.ua',
	 'destination' => $number,
	 'text' => $zakaz
  );

// ���������� ��������� �� ���� �����.
// ������� ����������� ����� ��������� ���������� ����� � �����. ������������ ����� - 11 ��������.
// ����� ����������� � ������ �������, ������� ���� � ��� ������
  $result = $client->SendSMS ($sms);

// ������� ��������� ��������.
  echo $result->SendSMSResult->ResultArray[0] . ''.'<br>';

// �������� ���������� ��������� ��������
		$result = $client->GetCreditBalance ();
		echo iconv ('windows-1251', 'utf-8', '��������: ').$result->GetCreditBalanceResult.iconv ('windows-1251', 'utf-8', ' ��������� SMS ���������').'<br>';

// ����������� ������ ID ���������, � ������� ���������� ������ ��������
  $result = $client->GetNewMessages ();

// ���� ���������
  if (!empty ($result->GetNewMessagesResult->ResultArray)) {
	 echo '
';
	 print_r ($result->GetNewMessagesResult->ResultArray);
	 echo '
';
	 // ����������� ������ ������� ��������� �� ID
	 foreach ($result->GetNewMessagesResult->ResultArray as $msg_id) {
		$sms = Array ('MessageId' => $msg_id);
		$status = $client->GetMessageStatus ($sms);
		echo '' . $msg_id . ' - ' . $status->GetMessageStatusResult . '';
	 }
  }
 }



  // ����� ����������� ������ ��������� ������� �������
  /*  echo '
';
  print_r ($client->__getFunctions ());
  echo '
';*/

  // ����� ��������� ����������� ���������� � ��������� UTF-8
  // $text = iconv ('windows-1251', 'utf-8', '��� ��������� ����� ���������� �� ��������� �����');

  // ���������� ��������� �� ��������� �������.
// ������ ��������� �������� ��� ��������.
  /*$sms = Array (
	 'sender' => 'Rassilka',
	 'destination' => '+380XXXXXXXX1,+380XXXXXXXX2,+380XXXXXXXX3',
	 'text' => $text
  );
  $result = $client->SendSMS ($sms);*/

// ������� ��������� ��������.
//  echo $result->SendSMSResult->ResultArray[0] . ''.'<br>';

// ID ������� ���������
//   echo $result->SendSMSResult->ResultArray[1] . '';

// ID ������� ���������
//   echo $result->SendSMSResult->ResultArray[2] . '';

// ���������� ��������� � WAPPush �������
// ������ ������ �������� http://
  /* $sms = Array (
	 'sender' => 'Rassilka',
	 'destination' => '+380XXXXXXXXX',
	 'text' => $text,
	 'wappush' => 'http://super-site.com'
  );

  $result = $client->SendSMS ($sms);*/

// ����������� ������ ����������� ��������� �� ID
  /*$sms = Array ('MessageId' => 'c9482a41-27d1-44f8-bd5c-d34104ca5ba9');
  $status = $client->GetMessageStatus ($sms);
  echo $status->GetMessageStatusResult . '';*/

?>