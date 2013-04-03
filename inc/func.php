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

?>
