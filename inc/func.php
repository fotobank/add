<?php

	include_once (__DIR__.'/../classes/autoload.php');
	autoload::getInstance();


  /**
	* @param        $addr
	* @param bool   $close_conn
	* @param string $code
	*/
function main_redir($addr = '', $close_conn = true, $code = 'HTTP/1.1 303 See Other')
{

  header($code);
  if(empty($addr))
	 {
		if (isset($_SERVER['HTTP_REFERER'])) {
		  header ("location: ".$_SERVER['HTTP_REFERER']);
		}else{
		  header ("location: index.php");
		}
	 } else {
	 header('location: '.$addr);
  }

  if ($close_conn)
	 {
		$db = go\DB\Storage::getInstance()->get('db-for-data');
		$db->close();
	 }
  exit();
 }


  /**
	* @param string $msg
	* @param string $addr
	*/
//ошибочный редирект с сообщением
function err_exit($msg = 'Ошибка! Обратитесь к администрации.', $addr = '')
{
  $session = check_Session::getInstance();
  if(empty($addr)) $addr = $_SERVER['HTTP_REFERER'];
  $session->set('err_msg', $msg);
  main_redir($addr);
}

  /**
	* @param string $msg
	* @param string $addr
	*/
//успешный редирект с сообщением
function ok_exit($msg = 'Операция успешно завершена', $addr = '')
{
  $session = check_Session::getInstance();
  if(empty($addr)) $addr = $_SERVER['HTTP_REFERER'];
  $session->set('ok_msg', $msg);
  main_redir($addr, false);
}



  function admin_only()
  {
	 if (isset($_COOKIE['admnews']) && $_COOKIE['admnews'] != md5(login().'///'.pass()));
	 {
		if(!$_SESSION['admin_logged']){
		  echo '<div class="title2">Извините ,данная функция доступна только для администратора<br/><a href="index.php">Админка</a></div>';
		}
	 }
  }


  function if_adm($str)
  {
	 if (isset($_COOKIE['admnews']) && $_COOKIE['admnews'] == md5(login().'///'.pass()));
	 {
		if($_SESSION['admin_logged']){
		  return $str;
		}
		return false;
	 }
  }


  function login()
  {
	 $db = go\DB\Storage::getInstance()->get('db-for-data');
	 return $db->query('SELECT `admnick` FROM `config` WHERE id=1', '', 'el');
  }


  function pass()
  {
	 $db = go\DB\Storage::getInstance()->get('db-for-data');
	 return $db->query('SELECT `admpass` FROM `config` WHERE id=1', '', 'el');
  }


  function if_login($str)
  {
		if(isset($_SESSION['logged']) && ($_SESSION['logged'])){
		  return $str;
		}
		return false;
  }

  function if_login_not_admin($str)
  {
	return if_login(!if_adm($str));
  }


  /**
	* @param $param_name
	* @param $param_index
	*
	* @return bool|\go\DB\Result
	*/
function get_param($param_name,$param_index)
{
	$db = go\DB\Storage::getInstance()->get('db-for-data');
	$rs = $db->query('select `param_value` from `nastr` where `param_name` = (?string) AND `param_index` = ?i',array($param_name,$param_index), 'el');
	$value = $rs ? $rs : false;
	return $value;
}

  /**
	* @param $kolonka
	* @param $user_id
	*
	* @return bool|\go\DB\Result
	*/
  function get_user($kolonka,$user_id)
  {
	 $db = go\DB\Storage::getInstance()->get('db-for-data');
	 $rs = $db->query('select ?c from `users` where `id` = ?i',array($kolonka,$user_id), 'el');
	 $value = $rs ? $rs : false;
	 return $value;
  }

/**
 * @return string
 */
function fotoFolder()
   {
	   $session = check_Session::getInstance();
	   $db = go\DB\Storage::getInstance()->get('db-for-data');
	   $foto_folder = $db->query('select `foto_folder` from `albums` where `id` = ?i',array($session->get('current_album')), 'el');
      return $foto_folder;
   }

  /**
	* @param $password
	* @param $id
	*
	* @return bool
	*/
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
	//$e = array('-','_','!','~','$','*','@',':','<','>','+','%');
   $e = array('-','_','!','~','*',':','<','>','+','.');
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
		  $session = check_Session::getInstance();

			if ($session->has('basket'))
				{
					$basket = '';
					$key    = 0;
					$koll   = array();
					foreach ($session->get('basket') as $ind => $val)
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
				  $session->del('basket');
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
		  $session = check_Session::getInstance();
			    $print = iTogo();
			if ($print)
				{
				 $zakaz =  $session->get("zakaz");
				 $format = $zakaz['format'];
			    $rt = NULL;

			if ($session->get('print') == '1' || $session->get('print') == '2')
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
			 elseif ($session->get('print') == 0)
				{
					$rt = "ИТОГО: ".$print['price']." гривень (".$print['file']." фото 13x18см)";
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



  /**
	* Функция для перевода даты на русский язык
	*
	* @param number дата в unix формате
	* @param string формат выводимой даты
	* @param number сдвиг времени (часов, относительно времени на сервере)
	*
	* %MONTH% — русское название месяца (родительный падеж)
	* %DAYWEEK% — русское название дня недели
	*
	* @example
	* echo dateToRus( time(), '%DAYWEEK%, j %MONTH% Y, G:i' );
	*  суббота, 10 декабря 2010, 12:03
	*  Пример использования:
   * echo dateToRus($row['created_unix'], '%DAYWEEK%, j %MONTH% Y, G:i');
	*/
  function dateToRus($d, $format = 'j %MONTH% Y', $offset = 0)
  {
	 $months = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля',
						  'августа', 'сентября', 'октября', 'ноября', 'декабря');

	 $days = array('понедельник', 'вторник', 'среда', 'четверг',
						'пятница', 'суббота', 'воскресенье');

	 $d += 3600 * $offset;

	 $format = preg_replace(array(
									'/%MONTH%/i',
									'/%DAYWEEK%/i'
									), array(
										$months[date("m", $d) - 1],
										$days[date("N", $d) - 1]
										), $format);

	 return date($format, $d);
  }


  /**
	* @return string
	*
	*  Переменная $domain содержит имя домена, на котором выполняется ваше приложение.
	*/
  function get_domain()
  {
	 $domain = "http://www.aleks.od.ua/";
	 return $domain;
  }

  /**
	* @param $link
	* @param $text
	* @param $title
	* @param $extras
	*
	* @return string
	*
	*  anchor('new-page.php','New Page','Custom Title Message!','#special_link');
	*
	*  В случае задания класса, ID и для открытия в новом окне, вызов функции будет иметь вид:
	*  $extras = array('#special_id','.special_class','_blank');
	*  echo anchor('new-page.php','New Page','Custom Title Message!',$extras);
	*
	*/
  function anchor($link, $text, $title, $extras)
  {
	 $domain = get_domain();
	 $link = $domain . $link;
	 $data = '<a href="' . $link . '"';
	 if ($title)
		{
		  $data .= ' title="' . $title . '"';
		}
	 else
		{
		  $data .= ' title="' . $text . '"';
		}
	 if (is_array($extras))
		{
		  foreach($extras as $rule)
			 {
				$data .= parse_extras($rule);
			 }
		}
	 if (is_string($extras))
		{
		  $data .= parse_extras($extras);
		}
	 $data.= '>';
	 $data .= $text;
	 $data .= "</a>";
	 return $data;
  }



  /**
	* @param $rule
	*
	* @return string
	*
	* Если мы передаем CSS ID, то он будет начинаться с #.
	* Если мы передаем класс CSS, то он начнется с . .
	* А если передается тэг target, то он начнется с _.
	*/
  function parse_extras($rule)
  {
	 if ($rule[0] == "#")
		{
		  $id = substr($rule,1,strlen($rule));
		  $data = ' id="' . $id . '"';
		  return $data;
		}
	 elseif ($rule[0] == ".")
		{
		  $class = substr($rule,1,strlen($rule));
		  $data = ' class="' . $class . '"';
		  return $data;
		}
	 elseif ($rule[0] == "_")
		{
		  $data = ' target="' . $rule . '"';
		  return $data;
		}
	 return false;
  }


  /**
	* @param $email
	* @param $text
	* @param $title
	* @param $extras
	*
	* @return string
	*
	* для создания ссылки mailto:
	* echo mailto('secret@emailaddress.com','Contact Me');
	* Или, если используются пользовательские настройки, так:
	* $extras = array('#special_id','.special_class','_blank');
	* echo mailto('secret@emailaddress.com','Contact me','Contact your good pal Barry.',$extras);
	*
	*/
function mailto($email, $text, $title, $extras)
{
$link = '<a href=\"mailto:' . $email;
$link = str_rot13($link);
$data = '<script type="text/javascript">document.write("';
  $data .= $link;
  $data .= '".replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));
</script>';
$data .= '"';
if ($title)
{
$data .= ' title="' . $title . '"';
}
else
{
$data .= ' title="' . $text . '"';
}
if (is_array($extras))
{
foreach($extras as $rule)
{
$data .= parse_extras($rule);
}
}
if (is_string($extras))
{
$data .= parse_extras($extras);
}
$data .= ">";
$data .= $text;
$data .= "</a>";
return $data;
}

  /**
	*  Склонение слов
	*   $n — число/количество
	*  ehample :  padegi(2)
	*  result: коментария
	*  ehample : padegi(55,'страница','страницы','страниц')
	*  result: страниц
	*/
 function padegi($n,$var1='комментарий',$var2='комментария',$var3='комментариев'){

  return $n%10==1&&$n%100!=11?$var1:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$var2:$var3);

  }


  /**
	* Удаление ссылок из текста
	* $string = 'Это тестовая строка с ссылками: http://xozblog.ru и еще http://google.com';
	*
	* @param $string
	*
	* @return mixed
	*/
  function removeUrl ($string){
	 return preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $string);
  }


// Вывести на экран изображение пользователя Gravatar
  function printGgravatar ($email) {
  $gravatar = 'http://www.gravatar.com/avatar/' . md5( strtolower( trim( $email ) ) ) . '?s=32';
  return '<img class="avatar photo" src="' . $gravatar . '" width="40" height="40"/>';
  }



  /**
	* Get either a Gravatar URL or complete image tag for a specified email address.
	*
	* @param string $email The email address
	* @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
	* @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
	* @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
	* @param boole $img True to return a complete IMG tag False for just the URL
	* @param array $atts Optional, additional key/value attributes to include in the IMG tag
	* @return String containing either just a URL or a complete image tag
	* @source http://gravatar.com/site/implement/images/php/
	*/
  function get_gravatar( $email, $img = false, $atts = array("width"=>"40", "height"=>"40", "class"=>"avatar photo"), $s = 80, $d = 'mm', $r = 'g' ) {
	 $url = 'http://www.gravatar.com/avatar/';
	 $url .= md5( strtolower( trim( $email ) ) );
	 $url .= "?s=$s&d=$d&r=$r";
	 if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
		  $url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	 }
	 return $url;
  }



  /**
	* Создание временного URL из строки
	* Здесь мы передаем в функцию строковую переменную, преобразуем строку в нижний регистр и заменяем все пробелы тире.
	* Принцип как в текстовом редакторе WordPress, вводим заголовок статьи и сразу формируется URL страницы.
	* echo create_slug('Create Simple Slug URL');
	*
	* @param $string
	*
	* @return mixed
	*/
  function create_slug($string){
	 $string = strtolower($string);
	 $slug=preg_replace('/[^a-z0-9-]+/', '-', $string);
	 return $slug;
  }

	// Return all values (array) of specified tag from XML-fragment
	function get_fa($text,$tag)
	{
		preg_match_all("/<$tag>(.*?)<\/$tag>/s",$text,$out);
		return $out[1];
	}

	// Return first value of specified tag from XML-fragment
	function get_f($text,$tag)
	{
		$ret = get_fa($text,$tag);
		return $ret[0];
	}

	/**
	 * Возвращает безопасное значение, с удаленным html и php кодом
	 * @param string $in_Val - исходное значение
	 * @param int $trim_Val - если больше 0, то оставляет только указанное количество символов
	 * @param bool $u_Case - если true, то возвращает заглавные буквы
	 * @param bool $trim_symbols - если true, то возвращает только цифры до первой буквы
	 * @return string
	 */
	function GetFormValue($in_Val, $trim_Val = 0, $u_Case = false, $trim_symbols=false) {
		$ret = trim(addslashes(htmlspecialchars(strip_tags($in_Val))));
		if ($trim_Val)
			$ret = substr($ret, 0, $trim_Val);
		if ($u_Case)
			$ret = strtoupper($ret);

		if ($trim_symbols) {
			$my_len = strlen($ret);
			for ($pos = 0; $pos<$my_len;$pos++) {
				if (!is_numeric(substr($ret,$pos,1))) {
					$ret = substr($ret,0,$pos);
					break;
				}
			}
		}
		return $ret;
	}

	// -------------------------------------------------------------
	function cleanInput($input) {

		$search = array(
			'@<script[^>]*?>.*?</script>@si',   // javascript
			'@<[\/\!]*?[^<>]*?>@si',            // HTML теги
			'@<style[^>]*?>.*?</style>@siU',    // теги style
			'@<![\s\S]*?--[ \t\n\r]*>@'         // многоуровневые комментарии
		);

		$output = preg_replace($search, '', $input);
		return $output;
	}

	function sql_valid($data) {
		$data = str_replace("\\", "\\\\", $data);
		$data = str_replace("'", "\'", $data);
		$data = str_replace('"', '\"', $data);
		$data = str_replace("\x00", "\\x00", $data);
		$data = str_replace("\x1a", "\\x1a", $data);
		$data = str_replace("\r", "\\r", $data);
		$data = str_replace("\n", "\\n", $data);
		return($data);
	}

	/**
	 * для базы данных
	 *
	 * @param $input
	 *
	 * @return bool|mixed
	 */
	function sanitize($input) {

		if (is_array($input)) {
			foreach($input as $var=>$val) {
				$output[$var] = sanitize($val);
			}
		}
		else {
			if (get_magic_quotes_gpc()) {
				$input = stripslashes($input);
			}
			$input  = cleanInput($input);
			$output = sql_valid($input);

		}
		return isset($output)?$output:false;
	}

	//---------------------------------------------------------
	/**
	 * @param $table
	 * @param $kolonka
	 *
	 * print для ENUM msql
	 */
	function printEnum ($table, $kolonka)
	{

		if (isset($_SESSION['kolonka']))
		{
			$current_c = $_SESSION['kolonka'];
		}
		else
		{
			$current_c = 'c_colonka';
		}

		$db = go\DB\Storage::getInstance()->get('db-for-data');
		$data	= $db->query('SHOW COLUMNS FROM ?t LIKE "%?e%" ',array($table,$kolonka))->row();
		preg_match_all('/\(([^)]+)\)/', str_replace("'", '', $data['Type']), $values);
		$enum_fileds = explode(',', $values[1][0]);
		foreach ($enum_fileds as $field)
		{
			printf ("<option value ='%s' ".( $current_c == $field ? 'selected="selected"' : '')." >%s</option>",$field,$field);
		}
	}



	//---------------------------------------------------------
	/**
	 * @param $table
	 * @param $kolonka
	 *
	 * print для Set msql
	 */
	function printSet ($table, $kolonka)
	{

		if (isset($_SESSION['location']))
		{
			$current_c = $_SESSION['location'];
		}
		else
		{
			$current_c = NULL;
		}

		$db = go\DB\Storage::getInstance()->get('db-for-data');
		$data	= $db->query('SHOW COLUMNS FROM ?t LIKE "%?e%" ',array($table,$kolonka))->row();
		preg_match_all('/\(([^)]+)\)/', str_replace("'", '', $data['Type']), $values);
		$enum_fileds = explode(',', $values[1][0]);
		foreach ($enum_fileds as $field)
		{
			$selekted = '';
			foreach($current_c as $val)
			{
				if($val == $field)
				{
					$selekted = 'selected="selected"';
					break;
				}
			}
			printf ("<option value ='%s' ".$selekted." >%s</option>",$field,$field);
		}
	}




	function Get_IP()
	{
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
		{
			$ip = getenv("HTTP_CLIENT_IP");
		}
		elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
		{
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}
		elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
		{
			$ip = getenv("REMOTE_ADDR");
		}
		elseif (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		else
		{
			$ip = "unknown";
		}

		return ($ip);
	}


	// Return Whois-information (uses database of RIPE NCC)
	// $address can be IP-address or hostname
	function Get_Whois($address)
	{
		$res = '';
		if (empty($address)) return 'No search key specified';
		$socket = fsockopen ("whois.ripe.net", 43, $errno, $errstr);
		if (!$socket) {
			return $errstr($errno);
		} else {
			fputs ($socket, $address."\r\n");
			while (!feof($socket)) {
				$res .= fgets($socket, 128);
			}
		}
		fclose ($socket);
		return $res;
	}

	// Return cut string
	// $InStr - string, $Len - required length
	function ISubStr($InStr,$Len)
	{
		$Tmp1 = substr($InStr,0,$Len);
		if (strlen($Tmp1) == $Len) { // Scrap of incomplete words
			for (;;) {
				if (substr($Tmp1,-1) == ' ') {break;}
				else {$Tmp1 = substr($Tmp1,0,-1);}
			}
			$Tmp1 = $Tmp1.'...';
		}
		return $Tmp1;
	}



	// Call HTTP authentication header
	function authenticate($message)
	{
		Header( "WWW-authenticate: Basic realm=\"$message\"");
		Header( "HTTP/1.0 401 Unauthorized");
	}


	// Delete all files in specified folder and also the folder
	function delete_files($folder)
	{
		if ($dir = @opendir($folder)) {
			while (($file = readdir($dir)) !== false) {
				if ($file!='.' && $file!='..' && filetype($folder.$file)=='file') {
					unlink($folder.$file);
				} elseif ($file!='.' && $file!='..' && filetype($folder.$file)=='dir') {
					delete_files($folder.$file.'/');
				}
			}
			closedir($dir);
			rmdir(substr($folder, 0, strlen($folder)-1));
		}
	}

	/**
	 * @param $time
	 * форматирование времени
	 * @return string
	 */
	function showPeriod($time) {
		return sprintf("%02d:%02d:%02d", (int)($time / 3600), (int)(($time % 3600) / 60), $time % 60);
	}


	/**
	 *
	 * Преобразование объекта в массив
	 * $array = objectToArray( $obj );
	 *
	 * @param    object  $object преобразуемый объект
	 * @reeturn      array
	 *
	 */
	function objectToArray( $object )
	{
		if( !is_object( $object ) && !is_array( $object ) )
		{
			return $object;
		}
		if( is_object( $object ) )
		{
			$object = get_object_vars( $object );
		}
		return array_map( 'objectToArray', $object );
	}