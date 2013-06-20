<?php
session_start();
define('SR_DENIED', true);
if (!include ("config.inc.php")) { die("Не найден рабочий файл конфигурации"); exit; }
$font_size = $spamcontrol_size;
$width=imagefontwidth($font_size)*$spamcontrol_length*2;
$height=imagefontheight($font_size)*2;
$img = imagecreate($width,$height);
$bg_color = trim($LIGHT);
$bg3 = hexdec(substr($bg_color, -2));
$bg2 = hexdec(substr($bg_color, -4, 2));
$bg1 = hexdec(substr($bg_color, -6, 2));
$bg = imagecolorallocate($img,$bg1,$bg2,$bg3);
$font_color_a = trim($spamcontrol_color);
$font_color_a3 = hexdec(substr($font_color_a, -2));
$font_color_a2 = hexdec(substr($font_color_a, -4, 2));
$font_color_a1 = hexdec(substr($font_color_a, -6, 2));
$font_color = imagecolorallocate($img,$font_color_a1,$font_color_a2,$font_color_a3);
$antispam = "";
for($i=0;$i<$spamcontrol_length;$i++)
{
   $xpos=2*$i*imagefontwidth($font_size);
   $ypos=rand(0,imagefontheight($font_size));
   $str=rand(0,9);
   imagechar($img,$font_size,$xpos,$ypos,$str,$font_color);
   $antispam .= $str;
}
$_SESSION["antispam"] = $antispam;
header("Content-Type: image/png");
imagepng($img); 
imagedestroy($img);
?> 