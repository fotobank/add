<?
session_start();
include 'sys/func.php';
include 'sys/head.php';

$_GET['nid'] = abs(intval($_GET['nid']));
if(mysql_result(mysql_query('SELECT COUNT(*) FROM `config` WHERE `common`="1"'),0)==0){	echo '<div class="title">Комментарии к новостям запрещены</div><div class="content">
    	<a href="index.php">К новстям</a></div>';include 'sys/end.php';exit;}

if(mysql_result(mysql_query('SELECT COUNT(*) FROM `news` WHERE id="'.$_GET['nid'].'" and komm="1"'),0)==0){	echo '<div class="title">Комментарии к данной новости запрещены</div><div class="content">
    	<a href="index.php">К новстям</a></div>';include 'sys/end.php';exit;}

echo '<div class="title2">Комментарии к новости: <a href="news.php?nid='.$_GET['nid'].'">
'.mysql_result(mysql_query('SELECT `name` FROM `news` WHERE `id`="'.$_GET['nid'].'"'),0).'</a></div>';

	//для капчи

	$mt = mt_rand(0,99);
	$mt1 = mt_rand(0,99);

$cfg = mysql_fetch_array(mysql_query('SELECT * FROM `config` WHERE id=1'));
switch(@$_GET['act']){	default:
	@$page = abs(intval($_GET['page']));
if(empty($page)){$page = 1;}

$all = mysql_result(mysql_query('SELECT COUNT(*) FROM `komments` WHERE `news_id`="'.$_GET['nid'].'"'),0);
$allp = ceil($all/$cfg[5]);
if($page>$allp){$page=$allp;}


if(mysql_result(mysql_query('SELECT COUNT(*) FROM `komments` WHERE `news_id`="'.$_GET['nid'].'" '),0)==0){	echo '<div class="title">Комментариев нету</div>';} else {
		$komm = mysql_query('SELECT * FROM `komments` WHERE `news_id`="'.$_GET['nid'].'"
		ORDER BY `id` DESC LIMIT '.intval($page*$cfg[5]-$cfg[5]).','.$cfg[5]);

		while($k = mysql_fetch_array($komm)){			echo '<div class="title">'. htmlspecialchars(stripslashes($k['nick'])).' ['.$k['data'].']  ';

			$str= '<a href="newsadm.php?act=kommdel&kid='.$k['id'].'">[del]</a>'; echo if_adm($str);

			echo '</div><div class="content2">'. htmlspecialchars(stripslashes($k['head'])).'</div>';}}




echo '<div class="content"><form action="?act=kommadd&amp;nid='.$_GET['nid'].'" method="post">
Представтесь: <input type="text" name="name" /><br/>
Ваш комментарий:<br/>
<textarea name="kommtext" cols="13" rows="4"></textarea><br/>';
if(mysql_result(mysql_query('SELECT COUNT(*) FROM `config` WHERE `captcha`="1"'),0)==1)	{		$_SESSION['mt']=$mt;
		$_SESSION['mt1']=$mt1;echo  'Введите код с картинки:<br/><img src="captcha.php" alt="wait" /><br/>
<input type="text" name="kod" size="4"/>';
	}


echo '<input type="submit" value="Добавить" /></form></div><div class="content2">';

//навигация

if($page>1){echo '<a href="?page='.($page-1).'&amp;nid='.$_GET['nid'].'"><<</a> ';}
	if($allp>$page){echo '<a href="?page='.($page+1).'&amp;nid='.$_GET['nid'].'">>></a><br/>';}
	echo '<form action="?" method="get">Стр. <input type="text" size="2" name="page" />
	<input type="hidden" name="nid" value="'.$_GET['nid'].'" /><input type="submit" value="go" /></form></div>';
	$str = '<div class="title"><a href="admin.php">Админка</a></div>'; echo if_adm($str);

break;

case 'kommadd':

$_POST['kommtext'] = trim($_POST['kommtext']);
$_POST['name'] = trim($_POST['name']);

if(mb_strlen($_POST['name'],'utf-8')>16){	echo '<div class="title">Максимальная длина ника 16 символов</div><div class="content">
    	<a href="komm.php?nid='.$_GET['nid'].'">Назад</a><br/>
    	<a href="index.php">К новстям</a></div>';include 'sys/end.php';exit;}

if(mb_strlen($_POST['kommtext'],'utf-8')>$cfg[9]){
	echo '<div class="title">Максимальная длина комментария '.$cfg[9].' символов</div><div class="content">
    	<a href="komm.php?nid='.$_GET['nid'].'">Назад</a><br/>
    	<a href="index.php">К новстям</a></div>';include 'sys/end.php';exit;}

if(mysql_result(mysql_query('SELECT COUNT(*) FROM `config` WHERE `captcha`="1"'),0)==1)
	{		if(intval($_POST['kod'])!=$_SESSION['mt'].$_SESSION['mt1']){			echo '<div class="title">Код с картинки введен не верно </div><div class="content">
    	<a href="komm.php?nid='.$_GET['nid'].'">Назад</a><br/>
    	<a href="index.php">К новстям</a></div>';include 'sys/end.php';exit;}}

if(mysql_result(mysql_query('SELECT COUNT(*) FROM `config` WHERE `anrek`="1"'),0)==1){
$_POST['kommtext'] = preg_replace('#http://.*\.(com|net|org|ru|ua|info|in)#i','',$_POST['kommtext']);}

if(empty($_POST['name']) || empty($_POST['kommtext'])){
echo '<div class="title">Заполните все поля <br/> *Реклама запрещена </div><div class="content">
    	<a href="komm.php?nid='.$_GET['nid'].'">Назад</a><br/>
    	<a href="index.php">К новстям</a></div>';include 'sys/end.php';exit;}

if(mysql_query('INSERT INTO `komments` VALUES("","'.$_GET['nid'].'","'.mysql_real_escape_string($_POST['kommtext']).'",
"'.mysql_real_escape_string($_POST['name']).'","'.date('d.m.y H:i').'")'))
{	echo '<div class="title">Комментарий успешно добавлен</div><div class="content">
    	<a href="komm.php?nid='.$_GET['nid'].'">Назад</a><br/>
    	<a href="index.php">К новстям</a></div>';
    	} else {    		echo '<div class="title">Ошибка добавления комментария<br/></div><div class="content">
    	<a href="komm.php?nid='.$_GET['nid'].'">Назад</a><br/>
    	<a href="index.php">К новстям</a></div>';}

break;

}
include 'sys/end.php';
?>