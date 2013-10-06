<?php
       error_reporting(E_ALL | E_STRICT);
       ini_set('display_errors', 1);
       require_once (__DIR__.'/classes/autoload.php');
       autoload::getInstance();
       // ��������� ������
       require_once (__DIR__.'/inc/errorDump.php');
       // ����� ������
    //   ERROR_CONSTANT;
       if (isset($_COOKIE['js']) && $_COOKIE['js'] == 1) {
              define ('JS', true);
              unset ($_COOKIE['js']);
       } else define ('JS', false);
       setcookie('js', '', time() - 1, '/');
       define ('BASEPATH', realpath(__DIR__).'/', true);
       require_once  (BASEPATH.'inc/head.php');
       $dataDB               = go\DB\query('select txt from content where id = ?i', array(1), 'el');
       $renderData['dataDB'] = $dataDB;
       $loadTwig('.twig', $renderData);
       require_once  (BASEPATH.'inc/ip-ban.php');
       set_time_limit(0);
       // include  (dirname(__FILE__).'/inc/lib/dtimediff/diftimer_class.php'); // ������� ������� ����� ����� ���������
       // $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
       //���������� ����� �� ��������
       define('PHOTOS_ON_PAGE', 70);
       if (isset($_GET['album_id'])) {
              $current_album = $session->set('current_album', intval($_GET['album_id']));
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
       <div id="main">

       <!-- ���� ������ -->
       <div class="modal-scrolable"
            style="z-index: 150;">
              <div id="static"
                   class="modal hide fade in animated fadeInDown"
                   data-keyboard="false"
                   data-backdrop="static"
                   tabindex="-1"
                   aria-hidden="false">
                     <div class="modal-header">
                            <h3 style="color: #444444">���� ������:</h3>
                     </div>
                     <div class="modal-body">

                            <div style="ttext_white">
                                   �� ������ ������ ���������� ������. ���� � ��� ��� ������ ��� ����� ��� �� ������ , ���������� ��������� � ��������������� �����
                                   ����� email � ������� <a href="kontakty.php"><span class="ttext_blue">"��������"</span>.</a>
                            </div>
                            <br/>

                            <form action="/fotobanck_adw.php"
                                  method="post">
                                   <label for="inputError"
                                          class="ttext_red"
                                          style="float: left; margin-right: 10px;">������: </label> <input id="inputError"
                                                                                                           type="text"
                                                                                                           name="album_pass"
                                                                                                           value=""
                                                                                                           maxlength="20"/> <input class="btn-small btn-primary"
                                                                                                                                   type="submit"
                                                                                                                                   value="����"/>
                            </form>
                     </div>
                     <div class="modal-footer">
                            <p id="err-modal"
                               style="float: left;"></p>
                            <button type="button"
                                    data-dismiss="modal"
                                    class="btn"
                                    onClick="window.document.location.href='/fotobanck_adw.php?back_to_albums'">
                                   � �� ����
                            </button>
                     </div>
              </div>
       </div>


       <!-- ������ -->
       <div id="error_inf"
            class="modal hide fade"
            tabindex="-1"
            data-replace="true">
              <div class="modal-header">
                     <button type="button"
                             class="close"
                             data-dismiss="modal"
                             aria-hidden="true">x
                     </button>
                     <h3 style="color:red">������������ ������.</h3>
              </div>
              <div class="modal-body">
                     <div>
                            <a href="kontakty.php"><span class="ttext_blue">������ ������?</span></a>
                     </div>
              </div>
       </div>


       <!-- ������ ������� � ������� -->
       <?
       $current_album = $session->get('current_album');
       if ($current_album != NULL && $session->has("popitka/$current_album") == true) {
              $ostPop = $session->get("popitka/$current_album");
              if ($ostPop <= 0 || $ostPop == 5) {
                     ?>
                     <div id="zapret"
                          class="modal hide fade"
                          tabindex="-1"
                          data-replace="true"
                          style=" margin-top: -180px;">
                            <div class="err_msg">
                                   <div class="modal-header">
                                          <h3 style="color:#fd0001">������ � ������� "
                                                 <?
                                                 $album_name = $session->get("album_name/$current_album");
                                                 echo $album_name;
                                                 ?>" ������������!</h3>
                                   </div>
                                   <div class="modal-body">
                                          <div style="color:black">�� ������������ 5 ������� ����� ������.� ����� ������, ��� IP ������������ �� 30 �����.
                                          </div>
                                          <br>
                                          <?
                                          $ret = json_decode(check(), true);

                                          if ($ret['min'] == 1 || $ret['min'] == 21) {
                                                 $okonc = '�';
                                          } elseif ($ret['min'] == 2 || $ret['min'] == 3
                                                    || $ret['min'] == 4
                                                    || $ret['min'] == 22
                                                    || $ret['min'] == 23
                                                    || $ret['min'] == 24
                                          ) {
                                                 $okonc = '�';
                                          } else {
                                                 $okonc = '';
                                          }

                                          ?>
                                          <h2>�������� <span id='timer'
                                                             long='<?=
                                                             $ret['min'].':'.$ret['sec'] ?>'><?=
                                                        $ret['min'].':'.$ret['sec'] ?></span> �����<?=$okonc?>
                                          </h2>
                                          <script type='text/javascript'>
                                                 $(function () {
                                                        var t = setInterval(function () {
                                                               function f(x) {
                                                                      return (x / 100).toFixed(2).substr(2)
                                                               }

                                                               var o = document.getElementById('timer'), w = 60, y = o.innerHTML.split(':'),
                                                                      v = y [0] * w + (y [1] - 1), s = v % w, m = (v - s) / w;
                                                               if (s < 0)
                                                                      var v = o.getAttribute('long').split(':'), m = v [0], s = v [1];
                                                               o.innerHTML = [f(m), f(s)].join(':');
                                                        }, 1000);
                                                 });
                                          </script>
                                          <br> <br> <a href="/kontakty.php"><span class="ttext_blue">�������������� ������</span></a> <a style="float:right"
                                                                                                                                         class="btn btn-danger"
                                                                                                                                         data-dismiss="fotobanck_adw.php"
                                                                                                                                         href="/fotobanck_adw.php?back_to_albums">�������</a>
                                   </div>
                            </div>
                     </div>
              <?
              }
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
                     $start        = ($current_page - 1) * PHOTOS_ON_PAGE;
                     $rs           = go\DB\query(
                            'select SQL_CALC_FOUND_ROWS p.* from photos p where id_album = ?i order by img ASC, id ASC limit ?i, '.PHOTOS_ON_PAGE,
                            array($_SESSION['current_album'], $start), 'assoc');
                     $record_count = go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el'); // ���������� �������
                     if ($rs) {
                            ?>
                            <!-- 3 -->
                            <hr class="style-one"
                                style="margin-top: 10px; margin-bottom: -20px;">
                            <?
                            foreach ($rs as $ln) {
                                   $source = ($_SERVER['DOCUMENT_ROOT'].fotoFolder().$ln['id_album'].'/'.$ln['img']);
                                   $sz     = @getimagesize($source);
                                   /* ������ ��������� */
                                   if (intval($sz[0]) > intval($sz[1])) {
                                          $preW = "155px;";
                                          $preH = "170px;";
                                          $ImgWidth  = intval($sz[1]);
                                          $ImgHeight = intval($sz[0]);
                                   } else {
                                          $preW = "170px;";
                                          $preH = "155px;";
                                          $ImgWidth  = intval($sz[0]);
                                          $ImgHeight = intval($sz[1]);
                                   }
                                   ?>
                                   <div class="podlogka">
                                          <figure class="ramka"
                                                  onClick="preview(<?= $ln['id'] ?>, <?= $ImgWidth ?>, <?= $ImgHeight ?>);">
                                                 <img class="lazy"
                                                      data-original="/thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
                                                      id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                      width="<?=$preW?>"
                                                      height="<?=$preH?>"
                                                      src=""
                                                      title="�� ���������� ������������� <?= $ln['votes'] ?> �������. ������� ��� ���������." />
                                                 <figcaption>� <?=$ln['nm']?></figcaption>
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

              // ������������� ����������
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
       function fotoPageModern($may_view, &$current_page, $width = 170) {

              $session      = check_Session::getInstance();
              $current_page = isset($_GET['current_page']) ? intval($_GET['current_page']) : 0;
              $widthSait    = 1200; // px
              $margP        = 50; // �������������� ������ ������ px
              if ($may_view) {
                     $start = $current_page * PHOTOS_ON_PAGE;
                     $rs    = go\DB\query(
                            'select SQL_CALC_FOUND_ROWS p.* from photos p where id_album = ?i
                             order by img ASC, id ASC limit ?i,'.PHOTOS_ON_PAGE,
                            array($session->get('current_album'), $start), 'assoc');
                     $record_count                                             = go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el'); // ���������� �������
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
                            foreach ($rs as $key => $ln) {
                                   $source = ($_SERVER['DOCUMENT_ROOT'].fotoFolder().$ln['id_album'].'/'.$ln['img']);
                                   $sz     = @getimagesize($source);
                                   /* ������ ��������� px */
                                   if (intval($sz[0]) > intval($sz[1])) {
                                          $sz_string = 'width="'.$width.'px"';
                                          $preW = 'width="'.$width.'px"';
                                          $preH = 'height="'.($width / 1.327).'px"';
                                   } else {
                                          $sz_string = 'height="'.($width * 1.066).'px"';
                                          $preW = 'height="'.($width * 1.066).'px"';
                                          $preH = 'width="'.($width / 1.247).'px"';
                                   }
                                   if ((($kollFoto == $koll))) {
                                          ?>
                                          <a class="modern"
                                             style="position: absolute; float: right;"
                                             href="/dir.php?num=<?= substr(($ln['img']), 2, -4) ?>"
                                             title="���� � <?= $ln['nm'] ?>"> <img id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                                                   class="lazy" <?=$preW?> <?=$preH?>
                                                                                   src=""
                                                                                   data-original="/thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
                                                                                   alt="� <?= $ln['nm'] ?>"/>� <?=$ln['nm']?>
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
                                             href="/dir.php?num=<?= substr(($ln['img']), 2, -4) ?>"
                                             title="���� � <?= $ln['nm'] ?>"> <img
                                                        id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                        class="lazy" <?=$preW?> <?=$preH?>
                                                        src=""
                                                        data-original="/thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
                                                        alt="� <?= $ln['nm'] ?>"/>� <?=$ln['nm']?>
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
                                      href="/fotobanck_adw.php?back_to_albums">� �����</a> <a class="next"
                                                                                              href="/fotobanck_adw.php">� �����������
                                                                                                                        ��� ���</a>
                            </div>
                            <img style="margin: 20px 0 0 40px;"
                                 src="/img/Stop Photo Camera.png"
                                 width="348"
                                 height="350"/>
                            <!--						<h3><span style="color: #ffa500">������ � ������� ������������ �������.  -->
                            <?// //check();?><!--</span></h3>-->
                            <?
                            if ($ostPop == -10) // �������� � ����� ������� ����
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
                                   <h3><span style="color: #c95030"> ��� 5 �������:</span></h3>
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
                                    * @todo  ������ ��� 5
                                    */
                                   if (intval($sz[0]) > intval($sz[1])) {
                                          $sz_string = 'width="165px"';
                                          $ImgWidth  = intval($sz[1]);
                                          $ImgHeight = intval($sz[0]);
                                   } else {
                                          $sz_string = 'height="195px"';
                                          $ImgWidth  = intval($sz[0]);
                                          $ImgHeight = intval($sz[1]);
                                   }
                                   ?>
                                   <div id="foto_top">
                                          <!--  <div  class="span2 offset0" >-->
                                          <figure class="ramka"
                                                  onClick="previewTop(<?= $ln['id'].','.$ImgWidth.','.$ImgHeight ?>);">

                                                 <span class="top_pos"
                                                       style="opacity: 0;"><?=$pos_num?></span> <img class="lazy"
                                                                                                     data-original="thumb.php?num=<?= substr(trim($ln['img']), 2,
                                                                                                            -4) ?>"
                                                                                                     id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                                                                     src=""
                                                                                                     alt="<?= $ln['nm'] ?>"
                                                                                                     title="������� ��� ���������" <?=$sz_string?> />
                                                 <figcaption><span style="font-size: x-small; font-family: Times, serif; ">� <?=$ln['nm']?>
                                                                                                                           �������:<span class="badge badge-warning">
																									<span id="s<?= substr(trim($ln['img']), 2, -4) ?>"
                                                        style="font-size: x-small; font-family: 'Open Sans', sans-serif; "><?=$ln['votes']?></span>
                								 </span><div id="d<?= substr(trim($ln['img']), 2, -4) ?>"
                                             style="width: 146px;">
                                                                      �������: <?echo str_repeat('<img src="/img/reyt.png"/>', floor($ln['votes'] / 5));?>
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
                                   <h3><span style="color: #c95030"> ��� 5 �������:</span></h3>
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
                                    *   ������ ��� 5
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
                                             title="���� � <?= $ln['nm'] ?>"
                                             data-placement="bottom"
                                             data-original-title="���� � <?= $ln['nm'] ?>">
                                                 <figure class="ramka">
                                                        <span class="top_pos"
                                                              style="opacity: 0;"><?=$pos_num?></span> <img class="lazy"
                                                                                                            data-original="thumb.php?num=<?= substr(trim($ln['img']),
                                                                                                                   2, -4) ?>"
                                                                                                            id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                                                                            src=""
                                                                                                            alt="<?= $ln['nm'] ?>"
                                                                                                            title="<?= $pos_num ?> ����� � �������� �����������" <?=$sz_string?>
                                                                                                            data-placement="top"/>
                                                        <figcaption><span style="font-size: x-small; font-family: Times, serif; ">� <?=$ln['nm']?>
                                                                                                                                  �������:<span
                                                                             class="badge badge-warning"> <span id="s<?= substr(trim($ln['img']),
                                                                                    2,
                                                                                    -4) ?>"
                                                                                                                style="font-size: x-small; font-family: 'Open Sans', sans-serif; "><?=$ln['votes']?></span>
                 </span><div id="d<?= substr(trim($ln['img']),
                                                                             2,
                                                                             -4) ?>"
                             style="width: 146px;">
                                                                             �������: <?echo str_repeat('<img src="/img/reyt.png"/>', floor(
                                                                                    $ln['votes']
                                                                                    / 5));?>
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
                            record(); //��� �� Ip
                     } elseif ($ostPop > 0) {
                            $ost        = '';
                            $album_pass = $session->get("album_pass/$current_album");
                            if ($album_pass != false) {
                                   $ostPop = $session->set("popitka/$current_album",
                                          $session->get("popitka/$current_album") - 1);
                            }
                            if ($ostPop == 4) {
                                   $ost = '� ��� �������� ';
                                   $pop = '�������';
                            } elseif ($ostPop == 0) {
                                   $pop = '��������� �������';
                            } else {
                                   $ost = '� ��� �������� ���';
                                   $pop = '�������';
                            }
                            if ($ostPop != 5) {
                                   $msg = ($ost.' '.($ostPop + 1).' '.$pop);
                                   echo "<script type='text/javascript'>
                        var infdok = document.getElementById('err-modal');
                        var SummDok = '$msg';
                        infdok.innerHTML = SummDok;
												dhtmlx.message({ type:'warning', text:'$msg'});
                        </script>";
                            }
                     }
              }
       }

       //	������ ��������
       if ($session->has('current_album')) {
       $current_album = $session->get('current_album');
       $album_data = go\DB\query('select * from albums where id = ?i', array($current_album), 'row');
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
																							// dhtmlx.message({ type:'error', text:'������ ������������,<br> ������ �����������!'});
																							humane.error('������ ������������, ������ �����������!');
																							</script>";
                            } elseif ($albPass == '') {
                                   echo "
																							<script type='text/javascript'>
																							humane('�������, ����������, ������.');
																							</script>";
                            } else {
                                   echo "
																							<script type='text/javascript'>
																							dhtmlx.message({ type:'addfoto', text:'���� ��������'});
																							</script>";
                            }

                     }
                     $may_view = ($session->get('album_pass/'.$album_data['id'])
                                  == $album_data['pass']); // ���������� ������
              } else {
                     $session->del("popitka/$current_album");
              }
       } else {
              $session->del('current_album');
       }

       // @todo ��������� �������� ������
       // $may_view = true;

       // <!-- ���� � ���������� ������ -->

       parol($may_view);

       $razdel = go\DB\query('select nm from `categories` where id = ?i', array($session->get('current_cat')), 'el');

       //	dump_r($razdel);

       // <!-- �������� ������ �� ���������� -->

       verifyParol($may_view);

       //	dump_r($may_view);
       /**
        *  ���������
        */
       if ($may_view) {

       $current_album = $session->get('current_album');
       $event = go\DB\query('select `event` from `albums` where `id` =?i', array($current_album), 'el');
       //		���������� ���������� ���� ���������� �� ������������
       if ($event == 'on' && JS) {
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
																										<a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapse"
                                        .$key."'>
                  		".$collapse_nm."
                 			 </a>
																										</div>
																										<div id='collapse".$key."' class='accordion-body collapse ".$in."'>
																										<div class='accordion-inner'>
																										<p class='bukvica'><span style='font-size:11.0pt;'>
                 							 ".$collapse."
                  							</span></p>
																								</div>
																										</div>
																												</div>	";

                            }
                            $nameButton = ($acc[$current_album][$key]['accordion_nm'] == 'default') ?
                                   $acc[1][1]['accordion_nm'] :
                                   $acc[$current_album][$key]['accordion_nm'];
                            echo "
																											</div>
																											<a class='profile_bitton2' href='#'>�������</a>
																											</div></div>
																											<div><a class='profile_bitton' href='#'>".$nameButton."</a></div>";
                     }
              }
       }
       ?>
       </div>
       <script language=JavaScript
               type="text/javascript">
              $(function () {
                     $('.profile_bitton , .profile_bitton2').click(function () {
                            $('.profile').slideToggle();
                            return false;
                     });
              });
       </script>

       <!-- ������ ����� -->
       <div class="page">
              <a class="next"
                 href="/fotobanck_adw.php?back_to_albums">� �����</a> <a class="next"
                                                                         href="/fotobanck_adw.php?unchenge_cat">� ����� ��������� </a>
              <a class="next"
                 href="/fotobanck_adw.php?back_to_albums">� ������ "<?=$razdel?>"</a> <a class="next">� ������ "<?=$album_data['nm']?>
                                                                                                      "</a>
       </div>

       <!-- �������� �������  -->
       <div class="cont-list"
            style="margin: 40px 10px 30px 0;">
              <div class="drop-shadow lifted">
                     <h2><span style="color: #00146e;">���������� ������� "<?=$album_data['nm']?>"</span>
                     </h2>
              </div>
       </div>
       <div style="clear: both;"></div>

       <!--/**	������� ���������� - ��������� �������*/ -->
       <div id="alb_opis"
            class="span3">
              <div class="alb_logo">
                     <div id="fb_alb_fotoP">
                            <img src="album_id.php?num=<?= substr(($album_data['img']),
                                   2, -4) ?>"
                                 width="130px"
                                 height="124px"
                                 alt="-"/>
                     </div>
              </div>
              <?=$album_data['descr']?>
       </div>

       <?

       // �������� ������� c JS
       if (JS) {
              $event = go\DB\query('select `event` from `albums` where `id` =?i', array($current_album), 'el');
              //		���������� ������ ���������� � �������
              if ($event == 'on') {
                     //		<!-- ����� ��� 5  -->
                     top5Modern($may_view, $rs, $ln, $source, $sz, $sz_string);
                     if (!$session->has('record_count/'.$current_album)) {
                            $rs = go\DB\query(
                                   'select SQL_CALC_FOUND_ROWS p.* from photos p where id_album = ?i',
                                   array($current_album), 'assoc');
                            $session->set('record_count/'.$current_album, go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el')); // ���������� �������
                     }
                     $pager = new Pager2($session->get("record_count/$current_album"), PHOTOS_ON_PAGE, new pagerHtmlRenderer());
                     $pager->setDelta(3);
                     $pager->setFirstPagesCnt(3);
                     $pager->setLastPagesCnt(3);
                     $pager->setPageVarName("current_page");
                     $pager->enableCacheRemover = true;
                     echo $pager->renderTop();
                     //	$pager->printDebug();
                     ?>

                     <!-- ����� ���� � ������ -->
                     <div id="modern">
                            <?
                            $width = 170; // ������ �������������� ������ � px
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

                     <!-- ���� --><!-- 4 -->
                     <hr class="style-one"
                         style="clear: both; margin-bottom: -20px; margin-top: 0"/>

                     <?
                     $pager = new Pager2($session->get('record_count/'.$current_album), PHOTOS_ON_PAGE, new pagerHtmlRenderer());
                     $pager->setDelta(3);
                     $pager->setFirstPagesCnt(3);
                     $pager->setLastPagesCnt(3);
                     $pager->setPageVarName("current_page");
                     $pager->enableCacheRemover = true;
                     echo $pager->render();
                     //		$pager->printDebug();
              } else {
                     /**  �������� �� ������ (����� ������ �������� � ���������)*/
                     $rs['current_album'] = $current_album;
                     $loadTwig('_podpiska.twig', $rs);

              }
       } else {
              ?>
              <NOSCRIPT>
                     <br><br>
                     <hfooter style="font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;"
                            >�� - �� ����������� JavaScript ����� ���������� ����������!
                             ( <a href="http://www.enable-javascript.com/ru/">��� �������� JavaScript?</a>)
                     </hfooter>
              </NOSCRIPT>
       <?
       }

       //else:  include (__DIR__.'/error_.php');
}  else {
       ?>

<br><br>
       <hfooter style="margin-left: 35px; font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;"
              >������ ������������ �������.
       </hfooter>

       <NOSCRIPT>
              <br><br>
              <hfooter style="margin-left: 90px; font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;"
                     >��� ����������� JavaScript ���������� ����� ������������! ( <a href="http://www.enable-javascript.com/ru/">��� �������� JavaScript?</a>)
              </hfooter>
       </NOSCRIPT>

<?
}

       /** ����� �������� � �������� */
} else {
       if ($session->has("current_cat")) {
              $current_cat = intval($session->get("current_cat"));
       } else {
              $current_cat = -1;
       }
       if ($current_cat > 0) {
              /** ������� ���� nm �� �� � ����� */
              $rs['razdel'] = go\DB\query('select nm from categories where id = ?i', array($session->get("current_cat")), 'el');
              $rs['albums'] = go\DB\query('select * from albums where id_category = ?i order by order_field asc', array($current_cat), 'assoc');
              /** ����� ��������� ���������� �� �������� �������� */
              $rs['txt'] = go\DB\query('select txt from categories where id = ?i', array($current_cat), 'el');
              /**  ������ ��������*/
              $loadTwig('_razdel.twig', $rs);
       } else {
              /**  ������ �������� (���������) */
              $buttons['buttons'] = go\DB\query('select * from `categories` order by `id_num` asc', NULL, 'assoc:id');
              $loadTwig('_kategorii.twig', $buttons);

       }

}
       $renderData['include_Js_banck'] = array('js/visLightBox/js/visuallightbox.js', 'js/photo-prev.js', 'js/visLightBox/js/vlbdata.js');
       $loadTwig('_footer.twig', $renderData);
       include (BASEPATH.'inc/footer.php');
?>