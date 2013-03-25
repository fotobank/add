<? 
chdir("..");
include ('inc/head.php');
chdir("folder_for_prototype");
?>

<div id="main">
<a class="small button full green" href="../f_svadbi.php">Назад к свадебным альбомам</a>
<br><br><br>
<!--Альбом начало-->

<table>
<tr>
<td>


<!--Превью + Сама фотка-->
<a class="alb_usl" rel="lightbox[roadtrip1]" href="images3/1.jpg">
 <img class="album_usl_img" border="0" src="images3/1.jpg" width="165" height="220"> 
 </a>
 <!--Превью + Сама фотка конец-->
 
 
<a class="alb_usl" rel="lightbox[roadtrip1]" href="images3/2.jpg">
 <img class="album_usl_img" border="0" src="images3/2.jpg" width="225" height="300"> 
 </a>


</td>
</tr>
</table>
<!--Альбом конец-->
</div>
<br><br><br>

<?php include ('../inc/footer.php');
?>