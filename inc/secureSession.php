<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 20.06.13
        * Time: 21:57
        * To change this template use File | Settings | File Templates.
        *
        * Защита сессии от фиксации
        * Простейшим способом защиты от фиксации сессии в PHP является установка параметра session.use_only_cookies
        * конфигурационного файла php.ini в значение on.
        * Это запретит передачу идентификатора сессии в URL-адресе запроса.
        * С помощью специальной сессионной переменной $_SESSION['starttime'] проверяется статус активности.
        * Если переменная не задана, мы регенерируем идентификатор.
        * Это позволяет создать для злоумышленника новую сессию с его идентификатором, затем изменить его.
        * Смысл заключается в том, что идентификатор взломщика устареет после первого запроса.
        * Сессии обычных пользователей будут создаваться нормальным способом
        * вместе с установкой статусной переменной. Поэтому идентификаторы обычных пользователей никогда не перезапишутся.
        *
        */
       /**
        * Проверка активности сессии
        * Example
        * if (is_session_started() === false) session_start();
        */
       function isSessionStarted(): bool {

              if (PHP_SAPI !== 'cli') {
                     if (PHP_VERSION_ID >= 50400) {
                            return session_status() === PHP_SESSION_ACTIVE;
                     }
                     return session_id() !== '';
              }
              return false;
       }


       /**
        * @param bool $is_user_activity
        * @param null $prefix
        * старт сессии
        *
        * @return bool
        */
       function startSession($is_user_activity = true, $prefix = NULL) {

              $session_lifetime = 300; // Таймаут отсутствия активности пользователя (в секундах)
              $id_lifetime      = 60;  // Время жизни идентификатора сессии
              /*if (session_id()) {
                     return true;
              }*/
              // Если в параметрах передан префикс пользователя,
              // устанавливаем уникальное имя сессии, включающее этот префикс,
              // иначе устанавливаем общее для всех пользователей имя (например, SID)
              session_name('SID'.($prefix ? '_'.$prefix : ''));
              // Устанавливаем время жизни куки до закрытия браузера (контролировать все будем на стороне сервера)
              ini_set('session.cookie_lifetime', 0);
              // стартуем сессию
              if (isSessionStarted() === false) {
                     session_start();
              }

              // убрать на продакшене:
              return true;

              $t = time();
              if ($session_lifetime) {
                     // Если таймаут отсутствия активности пользователя задан,
                     // проверяем время, прошедшее с момента последней активности пользователя
                     // (время последнего запроса, когда была обновлена сессионная переменная lastactivity)
                     if (isset($_SESSION['lastactivity'], $_SESSION['logged']) && isset($_SESSION['logged']) === true
                         && $t - $_SESSION['lastactivity'] >= $session_lifetime) {
                            // Если время, прошедшее с момента последней активности пользователя,
                            // больше таймаута отсутствия активности, значит сессия истекла, и нужно завершить сеанс
                            destroySession();
                            return false;

                     }
                     if ($is_user_activity) {
                            $_SESSION['lastactivity'] = $t;
                     }
              }
              if ($id_lifetime) {
                     // Если время жизни идентификатора сессии задано,
                     // проверяем время, прошедшее с момента создания сессии или последней регенерации
                     // (время последнего запроса, когда была обновлена сессионная переменная starttime)
                     if (isset($_SESSION['starttime'])) {
                            if ($t - $_SESSION['starttime'] >= $id_lifetime) {
                                   // Время жизни идентификатора сессии истекло
                                   // Генерируем новый идентификатор
                                   //	 session_write_close();
                                   session_regenerate_id(true);
                                   $_SESSION['starttime'] = $t;
                            }
                     } else {
                            // Сюда мы попадаем, если сессия только что создана
                            // Устанавливаем время генерации идентификатора сессии в текущее время
                            $_SESSION['starttime'] = $t;
                     }
              }

              return true;
       }

       /**
        * уничтожение сессии
        */
       function destroySession() {

              if (isSessionStarted()) {
                     session_unset();
                     /** @noinspection SummerTimeUnsafeTimeManipulationInspection */
                     setcookie(session_name(), session_id(), time() - (60 * 60 * 24));
                     session_destroy();
              }
       }
