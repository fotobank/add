<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['password']);
destroySession();
//session_destroy();
$sessionPath = session_get_cookie_params();
setcookie(session_name(), "", 0, $sessionPath["path"], $sessionPath["domain"]);
unset($login, $password, $entered_login, $entered_password);
?>
