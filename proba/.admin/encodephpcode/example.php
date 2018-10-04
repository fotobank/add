<?php

require_once("EncodeAndOptimizePhp.inc.php");
$encodeAndOptimizePhp = new EncodeAndOptimizePhp;
$encodeAndOptimizePhp->encodePhpFile('test.php');
// the encoded file(output file) will be in the same directory by the name: inputFileName.encoded.php
// in this case it will be =>  test.encoded.php
?>
