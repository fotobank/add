<?php
include ('inc/config.php');
include ('inc/func.php');

header('Content-type: text/html; charset=windows-1251');

if (isset($_SESSION['current_album'])):
		$id = intval($_GET['id']);
		if ($id > 0)
			{
				$rs = mysql_query('select * from photos where id = '.$id);
				if (mysql_num_rows($rs) > 0)
					{
						$photo_data = mysql_fetch_assoc($rs);
						$rs = mysql_query('select id from photos where id_album = '.intval($photo_data['id_album'])
							.' order by votes desc, id asc limit 0, 5');
						if (mysql_num_rows($rs) > 0)
							{
								$index = 0;
								$id_foto = array();
								while ($ln = mysql_fetch_assoc($rs))
									{
										$id_foto[$index] = ($ln['id']);
										$index++;
									}
								$right_id = 0;
								$left_id = 0;
								foreach ($id_foto as $key => $val)
									{
										if ($id == intval($val))
											{
												$right_id = intval($id_foto[$key + 1]);
												$left_id = intval($id_foto[$key - 1]);
											}
									}
								if ($id == $id_foto[0])
									{
										$left_id = intval($id_foto[4]);
									}
								if ($id == $id_foto[4])
									{
										$right_id = intval($id_foto[0]);
									}
								$source = $_SERVER['DOCUMENT_ROOT'].fotoFolder().$photo_data['id_album'].'/'.$photo_data['img'];
								$sz = @getimagesize($source);
								$sz_string = 'width: '.($sz[0]).'px;';
								?>

								<? if ($left_id): ?>
								<div class="left_pointer2" onClick="previewTop(<?= $left_id ?>);"></div>
							<? endif; ?>

								<? if ($right_id): ?>
								<div class="right_pointer2" onClick="previewTop(<?= $right_id ?>);"></div>
							<? endif; ?>


								<div style="<?= $sz_string ?>">

									<div style="text-align: center; width: 100%;">

										<img src="dir.php?num=<?= substr(($photo_data['img']), 2, -4) ?>" alt="<?= $photo_data['nm'] ?>" title="Фотография № <?= $photo_data['nm'] ?><?= $right_id ?>. Нажмите,чтобы закрыть." onClick="hidePreview();"/>
									</div>
									<div>
										<table border="0" cellspacing="10px" width="100%">
											<tr>
												<td class="ph_orig_nm" valign="top" colspan="4" align="center">
													фотография №
													<?=$photo_data['nm']?>
													<br>
													<?
													//Вместо * можно подставить тэг <img> с картинкой - печать звездочек
													echo str_repeat('<img src="/img/reyt.png"/>', floor($photo_data['votes'] / 5));
													?>
												</td>
											</tr>
											<tr>
												<td align="left">
													<? if ($left_id): ?>
														<div class="left_pointer" onClick="previewTop(<?= $left_id ?>);"></div>
													<? else: ?>
														<div class="pointer_hidden" onClick="hidePreview();"></div>
													<? endif; ?>
												</td>
												<td valign="top" width="33%" align="left">
													<input type="button" value="В корзину" style="cursor: pointer;" onClick="basketAdd(<?= $photo_data['id'] ?>);"/><br/>
													Цена: <?=(
													floatval($photo_data['price']) > 0 ? $photo_data['price'].'грн.' : 'бесплатно')?>
												</td>
												<td valign="top" width="33%" align="right">
													<input type="button" value="Голосовать" style="cursor: pointer;" onClick="goVote(event, <?= $photo_data['id'] ?>);"/><br/>
													Голосов: (<?=$photo_data['votes']?>)
												</td>

												<td align="right">
													<? if ($right_id): ?>
													<div class="right_pointer" onClick="previewTop(<?= $right_id ?>);">
														<? else: ?>
															<div class="pointer_hidden" onClick="hidePreview();"></div>
														<? endif; ?>

												</td>

											</tr>
											<!--        <tr>
													  <td colspan="2" align="center">
														  <span style="cursor: pointer;" onClick="JavaScript: hide_preview();">
														   закрыть
														  </span>
													  </td>
													</tr>
													-->
										</table>
									</div>
								</div>
							<?
							}
					}
			}
		mysql_close();
else:

		echo '<script type="text/javascript">';
		echo 'history.go(-1);';
		echo '</script>';
		mysql_close();

endif;

?>
<script type='text/javascript'>

	$(document).ready(function(){

	$('img').error(function () {
		$(this).attr('src', 'img/404.png');
	});

		if ($("img").attr("src") == "dir.php?num=5621") {

			$('#photo_preview, img').css('box-shadow','0 0 0 2px #000,0 0 2px 6px #fa0, 0 0 0 11px #fd0, 0 0 0 13px #000');

			    }





	})
</script>

