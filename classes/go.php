<?php
/**
 * Created by PhpStorm.
 * User: Jurii
 * Date: 23.10.13
 * Time: 22:36
 * класс синглтон дл€ классов
 */

       require_once (__DIR__.'/../inc/config.php');

class go {
       private static $vars = array();


       public static function build($id, $ini = NULL) { //создание класса
              $arr             = explode(':', $id);
              $class           = reset($arr);
              self::$vars[$id] = new $class($ini);

              return self::$vars[$id];
       }

       public static function has($id) { //проверка существовани€ класса
              if (isset(self::$vars[$id])) {
                     return true;
              } else {
                     return false;
              }
       }

       public static function call($id, $ini = NULL) { //вызов класса(при отсутствии готового экземпл€ра - создание нового и вызов)
              if (self::has($id)) {
                     return self::$vars[$id];
              } else {
                     return self::build($id, $ini);
              }
       }


       public static function del($id) { //удаление значени€(любого типа, в т.ч. класса)
              if (isset(self::$vars[$id])) {
                     unset(self::$vars[$id]);
              }

              return true;
       }
} 