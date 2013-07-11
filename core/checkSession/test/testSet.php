<?php
require_once(__DIR__.'/../checkSession.php');

checkSession::getInstance()->set('value', 123);

$json = array(
    'value'  => checkSession::getInstance()->get('value'),
    'open'   => checkSession::getInstance()->sessionIsOpen(),
    'exist'  => checkSession::getInstance()->sessionExists(),
    'sessid' => session_id()
);

header('Content-type: application/json');
echo json_encode($json);
exit(0);