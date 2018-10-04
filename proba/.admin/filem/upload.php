<?php
error_reporting(0);
include 'conf.php';
include 'func.php';
session_start();
if(!isset($_SESSION['User_Path'])) die("Не найдены данные вашей сессии");
if(!isset($_GET['dir'])) die("Сюда нельзя обратиться напрямую");


if(isset($_POST['act']))
{

  $uploadfile = makepath($_GET['dir'], $_FILES['userfile']['name']);


  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
  {
      $p=makeperms($_POST['perms']);





      define("STAT", "<font color=green>Файл загружен. Вы можете загрузить ещё один или вернуться на главную страницу</font>");
      chmod($uploadfile,$p);
  }

  else
  {

       define("STAT", "<font color=red>Произошла ошибка. Возможно, вы не имеете прав загружать такой файл</font>");
  }

}
else { define("STAT", '');   };

?>


<html>

<head>
  <title>PhpFileAdmin </title>

    <link rel="stylesheet" href="<?=INDIR?>img/style.css" type="text/css">
</head>

<body>

<div class="Header">Загрузка файла</div>
<span class="main">
<?=STAT?> <br>

<form enctype="multipart/form-data" action="upload.php?dir=<?=$_GET['dir']?>" method="post">
<input name="act" type="hidden" value="ok">
Файл: <input name="userfile" type="file" /><br><br>
Права: <input name="perms" style="width:40" type="text" value="775"><br>
Загрузить: <input type="submit" value="Загрузить" />

</form>
<a href="index.php?dir=<?=$_GET['dir']?>">Вернуться обратно</a>

</span>
</body>

</html>