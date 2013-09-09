<?php
require_once (__DIR__.'/../autoload.php');
	autoload::getInstance();

$json = array(
    'value'  => check_Session::getInstance()->get('value'),
    'open'   => check_Session::getInstance()->sessionIsOpen(),
    'exist'  => check_Session::getInstance()->sessionExists()
);

header('Content-type: application/json');
echo json_encode($json);
exit(0);