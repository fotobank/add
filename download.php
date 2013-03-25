<?php
include ('inc/config.php');
include ('inc/func.php');

if(!isset($_SESSION['logged']))
  err_exit('Для скачивания фото необходимо залогиниться на сайте!', 'index.php');
if(!isset($_GET['key']))
  err_exit('Ключ не найден!', 'index.php');
$key = mysql_escape_string($_GET['key']);
$rs = mysql_query('select * from download_photo where download_key = \''.$key.'\'');
if(mysql_num_rows($rs) == 0)
{
  err_exit('Ключ не найден!', 'index.php');
}
else
{
  $data = mysql_fetch_assoc($rs);
  if((time() - intval($data['dt_start']) > 172800) && intval($data['downloads']) > 0)
  {
  	//Раскомментировать следующую строку, если надо удалять просроченные записи о фото
  	//mysql_query('delete from download_photo where id = '.$data['id']);
  	err_exit('Лимит в 48 часов для скачивания фото прошел!', 'index.php');
  }
  else
  {
    $rs = mysql_query('select * from photos where id = '.$data['id_photo']);
    if(mysql_num_rows($rs) == 0)
    {
      err_exit('Фотография не найдена!', 'index.php');
    }
    else
    {
      $photo_data = mysql_fetch_assoc($rs);
      $ftp_host = get_param('ftp_host');
      $ftp_user = get_param('ftp_user');
      $ftp_pass = get_param('ftp_pass');
      if($ftp_host && $ftp_user && $ftp_pass)
      {
	    //Если в хосте присутствует порт - выделим его
    	if(strstr($ftp_host, ':'))
    	{
    		$ftp_port = substr($ftp_host, strpos($ftp_host, ':') + 1);
    		$ftp_host = substr($ftp_host, 0, strpos($ftp_host, ':'));
    	}
    	else
    	{
    		$ftp_port = 21;
    	}
    	   //Соединяемся	 	  
      	$ftp = ftp_connect($ftp_host, $ftp_port);
      	if(!$ftp)
      	{
		var_dump ($ftp);
         err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=002)', 'index.php');
        }
        if(!ftp_login($ftp, $ftp_user, $ftp_pass))
        {
        	ftp_close($ftp);
          err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=003)', 'index.php');
        }
    		$remote_file = $photo_data['ftp_path'];
    		$f_name = substr($remote_file, strrpos($remote_file, '/') + 1);								   
$f_name = iconv('utf-8', 'cp1251', $f_name);	
        $ext = strtolower(substr($f_name, strrpos($f_name, '.') + 1));
    		$local_file = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$f_name;
    	if(!ftp_get($ftp, $local_file, $remote_file, FTP_BINARY))
          err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=004)', 'index.php');
        switch($ext)
        {
        	default:
        	case 'jpg':
        	case 'jpeg':
        	  $img = imagecreatefromJPEG($local_file);
        	break;
        	case 'gif':
        	  $img = imagecreatefromGIF($local_file);
        	break;
        	case 'png':
        	  $img = imagecreatefromPNG($local_file);
        	break;
        }
        $sz = getimagesize($local_file);
        header('Content-Type: '.$sz['mime']);
        header('Content-Disposition: attachment; filename="'.$photo_data['nm'].'.'.$ext.'"');
        switch($ext)
        {
        	default:
        	case 'jpg':
        	case 'jpeg':
        	  imagejpeg($img);
        	break;
        	case 'gif':
        	  imagegif($img);
        	break;
        	case 'png':
        	  imagepng($img);
        	break;
        }
        imagedestroy($img);
        unlink($local_file);
        mysql_query('update download_photo set downloads = downloads + 1 where id = '.$data['id']);
      }
      else
      {
        err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=001)', 'index.php');
      }
    }
  }

}

mysql_close();
?>
