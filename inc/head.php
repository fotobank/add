<?php
	//		 error_reporting(E_ALL);
			 ini_set('display_errors', 0);
				/** -----------------------------------------------------------------------------------*/
			 header('Content-type: text/html; charset=windows-1251');
			 header("X-Frame-Options: SAMEORIGIN");
				/** -----------------------------------------------------------------------------------*/
			 require_once (__DIR__.'/config.php');
			 require_once (__DIR__.'/func.php');
				/** -----------------------------------------------------------------------------------*/
			 // seo
			 require_once (__DIR__.'/title.php');
				/** -----------------------------------------------------------------------------------*/
			 // обработка ошибок
		//	 $error_processor = Error_Processor::getInstance();
				/** -----------------------------------------------------------------------------------*/
				$odebug = odebugger_class::getInstance('RU');
				$odebug -> CSS = 'default'; // set the CSS
				$odebug -> HTML = 'default'; // set the HTML template
//				$odebug -> REALTIME = false; // не выводить ошибки на экран
//				$odebug -> printError();
//				$odebug -> showLog();
//				$odebug -> showAll();
				/** -----------------------------------------------------------------------------------*/
			 $session         = check_Session::getInstance();
				/** -----------------------------------------------------------------------------------*/
			 // запрет показа ошибок в DUMP_R ( true - показавать )
			 $session->set('DUMP_R', true);
			 // запрет показа ошибок в Debug_HackerConsole_Main ( true - показавать )
			 $session->set('Debug_HC', true);
			 /** -----------------------------------------------------------------------------------*/
				/**  Тесты для проверки Error_Processor
				* PHP set_error_handler TEST
				*/
			  IMAGINE_CONSTANT;
			 /**
				* PHP set_exception_handler TEST
				*/
				//trigger_error ('La variable ', E_USER_WARNING);
		  //	throw new Exception( 'Imagine Exception' );
			 /**
				* PHP register_shutdown_function TEST ( IF YOU WANT TEST THIS, DELETE PREVIOUS LINE )
				*/
			 //  imagine_function();
				/** ----------------------------------------------------------------------------------*/
			 // капча
			 $cryptinstall = '/classes/dsp/cryptographp.fct.php';
			 require_once  (__DIR__.'/../classes/dsp/cryptographp.fct.php');
				/** ----------------------------------------------------------------------------------*/
			 $include_CSS = array(
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

			 $include_Js    = array(
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
				/** ----------------------------------------------------------------------------------*/
			 try {
							require_once (__DIR__.'/../lib/Twig/Autoloader.php');
							Twig_Autoloader::register();
							$loadTwig = new loadTwig();
//					require_once ('plugins_Twig.php');

			 }
			 catch (Exception $e) {
							if (check_Session::getInstance()->has('DUMP_R')) {
										 dump_r($e->getMessage());
							}
			 }
				/** ----------------------------------------------------------------------------------*/
			 $user_balans         = $db->query('select balans from users where id = ?i', array($session->get('userid')), 'el');
			 $_SESSION['userVer'] = ($session->has('userVer')) ? $session->get('userVer') : genpass(10, 2);
			 $_SESSION['accVer']  = ($session->has('accVer')) ? $session->get('accVer') : genpass(10, 2);
			 // $razdel для фиксации главного меню
			 $razdel = $_SERVER['PHP_SELF'];
			 if ($_SERVER['PHP_SELF'] == '/fotobanck_adw.php') {
							$razdel = '/fotobanck_adw.php?unchenge_cat';
			 }

						$printErr = $session->get('err_msg').$session->get('ok_msg').$session->get('ok_msg2');

						if (!empty($error))
									{
												$printErr .= $error;
									}

			 $renderData = array(
							// SEO в top
							'title'             => $title,
							'description'       => $description,
							'keywords'          => $keywords,
							// инициализация
							'logged'            => $session->has('logged'),
							'us_name'           => $session->get('us_name'),
							'user_balans'       => $user_balans,
							'accVer'            => $session->get('accVer'),
							'userVer'           => $session->get('userVer'),
							// $value - для выбора меню
							'razdel'            => $razdel,
							// сжатие js и css в top
							'include_Js'        => $include_Js,
							'prioritize_Js'     => $prioritize_Js,
							'include_CSS'       => $include_CSS,
							// сжатие js в footer для кнопки наверх
							'include_Js_footer' => array('js/jquery.easing.1.3.js', 'js/dynamic.to.top.dev.js'),
							// проверка в футере для pivic и запуск только для aleks.od.ua
							'SERVER_NAME'       => $_SERVER['SERVER_NAME'],
							// системные сообщения
							'printMsg'										=>	new printMsg(),
							'odebug'												=> $odebug
			 );
// <!-- Голова конец -->