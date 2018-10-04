<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
if ($SZUserMgnt->removeLevel($ID)) {
  header("Location: users.levels.list.php");
} else {
  echo $SZUserMgnt->ERROR_MSG;
}
?>