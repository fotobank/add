<?php

	/**
	 * Class Error_Processor
	 * Library for processing of errors and events.
	 */
	class Error_Processor
	{

		var $EP_tmpl_err_item = '[ERR_MSG]'; // Error messages template: one item of list of a messages
		var $EP_log_fullname = 'errors.log'; // Path and filename of error log
		var $EP_mail_period = 5; // Minimal period for sending an error message (in minutes)
		var $EP_from_addr;
		var $EP_from_name;
		var $EP_to_addr;
		var $EP_log_max_size = 500; // Max size of a log before it will sended and cleared (in kb)
		var $event_log_fullname = 'events.log'; // Path and filename of event log
		static private $instance = NULL;
      var $error;
		var $err_list = array();


		/**
		 * function Singleton
		 * Создание объекта в единственном экземпляре
		 *
		 * @return Error_Processor|null
		 *
		 */

		static function getInstance()
			{
				if (self::$instance == NULL)
					{
						self::$instance = new Error_Processor();
					}
				return self::$instance;
			}

		/**
		 *   __construct()
 		 */
		protected  function __construct()
			{
				// определяем режим вывода ошибок
				ini_set('display_errors', 'On');

				// определеяем уровень протоколирования ошибок
				error_reporting(E_ALL | E_STRICT);

				set_error_handler(array('Error_Processor', 'userErrorHandler'));
				set_exception_handler(array('Error_Processor', 'captureException'));
				register_shutdown_function(array('Error_Processor', 'captureShutdown'));
			}

		/**
		 *  __clone()
		 */
		protected function __clone()
			{
			}

		/**
		 *  __wakeup()
		 */
		protected function __wakeup()  { }


		/**
		 * Обработчик ошибок
		 * определяемая пользователем функция обработки ошибок
		 */

		public static function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
			//    function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
			{

				if (error_reporting() & $errno)
					{
						/**
						 * включаем буфферизацию вывода (вывод скрипта сохраняется во внутреннем буфере)
						 */
						    ob_start();
						    ob_end_clean();
						/**
						 * timestamp для входа ошибки
						 */
						$dt = date("Y-m-d H:i:s (T)");
						/**
						 * определяем ассоциативный массив строки ошибки
						 * в действительности единственные входы, которые
						 * мы должны рассмотреть - это E_WARNING, E_NOTICE, E_USER_ERROR,
						 * E_USER_WARNING и E_USER_NOTICE
						 * если ошибка попадает в отчет (при использовании оператора "@" error_reporting() вернет 0)
						 */
						$errortype = array(E_ERROR             => 'E_ERROR (Фатальная ошибка)',
						                   E_WARNING           => 'E_WARNING (Предупреждение) ',
						                   E_PARSE             => 'E_PARSE',
						                   E_NOTICE            => 'E_NOTICE (Уведомление) ',
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
						                   E_USER_DEPRECATED   => 'E_USER_DEPRECATED',);
						// выводим свое сообщение об ошибке
						echo "<b>{$errortype[$errno]}</b>[$errno] $errmsg ($filename на $linenum строке)<br />\n";
						// набор ошибок, на которые переменный след будет сохранен
						$user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
						$err         = "<CATCHABLE ERRORS>\n";
						$err .= "\t Тип ошибки:      ".$errortype[$errno]."\n";
						$err .= "\t Сообщение:       ".$errmsg."\n";
						$err .= "\t Номер ошибки:    ".$errno."\n";
						$err .= "\t Файл скрипта:    ".$filename."\n";
						$err .= "\t Номер линии:     ".$linenum."\n";
						$err .= "\t Дата:            ".$dt."\n";
						$err .= "\t Ip пользователя: ".Get_IP()."\n";
						$err .= "\t Браузер:         ".$_SERVER['HTTP_USER_AGENT']."\n";
						if (in_array($errno, $user_errors))
							{
								$err .= "\t Трассировка ошибки:".wddx_serialize_value($vars, "Variables")."\n";
							}
						$err .= "</CATCHABLE ERRORS>\n\n";

						/**
						 * сохранить в файл регистрации ошибок, и послать мне по электронной почте,
						 * если есть критическая пользовательская ошибка
						 */
						//    $this -> log_send(0);

						$error_processor = Error_Processor::getInstance();

					   if (method_exists( $error_processor,'log_send'))
						   {
							   $error_processor->log_send(0);
							  // var_dump($err, $error_processor );
						   }



							// 	$err = $error_processor->log_send();
					// 	error_log($prov, 3, "error.log");

						error_log($err, 3, "error.log");
						if ($errno == E_USER_ERROR)
							{
								mail("aleksjurii@gmail.com.com", "Critical User Error", $err);
							}
					}

				return true;
			}


		/**
		 * EXTENSIONS ERRORS
		 */
		public static function captureException($exception)
			{

				// Display content $exception variable
				echo '<pre>';
				print_r($exception);
				echo '</pre>';
			}

		/**
		 * Функция перехвата фатальных ошибок
		 * UNCATCHABLE ERRORS
		 */

		public static function captureShutdown()
			{

				$error = error_get_last();
				if ($error)
					{
						## IF YOU WANT TO CLEAR ALL BUFFER, UNCOMMENT NEXT LINE:
						//  ob_end_clean();
						// Display content $error variable
						echo '<pre>';
						print_r($error);
						echo '</pre>';

						return false;
					}
				else
					{
						return true;
					}
			}


		/**
		 * Процессор ошибок
		 *
		 * @param        $err_msg
		 * @param string $actions
		 * @param string $err_file
		 * @param string $err_line
		 *
		 * $actions - переменная String с действиями: '' - добавление ошибок в список ошибок,
		 * 'w' - дополнительно пишет сообщение об ошибке на экран, 'а' - дополнительно
		 * выводит список всех сообщений на экран, "d" - дополнительно очищает стек ошибки,
		 * 's' - дополнительно остановить исполнение, 'l' - дополнительно пишет log,
		 * 'm' - дополнительно отправляет по электронной почте (значения могут быть объединены, например: 'ws')
		 * $err_file, $err_line - имя файла и строки с ошибкой (как правило, константы
		 * __FILE__ and __LINE__)
		 *
		 */
		function err_proc($err_msg, $actions = '', $err_file = '', $err_line = '')
			{

				$this->log_send(0);
				// Adding in list of errors
				$this->err_list[] = $err_msg;
				// Writing log
				if (substr_count($actions, 'l'))
					{
						@touch($this->EP_log_fullname);
						@chmod($this->EP_log_fullname, 0777);
						error_log(str_replace(array("\n","\r"), ' ', $err_msg)."\t".$_SERVER['REQUEST_URI']."\t".$_SERVER['HTTP_USER_AGENT'].
							"\t".date('r')."\t".Get_IP()."\n", 3, $this->EP_log_fullname);
					}


				/**
				 *  Sending mail
				 */
				if (substr_count($actions, 'm'))
					{
						// Check, that messages not send too often
						$log_file = $this->EP_log_fullname;
						$dump     = @file($log_file);
						$too_often = false;
						for ($I = count($dump) - 1; $I > 0; $I--)
							{
								$str = explode("\t", $dump[count($dump) - 1]);
								if (strtotime($str[2]) > strtotime("-".$this->EP_mail_period." minutes"))
									{
										$too_often = true;
										break;
									}
							}
						if ($too_often == false)
							{
								$mail_mes = "
										Error: $err_msg\n\n
										File: $err_file\n
										Line: $err_line\n
										Date/time: ".date('r')."\n
										\$SERVER_NAME = ".$_SERVER['SERVER_NAME']."\n
										\$REQUEST_URI: ".$_SERVER['REQUEST_URI']."\n
										\$REMOTE_ADDR: ".$_SERVER['REMOTE_ADDR']."\n
										\$HTTP_USER_AGENT: ".$_SERVER['HTTP_USER_AGENT']."\n
										\$HTTP_REFERER: ".$_SERVER['HTTP_REFERER']."\n
										\$REQUEST_METHOD: ".$_SERVER['REQUEST_METHOD']."\n
										\$HTTP_ACCEPT_LANGUAGE: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."\n
									   Cookie:\n";
								foreach ($_COOKIE as $I => $val)
									{
										$mail_mes .= $I.'='.$val."\n";
									}
								$mail_mes .= "
    	                        Variables (GET):\n ";
								while (list($I, $val) = each($_GET))
									{
										$mail_mes .= " $I=$val\n";
									}
								$mail_mes .= "
										 Variables (POST):\n ";
								while (list($I, $val) = each($_POST))
									{
										$mail_mes .= " $I=$val\n";
									}
								$mail            = new Mail_sender;
								$mail->from_addr = $this->EP_from_addr;
								$mail->from_name = $this->EP_from_name;
								$mail->to        = $this->EP_to_addr;
								$mail->subj      = "Error occurred: $err_msg";
								$mail->body      = $mail_mes;
								$mail->priority  = 1;
								$mail->prepare_letter();
								$mail->send_letter();
							}
					}
				if (substr_count($actions, 'w'))
					{
						echo $err_msg;
					}
				if (substr_count($actions, 'a'))
					{
						echo $this->err_write();
					}
				if (substr_count($actions, 'd'))
					{
						unset($this->err_list);
					}
				if (substr_count($actions, 's'))
					{
						die();
					}
			}

		/**
		 *  Return HTML-block with list of an error messages
		 *
		 * @return bool|string
		 */
		function err_write()
			{
				$messages = '';
				if (is_array($this->err_list))
					{
						foreach ($this->err_list as $err_msg)
							{
								$messages .= str_replace('[ERR_MSG]', $err_msg, $this->EP_tmpl_err_item);
							}
					}
				if ($messages != '')
					{
						return $messages;
					}
				else
					{
						return false;
					}
			}


		/**
		 * Sends a log to administrator by e-mail and clears a log
		 *
		 * @param int $type
		 *  $type: 0 - errors, 1 - events
		 */
		 function log_send($type = 0)
			{

				if ($type == 0)
					{
						$title    = 'Report of errors log';
						$log_file = $this->EP_log_fullname;
					}
				else
					{
						$title    = 'Report of events log';
						$log_file = $this->event_log_fullname;
					}
				$dump = @file($log_file);
				if ($dump && filesize($log_file) > $this->EP_log_max_size * 1024)
					{
						$mail_mes = '<html><body>
	                            <h1>'.$title.'</h1>';
						$dump     = array_reverse($dump, false);
						foreach ($dump as $val)
							{
								$mail_mes .= trim($val).'<br>';
							}
						$mail_mes .= ' <p>
											This letter was created and a log on server was cleared at '.date('Y-m-d').'.
											<br>
											This message was sent automatically by robot, please don\'t reply!
											</p>
											</body></html>';

						$mail            = new Mail_sender;
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
		 * @param $message
		 * @param $user_id
		 */
		function log_event($message, $user_id)
			{

				@touch($this->event_log_fullname);
				@chmod($this->event_log_fullname, 0777);
				error_log(str_replace(array("\n",
				                            "\r"), ' ', $message)."\t".$_SERVER['REQUEST_URI']."\t$user_id\t".date('r').
					                                  "\t".Get_IP()."\n", 3, $this->event_log_fullname);
				$this->log_send(1);
			}

	}




	// Примеры
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