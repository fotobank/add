<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 20.04.13
 * Time: 10:51
 * To change this template use File | Settings | File Templates.
 */

	include __DIR__.'/../../inc/config.php';
	include __DIR__.'/../../inc/func.php';

	if (isset($_POST['go_delete']))
		{
			$id          = intval($_POST['go_delete']);
			$img_name    = mysql_result(mysql_query('select img from photos where id = '.$id), 0);
			$foto_folder =
				mysql_result(mysql_query('select foto_folder from albums where id = '.intval($_SESSION['current_album']).'  '), 0);
			$source      = $_SERVER['DOCUMENT_ROOT'].$foto_folder.intval($_SESSION['current_album']).'/'.$img_name;
			if(isset($img_name)) unlink($source);
			mysql_query('delete from photos where id = '.$id);
	   	header("Content-type: image/png");
			echo "<img style='width: 140px; float: left; margin-left: 5px;' src= '/img/not_foto.png'>";
		}

	if (isset($_POST['go_edit_name']))
		{
			$id = intval($_POST['go_edit_name']);
			$nm = mysql_escape_string($_POST['nm']);
			if (empty($nm))
				{
					$nm = 'Не заданно';
				}
	 	mysql_query('update photos set nm = \''.$nm.'\' where id = '.$id);
		}


	if (isset($_POST['go_edit_price']))
		{
			$id    = intval($_POST['go_edit_price']);
			$price = floatval($_POST['price']);
			mysql_query('update photos set price = \''.$price.'\' where id = '.$id);
		}