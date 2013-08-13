<?
include 'sys/func.php';

$_GET['nid'] = abs(intval($_GET['nid']));
if(mysql_result(mysql_query('SELECT COUNT(*) FROM `news` WHERE `id`="'.$_GET['nid'].'"'),0)==0){	echo '<div class="title2">Извините ,данная новость не существует
	<br/><a href="index.php">К новостям</a></div>';include 'sys/end.php';exit;}
mysql_query('UPDATE `news` SET `pros`=`pros`+1 WHERE id="'.$_GET['nid'].'"');
$news = mysql_fetch_array(mysql_query('SELECT * FROM `news` WHERE id="'.$_GET['nid'].'"'));

include 'sys/bb.php';

//вывод новости

echo '<div class="title2">'.htmlspecialchars(stripslashes($news['name']));
$str='  <a href="newsadm.php?act=newsdel&amp;id='.$_GET['nid'].'">[del]</a>
<a href="newsadm.php?act=newsedit&amp;id='.$_GET['nid'].'">[edit]</a>'; echo if_adm($str);
echo '</div><div class="content">'.bb(htmlspecialchars(stripslashes($news['head']))).'</div><div class="title">';

if(mysql_result(mysql_query('SELECT COUNT(*) FROM `config` WHERE common=1'),0)==1 && $news['komm']==1){
echo '<a href="komm.php?nid='.$_GET['nid'].'">Прокомментировать</a>
['.mysql_result(mysql_query('SELECT COUNT(*) FROM `komments` WHERE `news_id`="'.$_GET['nid'].'"'),0).']<br/>';}
echo 'Просмотров: '.$news['pros'].'<br/>
Дата добавления: '.$news['date'].'</div>';



include 'sys/end.php';