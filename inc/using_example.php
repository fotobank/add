<?php


$err = new Error_Processor;

$err->err_proc('Test message ¹1','wld', __FILE__ , __LINE__ );

echo $err->err_write();
$err->log_send();

?>
