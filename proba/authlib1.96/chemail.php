<?php

require("backend.php");

$login_check = $authlib->is_logged();

if (!$login_check) {

	include("html/nologin.html");
	exit;

}

if (!$email || !$email2) {

	include("html/chemail.html");

}

else {

	$chemail = $authlib->chemail($login_check[1], $HTTP_POST_VARS['email'], $HTTP_POST_VARS['email2']);

	if ($chemail != 2) {

		include("html/chemail_error.html");

	}

	else {

		include("html/chemail_done.html");

	}

}

?>