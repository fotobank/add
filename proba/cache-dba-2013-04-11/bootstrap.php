<?php
error_reporting(-1);

ini_set('default_charset', 'UTF-8');

date_default_timezone_set('UTC');

ini_set('display_errors', 'On');

set_include_path(
    dirname(__FILE__, 2)
    .DIRECTORY_SEPARATOR
    .'php-dba-cache'
    .PATH_SEPARATOR
    .__DIR__
    .PATH_SEPARATOR
    .get_include_path()
);

$root = __DIR__. DIRECTORY_SEPARATOR;
require_once $root . 'app'.DIRECTORY_SEPARATOR .'config.php';
require_once $root . 'src'. DIRECTORY_SEPARATOR .'Cache.php';
require_once $root . 'src'. DIRECTORY_SEPARATOR .'Serializer.php';
require_once $root  . 'src'. DIRECTORY_SEPARATOR .'Sweeper.php';
require_once $root . 'src'. DIRECTORY_SEPARATOR .'Capsule.php';
