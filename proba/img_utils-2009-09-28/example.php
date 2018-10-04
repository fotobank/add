<?php
include('class.Img_utils.php');
$imgUtils = new Img_utils();

##########################################################################
# example 1 - converting file images: from jpg to png
$file_src = 'mydog.jpg';
$file_png = 'mydog';
$imgUtils->open($file_src);
$imgUtils->save($file_png, 'png'); //create 'mydog.png'


##########################################################################
# example 2 - creating 80x80 pixel thumb file
$file_src = 'mydog.jpg';
$file_png = 'mydog_thumb';
$imgUtils->open($file_src);
$imgUtils->resize(80,80);
$imgUtils->save($file_png, 'png'); //create 'mydog_thumb.png'


##########################################################################
# example 3 - crop image
$file_src = 'mydog.jpg';
$file_png = 'mydog_crop';
$imgUtils->open($file_src);
$imgUtils->crop(10,10,110,110);
$imgUtils->save($file_png, 'png'); //create 'mydog_crop.png'


##########################################################################
# example 4 - crop image and creatate a 50x50 pixel thumb
$file_src = 'mydog.jpg';
$file_png = 'mydog_thumb_crop';
$imgUtils->open($file_src);
$imgUtils->crop(0,0,100,100);
$imgUtils->resize(50,50);
$imgUtils->save($file_png, 'png');  //create 'mydog_thumb_crop.png'

?>