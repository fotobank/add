<?php
require_once('server.cls.php');
$passport = new Passport;
echo $passport->validate($_REQUEST['key'], $_REQUEST['keypas'], $_REQUEST['user'], $_REQUEST['pass']);
?>