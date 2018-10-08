<?php
       require_once __DIR__.'/../classes/dump_r/dump_r.php';
       /** ----------------------------------------------------------------------------------*/
       try {
              require_once __DIR__.'/../vendor/autoload.php';
              $loadTwig = new loadTwig();
       }
       catch (Exception $e) {
              if (check_Session::getInstance()->has('DUMP_R')) {
                     var_dump($e);
                     dump_r($e->getMessage());
              }
       }
       /*try {
              require_once __DIR__.'/../classes/autoload.php';
              autoload::getInstance();
       }
       catch (Exception $e) {
              if (check_Session::getInstance()->has('DUMP_R')) {
                     dump_r($e->getMessage());
              }
       }*/
     //  require_once __DIR__.'/secureSession.php';
       $session = check_Session::getInstance();
       startSession();
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


       $configDB = array(
              '_adapter' => 'mysql',
              'host'     => 'localhost',
              'username' => 'canon632',
              'password' => 'fianit8546',
              'dbname'   => 'creative_ls',
              'charset'  => 'cp1251',
              '_debug'   => false,
              '_lazy'    => false,
       );
       go\DB\Storage::getInstance()->create($configDB); // created main database in main storage



     //  $Storage->create($config, $name);
     //  go\DB\Storage::getInstance()->get()->query($pattern, $data);

       // функция теста
       function mydebug($query, $duration) {

              echo 'Debug: query: "'.$query.'", duration='.$duration.'<br />';
       }
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
