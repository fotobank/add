<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 09.08.13
        * Time: 15:35
        * To change this template use File | Settings | File Templates.
        */

       require_once __DIR__.'/../alex/fotobank/Framework/Boot/config.php';

       if (!isset($_SESSION['logged'])) {
              err_exit('��� ���������� ���� ���������� ������������ �� �����!');
       }
       if (!isset($_GET['key'])) {
              err_exit('���� �� ������!');
       }
       $key = $_GET['key'];
       $rs  = go\DB\query('select * from download_photo where download_key = ?string', array($key), 'row');
       if (!$rs) {
              err_exit('���� �� ������!');
       } else {
              $data = $rs;
              if ((time() - (int)$data['dt_start'] > 172800) && (int)$data['downloads'] > 0) {
                     //����������������� ��������� ������, ���� ���� ������� ������������ ������ � ����
                     //go\DB\query('delete from download_photo where id = ?',array($data['id']));
                     err_exit('����� � 48 ����� ��� ���������� ���� ������!');
              } else {
                     $rs = go\DB\query('select * from photos where id = ?i', array($data['id_photo']), 'row');
                     if (!$rs) {
                            err_exit('���������� �� �������!');
                     } else {
                            $photo_data = $rs;
                            $ftp_host   = get_param('ftp_host', 0);
                            $ftp_user   = get_param('ftp_user', 0);
                            $ftp_pass   = get_param('ftp_pass', 0);
                            if ($ftp_host && $ftp_user && $ftp_pass) {
                                   //���� � ����� ������������ ���� - ������� ���
                                   if (strstr($ftp_host, ':')) {
                                          $ftp_port = substr($ftp_host, strpos($ftp_host, ':') + 1);
                                          $ftp_host = substr($ftp_host, 0, strpos($ftp_host, ':'));
                                   } else {
                                          $ftp_port = 21;
                                   }
                                   //�����������
                                   $ftp = ftp_connect($ftp_host, $ftp_port);
                                   if (!$ftp) {
                                          //		var_dump ($ftp);
                                          err_exit('���������� ����������! ���������� � ������������� ������� (ERR=002)');
                                   }
                                   if (!ftp_login($ftp, $ftp_user, $ftp_pass)) {
                                          ftp_close($ftp);
                                          err_exit('���������� ����������! ���������� � ������������� ������� (ERR=003)');
                                   }
                                   $remote_file = $photo_data['ftp_path'];
                                   $f_name      = substr($remote_file, strrpos($remote_file, '/') + 1);
                                   $f_name      = iconv('utf-8', 'cp1251', $f_name);
                                   $ext         = strtolower(substr($f_name, strrpos($f_name, '.') + 1));
                                   $local_file  = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$f_name;
                                   if (!ftp_get($ftp, $local_file, $remote_file, FTP_BINARY)) {
                                          err_exit('���������� ����������! ���������� � ������������� ������� (ERR=004)');
                                   }
                                   switch ($ext) {
                                          default:
                                          case 'jpg':
                                          case 'jpeg':
                                                 $img = imagecreatefromjpeg($local_file);
                                                 break;
                                          case 'gif':
                                                 $img = imagecreatefromgif($local_file);
                                                 break;
                                          case 'png':
                                                 $img = imagecreatefrompng($local_file);
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
                                   err_exit('���������� ����������! ���������� � ������������� ������� (ERR=001)');
                            }
                     }
              }

       }
       go\DB\Storage::getInstance()->get()->close();
