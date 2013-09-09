<?php
	require_once (__DIR__.'/../../autoload.php');
	autoload::getInstance();

check_Session::getInstance()->clearSession();

$json = array(
    'open'   => check_Session::getInstance()->sessionIsOpen(),
    'exist'  => check_Session::getInstance()->sessionExists()
);

header('Content-type: application/json');
echo json_encode($json);
exit(0);