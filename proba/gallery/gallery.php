<? //require_once("start.php"); - подключаем БД ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link href="css/reset.css" rel="stylesheet" type="text/css">
<link href="css/styles.css" rel="stylesheet" type="text/css">
	<style type="text/css" media="screen">
		/*
			Load CSS before JavaScript
		*/
		
		/*
			Slides container
			Important:
			Set the width of your slides container
			Set to display none, prevents content flash
		*/
		#slides { width:1000px; margin:0 auto; }
		.slides_container {
			width:950px;
			display:none;
			margin:0 auto;
		}

		/*
			Each slide
			Important:
			Set the width of your slides
			If height not specified height will be set by the slide content
			Set to display block
		*/
		.slides_container div {
			width:960px;
			height:840px;
			display:block;
			margin:0 auto;
		}
		
		.slides_container div img {
			border:#FFF 8px solid;
			margin:35px;
		}
		.slides_container div table {
			margin:0 auto;
		}
	</style>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="js/slides.min.jquery.js"></script>
		<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>

	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>

	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

	<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				pagination: false,
				generatePagination: false,
				next: 'next',
				prev: 'prev'
			});
		$("a.gallery").fancybox({
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	true
		});

		});
	</script>
<title>Gallery</title>
</head>
<body>
<div id="page"><br />
<div style="margin:0 auto; width:372px;"><a href="index.html"><img src="logo2.png" /></a></div>

	<div id="slides">
    <table><tr><td style="padding:10px; vertical-align:middle;"><a href="#" class="prev"><img src="prev.png" /></a></td><td>
		<div class="slides_container">
        <?
			$gp=mysql_query("select * from photos where order by ord");
			$i=1;
			$allcl=true;
			while($pho = mysql_fetch_array($gp)){
				if ($i==1){ echo "<div><table><tr>"; $allcl=false; }
				echo "<td><a class=\"gallery\" rel=\"group\" title='{$pho['comment']}' href=\"upload/{$pho['big']}\"><img src=\"upload/{$pho['small']}\"></a></td>";
				
				if ($i%3==0){ echo "</tr><tr>"; }
				
				if ($i==9){ echo "</tr></table></div>"; $i=0; $allcl=true; }
				$i++;
			}
			if (!$allcl) echo "</table></div>";
		?>
		</div>
        </td><td style="padding:10px; vertical-align:middle;">
            <a href="#" class="next"><img src="next.png" /></a>
            </td></tr></table>
	</div>

<div style="margin:0 auto; width:800px;">
    <a href="about.html"><img src="menu_01.png" /></a>
    <a href="bio.html"><img src="menu_03.png" /></a>
    <a href="ex.php"><img src="menu_04.png" /></a>
    <a href="contacts.php"><img src="menu_05.png" /></a>			
</div><br /><br />&nbsp;
</div> 
</body>
</html>
