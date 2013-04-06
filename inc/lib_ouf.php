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

// Return IP-address of user
function Get_IP()
{
  $ip = @getenv(HTTP_X_FORWARDED_FOR);
  if (!$ip) {
    $ip = @getenv(REMOTE_ADDR);
  } else {
    $tmp = ",";
    if (strlen(strstr($ip,$tmp)) != 0) {
      $ips = explode($tmp,$ip);
      $ip = $ips[count($ips)-1];
    }
  }
  return trim($ip);
}

// Return Whois-information (uses database of RIPE NCC)
// $address can be IP-address or hostname
function Get_Whois($address)
{
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

// Explode date in format YYYY-MM-DD HH:MM:SS in object
function explode_date($date)
{
  $date_obj->year = substr($date,0,4);
  $date_obj->month = substr($date,5,2);
  $date_obj->day = substr($date,8,2);
  $date_obj->hour = substr($date,11,2);
  $date_obj->minutes = substr($date,14,2);
  $date_obj->seconds = substr($date,17,2);
  return $date_obj;
}

// Reads content of ini-file
// $ignore_sections: ignore sections ("[Something]")
function read_ini($file_name, $ignore_sections = FALSE)
{
  $dump = file($file_name);
  foreach ($dump as $val) {
    if (trim($val) != '') {
      if (substr($val,0,1) == '[') {
        $first_index = trim(substr($val,1,strlen($val)-4));
      } else {
        preg_match ("/(.*?)=/", $val, $tmp_index);
        preg_match ("/=(.*?)$/", $val, $tmp_value);
        if ($ignore_sections) $out[$tmp_index[1]] = $tmp_value[1];
        else $out[$first_index][$tmp_index[1]] = $tmp_value[1];
      }
    }
  }
  return($out);
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

// Return "breadcrumbs"
// Example: $breadcrumbs = array('soft.php'=>'Software', 'cms/index.php'=>'Ardzo.CMS', ''=>'Order');
function get_breadcrumbs($breadcrumbs, $divider = ' &rarr; ', $start_block = '<div class="breadcrumbs"><a href="index.php">Main page</a>', $end_block = '</div>')
{
  if (!empty($breadcrumbs)) {
    $tmp = $start_block;
    if (!is_array($breadcrumbs)) $breadcrumbs = array(''=>$breadcrumbs);
    foreach ($breadcrumbs as $url=>$title)
      if (empty($url)) $tmp .= $divider.$title;
      else $tmp .= $divider.'<a href="'.$url.'">'.$title.'</a>';
    $tmp .= $end_block;
    return $tmp;
  }
}
?>