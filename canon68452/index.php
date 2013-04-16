<?
	set_time_limit(0);
	include __DIR__.'/../inc/config.php';
	include __DIR__.'/../inc/func.php';
	//Логин
	if (isset($_POST['op']))
		{
			if ($_POST['op'] == 'out')
				{
					unset($_SESSION['admin_logged']);
					session_destroy();
					main_redir('index.php');
				}
			else
				{
					//Вот тут прописываем логин и пароль админа!
					if ($_POST['login'] == 'Photomas123' && $_POST['pass'] == 'Ht45Fd76S98K23')
						{
							$_SESSION['admin_logged'] = true;
							main_redir('index.php');
						}
				}
		}
	header('Content-type: text/html; charset=windows-1251');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: Mon, 26 Jul 2997 05:00:00 GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Cache-Control: post-check=0,pre-check=0");
	header("Cache-Control: max-age=0");
	header("Pragma: no-cache");

?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//RU" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>


	<title>Админка</title>

	<?


	//error_reporting(E_ALL);

	// обработка ошибок
	include __DIR__.'/../inc/lib_mail.php';
	include __DIR__.'/../inc/lib_ouf.php';
	include __DIR__.'/../inc/lib_errors.php';
	$error_processor = Error_Processor::getInstance();


	/**
	 *  Тесты для проверки Error_Processor
	 * PHP set_error_handler TEST
	 */
	// 	IMAGINE_CONSTANT;
	/**
	 * PHP set_exception_handler TEST
	 */
	//   throw new Exception( 'Imagine Exception' );
	/**
	 * PHP register_shutdown_function TEST ( IF YOU WANT TEST THIS, DELETE PREVIOUS LINE )
	 */
	//	 	imagine_function( );

	$start = '';

	if (isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true)
		{
			$time  = microtime();
			$time  = explode(' ', $time);
			$time  = $time[1] + $time[0];
			$start = $time;
			?>
			<h2>&laquo; DEBUG &raquo; </h2>
			<div class="ttext_orange" style="position:relative">
				Используемая память в начале: <?=intval(memory_get_usage() / 1024)?> Кбайт.
				<hr class="style-one" style=" margin-bottom: 0; margin-top: 10px"/>
			</div>
		<?
		}


	//Страницы
	if (isset($_GET['page']))
		{
			$_SESSION['page'] = intval($_GET['page']);
			if ($_SESSION['page'] < 1 || $_SESSION['page'] > 8)
				{
					$_SESSION['page'] = 1;
				}
		}
	if (!isset($_SESSION['page']) || $_SESSION['page'] < 1 || $_SESSION['page'] > 8)
		{
			$_SESSION['page'] = 1;
		}


	?>

	<link rel="shortcut icon" href="/img/ico_nmain.gif"/>
	<link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
	<link href="/css/bootstrap-responsive.css" rel="stylesheet" type="text/css"/>
	<!--<link rel="stylesheet" href="/css/main.css" type="text/css" />-->
	<link rel="stylesheet" href="/css/dynamic-to-top.css" type="text/css"/>
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<link href="/css/admin.css" rel="stylesheet" type="text/css"/>


	<link href="/css/animate.css" rel="stylesheet" type="text/css"/>
	<link href="/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
	<script src="/js/bootstrap-modalmanager.js"></script>
	<script src="/js/bootstrap-modal.js"></script>

	<!-- TinyMCE --><!--
<script type="text/javascript" src="/js/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
		// General options
		mode : "exact",
		elements : "content",
		theme : "advanced",
		language : "ru",
		skin : "o2k7",
		skin_variant : "silver",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave,imagemanager,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks,insertimage",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
        
		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "/css/main.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
--><!-- /TinyMCE --><!--
<script type="text/javascript" src="/js/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({    
        
        language : "en",
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver"        

});
</script>
--><!--
<script type="text/javascript" src="/js/tinymce/tiny_mce.js"></script>

<script type="text/javascript">
tinyMCE.init({    
        
        language : "ru",
        // General options
        mode : "exact",
		elements : "content",
        theme : "advanced",       
		plugins :        "spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
		
		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "/css/main.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

        // Skin options
        skin : "o2k7",
        skin_variant : "silver"        

});
</script>
-->

	<script src="./../ckeditor/ckeditor.js"></script>
	<script src="./../ckfinder/ckfinder.js"></script>


	</head>
	<div class="wrapper">
	<body style="margin-left: 20px;">
	<?


	function paginator($record_count, $pg)
		{

			/** @var $record_count  Количество фотографий в альбоме */
			if (isset($record_count))
				{
					if ($record_count > RECORDS_PER_PAGE)
						{
							$page_count = ceil($record_count / RECORDS_PER_PAGE);
							for ($i = 1; $i <= $page_count; $i++)
								{
									?>
									<!-- ПОСТРАНИЧНАЯ РАЗБИВКА -->
									<div style="float: left"><h4><a id="home">Страница <?=$pg?></a></h4></div>
									<div class="pagination">
										<?
										if ($pg == 1)
											{
												?>
												<span class="disabled">« </span>
												<span class="disabled">« Предыдущая</span>
											<?
											}
										else
											{
												?>
												<a class="next" href="index.php?pg=1">« </a>
												<a class="next" href="index.php?pg=<?= ($pg - 1) ?>">« Предыдущая</a>
											<?
											}
										for ($i = 1; $i <= $page_count; $i++)
											{
												if ($i == $pg)
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
														<a href="index.php?pg=<?= $i ?>"><?=$i?></a>
													<?
													}
											}
										if ($pg == $page_count)
											{
												?>
												<span class="disabled">Следующая »</span>
												<span class="disabled">Посл. »</span>
											<?
											}
										if ($pg < $page_count)
											{
												?>
												<a class="next" href="index.php?pg=<?= $pg + 1 ?>">Следующая »</a>
												<a class="next" href="index.php?pg=<?= $page_count ?>">»</a>
											<?
											}
										?>
									</div>
									<div style="float: left"><h4><a id="home">всего - <?=$record_count?> шт.</a></h4></div>
									<div style="clear: both;"></div>
								<?
								}
						}
				}
		}


	if (isset($err_msg))
		{
			?>
			<div style="text-align: center; color: #FF0000; background-color: #000000; padding: 5px; border: 1px solid #FF0000; border-radius: 10px;">
				<?=$err_msg ?>
			</div>
		<?
		}
	?>
	<? if (isset($_SESSION['admin_logged'])): ?>
		<!-- СОБСТВЕННО АДМИНКА -->
		<table border="0px" style="margin-left: 40px;">
			<tr>
				<td>
					<form action="index.php" method="post">
						<input type="submit" value="Выйти" class="btn btn-danger"> <input type="hidden" name="op" value="out">
					</form>
				</td>
				<td>
					<form action="index.php" method="get">
						<input type="submit" value="Альбомы" class="<? echo $_SESSION['page'] == 1 ? 'btn btn-success' : 'btn btn-primary'; ?>">
						<input type="hidden" name="page" value="1">
					</form>
				</td>
				<td>
					<form action="index.php" method="get">
						<input type="submit" value="Фото" class="<? echo $_SESSION['page'] == 2 ? 'btn btn-success' : 'btn btn-primary'; ?>">
						<input type="hidden" name="page" value="2">
					</form>
				</td>
				<td>
					<form action="index.php" method="get">
						<input type="submit" value="Пользователи" class="<? echo $_SESSION['page'] == 3 ? 'btn btn-success' : 'btn btn-primary'; ?>">
						<input type="hidden" name="page" value="3">
					</form>
				</td>
				<td>
					<form action="index.php" method="get">
						<input type="submit" value="Заказы" class="<? echo $_SESSION['page'] == 4 ? 'btn btn-success' : 'btn btn-primary'; ?>">
						<input type="hidden" name="page" value="4">
					</form>
				</td>
				<td>
					<form action="index.php" method="get">
						<input type="submit" value="Категории" class="<? echo $_SESSION['page'] == 5 ? 'btn btn-success' : 'btn btn-primary'; ?>">
						<input type="hidden" name="page" value="5">
					</form>
				</td>
				<td>
					<form action="index.php" method="get">
						<input type="submit" value="Настройки" class="<? echo $_SESSION['page'] == 6 ? 'btn btn-success' : 'btn btn-primary'; ?>">
						<input type="hidden" name="page" value="6">
					</form>
				</td>
				<td>
					<form action="index.php" method="get">
						<input type="submit" value="Контент" class="<? echo $_SESSION['page'] == 7 ? 'btn btn-success' : 'btn btn-primary'; ?>">
						<input type="hidden" name="page" value="7">
					</form>
				</td>
				<td>
					<form action="index.php" method="get">
						<input type="submit" value="eXtplorer" class="<? echo $_SESSION['page'] == 8 ? 'btn btn-success' : 'btn btn-primary'; ?>">
						<input type="hidden" name="page" value="8">
					</form>
				</td>
			</tr>
		</table>
		<hr>
		<?
		switch ($_SESSION['page'])
		{
			default:
			case 1:
					include 'album.php';
					break;
			case 2:
					include 'photo.php';
					break;
			case 3:
					include 'users.php';
					break;
			case 4:
					include 'orders.php';
					break;
			case 5:
					include 'categories.php';
					break;
			case 6:
					include 'nastr.php';
					break;
			case 7:
					include 'content.php';
					break;
			case 8:
					include 'manager.php';
					break;
		}
		?>

	<? else: ?>
		<!-- ФОРМА ЛОГИНА -->
		<form action="index.php" method="post">
			<table border="0">
				<tr>
					<td>Логин</td>
					<td><input type="text" name="login" value=""></td>
				</tr>
				<tr>
					<td>Пароль</td>
					<td><input type="password" name="pass" value=""></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="submit" value="Войти"></td>
				</tr>
			</table>
			<input type="hidden" name="op" value="in">
		</form>


		<div class="row">
			<div class="span4 offset4">
				<div class="well">
					<legend>Sign in to WebApp</legend>
					<form method="POST" action="" accept-charset="UTF-8">
						<div class="alert alert-error">
							<a class="close" data-dismiss="alert" href="#">x</a>Incorrect Username or Password!
						</div>
						<input class="span3" placeholder="Username" type="text" name="username">
						<input class="span3" placeholder="Password" type="password" name="password"> <label class="checkbox">
							<input type="checkbox" name="remember" value="1"> Remember Me </label>
						<button class="btn-info btn" type="submit">Login</button>
					</form>
				</div>
			</div>
		</div>

	<? endif;?>

	<a id="dynamic_to_top" href="#" style="display: inline;"> <span> </span> </a>
	<script type='text/javascript' src='/js/jquery.easing.1.3.js'></script>
	<script type='text/javascript'>
		/* <![CDATA[ */
		var mv_dynamic_to_top = {"text": "0", "version": "0", "min": "200", "speed": "1000", "easing": "easeInOutExpo", "margin": "20"};
		/* ]]> */
	</script>
	<script type='text/javascript' src='./../js/dynamic.to.top.dev.js'></script>

	</body>
	</div>
	<?
	if ((isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true))
		{
			?>
			<div style="position:relative; margin-top: 20px;">
				<div style="clear: both"></div>
				<?
				/**
				 * $actions - переменная String с действиями:
				 * '' - добавление ошибок в список ошибок,
				 * 'w' - пишет сообщение об ошибке на экран,
				 * 'а' - выводит список всех сообщений на экран,
				 * "d" - очищает стек ошибки,
				 * 's' - остановить исполнение,
				 * 'l' - пишет log,
				 * 'm' - отправляет по электронной почте (значения могут быть объединены, например: 'ws')
				 */
				//	$error_processor->err_proc("" , "w", $error_processor->error);
				$error_processor->err_proc("", "w", "");
				//	$error_processor->err_proc("", "am", "");
				?>
				<br> Память в конце: <?=intval(memory_get_usage() / 1024)?> Кбайт;
				Пик: <?=intval(memory_get_peak_usage() / 1024)?> Кбайт;
				<?
				$time = microtime();
				$time = explode(' ', $time);
				$time = $time[1] + $time[0];
				$finish = $time;
				$total_time = round(($finish - $start), 4);
				echo ' Страница сгенерированна за: '.$total_time.' секунд.'."\n";
				?>
			</div>
		<?
		}
	?>
	<div class="footer">
		<div style="padding-top: 13px; padding-left: 42%;">
			<hfooter> Creative ls &copy; 2013</hfooter>
		</div>
		<div id="foot_JavaScript" style="position:relative;left:10px;top:13px;width:269px;height:25px;z-index:10;">
			<div style="color:#000;font-size:10px;font-family:Verdana,sans-serif;font-weight:normal;font-style:normal;text-decoration:none" id="copyrightnotice"></div>
			<script type="text/javascript">
				var now = new Date();
				var startYear = "1995";
				var text = "Copyright &copy; ";
				if (startYear != '') {
					text = text + startYear + "-";
				}
				text = text + now.getFullYear() + ", www.aleks.od.ua";
				var copyrightnotice = document.getElementById('copyrightnotice');
				copyrightnotice.innerHTML = text;
			</script>
		</div>

	</div>

	</html>
<?
	mysql_close();
?>