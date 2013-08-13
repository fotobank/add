<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 25.07.13
 * Time: 0:51
 * To change this template use File | Settings | File Templates.
 */

 // header('Content-type: text/html; charset=windows-1251');

  if(isset($_POST['url']))  //
	 {
		include (__DIR__.'./../inc/autoPrev.php');
		$url = iconv('utf-8', 'cp1251', trim($_POST['url']));
		$galery = iconv('utf-8', 'cp1251', trim($_POST['galery']));
		$height = intval($_POST['height']);

		$thumb = new autoPrev();
		// вывод превьюшек
		echo	$thumb->printPrev($url, $galery, $height); // $url - папка фотографий, $galery - название галлереи, $height - высота превьюшек
	 }
?>