<?php
/**
 * Created by PhpStorm.
 * User: Jurii
 * Date: 01.11.13
 * Time: 10:37
 *  �������� ��������� JS ��� ������ ������
 */

       require_once(__DIR__.'/inc/config.php');
       require_once(__DIR__.'/inc/func.php');

       if(isset($_POST['js'])) {
        $session->set('JS', true);
       echo 'js:'.($session->get('JS'));
       }