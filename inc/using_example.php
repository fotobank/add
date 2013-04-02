<?php
include 'lib_mail.php';
//include 'lib_errors.php';

$err = new Error_Processor;

$err->err_proc('Test message #1!!!','');
$err->err_proc('Test message #2!!!','');
echo $err->err_write();
$err->log_send();
?>
