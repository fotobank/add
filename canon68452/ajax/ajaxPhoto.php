<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 20.04.13
 * Time: 10:51
 * To change this template use File | Settings | File Templates.
 */

	include (dirname(__FILE__).'/../../inc/config.php');
	include (dirname(__FILE__).'/../../inc/func.php');

	if (isset($_POST['go_delete']))
		{
	//		$id          = intval($_POST['go_delete']);
	//		$img_name    = mysql_result(mysql_query('select img from photos where id = '.$id), 0);
			$id          = $_POST['go_delete'];
			$img_name    = $db->query('select img from photos where id = (?string)' ,$id, 'el');
//			$foto_folder = mysql_result(mysql_query('select foto_folder from albums where id = '.intval($_SESSION['current_album']).'  '), 0);
			$foto_folder = $db->query('select foto_folder from albums where id = (?scalar)',$_SESSION['current_album'],'el');
			$source      = $_SERVER['DOCUMENT_ROOT'].$foto_folder.intval($_SESSION['current_album']).'/'.$img_name;
			if(isset($img_name)) unlink($source);
			$db->query('delete from photos where id = (?scalar)',$id);
	   	header("Content-type: image/png");
			echo "<img style='width: 140px; float: left; margin-left: 5px;' src= '/img/not_foto.png'>";
		}

	if (isset($_POST['go_edit_name']))
		{
    		$id = $_POST['go_edit_name'];
			$nm = $_POST['nm'];
			if (empty($nm))
				{
					$nm = 'Не заданно';
				}
			$db->query('update photos set nm = (?string) where id = (?scalar)', array($nm,$id));
		}


	if (isset($_POST['go_edit_price']))
		{
			$id    = $_POST['go_edit_price'];
			$price = $_POST['price'];
			$db->query('update photos set price = (?string) where id = (?scalar)', array($price,$id));
		}