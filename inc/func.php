<?php
function main_redir($addr, $close_conn = true, $code = 'HTTP/1.1 303 See Other')
{
  header($code);
  header('location: '.$addr);
  if ($close_conn)
  {
	 $db = go\DB\Storage::getInstance()->get('db-for-data');
	 $db->close();
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



function get_param($param_name,$param_index)
{
	$db = go\DB\Storage::getInstance()->get('db-for-data');
	$rs = $db->query('select `param_value` from nastr where `param_name` = (?string) AND `param_index` = ?i',array($param_name,$param_index), 'el');
	$value = $rs ? $rs : false;
	return $value;
}

/**
 * @return string
 */
function fotoFolder()
   {
	   $db = go\DB\Storage::getInstance()->get('db-for-data');
	   $foto_folder = $db->query('select foto_folder from albums where id = ?i',array($_SESSION['current_album']), 'el');
      return $foto_folder;
   }

function getPassword($password,$id){
//	stripslashes($password);
//	$ipassword = trim(md5($password));
//	$update = mysql_query("UPDATE users SET pass = '$ipassword' WHERE id = '$id'")or die(mysql_error()) ;
	$db = go\DB\Storage::getInstance()->get('db-for-data');
	$update = $db->query('UPDATE users SET pass = md5(?string) WHERE id = ?i',array($password,$id)) or die(mysql_error()) ;
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


// сумма прописью string str_digit_str(integer)
function str_digit_str($summ){
    $tmp_num = (integer)$summ;  // текущий
    $str = "";
    $i = 1;            // счетчик триад
    $th = array("");

    // откусываем по три цифры с конца и обрабатываем функцией
    while(strlen($tmp_num) > 0)
    {
        $tri = "";
        if (strlen($tmp_num) > 3)
        {
            $dig = substr($tmp_num,strlen($tmp_num)-3);
            $tmp_num = substr($tmp_num,0, -3);
        }
        else
        {
            $dig = $tmp_num;
            $tmp_num = "";
        }
       if ($i == 1) $th = " ";
       else if ($i == 2) $th = " тысяч ";
       else if ($i == 3) $th = " миллионов ";
       else if ($i == 4) $th = " миллиардов ";
       else if ($i == 5) $th = " биллионов ";
       else if ($i == 6) $th = " триллионов ";
       
        // вызываем функцию "сумма прописью" для нашей триады и присоединяем название разряда
        $str = digit_to_string($dig).$th.$str;
        $i++;
    }
    
    // а теперь заменим неправильные падежи - их не так много, поэтому обойдемся массивом замен
    $tr_arr = array(
        "один тысяч" => "одна тысяча",
        "два тысяч" => "две тысячи",
        "три тысяч" => "три тысячи",
        "четыре тысяч" => "четыре тысячи",
        "один миллионов" => "один миллион",
        "два миллионов" => "два миллиона",
        "три миллионов" => "три миллиона",
        "четыре миллионов" => "четыре миллиона",
        "один миллиардов" => "один миллиард",
        "два миллиардов" => "два миллиарда",
        "три миллиардов" => "три миллиарда",
        "четыре миллиардов" => "четыре миллиарда", );

    // заменяем падежи
    $str = strtr($str, $tr_arr);
    return($str);
}

// сумма прописью до 999
function digit_to_string($dig){
    $str = "";
    
    // определяем массивы единиц, десятков и сотен
    $ed = array("","один","два","три","четыре","пять","шесть","семь","восемь","девять","десять",
        "одиннадцать","двенадцать","тринадцать","четырнадцать","пятнадцать","шестнадцать",
        "семнадцать","восемнадцать","девятнадцать","двадцать");
    $des = array("","десять","двадцать","тридцать","сорок","пятьдесят","шестьдесят","семьдесят","восемьдесят","девяносто");
    $sot = array("","сто","двести","триста","четыреста","пятьсот","шестьсот","семьсот","восемьсот","девятьсот");

    $dig = (int)$dig;
    if ($dig > 0 && $dig <= 20)
    {
        $str = $ed[$dig];
    }
    else if ($dig > 20 && $dig < 100)
    {
        $tmp1 = substr($dig,0,1);
        $tmp2 = substr($dig,1,1);
        $str = $des[$tmp1]." ".$ed[$tmp2];
    }
    else if ($dig > 99 && $dig < 1000)
   {
        $tmp1 = substr($dig,0,1);
        if (substr($dig,1,2) > 20)
        {
            $tmp2 = substr($dig,1,1);
            $tmp3 = substr($dig,2,1);
            $str = $sot[$tmp1]." ".$des[$tmp2]." ".$ed[$tmp3];
        }
        else $str = $sot[$tmp1]." ".digit_to_string(substr($dig,1,2));
    }
  return $str;
}

	/**
	 * Подсчет переменных заказа для корзины
	 * @return float|int
	 */
	function iTogo()
		{
			if ($_SESSION['basket'])
				{
					$basket = '';
					$key    = 0;
					$koll   = array();
					foreach ($_SESSION['basket'] as $ind => $val)
						{

							$basket .= $ind.',';
							$koll[$key] = $val;
							$key++;

						}
					if($basket !='')
						{
					$basket = substr($basket, 0, strlen($basket) - 1); // отрезаем последний символ от строки
					$db = go\DB\Storage::getInstance()->get('db-for-data');
					$rs = $db->query('SELECT * FROM `photos` WHERE `id` IN ('.$basket.')')->assoc();
					$sum = array();
					$sum['pecat'] = 0;
					$sum['pecat_A4'] = 0;
					$sum['koll'] = 0;
					$sum['price'] = 0;
					$sum['file'] = 0;
					$sum['arrA4'] = array();
					$sum['arr13'] = array();
					$sum['A4'] = array();
					$sum['13'] = array();
					$sum['id'] = array();
					$sum['nm'] = array();
					if ($rs)
						{
							foreach ($rs as $key => $val)
								{
									$sum['file']   = $key+1; // кол-во заказанных файлов
									$sum['price'] += floatval($rs[$key]['price']); // цена за все скачанные файлы
									$sum['pecat'] += floatval($rs[$key]['pecat']) * intval($koll[$key]);  // цена за печать 13x18
									$sum['pecat_A4'] += floatval($rs[$key]['pecat_A4']) * intval($koll[$key]); // цена за печать A4
									$sum['koll'] += intval($koll[$key]); // кол-во фото для печати
									$sum['arr13'][$val['id']] = (floatval($rs[$key]['pecat']) * intval($koll[$key])); // массив фото 13x18 - цена * кол-во
									$sum['arrA4'][$val['id']] = floatval($rs[$key]['pecat_A4']) * intval($koll[$key]); // массив фото 20x30 - цена * кол-во
									$sum['13'][$val['id']] = floatval($rs[$key]['pecat']); // массив фото 13x18 - цена
									$sum['A4'][$val['id']] = floatval($rs[$key]['pecat_A4']); // массив фото 20x30 - цена
									$sum['cena_file'][$val['id']] = floatval($rs[$key]['price']); // массив цен на файлы
									$sum['id'][$val['id']] = $val['id'];
									$sum['nm'][$val['id']] = $val['nm'];
								}
							return $sum;
						}
					return $sum;
				     }
					unset ($_SESSION['basket']);
					return false;
				}
			else
				{
					return false;
				}
		}

	/**
	 * @return null|string
	 * рассчет суммы заказа
	 */
	function summa()
		{
			    $print = iTogo();
			if ($print)
				{
			    $format = $_SESSION['zakaz']['format'];
			    $rt = NULL;
			if (isset($_SESSION['print']))
				{
			if ($_SESSION['print'] == '1' || $_SESSION['print'] == '2')
				{
					if ($format == '10x15' || $format == '13x18')
						{
							$rt = "ИТОГО: ".$print['pecat']." гривень (".$print['koll']." фото ".$format."см)";
						}
					elseif ($format == '20x30')
						{
							$rt = "ИТОГО: ".$print['pecat_A4']." гривень (".$print['koll']." фото ".$format."см)";
						}
				}
			 elseif ($_SESSION['print'] == 0)
				{
					$rt = "ИТОГО: ".$print['price']." гривень (".$print['file']." фото 13x18см)";
				}
				}
			 return $rt;
				} else {
			 return false;
			}
		}

  function russData($mysqldate)
  {
# Переменная с датой из базы
//	 $mysqldate = '2011-06-10 15:18:00';

# Перевод даты из базы  в формат времени Unix
# получается примерно такое 1307719080
	 $time = strtotime($mysqldate);

# Создаем ассоциативный массив где каждому числу месяца присваем название месяца
	 $month_name = array( 1 => 'января', 2 => 'февраля', 3 => 'марта',
								 4 => 'апреля', 5 => 'мая', 6 => 'июня',
								 7 => 'июля', 8 => 'августа', 9 => 'сентября',
								 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
	 );

#Получаем название месяца, здесь используется наш созданный массив
	 $month = $month_name[ date( 'n',$time ) ];

	 $day   = date( 'j',$time ); # С помощью функции date() получаем число дня
	 $year  = date( 'Y',$time ); # Получаем год
	 $hour  = date( 'G',$time ); # Получаем значение часа
	 $min   = date( 'i',$time ); # Получаем минуты

	 $date = "$day $month $year, $hour:$min";  # Собираем пазл из переменных

	 return $date; #Выводим преобразованную дату
  }
?>