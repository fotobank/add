<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 20.04.13
 * Time: 10:51
 * To change this template use File | Settings | File Templates.
 */

	include __DIR__.'/../../alex/fotobank/Framework/Boot/config.php';

	if (isset($_POST['go_delete']))
		{
			$id          = $_POST['go_delete'];
			$img_name    = go\DB\query('select `img` from photos where `id` = ?i',array($id), 'el');
			$foto_folder = go\DB\query('select `foto_folder` from albums where `id` = ?i',array($_SESSION['current_album']),'el');
			$source      = $_SERVER['DOCUMENT_ROOT'].$foto_folder.intval($_SESSION['current_album']).'/'.$img_name;
			if(isset($img_name)) unlink($source);
			go\DB\query('delete from photos where id = ?i',array($id));
	   	header("Content-type: image/png");
			echo "<img style='width: 140px; float: left; margin-left: 5px;' src= '/img/not_foto.png'>";
		}

	if (isset($_POST['go_edit_name']))
		{
    		$id = $_POST['go_edit_name'];
			$nm =  iconv('utf-8', 'cp1251', trim($_POST['nm']));
			if (empty($nm))
				{
					$nm = '�� �������';
				}
			go\DB\query('update photos set nm = ?string where id = ?i', array($nm,$id));
		}


	if (isset($_POST['go_edit_price']))
		{
			$id    = $_POST['go_edit_price'];
			$price = $_POST['price'];
			go\DB\query('update photos set price = ?string where id = ?i', array($price,$id));
		}
