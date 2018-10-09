<?php
       /**
        * Created by PhpStorm.
        * User: Jurii
        * Date: 02.11.13
        * Time: 12:55
        */
       use Framework\Core\MailSender\MailSender;


       class fotoBanck {


              private $current_album;
              private $current_cat;
              // попытки входа
              private $login_attempt = array();
              private $album_name = array();
              private $album_pass = array();
              private $record_count = array();
              private $current_page;
              // раздел фотоальбома
              private $razdel;
              private $album_img;
              private $descr;
              private $disable_photo_display;  // отключение показа фотографий в альбоме
              private $album_data = array();
              private $input_pass = array();

              private $session;
              private $ipLog;
              private $timeout = '30';
              private $us_name;
              private $ip;
              private $fotoFolder;
              private $may_view;
              private $width = 170; // ширина горизонтальной превью в px
              private $page = 'pg'; // название GET страницы

              // свойства margin
              private $rs;
              private $start;  // первая фотографияя на странице
              private $widthSait = 1200; // px
              private $margP = 50; // предпологаемый правый маргин px

              // свойства md5_encrypt
              private $psw = 'Protected_Site_Sec'; // пароль
              private $iv_len = 24; // сложность шифра



              public function get($var) {
                     return $this->$var ?? NULL;
              }


              public function set($var, $val) {

                     if (isset($this->$var)) {
                            $this->$var = $val;

                            return true;
                     }

                     return false;
              }


              public function get_arr($arr, $var) {

                     if (array_key_exists($this->get($var), $this->$arr)) {

                            return $this->{$arr}[$this->get($var)];
                     }

                     return NULL;
              }


              public function __construct() {

                     $this->session      = check_Session::getInstance();
                     $this->us_name      = $this->session->get('us_name');
                     $this->current_cat  = $this->session->get('current_cat');
                     $this->ip           = Get_IP();
                     $this->current_page = isset($_GET[$this->page]) ? (int)$_GET[$this->page] : 0;
                     $this->ipLog        = $_SERVER['DOCUMENT_ROOT'].'/logs/ipLogFile.log';
                     if(!file_exists($this->ipLog)) {
                            $concurrentDirectory = dirname($this->ipLog);
                            if (!is_dir($concurrentDirectory) && !mkdir($concurrentDirectory, 0777) && !is_dir($concurrentDirectory)) {
                                   throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                            }
                            // создать файл
                            touch($this->ipLog);

                     }
                     if (isset($_GET['id'])) {
                            $this->current_album                    = (int)$_GET['id'];
                            $this->album_data                       = go\DB\query('select * from albums where id = ?i', array($this->current_album), 'row');
                            $this->fotoFolder                       = $this->album_data['foto_folder'];
                            $this->album_pass                       = $this->album_data['pass'];
                            $this->disable_photo_display            = $this->album_data['disable_photo_display'];
                            $this->album_img                        = $this->album_data['img'];
                            $this->descr                            = $this->album_data['descr'];
                            $this->album_name[$this->current_album] = $this->album_data['nm'];
                            $this->razdel                          = go\DB\query('select nm from categories where id = ?i', array($this->current_cat), 'el');
                            if ($this->album_data['pass'] != '' && !isset($this->login_attempt[$this->current_album])) {
                                   $this->login_attempt[$this->current_album] = 5;
                            }
                     }
                     if (isset($_GET['back_to_albums'])) {
                            unset($this->current_album);
                     }
                     if (isset($_GET['chenge_cat'])) {
                            unset($this->current_album);
                            $this->current_cat = (int)($_GET['chenge_cat']);
                     }
                     if (isset($_GET['unchenge_cat'])) {
                            unset($this->current_album);
                            unset($this->current_cat);
                     }
                     $this->may_view();
              }

              /* public function __isset($val){

                      return isset($this->$val);
               }*/
              /**
               *
               */
              public function __destruct() {

                     isset($this->current_album) ? $this->session->set('current_album', $this->current_album) : false;
                     isset($this->current_cat) ? $this->session->set('current_cat', $this->current_cat) : false;
                     $this->session->set('popitka', $this->login_attempt);
                     //              $this->session->set('album_name', $this->album_name);
                     //              $this->session->set('album_pass', $this->album_pass);
                     //              $this->session->set('current_page', $this->current_page);
                     //              $this->session->set('razdel', $this->razdel);
                     //              $this->session->set('record_count', $this->record_count);
              }


              /**
               * @return null|string
               * проверка на парольную блокировку альбома
               */
              public function check_block() {

                     if (isset($this->current_album, $this->login_attempt[$this->current_album])) {
                            $ostPop = $this->login_attempt[$this->current_album];
                            if ($ostPop <= 0 || $ostPop == 5) {
                                   $ret = json_decode($this->check(), true);
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

                                   return json_encode(array('okonc' => $okonc, 'ret' => $ret));
                            }
                     }

                     return NULL;
              }


              private function may_view() {

                     $this->may_view = false;
                     if ($this->album_data) {
                            if ($this->album_pass != '') {
                                   ?>
								<div style="display: none;"><? $this->check(); ?></div><?
                                   if (isset($_POST['album_pass'])) {
                                          $this->input_pass[$this->current_album] = GetFormValue($_POST['album_pass']);
                                          if ($this->input_pass[$this->current_album] != $this->album_pass && $this->input_pass[$this->current_album] != '') {
                                                 echo "
																							<script type='text/javascript'>
																							// dhtmlx.message({ type:'error', text:'Пароль неправильный,<br> будьте внимательны!'});
																							humane.error('Пароль неправильный, будьте внимательны!');
																							</script>";
                                          } elseif ($this->input_pass[$this->current_album] == '') {
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
                                          $this->may_view = ($this->input_pass[$this->current_album] == $this->album_pass); // переменная пароля
                                   }
                            } else {
                                   $this->may_view = true;
                                   $this->session->del("popitka/$this->current_album");
                                   unset($this->login_attempt[$this->current_album]);
                            }
                     } else {
                            $this->session->del('current_album');
                            unset($this->current_album);
                     }
              }


              // бан
              function record() // запись бана
              {

                     $log = fopen($this->ipLog, 'ab+');
                     fwrite($log, Get_IP().']['.time().']['.$this->current_album."\n");
                     fclose($log);
                     $mail_mes = 'Внимание - '.dateToRus(time(), '%DAYWEEK%, j %MONTH% Y, G:i').' - зафиксированн подбор пароля для альбома "'.
                                 $this->current_album.'", пользователь - "'.$this->us_name.'" c Ip:'.$this->ip.
                                 ' забанен на '.$this->timeout.' минут!';
                     $mail            = new MailSender;
                     $mail->from_addr = 'webmaster@aleks.od.ua';
                     $mail->from_name = 'aleks.od.ua';
                     $mail->to        = 'aleksjurii@gmail.com';
                     $mail->subj      = 'Подбор пароля';
                     $mail->body_type = 'text/html';
                     $mail->body      = $mail_mes;
                     $mail->priority  = 1;
                     $mail->prepare_letter();
                     $mail->send_letter();

              }


              // chek
              function check() // проверка бана
              {

                     $session       = check_Session::getInstance();
                     $data          = file($this->ipLog);
                     $now           = time();
                     $current_album = $this->current_album;
                     if (!$session->has("popitka") || !is_array($_SESSION['popitka'])) {
                            $_SESSION['popitka'] = array();
                     }
                     if ($this->current_album) {
                     	$attempt = $this->login_attempt[$this->current_album];
                       //     if (!$attempt || $attempt < 0 || $attempt > 5 || $attempt !== -10) {
                            if (!$attempt || $attempt < 0 || $attempt > 5) {
                                   $this->login_attempt[$this->current_album] = 5;
                            }
                     }
                     if ($data) //если есть хоть одна запись
                     {
                            foreach ($data as $key => $record) {
                                   $subdata = explode("][", $record);
                                   // показ остаточного времени
                                   if ($this->ip == $subdata[0] && $now < ($subdata[1] + 60 * $this->timeout) && $this->current_album == $subdata[2]) {
                                          $begin = ((($subdata[1] + 60 * $this->timeout) - $now) / 60);
                                          $min   = (int)($begin);
                                          $sec   = round((($begin - $min) * 60), 2);
                                          $session->set("popitka/$current_album", -10);

                                          return json_encode(array('min' => $min, 'sec' => $sec));
                                          break;
                                   }
                                   // время бана закончилось
                                   if ($this->ip == $subdata[0] && $now > ($subdata[1] + 60 * $this->timeout) && $this->current_album == $subdata[2]
                                       && $this->login_attempt[$this->current_album] <= 0
                                       && $this->login_attempt[$this->current_album] > 5) {
                                          $this->login_attempt[$this->current_album] = 5;
                                   }
                                   // чистка
                                   if (isset($subdata[1]) && ($subdata[1] + 60 * $this->timeout) < $now) {
                                          unset($data[$key]); // убираем элемент массива, который нужно удалить
                                          $data = str_replace('x0A', '', $data);
                                          file_put_contents($this->ipLog, implode('', $data)); // сохраняем этот массив, предварительно объединив его в строку
                                   }
                            }
                            unset($key);
                     } elseif ($this->current_album) {
                            if (!$data && $this->login_attempt[$this->current_album] <= 0 && $this->login_attempt[$this->current_album] > 5) {
                                   $this->login_attempt[$this->current_album] = 5;
                            }
                     }

                     return true;
              }


              /**
               * аккордеон
               */
              public function akkordeon() {

                     //		отключение аккордеона если фотографии не показываются
                     if ($this->disable_photo_display == 'on' && JS) {
                            $acc[1]                    = go\DB\query('SELECT * FROM accordions WHERE id_album = ?i ', array('1'), 'assoc:collapse_numer');
                            $acc[$this->current_album] =
                                   go\DB\query('SELECT * FROM accordions WHERE id_album = ?i ', array($this->current_album), 'assoc:collapse_numer');
                            if ($acc[$this->current_album]) {
                                   if ($acc[$this->current_album][1]['accordion_nm'] != '') {
                                          $akkordeon = "<div class='profile'><div id='garmon' class='span12 offset1'><div class='accordion' id='accordion2'>";
                                          $key       = 0;
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
                                                 $akkordeon .= "<div class='accordion-group'><div class='accordion-heading'>
																	<a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion2' href='#collapse"
                                                               .$key."'>".$collapse_nm."</a>
                                  </div><div id='collapse".$key."' class='accordion-body collapse ".$in."'>
                                  <div class='accordion-inner'><p class='bukvica'><span style='font-size:11.0pt;'>".$collapse."</span></p>
                                  </div></div></div>";

                                          }
                                          $nameButton = ($acc[$this->current_album][$key]['accordion_nm'] == 'default') ? $acc[1][1]['accordion_nm'] :
                                                 $acc[$this->current_album][$key]['accordion_nm'];
                                          $akkordeon  .= "</div><a class='profile_bitton2' href='#'>Закрыть</a></div></div>
																								<div><a class='profile_bitton' href='#'>".$nameButton."</a></div>";

                                          return $akkordeon;
                                   }
                            }
                     }

                     return NULL;
              }


              /**
               * @param $record_count
               * @param $current_page
               */
              function fotoPage(&$record_count, &$current_page) {

                     $current_page = isset($_GET['pg']) ? (int)($_GET['pg']) : 1;
                     if ($this->may_view) {
                            if ($current_page < 1) {
                                   $current_page = 1;
                            }
                            $start        = ($current_page - 1) * PHOTOS_ON_PAGE;
                            $rs           = go\DB\query('select SQL_CALC_FOUND_ROWS p.* from photos as p where id_album = ?i order by img ASC, id ASC limit ?i, '
                                                        .PHOTOS_ON_PAGE,
                                   array($_SESSION['current_album'], $start), 'assoc');
                            $record_count = go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el'); // количество записей
                            if ($rs) {
                                   ?>
								<!-- 3 -->
								<hr class="style-one"
								    style="margin-top: 10px; margin-bottom: -20px;">
                                   <?
                                   foreach ($rs as $ln) {
                                          $source = $_SERVER['DOCUMENT_ROOT'].$this->fotoFolder.$ln['id_album'].'/'.$ln['img'];
                                          $sz     = @getimagesize($source);
                                          /* размер превьюшек */
                                          if ((int)($sz[0]) > (int)($sz[1])) {
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
											        width="<?= $preW ?>"
											        height="<?= $preH ?>"
											        src=""
											        title="За фотографию проголосовало <?= $ln['votes'] ?> человек. Нажмите для просмотра."/>
											   <figcaption>№ <?= $ln['nm'] ?></figcaption>
										   </figure>
									   </div>
                                          <?
                                   }
                            }

                     }

              }


              /**
               * @param $start
               *
               * @return array
               */
              function getMargin($start) {

                     // инициализация переменных
                     // ------------------------
                     $margin      = 0;
                     $testDiv     = 0;
                     $koll        = 1;
                     $paddingFoto = 10;
                     // ------------------------
                     for ($i = $start; $i < count($this->rs); $i++) {
                            $ln     = $this->rs[$i];
                            $source = ($_SERVER['DOCUMENT_ROOT'].$this->fotoFolder.$ln['id_album'].'/'.$ln['img']);
                            $sz     = @getimagesize($source);
                            if ((int)($sz[0]) > (int)($sz[1])) {
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
                            $start                                    = $this->current_page * PHOTOS_ON_PAGE;
                            $this->rs                                 = go\DB\query(
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
                            $record_count                             = go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el'); // количество записей
                            $this->record_count[$this->current_album] = $record_count;
                            if ($this->rs) {

                                   $retPage = "";
                                   $data        = $this->getMargin(0);
                                   $kollFoto    = 1;
                                   $md5_encrypt = new md5_encrypt($this->psw, $this->iv_len);
                                   foreach ($this->rs as $key => $ln) {
                                          $encrypted =
                                                 $md5_encrypt->ret($this->fotoFolder.']['.$ln['id_album'].']['.(string)$ln['watermark'].']['.(string)$ln['ip_marker']
                                                                   .']['.$ln['img']);
                                          $source    = ($_SERVER['DOCUMENT_ROOT'].$this->fotoFolder.$ln['id_album'].'/'.$ln['img']);
                                          $sz        = @getimagesize($source);
                                          $img       = substr(trim($ln['img']), 2, -4);
                                          $nm        = (int)($ln['nm']);
                                          /* ширина превьюшек px */
                                          if ((int)($sz[0]) > (int)($sz[1])) {
                                                 $preW = 'width="'.$this->width.'px"';
                                                 $preH = 'height="'.ceil($this->width / 1.327).'px"';
                                          } else {
                                                 $preW = 'height="'.ceil($this->width * 1.066).'px"';
                                                 $preH = 'width="'.ceil($this->width / 1.247).'px"';
                                          }
                                          if ($kollFoto == $data['koll']) {

                                                 $retPage .= "<a class='modern' style='position: absolute; float: right;' href='/loader.php?".$encrypted
                                                             ."' title='Фото № ".$nm."'>
                                             <img id='".$img."' class='lazy' ".$preW." ".$preH." src='' data-original='/thumb.php?num=".$img."'
                                             alt='№ ".$nm."'/>№ ".$nm."</a></div><div style=' clear: both;'>";
                                                 $data     = $this->getMargin($key);
                                                 $kollFoto = 0;
                                          } else {

                                                 $retPage .= "<a class='modern' style='position: relative; float: left; margin-right: ".$data['margin']."px;'
                                             href='/loader.php?".$encrypted."' title='Фото № ".$nm."'>
                                             <img id='".$img."' class='lazy' ".$preW." ".$preH." src=''
                                             data-original='/thumb.php?num=".$img."' alt='№ ".$nm."'/>№ ".$nm." </a>";
                                          }
                                          $kollFoto++;
                                   }

                                   return $retPage;
                            }
                     }

                     return NULL;
              }


              /**
               *
               */
              function verifyParol() {

                     $return = NULL;
                     if (!$this->may_view && $this->current_album != NULL) {

                            $return .= "<div class='row'><div class='page'>
                                 <a class='next' href='/fotobanck_adw.php?back_to_albums'>« назад</a>
                                 <a class='next' href='/fotobanck_adw.php'>« попробовать еще раз</a></div>
                                 <img style='margin: 20px 0 0 40px;' src='/img/Stop Photo Camera.png' width='348' height='350'/>";
                            if ($this->login_attempt[$this->current_album] == -10) // проверка и вывод времени бана
                            {
                                   $return                                    .= "<script type='text/javascript'>
                                             $(document).ready(function(){
                                             $('#zapret').modal('show');
                                             });
                                             function gloze() {
                                             $('#zapret').modal('hide');
                                             location='/fotobanck_adw.php?back_to_albums';
                                             }
                                             setTimeout('gloze()', 10000);
                                             </script>";
                                   $this->login_attempt[$this->current_album] = 5;
                            }
                            $return .= "</div>";
                     }

                     return $return;
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
								 <h3><span style="color: #c95030"> Топ 5 альбома:</span></h3>
							 </div>
						 </div><br><br><br>
						 <!-- 1 -->
						 <hr class="style-one"
						     style="margin: 0 0 -20px 0;"/>
                            <?
                            $rs      = go\DB\query('select * from photos where id_album = ?i order by votes desc, id asc limit 0, 5',
                                   array($this->current_album), 'assoc');
                            $id_foto = array();
                            if ($rs) {
                                   $pos_num = 1;
                                   foreach ($rs as $ln) {
                                          $source            = $_SERVER['DOCUMENT_ROOT'].$this->fotoFolder.$ln['id_album'].'/'.$ln['img'];
                                          $sz                = @getimagesize($source);
                                          $id_foto[$pos_num] = ($ln['id']);
                                          /**
                                           * размер топ 5
                                           */
                                          if ((int)($sz[0]) > (int)($sz[1])) {
                                                 $sz_string = 'width="165px"';
                                          } else {
                                                 $sz_string = 'height="195px"';
                                          }
                                          ?>
									   <div id="foto_top">
										   <figure class="ramka"
										           onClick="previewTop(<?= $ln['id'] ?>);">

                                                 <span class="top_pos"
                                                       style="opacity: 0;"><?= $pos_num ?></span> <img class="lazy"
                                                                                                       data-original="thumb.php?num=<?= substr(trim($ln['img']), 2,
                                                                                                              -4) ?>"
                                                                                                       id="<?= substr(trim($ln['img']), 2, -4) ?>"
                                                                                                       src=""
                                                                                                       alt="<?= $ln['nm'] ?>"
                                                                                                       title="Нажмите для просмотра" <?= $sz_string ?> />
											   <figcaption><span style="font-size: x-small; font-family: Times, serif; ">№ <?= $ln['nm'] ?>
											                                                                             Голосов:<span class="badge badge-warning">
																									<span id="s<?= substr(trim($ln['img']), 2, -4) ?>"
																									      style="font-size: x-small; font-family: 'Open Sans', sans-serif; "><?= $ln['votes'] ?></span>
                								 </span><div id="d<?= substr(trim($ln['img']), 2, -4) ?>"
											                 style="width: 146px;">
                                                                      Рейтинг: <?
                                                                           echo str_repeat('<img src="/img/reyt.png"/>', floor($ln['votes'] / 5)); ?>
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
               * вывыод в топ 5
               */
              function top5Modern() {

                     ob_start();
                     if ($this->may_view) {
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
                            $this->rs = go\DB\query('select * from photos where id_album = ?i order by votes desc, id asc limit 0, 5', array($this->current_album),
                                   'assoc');
                            $id_foto  = array();
                            if ($this->rs) {
                                   $pos_num = 1;
                                   foreach ($this->rs as $ln) {
                                          $source            = $_SERVER['DOCUMENT_ROOT'].$this->fotoFolder.$ln['id_album'].'/'.$ln['img'];
                                          $sz                = @getimagesize($source);
                                          $id_foto[$pos_num] = ($ln['id']);
                                          /**
                                           *   размер топ 5
                                           */
                                          if ((int)($sz[0]) > (int)($sz[1])) {
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
												         style="opacity: 0;"><?= $pos_num ?></span>
												   <img class="lazy"
												        data-original="thumb.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
												        id="<?= substr(trim($ln['img']), 2, -4) ?>"
												        src=""
												        alt="<?= $ln['nm'] ?>"
												        title="<?= $pos_num ?> место в рейтинге голосования" <?= $sz_string ?>
												        data-placement="top"/>
												   <figcaption><span style="font-size: x-small; font-family: Times, serif; ">№ <?= $ln['nm'] ?>
												                                                                             Голосов:<span class="badge badge-warning">
                                       <span id="s<?= substr(trim($ln['img']), 2, -4) ?>"
                                             style="font-size: x-small; font-family: 'Open Sans', sans-serif; "><?= $ln['votes'] ?></span>
                                   </span><div id="d<?= substr(trim($ln['img']), 2, -4) ?>"
                                               style="width: 146px;">Рейтинг: <?
                                                                               echo str_repeat('<img src="/img/reyt.png"/>', floor($ln['votes'] / 5)); ?>
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
                     $result = ob_get_contents();
                     ob_end_clean();

                     return $result;
              }


              /**
               *
               */
              function parol() {

                     $return = NULL;
                     if (!$this->may_view && $this->current_album != NULL) {
                            $ostPop = $this->login_attempt[$this->current_album];
                            if ($ostPop > 0 && $ostPop <= 5) {
                                   $return .= "<script type='text/javascript'>
                             $(document).ready(function load() {
                             $('#static').modal('show');
                             });
                             </script>";
                            }
                            if ($ostPop <= 0 && $ostPop != -10) {
                                   $return                                    .= "<script type='text/javascript'>
                             $(document).ready(function(){
                             $('#zapret').modal('show');
                             });
                             function gloze() {
                             $('#zapret').modal('hide');
                             location='/fotobanck_adw.php?back_to_albums';
                             }
                             setTimeout('gloze()', 10000);
                             </script>";
                                   $this->login_attempt[$this->current_album] = 5;
                                   $this->record(); //бан по Ip
                            } elseif ($ostPop > 0) {
                                   $ost        = '';
                                   $album_pass = isset($this->input_pass[$this->current_album]) ?: false;
                                   if ($album_pass != false) {
                                          $this->login_attempt[$this->current_album] = $this->login_attempt[$this->current_album] - 1;
                                          $ostPop                                    = $this->login_attempt[$this->current_album];
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
                                          $msg    = ($ost.' '.($ostPop + 1).' '.$pop);
                                          $return .= "<script type='text/javascript'>
                                             var infdok = document.getElementById('err-modal');
                                             var summDok = '$msg';
                                             infdok.innerHTML = summDok;
                                             dhtmlx.message({ type:'warning', text:'$msg'});
                                             </script>";
                                   }
                            }
                     }
                     // <!-- Проверка пароля на блокировку -->
                     $return .= $this->verifyParol();

                     return $return;
              }

       }
