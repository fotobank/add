<?php include (dirname(__FILE__).'/inc/head.php');
?>
<div id="main">
	<div class="cont-list" style="margin: 0 10px 20px 40%;"><div class="drop-shadow lifted">
			<h2><span style="color: #00146e;">Съемки в школах</span></h2>
		</div></div>
<a class="small button full blue" href="uslugi.php">&nbsp &nbsp &nbsp &nbsp Назад к категориям &nbsp &nbsp &nbsp &nbsp </a><br><br>
<br><br><br><br><br>

<div id="cont_fb">

<? echo $db->query('select txt from content where id = ?i',array(13),'el'); ?>

</div>
</div>
<div class="end_content"></div>
</div>
<?php include (dirname(__FILE__).'/inc/footer.php');
?>