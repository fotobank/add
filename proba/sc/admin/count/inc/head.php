<?
    $beg = @file("../../data/begin.count");
    if($beg)
       {
          list($i,$h) = explode('<<>>',$beg[0]);
          $begin = $h." г.";
          list($ddd,$mmm,$yyy) = explode('.',$begin);
          $daylost =  ceil((time() - mktime(0, 0, 0, $mmm, $ddd, $yyy))/86400);
          
       }
     if(!$beg)
       {
          $begin ="<font color=red><b>не была</b></font>";
          $daylost = "<font color=red><b>0</b></font>";
       }

	?>
<html>
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="pragma" content="no-cache">
<link rel="StyleSheet" type="text/css" href="inc/style.css">
</head>
<body bgcolor=#ffffff>
<div align=right class=headtop>Система статистики от Plahov <br><a href=http://home.onego.ru/~nsg/ target=_blank class=linkforum>форум поддержки</a><br><font class=begin>Система работает <?= $daylost;?> дн. запущена <?= $begin; ?></font></div>
<br>
<? include("inc/menu.php"); ?>