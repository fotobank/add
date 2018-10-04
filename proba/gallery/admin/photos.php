<?
//require_once("start.php"); подключаем БД
session_start();
if (!isset($_SESSION['admin'])){ header("Location: index.php"); exit; }
if (isset($_GET['ok'])) echo "<strong>Фото добавлено!</strong><br /><br />";
if (isset($_GET['del'])) mysql_query("delete from photos where id ='{$_GET['del']}'");
?>
<center>
<table width="700" border="1">
  <tr align="center">
    <td><a href='photos.php'>Фотографии</a></td>
  </tr>
</table></center><br />

<center>
Загрузить фото
<form action="photo_add.php" method="post" enctype="multipart/form-data">
<br />
Комментарий к фото<br />
<input name="comment" size="100" /><br />
<br />
Фото - только JPG!<br />
<input type="file" name="photo" />
<br /><br />
<input type="submit" value="Добавить FOTO" />
</form>
</center>
<hr />
<br />
<?
if (isset($_POST['makeorder'])){
	foreach ($_POST['cats'] as $v){
		$set=$_POST['cat'.$v];
		mysql_query("update photos set `ord` = '{$set}' where id='{$v}'");
	}
}
?>
<form action="photos.php" method="post">
<input type="hidden" value="yep" name="makeorder" />
<? //$cats=mysql_query("select * from s_cats where id>2");
//while ($ca=mysql_fetch_array($cats)){
	//echo $ca['name']."<br />";
	$i=1;
	echo "<table><tr>";
	$gp=mysql_query("select * from photos order by ord");
	while($pho = mysql_fetch_array($gp)){
		echo "<td><img src='../upload/{$pho['small']}'><br /><a href='photos.php?del={$pho['id']}' onclick=\"return confirm ('Действительно удалить?')\">Удалить</a><br />Порядок <input type='text' size='3' name='cat{$pho['id']}' value='{$pho['ord']}' /><input type='hidden' name='cats[]' value='{$pho['id']}' /></td>";
		if ($i%6==0) echo "</tr><tr>";
		$i++;
	}
	echo "</tr></table><br /><hr>";	
//}
	
?><br />
<input type="submit" value="Поменять порядок" /></form><br />
