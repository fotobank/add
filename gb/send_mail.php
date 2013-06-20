<?
define('SR_DENIED', true);
if (!include ("config.inc.php")) { die("Не найден рабочий файл конфигурации"); exit; }
function clean ($string)
{
	/////////// очистка строки адреса ////////////
	$string = preg_replace("'[^_A-Z.a-z0-9-]'","",$string);
	return ($string);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title><?=$gname?></title>
<? require ("design/css.inc.php"); ?>
<script language="JavaScript">
<!--
		function checkForm () {
			var name = document.sendform.name.value;
			var msg = document.sendform.text.value;
			var mail = document.sendform.mail.value;

			if(name=="") {
				alert("Пожалуйста, введите свое имя.");
				document.sendform.name.focus();
				return false;
			}

			if(mail == "") {
				alert("Пожалуйста, введите свой Email.");
				document.sendform.mail.focus();
				return false;
			}

			if(mail.indexOf('@',0) == -1 || mail.indexOf('.',0) == -1){
				alert("Вы ввели неправильный email.\nПроверьте правильность ввода email и нажмите еще раз.");
				document.sendform.mail.value="";
				document.sendform.mail.focus();
				return false;
			}

			if(msg=="") {
				alert("Пожалуйста, введите сообщение.");
				document.sendform.text.focus();
				return false;
			}

				return true;
			}
//-->
</script>

</head>

<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0"  bgcolor=<?=$BACKGROUND?>>
<? 
if (!isset($_POST["send"]))
{
	$mm1 = clean($_GET["mm1"]);
	$mm2 = clean($_GET["mm2"]);
?>
<form id="sendform" name="sendform" method="post" action="" onSubmit="return checkForm();">
  <label></label>
  <table width="400" border="0" cellpadding="1" cellspacing="1" bgcolor=<?=$BORDER;?>>
    <tr>
      <td align="center" bgcolor=<?=$DARK;?> class="pdark"><strong>Отправка письма на адрес <? echo "<img src=\"mail.php?mm1=".$mm1."&mm2=".$mm2."\" align=\"absmiddle\"/>"; ?></strong></td>
    </tr>
    <tr>
      <td bgcolor=<?=$LIGHT;?>><table width="100%" border="0" cellspacing="4" cellpadding="4">
        <tr>
          <td class=p>Имя<strong>*</strong>:
            <input name="mm1" type="hidden" id="mm1" value="<?=$mm1?>" />
            <input name="mm2" type="hidden" id="mm2" value="<?=$mm2?>" />
		  </td>
          <td><input class=p name="name" type="text" id="name" /></td>
        </tr>
        <tr>
          <td class=p>Ваш email<strong>*</strong>: </td>
          <td><input class=p name="mail" type="text" id="mail" /></td>
        </tr>
        <tr>
          <td class=p>Тема письма: </td>
          <td><input class=p name="theme" type="text" id="theme" /></td>
        </tr>
        <tr>
          <td class=p>Текст письма<strong>*</strong>: </td>
          <td><textarea class=p name="text" cols="25" rows="6" id="text"></textarea></td>
        </tr>
        <tr>
          <td colspan="2" class="p">* - поля обязательные для заполнения.</td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="send" type="submit" class="p" id="send" style="width:125px;cursor:hand;" onmouseover="this.style.backgroundColor='<?=$DARK;?>';" onmouseout="this.style.backgroundColor='<?=$LIGHT;?>';" value="Отправить"></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<?
}
else
{
//////////////// проверка email ////////////////


	$name           = htmlspecialchars(stripslashes(trim($_POST['name'])));
	$mail           = htmlspecialchars(stripslashes(trim($_POST['mail'])));
	$theme          = htmlspecialchars(stripslashes(trim($_POST['theme'])));
	$text           = htmlspecialchars(stripslashes(trim($_POST['text'])));
	$adresat = clean($_POST['mm2'])."@".clean($_POST['mm1']);
	$host = $_SERVER['HTTP_HOST'];
	$message = "Из гостевой $gname (сайт $host) Вам было послано сообщение
	~~
Имя ..................... $name
Email ................... $mail
Тема .................... $theme
Текст сообщения.......... $text
	~~
";	

		$subj = "Сообщение из гостевой сайта ".$host;
		$headers = "From: ".$mail."\r\nContent-Type: text/plain; charset=windows-1251\r\nContent-Transfer-Encoding: 8bit";
		if (@mail($adresat, $subj, $message, $headers))
		{
		}
		else
		{
			die('Невозможно отправить сообщение</body></html>');
			exit;
		}

?>
<table width="400" height="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="<?=$BORDER;?>">
  <tr>
    <td align="center" bgcolor="<?=$DARK;?>" class="p2"><strong>Отправка письма </strong></td>
  </tr>
  <tr>
    <td bgcolor="<?=$LIGHT;?>"><table width="100%" height="100%" border="0" cellpadding="4" cellspacing="4">
      <tr>
        <td height="100%" class="p"><p>Сообщение отправлено...<br />
          <img src="img/spacer.gif" alt="" width="1" height="175" /></p>
            <p align="right"><a href="javascript:self.close()">Закрыть окно &nbsp;&nbsp; </a></p></td>
      </tr>
    </table></td>
  </tr>
</table>

<?
}
?>
</body>
</html>
