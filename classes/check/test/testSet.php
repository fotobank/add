<?php
require_once(__DIR__.'/../check_Session.php');

check_Session::getInstance()->set('value', 123);

$json = array(
    'value'  => check_Session::getInstance()->get('value'),
    'open'   => check_Session::getInstance()->sessionIsOpen(),
    'exist'  => check_Session::getInstance()->sessionExists(),
    'sessid' => session_id()
);

header('Content-type: application/json');
echo json_encode($json);
exit(0);