<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 25.05.13
        * Time: 11:56
        * To change this template use File | Settings | File Templates.
        */
       define('ROOT_PATH', realpath(__DIR__).'/', true);
       include ROOT_PATH.'inc/head.php';

       use Framework\Core\Mail\Sender;

       if ($link->referralSeed) {
              if ($link->check($_SERVER['SCRIPT_NAME'].'?go='.trim($_GET['go'] ?? ''))) {
                     // проверка кода
                     //	print "<br>checked link: ${_SERVER['REQUEST_URI']}<br />\n";
                     if (!isset($_SESSION['logged'])) {
                            err_exit('Для подтверждения заказа необходимо залогиниться на сайте!');
                     }
                     if (!isset($_GET['key'])) {
                            err_exit('Ключ не найден!');
                     }
                     $key = $_GET['key'];
                     $data = go\DB\query('select * from `print` where `key` = ?string', [$key], 'row');
                     //		  dump_r($data);
                     $renderData['block'] = false;
                     $renderData['id'] = false;
                     $renderData['summ'] = false;
                     $renderData['balans'] = false;
                     if (!$data) {
                            err_exit('Ключ не найден!');
                     }
                     else {
                            if ((time() - (int)$data['dt'] > 172800) && $data['id_nal'] !== 'пополнение баланса сайта') {
                                   //Раскомментировать следующую строку, если надо удалять просроченные записи о фото
                                   // go\DB\query('delete from print where id = ?',array($data['id']));
                                   // go\DB\query('delete from order_print where id_print = ?',array($data['id']));
                                   $renderData['block'] = 'time';
                            }
                            else {
                                   $balans = $user_balans - $data['summ'];
                                   if ($balans < 0 && $data['id_nal'] !== 'наложенный платеж' &&
                                          (int)$data['zakaz'] != 1) {
                                          $_SESSION['order_msg'] =
                                                 'Недостаточно средств на балансе! Необходимо  '.$data['summ'].' гр. Пополните свой счет на сайте любым<br> доступным Вам способом.
				 Или сделайте новый заказ наложенным платежом.';
                                          $renderData['block'] = 'limit';
                                          $renderData['summ'] = $data['summ'];
                                   }
                                   else {
                                          if ((int)$data['zakaz'] == 1 &&
                                                 $data['status'] == 0) // если заказ уже был подтвержден
                                          {
                                                 $renderData['block'] = 'oldZakaz';
                                                 $renderData['id'] = $data['id'];
                                          }
                                          else {
                                                 /** новый заказ*/
                                                 try {
                                                        go\DB\query('UPDATE `print` SET `zakaz` = ?b WHERE id = ?i',
                                                               ['1', $data['id']]);
                                                        if ($data['id_nal'] !== 'наложенный платеж') {
                                                               go\DB\query('UPDATE `users` SET `balans` = ?f WHERE id = ?i',
                                                                      [$balans, $_SESSION['userid']]);
                                                        }
                                                 } catch (go\DB\Exceptions\Exception $e) {
                                                        if (check_Session::getInstance()->has('DUMP_R')) {
                                                               dump_r('<br><br><br>Ошибка при работе с базой данных: '.
                                                                      $e);
                                                        }
                                                 }
                                                 if ($data['id_nal'] !== 'наложенный платеж') {
                                                        $renderData['block'] = 'nalPlat';
                                                        $renderData['balans'] = $balans;
                                                 }
                                                 $renderData['block'] = 'ok';
                                                 $renderData['id'] = $data['id'];
                                                 /** письмо фотографу */
                                                 $letter = '<html><body><h2>Заказ №'.$data['id'].'</h2>';
                                                 $user = go\DB\query('SELECT * FROM `users` WHERE `id` = ?i',
                                                        [$data['id_user']], 'row');
                                                 $letter .= "<b>Пользователь:</b> ".$user['us_name'].' '.
                                                        $user['us_surname']."<br>";
                                                 $letter .= "<b>E-mail пользователя:</b> ".$data['email']."<br>";
                                                 $letter .= "<b>Id пользователя:</b> ".$data['id_user']."<br>";
                                                 $letter .= "<b>Дата заказа:</b> ".date('d.m.Y  H.i', $data['dt']).
                                                        "<br>";
                                                 $letter .= "<b>Получатель:</b> ".$data['name'].'  '.$data['subname'].
                                                        "<br>";
                                                 $letter .= "<b>Номер телефона получателя:</b> ".$data['phone']."<br>";
                                                 $letter .= "<b>Размер фотографий:</b> ".$data['format']." см.<br>";
                                                 $letter .= "<b>Бумага:</b> ".$data['mat_gl']."<br>";
                                                 $letter .= ($data['id_nal'] == 'другое') ?
                                                        "<b>Способ оплаты выбранный пользователем:</b> '".
                                                        $data['user_opl'].",<br>" :
                                                        "<b>Способ оплаты:</b> ".$data['id_nal']."<br>";
                                                 $letter .= ($data['id_dost'] == 'другое') ?
                                                        "<b>Способ доставки выбранный пользователем:</b> '".
                                                        $data['user_dost'].",<br>" :
                                                        "<b>Вид доставки:</b> ".$data['id_dost']."<br>";
                                                 if ($data['id_dost'] ==
                                                        'Самовывоз из почтового отделения Вашего города' ||
                                                        $data['id_dost'] ==
                                                        'Доставка до двери почтовой службой (кроме Одессы)') {
                                                        $letter .= "<b>Наименование службы доставки:</b> ".
                                                               $data['subname'].",<br>";
                                                        $letter .= "<b>Адрес почтового отделения или получателя:</b><br> ".
                                                               $data['subname']."<br>";
                                                 }
                                                 if ($data['id_dost'] ==
                                                        'Самовывоз из студии (в Одессе)') $letter .= "<b>Адрес студии для получения фотографий:</b> '".
                                                        $data['adr_studii']."'<br>";
                                                 $letter .= "<b>Примечание пользователя:</b><br>".$data['comm']."<br>";
                                                 $nmAlb =
                                                        go\DB\query('SELECT a.nm FROM albums a, photos p, order_print o WHERE a.id = p.id_album  AND o.id_photo = p.id AND o.id_print = ?i LIMIT 1',
                                                               [$data['id']], 'el');
                                                 $photo_data =
                                                        go\DB\query('select * from `order_print` where `id_print` = ?i',
                                                               [$data['id']], 'assoc');
                                                 $letter .= "<br><b>Название альбома:</b> '".$nmAlb."'<br>";
                                                 $letter .= "<b>Номер и количество фотографий:</b><br>";
                                                 $koll = 0;
                                                 foreach ($photo_data as $val) {
                                                        $name = go\DB\query('select `nm` from `photos` where id =?i',
                                                               [$val['id_photo']], 'el');
                                                        $letter .= "Фотография № ".$name." - ".$val['koll']."шт.<br>";
                                                        $koll += $val['koll'];
                                                 }
                                                 $letter .= "<b>Всего:</b> ".$koll." шт.<br>";
                                                 $letter .= "<b>К оплате:</b> ".$data['summ']."гр. (".
                                                        str_digit_str($data['summ'])."гр.)<br><br>";
                                                 $letter .= '</body></html>';
                                                 $mail = new Sender();
                                                 $mail->from_addr = $data['email'];
                                                 $mail->from_name = $data['name'];
                                                 $mail->to = 'aleksjurii@gmail.com';
                                                 $mail->subj = 'Заказ фотографий';
                                                 $mail->body_type = 'text/html';
                                                 $mail->body = $letter;
                                                 $mail->priority = 1;
                                                 $mail->prepare_letter();
                                                 $mail->send_letter();
                                                 /** обработка заказа на FTP и отправить SMS */
                                                 $http = new http();
                                                 /** собрать заказ */
                                                 $zakazPrint =
                                                        $http->post('http://'.$_SERVER['HTTP_HOST'].'/security.php',
                                                               ['idZakaz' => $data['id']]);
                                                 // echo $zakazPrint;
                                                 // dump_r($zakazPrint);
                                                 /** SMS о поступлении заказа */
                                                 $zakaz = 'Заказ №'.$data['id'].' от: '.$user['us_name'].' '.
                                                        $user['us_surname'].' '.$data['format'].'-'.$koll.
                                                        ' шт. на сумму '.$data['summ'].'гр.';
                                                 // Проверяем доступность расширения SOAP
                                                 if (extension_loaded('soap')) {
                                                        $sendSMS = $http->post('http://'.$_SERVER['HTTP_HOST'].
                                                               '/inc/lib/sms/sendSMS.php',
                                                               ['sendSMS' => $zakaz, 'number' => '+380949477070']);
                                                        //	echo  iconv ('utf-8', 'windows-1251', $sendSMS);
                                                 }
                                                 else {
                                                        $sendSMS = $http->post('http://'.$_SERVER['HTTP_HOST'].
                                                               '/inc/lib/sms/sendSMS.php',
                                                               ['sendFluSMS' => $zakaz, 'number' => '380949477070']);
                                                        // echo $sendSMS;
                                                 }
                                          }
                                   }
                            }
                     }
                     /* todo: тест - собрать заказ */
                     //  $http = new http;
                     //  $result = $http->post('http://'.$_SERVER['HTTP_HOST'].'/inc/sobrZakaz.php', array('idZakaz' => $data['id']));
                     //  echo $result;
                     // Проверяем доступность расширения SOAP
                     /* if (extension_loaded('soap')){
                     $test = 'Тестовое сообщение sendSMS';
                     $sendSMS = $http->post('http://'.$_SERVER['HTTP_HOST'].'/inc/lib/sms/sendSMS.php', array('sendSMS' => $test, 'number' => '+380949477070'));
                     echo "Extensions SOAP loaded.";
                     echo  iconv ('utf-8', 'windows-1251', $sendSMS);
                      } else {
                     $test2 = 'Тестовое сообщение sendFluSMS';
                     $sendSMS = $http->post('http://'.$_SERVER['HTTP_HOST'].'/inc/lib/sms/sendSMS.php', array('sendFluSMS' => $test2, 'number' => '380949477070'));
                      echo "Extensions SOAP is not loaded.";
                      echo  $sendSMS;
                      }*/
                     go\DB\Storage::getInstance()->get()->close();
              }
              else {
                     //	print "<br>link invalid: ${_SERVER['REQUEST_URI']} \n";
                     include(__DIR__.'/error_.php');
              }
       }
       else include(__DIR__.'/error_.php');
       // рендер страницы
       $loadTwig('.twig', $renderData);
       include(ROOT_PATH.'inc/footer.php');
