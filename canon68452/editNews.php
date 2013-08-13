<?
include 'sys/func.php';

//Навигация
@$page = abs(intval($_GET['page']));
if(empty($page)){$page = 1;}

$all = mysql_result(mysql_query('SELECT COUNT(*) FROM `news`'),0);
$cfg = mysql_fetch_array(mysql_query('SELECT * FROM `config` WHERE id=1'));
$allp = ceil($all/$cfg[3]);
if($page>$allp){$page=$allp;}

//вывод новостей

if($all==0){echo '<div class="title2">Новостей нет</div>';
$str = '<div class="title"><a href="admin.php">Админка</a></div>'; echo if_adm($str);include 'sys/end.php';exit;}

echo '<div class="content">';

$n = mysql_query('SELECT * FROM `news` ORDER BY `id` DESC LIMIT '.intval($page*$cfg[3]-$cfg[3]).','.$cfg[3]);

include 'sys/bb.php';
while($na = mysql_fetch_array($n)){
	echo '<div class="title2">
	<a href="news.php?nid='.$na['id'].'">'.htmlspecialchars(stripslashes($na['name'])).'</a> ['.$na['date'].']';
	$str='  <a href="newsadm.php?act=newsdel&amp;id='.$na['id'].'">[del]</a>
	<a href="newsadm.php?act=newsedit&amp;id='.$na['id'].'">[edit]</a>'; echo if_adm($str);
	echo '</div><div class="content2">'.mb_substr(unbb(htmlspecialchars(stripslashes($na[1]))),0,$cfg[7]-1,'utf-8').' ...</div>';}

echo '</div>';
//навигация

	echo '<div class="content">Всего новостей: '.$all.'<br/>';
	if($page>1){echo '<a href="?page='.($page-1).'"><<</a> ';}
	if($allp>$page){echo '<a href="?page='.($page+1).'">>></a><br/>';}
	echo '<form action="?" method="get">Стр. <input type="text" size="2" name="page" /><input type="submit" value="go" /></form></div>';
	$str = '<div class="title"><a href="admin.php">Админка</a></div>'; echo if_adm($str);


?>