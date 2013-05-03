<?php include (dirname(__FILE__).'/inc/head.php');
?>
<div id="main">
<br><h2><span style="color: #ffa500">Школьники и выпускники </span></h2><br>
<a class="small button full blue" href="uslugi.php">&nbsp &nbsp &nbsp &nbsp Назад к категориям &nbsp &nbsp &nbsp &nbsp </a><br><br>

<div id="cont_fb">
	<? echo $db->query('select txt from content where id = ?i',array(9),'el'); ?>
</div>
</div>
<div class="end_content"></div>
</div>
<?php include (dirname(__FILE__).'/inc/footer.php');
?>