<?
set_time_limit(0);
include __DIR__.'/../inc/config.php';
include __DIR__.'/../inc/func.php';

error_reporting(E_ALL);

	// обработка ошибок
	include __DIR__.'/../inc/lib_mail.php';
	include __DIR__.'/../inc/lib_ouf.php';
	include __DIR__.'/../inc/lib_errors.php';
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


	/*if (isset($_SESSION['us_name']) && $_SESSION['us_name'] == 'test')
		{*/
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$start = $time;
			?>
			<h2><< DEBUG >> </h2>
			<div class="ttext_orange" style="position:relative">
				Используемая память в начале: <?=intval(memory_get_usage() / 1024)?> Кбайт.
				<hr class="style-one" style=" margin-bottom: 0px; margin-top: 10px"/>
			</div>
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
//		}


//Логин
if(isset($_POST['op']))
{
	if($_POST['op'] == 'out')
	{
		unset($_SESSION['admin_logged']);
		session_destroy();
  	main_redir('index.php');
	}
	else
	{
    //Вот тут прописываем логин и пароль админа!
    if($_POST['login'] == 'Photomas123' && $_POST['pass'] == 'Ht45Fd76S98K23')
    {
    	$_SESSION['admin_logged'] = true;
    	main_redir('index.php');
    }
  }
}

//Страницы
if(isset($_GET['page']))
{
	$_SESSION['page'] = intval($_GET['page']);
	if($_SESSION['page'] < 1 || $_SESSION['page'] > 8) $_SESSION['page'] = 1;
}
if(!isset($_SESSION['page']) || $_SESSION['page'] < 1 || $_SESSION['page'] > 8) $_SESSION['page'] = 1;

/*header('Content-type: text/html; charset=windows-1251');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
 header("Last-Modified: Mon, 26 Jul 2997 05:00:00 GMT");
 header("Cache-Control: no-cache, must-revalidate");
 header("Cache-Control: post-check=0,pre-check=0");
 header("Cache-Control: max-age=0");
 header("Pragma: no-cache");*/
?>
<!DOCTYPE html>
<html>
<head>
<title>Админка</title>

<link rel="shortcut icon" href="/img/ico_nmain.gif" />
<link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
<link href="/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
<!--<link rel="stylesheet" href="/css/main.css" type="text/css" />-->
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>


<link href="/css/animate.css" rel="stylesheet" type="text/css"/>
<link href="/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<script src="/js/bootstrap-modalmanager.js"></script>
<script src="/js/bootstrap-modal.js"></script>

<!-- TinyMCE -->
<!--
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
-->
<!-- /TinyMCE -->
 <!--
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
<!--
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

<script src="/ckfinde/ckeditor.js"></script>
<script src="/ckfinder/ckfinder.js"></script>



<style type="text/css">

body {
    background: #efefef;
}

input[type=checkbox] {
    visibility: hidden;
}


    /* SLIDE THREE */
.slideThree {
    width: 80px;
    height: 26px;
    background: #08009a;
    margin: -3px 10px 0 7px;
    float: left;

    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    border-radius: 50px;
    position: relative;

    -webkit-box-shadow: inset 4px 4px 4px rgba(0, 1, 84, 0.73), 0px 1px 0px rgba(41, 0, 224, 0.67);
    -moz-box-shadow: inset 4px 4px 4px rgba(0, 1, 84, 0.73), 0px 1px 0px rgba(41, 0, 224, 0.67);
    box-shadow: inset 4px 4px 4px rgba(0, 1, 84, 0.73), 0px 1px 0px rgba(41, 0, 224, 0.67);
}

.slideThree:after {
    content: 'OFF';
    font: 12px/26px Arial, sans-serif;
    color: #fe6769;
    position: absolute;
    right: 10px;
    z-index: 0;
    font-weight: bold;
    text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.44);
}

.slideThree:before {
    content: 'ON';
    font: 12px/26px Arial, sans-serif;
    color: #00bf00;
    position: absolute;
    left: 10px;
    z-index: 0;
    font-weight: bold;
    text-shadow: 1px 1px 0px rgba(0, 0, 0, 0.61);
}

.slideThree label {
    display: block;
    width: 34px;
    height: 20px;

    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    border-radius: 50px;

    -webkit-transition: all .4s ease;
    -moz-transition: all .4s ease;
    -o-transition: all .4s ease;
    -ms-transition: all .4s ease;
    transition: all .4s ease;
    cursor: pointer;
    position: absolute;
    top: 3px;
    left: 3px;
    z-index: 1;

    -webkit-box-shadow: 0px 2px 5px 0px rgba(105, 105, 105, 0.12);
    -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
    box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
    background: #fcfff4;

    background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #9faa99 100%);
    background: -moz-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #9faa99 100%);
    background: -o-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #9faa99 100%);
    background: -ms-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #9faa99 100%);
    background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #9faa99 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
}

.slideThree input[type=checkbox]:checked + label {
    left: 43px;
}

</style>




</head>
<body style="margin-left: 20px;">
<?

  if(isset($err_msg))
  {
  	?>
  	<div style="text-align: center; color: #FF0000; background-color: #000000; padding: 5px; border: 1px solid #FF0000; border-radius: 10px;">
  	  <?=$err_msg ?>
  	</div>
  	<?
  }
?>
<? if(isset($_SESSION['admin_logged'])): ?>
<!-- СОБСТВЕННО АДМИНКА -->
<table border="0px" style="margin-left: 40px;">
<tr>
  <td>
    <form action="index.php" method="post">
    <input type="submit" value="Выйти" class="btn btn-danger">
    <input type="hidden" name="op" value="out">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="Альбомы" class="<? echo $_SESSION['page'] == 1 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="1">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="Фото" class="<? echo $_SESSION['page'] == 2 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="2">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="Пользователи" class="<? echo $_SESSION['page'] == 3 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="3">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="Заказы" class="<? echo $_SESSION['page'] == 4 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="4">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="Категории" class="<? echo $_SESSION['page'] == 5 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="5">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="Настройки" class="<? echo $_SESSION['page'] == 6 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="6">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="Контент" class="<? echo $_SESSION['page'] == 7 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="7">
    </form>
  </td>
	<td>
		<form action="index.php" method="get">
			<input type="submit" value="eXtplorer" class="<? echo $_SESSION['page'] == 8 ? 'btn btn-success' : 'btn btn-primary';?>">
			<input type="hidden" name="page" value="8">
		</form>
	</td>
</tr>
</table>
<hr>
<?
switch($_SESSION['page'])
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
<? endif; ?>
</body>
</html>
<?
mysql_close();
?>