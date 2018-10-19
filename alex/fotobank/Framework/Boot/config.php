<?php
/**
 * Framework Component
 * @framework  ALEX_FOTOBANK
 * @author  Alex Jurii <jurii@mail.ru>
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2016
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

       //     set_time_limit(0);
       //     ignore_user_abort(1);
//       			 error_reporting(E_ALL | E_STRICT);

//       error_reporting(0);
       error_reporting(-1);
       /*if (ini_set('display_errors', '1') === false ||
              ini_set('display_startup_errors', '1') === false ||
              //  Если включена, последняя произошедшая ошибка будет первой в переменной $php_errormsg
              ini_set('track_errors', '1') === false) {
              throw new RuntimeException('Unable to set display_errors.');
       }*/
       if ($_SERVER['PHP_SELF'] === '/gb/index.php') {
              chdir('../');
       }
       require_once __DIR__.'/boot_config.php';
       require_once ROOT_PATH.'vendor/autoload.php';
       require_once ROOT_PATH.'inc/func.php';
       $session = check_Session::getInstance();
       if (!$session->has('referralSeed')) {
              $session->set('referralSeed', false);
       }
       $link = new link_Obfuscator($session->get('referralSeed'));
       //       test seed
       //       print "actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
       //       require_once (__DIR__.'/../classes/go/DB/autoload.php');
       //       \go\DB\autoloadRegister();
       /*$params = array(
              'host'     => 'localhost',
              'username' => 'canon632',
              'password' => 'fianit8546',
              'dbname'   => 'creative_ls',
              'charset'  => 'cp1251',
              '_debug'   => false,
              '_lazy'    => false,
       );

       $Storage = go\DB\Storage::getInstance();
       $db = go\DB\DB::create($params, 'mysql');
       $Storage->set($db);*/
       $configDB = ['_adapter' => 'mysql', 'host' => 'localhost', 'username' => 'canon632', 'password' => 'fianit8546',
                    'dbname'   => 'creative_ls', 'charset' => 'cp1251', '_debug' => false, '_lazy' => false,];
       go\DB\Storage::getInstance()->create($configDB); // created main database in main storage
       //  $Storage->create($config, $name);
       //  go\DB\Storage::getInstance()->get()->query($pattern, $data);
       // функция теста
       /*function mydebug($query, $duration)
       {
              echo 'Debug: query: "'.$query.'", duration='.$duration.'<br />';
       }*/
       // запуск теста
       //      $db->setDebug('mydebug');
       /* $config = array(
                         'host'     => 'localhost',
                         'username' => 'canon632',
                         'passwd'   => 'fianit8546',
                         'dbname'   => 'creative_ls',
                         'charset'  => 'cp1251',
                         'postmake' => true,
                         'debug'    => false
       );
       $db = new goDB($config);*/
