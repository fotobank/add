<?php

set_time_limit(600);

require_once 'class.ImageBatchProcessor.php';

$ibp = new ImageBatchProcessor();

$t = new ImageBatchTransformation();
$t->source = 'c:/mypicts/album1/';
$t->destination = 'd:/album/';
$t->format = TI_JPEG;
$t->jpegQuality = -1;
$t->interlace = TI_INTERLACE_ON;
$t->maxWidth = 150;
$t->maxHeight = 150;
$t->fitToMax = false;
$t->replaceExisted = true;

// Process all JPEGs from the directory except mypict.jpg.
$n = $ibp->process($t, '/^(?!mypict.jpg$)(.*)(\.jpg)$/is');

$t->source = 'c:/mypicts/album1/mypict.jpg';
$t->destination = 'd:/album/mypict.jpg';
$t->rotateAngle = -90;

// Rotate and process mypict.jpg.
$n += $ibp->processEx(array($t));

printf('%d images processed.', $n);

?>