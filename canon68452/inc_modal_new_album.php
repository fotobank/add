<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 14.10.13
 * Time: 1:28
 * To change this template use File | Settings | File Templates.
 */

?>
<div id="long"
     class="modal hide fade in animated fadeInDown"
     tabindex="-1"
     data-replace="true"
     data-width="400px"
     data-backdrop="static"
     aria-hidden="false">
       <div class="modal-header">
              <button type="button"
                      class="close"
                      data-dismiss="modal"
                      aria-hidden="true">x
              </button>
              <h3>Новый альбом:</h3>
       </div>
       <div class="modal-body">
                                   <form action="index.php"
                                         method="post"
                                         enctype="multipart/form-data">

                                                 <div class="new_album">
                                                        <div class="thumbnail">
                                          <?
//                                          require_once(__DIR__.'/jquery.fileapi/inc_fileapi.php');
                                          ?>
                                                        </div>
                                                 </div>
                                          <div class="clear"></div>
                                          <div class="input-prepend">
                                                 <label class="add-on"
                                                        for="name">Название</label>
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
                                                        for="foto_folder">Папка в фотобанке</label>
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
                                                    name="descr"></textarea>

                                          <div class="modal-footer">
                                          <input class="btn  btn-success"
                                                 type="hidden"
                                                 name="go_add"
                                                 value="1"/>
                                          <input class="btn  btn-success"
                                                 type="submit"
                                                 value="Добавить"/>

                                                 <button type="button"
                                                         data-dismiss="modal"
                                                         class="btn">Close
                                                 </button>
                                          </div>
                                   </form>



       </div>

</div>

<div class="offset1"
     style="float:left">
       <button class="btn btn-primary btn-large"
               href="#long"
               data-toggle="modal">Создать альбом
       </button>
</div>