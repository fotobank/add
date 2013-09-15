<?php

// include either the PHP4 or PHP5 class
require_once("../SecureSession.php5.class.php");

// Initialising this class calls session_start() for you and sets the session lifetime to an hour
// Example: $Session = new SecureSession;
// Start the class with all default parameters (1 hour session life, sha256 encryption for fingerprint (if possible),
// utilise 3 blocks of the IP address

// Alternatively, pass arguments to the constructor method to change the defaults:
// Example: $Session = new SecureSession(3600, "my secure words", true, 2);

// All arguments are optional, you may bypass the lifetime argument by passing null as the value, this will
// keep the script operating at the default lifetime of 1 hour
// Example: $Session = new SecureSession(null, "loremipsum", false);

$Session = new SecureSession;

if (isset($_SESSION['LoggedIn'])) {	// If sensitive session info / login is claimed, begin checking

	// $Session->AnalyseFingerPrint() tests the finger print stored in the session against a new request
	// The function returns true if the prints match, false otherwise.
	// Optionally you can pass a variable name as the argument of the method, this will receive a copy
	// of the verification check results which you can examine to serve up different error messages

	//** IMPORTANT **//
	// This argument is passed by reference with a default value of null, in PHP5 this argument is optional
	// and can be ommitted, PHP4 however requires you to supply a variable name as the argument as it doesn't
	// like function arguments with a default value of null that are passed by reference.

	if ($Session->AnalyseFingerPrint($Analysis) === true) {

		echo "Fingerprints verified - You're logged in";

	} else { // $Session->AnalyseFingerPrint() returned false, so kill the session and optionally throw error

		$Session->Destroy();	// This method resets the $_SESSION array, removes the session cookies and destroys the session

		// Possible return values of $Analysis pass by reference var:

		// true	 - Fingerprint match OK, no problems.
		// false - A fingerprint was stored in the session, but doesnt match a new request
		// null  - No fingerprint variable was stored in the user's session to check

		// Example of using $Analysis var to serve up different errors, redirects etc

		echo "We kicked you out the site because you're an ";
		echo ($Analysis === false) ? "Imposter - Your fingerprints don't match" : "Infiltrator - You have no finger prints";

	}

}

?>