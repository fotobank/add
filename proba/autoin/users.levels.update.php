<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
if ($SZUserMgnt->updateLevel($ID, $level, $level_name)) {
  header("Location: users.levels.list.php");
} else {
  echo $SZUserMgnt->ERROR_MSG;
}
?>