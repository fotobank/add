<?

require("backend.php");

$confirm = $authlib->confirm_email($HTTP_GET_VARS['id'], $HTTP_GET_VARS['email'], $HTTP_GET_VARS['mdhash']);

if ($confirm != 2) {

	include("html/confirm_email_error.html");

}

else {

	include("html/confirm_email_done.html");

}

?>