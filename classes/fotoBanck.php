<?php
/**
 * Created by PhpStorm.
 * User: Jurii
 * Date: 02.11.13
 * Time: 12:55
 */

class fotoBanck {





       public function __construct() {

              $session = check_Session::getInstance();

              if (isset($_GET['id'])) {
                     $current_album = $session->set('current_album', intval($_GET['id']));
                     $album_data    = go\DB\query('select * from albums where id = ?i', array($current_album), 'row');
                     $session->set("album_name/$current_album", "$album_data[nm]");
                     if ($album_data['pass'] != '' && $session->has("popitka/$current_album") == false) {
                            $session->set("popitka/$current_album", 5);
                     }
              }
              if (isset($_GET['back_to_albums'])) {
                     $session->del('current_album');
              }
              if (isset($_GET['chenge_cat'])) {
                     $session->del('current_album');
                     $session->set('current_cat', intval($_GET['chenge_cat']));
              }
              if (isset($_GET['unchenge_cat'])) {
                     $session->del('current_album');
                     $session->del('current_cat');
              }

       }


       // бан
       function record($ipLog='ipLogFile.txt', $timeout='30') // запись бана
       {
              $session = check_Session::getInstance();
              $log = fopen("$ipLog", "a+");
              fputs($log, Get_IP()."][".time()."][".$session->get('current_album')."\n");
              fclose($log);


              $mail_mes = "Внимание - ".dateToRus( time(), '%DAYWEEK%, j %MONTH% Y, G:i' )." - зафиксированн подбор пароля для альбома \"".
                          $_SESSION['current_album']."\", пользователь - \"".$session->get('us_name')."\" c Ip:".Get_IP().
                          " забанен на ".$timeout." минут!";

              $error_processor = Error_Processor::getInstance();
              $error_processor->log_evuent($mail_mes,"");

              $mail            = new Mail_sender;
              $mail->from_addr = "webmaster@aleks.od.ua";
              $mail->from_name = "aleks.od.ua";
              $mail->to        = "aleksjurii@gmail.com";
              $mail->subj      = "Подбор пароля";
              $mail->body_type = 'text/html';
              $mail->body      = $mail_mes;
              $mail->priority  = 1;
              $mail->prepare_letter();
              $mail->send_letter();

       }

       // chek
       function check($ipLog ='ipLogFile.txt', $timeout = '30') // проверка бана
       {
              $session = check_Session::getInstance();
              $data = file("$ipLog");
              $now  = time();
              $current_album = $session->get('current_album');
              if (!$session->has("popitka") || !is_array($_SESSION['popitka']))
              {
                     $_SESSION['popitka'] = array();
              }
              if ( $session->has("current_album") )
              {
                     if (!$session->has("popitka/$current_album") || $session->get("popitka/$current_album") < 0
                         || $session->get("popitka/$current_album") > 5 && $session->get("popitka/$current_album") != -10)
                     {
                            $session->set("popitka/$current_album", 5);
                     }
              }
              if ($data) //если есть хоть одна запись
              {
                     foreach ($data as $key => $record)
                     {
                            $subdata = explode("][", $record);

                            // показ остаточного времени
                            if (Get_IP() == $subdata[0] && $now < ($subdata[1] + 60 * $timeout) && $current_album == $subdata[2])
                            {
                                   $begin = ((($subdata[1] + 60 * $timeout) - $now) / 60);
                                   $min = intval($begin);
                                   $sec = round((($begin - $min)*60),2);
                                   $session->set("popitka/$current_album", -10);

                                   return json_encode(array('min' => $min,'sec' => $sec));
                                   break;
                            }

                            // время бана закончилось
                            if (Get_IP() == $subdata[0] && $now > ($subdata[1] + 60 * $timeout) && $current_album == $subdata[2]
                                && $session->get("popitka/$current_album") <= 0 && $session->get("popitka/$current_album") > 5 )

                            {
                                   $session->set("popitka/$current_album", 5);
                            }

                            // чистка
                            if (isset($subdata[1]) && ($subdata[1] + 60 * $timeout) < $now)
                            {
                                   unset($data[$key]); // убираем элемент массива, который нужно удалить
                                   $data = str_replace('x0A', '', $data);
                                   file_put_contents($ipLog, implode('', $data)); // сохраняем этот массив, предварительно объединив его в строку
                            }
                     }
                     unset($key);
              }
              elseif ($session->has("current_album"))
              {
                     if (!$data && $session->get("popitka/$current_album") <= 0 && $session->get("popitka/$current_album") > 5)
                     {
                            $session->set("popitka/$current_album", 5);
                     }
              }
              return true;
       }

       /**
        * @param $may_view
        * @param $current_page
        * @param $record_count
        *
        * @todo function fotoPage
        */
       function fotoPage(&$record_count, $may_view, &$current_page) {

              $current_page = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
              if ($may_view) {
                     if ($current_page < 1) {
                            $current_page = 1;
                     }
                     $start  = ($current_page - 1) * PHOTOS_ON_PAGE;
                     $rs     = go\DB\query('select SQL_CALC_FOUND_ROWS p.* from photos p where id_album = ?i order by img ASC, id ASC limit ?i, '.PHOTOS_ON_PAGE,
                            array($_SESSION['current_album'], $start), 'assoc');
                     $record_count = go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el'); // количество записей
                     if ($rs) {
                            ?>
                            <!-- 3 -->
                            <hr class="style-one"
                                style="margin-top: 10px; margin-bottom: -20px;">
                            <?
                            foreach ($rs as $ln) {
                                   $source = ($_SERVER['DOCUMENT_ROOT'].fotoFolder().$ln['id_album'].'/'.$ln['img']);
                                   $sz     = @getimagesize($source);
                                   /* размер превьюшек */
                                   if (intval($sz[0]) > intval($sz[1])) {
                                          $preW = "155px;";
                                          $preH = "170px;";
                                   } else {
                                          $preW = "170px;";
                                          $preH = "155px;";
                                   }
                                   ?>
                                   <div class="podlogka">
                                          <figure class="ramka"
                                                  onClick="preview(<?= $ln['id'] ?>);">
                                                 <img class="lazy"
                                                      data-original="/thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
                                                      id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                      width="<?=$preW?>"
                                                      height="<?=$preH?>"
                                                      src=""
                                                      title="За фотографию проголосовало <?= $ln['votes'] ?> человек. Нажмите для просмотра." />
                                                 <figcaption>№ <?=$ln['nm']?></figcaption>
                                          </figure>
                                   </div>
                            <?
                            }
                     }

              }

       }


       /**
        * @param $rs
        * @param $start
        * @param $width
        * @param $widthSait
        * @param $margP
        *
        * @return array
        */
       function getMargin($rs, $start, $width, $widthSait, $margP) {

              // инициализация переменных
              // ------------------------
              $margin      = 0;
              $testDiv     = 0;
              $koll        = 1;
              $paddingFoto = 10;
              // ------------------------
              for ($i = $start; $i < count($rs); $i++) {
                     $ln     = $rs[$i];
                     $source = ($_SERVER['DOCUMENT_ROOT'].fotoFolder().$ln['id_album'].'/'.$ln['img']);
                     $sz     = @getimagesize($source);
                     if (intval($sz[0]) > intval($sz[1])) {
                            $wid = $width + $paddingFoto;
                     } else {
                            $wid = $width / 1.25 + $paddingFoto;
                     }
                     $testDiv += $wid;
                     if ((($testDiv + ($margP * ($koll - 1)) >= $widthSait))) {
                            $margin = round(($widthSait - $testDiv) / ($koll - 1));
                            break;
                     }
                     $koll++;
              }
              unset($i);

              return array("margin" => $margin, "koll" => $koll);
       }



       /**
        * @param $may_view
        * @param $current_page
        * @param $width
        */
       function fotoPageModern($may_view, $current_page, $width = 170) {

              $session      = check_Session::getInstance();
              $widthSait    = 1200; // px
              $margP        = 50; // предпологаемый правый маргин px

              if ($may_view) {
                     $start = $current_page * PHOTOS_ON_PAGE;
                     $rs    = go\DB\query(
                            'select SQL_CALC_FOUND_ROWS  p.id_album,
                             p.nm,
                             p.img,
                             a.watermark,
                             a.ip_marker
                             FROM photos as p, albums as a
                             WHERE p.id_album = ?i
                             AND p.id_album = a.id
                             ORDER by p.img ASC, p.id ASC limit ?i,'.PHOTOS_ON_PAGE,
                            array($session->get('current_album'), $start), 'assoc');
                     $record_count = go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el'); // количество записей
                     $_SESSION['record_count'][$session->get('current_album')] = $record_count;
                     if ($rs) {
                            ?>
                            <!-- 3 -->
                            <hr class="style-one"
                                style="margin-top: 10px; margin-bottom: -20px;">
                            <div style=" clear: both;">
                            <?

                            $data = getMargin($rs, 0, $width, $widthSait, $margP);
                            $margin = $data['margin'];
                            $koll = $data['koll'];
                            $kollFoto = 1;

                            $fotoFolder = fotoFolder();
                            $psw = "Protected_Site_Sec"; // пароль
                            $iv_len = 24; // сложность шифра
                            $md5_encrypt = new md5_encrypt($psw, $iv_len);

                            foreach ($rs as $key => $ln) {
                                   $encrypted = $md5_encrypt->ret($fotoFolder.']['.$ln['id_album'].']['.(string)$ln['watermark'].']['.(string)$ln['ip_marker'].']['.$ln['img']);
                                   $source = ($_SERVER['DOCUMENT_ROOT'].$fotoFolder.$ln['id_album'].'/'.$ln['img']);
                                   $sz     = @getimagesize($source);
                                   /* ширина превьюшек px */
                                   if (intval($sz[0]) > intval($sz[1])) {
                                          $preW = 'width="'.$width.'px"';
                                          $preH = 'height="'.ceil($width / 1.327).'px"';
                                   } else {
                                          $preW = 'height="'.ceil($width * 1.066).'px"';
                                          $preH = 'width="'.ceil($width / 1.247).'px"';
                                   }
                                   if ($kollFoto == $koll) {

                                          ?>
                                          <a class="modern"
                                             style="position: absolute; float: right;"
                                             href="/loader.php?<?=$encrypted?>"
                                             title="Фото № <?= intval($ln['nm']) ?>">
                                                 <img id="<?= substr(trim($ln['img']), 2, -4); ?>"
                                                      class="lazy" <?=$preW?> <?=$preH?>
                                                      src=""
                                                      data-original="/thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
                                                      alt="№ <?= intval($ln['nm']) ?>"/>№ <?= intval($ln['nm']) ?>
                                          </a>
                                          </div>
                                          <?

                                          $data = getMargin($rs, $key, $width, $widthSait, $margP);
                                          $margin = $data['margin'];
                                          $koll = $data['koll'];
                                          $kollFoto = 0;

                                          ?>
                                          <div style=" clear: both;">
                                   <?
                                   } else {
                                          ?>
                                          <a class="modern"
                                             style="position: relative; float: left; margin-right: <?= $margin; ?>px;"
                                             href="/loader.php?<?=$encrypted?>"
                                             title="Фото № <?= intval($ln['nm']) ?>"> <img
                                                        id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                        class="lazy" <?=$preW?> <?=$preH?>
                                                        src=""
                                                        data-original="/thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
                                                        alt="№ <?= intval($ln['nm']) ?>"/>№ <?= intval($ln['nm']) ?>
                                          </a>
                                   <?
                                   }
                                   $kollFoto++;
                            }
                            ?>
                            </div>
                     <?
                     }
              }
       }


       /**
        * @param $may_view
        *
        * @todo function verifyParol
        */
       function verifyParol($may_view) {

              $session       = check_Session::getInstance();
              $current_album = $session->get('current_album');
              $ostPop        = $session->get("popitka/$current_album");
              if (!$may_view && $current_album != NULL) {
                     ?>
                     <div class="row">
                            <div class="page">
                                   <a class="next"
                                      href="/fotobanck_adw.php?back_to_albums">« назад</a> <a class="next"
                                                                                              href="/fotobanck_adw.php">« попробовать еще раз</a>
                            </div>
                            <img style="margin: 20px 0 0 40px;"
                                 src="/img/Stop Photo Camera.png"
                                 width="348"
                                 height="350"/>
                            <?
                                   if ($ostPop == -10) // проверка и вывод времени бана
                                   {
                                          echo "<script type='text/javascript'>
                                             $(document).ready(function(){
                                             $('#zapret').modal('show');
                                             });
                                             function gloze() {
                                             $('#zapret').modal('hide');
                                             location='/fotobanck_adw.php?back_to_albums';
                                             }
                                             setTimeout('gloze()', 10000);
                                             </script>";
                                          $session->set("popitka/$current_album", 5);
                                   }
                            ?>
                     </div>
              <?
              }
       }



       /**
        * @param $may_view
        * @param $rs
        * @param $ln
        * @param $source
        * @param $sz
        * @param $sz_string
        *
        * @todo function top5
        */
       function top5($may_view, &$rs, &$ln, &$source, &$sz, &$sz_string) {

              $session = check_Session::getInstance();
              if ($may_view) {
                     ?>
                     <div class="cont-list"
                          style="margin-left: 50%">
                            <div class="drop-shadow curved curved-vt-2">
                                   <h3><span style="color: #c95030"> Топ 5 альбома:</span></h3>
                            </div>
                     </div><br><br><br>
                     <!-- 1 -->
                     <hr class="style-one"
                         style="margin: 0 0 -20px 0;"/>
                     <?
                     $rs = go\DB\query('select * from photos where id_album = ?i order by votes desc, id asc limit 0, 5',
                                                                          array($session->get('current_album')), 'assoc');
                     $id_foto = array();
                     if ($rs) {
                            $pos_num = 1;
                            foreach ($rs as $ln) {
                                   $source            =
                                          $_SERVER['DOCUMENT_ROOT'].fotoFolder().$ln['id_album'].'/'
                                          .$ln['img'];
                                   $sz                = @getimagesize($source);
                                   $id_foto[$pos_num] = ($ln['id']);
                                   /**
                                    * размер топ 5
                                    */
                                   if (intval($sz[0]) > intval($sz[1])) {
                                          $sz_string = 'width="165px"';
                                   } else {
                                          $sz_string = 'height="195px"';
                                   }
                                   ?>
                                   <div id="foto_top">
                                          <figure class="ramka"
                                                  onClick="previewTop(<?= $ln['id'] ?>);">

                                                 <span class="top_pos"
                                                       style="opacity: 0;"><?=$pos_num?></span> <img class="lazy"
                                                                                                     data-original="thumb.php?num=<?= substr(trim($ln['img']), 2,
                                                                                                            -4) ?>"
                                                                                                     id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                                                                     src=""
                                                                                                     alt="<?= $ln['nm'] ?>"
                                                                                                     title="Нажмите для просмотра" <?=$sz_string?> />
                                                 <figcaption><span style="font-size: x-small; font-family: Times, serif; ">№ <?=$ln['nm']?>
                                                                                                                           Голосов:<span class="badge badge-warning">
																									<span id="s<?= substr(trim($ln['img']), 2, -4) ?>"
                                                        style="font-size: x-small; font-family: 'Open Sans', sans-serif; "><?=$ln['votes']?></span>
                								 </span><div id="d<?= substr(trim($ln['img']), 2, -4) ?>"
                                             style="width: 146px;">
                                                                      Рейтинг: <?echo str_repeat('<img src="/img/reyt.png"/>', floor($ln['votes'] / 5));?>
                                                               </div></span></figcaption>
                                          </figure>
                                   </div>
                                   <?
                                   $pos_num++;
                            }
                     }
                     ?>
                     <div style="clear: both"></div>
              <?
              }
       }


       /**
        * @param $may_view
        * @param $rs
        * @param $ln
        * @param $source
        * @param $sz
        * @param $sz_string
        *
        * function top5Modern
        */

       function top5Modern($may_view, &$rs, &$ln, &$source, &$sz, &$sz_string) {

              $session = check_Session::getInstance();
              if ($may_view) {
                     ?>
                     <div class="cont-list"
                          style="margin-left: 50%">
                            <div class="drop-shadow curved curved-vt-2">
                                   <h3><span style="color: #c95030"> Топ 5 альбома:</span></h3>
                            </div>
                     </div><br><br><br>
                     <!-- 1 -->
                     <hr class="style-one"
                         style="margin: 0 0 -20px 0;"/>
                     <?
                     $rs = go\DB\query('select * from photos where id_album = ?i
						            order by votes desc, id asc limit 0, 5', array($session->get('current_album')), 'assoc');
                     $id_foto = array();
                     if ($rs) {
                            $pos_num = 1;
                            foreach ($rs as $ln) {
                                   $source            = $_SERVER['DOCUMENT_ROOT'].fotoFolder().$ln['id_album'].'/'.$ln['img'];
                                   $sz                = @getimagesize($source);
                                   $id_foto[$pos_num] = ($ln['id']);
                                   /**
                                    *   размер топ 5
                                    */
                                   if (intval($sz[0]) > intval($sz[1])) {
                                          $sz_string = 'width="165px"';
                                   } else {
                                          $sz_string = 'height="195px"';
                                   }
                                   ?>
                                   <div id="foto_top">
                                          <a class="modern"
                                             href="/dir.php?num=<?= substr(($ln['img']), 2, -4) ?>"
                                             title="Фото № <?= $ln['nm'] ?>"
                                             data-placement="bottom"
                                             data-original-title="Фото № <?= $ln['nm'] ?>">
                                                 <figure class="ramka">
                                                        <span class="top_pos"
                                                              style="opacity: 0;"><?=$pos_num?></span>
                                                        <img class="lazy"
                                                             data-original="thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
                                                             id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                             src="" alt="<?= $ln['nm'] ?>"
                                                             title="<?= $pos_num ?> место в рейтинге голосования" <?=$sz_string?>
                                                             data-placement="top"/>
                                                        <figcaption><span style="font-size: x-small; font-family: Times, serif; ">№ <?=$ln['nm']?>Голосов:<span class="badge badge-warning">
                                                            <span id="s<?= substr(trim($ln['img']), 2, -4) ?>"
                                                                  style="font-size: x-small; font-family: 'Open Sans', sans-serif; "><?=$ln['votes']?></span>
                                   </span><div id="d<?= substr(trim($ln['img']), 2, -4) ?>"
                                               style="width: 146px;">Рейтинг: <?echo str_repeat('<img src="/img/reyt.png"/>', floor($ln['votes']/ 5));?>
                                                                      </div></span>
                                                        </figcaption>
                                                 </figure>
                                          </a>
                                   </div>
                                   <?
                                   $pos_num++;
                            }
                     }
                     ?>
                     <div style="clear: both"></div>
              <?
              }
       }

       /**
        * @param $may_view
        */
       function parol($may_view) {
              $session       = check_Session::getInstance();
              $current_album = $session->get('current_album');
              if (!$may_view && $current_album != NULL) {
                     $ostPop = $session->get("popitka/$current_album");
                     if ($ostPop > 0 && $ostPop <= 5) {
                            echo "<script type='text/javascript'>
                             $(document).ready(function load() {
                             $('#static').modal('show');
                             });
                             </script>";
                     }
                     if ($ostPop <= 0 && $ostPop != -10) {
                            echo "<script type='text/javascript'>
                             $(document).ready(function(){
                             $('#zapret').modal('show');
                             });
                             function gloze() {
                             $('#zapret').modal('hide');
                             location='/fotobanck_adw.php?back_to_albums';
                             }
                             setTimeout('gloze()', 10000);
                             </script>";
                            $session->set("popitka/$current_album", 5);
                            record(); //бан по Ip
                     } elseif ($ostPop > 0) {
                            $ost        = '';
                            $album_pass = $session->get("album_pass/$current_album");
                            if ($album_pass != false) {
                                   $ostPop = $session->set("popitka/$current_album",
                                          $session->get("popitka/$current_album") - 1);
                            }
                            if ($ostPop == 4) {
                                   $ost = 'У Вас осталось ';
                                   $pop = 'попыток';
                            } elseif ($ostPop == 0) {
                                   $pop = 'последняя попытка';
                            } else {
                                   $ost = 'У Вас остались ещё';
                                   $pop = 'попытки';
                            }
                            if ($ostPop != 5) {
                                   $msg = ($ost.' '.($ostPop + 1).' '.$pop);
                                   echo "<script type='text/javascript'>
                                             var infdok = document.getElementById('err-modal');
                                             var summDok = '$msg';
                                             infdok.innerHTML = summDok;
                                             dhtmlx.message({ type:'warning', text:'$msg'});
                                             </script>";
                            }
                     }
              }
       }

} 