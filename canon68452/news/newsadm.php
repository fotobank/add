<?
include 'sys/func.php';
include 'sys/head.php';
admin_only();


switch(@$_GET['act']){
	default:
	echo '<div class="content"><a href="?act=add">�������� �������</a><br/>
	<a href="?act=delnews">������� ��� �������</a></div>';
	break;

	case 'add':
	echo '<div class="title">���������� �������:</div>
	<div class="content">
	<form action="?act=addgo" method="post">
	��������� �������:<br/>
	<input type="text" name="namenews" /><br/>
	����� �������:<br/>
	<textarea name="textnews" cols="15" rows="7"></textarea><br/>
	<input type="checkbox" name="kommnews" /> ��������� �����������<br/>
	<input type="submit" value="����������" />
	</form></div>
	<div class="title2"><a href="bbcodes.php">BB ����</a></div>';
	break;

	case 'addgo':
    echo '<div class="title">���������� �������</div>';
	if(empty($_POST['namenews']) || empty($_POST['textnews'])){
		echo '<div class="title2">�� �� ��������� ��� ����</div>
		<div class="content1"><a href="?add">�����</a></div>';include 'sys/end.php';exit;}
	if(mb_strlen(trim($_POST['namenews']),'utf-8')>32 || mb_strlen(trim($_POST['namenews']),'utf-8')<3){
		echo '<div class="title2">����� ��������� ������ ���� �� 3 �� 32 �������</div>
		<a href="?add">�����</a></div>';include 'sys/end.php';exit;}
	if(isset($_POST['kommnews'])){$km = 0;} else {$km = 1;}
    if(mysql_query('INSERT INTO `news` VALUES(
    "","'.mysql_real_escape_string(trim($_POST['textnews'])).'","'.mysql_real_escape_string(trim($_POST['namenews'])).'","'.date('d.m.y H:i').'","'.$km.'","0")')){
    	echo '<div class="title2">������� ������� ���������!</div><div class="content2"><a href="admin.php">�������</a></div>';
    	} else {
    		echo '<div class="title2">������ ���������� ������� '.mysql_error().'</div>';}

    		break;

    case 'newsdel':
    $_GET['id'] = abs(intval($_GET['id']));
    if(mysql_result(mysql_query('SELECT COUNT(*) FROM `news` WHERE id="'.$_GET['id'].'"'),0)==0){
    	echo '<div class="title">������ ���o��� �� ����������</div><div class="content">
    	<a href="admin.php?act=index">�������</a><br/><a href="?">���������� ���������</a></div>';include 'sys/end.php';exit;}
    echo '<div class="title">�������� �������</div>';
    if(mysql_query('DELETE FROM `news` WHERE id="'.$_GET['id'].'"')){
    	echo '<div class="title2">������� ������� �������</div><div class="content2">
    	<a href="admin.php?act=index">�������</a><br/><a href="?">���������� ���������</a></div>';} else {
    		echo '<div class="title2">������ �������� �������<br/>'.mysql_error().'<br/>
    		<a href="admin.php?act=index">�������</a><br/><a href="?">���������� ���������</a></div>';}

    break;

    case 'delnews':
	echo '<form action="?act=delok" method="post">
	<div class="title">�� ������������� ������� ������� ��� �������?</div>
	<div class="content">
	<input type="submit" name="yesdel" value="��" />
	<input type="submit" name="nodel" value="���" /></form></div>';
	break;

	case 'delok':
	if(isset($_POST['yesdel'])){
		if(mysql_query('TRUNCATE TABLE `news`')){echo '
		<div class="title2">��� ������� ������� �������<br/> <a href="admin.php?act=index">�������</a></div>';}
		else { echo '<div class="title2">������ �������� �������� '.mysql_error().'<br/> <a href="?act=index">�������</a></div>';}}
		 else{
			echo '	<div class="title2">������� �� ���� �������<br/> <a href="admin.php?act=index">�������</a></div>';}
	break;

	case 'newsedit':
	$_GET['id'] = abs(intval($_GET['id']));
    if(mysql_result(mysql_query('SELECT COUNT(*) FROM `news` WHERE id="'.$_GET['id'].'"'),0)==0){
    	echo '<div class="title">������ ���o��� �� ����������</div><div class="content">
    	<a href="admin.php?act=index">�������</a><br/><a href="?">���������� ���������</a>';include 'sys/end.php';exit;}
    $ea = mysql_fetch_array(mysql_query('SELECT `name`,`head` FROM `news` WHERE `id`="'.$_GET['id'].'"'));
    echo '<div class="title">�������������� �������:</div>
	<div class="content">
	<form action="?act=editgo&id='.$_GET['id'].'" method="post">
	��������� �������:<br/>
	<input type="text" name="namenews" value="'.$ea['name'].'"/><br/>
	����� �������:<br/>
	<input type="text" name="textnews" value="'.$ea['head'].'" /><br/>
	<input type="checkbox" name="kommnews" /> ��������� �����������<br/>
	<input type="submit" value="����������" />
	</form></div>';
	break;

	case 'editgo':
	$_GET['id'] = abs(intval($_GET['id']));

	if(mysql_result(mysql_query('SELECT COUNT(*) FROM `news` WHERE id="'.$_GET['id'].'"'),0)==0){
    	echo '<div class="title">������ ���o��� �� ����������</div><div class="content">
    	<a href="admin.php?act=index">�������</a><br/><a href="?">���������� ���������</a></div>';include 'sys/end.php';exit;}

	echo '<div class="title>�������������� �������</div>';
	if(empty($_POST['namenews']) || empty($_POST['textnews'])){
		echo '<div class="title2">�� �� ��������� ��� ����</div>
		<div class="content1"><a href="?act=editgo&id='.$_GET['id'].'">�����</a></div>';include 'sys/end.php';exit;}
	if(mb_strlen(trim($_POST['namenews']),'utf-8')>32 || mb_strlen(trim($_POST['namenews']),'utf-8')<3){
		echo '<div class="title2">����� ��������� ������ ���� �� 3 �� 32 �������</div>
		<a href="?act=editgo&id='.$_GET['id'].'">�����</a></div>';include 'sys/end.php';exit;}
	if(isset($_POST['kommnews'])){$km = 0;} else {$km = 1;}
    if(mysql_query('UPDATE `news` SET `head`=
    "'.mysql_real_escape_string(trim($_POST['textnews'])).'", `name`="'.mysql_real_escape_string(trim($_POST['namenews'])).'",
    `komm`="'.$km.'" WHERE id="'.$_GET['id'].'"')){
    	echo '<div class="title2">������� ������� ��������!</div><div class="content2"><a href="admin.php">�������</a></div>';
    	} else {
    		echo '<div class="title2">������ ��������� ������� '.mysql_error().'</div>';}

    		break;

    case 'kommdel':
    $_GET['kid'] = abs(intval($_GET['kid']));
    if(mysql_result(mysql_query('SELECT COUNT(*) FROM `komments` WHERE id="'.$_GET['kid'].'"'),0)==0){
    	echo '<div class="title">������ ����������� �� ����������</div><div class="content">
    	<a href="admin.php?act=index">�������</a></div>';include 'sys/end.php';exit;}
    echo '<div class="title">�������� �����������</div>';
    if(mysql_query('DELETE FROM `komments` WHERE id="'.$_GET['kid'].'"')){
    	echo '<div class="title2">����������� ������� ������</div><div class="content2">
    	<a href="admin.php?act=index">�������</a></div>';} else {
    		echo '<div class="title2">������ �������� �����������<br/>'.mysql_error().'<br/>
    		<a href="admin.php?act=index">�������</a></div>';}
	}


include 'sys/end.php';
?>