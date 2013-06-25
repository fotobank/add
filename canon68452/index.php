<?
	set_time_limit(0);
	include (dirname(__FILE__).'/../inc/config.php');
	include (dirname(__FILE__).'/../inc/func.php');
	//Логин
	if (isset($_POST['op']))
		{
			if ($_POST['op'] == 'out')
				{
					unset($_SESSION['admin_logged']);
				//	session_destroy();
				   destroySession();
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

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$time  = microtime();
	$time  = explode(' ', $time);
	$time  = $time[1] + $time[0];
	$startTime = $time;
	$startMem = intval(memory_get_usage() / 1024); //Используемая память в начале

	// обработка ошибок
	include (dirname(__FILE__).'/../inc/lib_mail.php');
	include (dirname(__FILE__).'/../inc/lib_ouf.php');
	include (dirname(__FILE__).'/../inc/lib_errors.php');
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


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//RU" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:Логин="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
<meta name="description" content="Админка сайта Creative L.S." />
<meta name="keywords" content="Управление сайта Creative L.S." />
<meta name="author" content="webmaster" />
<title>Админка</title>


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
	<script type="text/javascript" src="/canon68452/ajax/ajaxAdmin.js"></script>

		<script type="text/javascript">
		function confirmDelete() {
		return confirm("Вы подтверждаете удаление?");
		}
		</script>

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
-->

<script type="text/javascript" src="/js/tinymce/tiny_mce.js"></script>




		<!--<script type="text/javascript" src="/js/tinymce/tiny_mce.js"></script>-->
<script type="text/javascript">
tinyMCE.init({    
        
        language : "ru",
        // General options
        mode : "exact",
		elements : "content",
        theme : "advanced",

  inline_styles: true,
  remove_script_host : false,
  cleanup: false,
  extended_valid_elements:"noindex, strong/b,  em/i, sup, sub, ul, ol, li, div[class | id | style | name | title | align | width | height], span[class | id | style | name | title], hr[class | id | style | name | title | align | width | height], img[class | id | style | name | title | src | align | alt | hspace | vspace | width | height | border=0], a[class | id | style | name | title | src | href | rel | target | ], iframe[class | id | style | name | title | src | align | width | height | marginwidth | marginheight | scrolling | frameborder | border | bordercolor], embed[class | id | style | name | title | align | width | height | hspace | vspace | type | pluginspage | src], object[class | id | style | name | title | align | width | height | hspace | vspace | type | classid | code | codebase | codetype | data]",


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

	<!--<script src="./../ckeditor/ckeditor.js"></script>
	<script src="./../ckfinder/ckfinder.js"></script>-->

	</head>
	<body style="margin-left: 20px;">
	<div class="wrapper">
	<?


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

	<? else:?>

		<script type="text/javascript" src="/js/jquery.js"></script>
		<script type="text/javascript" src="/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/js/jquery.tools.min.js"></script>
		<link href="/css/admin.css" rel="stylesheet" type="text/css"/>

		<!--Выделение формы входа с затемнением-->
		<script type="text/javascript">
			// execute your scripts when the DOM is ready. this is a good habit
			$(function() {
				// expose the form when it's clicked
				$(" .well ").click(function() {
					$(this).expose({
						// custom mask settings with CSS
						maskId: 'mask',
						api: true
					}).load();
				});
			});
		</script>

			<div style="width:350px; height:200px; position:absolute; left:50%; top:50%; margin:-100px 0 0 -200px;">
				<div class="well">
					<legend>ВХОД В АДМИНКУ</legend>
					<form class="expose" method="POST" action="index.php" accept-charset="1251">
						<input class="inp_f_kont span2" data-tabindex="1" title="Ваш логин?" maxlength="20" style="margin-left: 8px; width: 250px"
							placeholder="Введите логин:" type="text" name="login">
						<input class="inp_f_kont span2" data-tabindex="2" title="Пароль?" maxlength="20" style="margin-left: 8px; width: 250px"
							placeholder="Введите пароль:" type="password" name="pass">
						<input type="hidden" name="op" value="in">
							<button class="btn-info btn" type="submit" value="Войти" style="float: right; margin-right: 20px; margin-top: 5px;">Войти</button>
						<label class="checkbox" style="width: 150px; margin-top: 20px; margin-left: -10px;"><input type="checkbox" name="remember" value="1"> Напомнить пароль </label>
				</form>
				</div>
			</div>
	<?
	endif;?>

	<a id="dynamic_to_top" href="#" style="display: inline;"> <span> </span> </a>
	<script type='text/javascript' src='/js/jquery.easing.1.3.js'></script>
	<script type='text/javascript'>
		/* <![CDATA[ */
		var mv_dynamic_to_top = {"text": "0", "version": "0", "min": "200", "speed": "1000", "easing": "easeInOutExpo", "margin": "20"};
		/* ]]> */
	</script>
	<script type='text/javascript' src='./../js/dynamic.to.top.dev.js'></script>
	</div>
	</body>
	<div id="end_content"></div>
	<?
	if ((isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true))
		{
			?>
			<div style="clear: both"></div>
			<div style="position:relative; margin: 0 0 -60px 0;">
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
			   Используемая память в начале: <?=$startMem?> Кбайт;
				Память в конце: <?=intval(memory_get_usage() / 1024)?> Кбайт;
				Пик: <?=intval(memory_get_peak_usage() / 1024)?> Кбайт;
				<?
				$time = microtime();
				$time = explode(' ', $time);
				$time = $time[1] + $time[0];
				$finishTime = $time;
				$total_time = round(($finishTime - $startTime), 4);
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
	$db->close();
?>