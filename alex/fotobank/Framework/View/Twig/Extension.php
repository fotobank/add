<?php

       namespace Framework\View\Twig;

       use check_Session;
       use minifier_jsCss;
       use RuntimeException;
       use Twig_Extension;
       use Twig_SimpleFilter;
       use Twig_SimpleFunction;

       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 13.09.13
        * Time: 21:03
        * To change this template use File | Settings | File Templates.
        */
       class Extension extends Twig_Extension
       {

              /**
               * Returns the name of the extension.
               *
               * @return string The extension name
               */
              public function getName(): string
              {
                     return 'Extension';
              }

              public function getTests(): array
              {
                     return [];
              }

              public function getFilters(): array
              {
                     return [
                            'truncate' => new Twig_SimpleFilter('truncate', [$this, 'truncate'])
                     ];
              }

              /**
               * {@inheritdoc}
               */
              public function getFunctions(): array
              {
                     return [
                            'merge_files' => new Twig_SimpleFunction('merge_files', [$this, 'merge_files']),
                            't_dump_r'    => new Twig_SimpleFunction('t_dump_r', [$this, 't_dump_r']),
                            'captcha'     => new Twig_SimpleFunction('captcha', [$this, 'captcha']),
                     ];
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
              public function truncate($text, $max = 30): string
              {
                     if (\strlen($text) >= $max) {
                            $text      = substr($text, 0, $max);
                            $lastSpace = strrpos($text, ' ');
                            $text      = substr($text, 0, $lastSpace).'...';
                     }
                     return $text;
              }

              /**
               * @param $out_file
               * @param $b
               * @param $c
               * @param $e
               * @param $f
               * дополнительная функция для twig - сжатие css и js
               *
               * @return bool|string
               */
              public function merge_files($out_file, $b, $c, $e, $f)
              {
                 $out_file = '/alex/fotobank/Site/View/TwigCache'.$out_file;

                     try {
                            $vars = [
                                   'encode' => true,
                                   'timer'  => true,
                                   'gzip'   => true
                            ];
                            $min  = new minifier_jsCss($vars);
                            return $min->merge($out_file, $b, $c, $e, $f);
                     }
                     catch (RuntimeException $e) {
                            if (check_Session::getInstance()->has('DUMP_R')) {
                                   throw $e;
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
              public function captcha($crypt, $num)
              {
                     try {
                            dsp_crypt($crypt, $num);
                     }
                     catch (RuntimeException $e) {
                            if (check_Session::getInstance()->has('DUMP_R')) {
                                   throw $e;
                            }
                     }
              }

              /**
               * @param $dump
               *
               * @return bool|string
               */
              public
              function t_dump_r(
                     $dump
              ) {
                     return dump_r($dump);
              }
       }
