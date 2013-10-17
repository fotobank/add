<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 16.10.13
 * Time: 10:45
 * To change this template use File | Settings | File Templates.
 */

class fileapi_selectImg {

       private $pre = 0;                // префикс файлов
       private $aspectRatio = 1;        // соотношение сторон
       private $selection = '90%';      // область выделения при старте
       private $url = true;                    // скрипт обработки загруженного файла
       private $maxSize = '[540, 760]'; // размер окна кадрировки
       private $minSize = '[32, 32]';   // min размер выбранной области
       private $bgColor = '#fff';


       /**
        * @param $ini
        */
       public function __construct($ini) {

              foreach($ini as $var => $data) {
                     if(isset($this->$var)) {
                            $this->$var = $data;
                     }
              }

              // модальное окно кадрировки
       echo '<div class="modal" id="popup" style="display: none; top: 10%; z-index: 10000;">
                <div class="popup__body">
                     <div class="js-img"></div>
                </div>
                <div style="margin: 0 0 5px; text-align: center; clear: both;">
                     <div class="js-upload btn btn_browse btn_browse_small">Кадрировать</div>
                </div>
              </div>';
       }

       /**
        * @param $var
        * @param $data
        */
       public function __set($var, $data) {
              if(isset($this->$var)) {
                     $this->$var =  $data;
              }

       }

       public function replaceImg($dataImg) {

       $this->pre++;

       if(isset($dataImg['defaultThumb'])) {
         $defaultThumb = "<img style='width: ".$dataImg['widthThumb']."px; height: ".$dataImg['heightThumb']."px;'
                    src='".$dataImg['defaultThumb']."'
                    alt='-'/>";
       } else $defaultThumb = NULL;

?>
<div id="userpic" class="thumbnail userpic" style="width: <?= $dataImg['widthThumb'] ?>px; height: <?= $dataImg['heightThumb'] ?>px;">
       <div class="js-preview userpic__preview">
              <?= $defaultThumb ?>
       </div>
       <div class="btn btn-success js-fileapi-wrapper">
              <div class="js-browse">
                     <input type="file" name="filedata"/>
                     <input type="hidden" id="x<?= $this->pre ?>" name="x"/>
                     <input type="hidden" id="y<?= $this->pre ?>" name="y"/>
                     <input type="hidden" id="h<?= $this->pre ?>" name="h"/>
                     <input type="hidden" id="w<?= $this->pre ?>" name="w"/>
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
              url: '<?= $this->url ?>',
              accept: 'image/*',
              imageSize: { minWidth: 100, minHeight: 100 },
              dataType: false,
              elements: {
                     active: { show: '.js-upload', hide: '.js-browse' },
                     preview: {
                            el: '.js-preview',
                            width: '<?= $dataImg['widthThumb'] ?>',
                            height: '<?= $dataImg['heightThumb'] ?>'
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
                                                 bgColor: '<?= $this->bgColor ?>',
                                                 maxSize: <?= $this->maxSize ?>,
                                                 minSize: <?= $this->minSize ?>,
                                                 selection: '<?= $this->selection ?>',
                                                 aspectRatio: '<?= $this->aspectRatio ?>',
                                                 bgFade: true, // использовать эффект исчезновения
                                                 onChange: function (e) {   // обновление информации обрезки
                                                        $('<?="#x".$this->pre?>').val(e.x);
                                                        $('<?="#y".$this->pre?>').val(e.y);
                                                        $('<?="#w".$this->pre?>').val(e.w);
                                                        $('<?="#h".$this->pre?>').val(e.h);
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
<?
}


       }