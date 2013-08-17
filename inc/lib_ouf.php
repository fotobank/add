<?php
/*
Library "Often Used Functions". V1.9. Copyright (C) 2003 - 2008 Richter
In this library collected functions on PHP often used on web-sites
Additional information: http://wpdom.com, richter@wpdom.com
*/

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
	* print для ENUM
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
	* print для Set
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
  function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
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

?>