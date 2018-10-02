<?php
require_once __DIR__.'/../../inc/secureSession.php';
startSession();
error_reporting(E_ALL ^ E_NOTICE);
setcookie('cryptcookietest', "1");
header('Location: cryptographp.inc.php?cfg='.$_GET['cfg'].'&sn='.session_name().'&'.SID);
