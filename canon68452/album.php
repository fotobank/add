<?php
if (!isset($_SESSION['admin_logged'])) {
       die();
}
require_once (__DIR__.'/../inc/i_resize.php');
require_once (__DIR__.'/inc_album.php');
$imgAlbum = new fileapi_modalResizeImg();


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

       $fotobank_on  = go\DB\query('select `param_value` from `adminka` where `param_name` = ?string', array('fotobank_on'), 'el');
       ?>

       <div class="bheader" style="width: 1350px; margin-bottom: 30px;"><h2>Редактор альбомов:</h2></div>

       <fieldset style="width:220px; margin: -30px 30px 0 0; padding: 5px;  float:left; font-size:14px;">
              <legend style="font-weight:bold; width: auto;">Настройки:</legend>
              <div style="float: left;">Включить фотобанк:</div>
              <div class="slideThree">
                     <input id="slideThree1"
                            type='checkbox'
                            name='fotobank_on'
                            value='<?=(($fotobank_on == '1')?'0':'1')?>'
                            onclick="ajaxPostQ('index.php', '', 'fotobank_check='+'1');"
                            <?if ($fotobank_on == '1') {
                            echo 'checked="checked"';
                     }?> />
                     <label for="slideThree1"></label>
              </div>
       </fieldset>

       <?
       if (isset($_POST['fotobank_check'])) {

              go\DB\query('update `adminka` set `param_value` = not param_value where `param_name` = ?string', array('fotobank_on'));
       }
       include_once(__DIR__.'/inc_modal_new_album.php');
       ?>

       <div><strong>Выбрать категорию:</strong> <strong style="margin-left: 330px;">Выбрать альбом:</strong></div>
       <div class="controls" style="float:left;">
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
              <div class="clear"></div>

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
                                          <th style="text-align: center;">настройка фотографий и FTP</th>
                                          <th style="text-align: center;">Аккордеон</th>
                                   </tr>
                                   </thead>
                                   <tr>
                                   <td align="left">
                                          <ul style="margin: 0;">
                                                 <li style="width: 222px;">
                                                        <div class="thumbnail">
                                                               <?
                                                               $imgAlbum->url = "/classes/fileapi/replaceThumb.php";
                                                               $dataImg = array(
                                                                      "defaultThumb" => "/images/".$ln['img'], // картинка по умолчанию
                                                                      "widthThumb" => 200, // размер окна превью
                                                                      "heightThumb" => 200
                                                               );
                                                               $imgAlbum->prevResize($dataImg);
                                                               ?>
                                                               <div class="caption" style="margin-top: 10px;">


                                                                      <h3><?= $ln['nm'] ?></h3>
                                                                      <form action="index.php"
                                                                            method="post">
                                                                             <label for="appendedInputButton"></label>
                                                                             <input id="appendedInputButton"
                                                                                    type="text"
                                                                                    name="nm"
                                                                                    value="<?= $ln['nm'] ?>"
                                                                                    style="height: 22px; width: 194px; margin-bottom: 5px;  border-radius: 4px 4px 4px 4px;"/>
                                                                             <input class="btn btn-primary"
                                                                                    type="hidden"
                                                                                    name="go_edit_name"
                                                                                    value="<?= $ln['id'] ?>"/>
                                                                             <input class="btn btn-small btn-primary"
                                                                                    type="submit"
                                                                                    value="переименовать"/>
                                                                      </form>
                                                                      <div class="linBlue"></div>

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
                                                                      <div class="linBlue"></div>

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
                                                                      <div class="linBlue"></div>

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
                                   <td>
                                   <div class="thumbnail" style="margin: 0 10px; padding-bottom: 10px;">
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
                                                                                                         NAME='disable_photo_display'
                                                                                                         VALUE='on'
                                                                                                         <?if ($ln['disable_photo_display'] == 'on') {
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
                                                                                           <div class="linBlue"></div>
                                                                                           <input class="btn btn-primary"
                                                                                                  type="hidden"
                                                                                                  name="go_edit_nastr"
                                                                                                  value="<?= $ln['id'] ?>"/>
                                                                                           <input class="btn-small btn-primary"
                                                                                                  type="submit"
                                                                                                  style="margin-left: 10px;"
                                                                                                  value="сохранить"/>
                                                                                    </td>
                                                                             </tr>
                                                                      </table>
                                                               </form>

                                                        </td>
                                                 </tr>
                                                 <tr>
                                                        <td align="center">
                                                               <div class="linBlue" style="float: right;"></div>
                                                               <div class="clear"></div>
                                                               <form action="index.php"
                                                                     name="go_ftp_upload"
                                                                     method="post"
                                                                     style="float: right; margin-right: 10px;"
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
                                          </div>
                                          <form action="index.php"
                                                method="post"
                                                 style="float: left;">
                                                 <label>
                                                        <textarea name="descr"
                                                                  style="margin: 20px 10px 0; width: 258px; height: 240px; padding-bottom: 0;"
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
                                                        style="margin: 5px 20px;">
                                          </form>
                                          <?
                                          require_once(__DIR__.'/inc_album_warning.php');
                                          ?>
                                   </td>
                                   <td>
                                          <?
                                          require_once(__DIR__.'./../canon68452/inc/ink_akkordeon_album.php');
                                          ?>
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
?>
<div class="linBlue" style="width: 1330px;"></div>
<div style="clear: both; display: block; height: 100px;"></div>
