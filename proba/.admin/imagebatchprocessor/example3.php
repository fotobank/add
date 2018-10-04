<?php

set_time_limit(600);

// Define a callback function.
//
// The parameters are: directory path, current index, zero-padded index, full
// filename, filename without extension and extension started with a dot.
function batchRename($path, $index, $padded, $fileName, $baseName, $extension)
{
    $oldName = $path . $fileName;
    $newName = $path . 'photo' . $padded . $extension;
    return rename($oldName, $newName);
}

require_once 'class.ImageBatchProcessor.php';
$ibp = new ImageBatchProcessor();

// Walk through a directory.
//
// First parameter is directory path, second is the name of callback function,
// third is optional filter of filenames (there are 2 predefined filters: the
// default IBP_ALL_REGEXP and IBP_IMAGE_REGEXP for images only).
//
// Returns the number of processed files.
$ibp->dirWalk('d:/album/', 'batchRename', '/^(.*)(\.jpg|\.jpeg)$/is');

?>