<?

require("backend.php");

$register = $authlib->register($HTTP_POST_VARS['username'], $HTTP_POST_VARS['password'], $HTTP_POST_VARS['password2'], $HTTP_POST_VARS['name'], $HTTP_POST_VARS['email'], $HTTP_POST_VARS['age'], $HTTP_POST_VARS['sex'], $HTTP_POST_VARS['school']);

if ($register == 2) {

	include("html/register_done.html");

}

else {

	include("html/register_error.html");

}

?>