<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 14.10.13
 * Time: 1:23
 * To change this template use File | Settings | File Templates.
 */
?>
       <div class="example">
       <div class="example__left"style="padding: 20px 50px 0 0;">
              <div id="userpic" class="userpic">
                     <div class="js-preview userpic__preview"></div>
                     <div class="btn btn-success js-fileapi-wrapper">
                            <div class="js-browse">
                                   <span class="btn-txt">Выбор</span>
                                   <input type="file" name="filedata"/>
                            </div>
                            <div class="js-upload" style="display: none;">
                                   <div class="progress progress-success"><div class="js-progress bar"></div></div>
                                   <span class="btn-txt">Загрузка</span>
                            </div>
                     </div>
              </div>
       </div>



       <script type="text/javascript">
                    $('#userpic').fileapi({
                            url: '/canon68452/index.php',
                            accept: 'image/*',
                            imageSize: { minWidth: 200, minHeight: 200 },
                            elements: {
       active: { show: '.js-upload', hide: '.js-browse' },
       preview: {
              el: '.js-preview',
                                          width: 200,
                                          height: 200
                                   },
       progress: '.js-progress'
                            },
                            onSelect: function (evt, ui){
       var file = ui.files[0];

                                   if( file ){
                                          $('#popup').modal({
                                                 closeOnEsc: false,
                                                 closeOnOverlayClick: false,
                                                 onOpen: function (overlay){
                                                 $(overlay).on('click', '.js-upload', function (){
                                                        $.modal().close();
                                                        $('#userpic').fileapi('upload');
                                                 });

                                                 $('.js-img', overlay).cropper({
                                                               file: file,
                                                               bgColor: '#fff',
                                                               maxSize: [$(window).width()-100, $(window).height()-100],
                                                               minSize: [200, 200],
                                                               selection: '90%',
                                                               aspectRatio: 1,
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
</div>



<div id="popup" class="popup" style="display: none;">
       <div class="popup__body"><div class="js-img"></div></div>
       <div style="margin: 0 0 5px; text-align: center;">
              <div class="js-upload btn btn_browse btn_browse_small">Кадрировать</div>
       </div>
</div>