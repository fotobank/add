<?php

include  ('inc/head.php');
include  ('inc/ip-ban.php');
include  ('inc/dirPatc.php');

$ip = Get_IP(); // Ip пользователя
//Количество фоток на странице
define('PHOTOS_ON_PAGE', 7);
$Dir = DirPatc::getInst();


if (isset($_GET['album_id']))
	{
		$_SESSION['current_album'] = intval($_GET['album_id']);

		DirPatc::$current_album = intval($_GET['album_id']);

	}
if (isset($_GET['back_to_albums']))
	{
		unset($_SESSION['current_album']);

   	$Dir -> destory('current_album');
	}
if (isset($_GET['chenge_cat']))
	{
		unset($_SESSION['current_album']);
		$_SESSION['current_cat'] = intval($_GET['chenge_cat']);

		$Dir -> destory('current_album');
		DirPatc::$current_cat = intval($_GET['chenge_cat']);
	}
if (isset($_GET['unchenge_cat']))
	{
		unset($_SESSION['current_album']);
		unset($_SESSION['current_cat']);

		$Dir -> destory('current_album');
		$Dir -> destory('current_cat');
	}


?>
<form name=vote_price>
	<?
	$vote_price = floatval(get_param('vote_price'));
	?>
	<input type=hidden name=id1 value="<?= htmlspecialchars($vote_price); ?>">
</form>


<div id="main">
<script type="text/javascript" src="/js/photo-prev.js"></script>


<!-- ввод пароля -->
<div class="modal-scrolable" style="z-index: 150;">
	<div id="static" class="modal hide fade in animated fadeInDown" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="false">
		<div class="modal-header">
			<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>-->
			<h3 style="color: #444444">Ввод пароля:</h3>
		</div>
		<div class="modal-body">

			<div style="ttext_white">
				На данный альбом установлен пароль. Если у Вас нет пароля для входа или он утерян , пожалуйста свяжитесь с фотографом через
				email в разделе <a href="kontakty.php"><span class="ttext_blue">"Контакты"</span>.</a>
			</div>
			<br/>

			<form action="fotobanck.php" method="post">
				<label for="inputError" class="ttext_red" style="float: left; margin-right: 10px;">Пароль: </label>
				<input id="inputError" type="text" name="album_pass" value="" maxlength="20"/>
				<input class="btn-small btn-primary" type="submit" value="ввод"/>
			</form>
		</div>
		<div class="modal-footer">
			<p id="err-modal" style="float: left;"></p>
			<button type="button" data-dismiss="modal" class="btn" onClick="window.document.location.href='/fotobanck.php?back_to_albums'">
				Я не знаю
			</button>
		</div>
	</div>
</div>


<!-- ошибка -->
<div id="error_inf" class="modal hide fade" tabindex="-1" data-replace="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3 style="color:red">Неправильный пароль.</h3>
	</div>
	<div class="modal-body">
		<div>
			<a href="kontakty.php"><span class="ttext_blue">Забыли пароль?</span></a>
		</div>
	</div>
</div>


<!-- запрет доступа к альбому -->
<div id="zapret" class="modal hide fade" tabindex="-1" data-replace="true" style=" margin-top: -180px;">
	<div class="err_msg">
		<div class="modal-header">
			<h3 style="color:#fd0001">Доступ к альбому "<? if (isset($_SESSION['current_album']) and isset($_SESSION['album_name']))
					{ echo $_SESSION['album_name'][$_SESSION['current_album']];} ?>"	заблокирован!</h3>
		</div>
		<div class="modal-body">
			<div style="color:black">Вы использовали 5 попыток ввода пароля.В целях защиты, Ваш IP заблокирован на 30
				минут.
			</div>
			<br> <? check($ip, $ipLog, $timeout); ?> <br><br> <a href="kontakty.php"><span class="ttext_blue">Восстановление пароля</span></a>
			<a style="float:right" class="btn btn-danger" data-dismiss="fotobanck.php" href="fotobanck.php?back_to_albums">Закрыть</a>
		</div>
	</div>
</div>



<?
/**
 * @param $record_count
 * @param $may_view
 * @param $current_page
 * @todo paginator
 */

function paginator($record_count, $may_view, $current_page)
	{
		/** @var $record_count  Количество фотографий в альбоме */
		if (isset($record_count))
			{
				if ($may_view && $record_count > PHOTOS_ON_PAGE)
					{

						$page_count = ceil($record_count / PHOTOS_ON_PAGE);
						?>
						<!-- ПОСТРАНИЧНАЯ РАЗБИВКА -->
						<h4><a id="home" style="float: left">Страница <?=$current_page?></a></h4>
						<div class="pagination" align="center">
							<?
							if ($current_page == 1)
								{
									?>
									<span class="disabled">« </span>
									<span class="disabled">« Предыдущая</span>
								<?
								}
							else
								{
									?>
									<a class="next" href="fotobanck.php?album_id=<?= $_SESSION['current_album'] ?>&amp;pg=1#home">« </a>
									<a class="next" href="fotobanck.php?album_id=<?= $_SESSION['current_album'] ?>&amp;pg=<?= (
										$current_page - 1) ?>#home">« Предыдущая</a>
								<?
								}
							for ($i = 1; $i <= $page_count; $i++)
								{
									if ($i == $current_page)
										{
											//Текущая страница
											?>
											<span class="current"><?=$i?></span>
										<?
										}
									else
										{
											//Ссылка на другую страницу
											?>
											<a href="fotobanck.php?album_id=<?= $_SESSION['current_album'] ?>&amp;pg=<?= $i ?>#home"><?=$i?></a>
										<?
										}
								}
							if ($current_page == $page_count)
								{
									?>
									<span class="disabled">Следующая »</span>
									<span class="disabled">Посл. »</span>
								<?
								}
							if ($current_page < $page_count)
								{

									?>
									<a class="next" href="fotobanck.php?album_id=<?= $_SESSION['current_album'] ?>&amp;pg=<?= (
										$current_page + 1) ?>#home">Следующая »</a>
									<a class="next" href="fotobanck.php?album_id=<?= $_SESSION['current_album'] ?>&amp;pg=<?= ($page_count) ?>#home">
										»</a>
								<?
								}
							?>
						</div>
						<h4><a id="home" style="float: right">всего - <?=$record_count?> шт.</a></h4>
						<div style="clear: both;"></div>
					<?
					}
			}
		//<!--И добавлять такие блоки по мере добавления фотографий-->
	}



/**
 * @param $may_view
 * @param $current_page
 * @param $record_count
 * @todo function fotoPage
 */

function fotoPage($may_view, &$current_page, &$record_count)
	{
		$current_page = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
		if ($may_view)
			{
				if ($current_page < 1)
					{
						$current_page = 1;
					}
				$start = ($current_page - 1) * PHOTOS_ON_PAGE;
				$rs = mysql_query(
					'select SQL_CALC_FOUND_ROWS p.* from photos p where id_album = '.$_SESSION['current_album']
						.' order by img ASC, id ASC limit '.$start.','.PHOTOS_ON_PAGE);
				$record_count = intval(mysql_result(mysql_query('select FOUND_ROWS() as cnt'), 0)); // количество записей
				if (mysql_num_rows($rs) > 0)
					{
						?>
						<!-- 3 -->
						<hr class="style-one" style="margin-top: 10px; margin-bottom: -20px;">
						<?
						while ($ln = mysql_fetch_assoc($rs))
							{
								$source = ($_SERVER['DOCUMENT_ROOT'].fotoFolder().$ln['id_album'].'/'.$ln['img']);
								$sz = @getimagesize($source);
								/* размер превьюшек */
								if (intval($sz[0]) > intval($sz[1]))
									{
										$sz_string = 'width="155px"';
									}
								else
									{
										$sz_string = 'height="170px"';
									}
								?>
								<div class="podlogka">
									<figure class="ramka" onClick="preview(<?= $ln['id'] ?>);">
										<img id="<?= substr(trim($ln['img']), 2, -4) ?>" src="dir.php?num=<?= substr(trim($ln['img']), 2, -4) ?>"
											title="За фотографию проголосовало <?= $ln['votes'] ?> человек. Нажмите для просмотра." <?=$sz_string?> />

										<figcaption>№ <?=$ln['nm']?></figcaption>
									</figure>
								</div>
							<?
							}
					}
			}
	}


/**
 * @param $may_view
 * @todo function verifyParol
 */

function verifyParol($may_view)
	{
		if (!$may_view)
			{
				?>
				<div class="row">
					<div class="page">
						<a class="next" href="fotobanck.php?back_to_albums">« назад</a> <a class="next" href="fotobanck.php">«
							попробовать еще раз</a>
					</div>
					<img style="margin: 20px 0 0 40px;" src="/img/Stop Photo Camera.png" width="348" height="350"/>
					<!-- <h3><span style="color: #ffa500">Доступ к альбому заблокирован паролем.  <? //check($ip, $ipLog, $timeout);?></span></h3>-->
					<?
					if ($_SESSION['popitka'][$_SESSION['current_album']] == -10) // проверка и вывод времени бана
						{
							echo "<script type='text/javascript'>
                                             $(document).ready(function(){
                                             $('#zapret').modal('show');
                                             });
                                             function gloze() {
                                             $('#zapret').modal('hide');
                                             location='/fotobanck.php?back_to_albums';
                                             };
                                             setTimeout('gloze()', 10000);
                                             </script>";
							$_SESSION['popitka'][$_SESSION['current_album']] = 5;
						}
					?>
				</div>
			<?
			}
	}



/**
 * @param $may_view
 * @param $rs
 * @param $ln
 * @param $source
 * @param $sz
 * @param $sz_string
 * @todo function top5
 */

function top5($may_view, &$rs, &$ln, &$source, &$sz, &$sz_string)
	{
		if ($may_view)
			{
				?>
				<h3>
					<div style="text-align: center;">
						<span> Топ 5 альбома:</span>
					</div>
				</h3>
				<!-- 1 -->
				<hr class="style-one" style="margin: 0 0 -20px 0;"/>
				<?
				$rs = mysql_query('select * from photos where id_album = '.$_SESSION['current_album']
					.' order by votes desc, id asc limit 0, 5');
				$id_foto = array();
			if (mysql_num_rows($rs) > 0)
			{
				$pos_num = 1;
			while ($ln = mysql_fetch_assoc($rs))
			{
				$source = $_SERVER['DOCUMENT_ROOT'].fotoFolder().$ln['id_album'].'/'.$ln['img'];
				$sz = @getimagesize($source);
				$id_foto[$pos_num] = ($ln['id']);
				/**
				 * @todo  размер топ 5
				 */
				if (intval($sz[0]) > intval($sz[1]))
					{
						$sz_string = 'width="165px"';
					}
				else
					{
						$sz_string = 'height="195px"';
					}
				?>
				<div id="foto_top">
					<!--  <div  class="span2 offset0" >-->
					<figure class="ramka" onClick="previewTop(<?= $ln['id'] ?>);">

						<span class="top_pos" style="opacity: 0;"><?=$pos_num?></span>
						<img id="<?= substr(trim($ln['img']), 2, -4) ?>" src="dir.php?num=<?= substr(trim($ln['img']), 2, -4) ?>" alt="<?= $ln['nm'] ?>" title="Нажмите для просмотра" <?=$sz_string?> />
						<figcaption><span style="font-size: x-small; font-family: Times, serif; ">№ <?=$ln['nm']?>
								Голосов:<span class="badge badge-warning"> <span id="<?= substr(trim($ln['img']), 2, -4) ?>" style="font-size: x-small; font-family: 'Open Sans', sans-serif; "><?=$ln['votes']?></span>
                                                                    </span><br>Рейтинг: <?echo str_repeat('<img src="img/reyt.png"/>', floor(
									$ln['votes'] / 5));?>
                                                        </span></figcaption>
					</figure>
				</div>
				<!-- </div>-->
				<?
				$pos_num++;
			}
			}
				?>
				<div style="clear: both"></div>
          <!--желтя рамка топа-->
			//	<script type='text/javascript'>
				//	$(function () {
  //<!--$('#--><?//=$id_foto['1']?><!--, #--><?//=$id_foto['2']?><!--, #--><?//=$id_foto['3']?><!--, #--><?//=$id_foto['4']?><!--, #--><?//=$id_foto['5']?><!--').click(function () {-->
				//			$('#photo_preview').css('box-shadow', '0 0 0 2px #000,0 0 2px 6px #fa0, 0 0 0 11px #fd0, 0 0 0 13px #000');
				//		$("img[src='dir.php?num=5618']").closest("#photo_preview")
				//	.css('box-shadow', '0 0 0 2px #000,0 0 2px 6px #fa0, 0 0 0 11px #fd0, 0 0 0 13px #000');

				//	   });
			//			});
			//		return false;
			//		});
			//	</script>
			<?
			}
	}


/**
 * @param $may_view
 * @param $ip
 * @param $ipLog
 * @param $timeout
 * @todo function parol
 */

function parol($may_view, $ip, $ipLog, $timeout)
	{
		if (!$may_view)
			{
				if ($_SESSION['popitka'][$_SESSION['current_album']] > 0
					&& $_SESSION['popitka'][$_SESSION['current_album']] <= 5)
					{
						echo "<script type='text/javascript'>
                             $(document).ready(function load() {
                             $('#static').modal('show');
                             });
                             </script>";
					}
				if ($_SESSION['popitka'][$_SESSION['current_album']] <= 0
					&& $_SESSION['popitka'][$_SESSION['current_album']] != -10)
					{
						echo "<script type='text/javascript'>
                             $(document).ready(function(){
                             $('#zapret').modal('show');
                             });
                             function gloze() {
                             $('#zapret').modal('hide');
                             location='fotobanck.php?back_to_albums';
                             }
                             setTimeout('gloze()', 10000);
                             </script>";
						$_SESSION['popitka'][$_SESSION['current_album']] = 5;
						record($ip, $ipLog, $timeout); //бан по Ip
					}
				$ostal = '';
				if ($_SESSION['popitka'][$_SESSION['current_album']] >= 0 && isset($_POST['album_pass'])
					&& $_POST['album_pass'] != ""
					|| $_SESSION['popitka'][$_SESSION['current_album']] >= 0 && isset($_POST['album_pass'])
						&& $_POST['album_pass'] == NULL)
					{
						$_SESSION['popitka'][$_SESSION['current_album']]--;
					}
				if ($_SESSION['popitka'][$_SESSION['current_album']] == 4)
					{
						$ostal = 'У Вас осталось ';
						$popitka = 'попыток';
					}
				elseif ($_SESSION['popitka'][$_SESSION['current_album']] == 0)
					{
						$popitka = 'Последняя попытка';
					}
				else
					{
						$ostal = 'У Вас остались ещё';
						$popitka = 'попытки';
					}
				if ($_SESSION['popitka'][$_SESSION['current_album']] != 0
					&& $_SESSION['popitka'][$_SESSION['current_album']] != 5
				)
					{
						$popitka = ($ostal.' '.($_SESSION['popitka'][$_SESSION['current_album']] + 1).' '.$popitka);

			      	echo "<script type='text/javascript'>
                        var infdok = document.getElementById('err-modal');
                        var SummDok = '$popitka';
                        infdok.innerHTML = SummDok;
								dhtmlx.message({ type:'warning', text:'$popitka'});
                        </script>";
				   }
			}
	}


if (isset($_SESSION['current_album'])):

$rs = mysql_query('select * from albums where id = '.$_SESSION['current_album']);
$may_view = false;
$album_data = false;
if (mysql_num_rows($rs) == 0)
	{
		unset($_SESSION['current_album']);
	}
else
	{
		$album_data = mysql_fetch_assoc($rs);
	}
if ($album_data)
	{
		$may_view = true;
		if (!isset($_SESSION['album_name']) || !is_array($_SESSION['album_name']))
			{
				$_SESSION['album_name'] = array();
			}
		$_SESSION['album_name'][$_SESSION['current_album']] = $album_data['nm'];
		if ($album_data['pass'] != '')
			{
				?>
				<div style="display:none;"><? check($ip, $ipLog, $timeout); ?></div><?
				if (isset($_POST['album_pass']) && $_POST['album_pass'] != "")
					{
						if (!isset($_SESSION['album_pass']) || !is_array($_SESSION['album_pass']))
							{
								$_SESSION['album_pass'] = array();
							}
						$_SESSION['album_pass'][$album_data['id']] = $_POST['album_pass'];
						if (isset($_SESSION['album_pass'][$album_data['id']])
							&& $_SESSION['album_pass'][$album_data['id']] != $album_data['pass']
							&& $_SESSION['popitka'][$_SESSION['current_album']] != 0
						)
							{
								/*echo "<script type='text/javascript'>
										 window.onload = function(){ alert('Вы ввели неверный пароль!');}
										 </script>";*/
								/*
								 echo "<script type='text/javascript'>
								 $(document).ready(function(){
								 $('#error_inf').modal('show');
								 });
								 function gloze() {
								 $('#error_inf').modal('hide');
								 };
								 setTimeout('gloze()', 3000);
								 </script>";
								 */

								echo "
								<script type='text/javascript'>
								dhtmlx.message({ type:'error', text:'Пароль неправильный,<br> будьте внимательны!'});
								</script>";

							} else {

							echo "
								<script type='text/javascript'>
								dhtmlx.message({ type:'addfoto', text:'Вход выполнен'});
								</script>";
						}


					}
				$may_view = (isset($_SESSION['album_pass']) && is_array($_SESSION['album_pass'])
					&& isset($_SESSION['album_pass'][$album_data['id']])
					&& $_SESSION['album_pass'][$album_data['id']] == $album_data['pass']); // переменная пароля
			}
		else
			{
				unset($_SESSION['popitka'][$_SESSION['current_album']]);
			}
	}
// @todo Отключить проверку пароля
// $may_view = true;

// <!-- Ввод и блокировка пароля -->

parol($may_view, $ip, $ipLog, $timeout);

if (!isset($_SESSION['current_cat']))
	{
		echo "<script>window.document.location.href='/fotobanck.php?back_to_albums'</script>";
	}

$data =	mysql_query('select nm from categories where id = '.intval($_SESSION['current_cat']));
if (mysql_num_rows($data) > 0)
	{
$razdel = mysql_result($data, 0);
	}




// <!-- Проверка пароля на блокировку -->

verifyParol($may_view);



if ($may_view):
?>
<div class="profile">
	<div id="garmon" class="span12 offset1">
		<div class="accordion" id="accordion2">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">Заказ
						фотографий:</a>
				</div>
				<div id="collapseOne" class="accordion-body collapse in">
					<div class="accordion-inner">
						<p><span style="font-size:11.0pt;">Фотографии, представленные в альбоме <strong>"<?=$album_data['nm']?>
									"</strong>, прошли предварительную ручную обработку и полностью подготовлены к печати в размере 13x18см 300Dpi в городских минилабах с применением стандартного профиля. Внимание! В целях экономии места на сервере и защиты контента превьюшки, представленные на странице, сильно сжаты и предназначены только для общего представления о фотографии (местность, время, кадрировка, закрытые глаза, номер кадра и т.д ). При покупке фотографии на Ваш email,указанный при регистрации, придет ссылка для скачивания файла фотографии в разрешении <code>13x18см
									300Dpi</code> без <code>IP</code> - защиты и <code>водяного знака</code>. Выкупленные фотографии Вы имеете право распечатывать в любом количестве. Для использования фотографий в рекламных или коммерческих целях свяжитесь с фотографом.
                                            </span></p>
					</div>
				</div>
			</div>

			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
						Рейтинговая система голосования: </a>
				</div>
				<div id="collapseTwo" class="accordion-body collapse">
					<div class="accordion-inner">
						<p><span style="font-size:11.0pt;">Вы можете проголосовать за понравившуюся Вам фотографию, повысив ее рейтинг. Пять фотографий, набравших максимальное количество баллов, размещаюся в начале альбома и примут участие в скидочных акциях.
                                            </span></p>
					</div>
				</div>
			</div>

			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
						Действующие на альбом акции и скидки: </a>
				</div>
				<div id="collapseThree" class="accordion-body collapse">
					<div class="accordion-inner">
						<p><span style="font-size:11.0pt;">Фотографии, набравшие больше 5 звездочек в рейтинге, распечатаваются для владельцев бесплатно.
                                            </span></p>
					</div>
				</div>
			</div>
		</div>
		<a class="profile_bitton2" href="#">Закрыть</a>
	</div>
	<!-- гармошка -->

</div>
<div><a class="profile_bitton" href="#">Условия и скидки</a></div>
</div>



	<script language=JavaScript type="text/javascript">
		$(function () {
			$('.profile_bitton , .profile_bitton2').click(function () {
				$('.profile').slideToggle();
				return false;
			});
		});
	</script>


	<!-- кнопки назад -->

	<div class="page">
		<a class="next" href="fotobanck.php?back_to_albums">« назад</a> <a class="next" href="fotobanck.php?unchenge_cat">«
			выбор категорий </a> <a class="next" href="fotobanck.php?back_to_albums">« раздел "<?=$razdel?>"</a>
		<a class="next">« альбом "<?=$album_data['nm']?>"</a>
	</div>


	<!-- Название альбома  -->

	<div class="zagol2" class="span5 offset0"><h2><span style="color: #ffa500; float: left;  margin: 20px 0 0 300px;">Фотографии альбома "<?=$album_data['nm']?>
				"</span></h2></div>
	<div style="clear: both;"></div>

	<!--/**	выводим фотографию - заголовок альбома*/ -->
	<div id="alb_opis" class="span3">
		<div class="alb_logo">
			<div id="fb_alb_fotoP">
				<img src="album_id.php?num=<?= substr(($album_data['img']), 2, -4) ?>" width="130px" height="124px" alt="-"/>
			</div>
			<div id="fb_alb_nameP"></div>
		</div>
		<?=$album_data['descr']?>
	</div>


	<!-- вывод топ 5  -->
	<?
	top5($may_view, $rs, $ln, $source, $sz, $sz_string);
	?>


	<!-- Вывод фото в альбом -->
	<div id=foto-ajax>
		<?
		fotoPage($may_view, $current_page, $record_count);
		?>
	</div>

	<!-- тело --><!-- 4 -->
<hr class="style-one" style="clear: both; margin-bottom: -20px; margin-top: 0"/>



	<!--Вывод нумерации страниц -->	<?
  /**
   * @todo Вывод нумерации страниц
  */
	paginator($record_count, $may_view, $current_page);



	$PageVarName = "fotobanck.php?album_id=".$_SESSION['current_album']."&amp;pg";
	$CurPage = $current_page;
	$SLCountRowsToShowing = 2;
	if ($CurPage)
		{
			$CurPage = ($CurPage - 1) * $SLCountRowsToShowing;
		}
	else {
		$CurPage = 0;
	}
	$SqlShowAll = "SELECT * FROM `*` ORDER BY `*` DESC LIMIT ".$CurPage.", ".$SLCountRowsToShowing;
	$SqlPagesMessage = "SELECT `*` FROM `*`;";

	$CountToShow = PHOTOS_ON_PAGE;



	//include 'pages.php';
	endif;

		/**
		 *@todo <!-- Вывод альбомов в разделах -->
		 */
else:

		if (isset($_SESSION['current_cat']))
			{
				$current_cat = intval($_SESSION['current_cat']);
			}
		else
			{
				$current_cat = -1;
			}

		if ($current_cat > 0)
			{
				/**
				 * @todo<!--Вывести поле nm из бд в шапку -->
				 */
				$razdel = '';
				if (isset($_SESSION['current_cat']))
					{
						$razdel = mysql_result(mysql_query(
							'select nm from categories where id = '.$_SESSION['current_cat']), 0);
					}
				?>
				<div class="zagol2"><h2><span style="color: #ffa500">Раздел фотобанка - "<?=$razdel;?>"</span></h2></div>
				<!-- Кнопки назад -->

				<div class="page">
					<a class="next" href="fotobanck.php?unchenge_cat">« назад</a>
					<a class="next" href="fotobanck.php?unchenge_cat">« выбор категорий </a> <a class="next">« раздел
						"<?=$razdel;?>"</a>
				</div>
				<div style="clear: both"></div>

				<!-- Подготовка вывода альбомов на страницы разделов   -->
				<?
				$rs = mysql_query('select * from albums where id_category = '.$current_cat.' order by order_field asc');
				/**
				 * @todo  Вывод текстовой информации на страницы разделов
				 */
				echo mysql_result(mysql_query('select txt from categories where id = '.$current_cat.'  '), 0);
				/**
				 * @todo Печать альбомов
				 */
				if (mysql_num_rows($rs) > 0)
					{
						$i = 0;
						$h = 0;
						while ($ln = mysql_fetch_assoc($rs))
							{
								$top = $h * 1 + 20;
								$left = $i * 250;
								?>
								<div class="div_tab">
									<div class="div_t">
										<div class="div_fb3" style="top:<?= $top ?>px; left:<?= $left ?>px;">
											<a href="fotobanck.php?album_id=<?= $ln['id'] ?>">
												<img src="album_id.php?num=<?= substr(($ln['img']), 2, -4) ?>" id="album_<?= $ln['id'] ?>_2" alt="<?= $ln['nm'] ?>" title="Просмотр" class="img3"/>
											</a> <br> <span class="prev_name"><?=$ln['nm']?></span>
										</div>
									</div>
								</div>
								<?
								$i++;
								if ($i > 4)
									{
										$h++;
										$i = 0;
										?>
										<table border="0" width="100%" HEIGHT="250">
											<tr>
												<td>
													<HR SIZE=2>
													<br><br><br>
													<HR SIZE=2 WIDTH=100%>
													<br>
												</td>
											</tr>
										</table>
									<?
									}
							}
						if ($i != 0)
							{
								?>
								<table border="0" width="100%" HEIGHT="250">
									<tr>
										<td>
											<HR SIZE=2>
											<br><br><br>
											<HR SIZE=2 WIDTH=100%>
											<!--линии альбомов --><br>
										</td>
									</tr>
								</table>
							<?
							}
					}
			}
		else
			{
				?>
				<br>

				<h2><span style="color: #ffa500">Выбор категорий</span></h2><br>
				<table>
					<tr>
						<td>

							<?
							$rs = mysql_query('select * from categories order by id asc');
							while ($ln = mysql_fetch_assoc($rs))
								{
									/**
									 *@todo кнопки разделов
									 */
									?>
									<a class="button gray" href="fotobanck.php?chenge_cat=<?= $ln['id'] ?>"><?=$ln['nm']?> </a>
								<?
								}
							?>

						</td>
					</tr>
					<tr>
						<td>
							<div id="cont_fb"></div>
						</td>
					</tr>
				</table>

			<?
			}
endif;
?>

<script type='text/javascript'>
	$('img').error(function () {
		$(this).attr('src', 'img/not_foto.png');
	});
</script>

</div>
<div class="end_content">

</div></div>

<?php
include ('inc/footer.php');
?>            