<?php
       define('ROOT_PATH', realpath(__DIR__).'/', true);
       require ROOT_PATH.'alex/fotobank/Framework/Boot/config.php';
       require ROOT_PATH.'inc/i_resize.php';
       if (isset($_GET['num'])) {
              $number = (int)$_GET['num'];
              if ($number) {
                     $file = 'id'.$number.'.jpg';
                     $rs   = go\DB\query('SELECT a.*, p.id_album FROM albums a, photos p WHERE p.img = ? && p.id_album = a.id LIMIT 1',
                                         [$file], 'row');
                     if (is_array($rs)) {
                            $foto_folder = $rs['foto_folder'];
                            $watermark   = $rs['watermark'];
                            $ip_marker   = $rs['ip_marker'];
                            $sharping    = $rs['sharping'];
                            $quality     = $rs['quality'];
                            $dir_name    = $foto_folder.$rs['id'].'/';
                            $file_in     = substr($dir_name, 1).$file;
                            if ($watermark === '1' || $ip_marker === '1') {
                                   //     $temp_out = tempnam(sys_get_temp_dir(), 'foto');
                                   $temp_out = tempnam(session_save_path(), 'foto');
                                   imageresize($temp_out, $file_in, 600, 450, $quality, $watermark, $ip_marker,
                                               $sharping);
                                   if (is_file($temp_out)) {
                                          header('Content-type: image/jpg');
                                          readfile($temp_out);
                                          @unlink($temp_out);
                                   }
                            } else {
                                   header('Content-type: image/jpg');
                                   readfile($file_in);
                            }
                     } else {
                            header('Content-type: image/gif');
                            $foto_err = 'img/eror404.gif';
                            readfile($foto_err);
                     }
                     exit();
              }
       }
