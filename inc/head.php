<?
  // удаление волшебных кавычек
 //  if (get_magic_quotes_gpc()) {
	 $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	 while (list($key, $val) = each($process)) {
		foreach ($val as $k => $v) {
		  unset($process[$key][$k]);
		  if (is_array($v)) {
			 $process[$key][stripslashes($k)] = $v;
			 $process[] = &$process[$key][stripslashes($k)];
		  } else {
			 $process[$key][stripslashes($k)] = stripslashes($v);
		  }
		}
	 }
	 unset($process);
//   }


  require (__DIR__.'/../core/dump/dump_r.php');
   require_once (__DIR__.'/config.php');
   require_once (__DIR__.'/func.php');
   require_once (__DIR__.'/../core/checkSession/checkSession.php');
// require_once (__DIR__.'/phpIni.php');
//	error_reporting(E_ALL);
	ini_set('display_errors', 0);
 	error_reporting(0);
   header('Content-type: text/html; charset=windows-1251');
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
		if ($session->get('us_name') == 'test')
		  {
			 include_once (__DIR__.'/../core/Debug_HackerConsole/lib/config.php');
		    require_once (__DIR__.'/../core/Debug_HackerConsole/lib/Debug/HackerConsole/Main.php');
			 $Debug_HackerConsole_Main = Debug_HackerConsole_Main::getInstance(true);

			/* $time  = microtime();
			 $time  = explode(' ', $time);
			 $time  = $time[1] + $time[0];
			 $startTime = $time;
			 $startMem = intval(memory_get_usage() / 1024);*/ //Используемая память в начале
		  }

		function debugHC($v, $group="message")
		{
		  if (is_callable($f=array('Debug_HackerConsole_Main', 'out')))
			 {
				call_user_func($f, $v, $group);
			 }
		}
		//	debugHC("test");

		// обработка ошибок
		 require_once (__DIR__.'/lib_mail.php');
		 require_once (__DIR__.'/lib_ouf.php');
		 require_once (__DIR__.'/lib_errors.php');
		 $error_processor = Error_Processor::getInstance();
		 $session = checkSession::getInstance();
		/**
		 *  Тесты для проверки Error_Processor
		 * PHP set_error_handler TEST
		 */
 	 //   IMAGINE_CONSTANT;
		/**
		 * PHP set_exception_handler TEST
		 */
	//	   throw new Exception( 'Imagine Exception' );
		/**
		 * PHP register_shutdown_function TEST ( IF YOU WANT TEST THIS, DELETE PREVIOUS LINE )
		 */
	//		 	imagine_function( );

		include (__DIR__.'/title.php');
		$cryptinstall = '/inc/captcha/cryptographp.fct.php';
		require_once  (__DIR__.'/captcha/cryptographp.fct.php');

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

		require_once (__DIR__.'/../core/magic-min/class.magic-min.php' );

		//Initialize the class with image encoding, gzip, a timer, and use the google closure API
		$vars = array(
		  'encode' => true,
		  'timer' => true,
		  'gzip' => true
		);
		$min = new Minifier( $vars );

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
//		$min->logs();

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
	<table class="tb_head">
		<tr>
			<td>
				<div class="td_head_logo">
				<?  require_once (__DIR__.'/flash.php'); ?>
					<a class="logo" href="/index.php"></a>
					<div id="zagol">
						<h1>
							 <span class="letter1">Профессиональная
						<div style="padding-top: 10px; padding-bottom: 10px;">	Фото и Видеосъёмка</div>
				          в Одессе</span>
						</h1>
					</div>
				</div>
			</td>
			<td class="td_form_ent">

				<div id="form_ent">

					<? if ($session->has('logged')): ?>
						<div style="text-align: center;">
  <span style="color:#bb5"><span style="font-size: 14px">Здравствуйте,</span><br> <span style="font-weight: bold;"><?=$session->get('us_name')?></span><br/>
	  <?
	  $user_balans = $db->query('select balans from users where id = ?i',array($session->get('userid')),'el');
	  $_SESSION['userVer'] = ($session->has('userVer'))?$session->get('userVer'):genpass(10, 2);
	  $_SESSION['accVer'] = ($session->has('accVer'))?$session->get('accVer'):genpass(10, 2);

	  ?>
	  <span style="font-size: 12px;"> Ваш баланс: </span>
	  <span id="balans" style="font-weight: bold;"><?=$user_balans?></span> гр.<br/></span></div>

						<div style="margin-top: 8px;">
						  <a class="korzina" style="position: absolute; top: 62px; width: 52px;" href="/basket.php">корзина</a>
						  <a class="vihod" style="position: absolute; top: 62px; left: 80px;" href="/enter.php?logout=1">выход</a>
						</div>
						<div style="margin-top: 8px;">
						  <a class="scet" style="position: absolute; width: 30px; top: 88px;" data-target="#" data-toggle="order" href="<?='/security.php?acc='.$session->get('accVer')?>">счет</a>
						  <a class="user" href="<?='/security.php?user='.$session->get('userVer')?>" style="position: absolute; width: 88px; left: 48px; top: 88px;">пользователь</a>

						</div>

					<? else: ?>
						<span>Форма входа:</span><br>
						<form action="/enter.php" method="post">
							<table>
								<tr>
									<td> Логин:</td>
									<td><label><input class="inp_fent" name="login"> </label></td>
								</tr>
								<tr>
									<td> Пароль:</td>
									<td><label> <input class="inp_fent" type="password" name="password"> </label></td>
								</tr>
								<tr></tr>
								<tr>
									<td>
										<input data-placement="left" rel="tooltip" class="vhod" name="submit" type="submit" value="вход" title="Добро пожаловать!"
											data-original-title="Добро пожаловать!">
									</td>
									<td>
										<a href="/registr.php" class="registracia" data-placement="right" data-original-title="Вы еще не зарегистрировались? Присоединяйтесь">регистрация</a>
									</td>
								</tr>
							</table>
							<a href="/reminder.php" style="color: #fff; text-decoration: none;" data-target="#" data-toggle="modal" data-placement="right" data-original-title="Восстановление пароля">Забыли пароль?</a>
						</form>
					<? endif; ?>
				</div>
			</td>
		<tr>
			<td></td>
			<td>
	</table>

	<?

	// <!-- СООБЩЕНИЕ ОБ ОШИБКЕ-->


	if (!empty($error))
	  {
		 ?>
		 <script type='text/javascript'>
			dhtmlx.message.expire = 6000; // время жизни сообщения
			dhtmlx.message({ type: 'error', text: 'Ошибка!<br><?=$error?>'});
		 </script>
		 <?
		 unset($error);
	  }

	if ($session->has('err_msg') && $session->get('err_msg') != '')
		{
			?>
			<script type='text/javascript'>
				dhtmlx.message.expire = 6000; // время жизни сообщения
				dhtmlx.message({ type: 'error', text: 'Ошибка!<br><?=$session->get('err_msg')?>'});
				<!--			humane.error('Ошибка!<br>--><?//=$session->get('err_msg')?><!--')-->
			</script>
			<?
		  $session->del('err_msg');
		}

	// <!-- СООБЩЕНИЕ О УПЕШНОМ ЗАВЕРШЕНИИ-->

	if ($session->has('ok_msg') && $session->get('ok_msg') != '')
		{
			?>
			<script type='text/javascript'>
				humane.success("Добро пожаловать, <?=$session->get('us_name')?>!<br><span><?=$session->get('ok_msg')?></span>");
			</script>
			<?
		  $session->del('ok_msg');
		}


	if ($session->has('ok_msg2') && $session->get('ok_msg2') != '')
		{
			?>
			<script type='text/javascript'>
					dhtmlx.message.expire = 6000;
					dhtmlx.message({ type: 'warning', text: <?=$session->get('ok_msg2') ?>});
			</script>
			<?
		  $session->del('ok_msg2');
		}
	?>


		  <div id="main_menu">

			<?
			$value = $_SERVER['PHP_SELF'];
			if ($_SERVER['PHP_SELF'] == '/fotobanck_adw.php')
				{
					$value = '/fotobanck_adw.php?unchenge_cat';
				}

			if ($value == '/index.php')
				{
					$act_ln = 'gl_act';
					$key    = 'Главная';
					echo "
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_fb' href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
				}
			elseif ($value == '/fotobanck_adw.php?unchenge_cat')
				{
					$act_ln = 'fb_act';
					$key    = 'Фото-банк';
					echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
				}
			elseif ($value == '/uslugi.php')
				{
					$act_ln = 'usl_act';
					$key    = 'Услуги';
					echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
				}
			elseif ($value == '/ceny.php')
				{
					$act_ln = 'cn_act';
					$key    = 'Цены';
					echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
				}
			elseif ($value == '/kontakty.php')
				{
					$act_ln = 'konty_act';
					$key    = 'Контакты';
					echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
				}
			elseif ($value == '/gb/index.php')
				{
					$act_ln = 'gb_act';
					$key    = 'Гостевая';
					echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a href='$value' class='$act_ln'>$key</a>";
				}
			elseif ($value == '/registr.php' or'/activation.php')
				{
					$act_ln = 'gb_act';
					$key    = 'Гостевая';
					echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck_adw.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
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
<?