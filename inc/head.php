<?php
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		header('Content-type: text/html; charset=windows-1251');
		header("X-Frame-Options: SAMEORIGIN");
		if (!defined('DUMP_R')) {
				define('DUMP_R', true);
		} // ������ ������ ������ � DUMP_R ( true - ���������� )
		if (!defined('Debug_HC')) {
				define('Debug_HC', false);
		} // ������ ������ ������ � Debug_HackerConsole_Main ( true - ���������� )
		require_once (__DIR__.'/config.php');
		require_once (__DIR__.'/func.php');
		// seo
		require_once (__DIR__.'/title.php');


		// ��������� �������� ������������� ������� ��� �������
		$registry = new Registry();
		// ��������� ������
		$error_processor = Error_Processor::getInstance();
		$session = check_Session::getInstance();
		/**
		 *  ����� ��� �������� Error_Processor
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

		// �����
		$cryptinstall = '/classes/dsp/cryptographp.fct.php';
		require_once  (__DIR__.'/../classes/dsp/cryptographp.fct.php');

		// ������ css � js
		//Initialize the class with image encoding, gzip, a timer, and use the google closure API
		/*$vars = array(
				'encode' => true,
				'timer'  => true,
				'gzip'   => true
		);
		$min = new minifier_jsCss($vars);*/
		$include_CSS = array(
				// ������ �����
				'css/dynamic-to-top.css',
				'css/bootstrap.css',
				'css/lightbox.css',
				'css/animate.css',
				'css/bootstrap-modal.css',
				// ���������
				'js/jsmessage/codebase/themes/message_default.css',
				// ���������
				'js/humane/themes/jackedup.css',
				//		  'js/humane/themes/libnotify.css',
				//		  'js/humane/themes/bigbox.css',
				//		  'css/main.css',
				'js/visLightBox/data/vlboxCustom.css',
				'js/visLightBox/data/visuallightbox.css',
				'js/prettyPhoto/css/prettyPhoto.css',
				'js/badger/badger.css'
		);


		$include_Js = array(
				'js/jquery-1.10.2.min.js',
				'js/jquery.lazyload.js',
				'js/bootstrap.min.js',
				'js/bootstrap-modalmanager.js',
				'js/bootstrap-modal.js',
				//	  <!--���������-->
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

		// ������������
		try {
				require_once (__DIR__.'/../lib/Twig/Autoloader.php');
				Twig_Autoloader::register();
				if (isset($gb) && $gb == '/gb') {
						$templates = '../templates';
				} elseif ($_SERVER['PHP_SELF'] == '/core/users/page.php') {
						$templates = '../../templates';
				} else {
						$templates = 'templates';
				}
				$loader = new Twig_Loader_Filesystem($templates);
				$twig   = new Twig_Environment($loader, array(
													'cache'       => 'cache',
													'charset'     => 'windows-1251',
													'auto_reload' => true
												));
				// �������������� ������� ��� twig - ������ css � js
				function merge_twig($a, $b, $c, $e, $f) {

						$vars = array(
								'encode' => true,
								'timer'  => true,
								'gzip'   => true
						);
						$min  = new minifier_jsCss($vars);

						return $min->merge($a, $b, $c, $e, $f);
				}

				$twig->addFunction('merge_files', new Twig_Function_Function('merge_twig'));

		}
		catch (Exception $e) {
				if (DUMP_R) {
						dump_r($e->getMessage());
				}
		}

		$user_balans         =
				$db->query('select balans from users where id = ?i', array($session->get('userid')), 'el');
		$_SESSION['userVer'] = ($session->has('userVer')) ? $session->get('userVer') : genpass(10, 2);
		$_SESSION['accVer']  = ($session->has('accVer')) ? $session->get('accVer') : genpass(10, 2);
		// $value ��� �������� ����
		$value = $_SERVER['PHP_SELF'];
		if ($_SERVER['PHP_SELF'] == '/fotobanck_adw.php') {
				$value = '/fotobanck_adw.php?unchenge_cat';
		}
		flush();
// <!-- ������ ����� -->