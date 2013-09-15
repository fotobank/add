<?php
			define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
			include (BASEPATH.'inc/head.php');
?>
<div id="main">
	<div class="cont-list" style="margin: 0 10px 20px 40%;"><div class="drop-shadow lifted">
			<h2><span style="color: #00146e;">Садебные клипы</span></h2>
		</div></div>
  <a class="small button full blue" href="uslugi.php"><span>Назад к категориям</span></a>
<div id="cont_fb">
	<? echo $db->query('select txt from content where id = ?i',array(11),'el'); ?>
</div>
</div>
<div class="end_content"></div>
</div>
<?php include (BASEPATH.'inc/footer.php');
?>