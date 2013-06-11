<?php
	session_start();
	/*define('DB_HOST', 'localhost');
	define('DB_NAME', 'creative_ls');
	define('DB_USER', 'canon632');
	define('DB_PASS', 'fianit8546');*/
	/*mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('Нет подключения к MySQL!');
	mysql_select_db(DB_NAME) or die('Недоступна БД в MySQL!');


	mysql_set_charset('cp1251');
	mysql_query('set character_set_client = \'cp1251\'');
	mysql_query('set character_set_connection = \'cp1251\'');
	mysql_query('set character_set_results = \'cp1251\'');
	mysql_query('set character_set_system = \'cp1251\'');*/


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
?>