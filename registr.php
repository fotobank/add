<?php

  define ('ROOT_PATH', realpath(__DIR__).'/', true);

  include (ROOT_PATH.'inc/head.php');
  if (!isset($_SESSION['logged'])) {
    $rLogin      = 'Имя для входа (Login)';
    $rPass       = '';
    $rPass2      = '';
    $rEmail      = 'Рабочий E-mail';
    $rSkype      = 'Не обязательно';
    $rPhone      = 'Можно ввести потом';
    $rName_us    = 'Настоящее имя';
    $rSurName_us = 'Фамилия';
    $rCity       = 'Город';
    $ok_msg      = false;
    $err_msg     = NULL;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $rLogin      = trim($_POST['rLogin']);
      $rPass       = trim($_POST['rPass']);
      $rPass2      = trim($_POST['rPass2']);
      $rEmail      = trim($_POST['rEmail']);
      $rName_us    = trim($_POST['rName_us']);
      $rSurName_us = trim($_POST['rSurName_us']);
      $rPhone      = trim($_POST['rPhone']);
      $rSkype      = trim($_POST['rSkype']);
      $rPkey       = trim($_POST['rPkey']);
      $rCity       = trim($_POST['rCity']);
      $rIp         = Get_IP();
      if ($rLogin !== 'Имя для входа (Login)') {
        if (preg_match('/[?a-zA-Zа-яА-Я0-9_-]{3,20}$/u', $rLogin)) {
          if ($rEmail !== 'Рабочий E-mail') {
            if (($rName_us !== '' && $rName_us !== 'Настоящее имя') || preg_match('/[?a-zA-Zа-яА-Я0-9_-]{2,20}$/u', $rName_us)) {
              $rName_us = ($rName_us === 'Настоящее имя') ? '' : $rName_us;
              if ($rSurName_us === '' || $rSurName_us === 'Фамилия' || preg_match('/[?a-zA-Zа-яА-Я0-9_-]{2,20}$/u', $rSurName_us)) {
                $rSurName_us = ($rSurName_us === 'Фамилия') ? '' : $rSurName_us;
                if (preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $rEmail)) {
                  if ($rPass !== '' || $rPass2 !== '') {
                    if ($rPass === $rPass2) {
                      if (preg_match("/^[0-9a-z\_\-\!\~\*\:\<\>\+\.]{8,20}$/i", $rPass)) {
                        $mdPassword = md5($rPass);
                        $cnt  = (int)go\DB\query('select count(*) cnt from users where login = ?string',
                                      array($rLogin), 'el');
                        if ($cnt <= 0) {
                          $cnt = (int)go\DB\query('select count(*) cnt from users where email = ?string', array($rEmail),'el');
                          if ($cnt <= 0) {
                            if ($rPhone === 'Можно ввести позже') {
                              $rPhone = '';
                            }
                            if ((strlen($rPhone) == '') || ((strlen($rPhone) >= 7)
                                                            && (!preg_match("/[%a-z_@.,^=:;а-я\"*&$#№!?<>\~`|[{}\]]/iu",
                                                 $rPhone)))
                            ) {
                              if ($rCity !== 'Для отправки заказанных фотографий ( можно ввести позже )'
                                  || preg_match('/[?a-zA-Zа-яА-Я0-9_-]{2,30}$/u', $rCity)
                              ) {
                                $rCity = ($rCity === 'Для отправки заказанных фотографий ( можно ввести позже )') ? '' : $rCity;
                                if ($rSkype === 'Не обязательно') {
                                  $rSkype = '';
                                }
                                $time = time();
                                // проверка капчи
                                if ($rPkey === chk_crypt($rPkey)) {
                                  // Устанавливаем соединение с бд(не забудьте подставить ваши значения сервер-логин-пароль)
                                  try {
                                    // Получаем Id, под которым юзер добавился в базу
                                    $id = $db('INSERT INTO users (login, pass, email, us_name, timestamp, ip, phone, skype, city, us_surname)
                                                 VALUES (?string,?string,?string,?string,?i,?string,?string,?string,?string,?string)',
                                      array(
                                           $rLogin, $mdPassword,
                                           $rEmail,
                                           $rName_us, $time, $rIp,
                                           $rPhone, $rSkype, $rCity,
                                           $rSurName_us
                                      ), 'id');
                                  }
                                  catch (go\DB\Exceptions\Exception  $e) {
                                    trigger_error('Ошибка при работе с базой данных во время регистрации пользователя! Файл - registr.php.');
                                    $err_msg = 'Ошибка при работе с базой данных!';
                                    die("<div align='center' class='err_f_reg'>Ошибка при работе с базой данных!</div>");
                                  }
                                  // Составляем "keystring" для активации
                                  $key  = md5(substr($rEmail, 0, 2).$id.substr($rLogin, 0, 2));
                                  $date = date("d.m.Y", $time);
                                  // Компонуем письмо
                                  $title = 'Потвеждение регистрации на сайте Creative line studio';
                                  $headers = "Content-type: text/plain; charset=windows-1251\r\n";
                                  $headers .= "From: Администрация Creative line studio <webmaster@aleks.od.ua> \r\n";
                                  $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
                                  $letter  = <<< LTR
													  Здравствуйте, $rName_us.
													  Вы успешно зарегистрировались на Creative Line Studio.
													  После активации аккаунта Вам станут доступны скачивание, покупка или голосование за понравившуюся фотографию.
													  Так же для всех зарегистрированных пользователей предусмотрены различные бонусы и скидки.
													  Ваши регистрационные данные:
														  логин: $rLogin
														  пароль: $rPass

													  Для активации аккаунта вам следует пройти по ссылке:
													  http://$_SERVER[HTTP_HOST]/activation.php?login=$rLogin&key=$key

													  Данная ссылка будет доступна в течении 5 дней.

													  $date
LTR;
                                  // Отправляем письмо
                                  if (!mail($rEmail,
                                    $subject,
                                    $letter,
                                    $headers)
                                  ) {
                                    // Если письмо не отправилось, удаляем юзера из базы
                                    go\DB\query('DELETE FROM users WHERE login= (?string) LIMIT 1',
                                      array($rLogin));
                                    $err_msg =
                                           'Произошла ошибка при отправке письма.<br> Попробуйте зарегистрироваться еще раз.';
                                  } else {
                                    $ok_msg = true;

                                  }
                                } else {
                                  $err_msg = 'Неправильны ввод проверочного числа!';
                                }

                              } else {
                                $err_msg = 'Ошибка в названии города!';
                              }
                            } else {
                              $err_msg = 'Телефон указан неправильно! (должно быть больше 6 цифр)<br> пример: (067)-123-45-67';
                            }
                          } else {
                            $err_msg = 'Пользователь с таким E-mail уже существует!<br>Нажмите на восстановление пароля<br> или зарегистрируйтесь на другой E-mail.';
                          }
                        } else {
                          $err_msg = 'Пользователь с таким логином уже существует!';
                        }

                      } else {
                        $err_msg = 'В поле `Пароль` введены недопустимые символы<br> или длина меньше 8 символов.<br> Допускаются только английские символы, цифры и знаки<br>  . - _ ! ~ * : < > + ';
                      }
                    } else {
                      $err_msg = 'Пароли не совпадают!';
                    }
                  } else {
                    $err_msg = 'Поле `Пароль` не заполнено!';
                  }
                } else {
                  $err_msg = 'Указанный `E-mail` имеет недопустимый формат!';
                }
              } else {
                $err_msg = 'Заполните поле `Фамилия`!';
              }
            } else {
              $err_msg = 'Заполните поле `Ваше имя`!';
            }
          } else {
            $err_msg = 'Поле `E-mail` не заполнено!';
          }

        } else {
          $err_msg = 'Логин может состоять из букв, цифр, дефисов и подчёркиваний.<br> Длина от 3 до 20 символов.';
        }
      } else {
        $err_msg = 'Поле `Логин` не заполнено!';
      }

    }

    $regData    = array(
      'rLogin'      => $rLogin,
      'rPass'       => $rPass,
      'rPass2'      => $rPass2,
      'rName_us'    => $rName_us,
      'rEmail'      => $rEmail,
      'rSkype'      => $rSkype,
      'rPhone'      => $rPhone,
      'err_msg'     => $err_msg,
      'ok_msg'      => $ok_msg,
      'rCity'       => $rCity,
      'rSurName_us' => $rSurName_us
    );
    $renderData = array_merge($renderData, $regData);

    $loadTwig('.twig', $renderData);
    if (isset($err_msg)) {
      unset ($err_msg);
    }

  } else {
    echo "<script type='text/javascript'>window.document.location.href='/index.php'</script>";
  }
  include (ROOT_PATH.'inc/footer.php');
