<?
include 'sys/func.php';
include 'sys/head.php';
admin_only();


switch(@$_GET['act']){	default:
	echo '<div class="content"><a href="?act=add">Добавить новость</a><br/>
	<a href="?act=delnews">Удалить все новости</a></div>';
	break;

	case 'add':
	echo '<div class="title">Добавление новости:</div>
	<div class="content">
	<form action="?act=addgo" method="post">
	Заголовок новости:<br/>
	<input type="text" name="namenews" /><br/>
	Текст новости:<br/>
	<textarea name="textnews" cols="15" rows="7"></textarea><br/>
	<input type="checkbox" name="kommnews" /> Запретить комментарии<br/>
	<input type="submit" value="Продолжить" />
	</form></div>
	<div class="title2"><a href="bbcodes.php">BB коды</a></div>';
	break;

	case 'addgo':
    echo '<div class="title">Добавление новости</div>';
	if(empty($_POST['namenews']) || empty($_POST['textnews'])){		echo '<div class="title2">Вы не заполнили все поля</div>
		<div class="content1"><a href="?add">Назад</a></div>';include 'sys/end.php';exit;}
	if(mb_strlen(trim($_POST['namenews']),'utf-8')>32 || mb_strlen(trim($_POST['namenews']),'utf-8')<3){		echo '<div class="title2">Длина заголовка должна быть от 3 до 32 сиволов</div>
		<a href="?add">Назад</a></div>';include 'sys/end.php';exit;}
	if(isset($_POST['kommnews'])){$km = 0;} else {$km = 1;}
    if(mysql_query('INSERT INTO `news` VALUES(
    "","'.mysql_real_escape_string(trim($_POST['textnews'])).'","'.mysql_real_escape_string(trim($_POST['namenews'])).'","'.date('d.m.y H:i').'","'.$km.'","0")')){    	echo '<div class="title2">Новость успешно добавлена!</div><div class="content2"><a href="admin.php">Админка</a></div>';
    	} else {    		echo '<div class="title2">Ошибка добавления новости '.mysql_error().'</div>';}

    		break;

    case 'newsdel':
    $_GET['id'] = abs(intval($_GET['id']));
    if(mysql_result(mysql_query('SELECT COUNT(*) FROM `news` WHERE id="'.$_GET['id'].'"'),0)==0){    	echo '<div class="title">Данная новoсть не существует</div><div class="content">
    	<a href="admin.php?act=index">Админка</a><br/><a href="?">Управление новостями</a></div>';include 'sys/end.php';exit;}
    echo '<div class="title">Удаление новости</div>';
    if(mysql_query('DELETE FROM `news` WHERE id="'.$_GET['id'].'"')){    	echo '<div class="title2">Новость успешно удалена</div><div class="content2">
    	<a href="admin.php?act=index">Админка</a><br/><a href="?">Управление новостями</a></div>';} else {    		echo '<div class="title2">Ошибка удаления новости<br/>'.mysql_error().'<br/>
    		<a href="admin.php?act=index">Админка</a><br/><a href="?">Управление новостями</a></div>';}

    break;

    case 'delnews':
	echo '<form action="?act=delok" method="post">
	<div class="title">Вы действительно жедаете удалить все новости?</div>
	<div class="content">
	<input type="submit" name="yesdel" value="Да" />
	<input type="submit" name="nodel" value="Нет" /></form></div>';
	break;

	case 'delok':
	if(isset($_POST['yesdel'])){
		if(mysql_query('TRUNCATE TABLE `news`')){echo '
		<div class="title2">Все новости успешно удалены<br/> <a href="admin.php?act=index">Админка</a></div>';}
		else { echo '<div class="title2">Ошибка удаления новостей '.mysql_error().'<br/> <a href="?act=index">Админка</a></div>';}}
		 else{
			echo '	<div class="title2">Новости не были удалены<br/> <a href="admin.php?act=index">Админка</a></div>';}
	break;

	case 'newsedit':
	$_GET['id'] = abs(intval($_GET['id']));
    if(mysql_result(mysql_query('SELECT COUNT(*) FROM `news` WHERE id="'.$_GET['id'].'"'),0)==0){
    	echo '<div class="title">Данная новoсть не существует</div><div class="content">
    	<a href="admin.php?act=index">Админка</a><br/><a href="?">Управление новостями</a>';include 'sys/end.php';exit;}
    $ea = mysql_fetch_array(mysql_query('SELECT `name`,`head` FROM `news` WHERE `id`="'.$_GET['id'].'"'));
    echo '<div class="title">Редактирование новости:</div>
	<div class="content">
	<form action="?act=editgo&id='.$_GET['id'].'" method="post">
	Заголовок новости:<br/>
	<input type="text" name="namenews" value="'.$ea['name'].'"/><br/>
	Текст новости:<br/>
	<input type="text" name="textnews" value="'.$ea['head'].'" /><br/>
	<input type="checkbox" name="kommnews" /> Запретить комментарии<br/>
	<input type="submit" value="Продолжить" />
	</form></div>';
	break;

	case 'editgo':
	$_GET['id'] = abs(intval($_GET['id']));

	if(mysql_result(mysql_query('SELECT COUNT(*) FROM `news` WHERE id="'.$_GET['id'].'"'),0)==0){
    	echo '<div class="title">Данная новoсть не существует</div><div class="content">
    	<a href="admin.php?act=index">Админка</a><br/><a href="?">Управление новостями</a></div>';include 'sys/end.php';exit;}

	echo '<div class="title>Редактирование новости</div>';
	if(empty($_POST['namenews']) || empty($_POST['textnews'])){
		echo '<div class="title2">Вы не заполнили все поля</div>
		<div class="content1"><a href="?act=editgo&id='.$_GET['id'].'">Назад</a></div>';include 'sys/end.php';exit;}
	if(mb_strlen(trim($_POST['namenews']),'utf-8')>32 || mb_strlen(trim($_POST['namenews']),'utf-8')<3){
		echo '<div class="title2">Длина заголовка должна быть от 3 до 32 сиволов</div>
		<a href="?act=editgo&id='.$_GET['id'].'">Назад</a></div>';include 'sys/end.php';exit;}
	if(isset($_POST['kommnews'])){$km = 0;} else {$km = 1;}
    if(mysql_query('UPDATE `news` SET `head`=
    "'.mysql_real_escape_string(trim($_POST['textnews'])).'", `name`="'.mysql_real_escape_string(trim($_POST['namenews'])).'",
    `komm`="'.$km.'" WHERE id="'.$_GET['id'].'"')){
    	echo '<div class="title2">Новость успешно изменена!</div><div class="content2"><a href="admin.php">Админка</a></div>';
    	} else {
    		echo '<div class="title2">Ошибка изменении новости '.mysql_error().'</div>';}

    		break;

    case 'kommdel':
    $_GET['kid'] = abs(intval($_GET['kid']));
    if(mysql_result(mysql_query('SELECT COUNT(*) FROM `komments` WHERE id="'.$_GET['kid'].'"'),0)==0){
    	echo '<div class="title">Данный комментарий не существует</div><div class="content">
    	<a href="admin.php?act=index">Админка</a></div>';include 'sys/end.php';exit;}
    echo '<div class="title">Удаление комментария</div>';
    if(mysql_query('DELETE FROM `komments` WHERE id="'.$_GET['kid'].'"')){
    	echo '<div class="title2">Комментарий успешно удален</div><div class="content2">
    	<a href="admin.php?act=index">Админка</a></div>';} else {
    		echo '<div class="title2">Ошибка удаления комментария<br/>'.mysql_error().'<br/>
    		<a href="admin.php?act=index">Админка</a></div>';}
	}


include 'sys/end.php';
?>