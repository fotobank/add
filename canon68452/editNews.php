<?
if (!isset($_SESSION['admin_logged'])) die();

if(isset($_POST['deleteNews']))
  {
	 $deleteNews = $_POST['deleteNews'];
	 $img = go\DB\query("SELECT `img` FROM `news` WHERE `id` = ?i",array($deleteNews),'el');
	 unlink($img);
	 go\DB\query("delete from `news` where `id` = ?i", array($deleteNews));
	 go\DB\query("delete from `komments` where `news_id` = ?i", array($deleteNews));
  }

if(isset($_POST['newNews']))
  {
	 $list    = array('','Новость', '', '', 'Юрий','',0,'','','',0,0,'c_colonka','главная');
	 $pattern = 'INSERT INTO `news` VALUES (?list)';
	 $data    = array($list);
	 $idNews  = go\DB\query($pattern, $data)->id();

	 echo "<script type='text/javascript'>
			 location.href = 'index.php?page=8&newsId='+$idNews;
			 </script>";
  }


?>
<script type="text/javascript" src="/inc/wp/ajaxPostNews.js"></script>
<?

define('RECORDS_PER_PAGE', 20);

require_once  ( __DIR__ . '/../canon68452/praide-analyser-cp-1251.php');
require_once  ( __DIR__ . '/../inc/wp/comments.php');



	function printPubl($newsId,$pg)
{
  $data = go\DB\query('SELECT * FROM `news` WHERE `id` = ?i',array($newsId),'row');
// инициализация переменных -------------------------------------------------------------------
  if (isset($_SESSION['location'])) unset($_SESSION['location']);
  $_SESSION['location'] = explode(',',$data['location']);
  if (isset($_SESSION['kolonka'])) unset($_SESSION['kolonka']);
  $_SESSION['kolonka'] = $data['kolonka'];
// -------------------------------------------------------------------------------------------
  ?>
  <div id="newsId-<?=$newsId?>" class="tab-pane 'active'">
  <table class="table table-condensed span12">
	 <thead>
	 <tr>
		<th style="width: 370px;">Редактор текста статьи</th>
		<th style="width: 230px;">Параметры</th>
		<th>Редактор коментариев</th>
	 </tr>
	 </thead>
	 <tbody>
	 <tr>
		<td >
		  <b>шапка статьи</b>
		  <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
			 <label>
				<textarea id="head" class="tinymce" name="head" cols="35" rows="12"><?=$data['head']?></textarea>
			 </label><br>
			 <b>тело статьи</b>
			 <label>
				<textarea id="body" class="tinymce" name="body" cols="35" rows="12"><?=$data['body']?></textarea>
			 </label>
			 Проверить на уникальность
			 <div class="slideThree">
				<input id="slideThree3" type='checkbox' NAME='unik' VALUE='1' /> <label for="slideThree3"></label>
			 </div>

			 <div class="linBlue"></div>
			 <input  type="hidden" name="newsId" value="<?=$data['id']?>"/>
			 <input class="btn btn-primary" type="submit" value="сохранить" />
		  </form>
		</td>
		<td valign="top" align="center">
		  <form style="width: 230px;" id="upload_form" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" onsubmit="return checkForm()">
			 Название
			 <label>
				<input type="text" name="name" value="<?=$data['name']?>"/>
			 </label>
			 <div class="linBlue"></div>
			 Автор публикации
			 <label>
				<input  type="text" name="avtor-pub" value="<?=$data['avtor-pub']?>" "/>
			 </label>
			 <div class="linBlue"></div>
			 <label>Страница:<br/>
				<input  type="hidden" name="location[]" value=NULL>
				<select name="location[]" multiple="multiple" size="1" class="multiselect">
				  <?
				  printSet ('news', 'location');
				  ?>
				</select>
			 </label>
			 <div class="linBlue"></div>
			 <label>Колонка:<br/>
				<select name="kolonka" class="multiselect">
				  <?
				  printEnum ('news', 'kolonka');
				  ?>
				</select>
			 </label>
			 <div class="linBlue"></div>
			 Картинка заголовка статьи
			 <ul class="thumbnails" style="margin-bottom: 0;">
				<li class="span2">
				  <div class="thumbnail">
					 <img src="<?=$data['img']?>?t=<?=time()?>" style="width: auto; height: auto;">
					 <div class="caption">
					 </div>
				</li>
			 </ul>
				<input type="hidden" id="x1" name="x1" />
				<input type="hidden" id="y1" name="y1" />
				<input type="hidden" id="x2" name="x2" />
				<input type="hidden" id="y2" name="y2" />
				<div><input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()"/></div>
				<div class="error"></div>
				<div class="step2">
				  <h2>Шаг2: Выберите регион обрезки</h2>
				  <img id="preview" style="width: 230px;"/>
				  <?
				  // загрузка картинки
				  if (isset($_POST['filedim'])) {
					 require_once  ( __DIR__ . '/../inc/cropUploader/thumbUploader.php');
					 $sImage = new ImageUploader();
					 $dir = './../reklama/thumb/'; // папка для загрузки
					 $sImage->upload($dir, 140, true);
					 $imgNews = $dir.'imgNews-'.trim($_POST['newsId']).'.jpg';
					 go\DB\query('UPDATE `news` SET `img` = ?  WHERE `id` = ?i', array($imgNews, $_POST['newsId']));
				  }
				  ?>
				  <div class="info">
					 <div class="input-prepend">
						<label class="add-on" for="filesize">Размер файла</label>
						<input class="span1" type="text" id="filesize" name="filesize" style="width: 80px; height: 25px;">
					 </div>
					 <div class="input-prepend">
						<label class="add-on" for="filetype">Тип</label>
						<input class="span1" type="text" id="filetype" name="filetype" style="width: 80px; height: 25px;">
					 </div> <div class="input-prepend">
						<label class="add-on" for="filedim">Размер изображения</label>
						<input class="span1" type="text" id="filedim" name="filedim" style="width: 80px; height: 25px;">
					 </div> <div class="input-prepend">
						<label class="add-on" for="w">W</label><input class="span1" type="text" id="w" name="w" style="width: 80px; height: 25px;">
					 </div> <div class="input-prepend">
						<label class="add-on" for="h">H</label>
						<input class="span1" type="text" id="h" name="h" style="width: 80px; height: 25px;">
					 </div>
				  </div>
				</div>


			 <div class="linBlue"></div>
			 <div>Отключить коментарии</div>
			 <div class="slideThree">
				<input type='hidden' NAME='komm' VALUE='0'>
				<input id="slideThree2" type='checkbox' NAME='komm' VALUE='1'
				 <?if ($data['komm'] == 1)
				  {
					 echo 'checked="checked"';
				  } ?> /> <label for="slideThree2"></label>
			 </div>
			 <div class="linBlue"></div>
			 <div>Отключить цитату</div>
			 <div class="slideThree">
				<input type='hidden' NAME='on-cit' VALUE='0'>
				<input id="slideThree1" type='checkbox' NAME='on-cit' VALUE='1'
				 <?if ($data['on-cit'] == 1)
				  {
					 echo 'checked="checked"';
				  } ?> /> <label for="slideThree1"></label>
			 </div><div style="clear: both"></div>
			 <div class="linBlue"></div>
			 Автор цитаты
			 <label>
				<input type="text" name="avtor-cit" value="<?=$data['avtor-cit']?>"/>
			 </label>
			 <div class="linBlue"></div>
			 Цитата
			 <label>
				<textarea style="width: 200px; height: 100px;" name="citata" cols="35" rows="12"><?=$data['citata']?></textarea>
			 </label>

			 <div class="linBlue"></div>
			 <input  type="hidden" name="newsId" value="<?=$data['id']?>"/>
			 <input class="btn btn-primary" type="submit" value="изменить" />
		  </form>
		<td valign="top">
<?
	if(isset($_POST['preview'])) {
	  // превью - редактора
			require_once  (__DIR__.'/../inc/wp/comments-post.php');
	} elseif (isset($_POST['update']) || isset($_POST['insert'])) {
	  // отправка коментария на запись или обновление
			require_once  (__DIR__.'/../inc/wp/comment-redaktor.php');
			printKoment($data['id']);
	} else {
	  // печать комментариев
		 	 printKoment($data['id']);
	}
?>
		</td>
	 </tr>
	 <tr>
		<td>
		  <form style="width: 230px;" action="index.php?pg=<?=$pg?>" method="post">
			 <input type="hidden" name="newNews" value="1"/>
			 <input class="btn btn-success" type="submit" value="Новая статья"/>
		  </form>
		</td>
		<td>
		  <form style="width: 230px;" action="index.php?pg=<?=$pg?>" method="post">
			 <input type="hidden" name="deleteNews" value="<?=$newsId?>"/>
			 <input class="btn btn-danger" type="submit" value="удалить статью" onclick="return confirmDelete();"/>
		  </form>
		</td>
		<td></td>
	 </tr>

	 </tbody>
  </table>
  </div>
<?
}


// обработка  запросов
if(isset($_POST['newsId']))
  {
	 $set = array();
	 $expected=array('name','head','body','avtor-pub','on-cit','citata','avtor-cit','komm','kolonka');
	 foreach($expected as $key){
		if((isset($_POST[$key]) && (!empty($_POST[$key])) or (isset($_POST[$key]) && $_POST[$key] == '0')))
		  {
		  $set[$key]=$_POST[$key];
	     }
	   }
	 $location = '';
	if (isset($_POST['location']))
	  {
		 $str = $_POST['location'];
		 if($str[0] == 'multiselect-all' or $str[0] == "NULL"){
		 unset($str[0]);
		 }

         foreach($str as $val)
			  {
				 $location .= $val.',';
			  }

		 go\DB\query('UPDATE `news` SET `location` = ?  WHERE `id` = ?i', array($location, $_POST['newsId']));
	  }

	 $location = mb_substr($location, 0, -1);
	 go\DB\query('UPDATE `news` SET ?set WHERE `id` = ?i', array($set, $_POST['newsId']));

	 $_SESSION['kolonka'] = isset($_POST['kolonka'])?$_POST['kolonka']:'c_colonka';
	 if (isset($_SESSION['location'])) unset($_SESSION['location']);
	 $_SESSION['location'] = isset($_POST['location'])?$_POST['location']:NULL;
  }



$pg = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
if ($pg < 1)
  {
	 $pg = 1;
  }
$start = ($pg - 1) * RECORDS_PER_PAGE;

   $name = go\DB\query('select `name`, `id` from `news`')->assoc();
   $record_count = count($name);
if(isset($_GET['newsId']))  $_SESSION['newsId'] = $_GET['newsId'];
   $newsId = isset($_SESSION['newsId'])?$_SESSION['newsId']:1;

?>

<div class="tabbable tabs-left">
  <div class="thumbImg">
	 <div class="bheader"><h2>Редактор блоков</h2></div>
  </div>
  <ul class="nav nav-tabs" style="margin-right: 0;">
	 <?
	 if($name)
		{
		  foreach ($name as  $news)
			 {
				if($newsId == $news['id'])
				  {
					 $akt = 'active';
				  } else {
				    $akt = '';
				}
				?>
				<li class="<?=$akt?>"><a data-toggle="tab" href="<?='#newsId-'.$news['id']?>"
					onclick="location.href = 'index.php?page=8&newsId='+<?=$news['id']?>;">
					<?=$news['name']?></a></li>
				<?
			 }
		}
	 ?>
  </ul>
 <div class="tab-content">
	<?
				if(isset($_GET['newsId']) && intval(trim($_GET['newsId'])) == $newsId )
				  {
					 printPubl(trim($_GET['newsId']),$pg);
				  } else {
				  printPubl($newsId,$pg);
				}
	?>
	<div style="clear:both"> </div>
	<?

	/**
	 * Проверка на уникальность
	 */
	if (isset($_POST['unik']))
	  {
		   $text = $_POST['head'].$_POST['body'];
			$log = array();
			$log['query'] = $text;
			$queries = (get_magic_quotes_gpc())?stripslashes($text):$text;
			$queries = preg_replace("/[?!\(\)'\",]/", "", $queries);
			$queries = preg_replace("/[- ]{2}/", " ", $queries);
			$queries = preg_replace("/ +/", " ", $queries);
			$queries = str_replace(".", "\n", $queries);
			$queries = explode("\n", trim($queries));    // Разбиваем на предложения
			?>
		 <h1>Проверка уникальности текста в интернете.</h1>
			<h2>Яндекс</h2>
			<table border="1">
			  <tr><td>Страниц</td><td>Запрос</td></tr>
			  <?php
			  foreach ($queries as $q) {
				 if (strlen($q) > 30) {
					$q   = preg_replace("/(([\S]+?[\s]+){3,9}[\S]+)[\s\S]*/", "$1", $q);
					$top = top_10("\"".trim($q)."\"");
					$log["yandex"][] = array($top[0][1], $q);
					?><tr><td><span title="<?php echo implode("\r\n", $top[1]); ?>"><?php echo $top[0][1]; ?></span></td><td>
					  <a href="http://www.yandex.ru/yandsearch?text=<?php echo urlencode("\"$q\""); ?>" target="_blank"><?php echo $q; ?></a></td></tr><?php
				 }
			  }
			  ?></table>
			<h2>Google</h2>
			<table border="1">
			<tr><td>Сайтов</td><td>Запрос</td></tr>
			<?php
			foreach ($queries as $q) {
			  if (strlen($q) > 30) {
				 $q   = preg_replace("/(([\S]+?[\s]+){3,9}[\S]+)[\s\S]*/", "$1", $q);
				 $top = @top_10_g("\"".trim($q)."\"");
				 $log["google"][] = array(@$top[0][1], $q);
				 ?><tr><td><?php echo (is_int(@$top[0][1]))? $top[0][1] : "N/A"; ?></td><td><a href="http://www.google.com/search?hl=ru&q=<?php echo urlencode("\"$q\""); ?>"
					 target="_blank"><?php echo $q; ?></a></td></tr><?php
			  }
			}
			?></table><?php
	  }
	?>
	<div style="clear:both"> </div>
	      <?
		  paginator($record_count, $pg);
	      ?>
  </div>
</div>
	 <script type="text/javascript">
		$(function(){
		  $('.tab-pane').show();
		});
	 </script>
	 <script type="text/javascript">
		function view(n) {
		  style = document.getElementById(n).style;
		  style.display = (style.display == 'block') ? 'none' : 'block';
		}
	 </script>