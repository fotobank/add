<?php
       error_reporting(E_ALL | E_STRICT);
       ini_set('display_errors', 1);
       require_once(__DIR__.'/inc/config.php');
       // обработка ошибок
       require_once (__DIR__.'/inc/errorDump.php');
       // вызов ошибки
       // ERROR_CONSTANT;
       if (isset($_COOKIE['js']) &&$_COOKIE['js'] == 1) {
              define ('JS', true);
              unset ($_COOKIE['js']);   // удаляем куки JS из сервера
       } else define ('JS', false);
       $session->set("JS", JS);
       $session->set("JS_REQUEST_URI" , $_SERVER['REQUEST_URI']);
       if(!JS)  main_redir('/redirect.php');
       $session->set("JS_REDIRECT" , 0);
       setcookie('js', '', time() - 1, '/');   // удаляем куки JS из браузера

       define ('BASEPATH', realpath(__DIR__).'/', true);
       define('PHOTOS_ON_PAGE', 70);  //Количество фоток на странице
       require_once  (BASEPATH.'inc/head.php');
       /*$renderData['dataDB'] = go\DB\query('select txt from content where id = ?i', array(1), 'el');
       $loadTwig('.twig', $renderData);*/
       require_once  (BASEPATH.'inc/ip-ban.php');
       set_time_limit(0);

       // include  (dirname(__FILE__).'/inc/lib/dtimediff/diftimer_class.php'); // подсчет времени между двумя событиями
       // $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');

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
?>

<!--<div id="main">-->


       <!-- запрет доступа к альбому -->
       <?
       $current_album = $session->get('current_album');
       if ($current_album != NULL && $session->has("popitka/{$current_album}") == true) {
              $ostPop = $session->get("popitka/{$current_album}");
              if ($ostPop <= 0 || $ostPop == 5) {
                     $ret = json_decode(check(), true);
                     $renderData['ret'] = $ret;
                     $renderData['ip'] = Get_IP();
                     if ($ret['min'] == 1 || $ret['min'] == 21) {
                            $okonc = 'а';
                     } elseif ($ret['min'] == 2 || $ret['min'] == 3
                               || $ret['min'] == 4
                               || $ret['min'] == 22
                               || $ret['min'] == 23
                               || $ret['min'] == 24
                     ) {
                            $okonc = 'ы';
                     } else {
                            $okonc = '';
                     }
                     $renderData['okonc'] = $okonc;
              }
       }

       $renderData['dataDB'] = go\DB\query('select txt from content where id = ?i', array(1), 'el');
       $renderData['album_name'] = $session->get("album_name/$current_album");
       $loadTwig('.twig', $renderData);

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
                     $rs = go\DB\query('select * from photos where id_album = ?i
						   order by votes desc, id asc limit 0, 5', array($session->get('current_album')), 'assoc');
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
        * @todo function top5Modern
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

       /** начало страницы */
       if ($session->has('current_album')) {
       $current_album = $session->get('current_album');
       $album_data = go\DB\query('select * from `albums` where `id` = ?i', array($current_album), 'row');
       $may_view = false;
       if ($album_data) {
              $may_view = true;
              if ($album_data['pass'] != '') {
                     ?>
                     <div style="display: none;"><? check(); ?></div><?
                     if (isset($_POST['album_pass'])) {
                            $albPass = $session->set(
                                   "album_pass/".$album_data['id'], GetFormValue($_POST['album_pass']));
                            if ($albPass != $album_data['pass'] && $albPass != '') {
                                   echo "
																							<script type='text/javascript'>
																							// dhtmlx.message({ type:'error', text:'Пароль неправильный,<br> будьте внимательны!'});
																							humane.error('Пароль неправильный, будьте внимательны!');
																							</script>";
                            } elseif ($albPass == '') {
                                   echo "
																							<script type='text/javascript'>
																							humane('Введите, пожалуйста, пароль.');
																							</script>";
                            } else {
                                   echo "
																							<script type='text/javascript'>
																							dhtmlx.message({ type:'addfoto', text:'Вход выполнен'});
																							</script>";
                            }

                     }
                     $may_view = ($session->get('album_pass/'.$album_data['id'])
                                  == $album_data['pass']); // переменная пароля
              } else {
                     $session->del("popitka/$current_album");
              }
       } else {
              $session->del('current_album');
       }

       /** Отключить проверку пароля */
//     $may_view = true;

       // <!-- Ввод и блокировка пароля -->


       $razdel = go\DB\query('select nm from `categories` where id = ?i', array($session->get('current_cat')), 'el');
       parol($may_view);
       // <!-- Проверка пароля на блокировку -->
       verifyParol($may_view);

       /**
        *  Аккордеон
        */
       if ($may_view) {

       $current_album = $session->get('current_album');
       $disable_photo_display = go\DB\query('select `disable_photo_display` from `albums` where `id` =?i', array($current_album), 'el');
       //		отключение аккордеона если фотографии не показываются
       if ($disable_photo_display === 'on' && JS) {
              $acc[1]              = go\DB\query('SELECT * FROM accordions WHERE `id_album` = ?i ', array('1'), 'assoc:collapse_numer');
              $acc[$current_album] = go\DB\query('SELECT * FROM accordions WHERE `id_album` = ?i ', array($current_album), 'assoc:collapse_numer');
              if ($acc[$current_album]) {
                     if ($acc[$current_album][1]['accordion_nm'] != '') {
                            echo "
																				<div class='profile'>
																				<div id='garmon' class='span12 offset1'>
																				<div class='accordion' id='accordion2'>";
                            foreach ($acc[$current_album] as $key => $accData) {
                                   if ($key == 1) {
                                          $in = 'in';
                                   } else {
                                          $in = '';
                                   }
                                   $collapse_nm = $acc[$current_album][$key]['collapse_nm'];
                                   if ($collapse_nm == 'default') {
                                          $collapse_nm =
                                                 $acc[1][$key]['collapse_nm'];
                                   }
                                   $collapse = $acc[$current_album][$key]['collapse'];
                                   if ($collapse == '') {
                                          $collapse = $acc[1][$key]['collapse'];
                                   }
                                   echo "
                  								<div class='accordion-group'>
																	<div class='accordion-heading'>
																	<a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapse".$key."'>".$collapse_nm."</a>
                                      </div>
                                      <div id='collapse".$key."' class='accordion-body collapse ".$in."'>
                                      <div class='accordion-inner'>
                                      <p class='bukvica'><span style='font-size:11.0pt;'>".$collapse."</span></p>
                                  </div>
                                      </div>
                                          </div>	";

                            }
                            $nameButton = ($acc[$current_album][$key]['accordion_nm'] == 'default') ?
                                   $acc[1][1]['accordion_nm'] :
                                   $acc[$current_album][$key]['accordion_nm'];
                            echo "
																											</div>
																											<a class='profile_bitton2' href='#'>Закрыть</a>
																											</div></div>
																											<div><a class='profile_bitton' href='#'>".$nameButton."</a></div>";
                     }
              }
       }
       ?>
<!--</div>-->
       <script language=JavaScript type="text/javascript">
              $(function () {
                     $('.modern').click(function () {
                            onJS('/js_test.php');
                            return false;
                     });
              });
              $(function () {
                     $('.profile_bitton , .profile_bitton2').click(function () {
                            $('.profile').slideToggle();
                            return false;
                     });
              });
       </script>

       <!-- кнопки назад -->
       <div class="page">
              <a class="next"
                 href="/fotobanck_adw.php?back_to_albums">« назад</a> <a class="next"
                                                                         href="/fotobanck_adw.php?unchenge_cat">« выбор категорий </a>
              <a class="next"
                 href="/fotobanck_adw.php?back_to_albums">« раздел "<?=$razdel?>"</a> <a class="next">« альбом "<?=$album_data['nm']?>
                                                                                                      "</a>
       </div>

       <!-- Название альбома  -->
       <div class="cont-list"
            style="margin: 40px 10px 30px 0;">
              <div class="drop-shadow lifted">
                     <h2><span style="color: #00146e;">Фотографии альбома "<?=$album_data['nm']?>"</span>
                     </h2>
              </div>
       </div>
       <div style="clear: both;"></div>

       <!--/**	выводим фотографию - заголовок альбома*/ -->
       <div id="alb_opis"
            class="span3">
              <div class="alb_logo">
                     <div id="fb_alb_fotoP">
                            <img src="album_id.php?num=<?= substr(($album_data['img']), 2, -4) ?>"
                                 width="130px"
                                 height="124px"
                                 alt="-"/>
                     </div>
              </div>
              <?=$album_data['descr']?>
       </div>

       <?

       // выдавать контент только c включенным JS в браузере
       if (JS) {
              $disable_photo_display = go\DB\query('select `disable_photo_display` from `albums` where `id` =?i', array($current_album), 'el');
              //		отключение показа фотографий в альбоме
              if ($disable_photo_display === 'on') {
                     //		<!-- вывод топ 5  -->
                     top5Modern($may_view, $rs, $ln, $source, $sz, $sz_string);
                     if (!$session->has('record_count/'.$current_album)) {
                            $rs = go\DB\query('select SQL_CALC_FOUND_ROWS p.* from photos p where id_album = ?i', array($current_album), 'assoc');
                            $session->set('record_count/'.$current_album, go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el')); // количество записей
                     }
                     $page = "pg"; // название GET страницы
                     $pager = new Pager2($session->get("record_count/".intval($current_album)), PHOTOS_ON_PAGE, new pagerHtmlRenderer());
                     $pager->delta = 3;
                     $pager->firstPagesCnt = 3;
                     $pager->lastPagesCnt = 3;
                     $pager->setPageVarName($page);
                     $pager->enableCacheRemover = false;
                     $pager->renderTop();
                     // $pager->printDebug();
                     ?>

                     <!-- Вывод фото в альбом -->
                     <div id="modern">
                            <?
                            $width = 170; // ширина горизонтальной превью в px
                            $current_page = isset($_GET[$page]) ? (int)$_GET[$page] : 0;
                            fotoPageModern($may_view, $current_page, $width);
                            ?>
                     </div>

                     <script type="text/javascript">
                            $(function () {
                                   $("img.lazy").lazyload({
                                          threshold: 200,
                                          effect: "fadeIn"
                                   });
                            });
                     </script>

                     <!-- тело --><!-- 4 -->
                     <hr class="style-one"
                         style="clear: both; margin-bottom: -20px; margin-top: 0"/>

                     <?
                     $pager->render();
                     // $pager->printDebug();
              } else {
                     /**  подписка на альбом (когда альбом появится в категории)*/
                     $rs['current_album'] = $current_album;
                     $loadTwig('_podpiska.twig', $rs);

              }
       } else {
              ?>
              <br><br>
                     <hfooter style="font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;"
                            >В Вашем браузере не работает JavaScript!
                     </hfooter>
              <script type='text/javascript'>
                     $(function(){
                       window.document.location.href = '<?= $_SERVER['REQUEST_URI'] ?>';
                     }
              </script>
              <NOSCRIPT>
                     <br><br>
                     <hfooter style="font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;"
                            >Из - за отключенной JavaScript показ фотографий невозможен!
                             ( <a href="http://www.enable-javascript.com/ru/">Как включить JavaScript?</a>)
                     </hfooter>
              </NOSCRIPT>
       <?
       }

} else {
       ?>
       <div class="center" style="margin-top: 30px;">
       <hfooter style="font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;">
              Альбом заблокирован паролем
       </hfooter>
       </div>
       <div class="center" style="margin-top: 30px;">
       <NOSCRIPT>
              <hfooter style="font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;">
                     При отключенной JavaScript функционал сайта заблокирован! ( <a href="http://www.enable-javascript.com/ru/">Как включить JavaScript?</a> )
              </hfooter>
       </NOSCRIPT>
       </div>
       <?
       }

       /** Вывод альбомов в разделах */
} else {
       if ($session->has("current_cat")) {
              $current_cat = intval($session->get("current_cat"));
       } else {
              $current_cat = -1;
       }
       if ($current_cat > 0) {
              /** $rs['albums'][0]['txt'] - Вывод текстовой информации на страницы разделов */
              $rs['albums'] = go\DB\query('select c.nm as razdel, c.txt, a.* from categories as c, albums as a where c.id = ?i and a.id_category = ?i
                                           order by a.order_field asc', array($current_cat, $current_cat), 'assoc');
              /**  Печать альбомов*/
              $loadTwig('_razdel.twig', $rs);
       } else {
              /**  кнопки разделов (категорий) */
              $buttons['buttons'] = go\DB\query('select * from categories order by `id_num` asc', NULL, 'assoc:id');
              $loadTwig('_kategorii.twig', $buttons);

       }

}
       $renderData['include_Js_banck'] = array('js/visLightBox/js/visuallightbox.js', 'js/photo-prev.js', 'js/visLightBox/js/vlbdata.js');
       $loadTwig('_footer.twig', $renderData);
       include (BASEPATH.'inc/footer.php');
?>
