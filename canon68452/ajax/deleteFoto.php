<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 20.04.13
 * Time: 10:51
 * To change this template use File | Settings | File Templates.
 */

	if (isset($_POST['go_delete']))
		{
			$id          = intval($_POST['go_delete']);
			$img_name    = mysql_result(mysql_query('select img from photos where id = '.$id), 0);
			$foto_folder =
				mysql_result(mysql_query('select foto_folder from albums where id = '.intval($_SESSION['current_album']).'  '), 0);
			$source      = $_SERVER['DOCUMENT_ROOT'].$foto_folder.intval($_SESSION['current_album']).'/'.$img_name;
			unlink($source);
			mysql_query('delete from photos where id = '.$id);
			echo "<img src='/img/not_foto.png' >";
		}