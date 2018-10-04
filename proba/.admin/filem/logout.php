<?php
error_reporting(0);
include 'conf.php';
include 'func.php';
session_start();
session_destroy();
?>


<html>

<head>
  <title>Выход</title>

    <link rel="stylesheet" href="<?=INDIR?>img/style.css" type="text/css">
</head>

<body>

<div class="Header">Благодарим вас за использование PhpFileAdmin</div>
<span class="main">
<a href="login.php">(войти опять)</a>

<br>
<br>
<div align=right>(C) <a href="http://voida.net">void</a>, 2005</div>

</span>
</body>

</html>