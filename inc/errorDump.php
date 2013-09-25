<?php
				/**
					* Created by JetBrains PhpStorm.
					* User: Jurii
					* Date: 20.09.13
					* Time: 0:23
					* To change this template use File | Settings | File Templates.
					*/
				/** -----------------------------------------------------------------------------------*/
				$odebug           = debugger_errorClass::getInstance('RU');
				$odebugCSS        = 'default'; // set the CSS
				$odebugCSSLOG     = 'default_log';
				$odebug->HTML     = 'default'; // set the HTML template
				$odebug->HTMLLOG  = 'default_log';
				$odebug->ERROR    = true; // хандлер переключить на odebugger_class
				$odebug->LOGFILE  = true;
				$odebug->REALTIME = true; // true - выводить ошибки на экран*/
				$odebug->log_File = "_error_log.xml"; // имя log файла
				// error mail options
				$odebug->mail_Period  = 5; // Minimal period for sending an error message (in minutes)
				$odebug->from_Addr    = "robot@aleks.od.ua";
				$odebug->from_Name    = $_SERVER['HTTP_HOST'];
				$odebug->to_Addr      = "aleksjurii@gmail.com";
				$odebug->log_Max_Size = 150; //Max size of a log before it will sended and cleared (in kb)
				// $odebug -> checkCode ('./classes/debugger/test.php'); // проверка кода
				/** -----------------------------------------------------------------------------------*/
				$session = check_Session::getInstance();
				/** -----------------------------------------------------------------------------------*/
				// запрет показа ошибок в DUMP_R ( true - показавать )
				$session->set('DUMP_R', true);
				// запрет показа ошибок в Debug_HackerConsole_Main ( true - показавать )
				$session->set('Debug_HC', false);
/** -----------------------------------------------------------------------------------*/
/**  Тесты для проверки Error_Processor */
/** PHP set_error_handler TEST */
		IMAGINE_CONSTANT;
/** PHP set_exception_handler TEST */
//  trigger_error ('Сообщение пользователя', E_USER_WARNING);
//	 throw new Exception( 'Imagine Exception' );
/** PHP register_shutdown_function TEST ( IF YOU WANT TEST THIS, DELETE PREVIOUS LINE ) */
//_TEST_FATAL_ERROR_();