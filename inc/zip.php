<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$error = ""; //error holder
if (isset($_POST['createpdf'])) {
			$post        = $_POST;
			$file_folder = "files/"; // folder to load files
			if (extension_loaded('zip')) { // Checking ZIP extension is available
						if (isset($post['files']) and count($post['files']) > 0) { // Checking files are selected
									$zip      = new ZipArchive(); // Load zip library
									$zip_name = time().".zip"; // Zip name
									if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== true) { // Opening zip file to load files
												$error .= "* Sorry ZIP creation failed at this time<br/>";
									}
									foreach ($post['files'] as $file) {
												require_once(__DIR__.'/downloadZip.php');
												$zip->addFile($file_folder.$file); // Adding files into zip
									}
									$zip->close();
									if (file_exists($zip_name)) {
												// push to download the zip
												header('Content-type: application/zip');
												header('Content-Disposition: attachment; filename="'.$zip_name.'"');
												readfile($zip_name);
												// remove zip file is exists in temp path
												unlink($zip_name);
									}

						} else {
									$error .= "* Выберите, пожалуйста, файлы `галочками`.<br/>";
						}
			} else {
						$error .= "* You dont have ZIP extension<br/>";
			}
			if (!empty($error)) {
						?>
						<script type='text/javascript'>
									dhtmlx.message.expire = 6000; // время жизни сообщения
									dhtmlx.message({ type: 'error', text: 'Ошибка!<br><?=$error?>'});
						</script>
			<?
			}
}
$link = "/core/users/page.php?user=".$_SESSION['userForm']."#user";

/*$orders = go\DB\query('SELECT *
                     FROM download_photo
                     WHERE id_user = ?i',
                     array($_SESSION['userid']), 'assoc:id_order');*/
$orders = go\DB\query('SELECT id
                     FROM orders
                     WHERE id_user = ?i', array($_SESSION['userid']), 'assoc');

if ($orders) {
			if (!empty($error)) {
						?>
						<p style="border:#C10000 1px solid; background-color:#ffc6cc; color:#B00000;padding:8px; width:400px; margin:0 auto 10px;"><?php echo $error; ?></p> <?
			}
			foreach ($orders as $order) {
						?>
						<SCRIPT language="javascript">
									$(function () {
												$("#<?=$order['id']?>").click(function () {
															var checkAll = $("#<?=$order['id']?>").prop('checked');
															if (checkAll) {
																		$(".<?=$order['id']?>").prop("checked", true);
															} else {
																		$(".<?=$order['id']?>").prop("checked", false);
															}
												});
									});
						</SCRIPT>

						<div class="order-tabl">
									<h2>Заказ № <?=$order['id']?></h2>

									<form name="zips"
															method="post"
															action="<?= $link ?>">
												<table class="table table-condensed table-hover table-striped">
															<thead>
															<tr>
																		<th>#</th>
																		<th><input type="checkbox"
																													id="<?= $order['id'] ?>"/></th>
																		<th>Имя файла</th>
																		<th>Дата заказа</th>
																		<th>Количество загрузок</th>
															</tr>
															</thead>
															<tbody>
															<?
															$orderFoto = go\DB\query('SELECT * FROM download_photo WHERE id_order = ?i', array($order['id']), 'assoc');

															if ($orderFoto) {
																		foreach ($orderFoto as $key => $foto) {
																					$trClass = ($key % 2 == 0) ? "success" : "warning";
																					$name = go\DB\query('SELECT `nm` FROM `photos` WHERE `id` = ?i', array($foto['id_photo']), 'el')
																					?>
																					<tr class="<?= $trClass ?>">
																								<td><?=$key + 1?></td>
																								<td align="center">
																											<input type="checkbox"
																																		name="files[]"
																																		class="<?= $order['id'] ?>"
																																		value="<?= $foto['download_key'] ?>"/>
																								</td>
																								<td align="center"><?=$name.'.jpg'?></td>
																								<td><?=dateToRus($foto['dt_start'], '%DAYWEEK%, j %MONTH% Y, G:i');?></td>
																								<td align="center"><?=$foto['downloads']?></td>
																					</tr>
																		<?
																		}
															}
															?>
															<tr class="info">
																		<td colspan="5"
																						style=" text-align: center;">
																					<input type="submit"
																												name="createpdf"
																												class="btn btn-primary"
																												value="Заархивировать и скачать">
																		</td>
															</tr>
															</tbody>
												</table>
									</form>
						</div>

			<?

			}
}

?>

<script>
			$(function () {
//			 $(" #myTab a:last ").tab('show');
						$(' #myTab a[href="#zakaz"] ').tab('show');
			})
</script>


<table width="600"
							border="1"
							align="center"
							cellpadding="10"
							cellspacing="0"
							style="border-collapse:collapse; border:#ccc 1px solid;">
			<tr>
						<td width="33"
										align="center">*
						</td>
						<td width="117"
										align="center">File Type
						</td>
						<td width="382">File Name</td>
			</tr>
			<tr>
						<td align="center"><input type="checkbox"
																																name="files[]"
																																value="flowers.jpg"/></td>
						<td align="center"><img src="files/image.png"
																														title="Image"
																														width="16"
																														height="16"/></td>
						<td>flowers.jpg</td>
			</tr>
			<tr>
						<td align="center"><input type="checkbox"
																																name="files[]"
																																value="fun.jpg"/></td>
						<td align="center"><img src="files/image.png"
																														title="Image"
																														width="16"
																														height="16"/></td>
						<td>fun.jpg</td>
			</tr>
			<tr>
						<td align="center"><input type="checkbox"
																																name="files[]"
																																value="9lessons.docx"/></td>
						<td align="center"><img src="files/doc.png"
																														title="Document"
																														width="16"
																														height="16"/></td>
						<td>9lessons.docx</td>
			</tr>
			<tr>
						<td align="center"><input type="checkbox"
																																name="files[]"
																																value="9lessons.pdf"/></td>
						<td align="center"><img src="files/pdf.png"
																														title="pdf"
																														width="16"
																														height="16"/></td>
						<td>9lessons.pdf</td>
			</tr>
			<tr>
						<td colspan="3"
										align="center">
									<input type="submit"
																name="createpdf"
																class="btn btn-success"
																value="Заархивировать и скачать">&nbsp;
									<input type="reset"
																name="reset"
																class="btn btn-success"
																value="Сброс">
						</td>
			</tr>
</table>