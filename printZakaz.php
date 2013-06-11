<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 25.05.13
 * Time: 11:56
 * To change this template use File | Settings | File Templates.
 */

  set_time_limit(0);
  ini_set("display_errors","1");
  ignore_user_abort(1);
  require_once (__DIR__.'/inc/config.php');
  require_once (__DIR__.'/inc/func.php');


  if(!isset($_SESSION['logged']))
    err_exit('Для подтверждения заказа необходимо залогиниться на сайте!', 'index.php');
  if(!isset($_GET['key']))
    err_exit('Ключ не найден!', 'index.php');
  $key = $_GET['key'];
  $data = $db->query('select * from `print` where `key` = ?string', array($key), 'row');
if(!$data)
  {
	 err_exit('Ключ не найден!', 'index.php');
  }
else
  {
	 include (__DIR__.'/inc/head.php');
	 require_once (__DIR__.'/inc/lib_mail.php');
	 require_once (__DIR__.'/inc/http.php');


    if((time() - intval($data['dt']) > 172800) && $data['id_nal'] != 'пополнение баланса сайта')
		{

		  //Раскомментировать следующую строку, если надо удалять просроченные записи о фото
		  // $db->query('delete from print where id = ?',array($data['id']));
		  // $db->query('delete from order_print where id_print = ?',array($data['id']));
		  ?>
		  <script type='text/javascript'>
			 dhtmlx.message.expire = 6000; // время жизни сообщения
			 dhtmlx.message({ type: 'error', text: 'Лимит в 48 часов для подтверждения заказа прошел.'});
		  </script>
		  <div class="drop-shadow lifted" style="margin: 50px 0 0 320px;">
			 <div style="font-size: 24px;">Лимит в 48 часов для подтверждения заказа прошел.</div>
			 <div style="font-size: 24px;">Заказ необходимо пересобрать.</div>
		  </div><br><br><br><br><br><br><br>
		  <?
		}
	 else
		{
		      $balans = $user_balans - $data['summ'];
		  if ($balans < 0 && $data['id_nal'] != 'наложенный платеж')
			 {
				$_SESSION['order_msg'] = 'Недостаточно средств на балансе! Необходимо  '.$data['summ'].' гр. Пополните свой счет на сайте любым<br> доступным Вам способом.
				 Или сделайте новый заказ наложенным платежом.';
				?>
				<script type="text/javascript">
				  location.replace("basket.php?1=1");
				</script>
			 <?
				die('Недостаточно средств на балансе! Необходимо  '.$data['summ'].' гр. Пополните свой счет на сайте любым<br> доступным Вам способом.
				 Или сделайте новый заказ наложенным платежом.');
			 }
		  else
			 {

				if(intval($data['zakaz']) == 1 && $data['status'] == 0) // если заказ уже был подтвержден
				  {
					 ?>
					 <div class="drop-shadow lifted" style="margin: 50px 0 0 350px;">
						<div style="font-size: 24px;">Заказ №<?=$data['id']?> ждет своей очереди на выполнение.</div>
						<div style="font-size: 24px;">По его готовности Вы получите уведомление.</div>
					 </div><br><br><br><br><br><br><br>
				  <?
				  }
				else
				  {
		                                            /*todo: новый заказ*/
								try {
										$db->query('UPDATE `print` SET `zakaz` = ?b WHERE id = ?i', array('1',$data['id']));
										if ($data['id_nal'] != 'наложенный платеж')
											 {
												$db->query('UPDATE `users` SET `balans` = ?f WHERE id = ?i',array($balans,$_SESSION['userid']));
											 }
									 }
								catch (go\DB\Exceptions\Exception $e)
									 {
										 die ('<br><br><br>Ошибка при работе с базой данных: '.$e);
									 }


		   if ($data['id_nal'] != 'наложенный платеж')
						{
         echo   "<script type='text/javascript'>
					 $('#balans').empty().append($balans);
					 </script>";
						}
	?>

		  <div class="drop-shadow lifted" style="margin: 50px 0 0 400px;">
			 <div style="font-size: 24px;">Спасибо, Ваш заказ №<?=$data['id']?> принят в обработку. </div>
		  </div>
        <?
        /*todo: письмо фотографу */
		  $letter = '<html><body><h2>Заказ №'.$data['id'].'</h2>';
        $user = $db->query('SELECT * FROM `users` WHERE `id` = ?i',array($data['id_user']),'row');
		  $letter .= "<b>Пользователь:</b> ".$user['us_name'].' '.$user['us_surname']."<br>";
		  $letter .= "<b>E-mail пользователя:</b> ".$data['email']."<br>";
		  $letter .= "<b>Id пользователя:</b> ".$data['id_user']."<br>";
		  $letter .= "<b>Дата заказа:</b> ".date('d.m.Y  H.i', $data['dt'])."<br>";
		  $letter .= "<b>Получатель:</b> ".$data['name'].'  '.$data['subname']."<br>";
		  $letter .= "<b>Номер телефона получателя:</b> ".$data['phone']."<br>";
		  $letter .= "<b>Размер фотографий:</b> ".$data['format']." см.<br>";
		  $letter .= "<b>Бумага:</b> ".$data['mat_gl']."<br>";
		  $letter .= ($data['id_nal'] == 'другое') ? "<b>Способ оплаты выбранный пользователем:</b> '".$data['user_opl'].",<br>":"<b>Способ оплаты:</b> ".$data['id_nal']."<br>";
		  $letter .= ($data['id_dost'] == 'другое') ? "<b>Способ доставки выбранный пользователем:</b> '".$data['user_dost'].",<br>":"<b>Вид доставки:</b> ".$data['id_dost']."<br>";
		  if($data['id_dost'] == 'Самовывоз из почтового отделения Вашего города' || $data['id_dost'] == 'Доставка до двери почтовой службой (кроме Одессы)')
			 {
				$letter .= "<b>Наименование службы доставки:</b> ".$data['subname'].",<br>";
				$letter .= "<b>Адрес почтового отделения или получателя:</b><br> ".$data['subname']."<br>";
			 }
		  if($data['id_dost'] == 'Самовывоз из студии (в Одессе)') $letter .= "<b>Адрес студии для получения фотографий:</b> '".$data['adr_studii']."'<br>";
		  $letter .= "<b>Примечание пользователя:</b><br>".$data['comm']."<br>";
		  $nmAlb = $db->query('SELECT a.nm FROM albums a, photos p, order_print o WHERE a.id = p.id_album  AND o.id_photo = p.id AND o.id_print = ?i LIMIT 1',array($data['id']),'el');
		  $photo_data = $db->query('select * from `order_print` where `id_print` = ?i', array($data['id']), 'assoc');
		  $letter .= "<br><b>Название альбома:</b> '".$nmAlb."'<br>";
		  $letter .= "<b>Номер и количество фотографий:</b><br>";
		  $koll = 0;
		  foreach ($photo_data as  $val)
			 {
				$name = $db->query('select `nm` from `photos` where id =?i',array($val['id_photo']),'el');
				$letter .= "Фотография № ".$name." - ".$val['koll']."шт.<br>";
				$koll += $val['koll'];
			 }
		  $letter .= "<b>Всего:</b> ".$koll." шт.<br>";
		  $letter .= "<b>К оплате:</b> ".$data['summ']."гр. (".str_digit_str($data['summ'])."гр.)<br><br>";
		  $letter .= ' <p>
								 Письмо созданно '.date('Y-m-d').'.
								 <br>
								 Это письмо создал робот, please don\'t reply!
							 </p></body></html>';


		  $mail            = new Mail_sender;
		  $mail->from_addr = $data['email'];
		  $mail->from_name = $data['name'];
		  $mail->to        = 'aleksjurii@gmail.com';
		  $mail->subj      = 'Заказ фотографий';
		  $mail->body_type = 'text/html';
		  $mail->body      = $letter;
		  $mail->priority  = 1;
		  $mail->prepare_letter();
		  $mail->send_letter();


		  /* todo: обработка заказа на FTP */
		  $http = new http;
		  /*todo: собрать заказ */
		  $zakazPrint = $http->post($_SERVER['HTTP_HOST'].'/inc/sobrZakaz.php', array('idZakaz' => $data['id']));

		  /*todo:  SMS о поступлении заказа */
		  $zakaz = iconv ('windows-1251', 'utf-8',
			 'Заказ №'.$data['id'].
			 ' от: '.$user['us_name'].
			 ' '.
			 $user['us_surname'].
			 ' '.
			 $data['format'].
			 '-'.
			 $koll.' шт. на сумму '.
			 $data['summ'].'гр.');
	 	  $sendSMS = $http->post($_SERVER['HTTP_HOST'].'/inc/sendSMS.php', array('sendSMS' => $zakaz, 'number' => '+380949477070'));
		  /* todo: проверка - результат отправки */
		  // echo $sendSMS;
		}
	  }
	 }
  }


/* todo: тест - собрать заказ */
 //  $http = new http;
 //  $http->post($_SERVER['HTTP_HOST'].'/inc/sobrZakaz.php', array('idZakaz' => $data['id']));
 //  $zakaz = iconv ('windows-1251', 'utf-8', 'Тестовое сообщение');
 //  $sendSMS = $http->post($_SERVER['HTTP_HOST'].'/inc/sendSMS.php', array('sendSMS' => $zakaz, 'number' => '+380949477070'));
/* todo: проверка - результат отправки */
 //  echo  iconv ('utf-8','windows-1251', $sendSMS);


$db->close();

?>
  </div>
<?php
  include (dirname(__FILE__).'/inc/footer.php');
?>