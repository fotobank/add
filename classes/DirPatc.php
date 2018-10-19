<?php

       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 07.04.13
        * Time: 8:02
        * To change this template use File | Settings | File Templates.
        */
       class DirPatc
       {

              public static $current_album;
              public static $current_cat;
              public static $album_name;

              private function __construct()
              { /* ... @return Singleton */
              }  // �������� �� �������� ����� new Singleton

              public function __set($property, $value)
              {
                     if ($property === 'current_album') {
                            self::$current_album = $value;
                     }
                     elseif ($property === 'current_cat') {
                            self::$current_cat = $value;
                     }
                     elseif ($property === 'album_name') {
                            self::$album_name = $value;
                     }
              }

              public function __isset($name)
              {
                     if (null !== $name) {
                            return isset($this->$name);
                     }
                     return null;
              }

              public function __get($property)
              {
                     if ($property === 'current_album') {
                            return self::$current_album;
                     }
                     if ($property === 'current_cat') {
                            return self::$current_cat;
                     }
                     if ($property === 'album_name') {
                            return self::$album_name;
                     }
                     return null;
              }

              protected static $inst;  // object instance

              private function __clone()
              { /* ... @return Singleton */
              }  // �������� �� �������� ����� ������������

              public function __wakeup()
              { /* ... @return Singleton */
              }  // �������� �� �������� ����� unserialize

              public static function getInst(): \DirPatc
              {    // ���������� ������������ ��������� ������. @return Singleton
                     if (self::$inst === null) {
                            self::$inst = new DirPatc ();
                     }
                     return self::$inst;
              }

              public function destory($property)
              {
                     if ($property === 'current_album') {
                            self::$current_album = null;
                     }
                     elseif ($property === 'current_cat') {
                            self::$current_cat = null;
                     }
                     elseif ($property === 'album_name') {
                            self::$album_name = null;
                     }
              }
       }
