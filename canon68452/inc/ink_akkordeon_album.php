<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 18.10.13
 * Time: 23:30
 * To change this template use File | Settings | File Templates.
 */


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
<div class="thumbnail" style="width:460px; float:left; font-size:14px; padding: 20px;">
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
              <div><strong>Изменить заголовок:</strong> (Если названия нет - аккордеон выключен)</div>
              <div class="controls">
                     <div class="input-append">
                            <form action="/canon68452/index.php"
                                  method="post">
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
              <div><strong>Название параграфа: </strong> (если 'default' - выводится текст по умолчанию)</div>
              <div class="controls">
                     <div class="input-append">
                            <form action="/canon68452/index.php"
                                  method="post"
                                  enctype="multipart/form-data">
                                   <input type="text"
                                          class="span3"
                                          style=" height: 24px;"
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
              <div><strong>Выбор параграфа: </strong> (если 'default' - выводится текст по умолчанию)</div>
              <div class="controls">
                     <div class="input-append">
                            <form action="/canon68452/index.php"
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
                            <form action="/canon68452/index.php"
                                  method="post">
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
                            <form action="/canon68452/index.php"
                                  method="post"
                                  enctype="multipart/form-data">
                                   <input type="text"
                                          style="width: 180px; height: 20px;"
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
              <div><strong>Переименование параграфа:</strong></div>
              <div class="controls">
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
                                    onClick="ajaxPostQ('/canon68452/index.php','',$('#txtCollName').serialize());">Применить
                            </button>
                     </div>
              </div>

              <form id="txtColl"
                    action=""
                    style="margin: 10px 0;">
                     <label for="txtResult"></label>
                     <textarea id="txtResult"
                               name="txt_coll"
                               class="tinymce"
                               rows="25"
                               cols="700"
                               style="width: 450px; height: 200px;"><?=$rs['collapse']?></textarea>
                     <input type="hidden"
                            name="go_update"
                            value="<?= $rs['id_album'] ?>"/>
                     <input type="hidden"
                            name="collapse_numer"
                            value="<?= $rs['collapse_numer'] ?>"/>
              </form>
              <button class="btn btn-warning" style="float: left;"
                      onClick="ajaxPostQ('/canon68452/index.php','',$('#txtColl').serialize());">Применить
              </button>
              <?
              if (isset($_SESSION['alb_num']) && $_SESSION['alb_num'] != 1) {
                     ?>
                     <form action="/canon68452/index.php"
                           method="post">
                            <input type="hidden"
                                   name="go_del"
                                   value="<?= isset($_SESSION['current_album']) ? $_SESSION['current_album'] : NULL; ?>"/>
                            <input type="hidden"
                                   name="collapse_numer"
                                   value="<?= $_SESSION['collapse_numer'] ?>"/>
                            <input class="btn btn-danger"
                                   style="float: right;"
                                   type="submit"
                                   value="Удалить"
                                   onclick="return confirmDelete();"/>
                     </form>
              <?
              }
       }
}
?>
</div>