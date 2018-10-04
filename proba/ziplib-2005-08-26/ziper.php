<?
include("zip.lib.php");
$ziper = new zipfile();
$ziper->addFiles(array("m.pdf","file.png"));
$ziper->output("zip2.zip");
?>
