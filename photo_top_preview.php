<?php
include (dirname(__FILE__).'/inc/config.php');
include (dirname(__FILE__).'/inc/func.php');

header('Content-type: text/html; charset=windows-1251');

if (isset($_SESSION['current_album'])):
		$id = intval($_GET['id']);
		if ($id > 0)
			{
				$rs = $db->query('select * from `photos` where `id` = ?i',array($id),'row');
				if ($rs)
					{
						$photo_data = $rs;
						$id_foto = $db->query('select `id` from `photos` where `id_album` = ?i
							       order by votes desc, id asc limit 0, 5',array($photo_data['id_album']),'col');
						if ($id_foto)
							{
								$index = 0;
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
								<div class="left_pointer2" onClick="previewTop('<?= $left_id ?>');"></div>
							<? endif; ?>

								<? if ($right_id): ?>
								<div class="right_pointer2" onClick="previewTop('<?= $right_id ?>');"></div>
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

													<div class="left_pointer" onClick="previewTop('<?= $left_id ?>');"></div>

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

													<div class="right_pointer" onClick="previewTop('<?= $right_id ?>');">


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
		$db->close(true);
else:

		echo '<script type="text/javascript">';
		echo 'history.go(-1);';
		echo '</script>';
		$db->close(true);

endif;

?>
<script type='text/javascript'>

	$(document).ready(function () {

		$('img').error(function () {
			$(this).attr('src', 'img/404.png');
		});

	})
</script>