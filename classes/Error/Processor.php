<?php

       use Framework\Core\Mail\Sender;


			 require_once __DIR__.'/../../alex/fotobank/Framework/Boot/config.php';

			 if (check_Session::getInstance()->has('Debug_HC')) {
							$Debug_HackerConsole_Main = Debug_HackerConsole_Main::getInstance(true);
			 }

			 // �������� ������ �������
//			 	if (function_exists('debugHC'))  debugHC("test");
			 /**
				* Class Error_Processor
				*/
			 class Error_Processor {

							var $EP_tmpl_err_item = '<br><br>[ERR_MSG]'; // Error messages template: one item of list of a messages
							var $EP_log_fullname; // Path and filename of error log
							var $EP_mail_period = 5; // Minimal period for sending an error message (in minutes)
							var $EP_from_addr = "webmaster@aleks.od.ua";
							var $EP_from_name = "������ � ��������";
							var $EP_to_addr = "aleksjurii@gmail.com";
							var $EP_log_max_size = 500; // Max size of a log before it will sended and cleared (in kb)
							var $event_log_fullname; // Path and filename of event log
							static private $instance = NULL;
							var $err_led; // ��������� �� ������ ��� ������ �� �����
							var $err_list = array();
							var $err_name; // ��� ������ ��� ��������� ������
							/**
							 * function Singleton
							 * �������� ������� � ������������ ����������
							 *
							 * @return Error_Processor|null
							 *
							 */
							static function getInstance() {

										 if (self::$instance == NULL) {
														self::$instance = new Error_Processor();
										 }

										 return self::$instance;
							}


							/**
							 *   __construct()
							 */
							protected function __construct() {

										 set_error_handler(array('Error_Processor', 'userErrorHandler'));
										 set_exception_handler(array('Error_Processor', 'captureException'));
										 register_shutdown_function(array('Error_Processor', 'captureShutdown'));
										 $this->event_log_fullname = $_SERVER['DOCUMENT_ROOT'].'/log/events.log'; // Path and filename of error log
										 $this->EP_log_fullname    = $_SERVER['DOCUMENT_ROOT'].'/log/errors.log'; // Path and filename of event log
							}


							function __destruct() {

							}


							/**
							 *  __clone()
							 */
							protected function __clone() {
							}


							/**
							 *  __wakeup()
							 */
							protected function __wakeup() { }


							/**
							 * ���������� ������
							 * @todo ������������ ������������� ������� ��������� ������
							 */
							public static function userErrorHandler($errno, $errmsg, $filename, $linenum,
																											$vars = array()) //    function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
							{

										 if (error_reporting() & $errno) {
														/**
														 * �������� ������������ ������ (����� ������� ����������� �� ���������� ������)
														 */
														ob_start();
														/**
														 * timestamp ��� ����� ������
														 */
														$dt = date("Y-m-d H:i:s (T)");
														/**
														 * ���������� ������������� ������ ������ ������
														 * � ���������������� ������������ �����, �������
														 * �� ������ ����������� - ��� E_WARNING, E_NOTICE, E_USER_ERROR,
														 * E_USER_WARNING � E_USER_NOTICE
														 * ���� ������ �������� � ����� (��� ������������� ��������� "@" error_reporting() ������ 0)
														 */
														$errortype = array(
																	 E_ERROR             => 'E_ERROR (��������� ������)',
																	 E_WARNING           => 'E_WARNING (��������������) ',
																	 E_PARSE             => 'E_PARSE',
																	 E_NOTICE            => 'E_NOTICE (�����������) ',
																	 E_CORE_ERROR        => 'E_CORE_ERROR',
																	 E_CORE_WARNING      => 'E_CORE_WARNING',
																	 E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
																	 E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
																	 E_USER_ERROR        => 'E_USER_ERROR',
																	 E_USER_WARNING      => 'E_USER_WARNING',
																	 E_USER_NOTICE       => 'E_USER_NOTICE',
																	 E_STRICT            => 'E_STRICT',
																	 E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
																	 E_DEPRECATED        => 'E_DEPRECATED',
																	 E_USER_DEPRECATED   => 'E_USER_DEPRECATED',
														);
														// ����� ������, �� ������� ���������� ���� ����� ��������
														$user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
														$err         = "<CATCHABLE ERRORS>\n";
														$err .= "\t ��� ������:       ".$errortype[$errno]."\n";
														$err .= "\t ���������:        ".$errmsg."\n";
														$err .= "\t ����� ������:     ".$errno."\n";
														$err .= "\t ���� �������:     ".$filename."\n";
														$err .= "\t ��������:         ".$_SERVER['REQUEST_URI']."\n";
														$err .= "\t ����� ������:     ".$linenum."\n";
														$err .= "\t ����:             ".$dt."\n";
														$err .= "\t Ip ������������:  ".Get_IP()."\n";
														$err .= "\t �������:          ".$_SERVER['HTTP_USER_AGENT']."\n";
														if (in_array($errno, $user_errors)) {
																	 $err .= "\t ����������� ������:".wddx_serialize_value($vars, "Variables")."\n";
														}
														$err .= "</CATCHABLE ERRORS>\n\n";
														/**
														 * C�������� � ���� ����������� ������, � ������� ��� �� ����������� �����,
														 * ���� ���� ����������� ���������������� ������
														 */
														/*error_log($err, 3, "errors.log");
														if (filesize("error.log") > 500 * 1024)
														{
															$fp = fopen("error.log", 'a'); //��������� ���� � ������ ������
															ftruncate($fp, 0); // ������� ����
															fclose ($fp);
														}*/
														$err_led = "$errortype[$errno][$errno] $errmsg ($filename �� $linenum ������)";
														/**
														 * @ �������� ������ �  ��� ���� � email
														 */
														ob_end_clean();
														self::__err_proc($err, 'l', $err_led, $errortype[$errno], '������');
										 }

										 return true;
							}



							/**
							 * EXTENSIONS ERRORS
							 */
							public static function captureException($exception) {

										 $dt  = date("Y-m-d H:i:s (T)");
										 $err = "����: ".$dt."\n";
										 //	$err =  "<EXTENSIONS ERROR> \n";
										 // ������� ��� ��������� ������ � �����
										 //		preg_replace('(.*?)', '', func_get_args($exception));
										 $err .= $exception;
										 //	ob_start();
										 //	print_r($exception);
										 // ������� �����
										 //	$err .= ob_get_clean();
										 //	$err .= "\t ��������:        ".$_SERVER['REQUEST_URI']."\n";
										 //	$err .= "\t Ip ������������: ".Get_IP()."\n";
										 //	$err .= "\t �������:         ".$_SERVER['HTTP_USER_AGENT']."\n";
										 //	$err .=  "</EXTENSIONS ERROR>";
										 self::__err_proc($err, 'lm', $err, 'EXTENSIONS ERROR', '������');

										 return true;
							}



							/**
							 * ������� ��������� ��������� ������
							 * UNCATCHABLE ERRORS
							 */
							public static function captureShutdown() {

										 $error = error_get_last();
										 $dt    = date("Y-m-d H:i:s (T)");
										 if ($error) {
														## IF YOU WANT TO CLEAR ALL BUFFER, UNCOMMENT NEXT LINE:
														//  ob_end_clean();
														// Display content $error variable
														$err_led = "<FATAL ERROR> \n";
														$err_led .= "\t ��������: ".$_SERVER['REQUEST_URI']."\n";
														$err = "<FATAL ERROR> \n";
														foreach ($error as $key => $value) {
																	 //				echo "<b>$key:</b> $value \n";
																	 $err_led .= "\t $key: $value \n";
																	 $err .= "\t $key:\t \t $value \n";
														}
														$err_led .= "</FATAL ERROR> \n \n";
														$err .= "\t ��������:        ".$_SERVER['REQUEST_URI']."\n";
														$err .= "\t ����:            ".$dt."\n";
														$err .= "\t Ip ������������: ".Get_IP()."\n";
														$err .= "\t �������:         ".$_SERVER['HTTP_USER_AGENT']."\n";
														$err .= "</FATAL ERROR> \n";
														self::__err_proc($err, 'lm', $err_led, 'E_ERROR (��������� ������)', '������');
										 }

										 return true;
							}


							/**
							 * @param $err
							 * @param $actions
							 * @param $err_led
							 * @param $errno
							 * @param $error_name
							 */
							static function __err_proc($err, $actions, $err_led, $errno = '', $error_name) {

										 $error_processor           = Error_Processor::getInstance();
										 $error_processor->err_name = $errno;
										 $error_processor->err_proc($err, $actions, $err_led);
										 if (check_Session::getInstance()->has('DUMP_R')) {
														dump_r($err_led);
										 }
										 if (function_exists('debugHC')) {
														debugHC($err_led, $error_name);
										 }
							}


							/**
							 * ��������� ������
							 *
							 * @param        $err_msg
							 * @param string $actions
							 * @param string $err_led
							 *
							 * $actions - ���������� String � ����������: '' - ���������� ������ � ������ ������,
							 * 'w' - ������������� ����� ��������� �� ������ �� �����,
							 * '�' - ������������� ������� ������ ���� ��������� �� �����,
							 * "d" - ������������� ������� ���� ������,
							 * 's' - ������������� ���������� ����������,
							 * 'l' - ������������� ����� log,
							 * 'm' - ������������� ���������� �� ����������� ����� (�������� ����� ���� ����������, ��������: 'ws')
							 * $err_file, $err_line - ��� ����� � ������ � �������
							 *
							 */
							function err_proc($err_msg, $actions = '', $err_led) {

										 $this->log_send(0);
										 // Adding in list of errors
										 $this->err_list[] = $err_msg;
										 $this->err_led .= $err_led; // ��������� �� ������ ��� ������ �� �����
										 /**
											* Writing log
											*/
										 if (substr_count($actions, 'l')) {
														@touch($this->EP_log_fullname);
														@chmod($this->EP_log_fullname, 0777);
														error_log($err_msg, 3, $this->EP_log_fullname);
										 }
										 /**
											*  Sending mail
											*/
										 if (substr_count($actions, 'm')) {
														// ������ ������ ��� aleks.od.ua
														if ($_SERVER['HTTP_HOST'] == stristr(mb_substr(get_domain(), 0, -1), "al")) {
																	 // Check, that messages not send too often
																	 $log_file  = $this->EP_log_fullname;
																	 $dump      = @file($log_file);
																	 $too_often = false;
																	 for ($I = count($dump) - 17; $I > 0; $I--) {
																					$str = rtrim($dump[$I]);
																					//        $test = substr($str,-25,-6);
																					if (($timestamp = strtotime(substr($str, 19, -6))) !== false) {
																								 //          $test1 = strtotime(substr($str,-25,-6));
																								 //          $test2 = strtotime("-".$this->EP_mail_period." minutes");
																								 //			   $test3 =  $test1 -  $test2;
																								 if (strtotime(substr($str, -25, -6)) > strtotime("-".$this->EP_mail_period." minutes")) {
																												$too_often = true;
																												break;
																								 } else {
																												break;
																								 }
																					}
																	 }
																	 if ($too_often == false) //						if ($too_often)
																	 {
																					$_HTTP_REF = isset($_SERVER['HTTP_REFERER']) ? "<b>\$HTTP_REFERER:</b> ".$_SERVER['HTTP_REFERER']."<br>" : '';
																					$mail_mes  = "
																											 <u><b>Error:</b></u><br> $err_msg<br>
																											 <b>\$SERVER_NAME</b> = ".$_SERVER['SERVER_NAME']."<br>
																														.$_HTTP_REF.
																											 <b>\$REQUEST_METHOD:</b> ".$_SERVER['REQUEST_METHOD']."<br>
																											 <b>\$HTTP_ACCEPT_LANGUAGE:</b> ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."<br>
																											 <b>Cookie:</b><br>";
																					foreach ($_COOKIE as $I => $val) {
																								 $mail_mes .= $I.'='.$val."<br>";
																					}
																					$mail_mes .= "<b> Variables (GET):</b><br> ";
																					while (list($I, $val) = each($_GET)) {
																								 $mail_mes .= " $I=$val<br>";
																					}
																					$mail_mes .= "<b> Variables (POST):</b><br> ";
																					while (list($I, $val) = each($_POST)) {
																								 $mail_mes .= " $I=$val<br>";
																					}
																					$mail            = new Sender();
																					$mail->from_addr = $this->EP_from_addr;
																					$mail->from_name = $this->EP_from_name;
																					$mail->to        = $this->EP_to_addr;
																					$mail->subj      = "��������� ������: $this->err_name";
																					$mail->body_type = 'text/html';
																					$mail->body      = $mail_mes;
																					$mail->priority  = 1;
																					$mail->prepare_letter();
																					$mail->send_letter();

																	 }
														}

														if (substr_count($actions, 'w')) {
																	 echo $this->err_led;
														}
														if (substr_count($actions, 'a')) {
																	 echo $this->err_write();
														}
														if (substr_count($actions, 'd')) {
																	 unset($this->err_list);
														}
														if (substr_count($actions, 's')) {
																	 die();
														}
										 }
							}


							/**
							 *  Return HTML-block with list of an error messages
							 *
							 * @return bool|string
							 */
							function err_write() {

										 $messages = '';
										 if (is_array($this->err_list)) {
														foreach ($this->err_list as $err_msg) {
																	 $messages .= str_replace('[ERR_MSG]', $err_msg, $this->EP_tmpl_err_item);
														}
										 }
										 if ($messages != '') {
														return $messages;
										 } else {
														return false;
										 }
							}


							/**
							 * Sends a log to administrator by e-mail and clears a log
							 *
							 * @param int $type
							 *  $type: 0 - errors, 1 - events
							 */
							function log_send($type = 0) {

										 if ($type == 0) {
														$title    = 'Report of errors log';
														$log_file = $this->EP_log_fullname;
										 } else {
														$title    = 'Report of events log';
														$log_file = $this->event_log_fullname;
										 }
										 if (!file_exists($log_file)) {
														$fh = fopen($log_file, "w+");
														fclose($fh);
										 }
										 $dump = file($log_file);
										 if ($dump && filesize($log_file) > $this->EP_log_max_size * 1024) {
														$mail_mes = '<html><body>
	                            <h1>'.$title.'</h1>';
														$dump     = array_reverse($dump, false);
														foreach ($dump as $val) {
																	 $mail_mes .= trim($val).'<br>';
														}
														$mail_mes .= ' <p>
											This letter was created and a log on server was cleared at '.date('Y-m-d').'.
											<br>
											This message was sent automatically by robot, please don\'t reply!
											</p>
											</body></html>';
														$mail            = new Sender;
														$mail->from_addr = $this->EP_from_addr;
														$mail->from_name = $this->EP_from_name;
														$mail->to        = $this->EP_to_addr;
														$mail->subj      = $title;
														$mail->body_type = 'text/html';
														$mail->body      = $mail_mes;
														$mail->priority  = 3;
														$mail->prepare_letter();
														$mail->send_letter();
														unlink($log_file);
										 }
							}


							/**
							 * Log an event into log
							 *
							 * @param $message
							 * @param $user_id
							 */
							function log_evuent($message, $user_id) {

										 @touch($this->event_log_fullname);
										 @chmod($this->event_log_fullname, 0777);
										 error_log(str_replace(array("\n", "\r"), ' ', $message)."\t".$_SERVER['REQUEST_URI'].
															 "\t$user_id\t".date('r')."\t".Get_IP()."\n", 3, $this->event_log_fullname);
										 $this->log_send(1);
							}
			 }

			 // �������
			 /*function distance($vect1, $vect2)
			{
				if (!is_array($vect1) || !is_array($vect2)) {
					trigger_error("Incorrect parameters, arrays expected", E_USER_ERROR);
					return NULL;
				}

				if (count($vect1) != count($vect2)) {
					trigger_error("Vectors need to be of the same size", E_USER_ERROR);
					return NULL;
				}

				for ($i=0; $i<count($vect1); $i++) {
					$c1 = $vect1[$i]; $c2 = $vect2[$i];
					$d = 0.0;
					if (!is_numeric($c1)) {
						trigger_error("Coordinate $i in vector 1 is not a number, using zero",
							E_USER_WARNING);
						$c1 = 0.0;
					}
					if (!is_numeric($c2)) {
						trigger_error("Coordinate $i in vector 2 is not a number, using zero",
							E_USER_WARNING);
						$c2 = 0.0;
					}
					$d += $c2*$c2 - $c1*$c1;
				}
				return sqrt($d);
			}*/
			 // undefined constant, generates a warning
			 // $t = NOT_DEFINED;
			 // define some "vectors"
			 //$a = array(2, 3, "foo");
			 //$b = array(5.5, 4.3, -1.6);
			 //$c = array(1, -3);
			 // generate a user error
			 //$t1 = distance($c, $b) . "\n";
			 // generate another user error
			 //$t2 = distance($b, "i am not an array") . "\n";
			 // generate a warning
			 //$t3 = distance($a, $b) . "\n";
?>
