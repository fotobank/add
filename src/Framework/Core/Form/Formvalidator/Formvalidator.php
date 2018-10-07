<?php

       namespace Framework\Core\Form\Formvalidator;




       //   header('Content-type: text/html; charset=windows-1251');
       require_once(__DIR__.'/../../../../../inc/config.php');
       require_once(__DIR__.'/../../../../../inc/func.php');



       class Formvalidator {


              /*
               * ошибка получения длины Windows-1251 строк может быть проблематичным, поскольку не все хостинг-провайдеры поддерживают многобайтовые функции
               */
              /**
               * @param $value
               * @param $args
               *
               * @return string
               */
              public function textValidator($value, $args): string {

                     //        $min=$args[0];
                     //        $max=$args[1];
                     [$min, $max] = $args;
                     $length = mb_strlen($value, 'cp1251');
                     if ($min && ($length < $min)) {
                            return "слишком коротко (мин. $min символов)";
                     }
                     if ($max && ($length > $max)) {
                            return "слишком длинно (макс. $max символов)";
                     }

                     return false;
              }


              /**
               * @param $value
               * @param $args
               *
               * @return bool|string
               */
              public function passValidator($value, $args) {

                     //	 $pass1=$args[0];
                     //	 $pass2=$args[1];
                     //	 $min=$args[2];
                     //	 $max=$args[3];
                     [$pass1, $pass2, $min, $max] = $args;
                     if ($pass1 !== $pass2) {
                            return 'Пароли не совпадают';
                     }
                     $length = \strlen(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
                     if ($min && ($length < $min) && ($length !== 0)) {
                            return "слишком коротко (мин. $min символов)";
                     }
                     if ($max && ($length > $max)) {
                            return "слишком длинно (макс. $max символов)";
                     }
                     if ($pass1 === '' || preg_match($args[4], $value)) {
                            return false;
                     }

                     return $args[5];

              }


              /**
               * @param $value
               *
               * @return string
               */
              public function termValidator($value): string {

                     if ($value !== 'on') {
                            return ' Вы должны принять условия.';
                     }

                     return false;
              }



              /**
               * @param $value
               * @param $args
               *
               * @return bool|string
               */
              public function regExpValidator($value, $args) {

                     //	 $min=$args[0];
                     //	 $max=$args[1];
                     [$min, $max] = $args;
                     $length = \strlen(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
                     if ($min && ($length < $min) && ($length !== 0)) {
                            return "слишком коротко (мин. $min символов)";
                     }
                     if (($max) && ($length > $max)) {
                            return "слишком длинно (макс. $max символов)";
                     }
                     if (preg_match($args[2], $value)) {
                            return false;
                     }

                     return $args[3];
              }


              /**
               * @param $value
               * @param $args
               *
               * @return bool|string
               */
              public function loginValidator($value, $args) {

//                     $min    = $args[0];
//                     $max    = $args[1];
                     [$min, $max] = $args;
                     $length = \strlen(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
                     if ($min && ($length < $min) && ($length !== 0)) {
                            return "слишком коротко (мин. $min символов)";
                     }
                     if ($max && ($length > $max)) {
                            return "слишком длинно (макс. $max символов)";
                     }
                     if (!preg_match($args[2], $value)) {
                            return $args[3];
                     }
                     //  $rs = \go\DB\query('SELECT `id` FROM `users` WHERE `login`=?string', array($value), 'el');
                     /*if ($rs && $rs !== $_SESSION['userid']) {
                            return 'Пользователь с таким логином уже существует, выберите, пожалуйста, другой.';
                     }*/

                     return false;
              }


              /**
               * @param $value
               * @param $args
               *
               * @return bool|string
               */
              public function phoneValidator($value, $args) {

//                     $min    = $args[0];
//                     $max    = $args[1];
                     [$min, $max] = $args;
                     $length = \strlen(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
                     if ($min && ($length < $min) && ($length !== 0)) {
                            return "слишком коротко (мин. $min символов)";
                     }
                     if (($max) && ($length > $max)) {
                            return "слишком длинно (макс. $max символов)";
                     }
                     if (!preg_match($args[2], $value)) {
                            return false;
                     }

                     return $args[3];
              }


              /**
               * @brief check protection code
               *
               * @param $code
               * @param $args
               *
               * @return bool|string
               */
              public function jsProtector($code, $args) {

                     if ($code !== $args[0]) {
                            return 'Неправильный код защиты (JS может быть выключен, или ты бот)';
                     }

                     return false;
              }
       }
