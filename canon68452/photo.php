<?

function send_img($id, $res_foto)
	{

		echo '<script type="text/javascript">';
		echo'window.parent.document.getElementById("'.$id.'").innerHTML=\'<img style="width: 120px; float: left;" src="'
			.$res_foto.'?t='.time().'">\';';
		echo '</script>';
	}

if (!isset($_SESSION['admin_logged']))
	{
		die();
	}
define('RECORDS_PER_PAGE', 78);

if (isset($_POST['go_add']) && isset($_SESSION['current_album']) && intval($_SESSION['current_album']) > 0)
	{
		if (isset($_FILES['preview']) && $_FILES['preview']['size'] > 0)
			{
				$ext   = strtolower(substr($_FILES['preview']['name'], 1 + strrpos($_FILES['preview']['name'], ".")));
				$nm    = mysql_escape_string($_POST['nm']);
				$price = floatval($_POST['price']);
				if (empty($nm))
					{
						$nm = '-----';
					}
				mysql_query(
					'insert into photos (id_album, nm) values ('.intval($_SESSION['current_album']).', \''.$nm.'\')');
				$foto_folder =
					mysql_result(mysql_query(
						'select foto_folder from albums where id = '.intval($_SESSION['current_album']).'  '),
						0);
				if (mysql_errno() > 0)
					{
						die('Ошибка MySQL!');
					}
				$id_photo    = mysql_insert_id();
				$img         = 'id'.$id_photo.'.'.$ext;
				$target_name = $_SERVER['DOCUMENT_ROOT'].$foto_folder.intval($_SESSION['current_album']).'/'.$img;
				//	die ($_SERVER['DOCUMENT_ROOT'].$foto_folder.intval($_SESSION['current_album']).'/'.$img);
				if (move_uploaded_file($_FILES['preview']['tmp_name'], $target_name))
					{
						mysql_query("update photos set img = '$img', price = '$price' where id = '$id_photo'");
					}
				else
					{
						mysql_query('delete from photos where id = '.$id_photo);
						//		die('Error uploading file!');
					}

			}
	}

if (isset($_POST['go_turn']))
	{
		$id          = intval($_POST['go_turn']);
		$povorot     = intval($_POST['povorot']);
		$img_name    = mysql_result(mysql_query('select img from photos where id = '.$id), 0);
		$foto_folder =
			mysql_result(mysql_query('select foto_folder from albums where id = '.intval($_SESSION['current_album']).'  '),
				0);
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
		send_img($id, $res_foto);
		imagedestroy($result);
		imagedestroy($img);
		unlink($tmp_file);
	}



if (isset($_POST['chenge_album'])) $_SESSION['current_album'] = intval($_POST['album_id']);

$rs = mysql_query('select * from albums order by order_field asc');
if (mysql_num_rows($rs) > 0)
	{
		if (isset($_SESSION['current_album']))
			{
				$current = intval($_SESSION['current_album']);
			}
		else
			{
				$current = 0;
			}
		?>
		<div class="controls">
			<div class="input-append">
				<form action="index.php" method="post">
					<select id="appendedInputButton" class="span3" name="album_id" style="height: 28px;">
						<?
						while ($ln = mysql_fetch_assoc($rs))
							{
								?>
								<option value="<?= $ln['id'] ?>" <?=(
								$current == $ln['id'] ? 'selected="selected"' : '')?>> <?=$ln['nm']?></option>
							<?
							}
						?>
					</select> <input class="btn btn-success" type="hidden" name="chenge_album" value="1"/>
					<input class="btn  btn-success" type="submit" value="открыть" class="sub1"/>
				</form>
			</div>
		</div>
		<hr/>
	<?
	}

if (isset($_SESSION['current_album'])):

		$pg = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
		if ($pg < 1)
			{
				$pg = 1;
			}
		$start = ($pg - 1) * RECORDS_PER_PAGE;
		$rs =
			mysql_query('SELECT SQL_CALC_FOUND_ROWS * FROM photos where id_album = '.intval($_SESSION['current_album'])
				.'  order by id asc limit '.$start.', '.RECORDS_PER_PAGE);
		// $rs = mysql_query('select * from photos where id_album = '.intval($_SESSION['current_album']).' order by id asc');
		if (mysql_num_rows($rs) > 0)
			{
				$record_count = intval(mysql_result(mysql_query('select FOUND_ROWS() as cnt'), 0));
				$foto_folder  =
					mysql_result(mysql_query(
						'select foto_folder from albums where id = '.intval($_SESSION['current_album']).'  '),
						0);
				?>
				<ul class="thumbnails" style="margin-left: -15px;">
					<?
					while ($ln = mysql_fetch_assoc($rs))
						{
							?>
						<div class="ramka" style="width: 135px; height: 290px; float: left; left: 0px; margin-left: 5px; ">
							<div id="<?= 'ramka'.$ln['id'] ?>">
								<li class="span2" style="margin-left: 10px; margin-bottom: 10px;">
									<a class="thumbnail" href="<?=
									$foto_folder.$ln['id_album'].'/'.$ln['img'] ?>" style="width: 120px;">
										<div style="display: inline-block">
										<div id="<?= $ln['id'] ?>">
											<img style="width: 120px; float: left;" alt="" src="<?=
											$foto_folder.$ln['id_album'].'/'.$ln['img'] ?>?t=<?= time() ?>">
										</div>
										</div>

									</a>
									<div style="display: inline-block">
										<div style="float: left; height: 20px; width: 84px; margin-left: -2px;">
											<form action="index.php" name="go_turn" method="post" style="margin: 5px;" target="hiddenframe"
												onsubmit="document.getElementById('<?= $ln['id'] ?>').innerHTML='Подождите, идёт загрузка...'; return true;">
												<input class="btn" type="hidden" name="go_turn" value="<?= $ln['id'] ?>"/>
												<input class="btn" type="hidden" name="povorot" value="270"/>
												<input class="btn-mini btn-info" type="submit" value="^" style="float:left; width: 24px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;"/>
											</form>
											<form action="index.php" name="go_turn" method="post" style="margin: 5px;" target="hiddenframe"
												onsubmit="document.getElementById('<?= $ln['id'] ?>').innerHTML='Подождите, идёт загрузка...'; return true;">
												<input class="btn" type="hidden" name="go_turn" value="<?= $ln['id'] ?>"/>
												<input class="btn" type="hidden" name="povorot" value="180"/>
												<input class="btn-mini btn-info" type="submit" value="180" style="float:left; width: 24px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;"/>
											</form>
											<form action="index.php" name="go_turn" method="post" style="margin: 5px;" target="hiddenframe"
												onsubmit="document.getElementById('<?= $ln['id'] ?>').innerHTML='Подождите, идёт загрузка...'; return true;">
												<input class="btn" type="hidden" name="go_turn" value="<?= $ln['id'] ?>"/>
												<input class="btn" type="hidden" name="povorot" value="90"/>
												<input class="btn-mini btn-info" type="submit" value="^" style="float:left; width: 24px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;"/>
											</form>
											<iframe id="hiddenframe" name="hiddenframe" style="width:0; height:0; border:0"></iframe>
										</div>
									</div>
					<button class="btn-mini" style="position: relative; width: 46px; height: 18px; padding: 0 0 0 0; margin: 0 0 5px -2px;" onclick="
					/*return confirmDelete();*/ ajaxPostQ('/canon68452/ajax/ajaxPhoto.php','<?= '#ramka'.$ln['id'] ?>','<?= 'go_delete='.$ln['id'] ?>'); ">удалить</button>
									<div class="controls">
										<div class="input-append">
												<input class="span1" id="nm<?= $ln['id'] ?>" type="text" name="nm" value="<?= $ln['nm'] ?>"
													style="padding-top: 0; padding-bottom: 0; width: 83px; float: left;"/>
												<button class="btn-mini" style="width: 44px; height: 20px; padding-left: 0; padding-right: 0;"
					onclick="ajaxPostQ('/canon68452/ajax/ajaxPhoto.php', '', '<?= 'go_edit_name='.$ln['id'].'&nm=' ?>' + $('#nm<?= $ln['id'] ?>').val());">прим</button>
											<br style="clear: both">
												<input class="span1" id="price<?= $ln['id'] ?>" type="text" name="price" value="<?= $ln['price'] ?>"
													style="padding-top: 0; padding-bottom: 0; width: 83px;"/>
											<button class="btn-mini" style="width: 44px; height: 20px; padding-left: 0; padding-right: 0;"
					onclick="ajaxPostQ('/canon68452/ajax/ajaxPhoto.php', '', '<?= 'go_edit_price='.$ln['id'].'&price=' ?>' + $('#price<?= $ln['id'] ?>').val());">прим</button>
											<br style="clear: both">
										</div>
									</div>
								</li>
							</div>
							</div>
						<?
						}
					?>
				</ul>
				<?
				paginator($record_count, $pg);
			}
		else
			{
				?>
				В этом альбоме нет фотографий
			<?
			}
		?>
		<!--
		<hr/>
		<form action="index.php" method="post" enctype="multipart/form-data">
		<table border="0">
		  <tr>
			 <td>Превью</td>
			 <td><input type="file" name="preview" style="width: 100%;" /></td>
		  </tr>
		  <tr>
			 <td>Название</td>
			 <td><input type="text" name="nm" value="" style="width: 100%;" /></td>
		  </tr>
		  <tr>
			 <td>Цена</td>
			 <td><input type="text" name="price" value="" style="width: 100%;" /></td>
		  </tr>
		  <tr>
			 <td align="center" colspan="2">
				<input type="hidden" name="go_add" value="1" />
				<input type="submit" value="Добавить" class="sub1" />
			 </td>
		  </tr>
		</form>
		-->


	<?
endif; ?>


