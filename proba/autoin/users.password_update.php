<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
if (!isset($generate_password)) $generate_password=false;
if ($SZUserMgnt->setPassword($ID, $new_password, $confirm_password, $generate_password)) {
  header("Location: users.list.php");
} else {
  echo $SZUserMgnt->ERROR_MSG;
}
?>