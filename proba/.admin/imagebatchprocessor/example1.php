<?php

// Set script execution time limit to 10 minutes.
set_time_limit(600);

// Include class definition file.
require_once 'class.ImageBatchProcessor.php';

// Create transformation object.
$t = new ImageBatchTransformation();
// Source and destination directories.
$t->source = 'c:/mypicts/album1/';
$t->destination = 'd:/album/';
// Destination image format: TI_JPEG, TI_PNG or TI_GIF.
$t->format = TI_JPEG;
// Destination JPEG quality: 0 - 100 or -1 for default value.
$t->jpegQuality = -1;
// Interlacing mode: TI_INTERLACE_ON or TI_INTERLACE_OFF.
$t->interlace = TI_INTERLACE_ON;
// Maximal width and height of destination image.
$t->maxWidth = 150;
$t->maxHeight = 150;
// Force small images to enlarge to fit the maximal width and height.
$t->fitToMax = false;
// Replace existed files in destination directory.
$t->replaceExisted = true;

// Create batch processor object.
$ibp = new ImageBatchProcessor();

// Process batch transformation.
//
// First parameter is a trasformation object, second is optional filter of
// filenames (there are 2 predefined filters: the default IBP_IMAGE_REGEXP,
// which filters only images and IBP_ALL_REGEXP for all files), third is an
// optional maximum number of files to be processed.
//
// Returns the number of processed files.
$n = $ibp->process($t, '/^(.*)(\.jpg|\.jpeg)$/is', 10);

printf('%d images processed.', $n);

?>