<?php
//	MailCrypter Class Example Usage:

	include('MailCrypter.php');

	//instantiate new MailCrypter object
	$crypt = new MailCrypter();

	//echo a scrambled mailto: link
	echo $crypt->addMailTo("someone@somewhere.com");

	echo "<br>";

	//echo as many links as you want
	echo $crypt->addMailTo("someone-else@somewhere-else.com");


	//echo the javascript code that descrambles all written links
	//note: you must call writeScript AFTER echoing all the scrambled links on your page
	$crypt->writeScript();
