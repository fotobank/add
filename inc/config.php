<?php
   require_once(__DIR__.'/../core/secure/linkObfuscator.php');

  /**
	* @param bool $isUserActivity
	* @param null $prefix
	* ����� ������
	* @return bool
	*/
  function startSession($isUserActivity=true, $prefix=NULL) {
	 $sessionLifetime = 300; // ������� ���������� ���������� ������������ (� ��������)
	 $idLifetime = 60;  // ����� ����� �������������� ������

	 if ( session_id() ) return true;
	 // ���� � ���������� ������� ������� ������������,
	 // ������������� ���������� ��� ������, ���������� ���� �������,
	 // ����� ������������� ����� ��� ���� ������������� ��� (��������, SID)
	 session_name('SID'.($prefix ? '_'.$prefix : ''));
	 // ������������� ����� ����� ���� �� �������� �������� (�������������� ��� ����� �� ������� �������)
	 ini_set('session.cookie_lifetime', 0);
	 if ( ! session_start() ) return false;

	 $t = time();

	 if ( $sessionLifetime ) {
		// ���� ������� ���������� ���������� ������������ �����,
		// ��������� �����, ��������� � ������� ��������� ���������� ������������
		// (����� ���������� �������, ����� ���� ��������� ���������� ���������� lastactivity)
		if ( isset($_SESSION['lastactivity']) && $t-$_SESSION['lastactivity'] >= $sessionLifetime ) {
		  // ���� �����, ��������� � ������� ��������� ���������� ������������,
		  // ������ �������� ���������� ����������, ������ ������ �������, � ����� ��������� �����
		  destroySession();
		  return false;
		}
		else {
		  // ���� ������� ��� �� ��������,
		  // � ���� ������ ������ ��� ��������� ���������� ������������,
		  // ��������� ���������� lastactivity ��������� �������� �������,
		  // ��������� ��� ����� ����� ������ ��� �� sessionLifetime ������
		  if ( $isUserActivity ) $_SESSION['lastactivity'] = $t;
		}
	 }

	 if ( $idLifetime ) {
		// ���� ����� ����� �������������� ������ ������,
		// ��������� �����, ��������� � ������� �������� ������ ��� ��������� �����������
		// (����� ���������� �������, ����� ���� ��������� ���������� ���������� starttime)
		if ( isset($_SESSION['starttime']) ) {
		  if ( $t-$_SESSION['starttime'] >= $idLifetime ) {
			 // ����� ����� �������������� ������ �������
			 // ���������� ����� �������������
			 session_regenerate_id(true);
			 $_SESSION['starttime'] = $t;
		  }
		}
		else {
		  // ���� �� ��������, ���� ������ ������ ��� �������
		  // ������������� ����� ��������� �������������� ������ � ������� �����
		  $_SESSION['starttime'] = $t;
		}
	 }

	 return true;
  }

  /**
	* ����������� ������
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
	/*mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('��� ����������� � MySQL!');
	mysql_select_db(DB_NAME) or die('���������� �� � MySQL!');


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