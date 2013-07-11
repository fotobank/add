<?php
require_once(__DIR__.'/../checkSession.php');

$json = array(
    'value'  => checkSession::getInstance()->get('value'),
    'open'   => checkSession::getInstance()->sessionIsOpen(),
    'exist'  => checkSession::getInstance()->sessionExists()
);

header('Content-type: application/json');
echo json_encode($json);
exit(0);