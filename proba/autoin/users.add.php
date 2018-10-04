<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
if (!isset($generate_password)) $generate_password=false;
if ($SZUserMgnt->addUser($username, $email, $password, $confirm_password, $generate_password, $level)) {
  header("Location: users.list.php");
} else {
  echo $SZUserMgnt->ERROR_MSG;
}
?>