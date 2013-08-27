<?php

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
				$nm    = $_POST['nm'];
				$price = floatval($_POST['price']);
				if (empty($nm))
					{
						$nm = '-----';
					}
				try {
				$id_photo    = $db->query('insert into photos (id_album, nm) values (?i,?string)', array($_SESSION['current_album'],$nm), 'id');
				$foto_folder = $db->query('select foto_folder from albums where id = ?i',array($_SESSION['current_album']).'el');
				} catch (go\DB\Exceptions\Query $e) {
					echo 'SQL-query: '.$e->getQuery()."\n";
					echo 'Error description: '.$e->getError()."\n";
					echo 'Error code: '.$e->getErrorCode()."\n";
					die('Ошибка MySQL!');
				}
				$img         = 'id'.$id_photo.'.'.$ext;
				$target_name = $_SERVER['DOCUMENT_ROOT'].$foto_folder.intval($_SESSION['current_album']).'/'.$img;

				if (move_uploaded_file($_FILES['preview']['tmp_name'], $target_name))
					{
						$db->query('update photos set img = ?string, price = ?scalar where id = ?i',array($img,$price,$id_photo));
					}
				else
					{
						$db->query('delete from photos where id = ?i', array($id_photo));
						die('Error uploading file!');
					}

			}
	}


if (isset($_POST['chenge_album'])) $_SESSION['current_album'] = intval($_POST['album_id']);

$rs = $db->query('select * from albums order by order_field asc', null, 'assoc:order_field');
if ($rs)
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
					<select id="appendedInputButton" class="span3" name="album_id" style="height: 28px; float: left;">
						<?
							foreach ($rs as $ln)
							{
								?>
								<option value="<?= $ln['id'] ?>" <?=($current == $ln['id'] ? 'selected="selected"' : '')?>> <?=$ln['nm']?></option>
							   <?
							}
						?>
					</select><label for="appendedInputButton">
				   </label><input class="btn btn-success" type="hidden" name="chenge_album" value="1"/>
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
		$rs = $db->query('SELECT SQL_CALC_FOUND_ROWS * FROM photos where `id_album` = ?i order by `id` asc limit ?i, ?i',
			              array(($_SESSION['current_album']),$start,RECORDS_PER_PAGE), 'assoc');
		// $rs = mysql_query('select * from photos where id_album = '.intval($_SESSION['current_album']).' order by id asc');
		if ($rs)
			{
				$record_count = intval($db->query('select FOUND_ROWS() as cnt', null, 'el'));
				$foto_folder  = $db->query('select foto_folder from albums where id = ?i',array($_SESSION['current_album']),'el');
				?>
				<ul class="thumbnails" style="margin-left: -15px;">
					<?
						foreach ($rs as $ln)
						{
							?>
						<div class="ramka" style="width: 135px; height: 290px; float: left; left: 0px; margin-left: 5px; ">
							<div id="<?= 'ramka'.$ln['id'] ?>">
								<li class="span2" style="margin-left: 10px; margin-bottom: 10px;">
									<a class="thumbnail" href="<?=
									$foto_folder.$ln['id_album'].'/'.$ln['img'] ?>" style="width: 120px;">
										<div style="display: inline-block">
										<div id="<?= $ln['id'] ?>">
											<img style="width: 120px; float: left;" alt="" src="<?=$foto_folder.$ln['id_album'].'/'.$ln['img'] ?>?t=<?= time() ?>">
										</div>
										</div>
									</a>


								  <div style="display: inline-block">
									 <div style="float: left; height: 20px; width: 84px; margin-left: -2px;">




										<button class="btn-mini btn-info" style="float:left; width: 24px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 10px;"
										 onclick="ajaxPostQ('/canon68452/imageRotate.php', '<?= '#'.$ln['id'] ?>', '<?= 'go_turn='.$ln['id']. '&povorot='.'270' ?>');">^
										</button>


										  <button class="btn-mini btn-info" style="float:left; width: 24px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;"
											onclick="ajaxPostQ('/canon68452/imageRotate.php', '<?= '#'.$ln['id'] ?>', '<?= 'go_turn='.$ln['id']. '&povorot='.'180' ?>');">180
										  </button>

										<button class="btn-mini btn-info" style="float:left; width: 24px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;"
										 onclick="ajaxPostQ('/canon68452/imageRotate.php', '<?= '#'.$ln['id'] ?>', '<?= 'go_turn='.$ln['id']. '&povorot='.'90' ?>');">^
										</button>



									 </div>
								  </div>


					<button class="btn-mini" style="position: relative; width: 46px; height: 18px; padding: 0 0 0 0; margin: -15px 0 0 -2px;" onclick="
					/*return confirmDelete();*/ ajaxPostQ('/canon68452/ajax/ajaxPhoto.php','<?= '#ramka'.$ln['id'] ?>','<?= 'go_delete='.$ln['id'] ?>'); ">удалить</button>
									<div class="controls">
										<div class="input-append">
												<input class="span1" id="nm<?= $ln['id'] ?>" type="text" name="nm" value="<?= $ln['nm'] ?>"
													style="padding-top: 0; padding-bottom: 0; width: 83px; float: left;"/>
												<button class="btn-mini" style="width: 44px; height: 20px; padding-left: 0; padding-right: 0;"
					onclick="ajaxPostQ('/canon68452/ajax/ajaxPhoto.php', '', '<?= 'go_edit_name='.$ln['id'].'&nm=' ?>' + $('<?='#nm'.$ln['id'] ?>').val());">прим</button>
											<br style="clear: both">
												<input class="span1" id="price<?= $ln['id'] ?>" type="text" name="price" value="<?= $ln['price'] ?>"
													style="padding-top: 0; padding-bottom: 0; width: 83px;"/>
											<button class="btn-mini" style="width: 44px; height: 20px; padding-left: 0; padding-right: 0;"
					onclick="ajaxPostQ('/canon68452/ajax/ajaxPhoto.php', '', '<?= 'go_edit_price='.$ln['id'].'&price=' ?>' + $('<?='#price'.$ln['id'] ?>').val());">прим</button>
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
<?endif;?>
