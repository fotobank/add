<?php
			define ( 'ROOT_PATH' , realpath ( __DIR__ ) . '/' , TRUE );
			include (ROOT_PATH.'inc/head.php');
?>
<div id="main">
	<div class="cont-list" style="margin: 0 10px 20px 31%;"><div class="drop-shadow lifted">
			<h2><span style="color: #00146e;">Образцы работ с детских мероприятий </span></h2>
		</div></div>

<a class="small button full blue" href="uslugi.php"><span>Назад к категориям</span></a>

<div id="cont_fb">
	<? echo go\DB\query('select txt from content where id = ?i',array(6),'el'); ?>
</div>
</div>
<div class="end_content"></div>
</div>
<?php include (ROOT_PATH.'inc/footer.php');
?>
