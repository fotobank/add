<?php if(!is_file('install.php')) die('��� ����������� :)'); ?>
<html>

<head>
  <title>PhpFileAdmin - ���������</title>


</head>

<body>

<?php
 if (isset($_POST['act']))
 {
     // It will be installed


     // ������
     $err=0;
     echo('�������� ����� ������������... ');

     $d=$_POST['indir'];
     $f=fopen('conf.php', 'w+');
     fwrite($f, "<?php define('INDIR', '".$d."'); ?>");
     fclose($f);

     if(is_file('conf.php'))  echo('OK');
     else {echo('������'); $err++;}



     // �������� ����������
     echo('<br>�������� ����������... ');
     mkdir('./users', 0777);
     mkdir('./tmp', 0777);
     if((is_dir('./tmp'))&&(is_dir('./users'))) echo('OK');
     else {echo('������'); $err++;}

     // ... � ������ �������

     copy('deny_access', './users/.htaccess');
     copy('deny_access', './tmp/.htaccess');

     // �������� ������ ������������

     $f=fopen('./users/'.$_POST['login'],'w+');

     fwrite($f, md5($_POST['pass']));
     fwrite($f, "\n");

     fwrite($f, $_POST['hdir']);
     fwrite($f, "\n");

     fwrite($f, "Admin");
     fwrite($f, "\n");

     fclose($f);

     if(!is_file('./users/'.$_POST['login'])) {echo('<br>������ ��� �������� ������������'); $err++;}

     // ��������� / �������� �����������

     if($err==0)
     {
      unlink('install_data.d');
      unlink('install.php');
      echo('<br><b>��������� ��������� �������</b><br>');
      ?>������� <a href="login.php">����</a> ��� �����<?php
      die('</body> </html>');
     }





 }


?>



<form action="install2.php" method="post">
<input name="act" type="hidden" value="ok">
������ �������� ������� ��� ���������� <b>PhpFileAdmin</b> �� ��� ����. <br>
��� ������� ��������� ��������� ����:<br><br>
�����, � ������� ��������� PhpFileAdmin (� ������� <?=$_SERVER['HTTP_HOST']?>/filem<br>
(���������� � ���������� � ����������� ������ (� �������: /filem/). ���� PhpFileAdmin ���������� � ������, �� �������� ���� ������
<br>

<input name="indir" type="text" value="">
<br>
<br>
����� ��� ����������� ������� ��� ����� � �������. ���� ������ ������� ��� ��� ���.
<br>
�����: <br>
<input name="login" type="text" value=""><br>
������:<br>
<input name="pass" type="text" value=""> <br>
�������� �������:<br>
<input name="hdir" type="text" value="<?=$_SERVER['DOCUMENT_ROOT']?>">  <br>
<br>
��������? <input type="submit" value="����">
</form>
<br>
<br>
<div align=right>(C) <a href="http://voida.net">void</a>, 2005</div>


</body>

</html>