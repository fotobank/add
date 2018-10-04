<?

require("backend.php");

$login_check = $authlib->is_logged();

if (!$login_check) {

	include("html/nologin.html");
	exit;

}

if (!$HTTP_POST_VARS['name'] || !$HTTP_POST_VARS['age'] || !$HTTP_POST_VARS['sex'] || !$HTTP_POST_VARS['school']) {

	list($name, $age, $sex, $school, $email) = $authlib->edit_retrieve($login_check[1]);

	if ($sex == "Male") {

		$st = "<option value=Male selected>Male</option><option value=Female>Female</option></select>";

	}

	else {

		$st = "<option value=Female selected>Female</option><option value=Male>Male</option></select>";

	}

	include("html/edit.html");

}

else {

	$update = $authlib->edit($login_check[1], $HTTP_POST_VARS['name'], $HTTP_POST_VARS['age'], $HTTP_POST_VARS['sex'], $HTTP_POST_VARS['school']);

	if ($update != 2) {

		include("html/edit_error.html");

	}

	else {

		include("html/edit_done.html");

	}

}

?>