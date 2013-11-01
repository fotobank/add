<?php
/*
:::::::::::::::::::::::::::::::::::::::::::::::::
::                                             ::
::             H O W  T O  U S E ?             ::
::                                             ::
::                                             ::
::                                             ::
::   require('Loader.class.php');              ::
::                                             ::
::   $protect = new Loader(                    ::
::    	$_SERVER['HTTP_REFERER'],              ::
::    	$_SERVER['QUERY_STRING'],              ::
::    	String password,                       ::
::    	String watermark text,                 ::
::    	Watermark switch true->on false->off,  ::
::    	String font,                           ::
::    	Int fontsize,                          ::
::    	Hex fontcolor,                         ::
::    	Hex shadowcolor,                       ::
::      String Error action                    ::
::        'jump=>protected.php'                ::
::        Redirect into specified site         ::
::	  'show=>protected/protected.gif'      ::
::        Display a specified image            ::
::     );                                      ::
::                                             ::
:::::::::::::::::::::::::::::::::::::::::::::::::
*/

       require_once (__DIR__.'/../../inc/config.php');
       require_once (__DIR__.'/../../inc/func.php');

class md5_loader {

       /*
       :::::::::::::::::::::::::::::::::::::::::::::::
       ::                                           ::
       ::             Class variables               ::
       ::                                           ::
       :::::::::::::::::::::::::::::::::::::::::::::::
       */

       public $referer = false;
       public $query = false;
       public $pws; // пароль для шифрования
       public $text_string = ""; // текст водяного знака
       public $font; // применяемый шрифт
       public $font_size = 16; // размер шрифта водяного знака
       public $iv_len = 16; // сложность шифра
       public $rgbtext = "FFFFFF"; // цвет текста
       public $rgbtsdw = "000000"; // цвет тени
       public $text_padding    = 10; // смещение от края
       public $hotspot = 2; // расположение текста
       public $text_rotate = 0; // вращение текста
       public $sxp = 2; // тень смещение по x
       public $syp = 2; // тень смещение по y
       public $vz = "img/vz.png"; // картинка водяного знака
       public $vzm = "img/vzm.png"; // multi картинка водяного знака
       public $process = "jump=>security/protected.php"; // или картинка "show=>security/protected.gif" - сообщение об ошибке
       public $protectedImg = 'img/eror404.gif'; //защитная картинка выводится в модальном окне при нарушении в строке запроса GET
       private $str_img; // строка - путь к фото
       private $image; // объект изображения
       private $idImg; // id фото
       private $thumb; // миниатюра
       private $imgWidth; // ширина фото
       private $imgHeight; // высота фото
       private $watermark = true; // включить водяной знак;
       private $multi_watermark = true; // включить multi водяной знак;
       private $ip_marker = true; // включить надпись ip;
       private $txp = 0; // x - координата расположения текста водяного знака
       private $typ = 0; // y - координата расположения текста водяного знака
       private $ext; // расширение файла картинки
       protected static $_instance;


       /**
        * фильтрация входных данных
        */
       private function setField() {

              $decrypted =  explode("][", $this->md5_decrypt());
              $this->idImg = substr(trim(end($decrypted)), 2, -4);
              // передать через сессию
              check_Session::getInstance()->set('idImg', $this->idImg);
              $img = substr($decrypted[0].$decrypted[1], 1)."/".end($decrypted);
              if(!filter_var($img, FILTER_SANITIZE_URL)) {
                  $this->str_img = "The provided url is invalid";
              } else {
                  $this->str_img = trim(addslashes(htmlspecialchars(strip_tags($img))));
                  $this->watermark = is_null($decrypted[2])?true:($decrypted[2] == "1")?true:false;
                  $this->ip_marker = is_null($decrypted[3])?true:($decrypted[3] == "1")?true:false;
              }
         }


       /**
        * @param $imgData
        *
        * @return mixed
        */
       public function idImg($imgData) {
              foreach ($imgData as $var => $data) {
                     $this->$var = $data;
              }
              $this->setField();
              return $this->idImg;
       }

       public function thumb($imgData) {
              foreach ($imgData as $var => $data) {
                     $this->$var = $data;
              }
              $decrypted =  explode("][", $this->md5_decrypt());
              $this->thumb = $decrypted['1'];
              return $this->thumb;
       }

       /*
       :::::::::::::::::::::::::::::::::::::::::::::::
       ::                                           ::
       ::            Class constructor              ::
       ::                                           ::
       :::::::::::::::::::::::::::::::::::::::::::::::
       */
       public function __construct($ini) {
              foreach ($ini as $var => $data) {
                     $this->$var = $data;
              }
              if(!empty($this->text_string)) {
              $this->win2uni();
              }
       }


       /**
        * @param $imgData
        *
        * @return bool
        */
       public function img($imgData) {

              foreach ($imgData as $var => $data) {
                     $this->$var = $data;
              }
              $this->set_http_header();
              if ($this->referer) {
                     $this->setField();
                     if (!is_file( $this->str_img)) {
                     $this->file_show($this->protectedImg);
                            return false;
                     }
                     if ($this->watermark || $this->ip_marker) {
                            $this->ext = $this->ext($this->str_img);
                            $imgInfo = getimagesize ($this->str_img);
                            $this->imgWidth  = $imgInfo[0];
                            $this->imgHeight = $imgInfo[1];
                            $this->image = $this->create_image($this->str_img, $this->ext);
                            if ($this->watermark)
                            {
                                   $this->img_watermark();
                            }
                            if ($this->multi_watermark)
                            {
                                   $this->img_multi_watermark();
                            }
                            if ($this->ip_marker) $this->txt_watermark();
                                  $this->img_show();
                     } else $this->file_show($this->str_img);
              } else  $this->bad();
              return true;
       }


       /*
       :::::::::::::::::::::::::::::::::::::::::::::::
       ::                                           ::
       ::     Set http header and disable cache.    ::
       ::                                           ::
       :::::::::::::::::::::::::::::::::::::::::::::::
       */
       private function set_http_header() {

              header("Expires: -1");
              header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
              header("Cache-Control: no-cache, must-revalidate");
              header("Pragma: no-cache");

              return (0);
       }


       function file_show($img) {
              header("Content-type: image/".$this->ext($img));
              readfile($img);
       }


      private function calculateTextBox() {
              /************
              simple function that calculates the *exact* bounding box (single pixel precision).
              The function returns an associative array with these keys:
              left, top:  coordinates you will pass to imagettftext
              width, height: dimension of the image you have to create
               *************/
              $rect = imagettfbbox($this->font_size,$this->text_rotate,$this->font,$this->text_string);
              $minX = min(array($rect[0],$rect[2],$rect[4],$rect[6]));
              $maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6]));
              $minY = min(array($rect[1],$rect[3],$rect[5],$rect[7]));
              $maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7]));

              return array(
                     "left"   => abs($minX) - 1,
                     "top"    => abs($minY) - 1,
                     "width"  => $maxX - $minX,
                     "height" => $maxY - $minY,
                     "box"    => $rect
              );
       }

       // расширение файла
       private function ext($img) {
              $ext   = explode(".", $img);
              return $ext[1];
       }


       private  function create_image($img, $ext) {
              $image = NULL;
              switch ($ext) {
                     case "jpg":
                            $image = imageCreateFromJpeg($img);
                            break;
                     case "jpeg":
                            $image = imageCreateFromJpeg($img);
                            break;
                            break;
                     case "gif":
                            $image = imageCreateFromGif($img);
                            break;
                            break;
                     case "png":
                            $image = imageCreateFromPng($img);
                            break;
              }
              return $image;
       }


       private function txt_watermark() {

              if(empty($this->text_string)) {
              $sIP = Get_IP(); // Определяем IP посетителя
              $zap = basename ($this->str_img);
              $rs = go\DB\query('SELECT nm FROM photos WHERE img = ?string',array($zap), 'el');
              $this->text_string = "Ваш IP-adress: {$sIP}, фотография # ".(int)$rs;
              $this->win2uni();
              }
              $this->query_coordinate();
              $this->print_string();
       }

       private function img_watermark() {

              $aWmImgInfo = getimagesize($this->vz);
              if (is_array($aWmImgInfo) && count($aWmImgInfo)) {
                     //  Создаем изображение водяного знака
                     $rWmImage = $this->create_image($this->vz, $this->ext($this->vz));
                     // Копируем изображение водяного знака на изображение источник
                     imagecopy($this->image, $rWmImage, $this->imgWidth / 2 - $aWmImgInfo[0] / 2, $this->imgHeight * 0.5, 0, 0, $aWmImgInfo[0], $aWmImgInfo[1]);
              }
       }

       private function img_multi_watermark() {

              $rWmImage = $this->create_image($this->vzm, $this->ext($this->vzm));
              $aWmImgInfo = getimagesize($this->vzm);
              $x = 10;
              $dob_x = 30;
              $y = $dob_y = 50;
              $wKoll = ceil($this->imgWidth / ($aWmImgInfo[0] + $dob_x)) ;
              $yKoll = ceil($this->imgHeight / ($aWmImgInfo[1] + $dob_y));

              for ($d=0; $d < $yKoll ; $d++) {

                     for ($i=0; $i < $wKoll ; $i++) {

                            imagecopy($this->image, $rWmImage, $x, $y, 0, 0, $aWmImgInfo[0], $aWmImgInfo[1]);
                            $x += $aWmImgInfo[0] + $dob_x;
                     }
                     $x = 10;
                     $y += $aWmImgInfo[1] + $dob_y ;
              }
       }


       /**
        *
        */
       private  function img_show() {

              header("Content-type: image/".$this->ext);
              switch ($this->ext) {
                     case "jpg":
                            imageJpeg($this->image);
                            break;
                     case "jpeg":
                            imageJpeg($this->image);
                            break;
                     case "gif":
                            imageGif($this->image);
                            break;
                     case "png":
                            imagePng($this->image);
                            break;
              }
       }


       /**
        *
        */
       public function __destruct() {
              if(is_resource($this->image)) {
                     imagedestroy($this->image);
              }
       }


       /**
        *  Преобразование Windows 1251 -> Unicode
        *
        * @return string
        */
       private function win2uni() {

              // преобразование win1251 -> iso8859-5
              $this->text_string = convert_cyr_string($this->text_string, 'w', 'i');
              // преобразование iso8859-5 -> unicode:
              $result = '';
              for ($i = 0; $i < strlen($this->text_string); $i++) {
                     $charcode = ord($this->text_string[$i]);
                     $result .= ($charcode > 175) ? "&#".(1040 + ($charcode - 176)).";" : $this->text_string[$i];
              }

              $this->text_string = $result;
       }


       /**
        * @return mixed
        */
       function md5_decrypt() {

              $this->query   = base64_decode($this->query);
              $n          = strlen($this->query);
              $i          = $this->iv_len;
              $plain_text = '';
              $iv         = substr($this->pws ^ substr($this->query, 0, $this->iv_len), 0, 512);
              while ($i < $n) {
                     $block = substr($this->query, $i, 16);
                     $plain_text .= $block ^ pack('H*', md5($iv));
                     $iv = substr($block.$iv, 0, 512) ^ $this->pws;
                     $i += 16;
              }

              return preg_replace('/\\x13\\x00*$/', '', $plain_text);
       }



       /**
        * координаты X и Y расположения текста водяного знака
        */
       private function query_coordinate() {

              if ($this->hotspot != 0) {

                     $the_box   = $this->calculateTextBox();
                     switch ($this->hotspot) {
                            case 1:
                                   $this->txp = $this->text_padding;
                                   $this->typ = $the_box["top"] + $the_box["height"] + $this->text_padding;
                                   break;
                            case 2:
                                   $this->txp = $the_box["left"] + ($this->imgWidth / 2) - ($the_box["width"] / 2);
                                   $this->typ = $the_box["top"] + $the_box["height"] + $this->text_padding;
                                   break;
                            case 3:
                                   $this->txp = ($this->imgWidth) - $the_box["width"] - $this->text_padding;
                                   $this->typ = $the_box["top"] + $the_box["height"] + $this->text_padding;
                                   break;
                            case 4:
                                   $this->txp = $this->text_padding;
                                   $this->typ = $the_box["top"] + ($this->imgHeight / 2) - ($the_box["height"] / 2);
                                   break;
                            case 5:
                                   $this->txp = $the_box["left"] + ($this->imgWidth / 2) - ($the_box["width"] / 2);
                                   $this->typ = $the_box["top"] + ($this->imgHeight / 2) - ($the_box["height"] / 2);
                                   break;
                            case 6:
                                   $this->txp = $this->imgWidth - $the_box["width"] - $this->text_padding;
                                   $this->typ = $the_box["top"] + ($this->imgHeight / 2) - ($the_box["height"] / 2);
                                   break;
                            case 7:
                                   $this->txp = $this->text_padding;
                                   $this->typ = $this->imgHeight - $the_box["height"] - $this->text_padding;
                                   break;
                            case 8:
                                   $this->txp = $the_box["left"] + ($this->imgWidth / 2) - ($the_box["width"] / 2);
                                   $this->typ = $this->imgHeight - $the_box["height"] - $this->text_padding;
                                   break;
                            case 9:
                                   $this->txp = $this->imgWidth - $the_box["width"] - $this->text_padding;
                                   $this->typ = $this->imgHeight - $the_box["height"] - $this->text_padding;
                                   break;
                     }
              }
       }


       private function print_string() {

              $color_shad = imagecolorallocate($this->image, HexDec($this->rgbtsdw) & 0xff, (HexDec($this->rgbtsdw) >> 8) & 0xff,
                     (HexDec($this->rgbtsdw) >> 16) & 0xff);
              $color_text = imagecolorallocate($this->image, HexDec($this->rgbtext) & 0xff, (HexDec($this->rgbtext) >> 8) & 0xff,
                     (HexDec($this->rgbtext) >> 16) & 0xff);
              imagettftext($this->image,
                     $this->font_size,
                     $this->text_rotate,
                     $this->txp + $this->sxp,
                     $this->typ + $this->syp,
                     $color_shad,
                     $this->font,
                     $this->text_string);
              imagettftext($this->image,
                     $this->font_size,
                     $this->text_rotate,
                     $this->txp,
                     $this->typ,
                     $color_text,
                     $this->font,
                     $this->text_string);
       }


       /**
        *  защита
        */
       public function bad() {

              $processor = explode("=>", $this->process);
              if ($processor[0] == "show") {
                     $this->file_show($processor[1]);
              } elseif ($processor[0] == "jump") {
                     header("Location: ".$processor[1]);
              }
       }

}
?>
