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
     data-width="490px"
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

                            <div style="float: left">
                                   <form action="index.php"
                                         method="post"
                                         enctype="multipart/form-data">

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



                                         <!-- <input type="hidden"
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
                                                 name="y2"/>-->



                                         <!-- <div style="margin-top: 5px;">
                                                 <label class="add-on"
                                                        for="image_file">Превью</label>
                                                 <input type="file"
                                                        id="image_file"
                                                        name="image_file"
                                                        onchange="fileSelectHandler(); $('.step2').modal('show');"/>
                                          </div>-->
                                          <div class="error"></div>
                                          <div class="step2 modal hide fade in animated fadeInDown"
                                               tabindex="-1"
                                               aria-hidden="false"
                                               data-width="490">
                                                 <div class="modal-header">
                                                        <button type="button"
                                                                class="close"
                                                                data-dismiss="modal"
                                                                aria-hidden="true">x
                                                        </button>
                                                        <h3>Выбор региона обрезки:</h3>
                                                 </div>
                                                 <div class="modal-body">
                                                 <img id="preview" style="width: 460px;"/>
                                                 <div class="info" style="display: none;">
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
                                                 <div class="modal-footer">
                                                        <input class="btn  btn-success"
                                                               type="submit"
                                                               value="Добавить"/>
                                                        <button type="button"
                                                                data-dismiss="modal"
                                                                class="btn">Close
                                                        </button>
                                                 </div>
                                          </div>

                                          <div class="linBlue"></div>
                                          <input class="btn  btn-success"
                                                 type="hidden"
                                                 name="go_add"
                                                 value="1"/>
                                          <input class="btn  btn-success"
                                                 type="submit"
                                                 value="Добавить"/>
                                          <hr>

                                   </form>
                            </div>
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

<div class="offset1"
     style="float:left">
       <button class="btn btn-primary btn-large"
               href="#long"
               data-toggle="modal">Создать альбом
       </button>
</div>