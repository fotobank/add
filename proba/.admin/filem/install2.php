<?php if(!is_file('install.php')) die('Уже установлено :)'); ?>
<html>

<head>
  <title>PhpFileAdmin - установка</title>


</head>

<body>

<?php
 if (isset($_POST['act']))
 {
     // It will be installed


     // Конфиг
     $err=0;
     echo('Создание файла конфигурации... ');

     $d=$_POST['indir'];
     $f=fopen('conf.php', 'w+');
     fwrite($f, "<?php define('INDIR', '".$d."'); ?>");
     fclose($f);

     if(is_file('conf.php'))  echo('OK');
     else {echo('Ошибка'); $err++;}



     // Создание директорий
     echo('<br>Создание директорий... ');
     mkdir('./users', 0777);
     mkdir('./tmp', 0777);
     if((is_dir('./tmp'))&&(is_dir('./users'))) echo('OK');
     else {echo('Ошибка'); $err++;}

     // ... И запрет доступа

     copy('deny_access', './users/.htaccess');
     copy('deny_access', './tmp/.htaccess');

     // Создание нового пользователя

     $f=fopen('./users/'.$_POST['login'],'w+');

     fwrite($f, md5($_POST['pass']));
     fwrite($f, "\n");

     fwrite($f, $_POST['hdir']);
     fwrite($f, "\n");

     fwrite($f, "Admin");
     fwrite($f, "\n");

     fclose($f);

     if(!is_file('./users/'.$_POST['login'])) {echo('<br>Ошибка при создании пользователя'); $err++;}

     // Блокирока / Удаление нсталлятора

     if($err==0)
     {
      unlink('install_data.d');
      unlink('install.php');
      echo('<br><b>Установка завершена успешно</b><br>');
      ?>Нажмите <a href="login.php">Сюда</a> для входа<?php
      die('</body> </html>');
     }





 }


?>



<form action="install2.php" method="post">
<input name="act" type="hidden" value="ok">
Данная страница поможет вам установить <b>PhpFileAdmin</b> на ваш сайт. <br>
Вас следует заполнить следующие поля:<br><br>
Папка, в которой находится PhpFileAdmin (к примеру <?=$_SERVER['HTTP_HOST']?>/filem<br>
(указывайте с лидирующим и завершающим слешем (к примеру: /filem/). Если PhpFileAdmin установлен в корень, то оставьте поле пустым
<br>

<input name="indir" type="text" value="">
<br>
<br>
Также вам понадобится аккаунт для входа в систему. Этот скрипт создаст его для вас.
<br>
Логин: <br>
<input name="login" type="text" value=""><br>
Пароль:<br>
<input name="pass" type="text" value=""> <br>
Домашний каталог:<br>
<input name="hdir" type="text" value="<?=$_SERVER['DOCUMENT_ROOT']?>">  <br>
<br>
Взлетаем? <input type="submit" value="Взлёт">
</form>
<br>
<br>
<div align=right>(C) <a href="http://voida.net">void</a>, 2005</div>


</body>

</html>