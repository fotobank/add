<?php
error_reporting(0);
include 'conf.php';
include 'func.php';
session_start();
if(isset($_POST['act']))
{

   $usr_str=f_get('./users/'.$_POST['login']);

   $usr_str=str_replace("\r\n", "\n", $usr_str);
   $arr=explode("\n", $usr_str);

   if(md5($_POST['pass'])!=$arr[0]) define("STAT", "<font color=red>����� �/��� ������ �� �����</font>");
   else
   {
        $_SESSION['Ok']=1;
        $_SESSION['User_Path']=$arr[1];
        if($arr[2]=="Admin") $_SESSION['Adm']=1;
        redir('index.php');
   }


}
else define("STAT", "");
?>


<html>

<head>
  <title>����</title>

    <link rel="stylesheet" href="<?=INDIR?>img/style.css" type="text/css">
</head>

<body>

<div class="Header">PhpFileAdmin</div>
<span class="main">

<b>PhpFileAdmin</b> ������������ ���!<br>
<?=STAT?> <br>
<form action="login.php" method="post">
<input name="act" type="hidden" value="ok">
���:&nbsp;&nbsp;&nbsp;&nbsp; <input name="login" type="text" value=""><br><br>

������: <input name="pass" type="password" value=""><br><br>
����: <input type="submit" value="����" />

</form>
<br>
<br>
<div align=right>(C) <a href="http://voida.net">void</a>, 2005</div>

</span>
</body>

</html>