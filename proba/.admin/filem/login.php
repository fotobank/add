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

   if(md5($_POST['pass'])!=$arr[0]) define("STAT", "<font color=red>Ћогин и/или пароль не верны</font>");
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
  <title>¬ход</title>

    <link rel="stylesheet" href="<?=INDIR?>img/style.css" type="text/css">
</head>

<body>

<div class="Header">PhpFileAdmin</div>
<span class="main">

<b>PhpFileAdmin</b> приветствует вас!<br>
<?=STAT?> <br>
<form action="login.php" method="post">
<input name="act" type="hidden" value="ok">
»м€:&nbsp;&nbsp;&nbsp;&nbsp; <input name="login" type="text" value=""><br><br>

ѕароль: <input name="pass" type="password" value=""><br><br>
¬ход: <input type="submit" value="¬ход" />

</form>
<br>
<br>
<div align=right>(C) <a href="http://voida.net">void</a>, 2005</div>

</span>
</body>

</html>