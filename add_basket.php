<?php
  include (__DIR__.'/inc/config.php');
  if (isset($_POST['id']))
	 {
		ob_start();
		$id     = $_POST['id'];
		$status = 'ERR';
		$msg    = 'File not found!';
		if (!$session->has("logged"))
		  {
			 $msg = 'Пожалуйста, зарегистрируйтесь и войдите на сайт под своим именем.';
		  }
		else
		  {
			 if ($id)
				{
          include(__DIR__.'/classes/md5/md5_ini.php'); // подключть настройки md5 class
          $idImg = go::call('md5_loader', $ini)->idImg(array("query"  => $id)); // восстановить номер фотографии из хеша
				  $rs = go\DB\query('select p.id_album, a.nm
				                    from photos p, albums a
				                    where p.id_album = a.id
				                    and p.id = ?i', array($idImg), 'row');
				  if ($rs)
					 {
						$id_album = $rs['id_album'];
						$nm = $rs['nm'];
            $session->inc("basket/".$idImg); // увеличить на 1 заказ фотографий
            $session->set("zakaz/album_name/".$id_album, $nm); // установить название альбома
						$status = 'OK';
						$msg    = 'Фотография добавлена в корзину';
					 }
				}
		  }
		ob_end_clean();
		echo json_encode(array('status' => $status, 'msg' => $msg));
		go\DB\Storage::getInstance()->get()->close(true);
	 }
?>