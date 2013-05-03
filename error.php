<?php
//	include (dirname(__FILE__).'/inc/head.php');
?>

	<style type="text/css">
		body {
			width: 1200px;
			margin-left: auto;
			margin-right: auto;
			background: url("img/404_bg.png") repeat-y right #bcc5ca;
			color: #9A022B;
			text-shadow: 2px 2px 2px #ccc;
		}

		h1 {
			font-size: 48px;
			margin: 0 20px;
		}

		p {
			font-size: 32px;
			margin: 20px;
		}

		img {
			margin: 0;
		}

		a {
			/*text-decoration: none;*/
		}
	</style>
<?

	$id = $argv[0];
	$id = abs(intval($id));
	if (!$id)
		{
			$id = 404;
		}
	// ассоциативный массив кодов и описаний
	$a[401] = "Требуется авторизация";
	$a[403] = "Пользователь не прошел аутентификацию, доступ запрещен";
	$a[404] = "Страница не найдена. <br> <p>Возможно она была удалена, либо Вы набрали неверный адрес</p>";
	$a[500] = "Внутренняя ошибка сервера";
	$a[400] = "Неправильный запрос";
	// определяем дату и время в стандартном формате
	$time = date("d.m.Y H:i:s");
	// эта переменная содержит тело сообщения
	$body = <<<END
<p><a href='http://aleks.od.ua/'>Перейдем на Главную страницу?</a></p>
<div style='text-align: right;'>
    <img src='/img/404a.png' alt='404'>
</div>

END;
	if ($HTTP_REFERER)
		{
			$body .= "Вы пришли со страницы: <b>$HTTP_REFERER</b><br />\n";
		}

?>
	<title>aleks.od.ua | <?=$a[$id]?> </title>
	<h1><i>ОШИБКА <?=$id?></i> <?=$a[$id]?></h1>
	<p><?=$body?></p>
	<?= $GLOBALS['SERVER_SIGNATURE'] ?>








<?php
//	include ('inc/footer.php');
?>