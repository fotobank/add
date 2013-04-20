<?
include __DIR__.'./config.php';
include __DIR__.'./func.php';



//error_reporting(E_ALL);
//ini_set('display_errors', 1);
error_reporting(0);
header('Content-type: text/html; charset=windows-1251');


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//RU" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:Логин="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
	<!-- <meta name="google-site-verification" content="uLdE_lzhCOntN_AaTM1_sQNmIXFk1-Dsi5AWS0bKIgs"/>
	  <link href='http://fonts.googleapis.com/css?family=Lobster|Comfortaa:700|Jura:600&subset=cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>-->
	<?



	// обработка ошибок
	include __DIR__.'./lib_mail.php';
	include __DIR__.'./lib_ouf.php';
	include __DIR__.'./lib_errors.php';
	$error_processor = Error_Processor::getInstance();

	/**
	 *  Тесты для проверки Error_Processor
	 * PHP set_error_handler TEST
	 */
	//	IMAGINE_CONSTANT;
	/**
	 * PHP set_exception_handler TEST
	 */
	//   throw new Exception( 'Imagine Exception' );
	/**
	 * PHP register_shutdown_function TEST ( IF YOU WANT TEST THIS, DELETE PREVIOUS LINE )
	 */
	//	 	imagine_function( );


	if (isset($_SESSION['us_name']) && $_SESSION['us_name'] == 'test')
		{
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$start = $time;
			?>
			<h2><< DEBUG >> </h2>
			<div class="ttext_orange" style="position:relative">
				Используемая память в начале: <?=intval(memory_get_usage() / 1024)?> Кбайт.
				<hr class="style-one" style=" margin-bottom: -20px; margin-top: 10px"/>
			</div>
			<?
		}

	include __DIR__.'./title.php';
	$cryptinstall = '/inc/captcha/cryptographp.fct.php';
	include  'captcha/cryptographp.fct.php';
	?>

	<!--[if lt IE 9]>
	<script>
		document.createElement('header');
		document.createElement('nav');
		document.createElement('section');
		document.createElement('article');
		document.createElement('aside');
		document.createElement('footer');
		document.createElement('figure');
		document.createElement('figcaption');
		document.createElement('span');
	</script>	<![endif]-->


	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico"/>
	<link rel="shortcut icon" href="/img/ico_nmain.gif"/>
	<link rel="stylesheet" type="text/css" href="/css/reset.min.css">
	<link href="/css/dynamic-to-top.css" rel="stylesheet" type="text/css"/>
	<!-- кнопка вверх -->
	<link href="/css/bootstrap.css" rel="stylesheet"/>
	<link rel="stylesheet" href="/css/lightbox.css" type="text/css" media="screen"/>


	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/main.js"></script>
	<script type="text/javascript" src="/js/ajax.js"></script>

	<!--        <script src="/js/no-copy.js"></script>-->


	<link href="/css/animate.css" rel="stylesheet" type="text/css"/>
	<link href="/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
	<script src="/js/bootstrap-modalmanager.js"></script>
	<script src="/js/bootstrap-modal.js"></script>

	<!--сообщения-->
	<link href="/js/jsmessage/codebase/themes/message_default.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="/js/jsmessage/codebase/message.js"></script>


	<!--сообщения-->
	<link href="/js/humane/themes/jackedup.css" rel="stylesheet" type="text/css"/>
	<!--        <link href="/js/humane/themes/libnotify.css" rel="stylesheet" type="text/css"/>-->
	<!--        <link href="/js/humane/themes/bigbox.css" rel="stylesheet" type="text/css"/>-->
	<script type="text/javascript" src="/js/humane/humane.js"></script>

	<link href="/css/main.css" rel="stylesheet" type="text/css"/>
	<?


	if (strstr($_SERVER['PHP_SELF'], 'folder_for_prototype')): ?>
		<script type="text/javascript" src="/js/prototype.js"></script>
		<script type="text/javascript" src="/js/scriptaculous.js?load=effects"></script>
		<script type="text/javascript" src="/js/lightbox.js"></script>
	<? endif; ?>

	<!--- шифровка E-mail -->
	<script language="javascript">
		function scrambleVideo() {
			var p1, p2, p3, p4, p5, p6;
			p1 = '<a href="mai';
			p2 = 'video';
			p3 = '">';
			p1 += 'lto:';
			p2 += '@';
			p5 = '</a>';
			p6 = 'Заказ видеосъемки';
			p2 += 'aleks.od.ua';
			p4 = p6;
			document.write(p1 + p2 + p3 + p4 + p5)
		}
		function scrambleFoto() {
			var p1, p2, p3, p4, p5, p6;
			p1 = '<a href="mai';
			p2 = 'foto';
			p3 = '">';
			p1 += 'lto:';
			p2 += '@';
			p5 = '</a>';
			p6 = 'Заказ фотосесии';
			p2 += 'aleks.od.ua';
			p4 = p6;
			document.write(p1 + p2 + p3 + p4 + p5)
		}
	</script>

	<script language=JavaScript type="text/javascript">

		function smile(str) {
			obj = document.Sad_Raven_Guestbook.mess;
			obj.focus();
			obj.value = obj.value + str;
		}
		function openBrWindow(theURL, winName, features) {
			window.open(theURL, winName, features);
		}
		function inserttags(st_t, en_t) {
			obj = document.Sad_Raven_Guestbook.mess;
			obj2 = document.Sad_Raven_Guestbook;
			if ((document.selection)) {
				obj.focus();
				obj2.document.selection.createRange().text = st_t + obj2.document.selection.createRange().text + en_t;
			}
			else {
				obj.focus();
				obj.value += st_t + en_t;
			}
		}
	</script>

	<script type="text/javascript">
		$(document).ready(function () {
			$(".vhod ,.registracia, input, textarea").tooltip();
		});

		$("a[rel=popover]")
			.popover({
				offset: 10
			})
			.click(function (e) {
				e.preventDefault()
			});
	</script>




</head>
<body>
<div id="maket">
<div id="photo_preview_bg" class="hidden" onClick="hidePreview();"></div>
<div id="photo_preview" class="hidden"></div>


<!--Голова начало-->
<div id="head">
<table class="tb_head">
	<tr>
		<td>
			<div class="td_head_logo">

				<div id="flash-container">
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="910" height="208" id="flash-object">
						<param name="movie" value="img/container.swf">
						<param name="quality" value="high">
						<param name="scale" value="default">
						<param name="wmode" value="transparent">
						<param name="flashvars" value="color1=0xFFFFFF&amp;alpha1=.50&amp;framerate1=24&amp;loop=true&amp;wmode=transparent&amp;clip=img/flash.swf&amp;radius=4&amp;clipx=-50&amp;clipy=0&amp;initalclipw=900&amp;initalcliph=200&amp;clipw=1000&amp;cliph=200&amp;width=900&amp;height=200&amp;textblock_width=0&amp;textblock_align=no&amp;hasTopCorners=true&amp;hasBottomCorners=true">
						<param name="swfliveconnect" value="true">

						<!--[if !IE]>-->
						<object type="application/x-shockwave-flash" data="img/container.swf" width="910" height="208">
							<param name="quality" value="high">
							<param name="scale" value="default">
							<param name="wmode" value="transparent">
							<param name="flashvars" value="color1=0xFFFFFF&amp;alpha1=.50&amp;framerate1=24&amp;loop=true&amp;wmode=transparent&amp;clip=img/flash.swf&amp;radius=4&amp;clipx=-50&amp;clipy=0&amp;initalclipw=900&amp;initalcliph=200&amp;clipw=1000&amp;cliph=200&amp;width=900&amp;height=200&amp;textblock_width=0&amp;textblock_align=no&amp;hasTopCorners=true&amp;hasBottomCorners=true">
							<param name="swfliveconnect" value="true">
						</object>
						<!--<![endif]-->
					</object>
				</div>

				<a class="logo" href="/index.php"></a>

				<div id="zagol">
					<h1><span></span>Профессиональная<br> фото и видеосъёмка <br> в Одессе </h1>
				</div>

			</div>

		</td>
		<td class="td_form_ent">

			<div id="form_ent">

				<? if (isset($_SESSION['logged'])): ?>
					<div style="text-align: center;">
  <span style="color:#bb5">Здравствуйте,<br> <span style="font-weight: bold;"><?=$_SESSION['us_name']?></span><br/>
	  <?
	  $user_balans =
		  floatval(mysql_result(mysql_query('select balans from users where id = '.intval($_SESSION['userid'])), 0));
	  ?>
	  Ваш баланс: <span style="font-weight: bold;"><?=$user_balans?></span> гр.<br/></span></div>

					<div style="margin-top: 8px;">
						<a class="korzina" href="/basket.php">корзина</a>
						<a class="vihod" href="/enter.php?logout=1">выход</a>
					</div>
					<div style="margin-top: 8px;">
						<a class="scet" href="#scet_form">пополнение счета</a>
					</div>

				<? else: ?>
					<span>Форма входа:</span><br>
					<form action="/enter.php" method="post">
						<table>
							<tr>
								<td> Логин:</td>
								<td><label><input class="inp_fent" name="login"> </label></td>
							</tr>
							<tr>
								<td> Пароль:</td>
								<td><label> <input class="inp_fent" type="password" name="password"> </label></td>
							</tr>
							<tr></tr>
							<tr>
								<td>
									<input data-placement="left" rel="tooltip" class="vhod" name="submit" type="submit" value="вход" title="Добро пожаловать!" data-original-title="Tooltip on left">
								</td>

								<td>
									<a href="/registr.php" class="registracia" data-placement="right" data-original-title="Вы еще не зарегистрировались? Присоединяйтесь">регистрация</a>
								</td>
							</tr>
						</table>
						<!--						<a href="/reminder.php" style="color: #fff; text-decoration: none;" >Забыли пароль?</a>-->
						<a href="#" style="color: #fff; text-decoration: none;" onclick="$(document).ready(function load() {$('#vosst').modal('show'); }); ">Забыли
							пароль?</a>
					</form>
				<? endif; ?>

			</div>
		</td>

	<tr>
		<td></td>
		<td>
</table>
<a href="#" class="overlay" id="scet_form"></a>

<div id="popup">
	<legend>Пополнение счета </legend><a class="close2" href="#"></a>
</div>


<!-- восстановление пароля data-focus-on="input:first" -->
<div id="vosst" class="modal hide fade in animated fadeInDown" style="position: absolute; top: 40%; left: 50%; z-index: 1;
	" data-keyboard="false" data-width="460" data-backdrop="static" tabindex="-1" aria-hidden="false">
	<div class="modal-header" style="background: rgba(229,229,229,0.53)">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="$('#result').empty();">x
		</button>
		<div>
			<h3>
				<span style="font-weight: bold;"><legend>Восстановление пароля:</legend></span>
			</h3>
		</div>
		<div id="result"></div>
	</div>
	<div class="modal-body" style="height: 180px;">
		<form action="" id="reminder" >
			<label>
				<input id="name" class="autoclear" data-tabindex="2" title="Ваш логин:" maxlength="20"
					style="margin-left: 8px; width: 250px" type="text" value="Введите Ваш логин:" name="login"/>
			</label> <label>
				<input id="email" class="autoclear" data-tabindex="1"  title="или E-mail:" maxlength="20"
					style="margin-left: 8px; width: 250px" type="text" value="или E-mail:" name="email"/>
			</label> <label style="float: left">
				<input id="captcha" class="autoclear" data-tabindex="3"  title="Проверочное число:" maxlength="20"
					style="margin-left: 8px; width: 250px" type="text" value="Код безопасности:" name="pkey"/>
			</label>

			<div style="margin-top: 5px;"><?php dsp_crypt(0,1); ?></div>
			<input class="btn" type="reset" value="Напомнить"
				onClick="ajaxPostQ('/inc/SendData.php','#result',$('#reminder').serialize()); reload(0,'');"
				style="float: left; margin: 0 0 0 90px;"/>

		</form>

	</div>
	<div class="modal-footer">
		<button type="button" data-dismiss="modal" class="btn" onClick="$('#result').empty();"> Закрыть</button>
	</div>
</div>

<?

// <!-- СООБЩЕНИЕ ОБ ОШИБКЕ-->

if (isset($_SESSION['err_msg']))
	{
		?>
		<script type='text/javascript'>
			dhtmlx.message.expire = 6000; // время жизни сообщения
			dhtmlx.message({ type: 'error', text: 'Ошибка!<br><?=$_SESSION['err_msg']?>'});
			<!--			humane.error('Ошибка!<br>--><?//=$_SESSION['err_msg']?><!--')-->
		</script>
		<?
		unset($_SESSION['err_msg']);
	}


// <!-- СООБЩЕНИЕ О УПЕШНОМ ЗАВЕРШЕНИИ-->

if (isset($_SESSION['ok_msg']))
	{
		?>
		<script type='text/javascript'>
			dhtmlx.message.expire = 6000;
			humane.success("Добро пожаловать, <?=$_SESSION['us_name']?>!<br><span><?=$_SESSION['ok_msg']?></span>");
		</script>
		<?
		unset($_SESSION['ok_msg']);
	}


if (isset($_SESSION['ok_msg2']))
	{
		?>
		<script type='text/javascript'>
			$(document).ready(function () {
				dhtmlx.message({ type: 'warning', text: <?=$_SESSION['ok_msg2'] ?>});
			});
			/*function redirect() {
			 window.document.location.href = '<?=$back?>'
			 }
			 setTimeout('redirect()', 3000);*/
		</script>
		<?
		//	unset($_SESSION['ok_msg2']);
	}
?>



<div id="fixed_menu">
	<div id="main_menu" data-spy="affix" data-offset-top="210">


		<?

		$value = $_SERVER['PHP_SELF'];
		if ($_SERVER['PHP_SELF'] == '/fotobanck.php')
			{
				$value = '/fotobanck.php?unchenge_cat';
			}

		if ($value == '/index.php')
			{
				$act_ln = 'gl_act';
				$key    = 'Главная';
				echo "
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
			}
		elseif ($value == '/fotobanck.php?unchenge_cat')
			{
				$act_ln = 'fb_act';
				$key    = 'Фото-банк';
				echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
			}
		elseif ($value == '/uslugi.php')
			{
				$act_ln = 'usl_act';
				$key    = 'Услуги';
				echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
			}
		elseif ($value == '/ceny.php')
			{
				$act_ln = 'cn_act';
				$key    = 'Цены';
				echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
			}
		elseif ($value == '/kontakty.php')
			{
				$act_ln = 'konty_act';
				$key    = 'Контакты';
				echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
			}
		elseif ($value == '/gb/index.php')
			{
				$act_ln = 'gb_act';
				$key    = 'Гостевая';
				echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a href='$value' class='$act_ln'>$key</a>";
			}
		elseif ($value == '/registr.php' or'/activation.php')
			{
				$act_ln = 'gb_act';
				$key    = 'Гостевая';
				echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
			}
		?>

		<object width="90" height="90" style="position: absolute; margin-left: 135px; margin-top: 26px; width: 70px; height: 80px; z-index:10;"
			type="application/x-shockwave-flash" data="/img/calendarb.swf">
			<param name="movie" value="img/calendar2b.swf"/>
			<param name="wmode" value="transparent"/>
		</object>


	</div>
</div>

</div>


<script language=JavaScript type="text/javascript">
	/* $(document).ready(function () {
	 *//*$('#fixed_menu').on('mouseenter', function(){
	 $('#main_menu').show();
	 });*//*
	 *//*$(input('.affix').on('change', function () {
	 alert('Вы нажали на элемент foo2')
	 }));*//*
	 });*/

	/* idleTimer = null;
	 idleState = false; // состояние отсутствия
	 idleWait = 2000; // время ожидания в мс. (1/1000 секунды)

	 $(document).ready( function(){
	 $('#show_menu').on('mouseenter', function(){
	 clearTimeout(idleTimer); // отменяем прежний временной отрезок
	 if(idleState == true){
	 // Действия на возвращение пользователя
	 $("#fixed_menu").animate({height: "show"}, 1000);
	 }

	 idleState = false;
	 idleTimer = setTimeout(function(){
	 // Действия на отсутствие пользователя
	 $("#fixed_menu").animate({height: "hide"}, 1000);
	 idleState = true;
	 }, idleWait);
	 });

	 $("#fixed_menu").trigger("mouseenter"); // сгенерируем ложное событие, для запуска скрипта
	 });*/


	/*(function($){
	 $('#show_menu').mouseleave(function(e) {
	 $('#fixed_menu').fadeIn();
	 });
	 $('#fixed_menu').mouseleave(function(e) {
	 $(this).fadeOut();
	 });
	 })(jQuery)*/

</script>


<!--Голова конец-->


<?


if ($value == '/gb/index.php'): ?>
<div id="main">
	<table width=<?= $TABWIDTH ?> border=2 cellspacing=0 cellpadding=2>
		<tr>
			<td>
				<table width=100% border=2 cellspacing=1 cellpadding=3 bgcolor=<?=$BORDER?>>
					<tr>
						<td align=center class=pdarkhead bgcolor=<?=$DARK?>><b><?=$gname?></b></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<? endif; ?>    