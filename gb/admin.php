<?php

error_reporting(0);
$logined = 0;
define('SR_DENIED', true);
if (!include ("config.inc.php")) { die("Не найден рабочий файл конфигурации"); exit; }

function cut($string)
{
	$string = ereg_replace('\\\"',"&quot;",$string);
	$string = ereg_replace("\\\'","&quot;",$string);
	$string = str_replace("\r","",$string);
	$string = str_replace("\n","<br>",$string);
	$string = str_replace("%","&#37;",$string);
	$string = str_replace("^ +","",$string);
	$string = str_replace(" +$","",$string);
	$string = str_replace("|","l",$string);
	return ($string);
}

if (isset($_COOKIE["alogin"])) $alogin = $_COOKIE["alogin"];
if (isset($_POST["alogin"])) $alogin = $_POST["alogin"];
if (isset($_COOKIE["pass"])) $pass = $_COOKIE["pass"];
if (isset($_POST["pass"])) $pass = md5($_POST["pass"]);

$clean_rules = array('login','design','auto_exch','options','ban_list','base');
$QUERY_STRING = $_SERVER['QUERY_STRING'];
if (!in_array ($QUERY_STRING, $clean_rules)) $QUERY_STRING="login";

$error = "";

if (file_exists("passwords.php") && isset($alogin) && isset($pass) && $QUERY_STRING != ""):

	$handle=fopen('passwords.php',r);
	$string=rtrim(fgets($handle));
	while(strlen($string)) 
	{
	 $string=rtrim(fgets($handle));
	 $a=explode(":",$string);
	 if (($alogin==$a[0]) && ($pass==$a[1])) 
	   { 
	    $logined=1;
	   }
	}
	if ($logined)
	{
		setcookie("alogin",$alogin);
		setcookie("pass",$pass);	
	}
	else
	{
		$error = "Неверный логин или пароль";
		setcookie("alogin","",0);
		setcookie("pass","",0);
	}

endif;
?>

<html>
<head>
<title><?=$gname?></title>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="content-type" content="text/html; charset=windows-1251">
<style>
<?
header('Content-type: text/html; charset=windows-1251');
?>
body 
  {
  font-family: Verdana, Tahoma, Helvetica, Arial, sans-serif, "Arial Cyr"; font-size: 11px; color: #222222; 
  scrollbar-face-color: #E8E8FF;
  scrollbar-highlight-color: #CCCCCC;
  scrollbar-shadow-color: #CCCCCC;
  scrollbar-3dlight-color: #CCCCCC;
  scrollbar-arrow-color: #888888;
  scrollbar-track-color: #E8E8FF;
  scrollbar-darkshadow-color: #CCCCCC
  }
.p {color: #222222; font-size: 11px; font-family: Verdana, Tahoma}
.p1 {color: #6060B0; font-size: 11px; font-family: Verdana, Tahoma}
.p2 {color: #222222; font-size: 10px; font-family: Verdana, Tahoma}
.error {color: #FF0000; font-size: 11px; font-weight:bold; font-family: Verdana, Tahoma}
a:link {font-size: 11px; color: #6060B0; font-weight: normal; text-decoration: none}
a:visited {font-size: 11px; color: #6060B0; font-weight: normal; text-decoration: none}
a:active {font-size: 11px; color: #6060B0; font-weight: normal; text-decoration: none}
a:hover {font-size: 11px; color: #000000; font-weight: normal; text-decoration: none}
a.a:link {font-size: 11px; color: #6060B0; font-weight: bold; text-decoration: none}
a.a:visited {font-size: 11px; color: #6060B0; font-weight: bold; text-decoration: none}
a.a:active {font-size: 11px; color: #6060B0; font-weight: bold; text-decoration: none}
a.a:hover {font-size: 11px; color: #000000; font-weight: bold; text-decoration: none}
a.a1:link {font-size: 10px; color: #6060B0; font-weight: bold; text-decoration: none}
a.a1:visited {font-size: 10px; color: #6060B0; font-weight: bold; text-decoration: none}
a.a1:active {font-size: 10px; color: #6060B0; font-weight: bold; text-decoration: none}
a.a1:hover {font-size: 10px; color: #000000; font-weight: bold; text-decoration: none}
textarea,input { font-family: Verdana, Tahoma; font-size: 11px; background: #FFFFFF; border: 1pt solid #CCCCCC; color: #222222 }
</style>
</head>
<body bgcolor=#FFFFFF topmargin=10 leftmargin=0 marginwidth=0 marginheight=0>
<div align=center>
<table width=600 border=0 cellspacing=0 cellpadding=0>
<tr><td>
<table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC><tr>
  <td align=center class=p bgcolor=#E8E8FF><b><?=$gname?></b></td>
</tr></table>
</td></tr>
<tr><td>

<?php
if (!file_exists("passwords.php") && $QUERY_STRING == "login"):
	if (isset($_POST["alogin"])) $alogin = $_POST["alogin"];
	if (isset($_POST["pass"])) $pass = $_POST["pass"];
	echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table><table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC><tr><td align=center  class=p bgcolor=#FFFFFF>Сейчас будет создан файл с паролем...</b></td></tr></table>";
	if (isset($alogin) and $alogin != "" and isset($pass) and $pass != ""):
		$file = fopen("passwords.php","w");
		fputs($file,"<?php die('Access Denied'); ?>\r\n".$alogin.":".md5($pass));
		fclose($file);
		if (file_exists("passwords.php"))
		{
			echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table><table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC><tr><td align=center  class=p bgcolor=#FFFFFF>Файл с паролем создан.</b></td></tr></table>";
			echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table><table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC><tr><td align=center  class=p bgcolor=#FFFFFF><b>Теперь можете смело входить в админ.центр!</b></td></tr></table>";
		}
		else
		{
			echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table><table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC><tr><td align=center  class=p style=\"color:#FFFFFF\" bgcolor=#FF0000><b>Файл с паролем не создан!<br />Не получилось создать файл в директории гостевой книги.<br>Выставьте права 777 на директорию, в которой находится этот  скрипт<br>После установки пароля для админ.центра, смените права на 755</b></td></tr></table>";
		}
	else: echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table><table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC><tr><td align=center  class=p style=\"color:#FFFFFF\" bgcolor=#FF0000><b>Файл с паролем отсутствует, необходимо ввести логин, пароль для создания файла.</b></td></tr></table>";
	endif;
endif;

if ($logined == 1):

	echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table><table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC><tr>";
	echo "<td align=center class=p1 bgcolor=#FFFFFF>";
	echo "<b>.:</b> <a href=admin.php?login class=a>Правка</a>  <b>.:</b> ";
	//echo "<a href=admin.php?design class=a>Дизайн</a>  <b>.:</b> ";
	echo "<a href=admin.php?auto_exch class=a>Автозамена</a>  <b>.:</b> ";
	//echo "<a href=admin.php?options class=a>Настройки</a>  <b>.:</b> ";
	echo "<a href=admin.php?ban_list class=a>Бан-лист</a>  <b>.:</b> ";
	echo "<a href=admin.php?base class=a>База</a>  <b>.:</b> ";
	echo "<a href=index.php target=_blank class=a>Просмотр</a>  <b>.:</b> ";
	//echo "<a href=http://www.profy.org/gb/ target=_blank class=a>Помощь</a></td>";
	echo "</tr></table>";
	echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table>";

////////////// ПРАВКА СООБЩЕНИЙ //////////////

	if ($QUERY_STRING == "login" || ereg("^page",$QUERY_STRING)):
		if (isset($_POST["changes"])) $changes = $_POST["changes"];
		if (isset($_POST["delete"])) $delete = $_POST["delete"];
		if (isset($_POST["banip"])) $banip = $_POST["banip"];
		if (isset($_POST["banname"])) $banname = $_POST["banname"];
		if (isset($_POST["banall"])) $banall = $_POST["banall"];
		if (isset($_POST["save"])) $save = $_POST["save"];
		if (isset($_POST["id"])) $id=(int)$_POST["id"];
		if (isset($_POST["name"])) $name=cut($_POST["name"]);
		if (isset($_POST["mail"])) $mail=cut($_POST["mail"]);
		if (isset($_POST["url"])) $url=cut($_POST["url"]);
		if (isset($_POST["city"])) $city=cut($_POST["city"]);
		if (isset($_POST["mess"])) $mess=cut($_POST["mess"]);
		if (isset($_POST["answer"])) $answer=cut($_POST["answer"]);
		if (isset($_POST["ip"])) $ip=cut($_POST["ip"]);
		if (isset($_POST["date"])) $date=(int)$_POST["date"];
		
		if (!isset($_GET["page"])&&!isset($_POST["page"])) $page = 1;
		else if (!isset($_POST["page"])) $page = $_GET["page"];
		else $page = $_POST["page"];
		
		// запись в файлы данных
		if(isset($changes)||isset($delete)||isset($banip)||isset($banname)||isset($banall)):
			if(is_file($data) && is_readable($data)):
				$read=fopen($data,"r") or die("<p class=error>Не могу открыть файл $data</p>");
				$file_change=file("$data");
				fclose($read);
			endif;
			if(isset($changes)):
				$file_change[$id]="$name|$mess|$mail|$url|$city|$date|$answer|$ip\r\n";
				$number=$id+1;
			endif;
			if(isset($delete)):
				$file_change[$id]="";
				$number=$id+1;
			endif;
			if(isset($banip)):
				$file_change[$id]="";
				$number=$id+1;
				if(is_file($banlist) && is_writable($banlist))
				{
					$write=fopen($banlist,"a") or die("<p class=error>Не могу открыть файл $banlist</p>");
					flock($write,2);
					fputs($write,"$ip|Некорректное поведение!|\r\n");
					flock($write,3);
					fclose($write);
				}
			endif;
			if(isset($banname)):
				$file_change[$id]="";
				$number=$id+1;
				if(is_file($banlist) && is_writable($banlist))
				{
					$write=fopen($banlist,"a") or die("<p class=error>Не могу открыть файл $banlist</p>");
					flock($write,2);
					fputs($write,"999.999.999.999|Некорректное поведение!|$name\r\n");
					flock($write,3);
					fclose($write);
				}
			endif;
			if(isset($banall)):
				$file_change[$id]="";
				$number=$id+1;
				if(is_file($banlist) && is_writable($banlist))
				{
					$write=fopen($banlist,"a") or die("<p class=error>Не могу открыть файл $banlist</p>");
					flock($write,2);
					fputs($write,"$ip|Некорректное поведение!|$name\r\n");
					flock($write,3);
					fclose($write);
				}
			endif;
			if(is_file($data) && is_writable($data)):
				$write=fopen($data,"w") or die("<p class=error>Не могу открыть файл $data</p>");
				flock($write,2);
				foreach($file_change as $key=>$value)
					fputs($write,$value);
				flock($write,3);
				fclose($write);
			endif;
		endif;
		if(isset($save)):
			$file_change[$id]="$name|$mess|$mail|$url|$city|$date|$answer|$ip\r\n";
			$f=fopen($saves,"a");
			fputs($f,$file_change[$id]);
			fclose($f);
		endif;


		// чтение из файла данных
		if(is_file($data) && is_readable($data))
		{
			$readdata=fopen($data,"r") or die("<p class=error>Не могу открыть файл $data</p>");
			$file_array=file("$data");
			fclose($readdata);
		}
		else die("<p class=error>Файл $data не существует или запрещено чтение из него !</p>");
		$lines=count($file_array);
		$pages=(int)(($lines+$maxmess-1)/$maxmess);
		if($page==0||$page<0) {$page=1;}
		$from=$lines-($page*$maxmess-1);
		$to=$lines-(($page-1)*$maxmess);

		function getPages($total, $page, $link, $perpage)
		{
			$mpp = $perpage;
			$prev_page = $page - 1;
			$next_page = $page + 1;
			if ($total <= $mpp) $pages = 1;
			elseif($total % $mpp == 0) $pages = $total / $mpp;
			else $pages = $total / $mpp + 1;
			$pages = (int) $pages;
			$s_pages    = $page<7 ? 1 : floor($page / 7) * 7;
			$e_pages    = $page + 6;
			if ($e_pages > $pages) { $e_pages = $pages; }
			$s = "";
			if ($pages > 6){
			if($prev_page != 0) { $s = "<a href=\"".$link."page=1\"> &lt;&lt; </a>| \n"; }
			if($prev_page) { $s .= "<a href=\"".$link."page=$prev_page\"> &lt; </a>| \n"; }}
			for($i=$s_pages;$i<=$e_pages;$i++)
			{
				if ($i != $page) { $s .= "<a href=\"".$link."page=$i\" class=a1> $i </a>| \n"; }
				elseif ($i != 1) { $s .= " <b> $i |</b> "; }
				elseif ($page != $pages) { $s .= " <b> 1 |</b> "; }
			}
			if($page != $pages && $pages > 6)
			{
				$s .= "<a href=\"".$link."page=$next_page\"> &gt; </a>| \n";
				$s .= "<a href=\"".$link."page=$pages\"> &gt;&gt; </a>| \n";
			}
			if (!isset($s) || $s == "") { $s = " <b> 1 |</b> "; }
			return $s;
		}
		$echo_pages = getPages($lines, $page, "admin.php?", $maxmess);

		echo "<table bgcolor=#CCCCCC border=0 cellpadding=2 cellspacing=1 width=600><tr><td bgcolor=#FFFFFF class=p2 align=center><b>Всего сообщений : $lines</b></td></tr><tr><td bgcolor=#FFFFFF class=p2 align=center><b>Страницы : | $echo_pages</b></td></tr></table>";
		for($i=$to-1;$i>=$from-1;$i--)
		{
			$id=$i;
			list($name,$mess,$mail,$url,$city,$date,$answer,$ip)=explode("|", $file_array[$i]);
			if(!($name==""&&$mess=="")):
				$messnum=$id+1;
				$name = str_replace('"',"&quot;",$name);
				$mail = str_replace('"',"&quot;",$mail);
				$url = str_replace('"',"&quot;",$url);
				$city = str_replace('"',"&quot;",$city);
				$answer = str_replace("<br>","\n",$answer);
				$mess = str_replace("<br>","\n",$mess);
				$mess = str_replace('"',"&quot;",$mess);
				$answer = str_replace('"',"&quot;",$answer);
				
				echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table>";
				echo "<table border=0 cellpadding=2 cellspacing=1 width=600 bgcolor=#CCCCCC>";
				echo "<tr><td align=center class=p bgcolor=#E8E8FF><b>Сообщение #$messnum</b></td></tr>";
				echo "<tr><td bgcolor=#FFFFFF>";
				echo "<form action=admin.php?login method=post>";
				echo "<input name=id type=hidden value=$id>";
				echo "<input name=page type=hidden value=$page>";
				echo "<table width=527 cellspacing=2 cellpadding=1 border=0 align=center class=p>";
				echo "<tr><td align=right>Автор:</td><td align=center><input class=p style=\"width: 424px;\" name=name type=text value=\"$name\"></td></tr>";
				echo "<tr><td align=right>E-mail:</td><td align=center><input class=p style=\"width: 424px;\" name=mail type=text value=\"$mail\"></td></tr>";
				echo "<tr><td align=right>Home Page:</td><td align=center><input class=p style=\"width: 424px;\" name=url type=text value=\"$url\"></td></tr>";
				echo "<tr><td align=right>Город:</td><td align=center><input class=p style=\"width: 424px;\" name=city type=text value=\"$city\"></td></tr>";
				echo "<tr><td align=right>Время:</td><td align=center><input class=p style=\"width: 424px;\" name=date type=text value=\"$date\"></td></tr>";
				echo "<tr><td align=right>IP:</td><td align=center><input class=p style=\"width: 424px;\" name=ip type=text value=$ip></td></tr>";
				echo "<tr><td align=right>Сообщение:</td><td align=center><textarea class=p style=\"width: 424px;\" name=mess rows=5 cols=80>$mess</textarea></td></tr>";
				echo "<tr><td align=right>Ответ:</td><td align=center><textarea class=p style=\"width: 424px;\" name=answer rows=5 cols=80>$answer</textarea></td></tr>";
				echo "<tr><td colspan=2 align=center><input type=submit style=\"color:#000000;width:100px;cursor:hand;\" name=changes value=\"Изменить\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\">&nbsp;&nbsp;";
				echo "<input type=submit style=\"color:#000000;width:100px;cursor:hand;\" name=save value=\"Сохранить\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\">&nbsp;&nbsp;";
				echo "<input type=submit style=\"color:#CC0000;width:100px;cursor:hand;\" name=delete value=\"Удалить\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\"></td></tr>";
				echo "<tr><td colspan=2 align=center><input type=submit style=\"color:#CC0000;width:100px;cursor:hand;\" name=banip value=\"Бан IP\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\">&nbsp;&nbsp;";
				echo "<input type=submit style=\"color:#CC0000;width:100px;cursor:hand;\" name=banname value=\"Бан имени\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\">&nbsp;&nbsp;";
				echo "<input type=submit style=\"color:#CC0000;width:100px;cursor:hand;\" name=banall value=\"Бан IP+имени\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\"></td></tr>";
				echo "</table></form>";
				echo "</td></tr></table>";
			endif;
		}
		echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table>";
		echo "<table bgcolor=#CCCCCC border=0 cellpadding=2 cellspacing=1 width=600><tr><td bgcolor=#FFFFFF class=p2 align=center><b>Страницы : | $echo_pages</b></td></tr><tr><td bgcolor=#FFFFFF class=p2 align=center><b>Всего сообщений : $lines</b></td></tr></table>";
		$QUERY_STRING=="login";
	endif;

////////////// ПРАВКА ДИЗАЙНА //////////////

	if ($QUERY_STRING=="design"):
		
		// запись в файлы данных
		
		if(isset($_POST["change_design"])):
			if(is_file($header) && is_writable($header)):
				$myhead = $_POST["myhead"];
				$myhead = ereg_replace("\\\'","'",$myhead);
				$myhead = ereg_replace('\\\"','"',$myhead);
				$myhead = str_replace ("&lt;", "<", $myhead);
				$myhead = str_replace ("&gt;", ">", $myhead);
				$writech=fopen($header,"w") or die("<p class=error>Не могу открыть файл $header</p>");
				flock($writech,2);
				fputs($writech,"$myhead");
				flock($writech,3);
				fclose($writech);
			endif;
			if(is_file($footer) && is_writable($footer)):
				$myfoot = $_POST["myfoot"];
				$myfoot=ereg_replace("\\\'","'",$myfoot);
				$myfoot=ereg_replace('\\\"','"',$myfoot);
				$myfoot = str_replace ("&lt;", "<", $myfoot);
				$myfoot = str_replace ("&gt;", ">", $myfoot);
				$writech=fopen($footer,"w") or die("<p class=error>Не могу открыть файл $footer</p>");
				flock($writech,2);
				fputs($writech,"$myfoot");
				flock($writech,3);
				fclose($writech);
			endif;
			if(is_file($send_form) && is_writable($send_form)):
				$mysend = $_POST["mysend"];
				$mysend = ereg_replace("\\\'", "'", $mysend);
				$mysend = ereg_replace('\\\"', '"', $mysend);
				$mysend = str_replace ("&lt;", "<", $mysend);
				$mysend = str_replace ("&gt;", ">", $mysend);
				$writech=fopen($send_form,"w") or die("<p class=error>Не могу открыть файл $send_form</p>");
				flock($writech,2);
				fputs($writech,"$mysend");
				flock($writech,3);
				fclose($writech);
			endif;
		endif;

		// чтение из файлов данных
		
		echo "<table border=0 cellpadding=3 cellspacing=1 width=600 bgcolor=#CCCCCC class=p>";
		echo "<tr><td align=center bgcolor=#E8E8FF><b>Дизайн гостевой книги</b></td></tr>";
		echo "<tr><td bgcolor=#FFFFFF align=center><form action=admin.php?design method=post>";
		echo "<table width=592 cellspacing=3 cellpadding=1 border=0 class=p>";

		$head_arr=file("$header");
		$ddd=count($head_arr);
		$head_arr = str_replace ("<", "&lt;", $head_arr);
		$head_arr = str_replace (">", "&gt;", $head_arr);
		echo "<tr><td align=center width=592>header.inc.php :</td></tr>";
		echo "<tr><td align=center width=592><textarea class=p style=\"width: 550px;\" name=myhead rows=10>";
		for($i=0;$i<$ddd;$i++)
		{
			echo "$head_arr[$i]";
		}
		echo "</textarea></td></tr>";

		$foot_arr=file("$footer");
		$fff=count($foot_arr);
		$foot_arr = str_replace ("<", "&lt;", $foot_arr);
		$foot_arr = str_replace (">", "&gt;", $foot_arr);
		echo "<tr><td align=center width=592>footer.inc.php :</td></tr>";
		echo "<tr><td align=center width=592><textarea class=p style=\"width: 550px;\" name=myfoot rows=10>";
		for($i=0;$i<$fff;$i++)
		{
			echo "$foot_arr[$i]";
		}
		echo "</textarea></td></tr>";

		$send_arr=file("$send_form");
		$sss=count($send_arr);
		$send_arr = str_replace ("<", "&lt;", $send_arr);
		$send_arr = str_replace (">", "&gt;", $send_arr);
		echo "<tr><td align=center width=600>send.inc.php :</td></tr>";
		echo "<tr><td align=center width=600><textarea class=p style=\"width: 550px;\" name=mysend rows=10>";
		for($i=0;$i<$sss;$i++)
		{
			echo "$send_arr[$i]";
		}
		echo "</textarea></td></tr>";

		echo "<tr><td align=center><input type=submit style=\"color:#000000;width:200px;cursor:hand;\" name=change_design value=\"Внести изменения\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\"></td></tr>";
		echo "</form></table>";
		echo "</td></tr></table>";

		echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table>";
		echo "<table border=0 cellpadding=3 cellspacing=1 width=600 bgcolor=#CCCCCC class=p>";
		echo "<tr><td align=center bgcolor=#E8E8FF><b>Перечисленное ниже трогать не рекомендуется</b></td></tr>";
		echo "<tr><td bgcolor=#FFFFFF align=center><table width=527 cellspacing=3 cellpadding=1 border=0 class=p>";
		echo "<tr><td align=left width=527>$ name - имя автора сообщения<br>$ mail - его e-mail<br>$ url - его домашняя страничка<br>$ city - название города, откуда он<br>$ mess - сам текст сообщения<br>$ answer - Ваш ответ на сообщение</td></tr>";
		echo "<tr>
            <td align=center width=527>Также настоятельно рекомендуется не удалять и не изменять  функции <strong>javascript</strong> и то, что находится между тегами <strong>&lt;?</strong> и <strong>?&gt;</strong>. Если Вы захотите что-то изменить, лучше делать это в настройках.</td>
          </tr>";
		echo "</table></td></tr></table>";

		$QUERY_STRING=="design";
	endif;

////////////// СТРАНИЦА АВТОЗАМЕНЫ //////////////

	if ($QUERY_STRING=="auto_exch"):

		// запись в файл данных

		if(isset($_POST["change_auto"])):
			$ttt = count($_POST["change1_"]);
			$change1_ = $_POST["change1_"];
			$change2_ = $_POST["change2_"];
			if(is_file($exech) && is_writable($exech)):
				$writech=fopen($exech,"w") or die("<p class=error>Не могу открыть файл $exech</p>");
				flock($writech,2);
				for($i=0;$i<$ttt;$i++)
				{
					if($change1_[$i]!="")
					fputs($writech,"$change1_[$i]|$change2_[$i]\r\n");
				}
				flock($writech,3);
				fclose($writech);
			endif;
		endif;
		if(isset($_POST["add_new_auto"])&&$_POST["newchange1"]!=""&&$_POST["newchange2"]!=""):
			if(is_file($exech) && is_writable($exech)):
				$write=fopen($exech,"a") or die("<p class=error>Не могу открыть файл $exech</p>");
				$newchange1 = $_POST["newchange1"];
				$newchange2 = $_POST["newchange2"];
				flock($write,2);
				fputs($write,"$newchange1|$newchange2\r\n");
				flock($write,3);
				fclose($write);
			endif;
		endif;

		// чтение из файла данных

		echo "<table border=0 cellpadding=3 cellspacing=1 width=600 bgcolor=#CCCCCC class=p>";
		echo "<tr><td align=center bgcolor=#E8E8FF><b>Автозамены в гостевой книге</b></td></tr>";
		echo "<tr><td bgcolor=#FFFFFF align=center><form action=admin.php?auto_exch method=post>";
		echo "<table width=590 cellspacing=5 cellpadding=1 border=0 class=p>";
		$autochange=file("$exech");
		$lines=count($autochange);
		for($i=0;$i<$lines;$i++)
		{
			list($change1,$change2)=explode("|", $autochange[$i]);
			echo "<tr><td align=center width=590><input class=p style=\"width: 125px;\" name=change1_[] type=text value=$change1> >> <input class=p style=\"width: 420px;\" name=change2_[] type=text value=\"$change2\"></td></tr>";
		}
		echo "<tr><td align=center width=590>Если Вы захотите удалить какую-нибудь автозамену,<br> сотрите первое поле и нажмите на кнопку:</td></tr>";
		echo "<tr><td align=center><input type=submit style=\"color:#000000;width:200px;cursor:hand;\" name=change_auto value=\"Внести изменения\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\"></td></tr>";
		echo "</form></table>";
		echo "</td></tr></table>";
		echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table>";
		echo "<table border=0 cellpadding=3 cellspacing=1 width=600 bgcolor=#CCCCCC class=p>";
		echo "<tr><td align=center bgcolor=#E8E8FF><b>Добавление новой автозамены</b></td></tr>";
		echo "<tr><td bgcolor=#FFFFFF align=center><form action=admin.php?auto_exch method=post>";
		echo "<table width=590 cellspacing=5 cellpadding=1 border=0 class=p>";
		echo "<tr><td align=center width=590><input class=p style=\"width: 125px;\" name=newchange1 type=text> >> <input class=p style=\"width: 420px;\" name=newchange2 type=text></td></tr>";
		echo "<tr><td align=center><input type=submit style=\"color:#000000;width:200px;cursor:hand;\" name=add_new_auto value=\"Добавить\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\"></td></tr>";
		echo "</form></table>";
		echo "</td></tr></table>";

		$QUERY_STRING=="auto_exch";
	endif;

////////////// ИЗМЕНЕНИЕ НАСТРОЕК //////////////

	if ($QUERY_STRING=="options"):

		// запись в файл настроек

		if(isset($_POST["change_opt"])):
			$upconfig="<?php\r\nif ( !defined('SR_DENIED') ) { die('Неправильный вызов скрипта'); exit; }\r\n";
			if ($_POST["TABWIDTH_"]<400&&!eregi("\%",$_POST["TABWIDTH_"])) $TABWIDTH_ = 400; else $TABWIDTH_ = $_POST["TABWIDTH_="];
			$upconfig.="\$TABWIDTH = \"".$_POST["TABWIDTH_"]."\";\r\n";
			$upconfig.="\$BACKGROUND = \"".$_POST["BACKGROUND_"]."\";\r\n";
			$upconfig.="\$FONT = \"".$_POST["FONT_"]."\";\r\n";
			if ($_POST["FONTSIZE_"]<10) $FONTSIZE_ = 10;
			else if ($_POST["FONTSIZE_"]>15) $FONTSIZE_ = 15;
			else $FONTSIZE_ = $_POST["FONTSIZE_"];
			$upconfig.="\$FONTSIZE = ".$FONTSIZE_.";\r\n";
			$upconfig.="\$BORDER = \"".$_POST["BORDER_"]."\";\r\n";
			$upconfig.="\$DARK = \"".$_POST["DARK_"]."\";\r\n";
			$upconfig.="\$DARKFONTCOLOR = \"".$_POST["DARKFONTCOLOR_"]."\";\r\n";
			$upconfig.="\$DARKFONTLINK = \"".$_POST["DARKFONTLINK_"]."\";\r\n";
			$upconfig.="\$DARKFONTLINKHOVER = \"".$_POST["DARKFONTLINKHOVER_"]."\";\r\n";
			$upconfig.="\$LIGHT = \"".$_POST["LIGHT_"]."\";\r\n";
			$upconfig.="\$LIGHTFONTCOLOR = \"".$_POST["LIGHTFONTCOLOR_"]."\";\r\n";
			$upconfig.="\$LIGHTFONTLINK = \"".$_POST["LIGHTFONTLINK_"]."\";\r\n";
			$upconfig.="\$LIGHTFONTLINKHOVER = \"".$_POST["LIGHTFONTLINKHOVER_"]."\";\r\n";
			$upconfig.="\$ANSW = \"".$_POST["ANSW_"]."\";\r\n";
			$upconfig.="\$ANSWFONTCOLOR = \"".$_POST["ANSWFONTCOLOR_"]."\";\r\n";
			$upconfig.="\$ANSWFONTLINK = \"".$_POST["ANSWFONTLINK_"]."\";\r\n";
			$upconfig.="\$ANSWFONTLINKHOVER = \"".$_POST["ANSWFONTLINKHOVER_"]."\";\r\n";
			$upconfig.="\$version = \"".$_POST["version_"]."\";\r\n";
			$upconfig.="\$gname = \"".$_POST["gname_"]."\";\r\n";
			$upconfig.="\$maxmess = \"".$_POST["maxmess_"]."\";\r\n";
			$upconfig.="\$maxlenght = \"".$_POST["maxlenght_"]."\";\r\n";
			$upconfig.="\$maxword = \"".$_POST["maxword_"]."\";\r\n";
			$upconfig.="\$maxmail = \"".$_POST["maxmail_"]."\";\r\n";
			$upconfig.="\$maxurl = \"".$_POST["maxurl_"]."\";\r\n";
			$upconfig.="\$maxcity = \"".$_POST["maxcity_"]."\";\r\n";
			$upconfig.="\$PICWIDTH = \"".$_POST["PICWIDTH_"]."\";\r\n";
			$upconfig.="\$PICHEIGHT = \"".$_POST["PICHEIGHT_"]."\";\r\n";
			$upconfig.="\$config = \"".$_POST["config_"]."\";\r\n";
			$upconfig.="\$data = \"".$_POST["data_"]."\";\r\n";
			$upconfig.="\$saves = \"".$_POST["saves_"]."\";\r\n";
			$upconfig.="\$exech = \"".$_POST["exech_"]."\";\r\n";
			$upconfig.="\$banlist = \"".$_POST["banlist_"]."\";\r\n";
			$upconfig.="\$backup = \"".$_POST["backup_"]."\";\r\n";
			$upconfig.="\$footer = \"".$_POST["footer_"]."\";\r\n";
			$upconfig.="\$header = \"".$_POST["header_"]."\";\r\n";
			$upconfig.="\$send_form = \"".$_POST["send_form_"]."\";\r\n";
			$upconfig.="\$anti_email = \"".$_POST["anti_email_"]."\";\r\n";
			$upconfig.="\$email_size = \"".$_POST["email_size_"]."\";\r\n";
			$upconfig.="\$spamcontrol = \"".$_POST["spamcontrol_"]."\";\r\n";
			$upconfig.="\$spamcontrol_length = ".$_POST["spamcontrol_length_"].";\r\n";
			$upconfig.="\$spamcontrol_size = \"".$_POST["spamcontrol_size_"]."\";\r\n";
			$upconfig.="\$spamcontrol_color = \"".$_POST["spamcontrol_color_"]."\";\r\n";
			$upconfig.="\$mailto = \"".$_POST["mailto_"]."\";\r\n";
			$upconfig.="\$send_mail = \"".$_POST["send_mail_"]."\";\r\n";
			$upconfig.="\$mail_spam = \"".$_POST["mail_spam_"]."\";\r\n";
			$upconfig.="?>";
			if(is_file($config) && is_writable($config)):
				$write=fopen($config,"w") or die("<p class=error>Не могу открыть файл $config</p>");
				flock($write,2);
				fputs($write,$upconfig);
				flock($write,3);
				fclose($write);
			endif;
		endif;
     
		// чтение из файла настроек

		include("config.inc.php");
		echo "<table border=0 cellpadding=3 cellspacing=1 width=600 bgcolor=#CCCCCC class=p>";
		echo "<tr><td align=center bgcolor=#E8E8FF><b>Настройки гостевой книги</b></td></tr>";
		echo "<tr><td bgcolor=#FFFFFF align=center><form action=admin.php?options method=post>";
		echo "<table width=590 cellspacing=5 cellpadding=1 border=0 class=p>";
		echo "<tr><td align=left width=427>Название гостевой книги:</td><td width=100><input class=p name=\"gname_\" type=text value=\"$gname\"><input name=\"version_\" type=\"hidden\" id=\"version_\" value=\"$version\"></td></tr>";
		echo "<tr><td align=left width=427>Ширина гостевой книги (не менее 400 пикс.):</td><td width=100><input class=p name=\"TABWIDTH_\" type=text value=\"$TABWIDTH\"></td></tr>";
		echo "<tr><td align=left width=427>Шрифты гостевой книги:</td><td width=100><input class=p name=\"FONT_\" type=text value=\"$FONT\"></td></tr>";
		echo "<tr><td align=left width=427>Размер основного шрифта гостевой книги (от 10 до 15):</td><td width=100><input class=p name=\"FONTSIZE_\" type=text value=\"$FONTSIZE\"></td></tr>";
		echo "<tr><td align=center width=427><b>Настройки цветов (общие)</b></td><td width=100></td></tr>";
		echo "<tr><td align=left width=427>Цвет фона всей страницы:</td><td width=100><input class=p style=\"background: $BACKGROUND;\" name=BACKGROUND_ type=text value=$BACKGROUND></td></tr>";
		echo "<tr><td align=left width=427>Цвет границ гостевой книги:</td><td width=100><input class=p style=\"background: $BORDER;\" name=BORDER_ type=text value=$BORDER></td></tr>";
		echo "<tr><td align=left width=427>Цвет темных ячеек гостевой книги:</td><td width=100><input class=p style=\"background: $DARK; color=$DARKFONTCOLOR\" name=DARK_ type=text value=$DARK></td></tr>";
		echo "<tr><td align=left width=427>Цвет шрифта в темных ячейках гостевой книги:</td><td width=100><input class=p style=\"background: $DARK; color=$DARKFONTCOLOR\" name=DARKFONTCOLOR_ type=text value=$DARKFONTCOLOR></td></tr>";
		echo "<tr><td align=left width=427>Цвет ссылок в темных ячейках гостевой книги:</td><td width=100><input class=p style=\"background: $DARK; color=$DARKFONTLINK\" name=DARKFONTLINK_ type=text value=$DARKFONTLINK></td></tr>";
		echo "<tr><td align=left width=427>Цвет ссылок в темных ячейках гостевой книги при наведении курсора:</td><td width=100><input class=p style=\"background: $DARK; color=$DARKFONTLINKHOVER\" name=DARKFONTLINKHOVER_ type=text value=$DARKFONTLINKHOVER></td></tr>";
		echo "<tr><td align=left width=427>Цвет светлых ячеек гостевой книги:</td><td width=100><input class=p style=\"background: $LIGHT; color=$LIGHTFONTCOLOR\" name=LIGHT_ type=text value=$LIGHT></td></tr>";
		echo "<tr><td align=left width=427>Цвет шрифта в светлых ячейках гостевой книги:</td><td width=100><input class=p style=\"background: $LIGHT; color=$LIGHTFONTCOLOR\" name=LIGHTFONTCOLOR_ type=text value=$LIGHTFONTCOLOR></td></tr>";
		echo "<tr><td align=left width=427>Цвет ссылок в светлых ячейках гостевой книги:</td><td width=100><input class=p style=\"background: $LIGHT; color=$LIGHTFONTLINK\" name=LIGHTFONTLINK_ type=text value=$LIGHTFONTLINK></td></tr>";
		echo "<tr><td align=left width=427>Цвет ссылок в светлых ячейках гостевой книги при наведении курсора:</td><td width=100><input class=p style=\"background: $LIGHT; color=$LIGHTFONTLINKHOVER\" name=LIGHTFONTLINKHOVER_ type=text value=$LIGHTFONTLINKHOVER></td></tr>";
		echo "<tr><td align=left width=427>Цвет ответа администратора:</td><td width=100><input class=p style=\"background: $ANSW; color=$ANSWFONTCOLOR\" name=ANSW_ type=text value=$ANSW></td></tr>";
		echo "<tr><td align=left width=427>Цвет шрифта ответа администратора:</td><td width=100><input class=p style=\"background: $ANSW; color=$ANSWFONTCOLOR\" name=ANSWFONTCOLOR_ type=text value=$ANSWFONTCOLOR></td></tr>";
		echo "<tr><td align=left width=427>Цвет ссылок в ответе администратора:</td><td width=100><input class=p style=\"background: $ANSW; color=$ANSWFONTLINK\" name=ANSWFONTLINK_ type=text value=$ANSWFONTLINK></td></tr>";
		echo "<tr><td align=left width=427>Цвет ссылок в ответе администратора при наведении курсора:</td><td width=100><input class=p style=\"background: $ANSW; color=$ANSWFONTLINKHOVER\" name=ANSWFONTLINKHOVER_ type=text value=$ANSWFONTLINKHOVER></td></tr>";
		echo "<tr><td align=center width=427><b>Настройки сообщений</b></td><td width=100></td></tr>";
		echo "<tr><td align=left width=427>Максимальное количество сообщений на странице:</td><td width=100><input class=p name=maxmess_ type=text value=$maxmess></td></tr>";
		echo "<tr><td align=left width=427>Максимальное количество символов в сообщении:</td><td width=100><input class=p name=maxlenght_ type=text value=$maxlenght></td></tr>";
		echo "<tr><td align=left width=427>Максимальное количество символов в слове:</td><td width=100><input class=p name=maxword_ type=text value=$maxword></td></tr>";
		echo "<tr><td align=left width=427>Максимальное количество символов в e-mail:</td><td width=100><input class=p name=maxmail_ type=text value=$maxmail></td></tr>";
		echo "<tr><td align=left width=427>Максимальное количество символов в URL:</td><td width=100><input class=p name=maxurl_ type=text value=$maxurl></td></tr>";
		echo "<tr><td align=left width=427>Максимальное количество символов в названии города:</td><td width=100><input class=p name=maxcity_ type=text value=$maxcity></td></tr>";
		echo "<tr><td align=center width=427><b>Максимальные размеры рисунков, которые пользователи могут вставлять в текст своих сообщений</b></td><td width=100></td></tr>";
		echo "<tr><td align=left width=427>Ширина (должна быть меньше, чем ширина самой гостевой!):</td><td width=100><input class=p name=PICWIDTH_ type=text value=$PICWIDTH></td></tr>";
		echo "<tr><td align=left width=427>Высота:</td><td width=100><input class=p name=PICHEIGHT_ type=text value=$PICHEIGHT></td></tr>";		   
		echo "<tr><td align=center width=427><b>Пути к файлам</b></td><td width=100></td></tr>";
		echo "<tr><td align=left width=427>Путь к файлу с настройками гостевой книги:</td><td width=100><input class=p name=config_ type=text value=$config></td></tr>";
		echo "<tr><td align=left width=427>Путь к файлу с базой данных:</td><td width=100><input class=p name=data_ type=text value=$data></td></tr>";
		echo "<tr><td align=left width=427>Путь к файлу с избранными сообщениями:</td><td width=100><input class=p name=saves_ type=text value=$saves></td></tr>";
		echo "<tr><td align=left width=427>Путь к файлу с настройками автозамены в гостевой книге:</td><td width=100><input class=p name=exech_ type=text value=$exech></td></tr>";
		echo "<tr><td align=left width=427>Путь к файлу с ip-адресами нехороших человеков:</td><td width=100><input class=p name=banlist_ type=text value=$banlist></td></tr>";
		echo "<tr><td align=left width=427>Путь к файлу backup:</td><td width=100><input class=p name=backup_ type=text value=$backup></td></tr>";
		echo "<tr><td align=left width=427>Путь к файлу header.inc.php:</td><td width=100><input class=p name=header_ type=text value=$header></td></tr>";
		echo "<tr><td align=left width=427>Путь к файлу footer.inc.php:</td><td width=100><input class=p name=footer_ type=text value=$footer></td></tr>";
		echo "<tr><td align=left width=427>Путь к файлу с формой для новых сообщений:</td><td width=100><input class=p name=send_form_ type=text value=$send_form></td></tr>";
		echo "<tr><td align=center width=427><b>Защита email от спама</b></td><td width=100></td></tr>";
		echo "<tr><td align=left width=427>Включить защиту email от спама (yes/no):</td><td width=100><input class=p name=anti_email_ type=text value=$anti_email></td></tr>";
		echo "<tr><td align=left width=427>Размер шрифта email (работает при включенной защите email):</td><td width=100><input class=p name=email_size_ type=text value=$email_size></td></tr>";
		echo "<tr><td align=center width=427><b>Защита гостевой от спама</b></td><td width=100></td></tr>";
		echo "<tr><td align=left width=427>Включить защиту от спама (yes/no):</td><td width=100><input class=p name=spamcontrol_ type=text value=$spamcontrol></td></tr>";
		echo "<tr><td align=left width=427>Количество цифр в коде спам-защиты (работает при включенном антиспаме):</td><td width=100><input class=p name=spamcontrol_length_ type=text value=$spamcontrol_length></td></tr>";	  
		echo "<tr><td align=left width=427>Размер шрифта кода спам-защиты (работает при включенном антиспаме):</td><td width=100><input class=p name=spamcontrol_size_ type=text value=$spamcontrol_size></td></tr>";
		echo "<tr><td align=left width=427>Цвет шрифта кода спам-защиты (работает при включенном антиспаме):</td><td width=100><input class=p name=spamcontrol_color_ type=text value=$spamcontrol_color style=\"color:$spamcontrol_color;\"></td></tr>";  
		echo "<tr><td align=center width=427><b>Уведомление администратора о новых сообщениях</b></td><td width=100></td></tr>";
		echo "<tr><td align=left width=427>E-mail администратора:</td><td width=100><input class=p name=mailto_ type=text value=$mailto></td></tr>";
		echo "<tr><td align=left width=427>Отправлять новые сообщения на этот e-mail (yes/no):</td><td width=100><input class=p name=send_mail_ type=text value=$send_mail></td></tr>";
		echo "<tr><td align=left width=427>В том числе отправлять сообщения, заблокированные спам-защитой (yes/no):</td><td width=100><input class=p name=mail_spam_ type=text value=$mail_spam></td></tr>";
		echo "<tr><td colspan=2 align=center><input type=submit style=\"color:#000000;width:200px;cursor:hand;\" name=change_opt value=\"Внести изменения\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\"></td></tr>";
		echo "</form></table>";
		echo "</td></tr></table>";

		$QUERY_STRING=="options";
	endif;

////////////// БАН-ЛИСТ //////////////

	if ($QUERY_STRING=="ban_list"):

		// запись в файл 

		if(isset($_POST["change_ban"])):
			$badip_ = $_POST["badip_"];
			$why_ = $_POST["why_"];
			$who_ = $_POST["who_"];
			$bbb=count($badip_);
			if(is_file($banlist) && is_writable($banlist)):
				$writeb=fopen($banlist,"w") or die("<p class=error>Не могу открыть файл $banlist</p>");
				flock($writeb,2);
				for($i=0;$i<$bbb;$i++)
				{
					if($badip_[$i]!="")
					fputs($writeb,"$badip_[$i]|$why_[$i]|$who_[$i]\r\n");
				}
				flock($writeb,3);
				fclose($writeb);
			endif;
		endif;
		if(isset($_POST["add_new_ban"])&&$_POST["newbadip"]!=""):
			if(is_file($banlist) && is_writable($banlist)):
				$write=fopen($banlist,"a") or die("<p class=error>Не могу открыть файл $banlist</p>");
				flock($write,2);
				$newbadip = $_POST["newbadip"];
				$newhy = $_POST["newhy"];
				$newho = $_POST["newho"];
				fputs($write,"$newbadip|$newhy|$newho\r\n");
				flock($write,3);
				fclose($write);
			endif;
		endif;

		// чтение из файла
		
		echo "<table border=0 cellpadding=3 cellspacing=1 width=600 bgcolor=#CCCCCC class=p>";
		echo "<tr><td align=center bgcolor=#E8E8FF><b>Доска позора (aka Бан-лист)</b></td></tr>";
		$banips=file("$banlist");
		$banlines=count($banips);
		if($banlines!=0)
		{
			echo "<tr><td bgcolor=#FFFFFF align=center><form action=admin.php?ban_list method=post>";
			echo "<table width=590 cellspacing=5 cellpadding=1 border=0 class=p>";
			echo "<tr><td align=center width=590>Читать и писать в гостевой книге запрещено следующим мерзопакостным личностям:</td></tr>";
			for($i=0;$i<$banlines;$i++)
			{
				list($badip,$why,$who)=explode("|", $banips[$i]);
				echo "<tr><td align=center width=590>Бан IP: <input class=p style=\"width: 90px;\" name=badip_[] type=text value=$badip> Бан имени: <input class=p style=\"width: 150px;\" name=who_[] type=text value=\"$who\"> Причина: <input class=p style=\"width: 150px;\" name=why_[] type=text value=\"$why\"></td></tr>";
			}
			echo "<tr>
                 <td align=center width=590>Чтобы удалить строку из списка вредителей,<br>
                   просто сотрите IP и нажмите на кнопку:</td></tr>";
			echo "<tr><td align=center><input type=submit style=\"color:#000000;width:200px;cursor:hand;\" name=change_ban value=\"Внести изменения\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\"></td></tr>";
               echo "</form></table>";
		}
		else echo "<tr><td bgcolor=#FFFFFF align=center width=600>На удивление, доска позора пуста.";
		echo "</td></tr></table>";

		echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table>";
		echo "<table border=0 cellpadding=3 cellspacing=1 width=600 bgcolor=#CCCCCC class=p>";
		echo "<tr><td align=center bgcolor=#E8E8FF><b>Добавление новой \"редиски\"</b></td></tr>";
		echo "<tr><td bgcolor=#FFFFFF align=center><form action=admin.php?ban_list method=post>";
		echo "<table width=590 cellspacing=7 cellpadding=1 border=0 class=p>";
		echo "<tr><td align=center width=590> IP: <input class=p style=\"width: 90px;\" name=newbadip type=text> Известен как: <input class=p style=\"width: 150px;\" name=newho type=text> Причина: <input class=p style=\"width: 150px;\" name=newhy type=text></td></tr>";
		echo "<tr><td align=center><input type=submit style=\"color:#000000;width:200px;cursor:hand;\" name=add_new_ban value=\"Добавить\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\"></td></tr>";
		echo "<tr><td><p>1) <b>Вы можете забанить диапазон ip-адресов, указав адрес не полностью</b> (при блокировке ищется вхождение строки).<br/>Например, если вы укажете &quot;101.101.101.&quot;, то будут забанены все адреса в диапазоне 101.101.101.0-101.101.101.255</p><p>2) <b>Чтобы забанить ТОЛЬКО имя</b>, укажите для него любой несуществующий в природе ip-адрес, например, 999.999.999.999</p><p>3) <b>Будьте осторожны с баном имён</b>, не надо банить распространенные имена и ники</p></td></tr>";
		echo "</form></table>";
		echo "</td></tr></table>";

		$QUERY_STRING=="ban_list";
	endif;

////////////// РАБОТА С БАЗОЙ СООБЩЕНИЙ //////////////
     
	if ($QUERY_STRING=="base"):

		// полный бэкап базы сообщений
		
		if(isset($_POST["backup_all"])):
			$original=file("$data");
			$f=fopen($backup,"w");
			foreach($original as $value) fputs($f,$value);
			fclose($f);
			$back="<b>Готово!</b>";
		endif;
		
		// чистка базы сообщений
		
		if(isset($_POST["clean_all"]) && $_POST["leave"] != 0):
			$arrr=file("$data");
			$cnts = count($arrr);
			$m = $cnts - $_POST["leave"];
			$f=fopen($data,"w");
			foreach($arrr as $n=>$value)
			{
				if($n >= $m) { fputs($f,$value); }
			}
			fclose($f);
			$cl="<b>Готово!</b>";
		endif;
          
		echo "<table border=0 cellpadding=3 cellspacing=1 width=600 bgcolor=#CCCCCC class=p>";
		echo "<tr><td align=center bgcolor=#E8E8FF><b>Backup базы данных</b></td></tr>";
		echo "<tr><td bgcolor=#FFFFFF align=center width=600><br>Сделать backup всех сообщений?";  if (isset($back) && $back!="") { echo " $back"; }
		echo "<br><br><form action=admin.php?base method=post><input type=submit style=\"color:#000000;width:100px;cursor:hand;\" name=backup_all value=\"Backup\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\"></form>";
		echo "</td></tr></table>";
		echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table>";
		echo "<table border=0 cellpadding=3 cellspacing=1 width=600 bgcolor=#CCCCCC class=p>";
		echo "<tr><td align=center bgcolor=#E8E8FF><b>Почистим базу?</b></td></tr>";
		echo "<tr><td bgcolor=#FFFFFF align=center width=600><br><form action=admin.php?base method=post>Оставить последние <input class=p style=\"width: 30px;\" name=leave type=text value=\"100\"> сообщений, остальные стереть.";  if (isset($cl) && $cl!="") { echo " $cl"; }
		echo "<br><br><input type=submit style=\"color:#000000;width:100px;cursor:hand;\" name=clean_all value=\"Поехали\" onmouseover=\"this.style.backgroundColor='#E8E8FF';\" onmouseout=\"this.style.backgroundColor='#FFFFFF';\"></form>";
		echo "</td></tr></table>";

		$QUERY_STRING=="base";
	endif;

else:
	
	if($error!="")
	{
		$error = eregi_replace("[^ _A-Z.a-zА-Яа-я0-9-]","",$error);
		echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table><table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC><tr><td align=center class=p style=\"color:#FFFFFF\" bgcolor=#FF0000><b>$error</b></td></tr></table>";
	}
?>
</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table>
</td></tr><tr><td>
<table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC>
<form action=admin.php?login method=post>
<tr><td class=p bgcolor=#E8E8FF align=center><b>Вход в админ.центр:</b></td></tr>
<tr><td class=p bgcolor=#FFFFFF><table><tr><td class=p width=210 align=right>Логин:</td><td class=p width=390 align=left><input type=text name=alogin size=30></td></tr></table></td></tr>
<tr><td class=p bgcolor=#FFFFFF><table><tr><td class=p width=210 align=right>Пароль:</td><td class=p width=390 align=left><input type=password name=pass size=30></td></tr></table></td></tr>
<tr><td align=center bgcolor=#FFFFFF><input type=submit value="Войти" style="width:100px;cursor:hand;" onMouseOver="this.style.backgroundColor='#E8E8FF';" onMouseOut="this.style.backgroundColor='#FFFFFF';"></td></tr>
</form>
</table>
<?php
	if (!file_exists("passwords.php"))
		echo "</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table><table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC><tr><td align=center class=p bgcolor=#FFFFFF>Вы входите в админ.центр в первый раз!<br>Введите любой логин и пароль (они будут использоваться и в будущем).</td></tr></table>";
endif;
?>
</td></tr>
<tr><td>
</td></tr><tr><td><table border=0 cellpadding=0 cellspacing=0 width=600 height=4><tr><td height=4></td></tr></table>
<table width=600 border=0 cellspacing=1 cellpadding=3 bgcolor=#CCCCCC><tr>
  <td align=center class=p1 bgcolor=#E8E8FF><a href="http://www.sadraven.ru/" title="скачать скрипт гостевой книги" target="_blank">SR</a> + <a href="http://www.profy.org/gb/" target="_blank">Denied</a> Guestbook <?=$version?> &copy; 2008 <a href="http://gb.lugr.ru/" title="бесплатно скачать скрипты гостевых книг" target="_blank">fm</a></td>
</tr></table>
</td></tr>
</table>
</div>
</body>
</html>
