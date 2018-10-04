<?php

set_time_limit(600);

require_once 'class.ImageBatchProcessor.php';

// Transform c:/mypics/picture1.jpg to c:/album/picture_large.jpg.
// Maximal size: 800x600, rotate 90' clockwise, add a text label.
$t1 = new ImageBatchTransformation();
$t1->source = 'c:/mypicts/picture1.jpg';
$t1->destination = 'c:/album/picture_large.jpg';
$t1->maxWidth = 800;
$t1->maxHeight = 600;
$t1->format = TI_JPEG;
$t->jpegQuality = 85;
$t1->interlace = true;
$t1->rotateAngle = -90;
$t1->rotateBgColor = '#000000';
$t1->replaceExisted = true;
$t3->label['text'] = '(c) 2008 www.example.com';
$t3->label['vertPos'] = TI_POS_BOTTOM;
$t3->label['horzPos'] = TI_POS_RIGHT;
$t3->label['font'] = 'c:/windows/fonts/Arial.ttf';
$t3->label['size'] = 10;
$t3->label['color'] = '#ffff00';
$t3->label['angle'] = 0;

// Transform c:/mypics/picture1.jpg to c:/album/picture_small.jpg.
// Maximal size: 100x100, rotate 90' clockwise.
$t2 = new ImageBatchTransformation();
$t2->source = 'c:/mypicts/picture1.jpg';
$t2->destination = 'c:/album/picture_small.jpg';
$t2->maxWidth = 100;
$t2->maxHeight = 100;
$t2->format = TI_JPEG;
$t2->interlace = false;
$t2->rotateAngle = -90;
$t2->rotateBgColor = '#000000';
$t2->replaceExisted = true;

// Transform c:/mypics/picture2.jpg to c:/album/picture2.jpg.
// Maximal size: 450x400, add a text label and a watermark.
$t3 = new ImageBatchTransformation();
$t3->source = 'c:/mypics/picture2.jpg';
$t3->destination = 'c:/album/picture2.jpg';
$t3->maxWidth = 450;
$t3->maxHeight = 400;
$t3->format = TI_JPEG;
$t->jpegQuality = 85;
$t3->interlace = true;
$t3->replaceExisted = true;
$t3->label['text'] = '(c) 2008 www.example.com';
$t3->label['vertPos'] = TI_POS_BOTTOM;
$t3->label['horzPos'] = TI_POS_RIGHT;
$t3->label['font'] = 'c:/windows/fonts/Arial.ttf';
$t3->label['size'] = 10;
$t3->label['color'] = '#ffff00';
$t3->label['angle'] = 0;
$t3->logo['file'] = 'c:/mypics/logos/logo.gif';
$t3->logo['vertPos'] = TI_POS_TOP;
$t3->logo['horzPos'] = TI_POS_LEFT;

$ibp = new ImageBatchProcessor();
$n = $ibp->processEx(array($t1, $t2, $t3));

printf('%d images processed.', $n);

?>