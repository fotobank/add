<?
if ( !defined('SR_DENIED') )
{
	die("������������ ����� �������");
	exit;
}
/*if (session_id() == "")
  {*/
	 //session_start();
	 require_once(__DIR__.'/../inc/secureSession.php');
	 startSession();
 // }
$cryptinstall = '/../inc/captcha/cryptographp.fct.php';
include  (__DIR__.'/../inc/captcha/cryptographp.fct.php');

//error_reporting(0);
$mail_mess = $mess;
$mail_name = $name;
$name = cutty($name);
$mail = cutty($mail);
$url = cutty($url);
if ((!stristr($url, "http://"))&&(!stristr($url, "ftp://"))&&($url<>"")) $url = "http://".$url;
$city = cutty($city);
$mess = cutty($mess);
$ip = cutty($ip);
$ip = preg_replace("'[^_0-9. ]'","",$ip);
setcookie("cookmess", str_replace ("<br>", "\n", $mess), time()+3600);
$date = time();
$mail_date = mydate($date);

 $f_antispam = (int)$_POST["f_antispam"];
 $antispam = $_SESSION["antispam"];


if ($_POST['f_antispam'] == chk_crypt($_POST['f_antispam']))

// if (($f_antispam==$antispam)&&($antispam<>"")||($spamcontrol<>"yes"))
{
	$f = fopen ($data,"a");
	flock ($f,2);
	fputs ($f,"$name|$mess|$mail|$url|$city|$date||$ip\r\n");
	flock ($f,3);
	fclose ($f);
	$very_bad = 0;
	$ref_url="index.php";
}
elseif ($_POST['comment'] != '')
{
	$very_bad = 2;
	$ref_url="index.php?messref=1";
} else
  {
	 $very_bad = 1;
	 $ref_url="index.php?messref=1";
  }

$mess = "";
if (isset($mail_mess) && isset($mail_name) && $send_mail == "yes" && ($very_bad == 0 || $mail_spam=="yes")):
	$subject="��������� �� $mail_name";
	$body="	
	~~
	$mail_name ($city)
	Email: $mail
	URL: $url
	~~
	$mail_mess
	~~
	$mail_date
	~~
	IP-�����: $ip
	���������� ����� ��������-�������: $f_antispam ~~ $antispam
	";
	if ($mail<>"") $headers = "From: ".$mail."\n";
	else $headers = "From: foto@aleks.od.ua\n";
	$headers .= "X-Sender: < ".$gname." >\n";
	$headers .= "Content-Type: text/plain; charset=windows-1251";
	mail($mailto, $subject, $body, $headers);
endif;

?>
<html>
<head>
<title><?=$gname?></title>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="content-type" content="text/html; charset=windows-1251">
<META http-equiv="refresh" content="2; url=<?=$ref_url?>">
<? require ("design/css.inc.php"); ?>
<?
header('Content-type: text/html; charset=windows-1251');
?>
</head>
<body bgcolor=<?=$BACKGROUND?> topmargin=15 leftmargin=0 marginwidth=0 marginheight=0>
<table width=<?=$TABWIDTH?> border=0 align="center" cellpadding=2 cellspacing=1 bgcolor=<?=$BORDER;?>>
  <tr bgcolor="<?=$LIGHT;?>" class=p>
    <td>
<?
if ($very_bad==0) echo "<p class=p><strong>��������� ���������.</strong></p>";
elseif ($very_bad==1)
{
	echo "<p class=p><strong>��������� �� ���������. ������������ ����������� ����  $f_antispam $antispam </strong></p><br/>";
} elseif ($very_bad==2)
  {
	 echo "<p class=p><strong>��������� �� ���������. �� ���?</strong></p><br/>";
  }

?>	
	<p class=p">������ �� ������ ����������  � �������� �����. ������� <a href="<?=$ref_url?>"><strong>�����</strong>
	  </a>, ���� �� ������ ����� ��� �� �������� �������������� ���������������.</p></td>
  </tr>
</table>
</body>
</html>