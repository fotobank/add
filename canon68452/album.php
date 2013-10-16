<?php
if (!isset($_SESSION['admin_logged'])) {
       die();
}
require_once (__DIR__.'/../inc/i_resize.php');
require_once (__DIR__.'/inc_album.php');


?>
<div style="float: left;">
       <label>Включить фотобанк:</label>
</div>
       <div class="slideThree">
              <input id="slideThree1"
                     type='checkbox'
                     NAME='watermark'
                     VALUE='yes'
                     <?if (isset($ln['watermark'])) {
                     echo 'checked="checked"';
              } ?> /> <label for="slideThree1"></label>
       </div>
<div class="linBlue"></div>

<!-- создать альбом-->

<div class="example__right">
       <h2><span>Новый альбом</span></h2>
</div>

<?
//require_once(__DIR__.'/jquery.fileapi/inc_fileapi.php');
require_once(__DIR__.'/inc_modal_new_album.php');
require_once(__DIR__.'/inc_album_warning.php');


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
                                                               <?
                                                               require_once(__DIR__.'/jquery.fileapi/inc_fileapi.php');
                                                               ?>
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