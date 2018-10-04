<?

require("backend.php");

if (!$HTTP_POST_VARS['username'] || !$HTTP_POST_VARS['password']) {

	include("html/login_notext.html");
	exit;

}

$login = $authlib->login($HTTP_POST_VARS['username'], $HTTP_POST_VARS['password']);

if (!$login) {

	include("html/login_error.html");

}

else {

	include("html/login_done.html");

}

?>