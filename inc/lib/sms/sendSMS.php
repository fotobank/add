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



  // ------------------------------------------------------------------------------------------//
  // http://sms-fly.com/Info/API/
  // ��������� ������ ���� UTF-8
  /**
	*  12���
	*/
  if(isset($_POST['sendFluSMS']))
	 {
		$number = trim($_POST['number']);
		$text = iconv('windows-1251', 'utf-8', htmlspecialchars(trim($_POST['sendFluSMS'])));
		$description = iconv('windows-1251', 'utf-8', htmlspecialchars('����� ����'));
	//	$start_time = date("Y-m-d H:i:s");
	   $end_time = date("Y-m-d H:i:s", time() + 300); // ���� 5 �����
	   $start_time = 'AUTO';
	//	$end_time = 'AUTO';
		$rate = 120;
		$livetime = 24;
		$source = 'aleks.od.ua'; // Alfaname
		$user = '380949477070';
		$password = 'fotoBank_27';

		$myXML 	 = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$myXML 	.= "<request>";
		$myXML 	.= "<operation>SENDSMS</operation>";
		$myXML 	.= '		<message start_time="'.$start_time.'" end_time="'.$end_time.'" livetime="'.$livetime.'" rate="'.$rate.'" desc="'.$description.'" source="'.$source.'">'."\n";
		$myXML 	.= "		<body>".$text."</body>";
		$myXML 	.= "		<recipient>".$number."</recipient>";
		$myXML 	.=  "</message>";
		$myXML 	.= "</request>";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERPWD , $user.':'.$password);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, 'http://sms-fly.com/api/api.php');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml", "Accept: text/xml"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $myXML);
		$response = curl_exec($ch);
		curl_close($ch);

// ����� ���������� � ������� ��� �������� ������ �������� � textarea
		echo '<textarea spellcheck="false" name="111" rows="25" cols="150">';
		echo $response;
		echo '</textarea>';
	 }







  /**
	* 16���
	*/
  if(isset($_POST['sendSMS']))
	 {
		$zakaz = iconv('windows-1251', 'utf-8', htmlspecialchars(trim($_POST['sendSMS'])));
		$number = trim($_POST['number']);



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