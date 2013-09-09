<?php

   require_once (__DIR__.'/../autoload.php');
	autoload::getInstance();



// Все методы должны быть вызвана перед послылкой чего-нибудь в браузер (любой echo).
// Вы не должны вызвать session_start для любой операции..
// Вы можете настроить сессии перед любой операцией (call session_set_cookie_params or session_name).

// Пример Как установить значение сессии
check_Session::getInstance()->set('example', 123);

// Пример Как получить значение из сессии по ключевым
$value = check_Session::getInstance()->get('example');

// Пример, как проверить существование ключа
$exists = check_Session::getInstance()->has('example');

// Пример Как сбросить значение из сессии по ключу
check_Session::getInstance()->del('example');

