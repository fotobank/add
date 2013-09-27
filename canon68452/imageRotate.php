<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 11.06.13
 * Time: 19:16
 * To change this template use File | Settings | File Templates.
 */
  include (dirname(__FILE__).'/../inc/config.php');
  include (dirname(__FILE__).'/../inc/func.php');
  header("Content-type: image/jpg");
  if (isset($_POST['go_turn']))
	 {
		$id          = $_POST['go_turn'];
		$povorot     = intval($_POST['povorot']);
		$img_name    = go\DB\query('select img from photos where id = ?i',array($id), 'el');
		$foto_folder = go\DB\query('select foto_folder from albums where id = ?i', array($_SESSION['current_album']),'el');
		$source      = $_SERVER['DOCUMENT_ROOT'].$foto_folder.intval($_SESSION['current_album']).'/'.$img_name;
		$tmp_file    = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$img_name;
		$ext         = strtolower(substr($source, strrpos($source, '.') + 1));
		rename($source, $tmp_file);
		switch ($ext)
		{
		  default:
		  case 'jpg':
		  case 'jpeg':
				$img = imagecreatefromJPEG($tmp_file);
				break;
		  case 'gif':
				$img = imagecreatefromGIF($tmp_file);
				break;
		  case 'png':
				$img = imagecreatefromPNG($tmp_file);
				break;
		}
		$result = imagerotate($img, $povorot, 0);
		switch ($ext)
		{
		  default:
		  case 'jpg':
		  case 'jpeg':
				imagejpeg($result, $source);
				break;
		  case 'gif':
				imagegif($result, $source);
				break;
		  case 'png':
				imagepng($result, $source);
				break;
		}
		$res_foto = $foto_folder.intval($_SESSION['current_album']).'/'.$img_name;
		//send_img($id, $res_foto);
	// 	echo $res_foto;
		echo "<img style='width: 120px; float: left;' src= '".$res_foto."?t=".time()."'>";
//echo 'window.parent.document.getElementById("'.$id.'").innerHTML=\'<img style="width: 120px; float: left;" src="'.$res_foto.'?t='.time().'">\';';
	//	echo "<img style='width: 120px; float: left;' src='.$res_foto.'?t='.time()'>";
		imagedestroy($result);
		imagedestroy($img);
		unlink($tmp_file);
	 }