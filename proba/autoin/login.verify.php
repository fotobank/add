<?php
require('inc/header.inc.php');
if (!isset($rememberme)) $rememberme=false;
if ($SZUserMgnt->login($username, $password, $rememberme)) {
  session_start();
  if ($_SESSION["SESS_level"] >= 10) {
    header("Location: users.list.php");
  } else {
    header("Location: page.php");
  }
} else {
  echo $SZUserMgnt->ERROR_MSG;
  #header("Location: login.php");
}
?>