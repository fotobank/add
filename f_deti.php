<?php include (dirname(__FILE__).'/inc/head.php');
?>
<div id="main">
<br><h2><span style="color: #ffa500">Образцы работ с детских мероприятий </span></h2><br>
<a class="small button full blue" href="uslugi.php">&nbsp &nbsp &nbsp &nbsp Назад к категориям &nbsp &nbsp &nbsp &nbsp </a><br><br>

<div id="cont_fb">
<?  echo mysql_result(mysql_query('select txt from content where id = 6'), 0); ?>
</div>
</div>
<div class="end_content"></div>
</div>
<?php include (dirname(__FILE__).'/inc/footer.php');
?>