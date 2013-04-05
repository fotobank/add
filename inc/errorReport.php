<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 05.04.13
 * Time: 16:44
 * To change this template use File | Settings | File Templates.
 */


// мы сделаем нашу собственную обработку ошибок
error_reporting(0);

// определяемая пользователем функция обработки ошибок
function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
	{
		// timestamp для входа ошибки
		$dt = date("Y-m-d H:i:s (T)");

		// определяем ассоциативный массив строки ошибки
		// в действительности единственные входы, которые
		// мы должны рассмотреть - это E_WARNING, E_NOTICE, E_USER_ERROR,
		// E_USER_WARNING и E_USER_NOTICE
		$errortype = array (
			E_ERROR           => "Error",
			E_WARNING         => "Warning",
			E_PARSE           => "Parsing Error",
			E_NOTICE          => "Notice",
			E_CORE_ERROR      => "Core Error",
			E_CORE_WARNING    => "Core Warning",
			E_COMPILE_ERROR   => "Compile Error",
			E_COMPILE_WARNING => "Compile Warning",
			E_USER_ERROR      => "User Error",
			E_USER_WARNING    => "User Warning",
			E_USER_NOTICE     => "User Notice",
			E_STRICT          => "Runtime Notice"
		);
		// набор ошибок, на которые переменный след будет сохранен
		$user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

		$err = "<errorentry>\n";
		$err .= "\t<datetime>" . $dt . "</datetime>\n";
		$err .= "\t<errornum>" . $errno . "</errornum>\n";
		$err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
		$err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
		$err .= "\t<scriptname>" . $filename . "</scriptname>\n";
		$err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";

		if (in_array($errno, $user_errors)) {
			$err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
		}
		$err .= "</errorentry>\n\n";

		// для проверки:
		// echo $err;

		// сохранить в файл регистрации ошибок, и послать мне по электронной почте,
		// если есть критическая пользовательская ошибка
		error_log($err, 3, "error.log");
		if ($errno == E_USER_ERROR) {
			mail("aleksjurii@gmail.com.com", "Critical User Error", $err);
		}
	}


function distance($vect1, $vect2)
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
	}

$old_error_handler = set_error_handler("userErrorHandler");

// undefined constant, generates a warning
//$t = NOT_DEFINED;

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