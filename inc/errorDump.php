<?php
				/**
					* Created by JetBrains PhpStorm.
					* User: Jurii
					* Date: 20.09.13
					* Time: 0:23
					* To change this template use File | Settings | File Templates.
					*/

       include_once(__DIR__.'/../classes/simplehtmldom_1_5/simple_html_dom.php');
				/** -----------------------------------------------------------------------------------*/
				$odebug           = debugger_errorClass::getInstance('RU');
				$odebugCSS        = 'default'; // set the CSS
				$odebugCSSLOG     = 'default_log';
				$odebug->HTML     = 'default'; // set the HTML template
				$odebug->HTMLLOG  = 'default_log';
				$odebug->ERROR    = false; // ������� ����������� �� odebugger_class
				$odebug->LOGFILE  = false;
				$odebug->REALTIME = true; // true - �������� ������ �� �����*/
				$odebug->log_File = "_error_log.xml"; // ��� log �����
				// error mail options
				$odebug->mail_Period  = 555; // Minimal period for sending an error message (in minutes)
				$odebug->from_Addr    = "webmaster@aleks.od.ua";
				$odebug->from_Name    = $_SERVER['HTTP_HOST'];
			  $odebug->to_Addr      = "robot@aleks.od.ua";
//        $odebug->to_Addr      = "aleksjurii@gmail.com";
				$odebug->log_Max_Size = 200; //Max size of a log before it will sended and cleared (in kb)
				// $odebug -> checkCode ('./classes/debugger/test.php'); // �������� ����
/** -----------------------------------------------------------------------------------*/
/**  ����� ��� �������� Error_Processor */
/** PHP set_error_handler TEST */
//  IMAGINE_CONSTANT;
// IMAGINE_CONSTANT2; IMAGINE_CONSTANT3; IMAGINE_CONSTANT4;
/** PHP set_exception_handler TEST */
// trigger_error ('��������� ������������', E_USER_WARNING);
// throw new RuntimeException( 'Test RuntimeException' );
/** PHP register_shutdown_function TEST ( IF YOU WANT TEST THIS, DELETE PREVIOUS LINE ) */
// _TEST_FATAL_ERROR_();
