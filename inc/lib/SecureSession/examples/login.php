<?php

// include either the PHP4 or PHP5 class
require_once("../SecureSession.php5.class.php");
$Session = new SecureSession;

// Run your usual login methods from queries to a users db etc


if ($username == "User" && $passwd == "password") {
	// All login info seems good, assign the user a unique fingerprint so they can roam the site / protected pages

	$Session->SetFingerPrint();
	$_SESSION['LoggedIn'] = true;

	// Redirect user to your logged in area
	header('Location: index.php');
	die();

} else {
	echo "Неверное имя пользователя или пароль";

}

?>