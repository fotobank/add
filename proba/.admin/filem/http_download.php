<?php
error_reporting(0);
include 'conf.php';
include 'func.php';
session_start();
if(!isset($_SESSION['User_Path'])) die("�� ������� ������ ����� ������");
if(!isset($_GET['dir'])) die("���� ������ ����������
                                                  ��������");

if(isset($_POST['act']))
{

$lp=makepath($_GET['dir'], $_POST['local']);

if ((is_numeric($_POST['size']))||($_POST['size']==0)) { $recv=$_POST['size']; $onerecv=1;}
else {$recv=1024; $onerecv=0;};

$p=makeperms($_POST['perms']);

$local=fopen($lp, "w+");

$remote=fopen($_POST['URL'], "r");




        while(1)
        {

            $dat=fread($remote, $recv);
            fwrite($local, $dat);
            if($onerecv) break;

        };
        fclose($local);


    chmod($lp,$p);
     define("STAT", "<font color=green>���� ��������. �� ������ ��������� ��� ���� ��� ��������� �� ������� ��������</font>");
}
else {define("STAT", ''); };
?>


<html>

<head>
  <title>PhpFileAdmin </title>

    <link rel="stylesheet" href="<?=INDIR?>img/style.css" type="text/css">
</head>

<body>

<div class="Header">�������� ����� � ��������� �������</div>
<span class="main">
<?=STAT?> <br>

<form action="http_download.php?dir=<?=$_GET['dir']?>" method="post">
<input name="act" type="hidden" value="ok">
URL ��������� ����� (������� � http://):<br><input style="width:220" name="URL" type="text" value=""><br>
��� ���������� ����� (����� �����, ���� ����������):<br><input name="local" style="width:220" type="text" value=""><br>
����� ���� ��� ���������� (������ �����, ������ ����������� �����������) (�������� ������ ��� ���������������):<br>
<input name="size" style="width:80" type="text" value=""><br>
�����: <input name="perms" style="width:40" type="text" value="775"><br>
���������: <input type="submit" value="���������" />

</form>
<a href="index.php?dir=<?=$_GET['dir']?>">��������� �������</a>

</span>
</body>

</html>