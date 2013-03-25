<?php include ('inc/head.php');
 
?>
<link href="/css/calkul.css" rel="stylesheet" type="text/css" />
<script src="/js/calkul.js"></script>

<div id="main">
<div id="cont_fb">
<? echo mysql_result(mysql_query('select txt from content where id = 3'), 0); ?>
</div>

</div>
<div class="end_content"></div>
</div>
<?php include ('inc/footer.php');
?>