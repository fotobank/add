<?php
       try {
              require_once __DIR__.'/../../../vendor/autoload.php';
       }
       catch (\RuntimeException $e) {
              if (\check_Session::getInstance()->has('DUMP_R')) {
                     dump_r($e->getMessage());
              }
       }

check_Session::getInstance()->set('value', 'test');
$hasBefore = check_Session::getInstance()->has('value');
check_Session::getInstance()->del('value');
$hasAfter = check_Session::getInstance()->has('value');

$json = array(
    'hasBefore' => $hasBefore,
    'hasAfter'  => $hasAfter,
    'value'     => check_Session::getInstance()->get('value'),
    'open'      => check_Session::getInstance()->sessionIsOpen(),
    'exist'     => check_Session::getInstance()->sessionExists()
);

header('Content-type: application/json');
echo json_encode($json);
exit(0);
