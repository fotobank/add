<?php include (dirname(__FILE__).'/inc/head.php');
?>

<div id="main">
<div id="cont_fb">
<h2><span style="color: #ffa500">Свадьбы </span></h2><br>
<a class="small button full blue" href="uslugi.php">&nbsp &nbsp &nbsp &nbsp Назад к категориям &nbsp &nbsp &nbsp &nbsp </a><br><br>
<br><br>
	<? echo $db->query('select txt from content where id = ?i',array(5),'el'); ?>
</div>
</div>
<div class="end_content"></div>
</div>

<?php include (dirname(__FILE__).'/inc/footer.php');
?>