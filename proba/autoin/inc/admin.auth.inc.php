<?php
session_start();
if (!isset($PHPSESSID) or !isset($SESS_username) or ($SESS_level < 10)) {
  if (!$SZUserMgnt->rememberMe()) {
    header("Location: login.php");
  } else {
    header("Location: users.list.php");
  }
} else {
  $SZUserMgnt->updateSessionData($PHPSESSID);
}
?>