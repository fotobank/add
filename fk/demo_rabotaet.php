<? 

include ('../inc/head1.php');

?>

<div id="main">
<div id="cont_fb">


<!--Альбом начало-->

<table>
<tr>
<td>

<?php

$directory = 'gallery';

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
	
		/* echo '
		/* <div class="pic '.$nomargin.'" style="background:url('.$directory.'/'.$file.') no-repeat 50% 50%;"> */
		/* <a href="'.$directory.'/'.$file.'" title="'.$title.'" target="_blank">'.$title.'</a> */
		/* </div>'; */
		
		echo '
		<a class="alb_usl" rel="lightbox[roadtrip2]" href="'.$directory.'/'.$file.'">
 <img class="album_usl_img" border="0" src="'.$directory.'/'.$file.'" width="165" height="220"> 
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