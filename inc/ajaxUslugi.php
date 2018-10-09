<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 25.07.13
 * Time: 0:51
 * To change this template use File | Settings | File Templates.
 */

 // header('Content-type: text/html; charset=windows-1251');

       try {
              require_once __DIR__.'/../vendor/autoload.php';
       }
       catch (RuntimeException $e) {
              if (check_Session::getInstance()->has('DUMP_R')) {
                     dump_r($e->getMessage());
              }
       }

  if(isset($_POST['url']))  //
	 {
		$url = iconv('utf-8', 'cp1251', trim($_POST['url']));
		$galery = iconv('utf-8', 'cp1251', trim($_POST['galery']));
		$height = (int)$_POST['height'];

		$thumb = new autoPrev();
		// вывод превьюшек
		echo	$thumb->printPrev($url, $galery, $height); // $url - папка фотографий, $galery - название галлереи, $height - высота превьюшек
	 }
