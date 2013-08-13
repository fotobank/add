<?
include 'sys/func.php';
header("Content-type: application/rss+xml");
echo '<?xml version="1.0" encoding="UTF-8" ?><rss version="2.0">
<channel>
    <title>RSS Лента новостей '.$_SERVER['HTTP_HOST'].'</title>
     <link>http://'.$_SERVER['HTTP_HOST'].'</link>
     <description>Новости сайта '.$_SERVER['HTTP_HOST'].'</description>
     <language>ru-RU</language>';
     echo "\n";



$n = mysql_query('SELECT * FROM `news` ORDER BY `id` DESC');
include 'sys/bb.php';

while($na = mysql_fetch_array($n)){

echo '<item>
	  <title>'.htmlspecialchars(stripslashes($na['name'])).'</title>
	  <link>'.htmlentities('http://'.str_replace('rss','news',$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']).'?nid='.$na['id'], ENT_QUOTES, 'UTF-8').'</link>
	  <description>'.mb_substr(unbb(htmlspecialchars(stripslashes($na[1]))),0,50,'utf-8').'...</description></item>';
	  echo "\n";

	  }


echo '</channel></rss>';


?>