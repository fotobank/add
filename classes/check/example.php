<?php

       try {
              require_once __DIR__.'/../../vendor/autoload.php';
       }
       catch (\RuntimeException $e) {
              if (\check_Session::getInstance()->has('DUMP_R')) {
                     dump_r($e->getMessage());
              }
       }



// Все методы должны быть вызвана перед послылкой чего-нибудь в браузер (любой echo).
// Вы не должны вызвать session_start для любой операции..
// Вы можете настроить сессии перед любой операцией (call session_set_cookie_params or session_name).

// Пример Как установить значение сессии
check_Session::getInstance()->set('example', 123);

// Пример Как получить значение из сессии по ключу
$value = check_Session::getInstance()->get('example');

// Пример, как проверить существование ключа
$exists = check_Session::getInstance()->has('example');

// Пример Как сбросить значение из сессии по ключу
check_Session::getInstance()->del('example');

