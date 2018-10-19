<?php

       use Framework\Core\Config\Config;

       defined('DS') or define('DS', DIRECTORY_SEPARATOR);
       define('ROOT_PATH', realpath(__DIR__).DS);
       // путь к Framework
       define('SYS_DIR', ROOT_PATH.'alex'.DS.'fotobank'.DS.'Framework'.DS);
       /**
        * путь к сайту
        */
       define('SITE_DIR', ROOT_PATH.'alex'.DS.'fotobank'.DS.'Site'.DS);

       include_once ROOT_PATH.'inc/head.php';

       $config = new Config();
       $t = $config('db');

       $renderData['dataDB'] = go\DB\query('select `txt` from `content` where `id` = ?i', [1], 'el');
       $loadTwig('.twig', $renderData);
       include_once ROOT_PATH.'inc/footer.php';
