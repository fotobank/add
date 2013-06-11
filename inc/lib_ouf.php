<?php
/*
Library "Often Used Functions". V1.9. Copyright (C) 2003 - 2008 Richter
In this library collected functions on PHP often used on web-sites
Additional information: http://wpdom.com, richter@wpdom.com
*/

// Validation E-mail address
function validate_email($email)
{
  return (eregi("^[a-z0-9._-]+@[a-z0-9._-]+.[a-z]{2,4}$", $email));
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


// Функция экранирования переменных
  function quote_smart($value,$link) {
	 //если magic_quotes_gpc включена - используем stripslashes
	 if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	 }
	 //экранируем
	 $value = mysql_real_escape_string($value,$link);
	 return $value;
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

// Paging type 1 (numbers of a pages)
function get_paging1($item_q, $item_on_page, $cur_page, $tmpl_cur_page, $tmpl_oth_page, $divider = '', $max_simple = 30, $block_first = '&lt;&lt;', $block_last = '&gt;&gt;')
{
  if (!is_numeric($cur_page)) $cur_page = 1;
  $max_page = ceil($item_q/$item_on_page);

  if ($max_page <= $max_simple) { // Simple
    for ($I=1;$I<=$max_page;$I++) {
      if ($I == $cur_page) $paging .= str_replace("[NUM]",$I, $tmpl_cur_page);
      else {
        $page_no = $page_show = $I;
        eval($tmpl_oth_page);
        $paging .= $page_num;
      }
      if ($I < $max_page) $paging .= $divider;
    }
  } else { // Complex
    if ($cur_page > 1) {
      $page_no = 1;
      $page_show = $block_first;
      eval($tmpl_oth_page);
      $paging .= $page_num;
    }
    if ($cur_page > 3) $paging .= '... ';
    for ($I=$cur_page-2;$I<=$cur_page+2;$I++) {
      if ($I>0 and $I<=$max_page) {
        if ($I == $cur_page) $paging .= str_replace("[NUM]",$I, $tmpl_cur_page);
        else {
          $page_no = $page_show = $I;
          eval($tmpl_oth_page);
          $paging .= $page_num;
        }
        if ($I<$cur_page+2 and $I<$max_page) $paging .= $divider;
      }
    }
    if ($cur_page < $max_page-2) $paging .= '... ';
    if ($cur_page < $max_page) {
      $page_no = $max_page;
      $page_show = $block_last;
      eval($tmpl_oth_page);
      $paging .= $page_num;
    }
  }

  return $paging;
}

// Paging type 2 (numbers of a items, divided on groups)
function get_paging2($item_q, $item_on_page, $cur_page, $tmpl_cur_page, $tmpl_oth_page)
{
  $page_no = 0;
  for ($I=1;$I<=$item_q;$I=$I+$item_on_page) {
    $page_no++;
    $num_block = $I;
    $I1 = $I + $item_on_page - 1;
    if ($I1<=$item_q && $I!=$I1) $num_block .= '-'.$I1;
    if ($page_no != $cur_page) {
      eval($tmpl_oth_page);
      $paging .= $page_num;
    } else {
      $paging .= str_replace("[NUM]",$num_block, $tmpl_cur_page);
    }
  }
  return $paging;
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