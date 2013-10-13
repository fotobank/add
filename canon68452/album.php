<?php
if (!isset($_SESSION['admin_logged'])) {
       die();
}
require_once (__DIR__.'/../inc/i_resize.php');


/**
сканирование FTP папок
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

// Функция, подсчитывающая количество файлов $dir
function get_ftp_size($ftp_handle, $dir, $global_size = 0) {

       $file_list = ftp_rawlist($ftp_handle, $dir);
       if (!empty($file_list)) {
              foreach ($file_list as $file) {
                     // Разбиваем строку по пробельным символам
                     list($acc, $bloks, $group, $user, $size, $month, $day, $year, $file) = preg_split("/[\s]+/", $file);
                     // Если перед нами файл, подсчитываем его
                     $global_size++;
              }
       }

       return $global_size;
}



function hardFlush($proc, $id, $remote_file) {

       echo '<script type="text/javascript">';
       echo'window.parent.document.getElementById("'.$id.'bar").innerHTML="<div class=\'progress progress-danger\'><div class=\'bar\' style=\'width: '.$proc.'%;\'>'
           .$proc.'%</div></div>";';
       echo 'window.parent.document.getElementById("'.$id.'").innerHTML="файл: '.$remote_file.'";';
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

// Функция для отбрасывания каталогов и ненужных расширений:
function ftp_is_dir($folder) {

       $file_parts = explode('.', $folder); //разделить имя файла и поместить его в массив
       $ext        = strtolower(array_pop($file_parts)); //последний элеменет - это расширение
       if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
              return 'true';
       } else {
              return 'false';
       }
}


// добавить альбом
if (isset($_POST['go_add'])) {
       if (isset($_FILES['image_file']) && $_FILES['image_file']['size'] != 0) {
              if ($_FILES['image_file']['size'] < 1024 * 15 * 1024) {
                     $ext         = strtolower(substr($_FILES['image_file']['name'], 1 + strrpos($_FILES['image_file']['name'], ".")));
                     $nm          = trim($_POST['nm']);
                     $descr       = trim($_POST['descr']);
                     $foto_folder = trim($_POST['foto_folder']);
                     $id_category = trim($_POST['id_category']);
                     if (empty($nm)) {
                            $nm = 'Без имени';
                     }
                     try {
                            $id_album = go\DB\query('insert into `albums` (nm) VALUES (?string)', array($nm), 'id');
                     }
                     catch (go\DB\Exceptions\Exception $e) {
                            die('Ошибка при работе с базой данных');
                     }
                     go\DB\query('insert into `accordions` (id_album,collapse_numer,collapse_nm,accordion_nm) VALUES (?scalar,?i,?string,?string)',
                            array($id_album, '1', 'default', 'default'));
                     // загрузка картинки
                     if (isset($_POST['filedim'])) {
                            require_once  (__DIR__.'/../inc/cropUploader/thumbUploader.php');
                            $newThumbName = 'id'.$id_album.'.'.$ext;
                            $data         = array(
                                   "newThumbName" => $newThumbName, // имя конечного файла
                                   "upload_dir"   => './../images/', // папка для загрузки
                                   "width_load"   => 460, // ширина превью картинки при выборе
                                   "maxThumbSize" => 160, // ширина конечной картинки
                            );
                            if ($sImage = new ImageUploader($data)) {
                                   $sImage->upload();
                                   go\DB\query('update albums set id_category = ?i, img = ?, order_field = ?i, descr = ?, foto_folder = ? where id = ?i',
                                          array($id_category, $newThumbName, $id_album, $descr, $foto_folder, $id_album));
                                   mkdir('../'.$foto_folder.$id_album, 0777, true) or die($php_errormsg);
                                   $_SESSION['current_album'] = $id_album;
                                   $_SESSION['current_cat']   = $id_category;
                            } else {
                                   go\DB\query('delete from albums where id ?i', array($id_album));
                                   die('Не могу загрузить файл');
                            }
                     }
              } else {
                     //	  unlink($file_load);
                     die('Размер файла превышает 15 мегабайт');
              }
       } else {
              //   unlink($file_load);
              die('Битый файл!');
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
               ), 'Сохранить', '/canon68452/album.php');
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
              //Выбираем данные по альбому и настройки FTP-сервера
              $ftp_host = get_param('ftp_host', 0);
              $ftp_user = get_param('ftp_user', 0);
              $ftp_pass = get_param('ftp_pass', 0);
              // mysql_set_charset("utf8");
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
                            $out = "<div class='alert alert-error'>Неверный адрес или порт ftp сервера!'<br></div>";
                            senderror($out, $id, '');
                            die('Неверный адрес или порт ftp сервера!');
                     }
                     //Логинимся
                     if (!ftp_login($ftp, $ftp_user, $ftp_pass)) {
                            ftp_close($ftp);
                            $out = "<div class='alert alert-error'>Неверный логин или пароль для FTP сервера!<br></div>";
                            senderror($out, $id, '');
                            die('Неверный логин или пароль для FTP сервера!');
                     }
                     ftp_pasv($ftp, true);
                     if (ftp_chdir($ftp, $album_data['ftp_folder'])) {
                            ftp_chdir($ftp, $album_data['ftp_folder']);
                     }
                     //Получаем список файлов в папке
                     $file_list    = ftp_nlist($ftp, $album_data['ftp_folder']);
                     $fileListSort = array_multisort($file_list);
                     //var_dump($file_list);
                     //echo 'Ответ ftp: <br><pre>', print_r($file_list,1), '</pre>';
                     if ($fileListSort == false) {
                            ftp_close($ftp);
                            $out =
                                   "<div class='alert alert-error'>Папка: $album_data[ftp_folder] заданна не верно!<br>Проверьте путь!</div>";
                            senderror($out, $id, '');
                            die ('Директория  '.$album_data['ftp_folder'].' не существует! <br>');
                     }
                     //var_dump($file_list);
                     //echo 'Ответ ftp: <br><pre>', print_r($file_list,1), '</pre>';
                     // Файл существует на самом деле? Пустой список файлов с FTP!
                     if (!count($file_list)) {
                            $out = "<div class='alert alert-error'>Заданная на FTP папка : $album_data[ftp_folder] не содержит изображений!</div>";
                            senderror($out, $id, '');
                            echo 'Список доступных файлов пустой!';
                            echo '<br> ответ FTP - File List: <br><pre>', print_r($file_list, 1), '</pre>';
                            ftp_close($ftp);
                            die('Или заданная на FTP папка : " '.$album_data['ftp_folder'].' " - пустая!');
                     }
                     $local_dir = $_SERVER['DOCUMENT_ROOT'].'/tmp/';
                     // количество файлов в папке
                     $pload = 100 / (get_ftp_size($ftp, $album_data['ftp_folder']));
                     $proc  = 0;
                     $all   = 0;
                     //			ob_start();
                     //Перебираем файлы, закачиваем и обрабатываем по одному
                     foreach ($file_list as $remote_file) {
                            //Имя
                            $remote_file_old = $remote_file;
                            $remote_file     = iconv('utf-8', 'cp1251', $remote_file);
                            //var_dump($remote_file);
                            // шкала
                            $proc = $proc + $pload;
                            hardFlush((int)$proc, $id, basename($remote_file));
                            $f_name = substr($remote_file, strrpos($remote_file, '/') + 1);
                            if (ftp_is_dir($f_name) == 'true') // проверка на расширение и на каталог:
                            {
                                   //Локальный файл
                                   $local_file = $local_dir.$f_name;
                                   //Фаил на FTP
                                   //$remote_file = $album_data['ftp_folder'].$remote_file;
                                   //var_dump($ftp,$f_name);
                                   if (!ftp_get($ftp, $local_file, $remote_file_old, FTP_BINARY)) {
                                          ftp_close($ftp);
                                          $out =
                                                 "<div class='alert alert-error'>Не могу загрузить файл: $remote_file -> $local_file  </div> ";
                                          senderror($out, $id, '');
                                          die('Не могу загрузить файл: '.$remote_file.' -> '.$local_file);
                                   }
                                   //Создаем запись в БД
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
                                          echo ('Файл на FTP'.$remote_file.' - битый!'); ?><br><?php;
                                          $all--;
                                   }
                            } else {
                                   echo ($remote_file.'  - это папка или неподдерживаемый файл!');
                                   $out =
                                          "<div class='alert alert-error'>$remote_file - это папка или неподдерживаемый файл!<br></div>";
                                   senderror($out, $id, '');
                                   @unlink($local_file);
                                   $all--;
                            }
                            //   }
                            $all++;
                     }
                     ftp_close($ftp);
                     $out = "<div class='alert alert-info'>Загруженно $all фотографий.</div>";
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


?>

<div style="float: left;">
       <div class="slideThree">
              <input id="slideThree1"
                     type='checkbox'
                     NAME='watermark'
                     VALUE='yes'
                     <?if (isset($ln['watermark'])) {
                     echo 'checked="checked"';
              } ?> /> <label for="slideThree1"></label>
       </div>
       Включить фотобанк
</div>


<!-- создать альбом-->

<div id="long"
     class="modal hide fade in animated fadeInDown"
     tabindex="-1"
     data-replace="true"
     data-keyboard="false"
     data-backdrop="static"
     tabindex="-1"
     aria-hidden="false">
       <div class="modal-header">
              <button type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-hidden="true">x
              </button>
              <h3>Создать альбом:</h3>
       </div>
       <div class="modal-body">
              <div class="row">
                     <div class="span5 offset0">
                            <form action="index.php"
                                  method="post"
                                  enctype="multipart/form-data">
                                   <table border="0">
                                          <tr>
                                                 <td>
                                                        <div class="input-prepend">
                                                               <label class="add-on"
                                                                      for="name">Название альбома</label>
                                                               <input class="span1"
                                                                      type="text"
                                                                      id="name"
                                                                      name="nm"
                                                                      value=""
                                                                      style="width: 203px; height: 25px;"/>
                                                        </div>
                                                        <div class="input-prepend">
                                                               <label class="add-on"
                                                                      for="prependedInput">Категория</label>
                                                               <select id="prependedInput"
                                                                       name="id_category"
                                                                       class="span3 multiselect"
                                                                       style="width: 203px; height: 25px;">
                                                                      <?
                                                                      $tmp = go\DB\query('select * from `categories` order by id asc')->assoc();
                                                                      foreach ($tmp as $tmp2) {
                                                                             ?>
                                                                             <option value="<?= $tmp2['id'] ?>"
                                                                                    <?
                                                                                    if (!isset($_SESSION['id_category'])) {
                                                                                           $_SESSION['id_category'] = 1;
                                                                                    } else {
                                                                                           if ($tmp2['id'] == $_SESSION['id_category'] ? 'selected="selected"' :
                                                                                                  'el'
                                                                                           ) {
                                                                                                  ;
                                                                                           }
                                                                                    }
                                                                                    ?>><?=$tmp2['nm']?></option>
                                                                      <?
                                                                      }
                                                                      ?>
                                                               </select>
                                                        </div>
                                                        <div class="input-prepend">
                                                               <label class="add-on"
                                                                      for="foto_folder">Папка фотобанка</label>
                                                               <input class="span1"
                                                                      type="text"
                                                                      id="foto_folder"
                                                                      name="foto_folder"
                                                                      value="/images2/"
                                                                      style="width: 203px; height: 25px;"/>
                                                        </div>

                                                        <label class="add-on"
                                                               for="descr">Описание</label>
                                                        <textarea id="descr"
                                                                  style="width: 300px; height: 100px;"
                                                                  name="descr"></textarea>

                                                 </td>
                                          </tr>
                                          <tr>
                                                 <!--<td>
                                                   <div class="controls">
                                                     <div class="input-append">
                                                       <input id="appendedInputButton" class="span3" type="file" name="preview" style="width: 303px;"/>
                                                     </div>
                                                   </div>
                                                 </td>-->
                                                 <td>

                                                        <input type="hidden"
                                                               id="x1"
                                                               name="x1"/>
                                                        <input type="hidden"
                                                               id="y1"
                                                               name="y1"/>
                                                        <input type="hidden"
                                                               id="x2"
                                                               name="x2"/>
                                                        <input type="hidden"
                                                               id="y2"
                                                               name="y2"/>

                                                        <div class="input-prepend">
                                                               <label class="add-on"
                                                                      for="image_file">Превью</label>
                                                               <input type="file"
                                                                      id="image_file"
                                                                      name="image_file"
                                                                      onchange="fileSelectHandler()"/>
                                                        </div>
                                                        <div class="error"></div>
                                                        <div class="step2">
                                                               <h3>Выбор региона обрезки:</h3>
                                                               <img id="preview"
                                                                    style="width: 460px;"/>

                                                               <div class="info">
                                                                      <div class="input-prepend">
                                                                             <label class="add-on"
                                                                                    for="filesize">Размер файла</label>
                                                                             <input class="span1"
                                                                                    type="text"
                                                                                    id="filesize"
                                                                                    name="filesize"
                                                                                    style="width: 203px; height: 25px;">
                                                                      </div>
                                                                      <div class="input-prepend">
                                                                             <label class="add-on"
                                                                                    for="filetype">Тип</label>
                                                                             <input class="span1"
                                                                                    type="text"
                                                                                    id="filetype"
                                                                                    name="filetype"
                                                                                    style="width: 203px; height: 25px;">
                                                                      </div>
                                                                      <div class="input-prepend">
                                                                             <label class="add-on"
                                                                                    for="filedim">Размер изображения</label>
                                                                             <input class="span1"
                                                                                    type="text"
                                                                                    id="filedim"
                                                                                    name="filedim"
                                                                                    style="width: 203px; height: 25px;">
                                                                      </div>
                                                                      <div class="input-prepend">
                                                                             <label class="add-on"
                                                                                    for="w">W</label><input class="span1"
                                                                                                            type="text"
                                                                                                            id="w"
                                                                                                            name="w"
                                                                                                            style="width: 203px; height: 25px;">
                                                                      </div>
                                                                      <div class="input-prepend">
                                                                             <label class="add-on"
                                                                                    for="h">H</label>
                                                                             <input class="span1"
                                                                                    type="text"
                                                                                    id="h"
                                                                                    name="h"
                                                                                    style="width: 203px; height: 25px;">
                                                                      </div>

                                                               </div>
                                                        </div>
                                                 </td>
                                          </tr>

                                          <tr>
                                                 <td align="center">
                                                        <div class="linBlue"></div>
                                                        <input class="btn  btn-success"
                                                               type="hidden"
                                                               name="go_add"
                                                               value="1"/>
                                                        <input class="btn  btn-success"
                                                               type="submit"
                                                               value="Добавить"/>
                                                 </td>
                                          </tr>
                                   </table>
                            </form>
                     </div>
              </div>
       </div>
       <div class="modal-footer">
              <button type="button"
                      data-dismiss="modal"
                      class="btn">Close
              </button>
       </div>
</div>
<div class="offset2"
     style="float:left">
       <button class="btn btn-primary btn-large"
               href="#long"
               data-toggle="modal">Создать альбом
       </button>
</div>

<div class="row">
       <div class="span5 offset2">
              <p>1. Водяной знак для фотобанка и IP надпись формируется на сервере в момент <b>просмотра.</b></p>

              <p>2. Чекбос "резкость" добавляет шарпинг <b>при закачке</b> с FTP.</p>

              <p>3.Для папок <b>/два слэша/</b> обязательны.</p>

              <p>4.Перед изменением <b>папки в фотобанке</b> для закаченного альбома необходимо сначала создать папку на
                 сервере! </p>
       </div>
</div>


<?

if (isset($_POST['go_delete'])) {
       $id           = $_POST['go_delete'];
       $thumb        = trim($_POST['go_del_thumb']);
       $album_folder = $id;
       $foto_folder  = go\DB\query('select foto_folder from albums where id = ?i', array($id), 'el');
       echo "<script type='text/javascript'>
                             $(document).ready(function load() {
                             $('#static').modal('show');
                             });
                             </script>";

       ?>
       <div id="static"
            class="modal hide fade in animated fadeInDown"
            data-keyboard="false"
            data-backdrop="static"
            tabindex="-1"
            aria-hidden="false">
              <div class="modal-header">
                     <h3 style="color:red">Внимание! Удаление альбома!</h3>
              </div>
              <div class="modal-body">
                     Удалить каталог: "<?=($_SERVER['DOCUMENT_ROOT'].$foto_folder.$album_folder.$thumb)?>" ?
              </div>
              <div class="modal-footer">
                     <form action="/inc/delete_dir.php"
                           method="post">
                            <input type="hidden"
                                   name="confirm_id"
                                   value=<?= $id ?>>
                            <input type="hidden"
                                   name="thumb"
                                   value=<?= $thumb ?>>
                            <button type="submit"
                                    name="path"
                                    value=<?= ($_SERVER['DOCUMENT_ROOT'].$foto_folder.$album_folder.$thumb) ?>> ДА
                            </button>
                            <button id="noConfirm"
                                    type="submit"
                                    name="confirm_del"
                                    value=""> НЕТ
                            </button>
                     </form>
              </div>
       </div>
<?
}


if (isset($_SESSION['ok_msg']) && $_SESSION['ok_msg'] != "") {
       echo  $_SESSION['ok_msg'];
       $_SESSION['ok_msg'] = "";
}


if (isset($_POST['chenge_cat'])) {
       $_SESSION['current_cat'] = intval($_POST['id']);
}
$rs_cat = go\DB\query('select DISTINCT c.nm, c.id
  		      from categories c, albums a
  		    	where  c.id = a.id_category
  		      order by a.order_field asc')->assoc();
if ($rs_cat) {
       if (isset($_SESSION['current_cat'])) {
              $current_c = intval($_SESSION['current_cat']);
       } else {
              $current_c = 0;
       }

       ?>
       <hr/>
       <div><h3>Редактор альбомов:</h3>
       </div>
       <div><strong>Выбрать категорию:</strong> <strong style="margin-left: 300px;">Выбрать альбом:</strong>
       </div>
       <div class="controls"
            style="float:left;">
              <div class="input-append">
                     <form id="myForm1"
                           action="index.php"
                           method="post">
                            <select id="appendedInputButton"
                                    class="span3"
                                    name="id"
                                    style="height: 28px;"
                                    class="multiselect">
                                   <?
                                   foreach ($rs_cat as $ln_cat) {
                                          ?>
                                          <option value="<?= $ln_cat['id'] ?>" <?=(
                                          $current_c == $ln_cat['id'] ? 'selected="selected"' : '')?>> <?=$ln_cat['nm']?></option>
                                   <?
                                   }
                                   ?>
                            </select>
                            <input class="btn btn-success"
                                   type="hidden"
                                   name="chenge_cat"
                                   value="1"/>
                            <input class="btn btn-success"
                                   type="submit"
                                   value="открыть"/>
                     </form>
              </div>
       </div>

<?
}

if (isset($_POST['chenge_album'])) {
       $_SESSION['current_album'] = intval($_POST['id']);
}

if (isset($_SESSION['current_cat'])) {
       $rs = go\DB\query('select c.nm, a.*
  		      from categories c, albums a
  		      where  c.id = a.id_category
  		      and  a.id_category = '.intval($_SESSION['current_cat']).'
  		      order by a.order_field asc')->assoc();
       if ($rs) {
              if (isset($_SESSION['current_album'])) {
                     $current = intval($_SESSION['current_album']);
              } else {
                     $current = 0;
              }
              ?>
              <div class="controls">
                     <div class="input-append">
                            <form id="myForm2"
                                  action="index.php"
                                  method="post">
                                   <select id="appendedInputButton"
                                           class="span3"
                                           style=" margin-left: 100px; height: 28px;"
                                           name="id"
                                           class="multiselect">
                                          <?
                                          foreach ($rs as $ln) {
                                                 ?>
                                                 <option value="<?= $ln['id'] ?>" <?=(
                                                 $current == $ln['id'] ? 'selected="selected"' : '')?>> <?=$ln['nm']?></option>
                                          <?
                                          }
                                          ?>
                                   </select> <input class="btn btn-success"
                                                    type="hidden"
                                                    name="chenge_album"
                                                    value="1"/>
                                   <input class="btn  btn-success"
                                          type="submit"
                                          value="открыть"/>
                            </form>
                     </div>
              </div>

              <?
              if (isset($_SESSION['current_album'])):
                     $rs = go\DB\query('select * from albums where id = ?i', array($_SESSION['current_album']), 'assoc');
                     if ($rs) {
                            foreach ($rs as $ln) {
                                   $_SESSION['id_category'] = $ln['id_category'];
                                   ?>
                                   <div style="border-bottom: 0 none; margin-top: 20px;">
                                   <table border="0">
                                   <thead>
                                   <tr>
                                          <th style="text-align: center;"><span class="label label-important">АЛЬБОМ <?=$ln['nm']?></span></th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   <tr>
                                   <td valign="top">
                                   <table border="2">
                                   <thead>
                                   <tr>
                                          <th style="text-align: center;">настройка альбома</th>
                                          <th style="text-align: center;">текст под картинкой альбома</th>
                                          <th style="text-align: center;">настройка фотографий и FTP</th>
                                   </tr>
                                   </thead>
                                   <tr>
                                   <td align="left">
                                          <ul class="thumbnails">
                                                 <li class="span2">
                                                        <div class="thumbnail">
                                                               <img style="width: auto; height: auto;"
                                                                    src="/images/<?= $ln['img'] ?>"
                                                                    alt="-"/>

                                                               <div class="caption">
                                                                      <h3><?= $ln['nm'] ?></h3>

                                                                      <form action="index.php"
                                                                            method="post">
                                                                             <label for="appendedInputButton"></label>
                                                                             <input id="appendedInputButton"
                                                                                    type="text"
                                                                                    name="nm"
                                                                                    value="<?= $ln['nm'] ?>"
                                                                                    style="height: 22px; width: 140px; margin-bottom: 5px;  border-radius: 4px 4px 4px 4px;"/>
                                                                             <input class="btn btn-primary"
                                                                                    type="hidden"
                                                                                    name="go_edit_name"
                                                                                    value="<?= $ln['id'] ?>"/>
                                                                             <input class="btn btn-small btn-primary"
                                                                                    type="submit"
                                                                                    value="переименовать"/>
                                                                      </form>

                                                                      Папка альбома:
                                                                      "..<?=$ln['foto_folder']?><?=$ln['id']?>"
                                                                      <form action="index.php"
                                                                            method="post">
                                                                             <input class="btn btn-primary"
                                                                                    type="hidden"
                                                                                    name="go_delete"
                                                                                    value="<?= $ln['id'] ?>"/>
                                                                             <input class="btn btn-primary"
                                                                                    type="hidden"
                                                                                    name="go_del_thumb"
                                                                                    value="/"/>
                                                                             <input class="btn-small btn-danger dropdown-toggle"
                                                                                    type="submit"
                                                                                    value="удалить альбом"/>
                                                                      </form>
                                                                      Папка превьюшек:
                                                                      "..<?=$ln['foto_folder']?><?=$ln['id']?>/thumb"
                                                                      <form action="index.php"
                                                                            method="post">
                                                                             <input class="btn btn-primary"
                                                                                    type="hidden"
                                                                                    name="go_delete"
                                                                                    value="<?= $ln['id'] ?>"/>
                                                                             <input class="btn btn-primary"
                                                                                    type="hidden"
                                                                                    name="go_del_thumb"
                                                                                    value="/thumb/"/>
                                                                             <input class="btn-small btn-danger dropdown-toggle"
                                                                                    type="submit"
                                                                                    value="удалить превьюшки"/>
                                                                      </form>
                                                                      <form action="index.php"
                                                                            method="post">
                                                                             <div class="btn-toolbar">
                                                                                    <div class="btn-group">
                                                                                           <input type="hidden"
                                                                                                  name="go_updown"
                                                                                                  value="<?= $ln['id'] ?>"/>
                                                                                           <input class="btn-small btn-info"
                                                                                                  type="submit"
                                                                                                  name="up"
                                                                                                  value="поднять"
                                                                                                  style="border-radius: 4px 0 0 4px;"/>
                                                                                           <input class="btn-small btn-info"
                                                                                                  type="submit"
                                                                                                  name="down"
                                                                                                  value="опустить"
                                                                                                  style="border-radius: 0 4px 4px 0;"/>
                                                                                    </div>
                                                                             </div>
                                                                      </form>
                                                               </div>
                                                        </div>
                                                 </li>
                                          </ul>

                                   </td>
                                   <td align="center">
                                          <form action="index.php"
                                                method="post">
                                                 <label>
                                                        <textarea name="descr"
                                                                  style="margin: 20px 10px 0; width: 300px; height: 200px; padding-bottom: 0;"
                                                                  name="descr">
                                                               <?=$ln['descr']?>
                                                        </textarea> </label><br/>
                                                 <input class="btn btn-primary"
                                                        type="hidden"
                                                        name="go_edit_descr"
                                                        value="<?= $ln['id'] ?>"/>
                                                 <input class="btn-small btn-primary"
                                                        type="submit"
                                                        value="сохранить"
                                                        style="margin-left: 20px;">
                                          </form>
                                   </td>
                                   <td>
                                          <table border="0">
                                                 <tr>
                                                        <td>
                                                               <form action="index.php"
                                                                     method="post"
                                                                     style="margin: 5px;">
                                                                      <table border="0">
                                                                             <tr>
                                                                                    <td>
                                                                                           <div class="input-prepend">
                                                                                                  <label for="price"
                                                                                                         class="add-on">Цена за фото (гр.):</label>
                                                                                                  <input id="price"
                                                                                                         class="span2"
                                                                                                         type="text"
                                                                                                         NAME="price"
                                                                                                         VALUE="<?= $ln['price'] ?>"/>
                                                                                           </div>
                                                                                    </td>
                                                                                    <td>
                                                                                           <div class="slideThree">
                                                                                                  <input id="slideThree2"
                                                                                                         type='checkbox'
                                                                                                         NAME='on_off'
                                                                                                         VALUE='on'
                                                                                                         <?if ($ln['on_off'] == 'on') {
                                                                                                         echo 'checked="checked"';
                                                                                                  } ?> /> <label for="slideThree2"></label>
                                                                                           </div>
                                                                                           Включить альбом
                                                                                    </td>
                                                                             </tr>
                                                                             <tr>
                                                                                    <td>
                                                                                           <div class="input-prepend">
                                                                                                  <label for="pecat"
                                                                                                         class="add-on">10x15, 13x18 (гр.):</label>
                                                                                                  <input id="pecat"
                                                                                                         class="span2"
                                                                                                         type="text"
                                                                                                         NAME="pecat"
                                                                                                         VALUE="<?= $ln['pecat'] ?>"/>
                                                                                           </div>
                                                                                    </td>
                                                                                    <td>
                                                                                           <div class="slideThree">
                                                                                                  <input id="slideThree3"
                                                                                                         type='checkbox'
                                                                                                         NAME='event'
                                                                                                         VALUE='on'
                                                                                                         <?if ($ln['event'] == 'on') {
                                                                                                         echo 'checked="checked"';
                                                                                                  } ?> /> <label for="slideThree3"></label>
                                                                                           </div>
                                                                                           Показ фотографий в альбоме
                                                                                    </td>
                                                                             </tr>
                                                                             <tr>
                                                                                    <td>
                                                                                           <div class="input-prepend">
                                                                                                  <label for="pecat_A4"
                                                                                                         class="add-on">Печать A4 (гр.):</label>
                                                                                                  <input id="pecat_A4"
                                                                                                         class="span2"
                                                                                                         type="text"
                                                                                                         NAME="pecat_A4"
                                                                                                         VALUE="<?= $ln['pecat_A4'] ?>"/>
                                                                                           </div>
                                                                                    </td>
                                                                                    <td>
                                                                                           <div class="slideThree">
                                                                                                  <input id="slideThree4"
                                                                                                         type='checkbox'
                                                                                                         NAME='watermark'
                                                                                                         VALUE='yes'
                                                                                                         <?if ($ln['watermark']) {
                                                                                                         echo 'checked="checked"';
                                                                                                  } ?> /> <label for="slideThree4"></label>
                                                                                           </div>
                                                                                           Водяной знак
                                                                                    </td>
                                                                             </tr>
                                                                             <tr>
                                                                                    <td>
                                                                                           <div class="input-prepend">
                                                                                                  <label for="quality"
                                                                                                         class="add-on">Качество .jpg (%):</label>
                                                                                                  <input id="quality"
                                                                                                         class="span2"
                                                                                                         type="text"
                                                                                                         NAME="quality"
                                                                                                         VALUE="<?= $ln['quality'] ?>"/>
                                                                                           </div>
                                                                                    </td>
                                                                                    <td>
                                                                                           <div class="slideThree">
                                                                                                  <input id="slideThree5"
                                                                                                         type='checkbox'
                                                                                                         NAME='ip_marker'
                                                                                                         VALUE='yes' <?if ($ln['ip_marker']) {
                                                                                                         echo 'checked="checked"';
                                                                                                  }?> /> <label for="slideThree5"></label>
                                                                                           </div>
                                                                                           IP надпись
                                                                                    </td>
                                                                             </tr>
                                                                             <tr>
                                                                                    <td colspan="2">
                                                                                           <div class="input-prepend">
                                                                                                  <label for="id_category"
                                                                                                         class="add-on">Категория:</label>
                                                                                                  <select id="id_category"
                                                                                                          class="multiselect"
                                                                                                          name="id_category">
                                                                                                         <?
                                                                                                         $tmp =
                                                                                                                go\DB\query('select * from `categories` order by id asc',
                                                                                                                       NULL,
                                                                                                                       'assoc');
                                                                                                         foreach ($tmp as $tmp2) {
                                                                                                                ?>
                                                                                                                <option value="<?= $tmp2['id'] ?>" <?=($tmp2['id']
                                                                                                                                                       == $ln['id_category'] ?
                                                                                                                       'selected="selected"' :
                                                                                                                       '')?>><?=$tmp2['nm']?></option>
                                                                                                         <?
                                                                                                         }
                                                                                                         ?>
                                                                                                  </select>
                                                                                           </div>
                                                                                    </td>
                                                                             </tr>
                                                                             <tr>
                                                                                    <td>
                                                                                           <div class="input-prepend">
                                                                                                  <label for="pass"
                                                                                                         class="add-on">Пароль на альбом:</label>
                                                                                                  <input id="pass"
                                                                                                         class="span2"
                                                                                                         type="text"
                                                                                                         NAME="pass"
                                                                                                         VALUE="<?= $ln['pass'] ?>"/>
                                                                                           </div>
                                                                                    </td>
                                                                             </tr>
                                                                             <tr>
                                                                                    <td>
                                                                                           <div class="input-prepend">
                                                                                                  <label for="foto_folder"
                                                                                                         class="add-on">Папка фотобанка:</label>
                                                                                                  <input id="foto_folder"
                                                                                                         class="span2"
                                                                                                         type="text"
                                                                                                         NAME="foto_folder"
                                                                                                         VALUE="<?= $ln['foto_folder'] ?>"/>
                                                                                           </div>
                                                                                    </td>
                                                                                    <td>
                                                                                           <div class="slideThree">
                                                                                                  <input id="slideThree6"
                                                                                                         type='checkbox'
                                                                                                         NAME='sharping'
                                                                                                         VALUE='yes' <?if ($ln['sharping']) {
                                                                                                         echo 'checked="checked"';
                                                                                                  }?> /> <label for="slideThree6"></label>
                                                                                           </div>
                                                                                           Добавить резкость
                                                                                    </td>
                                                                             </tr>
                                                                             <tr>
                                                                                    <td>
                                                                                           <div class="input-prepend">
                                                                                                  <label for="foto_folder"
                                                                                                         class="add-on">Цена голоса (грн.):</label>
                                                                                                  <input id="foto_folder"
                                                                                                         class="span2"
                                                                                                         type="text"
                                                                                                         NAME="vote_price"
                                                                                                         VALUE="<?= $ln['vote_price'] ?>"/>
                                                                                           </div>
                                                                                    </td>
                                                                             </tr>

                                                                             <tr>
                                                                                    <td>
                                                                                           <div class="input-prepend">
                                                                                                  <label for="foto_folder"
                                                                                                         class="add-on">t голосования
                                                                                                                        (мин):</label>
                                                                                                  <input id="foto_folder"
                                                                                                         class="span2"
                                                                                                         type="text"
                                                                                                         NAME=" vote_time"
                                                                                                         VALUE="<?= $ln['vote_time'] ?>"/>
                                                                                           </div>
                                                                                    </td>
                                                                                    <td>
                                                                                           <div class="slideThree">
                                                                                                  <input id="slideThree7"
                                                                                                         type='checkbox'
                                                                                                         NAME='vote_time_on'
                                                                                                         VALUE='yes' <?if ($ln['vote_time_on']) {
                                                                                                         echo 'checked="checked"';
                                                                                                  }?> /> <label for="slideThree7"></label>
                                                                                           </div>
                                                                                           Голосование по времени
                                                                                    </td>
                                                                             </tr>

                                                                             <tr>
                                                                                    <td colspan="2">
                                                                                           <input id="ftpFold"
                                                                                                  type="hidden"
                                                                                                  name="ftpFold"
                                                                                                  value="<?= $ln['ftp_folder'] ?>"/>

                                                                                           <div class="input-prepend">
                                                                                                  <label id='refresh'
                                                                                                         title='Обновить папки'
                                                                                                         for="upFTP"
                                                                                                         class="add-on"
                                                                                                         onclick='sendFtp();'>
                                                                                                         Папка uploada FTP:</label>
                                                                                                  <select id="upFTP"
                                                                                                          class="span3"
                                                                                                          NAME="ftp_folder">
                                                                                                         <option value="<?= $ln['ftp_folder'] ?>">Подождите идет
                                                                                                                                                  запрос данных ...
                                                                                                         </option>
                                                                                                  </select>
                                                                                           </div>
                                                                                    </td>
                                                                             </tr>
                                                                             <tr>
                                                                                    <td colspan="2"
                                                                                        align="center">
                                                                                           <input class="btn btn-primary"
                                                                                                  type="hidden"
                                                                                                  name="go_edit_nastr"
                                                                                                  value="<?= $ln['id'] ?>"/>
                                                                                           <input class="btn-small btn-primary"
                                                                                                  type="submit"
                                                                                                  value="сохранить"/>
                                                                                    </td>
                                                                             </tr>
                                                                      </table>
                                                               </form>
                                                        </td>
                                                 </tr>
                                                 <tr>
                                                        <td align="center">
                                                               <form action="index.php"
                                                                     name="go_ftp_upload"
                                                                     method="post"
                                                                     style="margin-bottom: 0;"
                                                                     target="hiddenframe"
                                                                     onsubmit="document.getElementById('<?= $ln['id'] ?>').innerHTML='Подождите, идёт загрузка...'; return true;">
                                                                      <input class="btn btn-success"
                                                                             type="hidden"
                                                                             name="go_ftp_upload"
                                                                             value="<?= $ln['id'] ?>"/>

                                                                      <div id="<?= $ln['id'] ?>"></div>
                                                                      <div id="<?= $ln['id'] ?>bar"></div>
                                                                      <div id="<?= $ln['id'] ?>err"></div>
                                                                      <input class="btn-small btn-success"
                                                                             type="submit"
                                                                             value="Добавить с FTP"/><br/>
                                                               </form>
                                                        </td>
                                                        <td>
                                                               <iframe id="hiddenframe"
                                                                       name="hiddenframe"
                                                                       style="width:0; height:0; border:0;"></iframe>
                                                        </td>
                                                 </tr>
                                          </table>
                                   </td>
                                   </tr>
                                   <tr>
                                          <td align="center"
                                              style="margin: 10px;">
                                          </td>
                                   </tr>
                                   <tr>
                                          <td align="center"
                                              style="margin: 10px;">
                                          </td>
                                   </tr>
                                   <tr>
                                          <td align="center"
                                              style="height: 30px;">

                                          </td>
                                   </tr>
                                   </table>
                                   </td>
                                   </tr>
                                   </tbody>
                                   </table>
                                   </div>
                            <?
                            }
                     }
              endif;
       }
}

/**
 * аккордеон
 */
if (isset($_POST['add_par'])) {
       $ac_nm     = $_POST['add_par'];
       $coll_name = $_POST['nm'];
       $id_album  = $_POST['id_album'];
       $coll_num  =
              (go\DB\query('select collapse_numer from accordions where id_album = ?i order by collapse_numer desc limit 1',
                     array($id_album),
                     'el')) + 1;
       go\DB\query('insert into accordions (accordion_nm,collapse_nm,id_album,collapse_numer) values (?string,?string,?i,?i)',
              array($ac_nm, $coll_name, $id_album, $coll_num));

}

if (isset($_POST['go_del'])) {
       $id_album = $_POST['go_del'];
       $coll_num = $_POST['collapse_numer'];
       go\DB\query('delete from accordions where `id_album` =?i and `collapse_numer` = ?i', array($id_album, $coll_num));
}

if (isset($_POST['go_update'])) {
       $id             = $_POST['go_update'];
       $collapse_numer = $_POST['collapse_numer'];
       $txt            = iconv('utf-8', 'cp1251', trim($_POST['txt_coll']));
       $id_album       = $_POST['go_update'];
       go\DB\query("update accordions set collapse = ?string where id_album = ?i and collapse_numer =?i ",
              array($txt, $id_album, $collapse_numer));
}

if (isset($_POST['go_edit_nm'])) {
       $id = $_POST['go_edit_nm'];
       $nm = $_POST['nm'];
       go\DB\query('update accordions set accordion_nm =? where id_album = ?i', array($nm, $id));
}

if (isset($_POST['go_edit_name_coll'])) {
       $id  = $_POST['go_edit_name_coll'];
       $nm  = $_POST['nm'];
       $num = $_POST['collapse_numer'];
       go\DB\query('update accordions set collapse_nm =? where id_album = ?i and collapse_numer =?i',
              array($nm, $id, $num));
}

if (isset($_POST['go_up_down'])) {
       $id_album = $_POST['go_up_down'];
       $id_cat   = $_POST['coll_num'];
       if (isset($_SESSION['alb_num']) && $_SESSION['alb_num'] != 1) {
              if ($id_cat > 0) {
                     if (isset($_POST['up'])) {
                            $swap_id =
                                   go\DB\query('select collapse_numer from accordions where id_album =?i and collapse_numer < ?i order by collapse_numer desc limit 0, 1',
                                          array($id_album, $id_cat),
                                          'el');
                     } else {
                            $swap_id =
                                   go\DB\query('select collapse_numer from accordions where id_album =?i and collapse_numer > ?i order by collapse_numer asc limit 0, 1',
                                          array($id_album, $id_cat),
                                          'el');
                     }
                     if (isset($swap_id) && $swap_id > 0) {
                            go\DB\query('update accordions set collapse_numer = 0 where id_album =?i and  collapse_numer = ?i',
                                   array($id_album, $swap_id));
                            go\DB\query('update accordions set collapse_numer = ?i where id_album =?i and  collapse_numer = ?i',
                                   array($swap_id, $id_album, $id_cat));
                            go\DB\query('update accordions set collapse_numer = ?i where id_album =?i and  collapse_numer = 0',
                                   array($id_cat, $id_album));
                            $_SESSION['current_kont'] = $swap_id;
                     }
              }
       }
}
?>
<div style="clear: both"></div>
<hr/><h3>Аккордеон:</h3>
<?

if (isset($_POST['collapse_nm'])) {
       $data                       = explode('][', $_POST['collapse_nm']);
       $_SESSION['collapse_numer'] = intval($data[0]);
       $_SESSION['alb_num']        = intval($data[1]);
}

if (isset($_SESSION['current_album'])) {
       $rs = go\DB\query('select * from accordions where id_album = ?i or id_album = ?i order by id_album asc',
              array($_SESSION['current_album'], '1'), 'assoc');
       if ($rs) {
              $acc_nm = go\DB\query('select accordion_nm from accordions where id_album = ?i',
                     array(isset($_SESSION['alb_num']) ? $_SESSION['alb_num'] : $_SESSION['current_album']), 'el');
              ?>
              <div><strong>Изменить заголовок:</strong> (Если названия нет - аккордеон выключен) <strong>Название
                                                                                                         параграфа: </strong> (если 'default' - выводится текст по
                                                        умолчанию)
              </div>
              <div class="controls">
                     <div class="input-append">
                            <form action="index.php"
                                  method="post"
                                  style="float: left">
                                   <input id="appendedInputButton"
                                          class="span3"
                                          type="text"
                                          name="nm"
                                          value="<?= $acc_nm ?>"/>
                                   <input class="btn btn-warning"
                                          type="hidden"
                                          name="go_edit_nm"
                                          value="<?= isset($_SESSION['alb_num']) ? $_SESSION['alb_num'] : $_SESSION['current_album'] ?>"/>
                                   <input class="btn btn-warning"
                                          type="submit"
                                          value="Имя кнопки запуска"/>
                            </form>
                     </div>
              </div>
              <div class="controls">
                     <div class="input-append">
                            <form action="index.php"
                                  method="post"
                                  enctype="multipart/form-data">
                                   <input type="text"
                                          class="span3"
                                          style=" height: 24px; margin-left: 20px;"
                                          value="default"
                                          name="nm">
                                   <input type="hidden"
                                          name="add_par"
                                          value=""/>
                                   <input type="hidden"
                                          name="id_album"
                                          value="<?= $_SESSION['current_album'] ?>"/>
                                   <input type="submit"
                                          value="Добавить параграф"
                                          class="btn btn-success"/>
                            </form>
                     </div>
              </div>
              <br>
              <div class="controls"
                   style="float: left; margin-right: 20px;">
                     <div class="input-append">
                            <form action="index.php"
                                  method="post"
                                  style="float: left">
                                   <select class="span3"
                                           name="collapse_nm"
                                           class="multiselect">
                                          <?
                                          $curr_razd =
                                                 (isset($_SESSION['collapse_numer']) && isset($_SESSION['alb_num'])) ?
                                                        intval($_SESSION['collapse_numer']).intval($_SESSION['alb_num']) : 0;
                                          foreach ($rs as $ln) {
                                                 $id_album = ($ln['id_album'] == 1) ? 'default' : $ln['id_album'];
                                                 ?>
                                                 <option value="<?= $ln['collapse_numer'].']['.$ln['id_album'] ?>"
                                                        <?=(
                                                 $curr_razd == $ln['collapse_numer'].$ln['id_album'] ? 'selected="selected"' : '')?>>
                                                        <?=$id_album.' - '.$ln['collapse_numer'].': '.$ln['collapse_nm']?></option>
                                          <?
                                          }
                                          ?>
                                   </select>
                                   <input class="btn  btn-success"
                                          type="submit"
                                          value="Открыть"/>
                            </form>
                            <form action="index.php"
                                  method="post"
                                  style="float: left">
                                   <input type="hidden"
                                          name="go_up_down"
                                          value="<?= $rs[0]['id_album'] ?>"/>
                                   <input type="hidden"
                                          name="coll_num"
                                          value="<?= $curr_razd ?>"/>
                                   <input class="btn btn-info"
                                          type="submit"
                                          name="up"
                                          value="выше"/>
                                   <input class="btn btn-info"
                                          type="submit"
                                          name="down"
                                          value="ниже"/>
                            </form>
                     </div>
              </div>
       <?

       } else {
              ?>
              <div class="controls">
                     <div class="input-append">
                            <form action="index.php"
                                  method="post"
                                  enctype="multipart/form-data">
                                   <input type="text"
                                          style="width: 180px; height: 20px; margin-left: 20px;"
                                          value="Важно!"
                                          name="add_par">
                                   <input type="hidden"
                                          name="nm"
                                          value="default"/>
                                   <input type="hidden"
                                          name="id_album"
                                          value="<?= $_SESSION['current_album'] ?>"/>
                                   <input type="submit"
                                          value="Добавить аккордеон"
                                          class="btn btn-success"/>
                            </form>
                     </div>
              </div>
       <?
       }
}
if (isset($_POST['collapse_nm'])) {
       $data                       = explode('][', $_POST['collapse_nm']);
       $_SESSION['collapse_numer'] = intval($data[0]);
       $_SESSION['alb_num']        = intval($data[1]);
}
if (isset($_SESSION['collapse_numer']) && isset($_SESSION['alb_num'])) {
       $rs =
              go\DB\query('select * from accordions where id_album =?i and collapse_numer = ?i',
                     array($_SESSION['alb_num'], $_SESSION['collapse_numer']),
                     'row');
       if ($rs) {
              ?>
              <div class="controls"
                   style="margin-top: -20px;">
                     <div class="input-append">
                            <form id="txtCollName"
                                  action="">
                                   <input style="float: left; height: 24px;"
                                          class="span3"
                                          type="text"
                                          name="nm"
                                          value="<?= $rs['collapse_nm'] ?>"/>
                                   <input type="hidden"
                                          name="go_edit_name_coll"
                                          value="<?= $rs['id_album'] ?>"/>
                                   <input type="hidden"
                                          name="collapse_numer"
                                          value="<?= $rs['collapse_numer'] ?>"/>
                            </form>
                            <button class="btn btn-warning"
                                    name="save"
                                    onClick="ajaxPostQ('/canon68452/index.php','',$('#txtCollName').serialize());">Переименовать
                            </button>
                     </div>
              </div>
              <div style="clear: both"></div>
              <form id="txtColl"
                    action=""
                    style="margin-bottom: 10px;">
                     <label for="txtResult"></label>
                     <textarea id="txtResult"
                               name="txt_coll"
                               class="tinymce"
                               rows="25"
                               cols="700"
                               style="width: 950px; height: 200px;"><?=$rs['collapse']?></textarea>
                     <input type="hidden"
                            name="go_update"
                            value="<?= $rs['id_album'] ?>"/>
                     <input type="hidden"
                            name="collapse_numer"
                            value="<?= $rs['collapse_numer'] ?>"/>
              </form>
              <button class="btn btn-warning"
                      onClick="ajaxPostQ('/canon68452/index.php','',$('#txtColl').serialize());"
                      style="margin: 10px 0 40px 0; float: left">Применить
              </button>
              <?
              if (isset($_SESSION['alb_num']) && $_SESSION['alb_num'] != 1) {
                     ?>
                     <form action="index.php"
                           method="post">
                            <input type="hidden"
                                   name="go_del"
                                   value="<?= isset($_SESSION['current_album']) ? $_SESSION['current_album'] : NULL; ?>"/>
                            <input type="hidden"
                                   name="collapse_numer"
                                   value="<?= $_SESSION['collapse_numer'] ?>"/>
                            <input class="btn btn-danger"
                                   type="submit"
                                   value="Удалить"
                                   style="margin-left: 500px;"
                                   onclick="return confirmDelete();"/>
                     </form>
              <?
              }
       }
}
?>
<div style="clear: both; display: block; height: 100px;"></div>