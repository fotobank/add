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

$directory = 'foto/svadbi/11.08.12';

$allowed_types=array('jpg','jpeg','gif','png');
$file_parts=array();
$ext='';
$title='';
$i=0;

$dir_handle = @opendir($directory) or die("There is an error with your image directory!");

while ($file = readdir($dir_handle)) 
{
	if($file=='.' || $file == '..') continue;
	
	$file_parts = explode('.',$file);
	$ext = strtolower(array_pop($file_parts));

	$title = implode('.',$file_parts);
	$title = htmlspecialchars($title);
	
	$nomargin='';
	
	if(in_array($ext,$allowed_types))
	{
		if(($i+1)%4==0) $nomargin='nomargin';
		
		echo '
		<a class style="padding:5px 16px 5px 16px; display:block; float:left; " rel="lightbox[roadtrip2]" href="'.$directory.'/'.$file.'">
 <img class="album_usl_img" src="'.$directory.'/'.$file.'" width="avto" height="175" border="5" align="bottom" alt=""> 
 </a>';
		
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
</div>

<?
include ('../inc/footer.php');
?>