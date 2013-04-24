<?php
	session_start();
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'creative_ls');
	define('DB_USER', 'canon632');
	define('DB_PASS', 'fianit8546');
	mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('Нет подключения к MySQL!');
	mysql_select_db(DB_NAME) or die('Недоступна БД в MySQL!');



	mysql_set_charset('cp1251');
	mysql_query('set character_set_client = \'cp1251\'');
	mysql_query('set character_set_connection = \'cp1251\'');
	mysql_query('set character_set_results = \'cp1251\'');
	mysql_query('set character_set_system = \'cp1251\'');
?>