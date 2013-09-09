<?php
	error_reporting (E_ALL);
	ini_set('display_errors', 1);

	if(!defined('DUMP_R')) define('DUMP_R', true); // запрет показа ошибок в DUMP_R ( true - показавать )
   if(!defined('Debug_HC')) define('Debug_HC', false); // запрет показа ошибок в Debug_HackerConsole_Main ( true - показавать )

	try {
	require_once (__DIR__.'/../classes/autoload.php');
	autoload::getInstance();
	} catch (Exception $e) {
	die ('ERROR: (head.php lin 11) ' . $e->getMessage());
   }


   require_once (__DIR__.'/../classes/dump_r/dump_r.php');
	require_once (__DIR__.'/config.php');
   require_once (__DIR__.'/func.php');

// require_once (__DIR__.'/phpIni.php');

   header('Content-type: text/html; charset=windows-1251');
   header("X-Frame-Options: SAMEORIGIN");
?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//RU" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   <html xmlns:Логин="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<meta name="viewport" content="width=device-width, initial-scale=0.85" />
<!--		<meta name="google-site-verification" content="uLdE_lzhCOntN_AaTM1_sQNmIXFk1-Dsi5AWS0bKIgs"/>-->
<!--		<link href='http://fonts.googleapis.com/css?family=Lobster|Comfortaa:700|Jura:600&subset=cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>-->

		<?
		// шаблонизатор
		try {
			require_once (__DIR__ . '/../lib/Twig/Autoloader.php');
			Twig_Autoloader::register();
			$templates = (isset($gb) && $gb == '/gb') ? '../templates':'templates';
			$loader = new Twig_Loader_Filesystem($templates);
			$twig = new Twig_Environment($loader, array(
															  'cache'       => 'cache',
															  'charset'=>'windows-1251',
															  'auto_reload' => true
															  ));
		} catch (Exception $e) {
			if(DUMP_R) dump_r($e->getMessage());
		}


      // хранилище объектов использование объекта как массива
		$registry = new Registry();

		// обработка ошибок
		 $error_processor = Error_Processor::getInstance();
		 $session = check_Session::getInstance();
		/**
		 *  Тесты для проверки Error_Processor
		 * PHP set_error_handler TEST
		 */
 	 //   IMAGINE_CONSTANT;
		/**
		 * PHP set_exception_handler TEST
		 */
	 // 	throw new Exception( 'Imagine Exception' );
		/**
		 * PHP register_shutdown_function TEST ( IF YOU WANT TEST THIS, DELETE PREVIOUS LINE )
		 */
	//    imagine_function();

		require_once (__DIR__.'/title.php');
		$cryptinstall = '/classes/dsp/cryptographp.fct.php';
		require_once  (__DIR__.'/../classes/dsp/cryptographp.fct.php');


		?>
		<!--[if lt IE 9]>
	  <script type='text/javascript'>
			document.createElement('header');
			document.createElement('nav');
			document.createElement('section');
			document.createElement('article');
			document.createElement('aside');
			document.createElement('footer');
			document.createElement('figure');
			document.createElement('figcaption');
			document.createElement('span');
		</script>
		<![endif]-->

		<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico"/>
		<link rel="shortcut icon" href="/img/ico_nmain.gif"/>
	   <link rel="stylesheet" href="/css/main.css" type="text/css">

		<?

		//Initialize the class with image encoding, gzip, a timer, and use the google closure API
		$vars = array(
		  'encode' => true,
		  'timer' => true,
		  'gzip' => true
		);
		$min = new minifier_jsCss( $vars );

		$include_CSS= array(
		  // кнопка вверх
		  'css/dynamic-to-top.css',
		  'css/bootstrap.css',
		  'css/lightbox.css',
		  'css/animate.css',
		  'css/bootstrap-modal.css',
		  // сообщения
		  'js/jsmessage/codebase/themes/message_default.css',
		  // сообщения
		  'js/humane/themes/jackedup.css',
//		  'js/humane/themes/libnotify.css',
//		  'js/humane/themes/bigbox.css',
//		  'css/main.css',
		  'js/visLightBox/data/vlboxCustom.css',
		  'js/visLightBox/data/visuallightbox.css',
		  'js/prettyPhoto/css/prettyPhoto.css',
		  'js/badger/badger.css'
		);

		?>
		<link rel="stylesheet" href="<?php $min->merge( '/cache/head.min.css', 'css', $include_CSS, '', $include_CSS ); ?>" />
		<?
//		$min->logs();


		$include_Js = array(
		  'js/jquery-1.10.2.min.js',
		  'js/jquery.lazyload.js',
		  'js/bootstrap.min.js',
		  'js/bootstrap-modalmanager.js',
		  'js/bootstrap-modal.js',
	//	  <!--сообщения-->
		  'js/jsmessage/codebase/message.js',
		  'js/humane/humane.js',
		  'js/main.js',
		  'js/ajax.js',
		  'js/no-copy.js',
		  'js/badger/badger.js',
		  'js/jquery.waitforimages.js'
		);
		$prioritize_Js = array(
		  'js/jquery-1.10.2.min.js',
		  'js/jquery.lazyload.js',
		  'js/bootstrap.min.js',
		  'js/bootstrap-modalmanager.js',
		  'js/bootstrap-modal.js'
		);
		?>
		<script src="<?php $min->merge( '/cache/head.min.js', 'js', $include_Js, '', $prioritize_Js); ?>"></script>

	  <script type="text/JavaScript">
		 //подавить все сообщения об ошибках JavaScript
 		 window.onerror=null;
	  </script>
		<?
//	$min->logs();

		/*if (strstr($_SERVER['PHP_SELF'], 'folder_for_prototype')): */?><!--
		  <script type="text/javascript" src="/js/prototype.js"></script>
		  <script type="text/javascript" src="/js/scriptaculous.js?load=effects"></script>
		  <script type="text/javascript" src="/js/lightbox.js"></script>
		--><?/* endif; */?>


</head>
<?
  flush();
?>
<body>
<div id="maket">

	<div id="photo_preview_bg" class="hidden" onClick="hidePreview();"></div>
	<div id="photo_preview" class="hidden"></div>


	<!--Голова начало-->
	<div id="head">

	<?
	  require_once (__DIR__.'/flash.php');
	  $user_balans = $db->query('select balans from users where id = ?i',array($session->get('userid')),'el');
	  $_SESSION['userVer'] = ($session->has('userVer'))?$session->get('userVer'):genpass(10, 2);
	  $_SESSION['accVer'] = ($session->has('accVer'))?$session->get('accVer'):genpass(10, 2);

     // форма логина
		try {
			echo $twig->render('top_head.twig', array (
															 'logged' => $session->has('logged'),
															 'us_name' =>  $session->get('us_name'),
															 'user_balans' => $user_balans,
															 'accVer' =>  $session->get('accVer'),
															 'userVer' => $session->get('userVer')
															 ));
		} catch (Exception $e) {
			if(DUMP_R) dump_r($e->getMessage());
		}


	// <!-- СООБЩЕНИЕ ОБ ОШИБКЕ-->
	new printMsg();
	?>
		<div id="main_menu">
	<?

			$value = $_SERVER['PHP_SELF'];
			if ($_SERVER['PHP_SELF'] == '/fotobanck_adw.php')
			    {
				$value = '/fotobanck_adw.php?unchenge_cat';
			    }

			// вывод меню
			try {
			   echo $twig->render('main_menu.twig', array (
																 'value' => $value
																 ));
			    } catch (Exception $e) {
				if(DUMP_R) dump_r($e->getMessage());
			    }

			?>

			<object width="90" height="90" style="position: absolute; margin-left: 135px; margin-top: 26px; width: 70px; height: 80px; z-index:10;" type="application/x-shockwave-flash" data="/img/calendarb.swf">
				<param name="movie" value="img/calendar2b.swf"/>
				<param name="wmode" value="transparent"/>
			</object>


		</div>

	</div>

<!--[if lt IE 7]>
  <p class="chromeframe">Вы используете устаревший браузер. Для включения всех возможностей данного сайта необходимо обновить браузер.
  <a href="http://browsehappy.com/">Обновите свой браузер сейчас</a>или
  <a href="http://www.google.com/chromeframe/?redirect=true">установите расширение Google Chrome Frame</a>для просмотра этого сайта.</p>
<![endif]-->

	<NOSCRIPT >
		<br><br>
		<hfooter style="color: #d64d5c; margin-left: 200px;">Внимание! Для полноценной работы сайта, вам нужен браузер с поддержкой JavaScript!</hfooter>
	</NOSCRIPT>

	<!--Голова конец-->