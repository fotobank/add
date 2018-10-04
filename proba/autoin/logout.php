<?php
session_start();
require('inc/header.inc.php');
$SZUserMgnt->logout($PHPSESSID);
header("Location: login.php");
?>