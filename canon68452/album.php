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
						$nm          = mysql_escape_string($_POST['nm']);
						$descr       = mysql_escape_string($_POST['descr']);
						$foto_folder = mysql_escape_string($_POST['foto_folder']);
						$id_category = mysql_escape_string($_POST['id_category']);
						if (empty($nm))
							{
								$nm = 'Без имени';
							}
						mysql_query('insert into albums (nm) values (\''.$nm.'\')');
						if (mysql_errno() > 0)
							{
								die('Ошибка MySQL!'.mysql_error());
							}
						$id_album    = mysql_insert_id();
						$img         = 'id'.$id_album.'.'.$ext;
						$target_name = $_SERVER['DOCUMENT_ROOT'].'/images/'.$img;
						$file_load   = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$img;
						$preffiks    = '/Public/fotobank/';
						if (move_uploaded_file($_FILES['preview']['tmp_name'], $file_load))
							{
								$sharping  = 1;
								$watermark = 0;
								$ip_marker = 0;
								if (imageresize($target_name, $file_load, 200, 200, 75, $watermark, $ip_marker, $sharping)
									== 'true'
								)
									{
										mysql_query("update albums set id_category = '$id_category', img = '$img', order_field = '$id_album', descr = '$descr', foto_folder = '$foto_folder'  where id = '$id_album'");
										mkdir('../'.$foto_folder.$id_album, 0777, true) or die($php_errormsg);
										unlink($file_load);
										$_SESSION['current_album'] = $id_album;
										$_SESSION['current_cat']   = $id_category;
									}
								else
									{
										mysql_query('delete from albums where id = '.$id_album);
										die('Для обработки принимаются только JPG, PNG или GIF имеющие размер не более 15Mb.');
										unlink($file_load);
									}
							}
						else
							{
								mysql_query('delete from albums where id = '.$id_album);
								die('Не могу загрузить файл в папку "tmp"');
								unlink($file_load);
							}
					}
				else
					{
						die('Размер файла превышает 15 мегабайт');
						unlink($file_load);
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
		$id = intval($_POST['go_edit_name']);
		$nm = mysql_escape_string($_POST['nm']);
		if (empty($nm))
			{
				$nm = '-----';
			}
		mysql_query('update albums set nm = \''.$nm.'\' where id = '.$id);
	}




if (isset($_POST['go_edit_descr']))
	{
		$id    = intval($_POST['go_edit_descr']);
		$descr = mysql_escape_string($_POST['descr']);
		mysql_query('update albums set descr = \''.$descr.'\' where id = '.$id);
	}




if (isset($_POST['go_edit_nastr']))
	{
		$watermark   = (int)isset($_REQUEST['watermark']);
		$ip_marker   = (int)isset($_REQUEST['ip_marker']);
		$sharping    = (int)isset($_REQUEST['sharping']);
		$quality     = mysql_escape_string($_POST['quality']);
		$id          = intval($_POST['go_edit_nastr']);
		$price       = floatval($_POST['price']);
		$id_category = intval($_POST['id_category']);
		$pass        = mysql_escape_string($_POST['pass']);
		$ftp_folder  = mysql_escape_string($_POST['ftp_folder']);
		$foto_folder = mysql_escape_string($_POST['foto_folder']);
		mysql_query(
			'update albums set price = \''.$price.'\', id_category = '.$id_category.', pass = \''.$pass.'\',quality = \''
				.$quality.'\'
  , ftp_folder = \''.$ftp_folder.'\', foto_folder = \''.$foto_folder.'\', watermark = \''.$watermark.'\',
  ip_marker = \''.$ip_marker.'\', sharping = \''.$sharping.'\' where id = '.$id);
		mysql_query('update photos set price = \''.$price.'\' where id_album = '.$id);
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
		$id = intval($_POST['go_ftp_upload']);
		$rs = mysql_query('select * from albums where id = '.$id);
		if (mysql_num_rows($rs) > 0)
			{
				//Выбираем данные по альбому и настройки FTP-сервера
				$album_data = mysql_fetch_assoc($rs);
				$ftp_host   = get_param('ftp_host');
				$ftp_user   = get_param('ftp_user');
				$ftp_pass   = get_param('ftp_pass');
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
										$nm = substr($f_name, 0, strrpos($f_name, '.'));
										mysql_query(
											'insert into photos (id_album, nm) values ('.intval($album_data['id']).', \''.$nm
												.'\')');
										$id_photo     = mysql_insert_id();
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
												mysql_query("update photos set img = '$tmp_name', price = '".$album_data['price']
													."', ftp_path = '$remote_file' where id = '$id_photo'");
											}
										else
											{
												unlink($local_file);
												mysql_query('delete from photos where id = '.$id_photo);
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
		$id            = intval($_POST['go_updown']);
		$current_order = intval(mysql_result(mysql_query('select order_field from albums where id = '.$id), 0));
		if ($current_order > 0)
			{
				if (isset($_POST['up']))
					{
						$rs =
							mysql_query('select id, order_field from albums where order_field < '.$current_order
								.' order by order_field desc limit 0, 1');
					}
				else
					{
						$rs =
							mysql_query('select id, order_field from albums where order_field > '.$current_order
								.' order by order_field asc limit 0, 1');
					}
				if (mysql_num_rows($rs) > 0)
					{
						$ln         = mysql_fetch_assoc($rs);
						$swap_id    = intval($ln['id']);
						$swap_order = intval($ln['order_field']);
					}
			}
		if ($current_order > 0 && $swap_id > 0)
			{
				mysql_query('update albums set order_field = '.$current_order.' where id = '.$swap_id);
				mysql_query('update albums set order_field = '.$swap_order.' where id = '.$id);
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
										$tmp = mysql_query('select * from categories order by id asc');
										while ($tmp2 = mysql_fetch_assoc($tmp))
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
															if ($tmp2['id'] == $_SESSION['id_category'] ? 'selected="selected"' : '')
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
		$id           = intval($_POST['go_delete']);
		$album_folder = mysql_result(mysql_query('select order_field from albums where id = '.$id), 0);
		$foto_folder  = mysql_result(mysql_query('select foto_folder from albums where id = '.$id), 0);
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
$rs_cat = mysql_query('select DISTINCT c.nm, c.id
  		      from categories c, albums a 
  		    	where  c.id = a.id_category							      
  		      order by a.order_field asc   ');


if (mysql_num_rows($rs_cat) > 0)
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
						while ($ln_cat = mysql_fetch_assoc($rs_cat))
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
		$rs = mysql_query('select c.nm, a.*
  		      from categories c, albums a 
  		      where  c.id = a.id_category
  		      and  a.id_category = '.intval($_SESSION['current_cat']).'
  		      order by a.order_field asc');
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
						<form id="myForm2" action="index.php" method="post">
							<select id="appendedInputButton" class="span3" style=" margin-left: 100px; height: 28px;" name="id">
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
							<input class="btn  btn-success" type="submit" value="открыть"/>
						</form>
					</div>
				</div>

				<?
				if (isset($_SESSION['current_album'])):
						$rs = mysql_query('select * from albums where id = '.intval($_SESSION['current_album']));
						if (mysql_num_rows($rs) > 0)
							{
								while ($ln = mysql_fetch_assoc($rs))
									{
										$_SESSION['id_category'] = $ln['id_category'];
										?>
										<div style="border-bottom: 0 none; margin-bottom: 120px;">
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
																									<label for="price" class="add-on">Цена за фото (гр.):&nbsp;&nbsp;</label>
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
																									<label for="quality" class="add-on">Качество .jpg (%):&nbsp;&nbsp;&nbsp;</label>
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
																										$tmp = mysql_query('select * from categories order by id asc');
																										while ($tmp2 = mysql_fetch_assoc($tmp))
																											{
																										 ?>
																												<option value="<?= $tmp2['id'] ?>" <?=( $tmp2['id']
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
																									<label for="pass" class="add-on">Пароль на альбом:&nbsp;&nbsp;</label>
																									<input id="pass" class="span2" type="text" NAME="pass" VALUE="<?= $ln['pass'] ?>"/>
																								</div>
																							</td>
																						</tr>
																						<tr>
																							<td>
																								<div class="input-prepend">
																									<label for="foto_folder" class="add-on">Папка фотобанка:&nbsp;&nbsp;&nbsp;</label>
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
																							<td colspan="2">
																								<input id="ftpFold" type="hidden" name="ftpFold" value="<?= $ln['ftp_folder'] ?>"/>
																								<div class="input-prepend">
																								<label id='refresh' title='Обновить папки' for="upFTP" class="add-on" onclick='sendFtp();'>
																									Папка uploada FTP:</label>
																										<select id= "upFTP" class="span3" NAME="ftp_folder">
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
																				<form action="index.php" name="go_ftp_upload" method="post" style="margin-bottom: 0;" target="hiddenframe" onsubmit="document.getElementById('<?= $ln['order_field'] ?>').innerHTML='Подождите, идёт загрузка...'; return true;">
																					<input class="btn btn-success" type="hidden" name="go_ftp_upload" value="<?= $ln['id'] ?>"/>

																					<div id="<?= $ln['order_field'] ?>"></div>
																					<div id="<?= $ln['order_field'] ?>bar"></div>
																					<div id="<?= $ln['order_field'] ?>err"></div>
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
																	"..<?=$ln['foto_folder']?><?=$ln['order_field']?>"
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
?>
