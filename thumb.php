<?php
       header('Content-type: text/html; charset=windows-1251');
       require __DIR__.'/alex/fotobank/Framework/Boot/config.php';
       require __DIR__.'/inc/i_resize.php';



 if (isset($_GET['num'])) {

  $file = (string) $_GET['num'];
	$file = 'id'.$file.'.jpg';
	$rs = go\DB\query('SELECT a.*, p.id_album FROM albums as a, photos as p WHERE p.img = ? && p.id_album = a.id LIMIT 1',array($file),'row');
	$foto_folder = $rs['foto_folder'];
	$dirname = $foto_folder.$rs['id'].'/';
	$file_in = substr(($dirname),1) . $file;
	$file_out = $file_in;

	 if( !file_exists('.'.$dirname.'thumb'))  mkdir('.'.$dirname.'thumb', 0755, true);

	 if( file_exists('.'.$dirname.'thumb/'. $file ))
		{
		  header("Content-type: image/jpg");
		  readfile('.'.$dirname.'thumb/'. $file);
		}
	 else
		{
	   $file_out = '.'.$dirname.'thumb/'. $file;
      imageresize($file_out,$file_in,170,160,80,'','', 1);
		 if (is_file($file_out)) {
			  header("Content-type: image/jpg");
			  readfile('.'.$dirname.'thumb/'. $file);
	   }
   }
 }
