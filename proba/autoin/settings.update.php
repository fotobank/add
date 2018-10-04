<?php
require('inc/header.inc.php');
require('inc/auth.inc.php');
if ($SZUserMgnt->setPreferences($pwd_remind_header, $pwd_remind_body, $new_account_header, $new_account_body, $mail_sender_name, $mail_sender_email)) {
  header("Location: settings.php");
} else {
  echo $SZUserMgnt->ERROR_MSG;
}

?>