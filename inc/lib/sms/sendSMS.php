<?php
/**
	* Created by JetBrains PhpStorm.
	* User: Jurii
	* Date: 07.06.13
	* Time: 5:03
	* To change this template use File | Settings | File Templates.
   *
	* Данный файл предоставляет возможность отправлять СМС сообщения
	* с подменой номера, просматривать остаток кредитов пользователя,
	* просматривать статус отправленных сообщений.
	* -----------------------------------------------------------------
	* Для работы данного примера необходимо подключить SOAP-расширение.
	*
	*/

// Все данные возвращаются в кодировке UTF-8
  header ('Content-type: text/html; charset=utf-8');



  // ------------------------------------------------------------------------------------------//
  // http://sms-fly.com/Info/API/
  // сообщения должны быть UTF-8
  /**
	*  12коп
	*/
  if(isset($_POST['sendFluSMS']))
	 {
		$number = trim($_POST['number']);
		$text = iconv('windows-1251', 'utf-8', htmlspecialchars(trim($_POST['sendFluSMS'])));
		$description = iconv('windows-1251', 'utf-8', htmlspecialchars('Заказ фото'));
	//	$start_time = date("Y-m-d H:i:s");
	   $end_time = date("Y-m-d H:i:s", time() + 300); // плюс 5 минут
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

// вывод результата в браузер для удобства чтения обрамлен в textarea
		echo '<textarea spellcheck="false" name="111" rows="25" cols="150">';
		echo $response;
		echo '</textarea>';
	 }







  /**
	* 16коп
	*/
  if(isset($_POST['sendSMS']))
	 {
		$zakaz = iconv('windows-1251', 'utf-8', htmlspecialchars(trim($_POST['sendSMS'])));
		$number = trim($_POST['number']);



// Подключаемся к серверу
  $client = new SoapClient ('http://turbosms.in.ua/api/wsdl.html');

// Данные авторизации
  $auth = Array (
	 'login' => 'fotobank',
	 'password' => 'fotoBank_27'
  );

// Авторизируемся на сервере
  $result = $client->Auth ($auth);

// Результат авторизации
  echo $result->AuthResult . ''.'<br>';

// Данные для отправки
  $sms = Array (
	 'sender' => 'aleks.od.ua',
	 'destination' => $number,
	 'text' => $zakaz
  );

// Отправляем сообщение на один номер.
// Подпись отправителя может содержать английские буквы и цифры. Максимальная длина - 11 символов.
// Номер указывается в полном формате, включая плюс и код страны
  $result = $client->SendSMS ($sms);

// Выводим результат отправки.
  echo $result->SendSMSResult->ResultArray[0] . ''.'<br>';

// Получаем количество доступных кредитов
		$result = $client->GetCreditBalance ();
		echo iconv ('windows-1251', 'utf-8', 'Осталось: ').$result->GetCreditBalanceResult.iconv ('windows-1251', 'utf-8', ' доступных SMS сообщений').'<br>';

// Запрашиваем массив ID сообщений, у которых неизвестен статус отправки
  $result = $client->GetNewMessages ();

// Есть сообщения
  if (!empty ($result->GetNewMessagesResult->ResultArray)) {
	 echo '
';
	 print_r ($result->GetNewMessagesResult->ResultArray);
	 echo '
';
	 // Запрашиваем статус каждого сообщения по ID
	 foreach ($result->GetNewMessagesResult->ResultArray as $msg_id) {
		$sms = Array ('MessageId' => $msg_id);
		$status = $client->GetMessageStatus ($sms);
		echo '' . $msg_id . ' - ' . $status->GetMessageStatusResult . '';
	 }
  }
 }



  // Можно просмотреть список доступных функций сервера
  /*  echo '
';
  print_r ($client->__getFunctions ());
  echo '
';*/

  // Текст сообщения ОБЯЗАТЕЛЬНО отправлять в кодировке UTF-8
  // $text = iconv ('windows-1251', 'utf-8', 'Это сообщение будет доставлено на указанный номер');

  // Отправляем сообщение на несколько номеров.
// Номера разделены запятыми без пробелов.
  /*$sms = Array (
	 'sender' => 'Rassilka',
	 'destination' => '+380XXXXXXXX1,+380XXXXXXXX2,+380XXXXXXXX3',
	 'text' => $text
  );
  $result = $client->SendSMS ($sms);*/

// Выводим результат отправки.
//  echo $result->SendSMSResult->ResultArray[0] . ''.'<br>';

// ID первого сообщения
//   echo $result->SendSMSResult->ResultArray[1] . '';

// ID второго сообщения
//   echo $result->SendSMSResult->ResultArray[2] . '';

// Отправляем сообщение с WAPPush ссылкой
// Ссылка должна включать http://
  /* $sms = Array (
	 'sender' => 'Rassilka',
	 'destination' => '+380XXXXXXXXX',
	 'text' => $text,
	 'wappush' => 'http://super-site.com'
  );

  $result = $client->SendSMS ($sms);*/

// Запрашиваем статус конкретного сообщения по ID
  /*$sms = Array ('MessageId' => 'c9482a41-27d1-44f8-bd5c-d34104ca5ba9');
  $status = $client->GetMessageStatus ($sms);
  echo $status->GetMessageStatusResult . '';*/

?>