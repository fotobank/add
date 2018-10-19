<?php
       define('ROOT_PATH', realpath(__DIR__).'/', true);
       include ROOT_PATH.'alex/fotobank/Framework/Boot/config.php';

       /**
        * @param        $filepath
        * @param string $mimetype
        *
        * $filepath &ndash; путь к файлу, который мы хотим отдать
        * $mimetype &ndash; тип отдаваемых данных (можно не менять)
        */
       function func_download_file($filepath, $mimetype = 'application/octet-stream') {

              $fsize = filesize($filepath); // берем размер файла
              $ftime = date('D, d M Y H:i:s T', filemtime($filepath)); // определяем дату его модификации
              $fd = @fopen($filepath, 'rb'); // открываем файл на чтение в бинарном режиме
              if (isset($_SERVER['HTTP_RANGE'])) { // поддерживается ли докачка?
                     $range = $_SERVER['HTTP_RANGE']; // определяем, с какого байта скачивать файл
                     $range = str_replace('bytes=', '', $range);
                     list($range, $end) = explode('-', $range);
                     if (!empty($range)) {
                            fseek($fd, $range);
                     }
              } else { // докачка не поддерживается
                     $range = 0;
              }
              if ($range) {
                     header($_SERVER['SERVER_PROTOCOL'].' 206 Partial Content'); // говорим браузеру, что это часть какого-то контента
              } else {
                     header($_SERVER['SERVER_PROTOCOL'].' 200 OK'); // стандартный ответ браузеру
              }
              // прочие заголовки, необходимые для правильной работы
              header('Content-Disposition: attachment; filename='.basename($filepath));
              header('Last-Modified: '.$ftime);
              header('Accept-Ranges: bytes');
              header('Content-Length: '.($fsize - $range));
              if ($range) {
                     header("Content-Range: bytes $range-".($fsize - 1).'/'.$fsize);
              }
              header('Content-Type: '.$mimetype);
              fpassthru($fd); // отдаем часть файла в браузер (программу докачки)
              fclose($fd);
              exit;
       }

       if (!isset($_SESSION['logged'])) {
              err_exit('Для скачивания фото необходимо залогиниться на сайте!');
       }
       if (!isset($_GET['key'])) {
              err_exit('Ключ не найден!');
       }
       $key = $_GET['key'];
       $rs  = go\DB\query('select * from download_photo where download_key = ?string', array($key), 'row');
       if (!$rs) {
              err_exit('Ключ не найден!');
       } else {
              $data = $rs;
              if ((time() - intval($data['dt_start']) > 172800) && intval($data['downloads']) > 0) {
                     //Раскомментировать следующую строку, если надо удалять просроченные записи о фото
                     //go\DB\query('delete from download_photo where id = ?',array($data['id']));
                     err_exit('Лимит в 48 часов для скачивания фото прошел!');
              } else {
                     $rs = go\DB\query('select * from photos where id = ?i', array($data['id_photo']), 'row');
                     if (!$rs) {
                            err_exit('Фотография не найдена!');
                     } else {
                            $photo_data = $rs;
                            $ftp_host   = get_param('ftp_host', 0);
                            $ftp_user   = get_param('ftp_user', 0);
                            $ftp_pass   = get_param('ftp_pass', 0);
                            if ($ftp_host && $ftp_user && $ftp_pass) {
                                   //Если в хосте присутствует порт - выделим его
                                   if (strstr($ftp_host, ':')) {
                                          $ftp_port = substr($ftp_host, strpos($ftp_host, ':') + 1);
                                          $ftp_host = substr($ftp_host, 0, strpos($ftp_host, ':'));
                                   } else {
                                          $ftp_port = 21;
                                   }
                                   //Соединяемся
                                   $ftp = ftp_connect($ftp_host, $ftp_port);
                                   if (!$ftp) {
                                          //		var_dump ($ftp);
                                          err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=002)');
                                   }
                                   if (!ftp_login($ftp, $ftp_user, $ftp_pass)) {
                                          ftp_close($ftp);
                                          err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=003)');
                                   }
                                   $remote_file = $photo_data['ftp_path'];
                                   $f_name      = substr($remote_file, strrpos($remote_file, '/') + 1);
                                   $f_name      = iconv('utf-8', 'cp1251', $f_name);
                                   $ext         = strtolower(substr($f_name, strrpos($f_name, '.') + 1));
                                   $local_file  = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$f_name;
                                   if (!ftp_get($ftp, $local_file, $remote_file, FTP_BINARY)) {
                                          err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=004)');
                                   }
                                   switch ($ext) {
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
                                   switch ($ext) {
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
                                   go\DB\query('update download_photo set downloads = downloads + 1 where id = ?i', array($data['id']));
                            } else {
                                   err_exit('Фотография недоступна! Обратитесь к администрации сервиса (ERR=001)');
                            }
                     }
              }

       }
       go\DB\Storage::getInstance()->get()->close();
