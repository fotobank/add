<?
set_time_limit(0);
include __DIR__.'/../inc/config.php';
include __DIR__.'/../inc/func.php';


	//�����
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
					//��� ��� ����������� ����� � ������ ������!
					if($_POST['login'] == 'Photomas123' && $_POST['pass'] == 'Ht45Fd76S98K23')
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




	<title>�������</title>

<?


//error_reporting(E_ALL);

	// ��������� ������
	include __DIR__.'/../inc/lib_mail.php';
	include __DIR__.'/../inc/lib_ouf.php';
	include __DIR__.'/../inc/lib_errors.php';
	$error_processor = Error_Processor::getInstance();


	/**
	 *  ����� ��� �������� Error_Processor
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
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$start = $time;
			?>
			<h2>&laquo; DEBUG &raquo; </h2>
			<div class="ttext_orange" style="position:relative">
				������������ ������ � ������: <?=intval(memory_get_usage() / 1024)?> �����.
				<hr class="style-one" style=" margin-bottom: 0; margin-top: 10px"/>
			</div>
			<?
		}


//��������
if(isset($_GET['page']))
{
	$_SESSION['page'] = intval($_GET['page']);
	if($_SESSION['page'] < 1 || $_SESSION['page'] > 8) $_SESSION['page'] = 1;
}
if(!isset($_SESSION['page']) || $_SESSION['page'] < 1 || $_SESSION['page'] > 8) $_SESSION['page'] = 1;


?>

<link rel="shortcut icon" href="/img/ico_nmain.gif" />
<link rel="stylesheet" href="/css/bootstrap.css" type="text/css" />
<link href="/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
<!--<link rel="stylesheet" href="/css/main.css" type="text/css" />-->
<link rel="stylesheet" href="/css/dynamic-to-top.css" type="text/css" />
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

<script src= "./../ckeditor/ckeditor.js"></script>
<script src="./../ckfinder/ckfinder.js"></script>



<style type="text/css">

body {
    background: #efefef;
	height: 100%;
	width: 100%;
	margin: 0;
	padding: 0;
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

    -webkit-box-shadow: inset 4px 4px 4px rgba(0, 1, 84, 0.73), 0 1px 0 rgba(41, 0, 224, 0.67);
    -moz-box-shadow: inset 4px 4px 4px rgba(0, 1, 84, 0.73), 0 1px 0 rgba(41, 0, 224, 0.67);
    box-shadow: inset 4px 4px 4px rgba(0, 1, 84, 0.73), 0 1px 0 rgba(41, 0, 224, 0.67);
}

.slideThree:after {
    content: 'OFF';
    font: 12px/26px Arial, sans-serif;
    color: #fe6769;
    position: absolute;
    right: 10px;
    z-index: 0;
    font-weight: bold;
    text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.44);
}

.slideThree:before {
    content: 'ON';
    font: 12px/26px Arial, sans-serif;
    color: #00bf00;
    position: absolute;
    left: 10px;
    z-index: 0;
    font-weight: bold;
    text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.61);
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

    -webkit-box-shadow: 0 2px 5px 0 rgba(105, 105, 105, 0.12);
    -moz-box-shadow: 0 2px 5px 0 rgba(0,0,0,0.3);
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.3);
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

hfooter {
	position: absolute;
	padding: 2px 20px;
	color: #007;
	background-color: #dbdbdb;
	border: 1px solid #9d9da4;
	font-family: "Times New Roman", Times, serif;
	text-shadow: 1px 1px 1px #888888;
	font-size: 20px;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	box-shadow: 0 0 8px 1px #adadad, 0 0 2px rgba(199, 199, 199, 0.88) inset;
	clear: both;
}

div.pagination {
	padding:3px;
	margin: 10px 0 -40px 0;
	text-align:center;
	z-index: 10;

}

div.pagination a, div.page a {
	padding: 2px 5px 2px 5px;
	margin-right: 2px;
	border: 1px solid #2C2C2C;
	text-decoration: none;
	color: #fff;
	background: #2C2C2C url(/img/image1.gif);
}

div.pagination a:hover, div.pagination a:active,div.page a:hover, div.page a:active {
	border:1px solid #AAD83E;
	color: #FFF;
	background: #AAD83E url(/img/image2.gif);
}

div.pagination span.current, div.page span.current {
	padding: 2px 5px 2px 5px;
	margin-right: 2px;
	border: 1px solid #AAD83E;
	font-weight: bold;
	background: #AAD83E url(/img/image2.gif);
	color: #FFF;
}

div.pagination span.disabled, div.page span.disabled {
	padding: 2px 5px 2px 5px;
	margin-right: 2px;
	border: 1px solid #f3f3f3;
	color: #ccc;
}

</style>

</head>
<body style="margin-left: 20px;">
<?


function paginator($record_count, $pg)
	{
		/** @var $record_count  ���������� ���������� � ������� */
		if (isset($record_count))
			{
				if ($record_count > RECORDS_PER_PAGE)
					{

						$page_count = ceil($record_count / RECORDS_PER_PAGE);
						for ($i = 1; $i <= $page_count; $i++)
							{
								?>

								<!-- ������������ �������� -->
								<h4><a id="home" style="float: left">�������� <?=$pg?></a></h4>
								<div class="pagination" align="center">
									<?
									if ($pg == 1)
										{
											?>
											<span class="disabled">� </span>
											<span class="disabled">� ����������</span>
										<?
										}
									else
										{
											?>
											<a class="next" href="index.php?pg=1">� </a>
											<a class="next" href="index.php?pg=<?= ($pg - 1) ?>">� ����������</a>
										<?
										}
									for ($i = 1; $i <= $page_count; $i++)
										{
											if ($i == $pg)
												{
													//������� ��������
													?>
													<span class="current"><?=$i?></span>
												<?
												}
											else
												{
													//������ �� ������ ��������
													?>
													<a href="index.php?pg=<?= $i ?>"><?=$i?></a>
												<?
												}
										}
									if ($pg == $page_count)
										{
											?>
											<span class="disabled">��������� �</span>
											<span class="disabled">����. �</span>
										<?
										}
									if ($pg < $page_count)
										{

											?>
											<a class="next" href="index.php?pg=<?= $pg + 1 ?>">��������� �</a>
											<a class="next" href="index.php?pg=<?= $page_count ?>">�</a>
										<?
										}
									?>
								</div>
								<h4><a id="home" style="float: right">����� - <?=$record_count?> ��.</a></h4>
								<div style="clear: both;"></div>
							<?
							}
					}
			}
	}


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
<!-- ���������� ������� -->
<table border="0px" style="margin-left: 40px;">
<tr>
  <td>
    <form action="index.php" method="post">
    <input type="submit" value="�����" class="btn btn-danger">
    <input type="hidden" name="op" value="out">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="�������" class="<? echo $_SESSION['page'] == 1 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="1">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="����" class="<? echo $_SESSION['page'] == 2 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="2">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="������������" class="<? echo $_SESSION['page'] == 3 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="3">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="������" class="<? echo $_SESSION['page'] == 4 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="4">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="���������" class="<? echo $_SESSION['page'] == 5 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="5">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="���������" class="<? echo $_SESSION['page'] == 6 ? 'btn btn-success' : 'btn btn-primary';?>">
    <input type="hidden" name="page" value="6">
    </form>
  </td>
  <td>
    <form action="index.php" method="get">
    <input type="submit" value="�������" class="<? echo $_SESSION['page'] == 7 ? 'btn btn-success' : 'btn btn-primary';?>">
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
<!-- ����� ������ -->
<form action="index.php" method="post">
  <table border="0">
  <tr>
    <td>�����</td>
    <td><input type="text" name="login" value=""></td>
  </tr>
  <tr>
    <td>������</td>
    <td><input type="password" name="pass" value=""></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" value="�����"></td>
  </tr>
  </table>
  <input type="hidden" name="op" value="in">
</form>
<? endif;



	if ((isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] == true))
	{
?>
<div style="position:relative; margin-top: 50px;">
<?
/**
 * $actions - ���������� String � ����������:
 * '' - ���������� ������ � ������ ������,
 * 'w' - ����� ��������� �� ������ �� �����,
 * '�' - ������� ������ ���� ��������� �� �����,
 * "d" - ������� ���� ������,
 * 's' - ���������� ����������,
 * 'l' - ����� log,
 * 'm' - ���������� �� ����������� ����� (�������� ����� ���� ����������, ��������: 'ws')
 */
//	$error_processor->err_proc("" , "w", $error_processor->error);
$error_processor->err_proc("", "w", "");
//	$error_processor->err_proc("", "am", "");
	?>
		<br>
		������ � �����: <?=intval(memory_get_usage()/1024)?> �����;
		���: <?=intval(memory_get_peak_usage()/1024)?> �����;
		<?
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		echo ' �������� �������������� ��: '.$total_time.' ������.'."\n";

		?>
	</div>

	<script type='text/javascript' src='/js/jquery.easing.1.3.js'></script>
	<script type='text/javascript'>
		/* <![CDATA[ */
		var mv_dynamic_to_top = {"text":"0","version":"0","min":"200","speed":"1000","easing":"easeInOutExpo","margin":"20"};
		/* ]]> */
	</script>
	<script type='text/javascript' src='./../js/dynamic.to.top.dev.js'></script>
	<a id="dynamic_to_top" href="#" style="display: inline;">
		<span> </span>
	</a>


<div id="footer">
	<div style="padding-top: 13px; padding-left: 42%;">
		<hfooter> Creative ls &copy; 2013</hfooter>
	</div>
	<div id="foot_JavaScript" style="position:relative;left:10px;top:13px;width:269px;height:25px;z-index:10;">
		<div style="color:#000;font-size:10px;font-family:Verdana,sans-serif;font-weight:normal;font-style:normal;text-decoration:none" id="copyrightnotice">
		</div>
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
		<?
		}
	?>
</body>
</html>
<?
mysql_close();
?>