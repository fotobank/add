<?php
/**
 * Центральный файл юнит-тестов, следует подключать из всех тестов
 *
 * @package    go\DB
 * @subpackage Tests
 * @author     Григорьев Олег aka vasa_c
 */

namespace go\Tests\DB;

/* Путь к goDB. Изменить при переносе */
$PATH_TO_GODB = __DIR__.'/../../../classes/Go/DB';

require_once(__DIR__.'/Base.php');
require_once(__DIR__.'/Config.php');

try {
       require_once __DIR__.'/../../../vendor/autoload.php';
}
catch (\RuntimeException $e) {
       if (\check_Session::getInstance()->has('DUMP_R')) {
              dump_r($e->getMessage());
       }
}
\go\DB\autoloadRegister();
