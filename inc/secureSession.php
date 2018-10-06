<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 20.06.13
        * Time: 21:57
        * To change this template use File | Settings | File Templates.
        */
       /**
        * ѕроверка активности сессии
        * Example
        * if (is_session_started() === false) session_start();
        */
       function is_session_started(): bool {

              if (PHP_SAPI !== 'cli') {
                     if (PHP_VERSION_ID >= 50400) {
                            return session_status() === PHP_SESSION_ACTIVE;
                     }
                     return session_id() !== '';
              }
              return false;
       }


       /**
        * @param bool $isUserActivity
        * @param null $prefix
        * старт сессии
        *
        * @return bool
        */
       function startSession($isUserActivity = true, $prefix = NULL) {

              $sessionLifetime = 300; // “аймаут отсутстви€ активности пользовател€ (в секундах)
              $idLifetime      = 60;  // ¬рем€ жизни идентификатора сессии
              /*if (session_id()) {
                     return true;
              }*/
              // ≈сли в параметрах передан префикс пользовател€,
              // устанавливаем уникальное им€ сессии, включающее этот префикс,
              // иначе устанавливаем общее дл€ всех пользователей им€ (например, SID)
              session_name('SID'.($prefix ? '_'.$prefix : ''));
              // ”станавливаем врем€ жизни куки до закрыти€ браузера (контролировать все будем на стороне сервера)
              ini_set('session.cookie_lifetime', 0);
              // стартуем сессию
              if (is_session_started() === false) {
                     session_start();
              }

              $t = time();
              if ($sessionLifetime) {
                     // ≈сли таймаут отсутстви€ активности пользовател€ задан,
                     // провер€ем врем€, прошедшее с момента последней активности пользовател€
                     // (врем€ последнего запроса, когда была обновлена сессионна€ переменна€ lastactivity)
                     if (isset($_SESSION['lastactivity'], $_SESSION['logged']) && isset($_SESSION['logged']) === true
                         && $t - $_SESSION['lastactivity'] >= $sessionLifetime) {
                            // ≈сли врем€, прошедшее с момента последней активности пользовател€,
                            // больше таймаута отсутстви€ активности, значит сесси€ истекла, и нужно завершить сеанс
                            destroySession();
                            return false;

                     }
                     if ($isUserActivity) {
                            $_SESSION['lastactivity'] = $t;
                     }
              }
              if ($idLifetime) {
                     // ≈сли врем€ жизни идентификатора сессии задано,
                     // провер€ем врем€, прошедшее с момента создани€ сессии или последней регенерации
                     // (врем€ последнего запроса, когда была обновлена сессионна€ переменна€ starttime)
                     if (isset($_SESSION['starttime'])) {
                            if ($t - $_SESSION['starttime'] >= $idLifetime) {
                                   // ¬рем€ жизни идентификатора сессии истекло
                                   // √енерируем новый идентификатор
                                   //	 session_write_close();
                                   session_regenerate_id(true);
                                   $_SESSION['starttime'] = $t;
                            }
                     } else {
                            // —юда мы попадаем, если сесси€ только что создана
                            // ”станавливаем врем€ генерации идентификатора сессии в текущее врем€
                            $_SESSION['starttime'] = $t;
                     }
              }

              return true;
       }

       /**
        * уничтожение сессии
        */
       function destroySession() {

              if (is_session_started()) {
                     session_unset();
                     /** @noinspection SummerTimeUnsafeTimeManipulationInspection */
                     setcookie(session_name(), session_id(), time() - (60 * 60 * 24));
                     session_destroy();
              }
       }
