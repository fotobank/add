<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
if ($SZUserMgnt->updateUser($ID, $username, $email, $level)) {
  header("Location: users.list.php");
} else {
  echo $SZUserMgnt->ERROR_MSG;
}
?>