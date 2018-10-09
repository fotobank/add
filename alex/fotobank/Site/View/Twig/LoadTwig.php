<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 13.09.13
        * Time: 13:52
        * To change this template use File | Settings | File Templates.
        */

       namespace Site\View\Twig;

       use function chdir;
       use check_Session;
       use Site\View\Twig\Exception\LoadTwigException;
       use Twig_Environment;
       use Twig_Error_Loader;
       use Twig_Error_Runtime;
       use Twig_Error_Syntax;
       use Twig_Extension_Debug;
       use Twig_Loader_Filesystem;
       use Framework\View\Twig\Extension;

       class LoadTwig
       {

              public static $twig;

              public function __construct()
              {
                     if ($_SERVER['PHP_SELF'] === '/gb/index.php') {
                            chdir('../');
                     }

                     $templates = [
                            'alex/fotobank/Framework/View/Twig/Templates/Default',
                            'alex/fotobank/Site/View/Twig/Templates/Default'
                     ];
                     $cache     = 'alex/fotobank/Site/View/TwigCache';

                     $loader     = new Twig_Loader_Filesystem($templates);
                     self::$twig = new Twig_Environment($loader, [
                            'cache'            => $cache,
                            'charset'          => 'windows-1251',
                            'auto_reload'      => true,
                            'debug'            => true,
                            'strict_variables' => true,
                            'autoescape'       => false
                     ]);
                     self::$twig->addExtension(new Twig_Extension_Debug());
                     self::$twig->addExtension(new Extension());
                     /*$optimizer = new Twig_Extension_Optimizer(Twig_NodeVisitor_Optimizer::OPTIMIZE_FOR);
                     $twig->addExtension($optimizer);*/
              }

              function __invoke($extension, $renderData)
              {
                     $dir = null;
                     if ($_SERVER['PHP_SELF'] === '/gb/index.php') {
                            $twigName = '/gostevaia';
                     } else {
                            $twigName = mb_substr($_SERVER['PHP_SELF'], 0, -4);
                     }
                     $dir = null;
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
                            echo self::$twig->render($twigName, $renderData);
                     }
                     catch (Twig_Error_Loader $e) {
                            if (check_Session::getInstance()->has('DUMP_R')) {
                                   throw new LoadTwigException($e);
                            }
                     }
                     catch (Twig_Error_Runtime $e) {
                            if (check_Session::getInstance()->has('DUMP_R')) {
                                   throw new LoadTwigException($e);
                            }
                     }
                     catch (Twig_Error_Syntax $e) {
                            if (check_Session::getInstance()->has('DUMP_R')) {
                                   throw new LoadTwigException($e);
                            }
                     }
              }
       }
