<?

require("backend.php");

$login_check = $authlib->is_logged();

if (!$login_check) {

	include("html/nologin.html");

}

else {

	include("html/admin.html");

}

?>