<?php

require("backend.php");

$lostpass = $authlib->lostpwd($HTTP_POST_VARS['email']);

if ($lostpass == 2) {

	include("html/lostpass_done.html");

}

else {

	include("html/lostpass_error.html");

}

?>