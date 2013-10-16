<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 14.10.13
 * Time: 1:23
 * To change this template use File | Settings | File Templates.
 */
?>
              <div id="userpic"
                   class="thumbnail userpic">
                     <div class="js-preview userpic__preview">
                            <img style="width: auto; height: auto;"
                                 src="/images/<?= $ln['img'] ?>"
                                 alt="-"/>
                     </div>
                     <div class="btn btn-success js-fileapi-wrapper">
                            <div class="js-browse">
                                   <input type="file" name="filedata"/>
                                   <input type="hidden" id="x1" name="x1"/>
                                   <input type="hidden" id="y1" name="y1"/>
                                   <input type="hidden" id="h"  name="h"/>
                                   <input type="hidden" id="w"  name="w"/>
                                   <span class="btn-txt">Выбор</span>
                            </div>
                            <div class="js-upload" style="display: none;">
                                   <div class="progress progress-success">
                                          <div class="js-progress bar"></div>
                                   </div>
                                   <span class="btn-txt">Загрузка</span>
                            </div>
                     </div>
              </div>

       <script type="text/javascript">

              $('#userpic').fileapi({
                     url: '/canon68452/index.php',
                     accept: 'image/*',
                     imageSize: { minWidth: 200, minHeight: 200 },
                     dataType: false,
                     elements: {
                            active: { show: '.js-upload', hide: '.js-browse' },
                            preview: {
                                   el: '.js-preview',
                                   width: 150,
                                   height: 150
                            },
                            progress: '.js-progress'
                     },
                     onSelect: function (evt, ui){
                            var file = ui.files[0];
                            if( file ){
                                   $('#popup').modall({
                                          closeOnOverlayClick: false,
                                          onOpen: function (overlay){
                                                 $(overlay).on('click', '.js-upload', function (){
                                                        $.modall().close();
                                                        $('#userpic').fileapi('upload');
                                                 });

                                                 $('.js-img', overlay).cropper({
                                                        file: file,
                                                        bgColor: '#fff',
                                                        maxSize: [540, 760],
                                                        minSize: [32, 32],
                                                        selection: '90%',
                                                        aspectRatio: 1,
                                                        bgFade: true, // использовать эффект исчезновения
                                                        onChange: function (e) {   // обновление информации обрезки
                                                               $('#x1').val(e.x);
                                                               $('#y1').val(e.y);
                                                               $('#w').val(e.w);
                                                               $('#h').val(e.h);
                                                        },
                                                        onSelect: function (coords){
                                                               $('#userpic').fileapi('crop', file, coords);
                                                        }
                                                 });
                                          }
                                   }).open();
                            }
                     }
              });

       </script>

<div class="modal" id="popup" style="display: none; top: 10%; z-index: 10000;">
       <div class="popup__body">
              <div class="js-img"></div>
       </div>
       <div style="margin: 0 0 5px; text-align: center; clear: both;">
              <div class="js-upload btn btn_browse btn_browse_small">Кадрировать</div>
       </div>
</div>