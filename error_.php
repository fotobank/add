<?php
//	include (dirname(__FILE__).'/inc/head.php');


	$id = (isset($argv[0]))?$argv[0]:404;
	$id = abs(intval($id));
	if (!$id)
		{
			$id = 404;
		}
	// ассоциативный массив кодов и описаний
	$a[401] = "Требуется авторизация!";
	$a[403] = "Пользователь не прошел аутентификацию, доступ запрещен!";
	$a[404] = "Страница не найдена! <br> <p style='font-size: 24px; color: #10109c;'>Возможно она была удалена, либо Вы набрали неверный адрес.</p>";
	$a[500] = "Внутренняя ошибка сервера!";
	$a[400] = "Неправильный запрос!";

	// эта переменная содержит тело сообщения
	$body = <<<END

<div style='text-align: right;'>
    <img src='/img/_404.png' alt='404'>
</div>

END;
	if (isset($HTTP_REFERER))
		{
			$body .= "Вы пришли со страницы: <b>$HTTP_REFERER</b><br />\n";
		}

?>
<!--	<title>aleks.od.ua | --><?//=$a[$id]?><!-- </title>-->
	<h2 style="font-size: 36px; font-family: Georgia, 'Times New Roman', Times, serif; color: #9c3735; margin-top: 50px;"><i>Ошибка: <?=$id?></i> <?=$a[$id]?></h2>
	<p><?=$body?></p>
   <?= isset($GLOBALS['SERVER_SIGNATURE'])?$GLOBALS['SERVER_SIGNATURE']:'' ?>

<?php
//	include ('inc/footer.php');
?>