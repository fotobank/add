<?php
require('inc/header.inc.php');
require('inc/auth.inc.php');
if ($SZUserMgnt->updatePassword($SESS_user_id, $old_password, $new_password, $confirm_password)) {
  header("Location: page.php");
} else {
  echo $SZUserMgnt->ERROR_MSG;
}
?>