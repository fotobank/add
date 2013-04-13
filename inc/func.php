<?php
function main_redir($addr, $close_conn = true, $code = 'HTTP/1.1 303 See Other')
{
  header($code);
  header('location: '.$addr);
  if ($close_conn)
  {
    mysql_close();
    exit();
  }
}

//ошибочный редирект с сообщением
function err_exit($msg = 'Ошибка! Обратитесь к администрации.', $addr = '')
{
  if(empty($addr)) $addr = $_SERVER['PHP_SELF'];
  $_SESSION['err_msg'] = $msg;
  main_redir($addr);
}

//успешный редирект с сообщением
function ok_exit($msg = 'Операция успешно завершена', $addr = '')
{
  if(empty($addr)) $addr = $_SERVER['PHP_SELF'];
  $_SESSION['ok_msg'] = $msg;
  main_redir($addr);
}

function get_param($param_name)
{
	$value = false;
	$rs = mysql_query('select param_value from nastr where param_name = \''.$param_name.'\'');
  if(mysql_num_rows($rs) > 0)
    $value = mysql_result($rs, 0);
	return $value;
}

/**
 * @return string
 */
function fotoFolder()
   {
      $foto_folder = mysql_result(mysql_query('select foto_folder from albums where id = '.intval($_SESSION['current_album']).'  '), 0);
      return $foto_folder;
   }

function getPassword($password,$id){
	stripslashes($password);
	$ipassword = trim(md5($password));
	$update = mysql_query("UPDATE users SET pass = '$ipassword' WHERE id = '$id'")or die(mysql_error()) ;
	if($update){return true;}
	return false;
}

/**
 * @param     $number
 * @param int $param
 *
 * @return string
 * пароль с регулируемым уровнем сложности
 * genpass(10, 1); // генерирует пароль из 10 символов содержащий буквы в верхнем и нижнем регистре
 * genpass(10, 2); // генерирует пароль из 10 символов содержащий буквы в верхнем и нижнем регистре, а также цифры от 0 до 9
 * genpass(10, 3); // генерирует пароль из 10 символов содержащий буквы в верхнем и нижнем регистре, цифры от 0 до 9 и все спец. символы. Пароль получится реально сложным))
 */
function genpass($number, $param = 1)
	{
		$arr = array('a','b','c','d','e','f',
		             'g','h','i','j','k','l',
		             'm','n','o','p','r','s',
		             't','u','v','x','y','z',
		             'A','B','C','D','E','F',
		             'G','H','I','J','K','L',
		             'M','N','O','P','R','S',
		             'T','U','V','X','Y','Z',
		             '1','2','3','4','5','6',
		             '7','8','9','0','.',',',
		             '(',')','[',']','!','?',
		             '&','^','%','@','*','$',
		             '<','>','/','|','+','-',
		             '{','}','`','~');
		// Генерируем пароль
		$pass = "";
		for($i = 0; $i < $number; $i++)
			{
				if ($param>count($arr)-1)$param=count($arr) - 1;
				if ($param==1) $param=48;
				if ($param==2) $param=58;
				if ($param==3) $param=count($arr) - 1;
				// Вычисляем случайный индекс массива
				$index = rand(0, $param);
				$pass .= $arr[$index];
			}
		return $pass;
	}

/**
 * @param int $size
 *
 * @return string
 * легкозапоминающийся пароль
 */
function genPassword($size = 8){
	$a = array('e','y','u','i','o','a','E','Y','U','I','O','A');
	$b = array('q','w','r','t','p','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
	$c = array('1','2','3','4','5','6','7','8','9','0');
	$e = array('-','_','!','~','$','*','@',':','<','>','+','%');
	$password = $b[array_rand($b)];

	do {
		$lastChar = $password[ strlen($password)-1 ];
		@$predLastChar = $password[ strlen($password)-2 ];
		if( in_array($lastChar,$b)  ) {//последняя буква была согласной
			if( in_array($predLastChar,$a) ) { // две последние буквы были согласными
				$r = rand(0,2);
				if( $r  ) $password .= $a[array_rand($a)];
				else $password .= $b[array_rand($b)];
			}
			else $password .= $a[array_rand($a)];

		} elseif( !in_array($lastChar,$c) AND !in_array($lastChar,$e) ) {
			$r = rand(0,2);
			if($r == 2)$password .= $b[array_rand($b)];
			elseif(($r == 1)) $password .= $e[array_rand($e)];
			else $password .= $c[array_rand($c)];
		} else{
			$password .= $b[array_rand($b)];
		}

	} while ( ($len = strlen($password) ) < $size);

	return $password;
}

?>
