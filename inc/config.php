<?php

	require_once (__DIR__.'/../classes/autoload.php');
	autoload::getInstance();

   require_once(__DIR__.'/secureSession.php');

   $session = check_Session::getInstance();
   startSession();

   if(!isset($_SESSION['referralSeed'])) $_SESSION['referralSeed'] = false;

   $link=new link_Obfuscator($session->get('referralSeed'));
   //test seed
   //print "actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";




	require(__DIR__.'/../classes/Go/DB/autoload.php');
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