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
  ini_set("display_errors","1");
  ignore_user_abort(1);
  require_once (__DIR__.'/../config.php');
  require_once (__DIR__.'/../lib_ouf.php');
  require_once (__DIR__.'/../lib_mail.php');


  if(isset($_POST['prMail']))
	 {
		$user_data = $db->query('SELECT * FROM `users` WHERE id = ?i', array($_SESSION['userid']), 'row');
		$letter = "Здравствуйте, ".iconv('utf-8', 'windows-1251', $user_data['us_name'])."!\r\n";
		$letter .= "Кто-то (возможно, Вы) запросил реквизиты пополнения счета для сайта  http://".$_SERVER['HTTP_HOST']."\r\n";
		$letter .= "Если вы не запрашивали реквизиты, пожалуйста, просто удалите это письмо.\r\n\n";

		$letter .= "Небольшая инструкция:\r\n";
		$letter .= "Выберите в фотобанке понравившиеся Вам фотографии и отправьте их в корзину.\r\n";
		$letter .= "Затем нажмите на кнопку корзины и проверьте заказ, если надо отредактируйте.\r\n";
		$letter .= "Снизу на каждой фотографии указана её стоимость,\r\n";
		$letter .= "а общая стоимость всех выбранных фотографий указана внизу страницы на красном фоне.\r\n";
		$letter .= "Эту сумму необходимо увеличить на величину банковского процента за перевод денег (от 1% до 3% в зависимости от банка).\r\n";
		$letter .= "Т.к. перевод осуществляется на карточку ПриватБанка, то при оплате в отделениях ПриватБанка процент будет неименьший.\r\n\n";
		$letter .= "\t\t\t\t---------------------------------------------------\r\n";
		$letter .= "\t\t\t\tРеквизиты для пополнения счета:\r\n";
		$letter .= "\t\t\t\tПолучатель: Алексеев Юрий Викторович\r\n";
		$letter .= "\t\t\t\tНаименование банка: 'ПриватБанк'\r\n";
		$letter .= "\t\t\t\tНомер Visa карты:  4731 1855 0554 6074 \r\n";
		$letter .= "\t\t\t\t---------------------------------------------------\r\n\n";
		$letter .= "Перевести деньги на данную карту возможно любым доступным Вам способом,\r\n";
		$letter .= "например через автомат в холле ПриватБанка или через систему Приват24.\r\n\n";
		$letter .= "После перевода сообщите на E-mail mailto:aleksjurii@gmail.com\r\n";
		$letter .= "или по SMS на +380-94-94-77-070 :\r\n";
		$letter .= "Ваше Имя,\r\n";
		$letter .= "Дату и время перевода,\r\n";
		$letter .= "Место перевода,\r\n";
		$letter .= "Сумму перевода,\r\n";
		$letter .= "Ваш Е-mail и Login на сайте http://".$_SERVER['HTTP_HOST']." ,\r\n";
		$letter .= "После перечисления денег банком ваш счет на сайте пополнится на сумму перевода\r\n";
		$letter .= "и Вы сможете скачивать, голосовать или заказывать печать любимых фотографий.\r\n\n ";
		$letter .= "Возникшие вопросы Вы можете задать через E-mail mailto:aleksjurii@gmail.com ,\r\n";
		$letter .= "Оn-line через Skype: jurii.od.ua, или по телефону +380-94-94-77-070 .\r\n\n\n\n";
		$letter .= "\t\t\t\tС уважением, Администрация Creative line studio \r\n";


		$mail            =  new Mail_sender;
		$mail->from_addr = "aleksjurii@gmail.com";
		$mail->from_name = "Фотобанк ".$_SERVER['HTTP_HOST'];
		$mail->to        =  $user_data['email'];
		$mail->subj      = "Реквизиты пополнения счета сайта http://".$_SERVER['HTTP_HOST'];
		$mail->body_type = 'text/plain';
		$mail->body      =  $letter;
		$mail->priority  = 1;
		$mail->prepare_letter();
		$mail->send_letter();

		echo ('Реквизиты карты с инструкцией высланы на Ваш E-mail.');
	 }