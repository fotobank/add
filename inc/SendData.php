<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 12.04.13
        * Time: 12:55
        * To change this template use File | Settings | File Templates.
        */
       /**
        *  ajax скрипт восстановления пароля
        */
       header('Content-type: text/html; charset=windows-1251');
       require_once __DIR__.'/../alex/fotobank/Framework/Boot/config.php';
       $error_processor = Error_Processor::getInstance();
       $session = check_Session::getInstance();
       // капча
       $cryptinstall = '/classes/dsp/cryptographp.fct.php';
       require_once(__DIR__.'/../classes/dsp/cryptographp.fct.php');
       /**
        * @param $where
        * @param $type
        *
        * @return string
        */
       function checkData($where, $type) {

              $user_data = NULL;
              $error     = false;
              $session   = check_Session::getInstance();
              try {
                     $user_data = go\DB\query('select * from users where ?col = ?', array($type, $where), 'row');

              }
              catch (go\DB\Exceptions\Exception  $e) {
                     $session->set('err_msg', 'Ошибка при работе с базой данных');
                     $error = true;
              }
              if ($error != true && $user_data) {
                     $title   = 'Восстановление пароля на сайте Creative line studio';
                     $headers = "Content-type: text/plain; charset=windows-1251\r\n";
                     $headers .= "From: Администрация Creative line studio \r\n";
                     $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
                     $letter  = "Здравствуйте,".iconv('utf-8', 'windows-1251', $user_data['us_name'])."!\r\n";
                     $letter  .= "Кто-то (возможно, Вы) запросил восстановление пароля на сайте Creative line studio.\r\n";
                     $letter  .= "Данные для входа на сайт:\r\n";
                     $letter  .= "   логин: ".iconv('utf-8', 'windows-1251', $user_data['login'])."\r\n";
                     // создание нового пароля
                     //$password = genpass(10, 3); // пароль с регулируемым уровнем сложности
                     $password = genPassword(10); // легкозапоминающийся пароль
                     // шифровка и запись в базу
                     getPassword($password, $user_data['id']) or die("Ошибка!");
                     $letter .= "   пароль: $password\r\n";
                     $letter .= "Если вы не запрашивали восстановление пароля, пожалуйста, немедленно свяжитесь с администрацией сайта!\r\n";
                     // Отправляем письмо
                     if (!mail($user_data['email'], $subject, $letter, $headers)) {
                            $session->set('err_msg', 'Не удалось отправить письмо. Пожалуйста, попробуйте позже.<br>');
                     } else {
                            $session->set('ok_msg2',
                                   'Запрос выполнен.<br>Новый пароль отправлен на E-mail,<br> указанный Вами при регистрации.<br>');

                     }
                     $ret = 'true';
              } else {
                     $session->set('err_msg', "Пользователь с данным '$type' не найден.<br>");
                     $ret = 'false';
              }
              go\DB\Storage::getInstance()->get()->close();

              return $ret;
       }

       //Получаем данные
       if (!$session->has('previos_data')
           || $session->get('previos_data') != md5(trim($_POST['login']).trim($_POST['email']).trim($_POST['pkey']))
       ) {
              if (iconv("utf-8", "windows-1251", $_POST['login'].$_POST['email'].$_POST['pkey']) == "Введите Ваш логин:или E-mail:Код безопасности:"
              ) {
                     $session->set('err_msg', "Необходимо заполнить одно из полей.<br>");
              } else {
                     if ($_POST['pkey'] == chk_crypt($_POST['pkey'])) {
                            if (isset($_POST['login']) && $_POST['login'] != '') {
                                   $dataLogin = iconv("utf-8", "windows-1251", $_POST['login']);
                                   if ($dataLogin != "Введите Ваш логин:") {
                                          $login = trim(htmlspecialchars($dataLogin));
                                          if (!preg_match("/[?a-zA-Zа-яА-Я0-9_-]{3,16}$/", $login)) {
                                                 $session->set('err_msg2',
                                                        "Логин может состоять из букв, цифр, дефисов и подчёркиваний. Длина от 3 до 16 символов.<br>");
                                                 $where = 'false';
                                          } else {
                                                 $login = iconv("windows-1251", "utf-8", $login);
                                                 $where = checkData($login, 'login');
                                          }
                                   }
                            }
                            if (isset($_POST['email']) && $_POST['email'] != '') {
                                   $dataEmail = iconv("utf-8", "windows-1251", $_POST['email']);
                                   if ($dataEmail != "или E-mail:") {
                                          $email = trim(htmlspecialchars($dataEmail));
                                          if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $email)) {
                                                 $session->set('err_msg2', "Ошибочный 'E-mail' (пример: a@b.c)!<br>");
                                                 $where = 'false';
                                          } else {
                                                 $where = checkData($email, 'email');
                                          }
                                   }
                            }
                            if (empty($_POST['email']) && empty($_POST['login'])) {
                                   $where = '';
                            }
                            if ($where == '') {
                                   $session->set('err_msg', "Пожалуйста, заполните одно из полей!<br>");
                            }
                            if ($where == 'false') {
                                   $session->set('err_msg', "Пользователь не найден.");
                            }

                     } else {
                            $session->set('err_msg', "Неправильный ввод проверочного числа!<br>");
                     }
              }
       } elseif ($session->get('previos_data') == "b894200597453166c8ff8dd7d7488263") {
              $session->set('err_msg', "<p class='ttext_red'>Для напоминания пароля необходимо заполнить<br> одно из полей.</p><br>");
       } else {
              $session->set('err_msg', "<p class='ttext_red'>Повторный ввод одинаковых данных!</p><br>");
       }
       if ($session->has('ok_msg2')) {
              $_SESSION['ok_msg2'] = "<p class='ttext_blue'>".$_SESSION['ok_msg2']."</p>";
              echo $session->get('ok_msg2');
              $session->del('ok_msg2');
       } else {
              if ($session->has('err_msg2')) {
                     echo $session->get('err_msg2');
              } elseif ($session->has('err_msg')) {
                     echo $session->get('err_msg');
              }

       }
       $session->set('previos_data', md5(trim($_POST['login']).trim($_POST['email']).trim($_POST['pkey'])));
       $session->del('err_msg');
       $session->del('err_msg2');
       $session->del('ok_msg2');
       $session->del('secret_number');
