<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 14.10.13
 * Time: 1:10
 * To change this template use File | Settings | File Templates.
 */

       /**
       ������������ FTP �����
       @author - Jurii
       @date   - 20.04.13
       @time   - 10:44
        */
?>
       <script type="text/javascript">
              $(function () {
                     sendFtp();
              });
       </script>

<?

       // �������, �������������� ���������� ������ $dir
       function get_ftp_size($ftp_handle, $dir, $global_size = 0) {

              $file_list = ftp_rawlist($ftp_handle, $dir);
              if (!empty($file_list)) {
                     foreach ($file_list as $file) {
                            // ��������� ������ �� ���������� ��������
                            list($acc, $bloks, $group, $user, $size, $month, $day, $year, $file) = preg_split("/[\s]+/", $file);
                            // ���� ����� ���� ����, ������������ ���
                            $global_size++;
                     }
              }

              return $global_size;
       }



       function hardFlush($proc, $id, $remote_file) {

              echo '<script type="text/javascript">';
              echo'window.parent.document.getElementById("'.$id.'bar").innerHTML="<div class=\'progress progress-danger\'><div class=\'bar\' style=\'width: '.$proc.'%;\'>'
                  .$proc.'%</div></div>";';
              echo 'window.parent.document.getElementById("'.$id.'").innerHTML="����: '.$remote_file.'";';
              echo '</script>';
              //	   ob_end_flush();
              ob_flush();
              flush();
       }

       function sendtext($out, $id, $bar) {

              echo '<script type="text/javascript">';
              echo 'window.parent.document.getElementById("'.$id.$bar.'").innerHTML="'.$out.'";';
              echo '</script>';
       }

       function senderror($out, $id, $err) {

              echo '<script type="text/javascript">';
              echo 'window.parent.document.getElementById("'.$id.'err").innerHTML="'.$out.'";';
              echo '</script>';
       }

       // ������� ��� ������������ ��������� � �������� ����������:
       function ftp_is_dir($folder) {

              $file_parts = explode('.', $folder); //��������� ��� ����� � ��������� ��� � ������
              $ext        = strtolower(array_pop($file_parts)); //��������� �������� - ��� ����������
              if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                     return 'true';
              } else {
                     return 'false';
              }
       }


       // �������� ������
       if (isset($_POST['go_add'])) {
              if (isset($_FILES['filedata']) && $_FILES['filedata']['size'] != 0) {
                     if ($_FILES['filedata']['size'] < 1024 * 15 * 1024) {
                            $ext         = strtolower(substr($_FILES['filedata']['name'], 1 + strrpos($_FILES['filedata']['name'], ".")));
                            $nm          = trim($_POST['nm']); // �������� �������
                            $descr       = trim($_POST['descr']); // ��������
                            $foto_folder = trim($_POST['foto_folder']); // ���������� � ���������
                            $id_category = intval($_POST['id_category']); // ���������
                            if (empty($nm)) {
                                   $nm = '��� �����';
                            }
                            try {
                                   $id_album = go\DB\query('insert into `albums` (nm) VALUES (?string)', array($nm), 'id');
                            }
                            catch (go\DB\Exceptions\Exception $e) {
                                   die('������ ��� ������ � ����� ������');
                            }
                            go\DB\query('insert into `accordions` (id_album,collapse_numer,collapse_nm,accordion_nm) VALUES (?scalar,?i,?string,?string)',
                                   array($id_album, '1', 'default', 'default'));

                            /** �������� �������� ---------------------------------------------------------------------------------------- */
                            $sImage = new fileapi_uploadImg();
                            $newThumbName = 'id'.$id_album.'.'.$ext;
                            $array         = array(
                            "_FILESname"   => 'filedata', // ��� ������������ ����� � ������� $_FILES
                            "newThumbName" => $newThumbName, // ��� ��������� �����
                            "upload_dir"   => './../images/', // ����� ��� ��������
                            "maxThumbSize" => 200, // ������ �������� ��������
                            );
                            if($sImage->set($array)){
                                   go\DB\query('update albums set id_category = ?i, img = ?, order_field = ?i, descr = ?, foto_folder = ? where id = ?i',
                                   array($id_category, $newThumbName, $id_album, $descr, $foto_folder, $id_album));
                                   mkdir('../'.$foto_folder.$id_album, 0777, true) or die($php_errormsg);
                                   $_SESSION['current_album'] = $id_album;
                                   $_SESSION['current_cat']   = $id_category;
                            } else {
                                   go\DB\query('delete from albums where id ?i', array($id_album));
                                   die('�� ���� ��������� ����');
                            }
                            /** �������� �������� ---------------------------------------------------------------------------------------- */

                     } else {
                            dump_r('������ ����� ��������� 15 ��������');
                     }
              } else {
                     dump_r('����� ����!');
              }
       }



       /*
       Todo    - go_edit_name
        */
       if (isset($_POST['go_edit_name'])) {
              $id = $_POST['go_edit_name'];
              $nm = $_POST['nm'];
              if (empty($nm)) {
                     $nm = '-----';
              }
              go\DB\query('update albums set nm = ? where id = ?i', array($nm, $id));
       }




       if (isset($_POST['go_edit_descr'])) {
              $id    = $_POST['go_edit_descr'];
              $descr = $_POST['descr'];
              go\DB\query('update albums set descr = ? where id = ?i', array($descr, $id));
       }




       if (isset($_POST['go_edit_nastr'])) {
              $watermark    = isset($_REQUEST['watermark']);
              $ip_marker    = isset($_REQUEST['ip_marker']);
              $sharping     = isset($_REQUEST['sharping']);
              $quality      = $_POST['quality'];
              $id           = $_POST['go_edit_nastr'];
              $price        = $_POST['price'];
              $pecat        = $_POST['pecat'];
              $pecat_A4     = $_POST['pecat_A4'];
              $id_category  = $_POST['id_category'];
              $pass         = $_POST['pass'];
              $ftp_folder   = $_POST['ftp_folder'];
              $foto_folder  = $_POST['foto_folder'];
              $vote_price   = $_POST['vote_price'];
              $vote_time    = $_POST['vote_time'];
              $vote_time_on = isset($_REQUEST['vote_time_on']);
              $event        = (isset($_POST['event']) == 'on') ? 'on' : 'off';
              $on_off       = (isset($_POST['on_off']) == 'on') ? 'on' : 'off';
              go\DB\query('update albums set
		price = ?f,
		pecat = ?f,
		pecat_A4 = ?f,
		id_category = ?i,
		pass = ?string,
		quality = ?i,
		ftp_folder = ?string,
		foto_folder = ?string,
		watermark = ?b,
		ip_marker = ?b,
		sharping = ?b,
		vote_price = ?f,
		vote_time = ?i,
		vote_time_on = ?b,
		event = ?,
		on_off = ?  where
		id = ?i',
                     array(
                          $price,
                          $pecat,
                          $pecat_A4,
                          $id_category,
                          $pass,
                          $quality,
                          $ftp_folder,
                          $foto_folder,
                          $watermark,
                          $ip_marker,
                          $sharping,
                          $vote_price,
                          $vote_time,
                          $vote_time_on,
                          $event,
                          $on_off,
                          $id
                     ));
              go\DB\query('update photos set price = ?f, pecat = ?f, pecat_A4 = ?f where id_album = ?i', array($price, $pecat, $pecat_A4, $id));
              $_SESSION['current_album'] = $id;
              $_SESSION['current_cat']   = $id_category;
              debugHC(array(
                           "price"        => $price,
                           "pecat"        => $pecat,
                           "pecat_A4"     => $pecat_A4,
                           "id_category"  => $id_category,
                           "pass"         => $pass,
                           "quality"      => $quality,
                           "ftp_folder"   => $ftp_folder,
                           "foto_folder"  => $foto_folder,
                           "watermark"    => $watermark,
                           "ip_marker"    => $ip_marker,
                           "sharping"     => $sharping,
                           "vote_price"   => $vote_price,
                           "vote_time"    => $vote_time,
                           "vote_time_on" => $vote_time_on,
                           "event"        => $event,
                           "on_off"       => $on_off,
                           "id"           => $id
                      ), '���������', '/canon68452/album.php');
       }

       /*
         Todo    go_ftp_upload
         @author - Jurii
         @date   - 14.04.13
         @time   - 14:29
       */
if (isset($_POST['go_ftp_upload'])) {
       $id         = $_POST['go_ftp_upload'];
       $album_data = go\DB\query('select * from albums where id = ?i', array($id), 'row');
if ($album_data) {
       //�������� ������ �� ������� � ��������� FTP-�������
       $ftp_host = get_param('ftp_host', 0);
       $ftp_user = get_param('ftp_user', 0);
       $ftp_pass = get_param('ftp_pass', 0);
       // mysql_set_charset("utf8");
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
              $out = "<div class='alert alert-error'>�������� ����� ��� ���� ftp �������!'<br></div>";
              senderror($out, $id, '');
              die('�������� ����� ��� ���� ftp �������!');
       }
       //���������
       if (!ftp_login($ftp, $ftp_user, $ftp_pass)) {
              ftp_close($ftp);
              $out = "<div class='alert alert-error'>�������� ����� ��� ������ ��� FTP �������!<br></div>";
              senderror($out, $id, '');
              die('�������� ����� ��� ������ ��� FTP �������!');
       }
       ftp_pasv($ftp, true);
       if (ftp_chdir($ftp, $album_data['ftp_folder'])) {
              ftp_chdir($ftp, $album_data['ftp_folder']);
       }
       //�������� ������ ������ � �����
       $file_list    = ftp_nlist($ftp, $album_data['ftp_folder']);
       $fileListSort = array_multisort($file_list);
       //var_dump($file_list);
       //echo '����� ftp: <br><pre>', print_r($file_list,1), '</pre>';
       if ($fileListSort == false) {
              ftp_close($ftp);
              $out =
                     "<div class='alert alert-error'>�����: $album_data[ftp_folder] ������� �� �����!<br>��������� ����!</div>";
              senderror($out, $id, '');
              die ('����������  '.$album_data['ftp_folder'].' �� ����������! <br>');
       }
       //var_dump($file_list);
       //echo '����� ftp: <br><pre>', print_r($file_list,1), '</pre>';
       // ���� ���������� �� ����� ����? ������ ������ ������ � FTP!
       if (!count($file_list)) {
              $out = "<div class='alert alert-error'>�������� �� FTP ����� : $album_data[ftp_folder] �� �������� �����������!</div>";
              senderror($out, $id, '');
              echo '������ ��������� ������ ������!';
              echo '<br> ����� FTP - File List: <br><pre>', print_r($file_list, 1), '</pre>';
              ftp_close($ftp);
              die('��� �������� �� FTP ����� : " '.$album_data['ftp_folder'].' " - ������!');
       }
       $local_dir = $_SERVER['DOCUMENT_ROOT'].'/tmp/';
       // ���������� ������ � �����
       $pload = 100 / (get_ftp_size($ftp, $album_data['ftp_folder']));
       $proc  = 0;
       $all   = 0;
       //			ob_start();
       //���������� �����, ���������� � ������������ �� ������
foreach ($file_list as $remote_file) {
       //���
       $remote_file_old = $remote_file;
       $remote_file     = iconv('utf-8', 'cp1251', $remote_file);
       //var_dump($remote_file);
       // �����
       $proc = $proc + $pload;
       hardFlush((int)$proc, $id, basename($remote_file));
       $f_name = substr($remote_file, strrpos($remote_file, '/') + 1);
if (ftp_is_dir($f_name) == 'true') // �������� �� ���������� � �� �������:
{
       //��������� ����
       $local_file = $local_dir.$f_name;
       //���� �� FTP
       //$remote_file = $album_data['ftp_folder'].$remote_file;
       //var_dump($ftp,$f_name);
       if (!ftp_get($ftp, $local_file, $remote_file_old, FTP_BINARY)) {
              ftp_close($ftp);
              $out =
                     "<div class='alert alert-error'>�� ���� ��������� ����: $remote_file -> $local_file  </div> ";
              senderror($out, $id, '');
              die('�� ���� ��������� ����: '.$remote_file.' -> '.$local_file);
       }
       //������� ������ � ��
       $nm           = substr($f_name, 0, strrpos($f_name, '.'));
       $id_photo     = go\DB\query('insert into photos (id_album, nm) values (?i,?string)',
              array($album_data['id'], $nm), 'id');
       $tmp_name     = 'id'.$id_photo.'.jpg';
       $foto_folder  = $album_data['foto_folder'];
       $album_folder = $album_data['id'];
       //$watermark = $album_data['watermark'];
       $watermark = 0;
       //$ip_marker = $album_data['ip_marker'];
       $ip_marker   = 0;
       $sharping    = $album_data['sharping'];
       $target_name = $_SERVER['DOCUMENT_ROOT'].$foto_folder.$album_folder.'/'.$tmp_name;
       $quality     = $album_data['quality'];
if (imageresize($target_name,
       $local_file,
       /*	600,
         450, */
       700,
       500,
       $quality,
       $watermark,
       $ip_marker,
       $sharping) == 'true'
) {
       unlink($local_file);
       go\DB\query("update photos set img = ?string, price = ?scalar, ftp_path = ?string where id = ?i",
              array($tmp_name, $album_data['price'], $remote_file, $id_photo));
} else {
       unlink($local_file);
       go\DB\query('delete from photos where id = ?i', array($id_photo));
       echo ('���� �� FTP'.$remote_file.' - �����!'); ?><br><?php;
       $all--;
}
} else {
       echo ($remote_file.'  - ��� ����� ��� ���������������� ����!');
       $out =
              "<div class='alert alert-error'>$remote_file - ��� ����� ��� ���������������� ����!<br></div>";
       senderror($out, $id, '');
       @unlink($local_file);
       $all--;
}
       //   }
       $all++;
}
       ftp_close($ftp);
       $out = "<div class='alert alert-info'>���������� $all ����������.</div>";
       sendtext($out, $id, '');
       $out = '';
       sendtext($out, $id, 'bar');
}
}
}

       if (isset($_POST['go_updown'])) {
              $swap_id       = 0;
              $swap_order    = 0;
              $id            = $_POST['go_updown'];
              $current_order = go\DB\query('select order_field from albums where id = ?i', array($id), 'el');
              if ($current_order) {
                     if (isset($_POST['up'])) {
                            $rs =
                                   go\DB\query('select id, order_field from albums where order_field < ?i order by order_field desc limit 0, 1',
                                          array($current_order),
                                          'row');
                     } else {
                            $rs =
                                   go\DB\query('select id, order_field from albums where order_field > ?i order by order_field asc limit 0, 1',
                                          array($current_order),
                                          'row');
                     }
                     if ($rs) {
                            $swap_id    = intval($rs['id']);
                            $swap_order = intval($rs['order_field']);
                     }
              }
              if ($current_order > 0 && $swap_id > 0) {
                     go\DB\query('update albums set order_field = ?i where id = ?i', array($current_order, $swap_id));
                     go\DB\query('update albums set order_field = ?i where id = ?i', array($swap_order, $id));
              }
       }