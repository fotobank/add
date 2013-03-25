<? 
chdir("..");
include ('inc/head.php');
chdir("folder_for_prototype");
?>

<?php

// Hiding notices:
error_reporting(E_ALL^E_NOTICE);

?>


<div id="main">
<a class="small button full green" href="../f_svadbi.php">Назад к свадебным альбомам</a>
<div id="cont_fb" style="margin-top:20px">



<!--Альбом начало-->

<table>
<tr>
<td>

<?php

$directory = 'foto/svadbi/04';  //название папки с изображениями

$allowed_types=array('jpg','jpeg','gif','png');  //разрешеные типы изображений
$file_parts=array();
$ext='';
$title='';
$i=0;
//пробуем открыть папку
$dir_handle = @opendir($directory) or die("Внимание!Существует ошибка в Вашем каталоге с изображеньями или Вы не задали каталог!");

while ($file = readdir($dir_handle))   //поиск по файлам
{
	if($file=='.' || $file == '..') continue;    //пропустить ссылки на другие папки
	
	$file_parts = explode('.',$file);              //разделить имя файла и поместить его в массив
	$ext = strtolower(array_pop($file_parts));      //последний элеменет - это расширение

	$title = implode('.',$file_parts);
	$title = htmlspecialchars($title);
	
	$nomargin='';
	
	if(in_array($ext,$allowed_types))
	{
		if(($i+1)%4==0) $nomargin='nomargin';
		
		echo '
            <a class style="padding:5px 16px 5px 16px; display:block; float:left; " rel="lightbox[roadtrip2]" href="'.$directory.'/'.$file.'" title="'.$title.'" target="_blank">
            <img class="album_usl_img" src="'.$directory.'/'.$file.'" height="175" border="5" align="bottom" alt="" ></a>';
		$i++;
	}
}

closedir($dir_handle);

?>

</td>
</tr>
</table>

<!--Альбом конец-->
</div>
</div>
<div class="end_content"></div>
</div>

<?
include ('../inc/footer.php');
?>