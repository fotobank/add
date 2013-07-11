<?php
require_once(__DIR__.'/../checkSession.php');

checkSession::getInstance()->set('value', 'test');
$hasBefore = checkSession::getInstance()->has('value');
checkSession::getInstance()->del('value');
$hasAfter = checkSession::getInstance()->has('value');

$json = array(
    'hasBefore' => $hasBefore,
    'hasAfter'  => $hasAfter,
    'value'     => checkSession::getInstance()->get('value'),
    'open'      => checkSession::getInstance()->sessionIsOpen(),
    'exist'     => checkSession::getInstance()->sessionExists()
);

header('Content-type: application/json');
echo json_encode($json);
exit(0);