<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
if ($SZUserMgnt->removeUser($ID)) {
  header("Location: users.list.php");
} else {
  echo $SZUserMgnt->ERROR_MSG;
  #header("Location: login.php");
}
?>