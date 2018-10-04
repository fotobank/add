<?php
require('MySQLHandler.class.php');
require('SZUserMgnt.class.php');
require('SZMail.class.php');
$MySQLHandler = new MySQLHandler();
$SZMail = new SZMail();
$MySQLHandler->init();
$SZUserMgnt = new SZUserMgnt($MySQLHandler, $SZMail);
?>