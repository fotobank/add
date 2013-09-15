<?
define('SR_DENIED', true);
if (!include ("config.inc.php")) {
		 die("Не найден рабочий файл конфигурации");
}

function clean($string) {

		 /////////// очистка строки адреса ////////////
		 $string = preg_replace("'[^_A-Z.a-z0-9-]'", "", $string);

		 return ($string);
}

$font_size = $email_size;
$string = clean($_GET["mm2"])."@".clean($_GET["mm1"]);
$width = imagefontwidth($font_size) * strlen($string);
$height = imagefontheight($font_size);
$img = imagecreate($width, $height);
$bg_color = trim($DARK);
$bg3 = hexdec(substr($bg_color, -2));
$bg2 = hexdec(substr($bg_color, -4, 2));
$bg1 = hexdec(substr($bg_color, -6, 2));
$bg = imagecolorallocate($img, $bg1, $bg2, $bg3);
$font_color_a = trim($DARKFONTLINK);
$font_color_a3 = hexdec(substr($font_color_a, -2));
$font_color_a2 = hexdec(substr($font_color_a, -4, 2));
$font_color_a1 = hexdec(substr($font_color_a, -6, 2));
$font_color = imagecolorallocate($img, $font_color_a1, $font_color_a2, $font_color_a3);
$len = strlen($string);

for ($i = 0; $i < $len; $i++) {
		 $xpos = $i * imagefontwidth($font_size);
		 $ypos = 0;
		 imagechar($img, $font_size, $xpos, $ypos, $string, $font_color);
		 $string = substr($string, 1);
}
header("Content-Type: image/png");
imagepng($img);
imagedestroy($img);
?>
