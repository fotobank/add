<?php
if (!isset($_SESSION['admin_logged']))
	{
		die();
	}
include (dirname(__FILE__).'/../inc/i_resize.php');

/*
	Todo    - сканирование FTP папок
   @author - Jurii
	@date   - 20.04.13
	@time   - 10:44
 */
?>
<script type="text/javascript">
	$(function () {
		sendFtp();
	});
</script>

<?


// Функция, подсчитывающая количество файлов $dir
function get_ftp_size($ftp_handle, $dir, $global_size = 0)
	{

		$file_list = ftp_rawlist($ftp_handle, $dir);
		if (!empty($file_list))
			{
				foreach ($file_list as $file)
					{
						// Разбиваем строку по пробельным символам
						list($acc, $bloks, $group, $user, $size, $month, $day, $year, $file) = preg_split("/[\s]+/", $file);
						// Если перед нами файл, подсчитываем его
						$global_size++;
					}
			}

		return $global_size;
	}

function hardFlush($proc, $id, $remote_file)
	{

		echo '<script type="text/javascript">';
		echo'window.parent.document.getElementById("'.$id
			.'bar").innerHTML="<div class=\'progress progress-danger\'><div class=\'bar\' style=\'width: '.$proc.'%;\'>'
			.$proc.'%</div></div>";';
		echo 'window.parent.document.getElementById("'.$id.'").innerHTML="файл: '.$remote_file.'";';
		echo '</script>';
		flush();
		ob_flush();
	}

function sendtext($out, $id, $bar)
	{

		echo '<script type="text/javascript">';
		echo 'window.parent.document.getElementById("'.$id.$bar.'").innerHTML="'.$out.'";';
		echo '</script>';
	}

function senderror($out, $id, $err)
	{

		echo '<script type="text/javascript">';
		echo 'window.parent.document.getElementById("'.$id.'err").innerHTML="'.$out.'";';
		echo '</script>';
	}

// Функция для отбрасывания каталогов и ненужных расширений:
function ftp_is_dir($folder)
	{

		$file_parts = explode('.', $folder); //разделить имя файла и поместить его в массив
		$ext        = strtolower(array_pop($file_parts)); //последний элеменет - это расширение
		if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif')
			{
				return 'true';
			}
		else
			{
				return 'false';
			}
	}



if (isset($_POST['go_add']))
	{
		if (isset($_FILES['preview']) && $_FILES['preview']['size'] != 0)
			{
				if ($_FILES['preview']['size'] < 1024 * 15 * 1024)
					{
						$ext         =
							strtolower(substr($_FILES['preview']['name'], 1 + strrpos($_FILES['preview']['name'], ".")));
						$nm          = $_POST['nm'];
						$descr       = $_POST['descr'];
						$foto_folder = $_POST['foto_folder'];
						$id_category = $_POST['id_category'];
						if (empty($nm))
							{
								$nm = 'Без имени';
							}
						try
							{
								$id_album = $db->query('insert into `albums` (nm) VALUES (?string)', array($nm), 'id');
							}
						catch (go\DB\Exceptions\Exception $e)
							{
								die('Ошибка при работе с базой данных');
							}
						$db->query('insert into `accordions` (id_album,collapse_numer,collapse_nm,accordion_nm) VALUES (?scalar,?i,?string,?string)',
							array($id_album,'1','default','default'));
						$img         = 'id'.$id_album.'.'.$ext;
						$target_name = $_SERVER['DOCUMENT_ROOT'].'/images/'.$img;
						$file_load   = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$img;
						if (move_uploaded_file($_FILES['preview']['tmp_name'], $file_load))
							{
								$sharping  = 1;
								$watermark = 0;
								$ip_marker = 0;
								if (imageresize($target_name, $file_load, 200, 200, 75, $watermark, $ip_marker, $sharping)
									== 'true'
								)
									{
										$db->query('update albums set id_category = ?i, img = ?, order_field = ?i, descr = ?, foto_folder = ? where id = ?i',
											array($id_category, $img, $id_album, $descr, $foto_folder, $id_album));
										mkdir('../'.$foto_folder.$id_album, 0777, true) or die($php_errormsg);
										unlink($file_load);
										$_SESSION['current_album'] = $id_album;
										$_SESSION['current_cat']   = $id_category;
									}
								else
									{
										$db->query('delete from albums where id ?i', array($id_album));
										unlink($file_load);
										die('Для обработки принимаются только JPG, PNG или GIF имеющие размер не более 15Mb.');
									}
							}
						else
							{
								$db->query('delete from albums where id ?i', array($id_album));
								unlink($file_load);
								die('Не могу загрузить файл в папку "tmp"');

							}
					}
				else
					{
						unlink($file_load);
						die('Размер файла превышает 15 мегабайт');
					}
			}
		//   else
		// {
		//         die('Битый файл!');
		//		unlink($file_load);
		// }
	}



/*
Todo    - go_edit_name
 */
if (isset($_POST['go_edit_name']))
	{
		$id = $_POST['go_edit_name'];
		$nm = $_POST['nm'];
		if (empty($nm))
			{
				$nm = '-----';
			}
		$db->query('update albums set nm = ? where id = ?i', array($nm, $id));
	}




if (isset($_POST['go_edit_descr']))
	{
		$id    = $_POST['go_edit_descr'];
		$descr = $_POST['descr'];
		$db->query('update albums set descr = ? where id = ?i', array($descr, $id));
	}




if (isset($_POST['go_edit_nastr']))
	{
		$watermark    = isset($_REQUEST['watermark']);
		$ip_marker    = isset($_REQUEST['ip_marker']);
		$sharping     = isset($_REQUEST['sharping']);
		$quality      = $_POST['quality'];
		$id           = $_POST['go_edit_nastr'];
		$price        = $_POST['price'];
		$id_category  = $_POST['id_category'];
		$pass         = $_POST['pass'];
		$ftp_folder   = $_POST['ftp_folder'];
		$foto_folder  = $_POST['foto_folder'];
		$vote_price   = $_POST['vote_price'];
		$vote_time    = $_POST['vote_time'];
		$vote_time_on = isset($_REQUEST['vote_time_on']);
		$db->query('update albums set
		price = ?f,
		id_category = ?i,
		pass = ?string,
		quality = ?i,
		ftp_folder = ?string,
		foto_folder = ?string,
		watermark = ?b,
		ip_marker = ?b,
		sharping = ?b,
		vote_price = ?f,
		vote_time = ?i,
		vote_time_on = ?b  where
		id = ?i',
			array($price,
			      $id_category,
			      $pass,
			      $quality,
			      $ftp_folder,
			      $foto_folder,
			      $watermark,
			      $ip_marker,
			      $sharping,
			      $vote_price,
			      $vote_time,
			      $vote_time_on,
			      $id));
		$db->query('update photos set price = ?f where id_album = ?i', array($price, $id));
		$_SESSION['current_album'] = $id;
		$_SESSION['current_cat']   = $id_category;
	}



/*
  Todo    go_ftp_upload
  @author - Jurii
  @date   - 14.04.13
  @time   - 14:29
*/
if (isset($_POST['go_ftp_upload']))
	{
		//600x450
		$id         = $_POST['go_ftp_upload'];
		$album_data = $db->query('select * from albums where id = ?i', array($id), 'row');
		if ($album_data)
			{
				//Выбираем данные по альбому и настройки FTP-сервера
				$ftp_host = get_param('ftp_host');
				$ftp_user = get_param('ftp_user');
				$ftp_pass = get_param('ftp_pass');
				// mysql_set_charset("utf8");
				if ($ftp_host && $ftp_user && $ftp_pass)
					{
						//Если в хосте присутствует порт - выделим его
						if (strstr($ftp_host, ':'))
							{
								$ftp_port = substr($ftp_host, strpos($ftp_host, ':') + 1);
								$ftp_host = substr($ftp_host, 0, strpos($ftp_host, ':'));
							}
						else
							{
								$ftp_port = 21;
							}
						//Соединяемся
						$ftp = ftp_connect($ftp_host, $ftp_port);
						if (!$ftp)
							{
								$out = "<div class='alert alert-error'>Неверный адрес или порт ftp сервера!'<br></div>";
								senderror($out, $id, '');
								die('Неверный адрес или порт ftp сервера!');
							}
						//Логинимся
						if (!ftp_login($ftp, $ftp_user, $ftp_pass))
							{
								ftp_close($ftp);
								$out = "<div class='alert alert-error'>Неверный логин или пароль для FTP сервера!<br></div>";
								senderror($out, $id, '');
								die('Неверный логин или пароль для FTP сервера!');
							}
						ftp_pasv($ftp, true);
						if (ftp_chdir($ftp, $album_data['ftp_folder']))
							{
								ftp_chdir($ftp, $album_data['ftp_folder']);
							}
						//Получаем список файлов в папке
						$file_list    = ftp_nlist($ftp, $album_data['ftp_folder']);
						$fileListSort = array_multisort($file_list);
						//var_dump($file_list);
						//echo 'Ответ ftp: <br><pre>', print_r($file_list,1), '</pre>';
						if ($fileListSort == false)
							{
								ftp_close($ftp);
								$out =
									"<div class='alert alert-error'>Папка: $album_data[ftp_folder] заданна не верно!<br>Проверьте путь!</div>";
								senderror($out, $id, '');
								die ('Директория  '.$album_data['ftp_folder'].' не существует! <br>');
							}
						//var_dump($file_list);
						//echo 'Ответ ftp: <br><pre>', print_r($file_list,1), '</pre>';
						// Файл существует на самом деле? Пустой список файлов с FTP!
						if (!count($file_list))
							// if ( !count($file_list) || ftp_size( $ftp, $file_list[0] ) == -1 )
							{
								$out =
									"<div class='alert alert-error'>Заданная на FTP папка : $album_data[ftp_folder] не содержит изображений!</div>";
								senderror($out, $id, '');
								echo 'Список доступных файлов пустой!';
								echo '<br> ответ FTP - File List: <br><pre>', print_r($file_list, 1), '</pre>';
								ftp_close($ftp);
								die('Или заданная на FTP папка : " '.$album_data['ftp_folder'].' " - пустая!');
							}
						$local_dir = $_SERVER['DOCUMENT_ROOT'].'/tmp/';
						// количество файлов в папке
						$pload = 100 / (get_ftp_size($ftp, $album_data['ftp_folder']));
						$proc  = 0;
						$all   = 0;
						ob_start();
						//Перебираем файлы, закачиваем и обрабатываем по одному
						foreach ($file_list as $remote_file)
							{
								//Имя
								$remote_file_old = $remote_file;
								$remote_file     = iconv('utf-8', 'cp1251', $remote_file);
								//var_dump($remote_file);
								// шкала
								$proc = $proc + $pload;
								hardFlush((int)$proc, $id, basename($remote_file));
								$f_name = substr($remote_file, strrpos($remote_file, '/') + 1);
								if (ftp_is_dir($f_name) == 'true') // проверка на расширение и на каталог:
									{
										//Локальный файл
										$local_file = $local_dir.$f_name;
										//Фаил на FTP
										//$remote_file = $album_data['ftp_folder'].$remote_file;
										//var_dump($ftp,$f_name);
										if (!ftp_get($ftp, $local_file, $remote_file_old, FTP_BINARY))
											{
												ftp_close($ftp);
												$out =
													"<div class='alert alert-error'>Не могу загрузить файл: $remote_file -> $local_file  </div> ";
												senderror($out, $id, '');
												die('Не могу загрузить файл: '.$remote_file.' -> '.$local_file);
											}
										//Создаем запись в БД
										$nm           = substr($f_name, 0, strrpos($f_name, '.'));
										$id_photo     = $db->query('insert into photos (id_album, nm) values (?i,?string)',
											array($album_data['id'], $nm),
											'id');
										$tmp_name     = 'id'.$id_photo.'.jpg';
										$foto_folder  = $album_data['foto_folder'];
										$album_folder = $album_data['id'];
										//$watermark = $album_data['watermark'];
										$watermark = 0;
										//$ip_marker = $album_data['ip_marker'];
										$ip_marker   = 0;
										$sharping    = $album_data['sharping'];
										$target_name = $_SERVER['DOCUMENT_ROOT'].$foto_folder.$album_folder.'/'.$tmp_name;
										$quality     = $album_data['quality'];
										if (imageresize($target_name,
											$local_file,
											600,
											450,
											$quality,
											$watermark,
											$ip_marker,
											$sharping) == 'true'
										)
											{
												unlink($local_file);
												$db->query("update photos set img = ?string, price = ?scalar, ftp_path = ?string where id = ?i",
													array($tmp_name, $album_data['price'], $remote_file, $id_photo));
											}
										else
											{
												unlink($local_file);
												$db->query('delete from photos where id = ?i', array($id_photo));
												echo ('Файл на FTP'.$remote_file.' - битый!'); ?><br><?php;
												$all--;
											}
									}
								else
									{
										echo ($remote_file.'  - это папка или неподдерживаемый файл!');
										$out =
											"<div class='alert alert-error'>$remote_file - это папка или неподдерживаемый файл!<br></div>";
										senderror($out, $id, '');
										@unlink($local_file);
										$all--;
									}
								//   }
								$all++;
							}
						ftp_close($ftp);
						$out = "<div class='alert alert-info'>Загруженно $all фотографий.</div>";
						sendtext($out, $id, '');
						$out = '';
						sendtext($out, $id, 'bar');
					}
			}
	}

if (isset($_POST['go_updown']))
	{
		$swap_id       = 0;
		$swap_order    = 0;
		$id            = $_POST['go_updown'];
		$current_order = $db->query('select order_field from albums where id = ?i', array($id), 'el');
		if ($current_order)
			{
				if (isset($_POST['up']))
					{
						$rs =
							$db->query('select id, order_field from albums where order_field < ?i order by order_field desc limit 0, 1',
								array($current_order),
								'row');
					}
				else
					{
						$rs =
							$db->query('select id, order_field from albums where order_field > ?i order by order_field asc limit 0, 1',
								array($current_order),
								'row');
					}
				if ($rs)
					{
						$swap_id    = intval($rs['id']);
						$swap_order = intval($rs['order_field']);
					}
			}
		if ($current_order > 0 && $swap_id > 0)
			{
				$db->query('update albums set order_field = ?i where id = ?i', array($current_order, $swap_id));
				$db->query('update albums set order_field = ?i where id = ?i', array($swap_order, $id));
			}
	}


?>
<div id="long" class="modal hide fade in animated fadeInDown" tabindex="-1" data-replace="true" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="false">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3>Создать альбом:</h3>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="span5 offset0">
				<form action="index.php" method="post" enctype="multipart/form-data">
					<table border="0">
						<tr>
							<td><strong>Превью:</strong></td>
							<td>
								<div class="controls">
									<div class="input-append">
										<input id="appendedInputButton" class="span3" type="file" name="preview" style="width: 303px;"/>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td><strong>Название:</strong></td>
							<td><label> <input type="text" name="nm" value="" style="width: 203px; margin-bottom: 0;"/>
								</label></td>
						</tr>
						<tr>
							<td><strong>Категория:</strong></td>
							<td>
								<div>
									<label for="prependedInput"></label><select id="prependedInput" class="span2" name="id_category" style="margin-bottom: 0; width: 207px;">
										<?
										$tmp = $db->query('select * from `categories` order by id asc')->assoc();
										foreach ($tmp as $tmp2)
											{
												?>
												<option value="<?= $tmp2['id'] ?>"
													<?
													if (!isset($_SESSION['id_category']))
														{
															$_SESSION['id_category'] = 1;
														}
													else
														{
															if ($tmp2['id'] == $_SESSION['id_category'] ? 'selected="selected"' : 'el')
																{
																	;
																}
														}
													?>><?=$tmp2['nm']?></option>
											<?
											}
										?>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td><strong>Папка фотобанка:</strong></td>

							<td>
								<label>
									<input type="text" name="foto_folder" value="/images2/" style="width: 203px; margin-top: 5px;"/>
								</label>
							</td>
						</tr>

						<tr>
							<td><strong>Описание:</strong></td>
							<td><label> <textarea style="width: 400px; height: 100px;" name="descr"></textarea> </label></td>
						</tr>
						<tr>
							<td align="center" colspan="2">
								<input class="btn  btn-success" type="hidden" name="go_add" value="1"/>
								<input class="btn  btn-success" type="submit" value="Добавить"/>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn">Close</button>
	</div>
</div>
<div class="offset2" style="float:left">
	<button class="btn btn-primary btn-large" href="#long" data-toggle="modal">Создать альбом</button>
</div>

<div class="row">
	<div class="span5 offset2">
		<p>1. Водяной знак для фотобанка и IP надпись формируется на сервере в момент <b>просмотра.</b></p>

		<p>2. Чекбос "резкость" добавляет шарпинг <b>при закачке</b> с FTP.</p>

		<p>3.Для папок <b>/два слэша/</b> обязательны.</p>

		<p>4.Перед изменением <b>папки в фотобанке</b> для закаченного альбома необходимо сначала создать папку на
			сервере! </p>
	</div>
</div><?


if (isset($_POST['go_delete']))
	{
		$id           = $_POST['go_delete'];
		$album_folder = $id;
		$foto_folder  = $db->query('select foto_folder from albums where id = ?i', array($id), 'el');
		echo "<script type='text/javascript'>
                             $(document).ready(function load() {
                             $('#static').modal('show');
                             });
                             </script>";

		?>
		<div id="static" class="modal hide fade in animated fadeInDown" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="false">
			<div class="modal-header">
				<h3 style="color:red">Внимание! Удаление альбома!</h3>
			</div>
			<div class="modal-body">
				Удалить каталог: "<?=($_SERVER['DOCUMENT_ROOT'].$foto_folder.$album_folder)?>" ?
			</div>
			<div class="modal-footer">
				<form action="/inc/delete_dir.php" method="post">
					<input type="hidden" name="confirm_id" value=<?=$id?>/>
					<button type="submit" name="confirm_del" value=<?= (
						$_SERVER['DOCUMENT_ROOT'].$foto_folder.$album_folder) ?>> ДА
					</button>
					<button id="noConfirm" type="submit" name="confirm_del" value="0"> НЕТ</button>
				</form>
			</div>
		</div>
	<?
	}


if (isset($_SESSION['ok_msg']) && $_SESSION['ok_msg'] != "")
	{
		echo  $_SESSION['ok_msg'];
		$_SESSION['ok_msg'] = "";
	}


if (isset($_POST['chenge_cat']))
	{
		$_SESSION['current_cat'] = intval($_POST['id']);
	}
$rs_cat = $db->query('select DISTINCT c.nm, c.id
  		      from categories c, albums a
  		    	where  c.id = a.id_category
  		      order by a.order_field asc')->assoc();
if ($rs_cat)
	{
		if (isset($_SESSION['current_cat']))
			{
				$current_c = intval($_SESSION['current_cat']);
			}
		else
			{
				$current_c = 0;
			}

		?>
		<hr/>
		<div><h3>Редактор альбомов:</h3>
		</div>
		<div><strong>Выбрать категорию:</strong> <strong style="margin-left: 300px;">Выбрать альбом:</strong>
		</div>
		<div class="controls" style="float:left;">
			<div class="input-append">
				<form id="myForm1" action="index.php" method="post">
					<select id="appendedInputButton" class="span3" name="id" style="height: 28px;">
						<?
						//						while ($ln_cat = mysql_fetch_assoc($rs_cat))
						foreach ($rs_cat as $ln_cat)
							{
								?>
								<option value="<?= $ln_cat['id'] ?>" <?=(
								$current_c == $ln_cat['id'] ? 'selected="selected"' : '')?>> <?=$ln_cat['nm']?></option>
							<?
							}
						?>
					</select> <input class="btn btn-success" type="hidden" name="chenge_cat" value="1"/>
					<input class="btn btn-success" type="submit" value="открыть"/>
				</form>
			</div>
		</div>

	<?
	}

if (isset($_POST['chenge_album']))
	{
		$_SESSION['current_album'] = intval($_POST['id']);
	}

if (isset($_SESSION['current_cat']))
	{
		$rs = $db->query('select c.nm, a.*
  		      from categories c, albums a
  		      where  c.id = a.id_category
  		      and  a.id_category = '.intval($_SESSION['current_cat']).'
  		      order by a.order_field asc')->assoc();
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
						<form id="myForm2" action="index.php" method="post">
							<select id="appendedInputButton" class="span3" style=" margin-left: 100px; height: 28px;" name="id">
								<?
								foreach ($rs as $ln)
									{
										?>
										<option value="<?= $ln['id'] ?>" <?=(
										$current == $ln['id'] ? 'selected="selected"' : '')?>> <?=$ln['nm']?></option>
									<?
									}
								?>
							</select> <input class="btn btn-success" type="hidden" name="chenge_album" value="1"/>
							<input class="btn  btn-success" type="submit" value="открыть"/>
						</form>
					</div>
				</div>

				<?
				if (isset($_SESSION['current_album'])):
						$rs = $db->query('select * from albums where id = ?i', array($_SESSION['current_album']), 'assoc');
						if ($rs)
							{
								foreach ($rs as $ln)
									{
										$_SESSION['id_category'] = $ln['id_category'];
										?>
										<div style="border-bottom: 0 none;">
										<table border="0">
										<tr>
										<td valign="top">
										<table border="2">
										<tr>
											<td align="center" style="height: 120px;">
												<img src="/images/<?= $ln['img'] ?>" alt="-" width="100px" height="100px"/>

												<div class="controls">
													<div class="input-append">
														<form action="index.php" method="post">
															<label for="appendedInputButton"></label>
															<input id="appendedInputButton" type="text" name="nm" value="<?= $ln['nm'] ?>" style="height: 22px; margin-top: 20px;"/>
															<input class="btn btn-primary" type="hidden" name="go_edit_name" value="<?= $ln['id'] ?>"/>
															<input class="btn btn-primary" type="submit" value="переименовать" style="margin-top: 20px;"/>
														</form>
													</div>
												</div>
											</td>
											<td rowspan="3" align="center">
												<form action="index.php" method="post" style="margin: 0 0 -20px 0;">
													<label>
														<textarea rows="12" cols="35" name="descr" style="width: 346px; height: 210px;">
															<?=$ln['descr']?>
														</textarea> </label><br/>
													<input class="btn btn-primary" type="hidden" name="go_edit_descr" value="<?= $ln['id'] ?>"/>
													<input class="btn-small btn-primary" type="submit" value="сохранить" style="margin-bottom: 10px;">
												</form>
											</td>
											<td rowspan="3">
												<table border="0">
													<tr>
														<td>
															<form action="index.php" method="post" style="margin: 5px;">
																<table border="0">
																	<tr>
																		<td>
																			<div class="input-prepend">
																				<label for="price" class="add-on">Цена за фото (гр.):&nbsp;&nbsp;&nbsp;</label>
																				<input id="price" class="span2" type="text" NAME="price" VALUE="<?= $ln['price'] ?>"/>
																			</div>
																		</td>
																		<td>
																			<div class="slideThree">
																				<input id="slideThree1" type='checkbox' NAME='watermark' VALUE='yes'
																					<?if ($ln['watermark'])
																					{
																						echo 'checked="checked"';
																					} ?> /> <label for="slideThree1"></label>
																			</div>
																			Водяной знак
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<div class="input-prepend">
																				<label for="quality" class="add-on">Качество .jpg (%):&nbsp;&nbsp;&nbsp;&nbsp;</label>
																				<input id="quality" class="span2" type="text" NAME="quality" VALUE="<?= $ln['quality'] ?>"/>
																			</div>
																		</td>
																		<td>
																			<div class="slideThree">
																				<input id="slideThree2" type='checkbox' NAME='ip_marker' VALUE='yes' <?if ($ln['ip_marker'])
																					{
																						echo 'checked="checked"';
																					}?> /> <label for="slideThree2"></label>
																			</div>
																			IP надпись
																		</td>
																	</tr>
																	<tr>
																		<td colspan="2">
																			<div class="input-prepend">
																				<label for="id_category" class="add-on">Категория: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
																				<select id="id_category" class="span3" name="id_category">
																					<?
																					$tmp =
																						$db->query('select * from `categories` order by id asc',
																							NULL,
																							'assoc');
																					foreach ($tmp as $tmp2)
																						{
																							?>
																							<option value="<?= $tmp2['id'] ?>" <?=($tmp2['id']
																								== $ln['id_category'] ? 'selected="selected"' : '')?>><?=$tmp2['nm']?></option>
																						<?
																						}
																					?>
																				</select>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<div class="input-prepend">
																				<label for="pass" class="add-on">Пароль на альбом:&nbsp;&nbsp;&nbsp;&nbsp;</label>
																				<input id="pass" class="span2" type="text" NAME="pass" VALUE="<?= $ln['pass'] ?>"/>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td>
																			<div class="input-prepend">
																				<label for="foto_folder" class="add-on">Папка фотобанка:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
																				<input id="foto_folder" class="span2" type="text" NAME="foto_folder" VALUE="<?= $ln['foto_folder'] ?>"/>
																			</div>
																		</td>
																		<td>
																			<div class="slideThree">
																				<input id="slideThree3" type='checkbox' NAME='sharping' VALUE='yes' <?if ($ln['sharping'])
																					{
																						echo 'checked="checked"';
																					}?> /> <label for="slideThree3"></label>
																			</div>
																			Добавить резкость
																		</td>
																	</tr>


																	<tr>
																		<td>
																			<div class="input-prepend">
																				<label for="foto_folder" class="add-on">Цена голоса (грн.):&nbsp;&nbsp;</label>
																				<input id="foto_folder" class="span2" type="text" NAME="vote_price" VALUE="<?= $ln['vote_price'] ?>"/>
																			</div>
																		</td>
																	</tr>

																	<tr>
																		<td>
																			<div class="input-prepend">
																				<label for="foto_folder" class="add-on">t голосования
																					(мин):</label>
																				<input id="foto_folder" class="span2" type="text" NAME=" vote_time" VALUE="<?= $ln['vote_time'] ?>"/>
																			</div>
																		</td>
																		<td>
																			<div class="slideThree">
																				<input id="slideThree4" type='checkbox' NAME='vote_time_on' VALUE='yes' <?if ($ln['vote_time_on'])
																					{
																						echo 'checked="checked"';
																					}?> /> <label for="slideThree4"></label>
																			</div>
																			Голосование по времени
																		</td>
																	</tr>

																	<tr>
																		<td colspan="2">
																			<input id="ftpFold" type="hidden" name="ftpFold" value="<?= $ln['ftp_folder'] ?>"/>

																			<div class="input-prepend">
																				<label id='refresh' title='Обновить папки' for="upFTP" class="add-on" onclick='sendFtp();'>
																					Папка uploada FTP:&nbsp;</label>
																				<select id="upFTP" class="span3" NAME="ftp_folder">
																					<option value="<?= $ln['ftp_folder'] ?>"><?= $ln['ftp_folder'] ?></option>
																				</select>
																			</div>
																		</td>
																	</tr>
																	<tr>
																		<td colspan="2" align="center">
																			<input class="btn btn-primary" type="hidden" name="go_edit_nastr" value="<?= $ln['id'] ?>"/>
																			<input class="btn-small btn-primary" type="submit" value="сохранить"/>
																		</td>
																	</tr>
																</table>
															</form>
														</td>
													</tr>
													<tr>
														<td align="center">
															<form action="index.php" name="go_ftp_upload" method="post" style="margin-bottom: 0;" target="hiddenframe" onsubmit="document.getElementById('<?= $ln['id'] ?>').innerHTML='Подождите, идёт загрузка...'; return true;">
																<input class="btn btn-success" type="hidden" name="go_ftp_upload" value="<?= $ln['id'] ?>"/>

																<div id="<?= $ln['id'] ?>"></div>
																<div id="<?= $ln['id'] ?>bar"></div>
																<div id="<?= $ln['id'] ?>err"></div>
																<input class="btn-small btn-success" type="submit" value="Добавить с FTP"/><br/>
															</form>
														</td>
														<td>
															<iframe id="hiddenframe" name="hiddenframe" style="width:0; height:0; border:0"></iframe>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align="center" style="margin: 10px;">Папка альбома:
												"..<?=$ln['foto_folder']?><?=$ln['id']?>"
												<form action="index.php" method="post" style="margin: 10px;">
													<input class="btn btn-primary" type="hidden" name="go_delete" value="<?= $ln['id'] ?>"/>
													<input class="btn-small btn-danger dropdown-toggle" type="submit" value="удалить  альбом"/>
												</form>
											</td>
										</tr>
										<tr>
											<td align="center" style="height: 30px;">
												<form action="index.php" method="post" style="margin: 0;">
													<div class="btn-toolbar">
														<div class="btn-group">
															<input type="hidden" name="go_updown" value="<?= $ln['id'] ?>"/>
															<input class="btn-small btn-info" type="submit" name="up" value="поднять"/>
															<input class="btn-small btn-info" type="submit" name="down" value="опустить"/>
														</div>
													</div>
												</form>
											</td>
										</tr>
										</table>
										</td>
										</tr>
										</table>
										</div>
									<?
									}
							}
				endif;
			}
	}

/**
 * аккордеон
 */
if (isset($_POST['add_par']))
	{
		$ac_nm     = $_POST['add_par'];
		$coll_name = $_POST['nm'];
		$id_album  = $_POST['id_album'];
		$coll_num  =
			($db->query('select collapse_numer from accordions where id_album = ?i order by collapse_numer desc limit 1',
				array($id_album),
				'el')) + 1;
		$db->query('insert into accordions (accordion_nm,collapse_nm,id_album,collapse_numer) values (?string,?string,?i,?i)',
			array($ac_nm, $coll_name, $id_album, $coll_num));

	}

if (isset($_POST['go_del']))
	{
		$id_album = $_POST['go_del'];
		$coll_num = $_POST['collapse_numer'];
		$db->query('delete from accordions where `id_album` =?i and `collapse_numer` = ?i', array($id_album, $coll_num));
	}

if (isset($_POST['go_update']))
	{
		$id             = $_POST['go_update'];
		$collapse_numer = $_POST['collapse_numer'];
		$txt            = iconv('utf-8', 'cp1251', trim($_POST['txt_coll']));
		$id_album       = $_POST['go_update'];
		$db->query("update accordions set collapse = ?string where id_album = ?i and collapse_numer =?i ",
			array($txt, $id_album, $collapse_numer));
	}

if (isset($_POST['go_edit_nm']))
	{
		$id = $_POST['go_edit_nm'];
		$nm = $_POST['nm'];
		$db->query('update accordions set accordion_nm =? where id_album = ?i', array($nm, $id));
	}

if (isset($_POST['go_edit_name_coll']))
	{
		$id  = $_POST['go_edit_name_coll'];
		$nm  = $_POST['nm'];
		$num = $_POST['collapse_numer'];
		$db->query('update accordions set collapse_nm =? where id_album = ?i and collapse_numer =?i',
			array($nm, $id, $num));
	}

if (isset($_POST['go_up_down']))
	{
		$id_album = $_POST['go_up_down'];
		$id_cat   = $_POST['coll_num'];
		if ($id_cat > 0)
			{
				if (isset($_POST['up']))
					{
						$swap_id =
							$db->query('select collapse_numer from accordions where id_album =?i and collapse_numer < ?i order by collapse_numer desc limit 0, 1',
								array($id_album, $id_cat),
								'el');
					}
				else
					{
						$swap_id =
							$db->query('select collapse_numer from accordions where id_album =?i and collapse_numer > ?i order by collapse_numer asc limit 0, 1',
								array($id_album, $id_cat),
								'el');
					}
			}
		if ($id_cat > 0 && isset($swap_id) && $swap_id > 0)
			{
				$db->query('update accordions set collapse_numer = 0 where id_album =?i and  collapse_numer = ?i',
					array($id_album, $swap_id));
				$db->query('update accordions set collapse_numer = ?i where id_album =?i and  collapse_numer = ?i',
					array($swap_id, $id_album, $id_cat));
				$db->query('update accordions set collapse_numer = ?i where id_album =?i and  collapse_numer = 0',
					array($id_cat, $id_album));
				$_SESSION['current_kont'] = $swap_id;
			}
	}
?>
<hr/><h3>Аккордеон:</h3>
<?

if (isset($_POST['collapse_nm']))
	{
		$data                       = explode('][', $_POST['collapse_nm']);
		$_SESSION['collapse_numer'] = intval($data[0]);
		$_SESSION['alb_num']        = intval($data[1]);
	}

if (isset($_SESSION['current_album']))
	{
		$rs = $db->query('select * from accordions where id_album = ?i or id_album = ?i order by id_album asc',
				array($_SESSION['current_album'], '1'), 'assoc');
		if ($rs)
			{

			$acc_nm = $db->query('select accordion_nm from accordions where id_album = ?i',
				array(isset($_SESSION['alb_num']) ? $_SESSION['alb_num'] : $_SESSION['current_album']), 'el');
				?>
				<div><strong>Изменить заголовок:</strong> (Если названия нет - аккордеон выключен) <strong>Название
						параграфа: </strong> (если 'default' - выводится текст по умолчанию)
				</div>
				<div class="controls">
					<div class="input-append">
						<form action="index.php" method="post" style="float: left">
							<input id="appendedInputButton" class="span3" type="text" name="nm" value="<?= $acc_nm ?>"/>
							<input class="btn btn-warning" type="hidden" name="go_edit_nm"
								value="<?= isset($_SESSION['alb_num']) ? $_SESSION['alb_num'] : $_SESSION['current_album'] ?>"/>
							<input class="btn btn-warning" type="submit" value="Имя кнопки запуска"/>
						</form>
					</div>
				</div>
				<div class="controls">
					<div class="input-append">
						<form action="index.php" method="post" enctype="multipart/form-data">
							<input type="text" class="span3" style=" height: 24px; margin-left: 20px;" value="default" name="nm">
							<input type="hidden" name="add_par" value=""/>
							<input type="hidden" name="id_album" value="<?= $_SESSION['current_album'] ?>"/>
							<input type="submit" value="Добавить параграф" class="btn btn-success"/>
						</form>
					</div>
				</div>
				<br>
				<div class="controls" style="float: left; height: 28px;">
					<div class="input-append">
						<form action="index.php" method="post" style="float: left">
							<select class="span3" name="collapse_nm" style="height: 28px;">
								<?
								$curr_razd =
									(isset($_SESSION['collapse_numer']) && isset($_SESSION['alb_num'])) ?
										intval($_SESSION['collapse_numer']).intval($_SESSION['alb_num']) : 0;
								foreach ($rs as $ln)
									{
										$id_album = ($ln['id_album'] == 1) ? 'default' : $ln['id_album'];
										?>
										<option value="<?= $ln['collapse_numer'].']['.$ln['id_album'] ?>"
											<?=(
										$curr_razd == $ln['collapse_numer'].$ln['id_album'] ? 'selected="selected"' : '')?>>
											<?=$id_album.' - '.$ln['collapse_numer'].': '.$ln['collapse_nm']?></option>
									<?
									}
								?>
							</select>
							<input class="btn  btn-success" type="submit" value="Открыть"/>
						</form>
						<form action="index.php" method="post">
									<input type="hidden" name="go_up_down" value="<?= $rs[0]['id_album'] ?>"/>
									<input type="hidden" name="coll_num" value="<?= $curr_razd ?>"/>
									<input class="btn btn-info" type="submit" name="up" value="выше"/>
									<input class="btn btn-info" type="submit" name="down" value="ниже"/>
						</form>
					</div>
				</div>
			<?

			}
		else
			{
				?>
				<div class="controls">
					<div class="input-append">
						<form action="index.php" method="post" enctype="multipart/form-data">
							<input type="text" style="width: 180px; height: 20px; margin-left: 20px;" value="Важно!" name="add_par">
							<input type="hidden" name="nm" value="default"/>
							<input type="hidden" name="id_album" value="<?= $_SESSION['current_album'] ?>"/>
							<input type="submit" value="Добавить аккордеон" class="btn btn-success"/>
						</form>
					</div>
				</div>
			<?
			}
	}
if (isset($_POST['collapse_nm']))
	{
		$data                       = explode('][', $_POST['collapse_nm']);
		$_SESSION['collapse_numer'] = intval($data[0]);
		$_SESSION['alb_num']        = intval($data[1]);
	}
if (isset($_SESSION['collapse_numer']) && isset($_SESSION['alb_num']))
	{
		$rs =
			$db->query('select * from accordions where id_album =?i and collapse_numer = ?i',
				array($_SESSION['alb_num'], $_SESSION['collapse_numer']),
				'row');
		if ($rs)
			{
				?>
				<div class="controls">
					<div class="input-append">
						<form id="txtCollName"  action="" >
							<input style=" margin-left: 150px; float: left;" class="span3" type="text" name="nm" value="<?= $rs['collapse_nm'] ?>"/>
							<input type="hidden" name="go_edit_name_coll" value="<?= $rs['id_album'] ?>"/>
							<input type="hidden" name="collapse_numer" value="<?= $rs['collapse_numer'] ?>"/>
						</form>
							<button class="btn btn-warning" name="save"
								onClick="ajaxPostQ('/canon68452/index.php','',$('#txtCollName').serialize());">Переименовать</button>
					</div>
				</div>

				<form id="txtColl" action="" style="margin-bottom: 10px;">
						<label for="txtResult"></label>
						<textarea id="txtResult" name="txt_coll" class="tinymce" rows="25" cols="700" style="width: 950px; height: 200px;"><?=$rs['collapse']?></textarea>
						<input type="hidden" name="go_update" value="<?= $rs['id_album'] ?>"/>
						<input type="hidden" name="collapse_numer" value="<?= $rs['collapse_numer'] ?>"/>
				</form>
				<button class="btn btn-warning"
					onClick="ajaxPostQ('/canon68452/index.php','',$('#txtColl').serialize());" style="margin: 10px 0 40px 0; float: left">Применить</button>
				<?
				if(isset($_SESSION['alb_num']) && $_SESSION['alb_num'] !=1)
				{
				?>
				<form action="index.php" method="post">
					<input type="hidden" name="go_del" value="<?= $_SESSION['current_album'] ?>"/>
					<input type="hidden" name="collapse_numer" value="<?= $_SESSION['collapse_numer'] ?>"/>
					<input class="btn btn-danger" type="submit" value="Удалить" style="margin-left: 500px;" onclick="return confirmDelete();"/>
				</form>
			<?
			}
			}
	}
?>
<div style="clear: both; display: block; height: 100px;"></div>