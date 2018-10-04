<?

require("backend.php");

$confirm = $authlib->confirm($HTTP_GET_VARS['hash'], $HTTP_GET_VARS['username']);

if ($confirm != 2) {

	include("html/confim_error.html");
	exit;
}

else {
	include("html/confirm_done.html");
}

?>