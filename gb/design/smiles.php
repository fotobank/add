<?
define('SR_DENIED', true);
include ("../config.inc.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Смайлики</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<?
header('Content-type: text/html; charset=windows-1251');
?>
<script language="javascript" type="text/javascript">
<!--
function smile(text) {
	text = ' ' + text + ' ';
	if (opener.document.forms['post'].mess.createTextRange && opener.document.forms['post'].mess.caretPos) {
		var caretPos = opener.document.forms['post'].mess.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		opener.document.forms['post'].mess.focus();
	} else {
	opener.document.forms['post'].mess.value  += text;
	opener.document.forms['post'].mess.focus();
	}
}
//-->
</script>
<? require ("css.inc.php"); ?>
</head>

<body bgcolor=<?=$BACKGROUND?>>
  
<table width=100%  border=0 cellpadding=2 cellspacing=1 bgcolor=<?=$BORDER;?>>
  <tr align="center" bgcolor="<?=$DARK;?>">
    <td colspan="4" class=pdark><strong>Дополнительные смайлики</strong><br>
        Для вставки смайлика в сообщение нужно скопировать в окно сообщения текст из правого столбца</td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td><img src="../img/welcome.gif" width="55" height="49"></td>
    <td>:welcome:</td>
    <td height="34"><img src=../img/horse.gif border=0 width=44 height=23></td>
    <td height="34"> &nbsp;:horse: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/wink2.gif border=0 width=15 height=15></td>
    <td height="34">:wink2: </td>
    <td height="34"><img src=../img/moo.gif border=0 width=16 height=16></td>
    <td height="34">&nbsp;:moo: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/yes.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:yes: </td>
    <td height="34"><img src=../img/pig.gif border=0 width=28 height=20></td>
    <td height="34">&nbsp;:pig: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/no.gif border=0 width=15 height=15></td>
    <td height="34"> &nbsp;:no: </td>
    <td height="34"><img src=../img/bud.gif border=0 width=60 height=40></td>
    <td height="34">&nbsp;:bud: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/bye.gif border=0 width=15 height=15></td>
    <td height="34"> &nbsp;:bye: </td>
    <td height="34"><img src=../img/rup.gif border=0 width=38 height=18></td>
    <td height="34">&nbsp;:rup: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/rolleyes.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:rolleyes: </td>
    <td height="34"><img src="../img/stop.gif" width="20" height="16"></td>
    <td height="34">:stop:</td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/eek.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:eek: </td>
    <td height="34"><img src=../img/help.gif border=0 width=35 height=25></td>
    <td height="34">&nbsp;:help: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/dmad.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:madbg: </td>
    <td height="34"><img src=../img/heart.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:heart: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/haha.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:haha: </td>
    <td height="34"><img src=../img/lips.gif border=0 width=21 height=17></td>
    <td height="34">&nbsp;:lips: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src="../img/biggrin2.gif" width="21" height="24"></td>
    <td height="34">:biggrin:</td>
    <td height="34"><img src=../img/loveyou.gif border=0 width=34 height=15></td>
    <td height="34">&nbsp;:loveyou: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/smilk.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:smilk: </td>
    <td height="34"><img src=../img/rose.gif border=0 width=30 height=21></td>
    <td height="34">&nbsp;:rose: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/cool2.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:cool2: </td>
    <td height="34"><img src="../img/blush.gif" width="19" height="19"></td>
    <td height="34">:blush:</td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/vava.gif border=0 width=22 height=15></td>
    <td height="34">&nbsp;:vava: </td>
    <td height="34"><img src="../img/flirt.gif" width="19" height="19"></td>
    <td height="34">:flirt:</td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/kid.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:kid: </td>
    <td height="34"><img src=../img/ass.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:ass: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/cry2.gif border=0 width=21 height=15></td>
    <td height="34">&nbsp;:cry2: </td>
    <td height="34"><img src=../img/red.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:red: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/astro.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:astro: </td>
    <td height="34"><img src=../img/tong.gif border=0 width=23 height=15></td>
    <td height="34">&nbsp;:tong: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/dead.gif border=0 width=17 height=21></td>
    <td height="34">&nbsp;:dead: </td>
    <td height="34"><img src=../img/surp.gif border=0 width=19 height=19></td>
    <td height="34">&nbsp;:surp: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/love.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:love: </td>
    <td height="34"><img src=../img/smoke.gif border=0 width=21 height=15></td>
    <td height="34">&nbsp;:smoke: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/kiss.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:kiss: </td>
    <td height="34"><img src=../img/shuffle.gif border=0 width=15 height=20></td>
    <td height="34">&nbsp;:shuffle: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/scream.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:scream: </td>
    <td height="34"><img src="../img/ranting.gif" width="28" height="24"></td>
    <td height="34">&nbsp;:ranting:</td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/sleep.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:sleep: </td>
    <td height="34"><img src=../img/spin.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:spin: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/ill.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:ill: </td>
    <td height="34"><img src=../img/laugh.gif border=0 width=39 height=15></td>
    <td height="34">&nbsp;:laugh: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/insane.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:insane: </td>
    <td height="34"><img src=../img/suic.gif border=0 width=70 height=15></td>
    <td height="34">&nbsp;:suic: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/lol.gif border=0 width=15 height=15></td>
    <td height="34">&nbsp;:lol: </td>
    <td height="34"><img src="../img/secret.gif" width="45" height="30"></td>
    <td height="34">:secret:</td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src="../img/drunk.gif" width="58" height="30"></td>
    <td height="34">:drunk:</td>
    <td height="34"><img src="../img/evil.gif" width="22" height="25"></td>
    <td height="34">:evil: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/beer.gif border=0 width=26 height=39></td>
    <td height="34"> &nbsp;:beer: </td>
    <td height="34"><img src=../img/evil2.gif border=0 width=16 height=16></td>
    <td height="34">&nbsp;:evil2: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/beers.gif border=0 width=57 height=16></td>
    <td height="34"> &nbsp;:beers: </td>
    <td height="34"><img src=../img/shoot.gif border=0 width=51 height=18></td>
    <td height="34">&nbsp;:shoot: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/suck.gif border=0 width=20 height=19></td>
    <td height="34">&nbsp;:suck: </td>
    <td height="34"><img src=../img/duel.gif border=0 width=82 height=19></td>
    <td height="34">&nbsp;:duel: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/kick.gif border=0 width=57 height=17></td>
    <td height="34">&nbsp;:kick: </td>
    <td height="34"><img src="../img/ah.gif" width="19" height="25"></td>
    <td height="34">:ah:</td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src=../img/bums.gif border=0 width=31 height=28></td>
    <td height="34">&nbsp;:bums: </td>
    <td height="34"><img src=../img/pretty.gif border=0 width=48 height=41></td>
    <td height="34">&nbsp;:pretty: </td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src="../img/00.gif" width="39" height="50"></td>
    <td height="34">:00:</td>
    <td height="34"><img src="../img/pick.gif" width="45" height="37"></td>
    <td height="34">:pick:</td>
  </tr>
  <tr align="center" bgcolor="<?=$LIGHT;?>" class=p>
    <td height="34"><img src="../img/medal.gif" width="42" height="45"></td>
    <td height="34">:medal:</td>
    <td height="34"><img src="../img/leb.gif" width="74" height="22"></td>
    <td height="34">:leb:</td>
  </tr>
</table>
</body>
</html>
