<?php
require_once(__DIR__.'/../../inc/secureSession.php');
startSession();
//session_start();
error_reporting(E_ALL ^ E_NOTICE);
SetCookie("cryptcookietest", "1");
Header("Location: cryptographp.inc.php?cfg=".$_GET['cfg']."&sn=".session_name()."&".SID);
?>
