<?
define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
include 'sys/func.php';
if(intval(@$_COOKIE['admnewswar'])>2){
	echo '<div class="title">Вы превысили количество попыток вхoда,повторите через час</div>';exit;}

  $db = go\DB\Storage::getInstance()->get('db-for-data');
  $mp = $db->query('SELECT * FROM `config` WHERE id=?i',array(1),'row');

switch(@$_GET['act']){
	default:
	if(@$_COOKIE['admnews'] == md5($mp[1].'///'.$mp[2])){
		header('Location: admin.php?act=index');}
	echo '<div class="title2">Вход в систему</div>
	<div class="content">
	<form action="?act=input" method="post">
	Логин:<br/>
	<input type="text" name="login" /><br/>
	Пароль:<br/>
	<input type="password" name="pass" /><br/>
	<input type="submit" value="Войти" /></form></div>';
	break;

	case 'input':
	if(@$_COOKIE['admnews'] == "$mp[1]///$mp[2]"){
		header('Location: admin.php?act=index');}
	if(mysql_result(mysql_query('SELECT COUNT(*) FROM `config` WHERE
	admnick="'.mysql_real_escape_string($_POST['login']).'" &&	admpass="'.md5($_POST['pass']).'"'),0)==1){
		setcookie('admnews',''.$_POST['login'].'///'.md5($_POST['pass']),time()+86400);

		echo '<div class="title2">Вы вошли как администратор</div>
		<div class="content2"><a href="?act=index">Админка</a></div>';
		} else{
			if(intval($_COOKIE['admnewswar'])>0){
			setcookie('admnewswar',$_COOKIE['admnewswar']+1,time()+3600);
			} else{
				setcookie('admnewswar',1,time()+3600);}

			echo '<div class="title2">Не правельный логин или пароль</div>
			<div class="content2"><a href="?">Авторизация</a></div>';exit;}
			break;

	case 'index':
	admin_only();

		echo '<div class="title2">Админ панель</div><div class="content">
		<a href="newsadm.php">Управление новостями</a>
		</div><div class="content2">
		<a href="?act=set">Настройки</a><br/>
		<a href="?act=dak">Удалить все комментарии</a><br/>
		<a href="?act=optbd">Оптимизировать базу данных</a><br/>
		<a href="?act=exito">Выход</a>
		</div>';

	break;

	case 'set':
	admin_only();

	echo '<div class="title2">Настройки новостей</div><div class="content2">
	<form action="?act=setok" method="post">
	Новостей на страницу:<br/>
	<input type="text" name="nop" size="2" value="'.$mp[3].'" /><br/>
	<input type="checkbox" name="komm" value="da" checked="checked" /> Комментарии разрешены?<br/>
	Комментариев на страницу:<br/>
	<input type="text" name="kop" size="2" value="'.$mp[5].'" /><br/>
	Максимальная длина комментария:<br/>
	<input type="text" name="dlk" size="3" value="'.$mp[9].'" /><br/>
	<input type="checkbox" name="anrek" value="da" checked="checked" /> Антиреклама<br/>
	Количество символов в сокращенной новости:<br/>
	<input type="text" name="kolsm" size="4" value="'.$mp[7].'" /><br/>
	<input type="checkbox" name="captcha" value="da" checked="checked" /> Каптча при добавлении коментария<br/>
	<input type="submit" value="Изменить" />
	</form></div>';
	break;

	case 'setok':
	admin_only();

	echo '<div class="title2">Ностройки новостей</div>';
	$_POST['nop']=abs(intval($_POST['nop']));
	$_POST['kolsm']=abs(intval($_POST['kolsm']));
	$_POST['kop']=abs(intval($_POST['kop']));
	$_POST['dlk']=abs(intval($_POST['dlk']));
	if(empty($_POST['nop']) || empty($_POST['kop']) || empty($_POST['kolsm']) || empty($_POST['dlk'])){
		echo '<div class="title2">Пожалуста заполните все поля</div>
		<div class="content2"><a href="?act=set">Назад</a></div>';exit;}
	if(isset($_POST['komm'])){$komm = 1;} else { $komm = 0;}
	if(isset($_POST['anrek'])){$anrek = 1;} else { $anrek = 0;}
	if(isset($_POST['captcha'])){ $cptch = 1;} else {$cptch = 0;}

	if(mysql_query('UPDATE `config` SET nop="'.$_POST['nop'].'", common="'.$komm.'", cop="'.$_POST['kop'].'",
	captcha="'.$cptch.'", kolsm="'.$_POST['kolsm'].'", anrek="'.$anrek.'", kommdl="'.$_POST['dlk'].'" WHERE id=1')){
		echo '<div class="title2">Настройки успешно изменены</div><div class="content2"><a href="?act=index">Админка</a></div>';} else
		 {
		echo '<div class="title2">Ошибка изменении настроек <br/>'.mysql_error().'</div>
		<div class="content2"><a href="?act=index">Админка</a></div>';}

	break;

	case 'optbd':
	admin_only();
	if(mysql_query('OPTIMIZE TABLE `news`,`config`,`komments`')){
		echo '<div class="title2">БД успешно оптимизирована </div><div class="content2"><a href="?act=index">Админка</a></div>';}
		else{ echo '<div class="title2">Ошибка оптимизации БД<br/> '.mysql_error().'</div>
		<div class="content2><a href="?act=index">Админка</a></div>';}
	break;

	case 'exito':
	admin_only();
	if(setcookie('admnews','')){
		echo '<div class="title">Вы успешно вышли из админки</div>
		<div class="content"><a href="index.php">К новостям</a></div>';} else {
			echo '<div class="title">Не удалось выйти из админки</div>
		<div class="content"><a href="index.php">К новостям</a></div>';}
		break;

	case 'dak':
	admin_only();
	echo '<form action="?act=dakok" method="post">
	<div class="title">Вы действительно жедаете удалить все комментарии?</div>
	<div class="content">
	<input type="submit" name="yesdel" value="Да" />
	<input type="submit" name="nodel" value="Нет" /></form></div>';
	break;

	case 'dakok':
	admin_only();
	if(isset($_POST['yesdel'])){
		if(mysql_query('TRUNCATE TABLE `komments`')){
			echo '<div class="title2">Все комментарии успешно удалены<br/> <a href="admin.php?act=index">Админка</a></div>';}
		else { echo '<div class="title2">Ошибка удаления комментариев '.mysql_error().'<br/> <a href="?act=index">Админка</a></div>';}}
		 else{
			header('Location: admin.php?act=index');}
	break;
	}

	?>