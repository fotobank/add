<?
include '../inc/config.php';
include '../inc/func.php';
header('Content-type: text/html; charset=windows-1251');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//RU" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<?php
include $_SERVER['DOCUMENT_ROOT'].'/inc/title.php';
?>

<link rel="shortcut icon" href="../img/ico_nmain.gif" />
<link href="../css/main.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../css/lightbox.css" type="text/css" media="screen" />
<script src="../js/jquery-1.7.1.min.js"></script>
<script src="../js/main.js"></script>
 
<? if(strstr($_SERVER['PHP_SELF'], 'fk')): ?>
<script type="text/javascript" src="../js/prototype.js"></script>
<script type="text/javascript" src="../js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="../js/lightbox.js"></script>
<? endif; ?>

<script language=JavaScript>
function clickIE4()
{
  if (event.button==2)
  {
    return false;
  }
}
function clickNS4(e)
{
  if (document.layers||document.getElementById&&!document.all)
  {
    if (e.which==2||e.which==3)
    {
      return false;
    }
  }
}
if (document.layers)
{
  document.captureEvents(Event.MOUSEDOWN);
  document.onmousedown=clickNS4;
}
else if (document.all && !document.getElementById)
{
  document.onmousedown=clickIE4;
}
document.oncontextmenu=new Function("return false");
</script>




<script language=JavaScript type="text/javascript">

function smile(str){
	obj = document.Sad_Raven_Guestbook.mess;
	obj.focus();
	obj.value =	obj.value + str;
}
function openBrWindow(theURL,winName,features){
  	window.open(theURL,winName,features);
}
function inserttags(st_t, en_t){
	obj = document.Sad_Raven_Guestbook.mess;
	obj2 = document.Sad_Raven_Guestbook;
	if ((document.selection)) {
		obj.focus();
		obj2.document.selection.createRange().text = st_t+obj2.document.selection.createRange().text+en_t;
	}
	else
	{
		obj.focus();
		obj.value += st_t+en_t;
	}
}
</script>

<META HTTP-EQUIV=Cache-Control content=no-cache> 
<!--[if lt IE 9]>
   <script>document.createElement('figure');</script>
  <![endif]-->
</head>

<body> 


<div id="maket"> 
<div id="photo_preview_bg" onClick="JavaScript: hidePreview();"></div>
<div id="photo_preview"></div>




<!--������ ������-->
<div id="head">
	<table class="tb_head">
    <tr>
    <td class="td_head_logo">
	<div id="zagol">
            <h1>
    		����������������<br>
 			���� � ����������� <br>
			� ������
    		</h1>
    </div>
    <a class="logo" href="/index.php"></a>

    </td>
    <td class="td_form_ent">

    <div id="form_ent">

<? if(isset($_SESSION['logged'])): ?>
<center>
  <span style="color:#bb5">������������,<br> <b><?=$_SESSION['us_name']?>.</b><br/>
  <?
  $user_balans = floatval(mysql_result(mysql_query('select balans from users where id = '.intval($_SESSION['userid'])), 0));
  ?>
  ��� ������: <b><?=$user_balans?></b> ��.<br/></span></center>

  
  <a class="korzina" href="/basket.php">�������</a> 
 
 <a class="vihod" href="/enter.php?logout=1" >�����</a>
  
  
<? else: ?>
    <u>����� �����:</u><br>
    <form action="/enter.php" method="post">
    <table>
    <tr>
    <td> �����: </td> <td><input class="inp_fent" name="login"></td>
    </tr>
    <tr>
     <td> ������: </td> <td> <input class="inp_fent" type="password" name="password"></td>
     </tr>
     <tr></tr>
	 <tr>
    <td><input class="vhod" name="submit" type="submit" value="����"></td>    
	 <td>		
			<a href="/registr.php" class="registracia" >�����������</a>
	 </td>	 
	  
     </tr>
    </table>
    <a href="/reminder.php" style="color: #fff; text-decoration: none;">������ ������?</a>
    </form>
<? endif; ?>

    </div>
    </table>

<!-- ��������� �� ������-->
<?
if(isset($_SESSION['err_msg']))
{
	?>
	<div class="err_msg"><?=$_SESSION['err_msg']?></div>
	<?
	unset($_SESSION['err_msg']);
}
?>

<!-- ��������� � ������� ����������-->
<?
if(isset($_SESSION['ok_msg']))
{
	?>
	<div class="ok_msg"><?=$_SESSION['ok_msg']?></div>
	<?
	unset($_SESSION['ok_msg']);
}
?>
    <div id="main_menu">

    <?PHP
	$value= $_SERVER['PHP_SELF'];

if ($value=='/index.php') {$act_ln='gl_act'; $key='�������';
echo "
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a class='bt_gb' href='/gb/'>��������</a>"

	;}elseif ($value=='/fotobanck.php') {$act_ln='fb_act'; $key='����-����';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a class='bt_gb' href='/gb/'>��������</a>"

	;}elseif ($value=='/uslugi.php') {$act_ln='usl_act'; $key='������';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a class='bt_gb' href='/gb/'>��������</a>"

	;}elseif ($value=='/ceny.php') {$act_ln='cn_act'; $key='����';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a class='bt_gb' href='/gb/'>��������</a>"

	;}elseif ($value=='/kontakty.php') {$act_ln='konty_act'; $key='��������';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_gb' href='/gb/'>��������</a>"

	;}elseif ($value=='/gb/index.php') {$act_ln='gb_act'; $key='��������';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a href='$value' class='$act_ln'>$key</a>"

	;}elseif ($value=='/registr.php' or'/activation.php') {$act_ln='gb_act'; $key='��������';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a class='bt_gb' href='/gb/'>��������</a>"
	;}
?>
    </div>
</div>
<!--������ �����-->

<?
if($value == '/gb/index.php'): ?>
<div id="main">
<table width=<?=$TABWIDTH?> border=2 cellspacing=0 cellpadding=2><tr><td>
<table width=100% border=2 cellspacing=1 cellpadding=3 bgcolor=<?=$BORDER?>><tr><td align=center class=pdarkhead bgcolor=<?=$DARK?>><b><?=$gname?></b></td></tr></table>
</td></tr><tr><td>

<? endif;?>