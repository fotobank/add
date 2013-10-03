<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 13.09.13
        * Time: 21:03
        * To change this template use File | Settings | File Templates.
        */
       class Extension extends Twig_Extension {

              /**
               * Returns the name of the extension.
               *
               * @return string The extension name
               */
              public function getName() {

                     return 'Extension';
              }


              public function getTests() {

                     return array();
              }


              public function getFilters() {

                     return array(
                            'truncate' => new Twig_Filter_Method($this, 'truncate')
                     );
              }



              /**
               * {@inheritdoc}
               */
              public function getFunctions() {

                     return array(
                            'merge_files' => new Twig_Function_Method($this, 'merge_files'),
                            'dump_r'      => new Twig_Function_Method($this, '__dump_r'),
                            'kapca'       => new Twig_Function_Method($this, 'kapca'),
                     );
              }


              /**
               * @param     $text
               * @param int $max
               *
               * @return string
               *
               * {% set text = 'Супер длинная строка, которую я хочу обрезать всего до 20 символов...' %}
               * {{ text | truncate(20) }}
               *
               */
              public function truncate($text, $max = 30) {

                     $lastSpace = 0;
                     if (strlen($text) >= $max) {
                            $text      = substr($text, 0, $max);
                            $lastSpace = strrpos($text, ' ');
                            $text      = substr($text, 0, $lastSpace).'...';
                     }

                     return $text;
              }


              /**
               * @param $a
               * @param $b
               * @param $c
               * @param $e
               * @param $f
               * дополнительная функция для twig - сжатие css и js
               * @return bool|string
               */
              public function merge_files($a, $b, $c, $e, $f) {

                     try {
                            $vars = array(
                                   'encode' => true,
                                   'timer'  => true,
                                   'gzip'   => true
                            );
                            $min  = new minifier_jsCss($vars);

                            return $min->merge($a, $b, $c, $e, $f);

                     }
                     catch (Exception $e) {
                            if (check_Session::getInstance()->has('DUMP_R')) {
                                   dump_r($e->getMessage());
                            }

                            return false;
                     }
              }


              /**
               * @param $crypt
               * @param $num
               *
               * @return bool|void
               */
              public function kapca($crypt, $num) {

                     try {
                            /** @noinspection PhpVoidFunctionResultUsedInspection */
                            return dsp_crypt($crypt, $num);
                     }
                     catch (Exception $e) {
                            if (check_Session::getInstance()->has('DUMP_R')) {
                                   dump_r($e->getMessage());
                            }

                            return false;
                     }
              }



              /**
               * @param $dump
               *
               * @return bool|string
               */
              public
              function __dump_r($dump
              ) {

                     return dump_r($dump);
              }

       }
