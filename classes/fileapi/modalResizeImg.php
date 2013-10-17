<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 16.10.13
 * Time: 10:45
 * To change this template use File | Settings | File Templates.
 * модальное окно для кадрировки и отправки файла по POST
 */

class fileapi_modalResizeImg {

       public  $pre = 0;                // префикс файлов
       public $aspectRatio = 1;        // соотношение сторон
       public $selection = '90%';      // область выделения при старте
       public $url = '';               // скрипт обработки загруженного файла
       public $maxSize = '[540, 760]'; // размер окна кадрировки
       public $minSize = '[32, 32]';   // min размер выбранной области
       public $bgColor = '#fff';


       /**
        * @param $var
        * @param $data
        */
       public function __set($var, $data) {

                     $this->$var = $data;
       }

       public function prevResize($dataImg) {

              $this->pre++;
              if(isset($dataImg['defaultThumb'])) {
                $defaultThumb = "<img style='width: ".$dataImg['widthThumb']."px; height: ".$dataImg['heightThumb']."px;'
                           src='".$dataImg['defaultThumb']."'
                           alt='-'/>";
              } else $defaultThumb = NULL;

       // модальное окно кадрировки
              ?>
       <div class="modal" id="popup<?=$this->pre?>" style="display: none; top: 10%; z-index: 10000;">
              <div class="popup__body">
                     <div class="js-img<?=$this->pre?>"></div>
              </div>
              <div style="margin: 0 0 5px; text-align: center; clear: both;">
                     <button class="js-upload<?=$this->pre?> btn btn_browse btn_browse_small">Кадрировать</button>
              </div>
       </div>

              <div id="userpic<?=$this->pre?>" class="thumbnail userpic"
                   style="width: <?= $dataImg['widthThumb'] ?>px; height: <?= $dataImg['heightThumb'] ?>px;">
                     <div class="js-preview<?=$this->pre?> userpic__preview">
                            <?= $defaultThumb ?>
                     </div>
                     <div class="btn btn-success js-fileapi-wrapper">
                            <div class="js-browse<?=$this->pre?>">
                                   <input type="file" name="filedata"/>
                                   <span class="btn-txt">Выбор</span>
                                   <script type="text/javascript">
                                   </script>
                            </div>
                            <div class="js-upload<?=$this->pre?>" style="display: none;">
                                   <div class="progress progress-success">
                                          <div class="js-progress<?=$this->pre?> bar"></div>
                                   </div>
                                   <span class="btn-txt">Загрузка</span>
                            </div>
                     </div>
              </div>


              <script type="text/javascript">
                     $('#userpic'+<?=$this->pre?>).fileapi({
                            url: '<?= $this->url ?>',
                            accept: 'image/*',
                            imageSize: { minWidth: 100, minHeight: 100 },
                            dataType: false,
                            elements: {
                                   active: { show: '.js-upload'+<?=$this->pre?>, hide: '.js-browse'+<?=$this->pre?> },
                                   preview: {
                                          el: '.js-preview'+<?=$this->pre?>,
                                          width: '<?= $dataImg['widthThumb'] ?>',
                                          height: '<?= $dataImg['heightThumb'] ?>'
                                   },
                                   progress: '.js-progress'+<?=$this->pre?>
                            },
                            onSelect: function (evt, ui){
                                   var file = ui.files[0];
                                   if( file ){
                                          $('#popup'+<?=$this->pre?>).modall({
                                                 closeOnOverlayClick: false,
                                                 onOpen: function (overlay){
                                                        $(overlay).on('click', '.js-upload'+<?=$this->pre?>, function (){
                                                               $.modall().close();
                                                               $('#userpic'+<?=$this->pre?>).fileapi('upload');
                                                        });
                                                        $('.js-img'+<?=$this->pre?>, overlay).cropper({
                                                               file: file,
                                                               bgColor: '<?= $this->bgColor ?>',
                                                               maxSize: <?= $this->maxSize ?>,
                                                               minSize: <?= $this->minSize ?>,
                                                               selection: '<?= $this->selection ?>',
                                                               aspectRatio: '<?= $this->aspectRatio ?>',
                                                               bgFade: true, // использовать эффект исчезновения
                                                               onSelect: function (coords){
                                                                      $('#userpic'+<?=$this->pre?>).fileapi('crop', file, coords);
                                                               }
                                                        });
                                                 }
                                          }).open();
                                   }
                            }
                     });
              </script>
              <?
       }
}