<?php
include (dirname(__FILE__).'/inc/config.php');
include (dirname(__FILE__).'/inc/func.php');

if(!isset($_SESSION['logged']))
  err_exit('Для скачивания фото необходимо залогиниться на сайте!');
if(!isset($_GET['key']))
  err_exit('Ключ не найден!');
$key = $_GET['key'];
$rs = $db->query('select * from download_photo where download_key = ?string', array($key), 'row');
if(!$rs)
{
  err_exit('Ключ не найден!');
}
else
{
  $data = $rs;
  if((time() - intval($data['dt_start']) > 172800) && intval($data['downloads']) > 0)
  {
  	//Раскомментировать следующую строку, если надо удалять просроченные записи о фото
  	//$db->query('delete from download_photo where id = ?',array($data['id']));
  	err_exit('Лимит в 48 часов для скачивания фото прошел!');
  }
  else
  {
    $rs = $db->query('select * from photos where id = ?i', array($data['id_photo']), 'row');
    if(!$rs)
    {
      err_exit('Фотография не найдена!');
    }
    else
    {
      $photo_data = $rs;
      $ftp_host = get_param('ftp_host',0);
      $ftp_user = get_param('ftp_user',0);
      $ftp_pass = get_param('ftp_pass',0);
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
//		var_dump ($ftp);
         err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=002)');
        }
        if(!ftp_login($ftp, $ftp_user, $ftp_pass))
        {
        	ftp_close($ftp);
          err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=003)');
        }
    		$remote_file = $photo_data['ftp_path'];
    		$f_name = substr($remote_file, strrpos($remote_file, '/') + 1);								   
         $f_name = iconv('utf-8', 'cp1251', $f_name);
         $ext = strtolower(substr($f_name, strrpos($f_name, '.') + 1));
    		$local_file = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$f_name;
    	if(!ftp_get($ftp, $local_file, $remote_file, FTP_BINARY))
          err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=004)');
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
	      $db->query('update download_photo set downloads = downloads + 1 where id = ?i', array($data['id']));
      }
      else
      {
        err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=001)');
      }
    }
  }

}
$db->close();
?>