<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 12.05.13
 * Time: 15:46
 * To change this template use File | Settings | File Templates.
 */

	include (dirname(__FILE__).'/config.php');
	include (dirname(__FILE__).'/func.php');

	if (isset($_POST['goPecatDel']))
		{
			unset($_SESSION['basket'][intval($_POST['goPecatDel'])]);
			header("Content-type: image/png");
			echo "
			<div style='margin:25px 0 0 5px;'>
			<img style='width: 140px; float: left; margin-left: 5px;' src= '/img/not_foto.png'>
			</div>";
		}