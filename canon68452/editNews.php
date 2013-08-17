<?
if (!isset($_SESSION['admin_logged'])) die();
//include 'news/sys/func.php';

if(!isset($_SESSION['admin_logged']))
  die();

define('RECORDS_PER_PAGE', 20);

if(isset($_POST['delete_order']))
  {
	 $id = $_POST['delete_order'];
	 $db->query("delete from orders where id = ?i", array($id));
	 $db->query("delete from order_items where id_order = ?i", array($id));
	 $db->query("delete from download_photo where id_order = ?i", array($id));
  }

include_once "praide-analyser-cp-1251.php";


function printKoment($newsId)
{
  $db = go\DB\Storage::getInstance()->get('db-for-data');
  $komments = $db->query('SELECT * FROM `komments` WHERE `news_id` = ?i',array($newsId),'assoc');

  include __DIR__ . '/../inc/Gravatar.php';
  $gravatar = new \emberlabs\GravatarLib\Gravatar();
  // example: setting default image and maximum size
  $gravatar->setDefaultImage('mm') ->setAvatarSize(150);
//  $gravatar->setDefaultImage('http://aleks.od.ua/path/to/image.png');
  // example: setting maximum allowed avatar rating
  $gravatar->setMaxRating('G');
  $avatar = $gravatar->buildGravatarURL('aleksjurii@gmail.com');


  foreach ($komments as $key => $post)
	 {
	$color =	($key %2 == 0)?"background-color:#efe;":"background-color:#ffe;"
?>


		  <ol class="commentlist">
			 <li id="comment-<?=$post['id']?>">
				<div id="div-comment-<?=$post['id']?>">
				  <div class="vcard">
					 <img class="avatar photo" width="40" height="40" src="http://0.gravatar.com/avatar/0cada37723a7804c48bfd46aa0a6fa45?s=40&d=&r=G" alt="">
					 <cite class="fn">
						<noindex>
						  <a class="url" href="http://dbmast.ru/goto/http://www.sngsnick.com/" rel="nofollow" target="_blank"><?=$post['nick']?></a>
						</noindex>
					 </cite>
					 <span class="says">:</span>
				  </div>
				  <div class="comment-meta">
					 <a href="http://dbmast.ru/besplatnyj-onlajn-servis-dlya-bystrogo-obmena-fajlami-do-50-gb/comment-page-1#comment-3402"><?=$post['data']?></a>
				  </div>
				  <p>Хороший сервис. Я о нем тоже уже где-то писал в конце мая.</p>
				  <div class="reply">
					 <a onclick="return addComment.moveForm('div-comment-1958', '1958', 'respond', '1701')"
					  href="index.php?replytocom=1958#respond">Ответить</a>
				  </div>
				</div>


				<ul class="children">
				  <li id="comment-<?=$post['id']?>">
					 <div id="div-comment-<?=$post['id']?>">
						<div class="vcard">
						  <img class="avatar photo" width="40" height="40" src="<?=$avatar?>" alt="">
						  <cite class="fn">driver</cite>
						  <span class="says">:</span>
						</div>
						<div class="comment-meta">
						  <a href="http://dbmast.ru/besplatnyj-onlajn-servis-dlya-bystrogo-obmena-fajlami-do-50-gb/comment-page-1#comment-3403"><?=$post['data']?></a>
						</div>
						<p>Здравствуйте, Николай. </p>
						<p>Спасибо за комментарий, если мой скромный блог просматривают такие люди, значит все не зря. Удачи вам в вашей работе)))</p>
						<div class="reply">

 <a onclick="return addComment.moveForm('div-comment-3403', '3403', 'respond', '2089'); href='index.php?replytocom=3403#respond'">Ответить</a>

						</div>
					 </div>
				  </li>
				</ul>
			 </li>
         </ol>

<?
	 }
}



function printPubl($newsId,$pg)
{
  $db = go\DB\Storage::getInstance()->get('db-for-data');
  $data = $db->query('SELECT * FROM `news` WHERE `id` = ?i',array($newsId),'row');
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
		  <form style="width: 230px;" action="<?=$_SERVER['PHP_SELF']?>" method="post">
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
			 Картинка слева
			 <label>
				<div class="controls">
				  <div class="input-append">
					 <input id="appendedInputButton" class="span3" type="file" name="img" style="width: 303px;"/>
				  </div>
				</div>
			 </label>
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
		  printKoment($data['id'])
?>
		</td>
	 </tr>
	 <tr>
		<td></td>
		<td>
		  <form style="width: 230px;" action="index.php?pg=<?=$pg?>" method="post">
			 <input class="btn btn-primary" type="submit" value="удалить статью" onclick="return confirmDelete();"/>
		  </form>
		</td>
		<td></td>
	 </tr>

	 </tbody>
  </table>
  </div>
<?
}



if(isset($_POST['newsId']))
  {
	 $set = array();
	 $expected=array('name','head','body','avtor-pub','img','on-cit','citata','avtor-cit','komm','kolonka');
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

		 $db->query('UPDATE `news` SET `location` = ?  WHERE `id` = ?i', array($location, $_POST['newsId']));
	  }

	 $location = mb_substr($location, 0, -1);
	 $db->query('UPDATE `news` SET ?set WHERE `id` = ?i', array($set, $_POST['newsId']));

	 $_SESSION['kolonka'] = isset($_POST['kolonka'])?$_POST['kolonka']:'c_colonka';
	 if (isset($_SESSION['location'])) unset($_SESSION['location']);
	 $_SESSION['location'] = isset($_POST['location'])?$_POST['location']:null;
	 if (isset($_FILES['img']) && $_FILES['img']['size'] != 0)
		{
		  if ($_FILES['img']['size'] < 1024 * 15 * 1024)
			 {
				$ext         =
				 strtolower(substr($_FILES['img']['name'], 1 + strrpos($_FILES['img']['name'], ".")));
				$nm          = $_POST['nm'];
				$descr       = $_POST['descr'];
				$foto_folder = $_POST['foto_folder'];
				$id_category = $_POST['id_category'];
				if (empty($nm))
				  {
					 $nm = 'Без имени';
				  }
				try
				  {
					 $id_album = $db->query('insert into `albums` (nm) VALUES (?string)', array($nm), 'id');
				  }
				catch (go\DB\Exceptions\Exception $e)
				  {
					 die('Ошибка при работе с базой данных');
				  }
				$db->query('insert into `accordions` (id_album,collapse_numer,collapse_nm,accordion_nm) VALUES (?scalar,?i,?string,?string)',
				  array($id_album,'1','default','default'));
				$img         = 'id'.$id_album.'.'.$ext;
				$target_name = $_SERVER['DOCUMENT_ROOT'].'/images/'.$img;
				$file_load   = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$img;
				if (move_uploaded_file($_FILES['img']['tmp_name'], $file_load))
				  {
					 $sharping  = 1;
					 $watermark = 0;
					 $ip_marker = 0;
					 if (imageresize($target_name, $file_load, 200, 200, 75, $watermark, $ip_marker, $sharping) == 'true')
						{
						  $db->query('update albums set id_category = ?i, img = ?, order_field = ?i, descr = ?, foto_folder = ? where id = ?i',
							 array($id_category, $img, $id_album, $descr, $foto_folder, $id_album));
						  mkdir('../'.$foto_folder.$id_album, 0777, true) or die($php_errormsg);
						  unlink($file_load);
						  $_SESSION['current_album'] = $id_album;
						  $_SESSION['current_cat']   = $id_category;
						}
					 else
						{
						  $db->query('delete from albums where id ?i', array($id_album));
						  unlink($file_load);
						  die('Для обработки принимаются только JPG, PNG или GIF имеющие размер не более 15Mb.');
						}
				  }
				else
				  {
					 $db->query('delete from albums where id ?i', array($id_album));
					 unlink($file_load);
					 die('Не могу загрузить файл в папку "tmp"');
				  }
			 }
		  else
			 {
				unlink($file_load);
				die('Размер файла превышает 15 мегабайт');
			 }
		}
  }



$pg = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
if ($pg < 1)
  {
	 $pg = 1;
  }
$start = ($pg - 1) * RECORDS_PER_PAGE;

   $name = $db->query('select `name`, `id` from `news`')->assoc();
   $record_count = count($name);
if(isset($_GET['newsId']))  $_SESSION['newsId'] = $_GET['newsId'];
   $newsId = isset($_SESSION['newsId'])?$_SESSION['newsId']:1;

?>

<div class="tabbable tabs-left">
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