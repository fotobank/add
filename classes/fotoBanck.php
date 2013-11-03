<?php
/**
 * Created by PhpStorm.
 * User: Jurii
 * Date: 02.11.13
 * Time: 12:55
 */

class fotoBanck {


       public  $current_album;
       public  $current_cat;
       public  $popitka = array();
       public  $album_name = array();
       private $album_pass = array();
       public  $record_count = array();
       private $current_page;
       public  $razdel;
       public  $album_img;
       public  $descr;

       private $session;
       private $ipLog = '/logs/ipLogFile.log';
       private $timeout='30';
       private $us_name;
       public  $ip;
       private $fotoFolder;
       public  $may_view;
       private $width = 170; // ������ �������������� ������ � px
       private $page = "pg"; // �������� GET ��������

       // �������� margin
       private $rs;
       private $start;
       private $widthSait = 1200; // px
       private $margP = 50; // �������������� ������ ������ px

       // �������� md5_encrypt
       private $psw = "Protected_Site_Sec"; // ������
       private $iv_len = 24; // ��������� �����



       public function __get($var) {

              return isset($this->$var)?$this->$var:NULL;
       }

       public function __construct() {

              $this->session = check_Session::getInstance();
              $this->us_name = $this->session->get('us_name');
              $this->current_cat = $this->session->get('current_cat');
              $this->ip = Get_IP();
              $this->fotoFolder = fotoFolder();
              $this->current_page = isset($_GET[$this->page]) ? intval($_GET[$this->page]) : 0;


              if (isset($_GET['id'])) {
                     $this->current_album = intval($_GET['id']);
                     $album_data    = go\DB\query('select * from albums where id = ?i', array($this->current_album), 'row');
                     $this->album_img = $album_data['img'];
                     $this->descr = $album_data['descr'];
                     $this->album_name[$this->current_album] = $album_data['nm'];
                     $this->razdel = go\DB\query('select nm from categories where id = ?i', array($this->current_cat), 'el');
                     if ($album_data['pass'] != '' && !$this->popitka[$this->current_album]) {
                            $this->popitka[$this->current_album] = 5;
                     }
              }
              if (isset($_GET['back_to_albums'])) {
                     unset($this->current_album);
              }
              if (isset($_GET['chenge_cat'])) {
                     unset($this->current_album);
                     $this->current_cat = intval($_GET['chenge_cat']);
              }
              if (isset($_GET['unchenge_cat'])) {
                     unset($this->current_album);
                     unset($this->current_cat);
              }

              $this->may_view();
       }

       /**
        *
        */
       public function __destruct() {

              $this->session->set('current_album', $this->current_album);
              $this->session->set('current_cat', $this->current_cat);
              $this->session->set('popitka', $this->popitka);
              $this->session->set('album_name', $this->album_name);
              $this->session->set('album_pass', $this->album_pass);
              $this->session->set('current_page', $this->current_page);
              $this->session->set('razdel', $this->razdel);
              $this->session->set('record_count', $this->record_count);
       }

       public function check_block() {
              if ($this->current_album && isset($this->popitka[$this->current_album])) {
                     $ostPop = $this->popitka[$this->current_album];
                     if ($ostPop <= 0 || $ostPop == 5) {
                            $ret = json_decode($this->check(), true);
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
                            return json_encode(array('okonc' => $okonc,'ret' => $ret));
                     }
              }
              return NULL;
       }

       private function may_view() {

              $album_data = go\DB\query('select * from albums where id = ?i', array($this->current_album), 'row');
              $this->may_view = false;
              if ($album_data) {
                     $this->may_view = true;
                     if ($album_data['pass'] != '') {
                            ?>
                            <div style="display: none;"><? check(); ?></div><?
                            if (isset($_POST['album_pass'])) {
                                   $this->album_pass[$album_data['id']] = GetFormValue($_POST['album_pass']);
                                   $albPass = $this->album_pass[$album_data['id']];
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
                            $this->may_view = ($this->album_pass[$album_data['id']] == $album_data['pass']); // ���������� ������
                     } else {
                            $this->session->del("popitka/$this->current_album");
                            unset($this->popitka[$this->current_album]);
                     }
              } else {
                     $this->session->del('current_album');
                     unset($this->current_album);
              }
       }

       // ���
       function record() // ������ ����
       {
              $log = fopen("$this->ipLog", "a+");
              fputs($log, Get_IP()."][".time()."][".$this->current_album."\n");
              fclose($log);


              $mail_mes = "�������� - ".dateToRus( time(), '%DAYWEEK%, j %MONTH% Y, G:i' )." - ������������� ������ ������ ��� ������� \"".
                          $this->current_album."\", ������������ - \"".$this->us_name."\" c Ip:".$this->ip.
                          " ������� �� ".$this->timeout." �����!";


              $mail            = new Mail_sender;
              $mail->from_addr = "webmaster@aleks.od.ua";
              $mail->from_name = "aleks.od.ua";
              $mail->to        = "aleksjurii@gmail.com";
              $mail->subj      = "������ ������";
              $mail->body_type = 'text/html';
              $mail->body      = $mail_mes;
              $mail->priority  = 1;
              $mail->prepare_letter();
              $mail->send_letter();

       }

       // chek
       function check() // �������� ����
       {
              $session = check_Session::getInstance();
              $data = file("$this->ipLog");
              $now  = time();
              $current_album = $this->current_album;
              if (!$session->has("popitka") || !is_array($_SESSION['popitka']))
              {
                     $_SESSION['popitka'] = array();
              }
              if ( $this->current_album )
              {
                     if (!$this->popitka[$this->current_album] || $this->popitka[$this->current_album] < 0
                         || $this->popitka[$this->current_album] > 5 && $this->popitka[$this->current_album] != -10)
                     {
                            $this->popitka[$this->current_album] = 5;
                     }
              }
              if ($data) //���� ���� ���� ���� ������
              {
                     foreach ($data as $key => $record)
                     {
                            $subdata = explode("][", $record);

                            // ����� ����������� �������
                            if (Get_IP() == $subdata[0] && $now < ($subdata[1] + 60 * $this->timeout) && $this->current_album == $subdata[2])
                            {
                                   $begin = ((($subdata[1] + 60 * $this->timeout) - $now) / 60);
                                   $min = intval($begin);
                                   $sec = round((($begin - $min)*60),2);
                                   $session->set("popitka/$current_album", -10);

                                   return json_encode(array('min' => $min,'sec' => $sec));
                                   break;
                            }

                            // ����� ���� �����������
                            if (Get_IP() == $subdata[0] && $now > ($subdata[1] + 60 * $this->timeout) && $this->current_album == $subdata[2]
                                && $this->popitka[$this->current_album] <= 0 && $this->popitka[$this->current_album] > 5 )

                            {
                                   $this->popitka[$this->current_album] = 5;
                            }

                            // ������
                            if (isset($subdata[1]) && ($subdata[1] + 60 * $this->timeout) < $now)
                            {
                                   unset($data[$key]); // ������� ������� �������, ������� ����� �������
                                   $data = str_replace('x0A', '', $data);
                                   file_put_contents($this->ipLog, implode('', $data)); // ��������� ���� ������, �������������� ��������� ��� � ������
                            }
                     }
                     unset($key);
              }
              elseif ($this->current_album)
              {
                     if (!$data && $this->popitka[$this->current_album] <= 0 && $this->popitka[$this->current_album] > 5)
                     {
                            $this->popitka[$this->current_album] = 5;
                     }
              }
              return true;
       }


       /**
        * ���������
        */
       public function akkordeon() {

              $event = go\DB\query('select `event` from `albums` where `id` =?i', array($this->current_album), 'el');
              //		���������� ���������� ���� ���������� �� ������������
              if ($event == 'on' && JS) {
                     $acc[1] = go\DB\query('SELECT * FROM accordions WHERE id_album = ?i ', array('1'), 'assoc:collapse_numer');
                     $acc[$this->current_album] = go\DB\query('SELECT * FROM accordions WHERE id_album = ?i ', array($this->current_album), 'assoc:collapse_numer');
                     if ($acc[$this->current_album]) {
                            if ($acc[$this->current_album][1]['accordion_nm'] != '') {
                                   $return = "
																				<div class='profile'>
																				<div id='garmon' class='span12 offset1'>
																				<div class='accordion' id='accordion2'>";
                                   $key = 0;
                                   foreach ($acc[$this->current_album] as $key => $accData) {
                                          if ($key == 1) {
                                                 $in = 'in';
                                          } else {
                                                 $in = '';
                                          }
                                          $collapse_nm = $acc[$this->current_album][$key]['collapse_nm'];
                                          if ($collapse_nm == 'default') {
                                                 $collapse_nm =
                                                        $acc[1][$key]['collapse_nm'];
                                          }
                                          $collapse = $acc[$this->current_album][$key]['collapse'];
                                          if ($collapse == '') {
                                                 $collapse = $acc[1][$key]['collapse'];
                                          }
                                          $return .= "
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
                                   $nameButton = ($acc[$this->current_album][$key]['accordion_nm'] == 'default') ? $acc[1][1]['accordion_nm'] :
                                                                                              $acc[$this->current_album][$key]['accordion_nm'];
                                   $return .= " </div><a class='profile_bitton2' href='#'>�������</a>
																								</div></div>
																								<div><a class='profile_bitton' href='#'>".$nameButton."</a></div>";
                                   return $return;
                            }
                     }
              }
              return null;
       }


       /**
        * @param $record_count
        * @param $current_page
        */
       function fotoPage(&$record_count,&$current_page) {

              $current_page = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
              if ($this->may_view) {
                     if ($current_page < 1) {
                            $current_page = 1;
                     }
                     $start  = ($current_page - 1) * PHOTOS_ON_PAGE;
                     $rs     = go\DB\query('select SQL_CALC_FOUND_ROWS p.* from photos as p where id_album = ?i order by img ASC, id ASC limit ?i, '.PHOTOS_ON_PAGE,
                            array($_SESSION['current_album'], $start), 'assoc');
                     $record_count = go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el'); // ���������� �������
                     if ($rs) {
                            ?>
                            <!-- 3 -->
                            <hr class="style-one"
                                style="margin-top: 10px; margin-bottom: -20px;">
                            <?
                            foreach ($rs as $ln) {
                                   $source = $_SERVER['DOCUMENT_ROOT'].$this->fotoFolder.$ln['id_album'].'/'.$ln['img'];
                                   $sz     = @getimagesize($source);
                                   /* ������ ��������� */
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
        * @return array
        */
       function getMargin() {

              // ������������� ����������
              // ------------------------
              $margin      = 0;
              $testDiv     = 0;
              $koll        = 1;
              $paddingFoto = 10;
              // ------------------------
              for ($i = $this->start; $i < count($this->rs); $i++) {
                     $ln     = $this->rs[$i];
                     $source = ($_SERVER['DOCUMENT_ROOT'].$this->fotoFolder.$ln['id_album'].'/'.$ln['img']);
                     $sz     = @getimagesize($source);
                     if (intval($sz[0]) > intval($sz[1])) {
                            $wid = $this->width + $paddingFoto;
                     } else {
                            $wid = $this->width / 1.25 + $paddingFoto;
                     }
                     $testDiv += $wid;
                     if ((($testDiv + ($this->margP * ($koll - 1)) >= $this->widthSait))) {
                            $margin = round(($this->widthSait - $testDiv) / ($koll - 1));
                            break;
                     }
                     $koll++;
              }
              unset($i);

              return array("margin" => $margin, "koll" => $koll);
       }



       /**
        *
        */
       function fotoPageModern() {

              if ($this->may_view) {
                     $start = $this->current_page * PHOTOS_ON_PAGE;
                     $this->rs = go\DB\query(
                                                 'select SQL_CALC_FOUND_ROWS  p.id_album,
                                                  p.nm,
                                                  p.img,
                                                  a.watermark,
                                                  a.ip_marker
                                                  FROM photos as p, albums as a
                                                  WHERE p.id_album = ?i
                                                  AND p.id_album = a.id
                                                  ORDER by p.img ASC, p.id ASC limit ?i,'.PHOTOS_ON_PAGE,
                                                 array($this->current_album, $start), 'assoc');
                     $record_count = go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el'); // ���������� �������
                     $this->record_count[$this->current_album] = $record_count;
                     if ($this->rs) {
                            ?>
                            <!-- 3 -->
                            <hr class="style-one"
                                style="margin-top: 10px; margin-bottom: -20px;">
                            <div style=" clear: both;">
                            <?

                            $data = $this->getMargin();
                            $margin = $data['margin'];
                            $koll = $data['koll'];
                            $kollFoto = 1;

                            $md5_encrypt = new md5_encrypt($this->psw, $this->iv_len);

                            foreach ($this->rs as $key => $ln) {
                                   $encrypted = $md5_encrypt->ret($this->fotoFolder.']['.$ln['id_album'].']['.(string)$ln['watermark'].']['.(string)$ln['ip_marker']
                                                                  .']['.$ln['img']);
                                   $source = ($_SERVER['DOCUMENT_ROOT'].$this->fotoFolder.$ln['id_album'].'/'.$ln['img']);
                                   $sz     = @getimagesize($source);
                                   /* ������ ��������� px */
                                   if (intval($sz[0]) > intval($sz[1])) {
                                          $preW = 'width="'.$this->width.'px"';
                                          $preH = 'height="'.ceil($this->width / 1.327).'px"';
                                   } else {
                                          $preW = 'height="'.ceil($this->width * 1.066).'px"';
                                          $preH = 'width="'.ceil($this->width / 1.247).'px"';
                                   }
                                   if ($kollFoto == $koll) {

                                          ?>
                                          <a class="modern"
                                             style="position: absolute; float: right;"
                                             href="/loader.php?<?=$encrypted?>"
                                             title="���� � <?= intval($ln['nm']) ?>">
                                                 <img id="<?= substr(trim($ln['img']), 2, -4); ?>"
                                                      class="lazy" <?=$preW?> <?=$preH?>
                                                      src=""
                                                      data-original="/thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
                                                      alt="� <?= intval($ln['nm']) ?>"/>� <?= intval($ln['nm']) ?>
                                          </a>
                                          </div>
                                          <?

                                          $data = $this->getMargin();
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
                                             title="���� � <?= intval($ln['nm']) ?>"> <img
                                                        id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                        class="lazy" <?=$preW?> <?=$preH?>
                                                        src=""
                                                        data-original="/thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
                                                        alt="� <?= intval($ln['nm']) ?>"/>� <?= intval($ln['nm']) ?>
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
        *
        */
       function verifyParol() {

              if (!$this->may_view && $this->current_album != NULL) {
                     ?>
                     <div class="row">
                            <div class="page">
                                   <a class="next"
                                      href="/fotobanck_adw.php?back_to_albums">� �����</a> <a class="next"
                                                                                              href="/fotobanck_adw.php">� ����������� ��� ���</a>
                            </div>
                            <img style="margin: 20px 0 0 40px;"
                                 src="/img/Stop Photo Camera.png"
                                 width="348"
                                 height="350"/>
                            <?
                                   if ($this->popitka[$this->current_album] == -10) // �������� � ����� ������� ����
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
                                          $this->popitka[$this->current_album] = 5;
                                   }
                            ?>
                     </div>
              <?
              }
       }



       /**
        * @param $rs
        * @param $ln
        * @param $source
        * @param $sz
        * @param $sz_string
        */
       function top5(&$rs, &$ln, &$source, &$sz, &$sz_string) {


              if ($this->may_view) {
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
                     $rs = go\DB\query('select * from photos where id_album = ?i order by votes desc, id asc limit 0, 5',
                                                                          array($this->current_album), 'assoc');
                     $id_foto = array();
                     if ($rs) {
                            $pos_num = 1;
                            foreach ($rs as $ln) {
                                   $source            = $_SERVER['DOCUMENT_ROOT'].$this->fotoFolder.$ln['id_album'].'/'.$ln['img'];
                                   $sz                = @getimagesize($source);
                                   $id_foto[$pos_num] = ($ln['id']);
                                   /**
                                    * ������ ��� 5
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
        *
        */
       function top5Modern() {

              if ($this->may_view) {
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
                     $this->rs = go\DB\query('select * from photos where id_album = ?i order by votes desc, id asc limit 0, 5', array($this->current_album), 'assoc');
                     $id_foto = array();
                     if ($this->rs) {
                            $pos_num = 1;
                            foreach ($this->rs as $ln) {
                                   $source            = $_SERVER['DOCUMENT_ROOT'].$this->fotoFolder.$ln['id_album'].'/'.$ln['img'];
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
                                       <span class="top_pos" style="opacity: 0;"><?=$pos_num?></span>
                                          <img class="lazy"
                                               data-original="thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
                                               id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                               src="" alt="<?= $ln['nm'] ?>"
                                               title="<?= $pos_num ?> ����� � �������� �����������" <?=$sz_string?>
                                               data-placement="top"/>
                                   <figcaption><span style="font-size: x-small; font-family: Times, serif; ">� <?=$ln['nm']?>�������:<span class="badge badge-warning">
                                       <span id="s<?= substr(trim($ln['img']), 2, -4) ?>"
                                             style="font-size: x-small; font-family: 'Open Sans', sans-serif; "><?=$ln['votes']?></span>
                                   </span><div id="d<?= substr(trim($ln['img']), 2, -4) ?>"
                                             style="width: 146px;">�������: <?echo str_repeat('<img src="/img/reyt.png"/>', floor($ln['votes']/ 5));?>
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
        *
        */
       function parol() {

              if (!$this->may_view && $this->current_album != NULL) {
                     $ostPop = $this->popitka[$this->current_album];
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
                            $this->popitka[$this->current_album] = 5;
                            $this->record(); //��� �� Ip
                     } elseif ($ostPop > 0) {
                            $ost        = '';
                            $album_pass = $this->album_pass[$this->current_album];
                            if ($album_pass != false) {
                                   $this->popitka[$this->current_album] = $this->popitka[$this->current_album] - 1;
                                   $ostPop = $this->popitka[$this->current_album];
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
                                             var summDok = '$msg';
                                             infdok.innerHTML = summDok;
                                             dhtmlx.message({ type:'warning', text:'$msg'});
                                             </script>";
                            }
                     }
              }
       }

} 