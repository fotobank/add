<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 20.09.13
 * Time: 0:23
 * To change this template use File | Settings | File Templates.
 */

				//		  $error_processor = Error_Processor::getInstance();
				/** -----------------------------------------------------------------------------------*/
				$odebug = odebugger_class::getInstance('RU');
				$odebugCSS = 'default'; // set the CSS
				$odebugCSSLOG = 'default_log';
				$odebug -> HTML = 'default'; // set the HTML template
				$odebug -> HTMLLOG = 'default_log';
				$odebug -> ERROR = true;  // ������� ����������� �� odebugger_class
				$odebug -> LOGFILE = true;
				$odebug -> REALTIME = true; // true - �������� ������ �� �����*/
				$odebug -> log_File = "_error_log.xml"; // ��� log �����
    // error mail options
				$odebug -> mail_Period = 5; // Minimal period for sending an error message (in minutes)
				$odebug -> from_Addr = "webmaster@aleks.od.ua";
				$odebug -> from_Name = "������ � ��������";
				$odebug -> to_Addr = "aleksjurii@gmail.com";
				$odebug -> log_Max_Size = 500; //Max size of a log before it will sended and cleared (in kb)

				// $odebug -> checkCode ('./classes/odebugger/test.php'); // �������� ����
				/** -----------------------------------------------------------------------------------*/
				$session = check_Session::getInstance();
				/** -----------------------------------------------------------------------------------*/
				// ������ ������ ������ � DUMP_R ( true - ���������� )
				$session->set('DUMP_R', true);
				// ������ ������ ������ � Debug_HackerConsole_Main ( true - ���������� )
				$session->set('Debug_HC', false);
				/** -----------------------------------------------------------------------------------*/
				/**  ����� ��� �������� Error_Processor */
				/** PHP set_error_handler TEST */
				//		IMAGINE_CONSTANT;
				/** PHP set_exception_handler TEST	*/
				 // trigger_error ('��������� ������������', E_USER_WARNING);
					// throw new Exception( 'Imagine Exception' );
				/** PHP register_shutdown_function TEST ( IF YOU WANT TEST THIS, DELETE PREVIOUS LINE ) */
				 //_TEST_FATAL_ERROR_();