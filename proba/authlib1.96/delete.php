<?php

require("backend.php");

$login_check = $authlib->is_logged();

if (!$login_check) {

	include("html/nologin.html");
	exit;

}

$delete = $authlib->delete($login_check[1]);

setcookie("authlib_basic");

include("html/delete_done.html");

?>