<?php
session_start();
        $im = @imagecreate (80, 20) or die ("Cannot initialize new GD image stream!");
		$bg = imagecolorallocate ($im, 232, 238, 247);
		$char = abs(intval($_SESSION['mt'])).abs(intval($_SESSION['mt1']));

		//������ ��� �� ����
		for ($i=0; $i<=128; $i++) {
			$color = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255)); //����� ����
			imagesetpixel($im, rand(2,80), rand(2,20), $color); //������ �������
		}

		//������� ������� ����
		for ($i = 0; $i < strlen($char); $i++) {
			$color = imagecolorallocate ($im, rand(0,255), rand(0,128), rand(0,255)); //����� ����
			$x = 5 + $i * 20;
			$y = rand(1, 6);
			imagechar ($im, 5, $x, $y, $char[$i], $color);
		}
		if (function_exists("imagepng")) {
		   header("Content-type: image/png");
		   imagepng($im);
		} elseif (function_exists("imagegif")) {
		   header("Content-type: image/gif");
		   imagegif($im);
		} elseif (function_exists("imagejpeg")) {
		   header("Content-type: image/jpeg");
		   imagejpeg($im);
		} else {
		   die("No image support in this PHP server!");
		}
		imagedestroy ($im);
        ?>
