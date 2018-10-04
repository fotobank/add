<?php

require("backend.php");

$login_check = $authlib->is_logged();

if (!$login_check) {

	include("html/nologin.html");
	exit;

}

if (!$password || !$password2) {

	include("html/chpass.html");

}

else { 

	$chpass = $authlib->chpass($login_check[1], $HTTP_POST_VARS['password'], $HTTP_POST_VARS['password2']);

	if ($chpass != 2) {

		require("html/chpass_error.html");

	}

	else {

		require("html/chpass_done.html");

	}

}

?>