<?php
   require_once(__DIR__.'/../core/secure/linkObfuscator.php');

  /**
	* @param bool $isUserActivity
	* @param null $prefix
	* старт сессии
	* @return bool
	*/
  function startSession($isUserActivity=true, $prefix=NULL) {
	 $sessionLifetime = 300; // “аймаут отсутстви€ активности пользовател€ (в секундах)
	 $idLifetime = 60;  // ¬рем€ жизни идентификатора сессии

	 if ( session_id() ) return true;
	 // ≈сли в параметрах передан префикс пользовател€,
	 // устанавливаем уникальное им€ сессии, включающее этот префикс,
	 // иначе устанавливаем общее дл€ всех пользователей им€ (например, SID)
	 session_name('SID'.($prefix ? '_'.$prefix : ''));
	 // ”станавливаем врем€ жизни куки до закрыти€ браузера (контролировать все будем на стороне сервера)
	 ini_set('session.cookie_lifetime', 0);
	 if ( ! session_start() ) return false;

	 $t = time();

	 if ( $sessionLifetime ) {
		// ≈сли таймаут отсутстви€ активности пользовател€ задан,
		// провер€ем врем€, прошедшее с момента последней активности пользовател€
		// (врем€ последнего запроса, когда была обновлена сессионна€ переменна€ lastactivity)
		if ( isset($_SESSION['lastactivity']) && $t-$_SESSION['lastactivity'] >= $sessionLifetime ) {
		  // ≈сли врем€, прошедшее с момента последней активности пользовател€,
		  // больше таймаута отсутстви€ активности, значит сесси€ истекла, и нужно завершить сеанс
		  destroySession();
		  return false;
		}
		else {
		  // ≈сли таймаут еще не наступил,
		  // и если запрос пришел как результат активности пользовател€,
		  // обновл€ем переменную lastactivity значением текущего времени,
		  // продлева€ тем самым врем€ сеанса еще на sessionLifetime секунд
		  if ( $isUserActivity ) $_SESSION['lastactivity'] = $t;
		}
	 }

	 if ( $idLifetime ) {
		// ≈сли врем€ жизни идентификатора сессии задано,
		// провер€ем врем€, прошедшее с момента создани€ сессии или последней регенерации
		// (врем€ последнего запроса, когда была обновлена сессионна€ переменна€ starttime)
		if ( isset($_SESSION['starttime']) ) {
		  if ( $t-$_SESSION['starttime'] >= $idLifetime ) {
			 // ¬рем€ жизни идентификатора сессии истекло
			 // √енерируем новый идентификатор
			 session_regenerate_id(true);
			 $_SESSION['starttime'] = $t;
		  }
		}
		else {
		  // —юда мы попадаем, если сесси€ только что создана
		  // ”станавливаем врем€ генерации идентификатора сессии в текущее врем€
		  $_SESSION['starttime'] = $t;
		}
	 }

	 return true;
  }

  /**
	* уничтожение сессии
	*/
  function destroySession() {
	 if ( session_id() ) {
		session_unset();
		setcookie(session_name(), session_id(), time()-60*60*24);
		session_destroy();
	 }
  }


   startSession();

 // session_start();
   if(!isset($_SESSION['referralSeed'])) $_SESSION['referralSeed'] = false;
   $link=new linkObfuscator($_SESSION['referralSeed']);
   //test seed
   //print "actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";

	/*define('DB_HOST', 'localhost');
	define('DB_NAME', 'creative_ls');
	define('DB_USER', 'canon632');
	define('DB_PASS', 'fianit8546');*/
	/*mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('Ќет подключени€ к MySQL!');
	mysql_select_db(DB_NAME) or die('Ќедоступна Ѕƒ в MySQL!');


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