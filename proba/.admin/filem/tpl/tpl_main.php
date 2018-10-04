<html>

<head>
  <title>PhpFileAdmin</title>
  <link rel="stylesheet" href="<?=INDIR?>img/style.css" type="text/css">
</head>

<body>


<div class="main" align=right>
<?=ADM_REF?>
<a href="index.php?dir=<?=CDIR?>">Обновить</a>&nbsp;&nbsp;
<a href="logout.php">Выход</a>

</div>
<div class="Header">PhpFileAdmin</div>
<form name="MainForm" action="index.php?dir=<?=CDIR?>" method="post">
<script language="javascript">


function apply_form(v)
{

   document.MainForm.act.value=v;


   document.MainForm.submit();
   return;

}


function new_dir()
{

    var s=prompt("Введите имя новой директории","");
    if ((s == null)|| (s == '')) return;
    document.MainForm.str.value=s;
    apply_form(5);
    return;
}

function chperms(how)
{

    var s=prompt("Введите новые права для выбранных объектов (к примеру 775)","");
    if ((s == null)|| (s == '')) return;
    document.MainForm.str.value=s;
    apply_form(how);
    return;
}

function rename()
{

    var s=prompt("Введите новое имя\n(эта функция переименует только один отмеченный объект)","");
    if ((s == null)|| (s == '')) return;
    document.MainForm.str.value=s;
    apply_form(9);
    return;
}

function unzip()
{

apply_form(8);
return;

}

function zip()
{

    var s=prompt("Введите имя архива\n(файл будет создан)","");
    if ((s == null)|| (s == '')) return;
    document.MainForm.str.value=s;
    apply_form(10);
    return;
}
</script>


<table width=100%>

<tr valign=top>



<td class="main" width=60%>
<!-- Директория  -->
<?=DIR_HISTORY?><br><br>
<!-- ///  -->
<table width=100% class="main">
<tr> <td><b>Имя</b></td> <td><b>Размер</b></td> <td><b>Права</b></td> </tr>
<!-- Список файлов  -->
<?=FILES_LIST?>
<!-- ///  -->
</table>
</td>
<td width=40%>
<table width=100%  class="main">   <tr valign=top> <td>
<input name="curdir" type="hidden" value="<?=CDIR?>">

<!-- Возможности   -->
<a title="Копировать" href="javascript:apply_form(1)"><img src="<?=INDIR?>img/copy.gif" alt="Копировать">Копировать</a>&nbsp;<br>
<a title="Вырезать / Переместить" href="javascript:apply_form(2)"><img src="<?=INDIR?>img/move.gif" alt="Вырезать / Переместить">Вырезать</a>&nbsp;<br>
<a title="Вставить" href="javascript:apply_form(3)"><img src="<?=INDIR?>img/paste.gif" alt="Вставить">Вставить</a>&nbsp;<br>
<a title="Удалить" href="javascript:apply_form(4)"><img src="<?=INDIR?>img/del.gif" alt="Удалить">Удалить</a>&nbsp;
</td>

<td>
<a title="Новая папка" href="javascript:new_dir()"><img src="<?=INDIR?>img/new_fold.gif" alt="Новая папка">Новая папка</a>&nbsp;<br>
<a title="Загрузить файл" href="upload.php?dir=<?=CDIR?>"><img src="<?=INDIR?>img/upload.gif" alt="Загрузить файл">Загрузить файл</a>&nbsp;<br>
<a title="права" href="javascript:chperms(6)"><img src="<?=INDIR?>img/chmod.gif" alt="права">Права</a>&nbsp;<br>
<a title="права" href="javascript:chperms(7)"><img src="<?=INDIR?>img/chmod.gif" alt="права">Права (рекурсивно)</a>&nbsp;<br>
</td>

<td>
<a title="Переименовать" href="javascript:rename()"><img src="<?=INDIR?>img/rename.gif" alt="Переименовать">Переименовать</a>&nbsp;<br>
<a title="Распаковать файл (ы)" href="javascript:unzip()"><img src="<?=INDIR?>img/unzip.gif" alt="Распаковать файл (ы)">Распаковать файл (ы)</a>&nbsp;<br>
<a title="Упаковать файл (ы)" href="javascript:zip()"><img src="<?=INDIR?>img/zip.gif" alt="Упаковать файл (ы)">Архивировать (zip)</a>&nbsp;<br>
<a title="Скачать (HTTP)" href="http_download.php?dir=<?=CDIR?>"><img src="<?=INDIR?>img/http_dl.gif" alt="Скачать (HTTP)">Скачать (HTTP)</a>&nbsp;<br>
</td>
</table>
<input name="str" type="hidden" value="">
<input name="act" type="hidden" value="">


<br>
<hr width=100%>
<!-- ///   -->

<!-- Буферизованные файлы   -->
<?=BUFF?>

<!-- /// -->
</td>
</tr>

</table>
</form>
<?php



?>

</body>

</html>