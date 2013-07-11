<?php
require_once(__DIR__.'/../checkSession.php');

checkSession::getInstance()->clearSession();

$json = array(
    'open'   => checkSession::getInstance()->sessionIsOpen(),
    'exist'  => checkSession::getInstance()->sessionExists()
);

header('Content-type: application/json');
echo json_encode($json);
exit(0);