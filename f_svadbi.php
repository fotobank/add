<?php include ('inc/head.php');
?>

<div id="main">
<div id="cont_fb">
<h2><span style="color: #ffa500">Свадьбы </span></h2><br>
<a class="small button full blue" href="uslugi.php">&nbsp &nbsp &nbsp &nbsp Назад к категориям &nbsp &nbsp &nbsp &nbsp </a><br><br>
<br><br>
<?  echo mysql_result(mysql_query('select txt from content where id = 5'), 0); ?>
</div>
</div>
<div class="end_content"></div>
</div>

<?php include ('inc/footer.php');
?>