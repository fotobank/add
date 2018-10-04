<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 13.09.13
        * Time: 13:52
        * To change this template use File | Settings | File Templates.
        */
       class loadTwig {

              public static $twig;


              function __construct() {

                     if ($_SERVER['PHP_SELF'] === '/gb/index.php') {
                            $templates = ['../templates', '../src/Framework/View/Twig/Templates'];
                            $cache     = '../cache';
                     } else {
                            $templates = ['templates', 'src/Framework/View/Twig/Templates'];
                            $cache     = 'cache';
                     }

                     $loader     = new Twig_Loader_Filesystem($templates);
                     self::$twig = new Twig_Environment($loader, array(
                                                                      'cache'            => $cache,
                                                                      'charset'          => 'windows-1251',
                                                                      'auto_reload'      => true,
                                                                      'debug'            => true,
                                                                      'strict_variables' => true,
                                                                      'autoescape'       => false
                                                                 ));
                     self::$twig->addExtension(new Twig_Extension_Debug());
                     self::$twig->addExtension(new Extension());

                     /*$optimizer = new Twig_Extension_Optimizer(Twig_NodeVisitor_Optimizer::OPTIMIZE_FOR);
                     $twig->addExtension($optimizer);*/

              }


              function __invoke($extension, $renderData) {

                     $dir = NULL;
                     if ($_SERVER['PHP_SELF'] === '/gb/index.php') {
                            $twigName = '/gostevaia';

                     } else {
                            $twigName = mb_substr($_SERVER['PHP_SELF'], 0, -4);
                     }
                     $dir = NULL;
                     if ($_SERVER['PHP_SELF'] === '/f_svadbi.php'
                         || $_SERVER['PHP_SELF'] === '/f_deti.php'
                         || $_SERVER['PHP_SELF'] === '/f_bankety.php'
                         || $_SERVER['PHP_SELF'] === '/f_photoboock.php'
                         || $_SERVER['PHP_SELF'] === '/f_vipusk.php'
                         || $_SERVER['PHP_SELF'] === '/f_raznoe.php'
                         || $_SERVER['PHP_SELF'] === '/v_svadby.php'
                         || $_SERVER['PHP_SELF'] === '/v_deti.php'
                         || $_SERVER['PHP_SELF'] === '/v_vipusk.php'
                         || $_SERVER['PHP_SELF'] === '/v_sl_show.php'
                         || $_SERVER['PHP_SELF'] === '/v_bankety.php'
                         || $_SERVER['PHP_SELF'] === '/v_raznoe.php'
                     ) {
                            $dir = '/uslugi';
                     }
                     $twigName = $dir.$twigName.$twigName.$extension;
                     try {
                            echo  self::$twig->render($twigName, $renderData);
                     }
                     catch (Exception $e) {
                            if (check_Session::getInstance()->has('DUMP_R')) {
                                   dump_r($e->getMessage());
                            } else {
                                   echo 'Ошибка в рендере страницы';
                            }
                     }
              }

       }
