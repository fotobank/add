<?php
/**
 * Created by PhpStorm.
 * User: Jurii
 * Date: 01.11.13
 * Time: 10:37
 *  проверка включения JS при потере сессии
 */

       require_once __DIR__.'/alex/fotobank/Framework/Boot/config.php';

       if(isset($_POST['js'])) {
        $session->set('JS', true);
       echo 'js:'.$session->get('JS');
       }
