<?php
/**
 * Created by PhpStorm.
 * User: Jurii
 * Date: 23.10.13
 * Time: 22:36
 * ����� �������� ��� �������
 */

       require_once __DIR__.'/../alex/fotobank/Framework/Boot/config.php';

class go {
       private static $vars = array();


       public static function build($id, $ini = NULL) { //�������� ������
              $arr             = explode(':', $id);
              $class           = reset($arr);
              self::$vars[$id] = new $class($ini);

              return self::$vars[$id];
       }

       /**
        * @param $id
        * @return bool
        * �������� ������������� ������
        */
       public static function has($id): bool
       {
              if (isset(self::$vars[$id])) {
                     return true;
              }
              return false;
       }

       public static function call($id, $ini = NULL) { //����� ������(��� ���������� �������� ���������� - �������� ������ � �����)
              if (self::has($id)) {
                     return self::$vars[$id];
              }
              return self::build($id, $ini);
       }


       public static function del($id) { //�������� ��������(������ ����, � �.�. ������)
              if (isset(self::$vars[$id])) {
                     unset(self::$vars[$id]);
              }

              return true;
       }
} 
