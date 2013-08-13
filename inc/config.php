<?php
   require_once(__DIR__.'/../core/secure/linkObfuscator.php');
   require_once(__DIR__.'/secureSession.php');
   require_once(__DIR__.'/../core/checkSession/checkSession.php');
   $session = checkSession::getInstance();
   startSession();

   if(!isset($_SESSION['referralSeed'])) $_SESSION['referralSeed'] = false;

   $link=new linkObfuscator($session->get('referralSeed'));
   //test seed
   //print "actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";




	require(__DIR__.'/goDB/autoload.php');
	\go\DB\autoloadRegister();
	$params = array(
		            'host'     => 'localhost',
	               'username' => 'canon632',
	               'password' => 'fianit8546',
	               'dbname'   => 'creative_ls',
	               'charset'  => 'cp1251',
	         //    '_debug'   => true,
	               '_debug'   => false,
						'_lazy'    => false,
	);

	$db = go\DB\DB::create($params, 'mysql');
	$Storage = go\DB\Storage::getInstance();
	$Storage->set($db, 'db-for-data');