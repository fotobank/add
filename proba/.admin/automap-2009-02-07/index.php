<?php
/*------------------------------------------------------------------------------------------

This file is part of auto google site maps creation by lee johnstone
this file was orginaly made by a third party site please read below for there license.

YOU MAY NOT
(1) Remove or modify this copyright notice.
(2) Distribute this code as your own
(3) Use this code in commercial projects
    
YOU MAY
(1) Use this code or any modified version of it on your website.
(2) Use this code as part of another product.

u may not remove this notice
please read our copyright license here
http://www.freakcms.com/licensing.php
or contact us here
http://www.toy17s.com/index.php?page=Contact-us
--------------------------------------------------------------------------------------------

This is the main index search file, used to enter the url and options before a sitemap
is attempted to be created.

Example of usage

To create a new map u must have a basic html form in the below style.

############### BELOW FORM #####################

<form method="POST" action="index.php">
	<table class="form">
		<tbody>
		<tr>
			<th >Start from:</th>
			<td align="center" ><input type="text" size="40" name="url" value="http://" /> </td>
		</tr>
		<tr>
			<th >Maximum number of links:</th>
			<td align="center" >
			<input type="text" size="40" name="maxpages" value="99" /> </td>
		</tr>
		<tr>
			<th>Webpage extensions:</th>
			<td align="center">
			<input type="text" size="40" name="ext" value="asp aspx cgi htm html php pl" />
			</td>
		</tr>
		<tr>
			<td colspan=2>
			<input type="submit" value="Create your map" name="automap" /></td>
			<input type="hidden" size="40" name="ses" value="id sid PHPSESSID" />
		</tr>
	</tbody>
	</table>
</form>

############### END FORM #####################

on the forms target page u must have the below php5 class code.

############### START CLASS USAGE #####################

<?php
if(isset($_POST['automap'])){
include 'create.php';
$map = new AutoMaps();
$map->AutoMap();
}
?>
############### END CLASS USAGE #####################


to get the newly created sitemap after its been made call this code.

############### END GET CODE #####################

include 'create.php';
$map = new AutoMaps();
$map->GetMap();
                
############### END GET CODE #####################

thats all for now in this release.
if u feel u can make this beter let me kno at webmaster@freakcms.com
-------------------------------------------------------------------------------------------*/


if(isset($_POST['automap'])){
?>
<html>
<head>
<title>Automap : Automaticly Create Google Site Maps - Finish</title>
<style type="text/css">
table { border-collapse: collapse; }
td { padding: 0px 5px 1px 0px; }
div.link{padding: 0px;margin: 0px 0px 6px 0px;line-height: 0.9em;}
a{text-decoration: none;color: #007500;}
</style>
<meta name="keywords" content="google, maps, site, creator, maker, online, sitemap, gmaps, help, tools, making, tutorials, help for maps, sitemap help, google sitemap, yahoo sitemap">
<meta name="description" content="Create your own google sitemap within minutes, can handle large sites, small sites, full vaild google site maps aswell as yahoo two">
</head>
<body>
<h1>Automap : Automaticly Create Google Site Maps - Finish</h1>
<?php
include 'create.php';
$map = new AutoMaps();
$map->AutoMap();
?>
<h3>Your site map</h3>
<a target="_blank" href="get.php">Download your sitemap here</a>
<h3>What to do with your new map</h3>
<p>Now that you have made and downloaded your sitemap.<br>
upload it to the top level directory for the site you made it for<br>
Visit Google and join or login to your webmaster tools account<br>
submit a new sitemap in your admin area.</p>
<h3>Information</h3>
This site map is valid for Google and yahoo and possible other search engine spiders.<br>
having this sitemap will not promise search engine results but it will help either way.<br>
thank you for use my tools.<br><br>
Would u like to create a new sitemap? <br>
<a href="./">yes?</a> <br>
<a href="http://www.freakcms.com">no?</a>
<div align=center>
<!-- do not remove this copyright unless otherwise stated -->
<p>Automap : Automaticly Create Google site maps by <a href="http://www.freakcms.com/portfolio.php">Lee Johnstone</a> @ <a href="http://www.freakcms.com">Freak cms</a></p>
<!-- do not remove this copyright unless otherwise stated --></div>
</body>
</html>
<?php
}else{
?>
<html>
<head>
<title>Automap : Automaticly Create Google Site Maps - Start</title>
<style type="text/css">
table.form th{padding: 0px 5px 4px 2px;vertical-align: middle;text-align: left;font-family: Verdana, Sans-Serif;font-weight: 100;font-size: 0.7em;}
table.form td { padding: 2px; }
table.form th.error { color: #F00000; }
table.form input.submit { font-family: Verdana, Sans-Serif; }
</style>
<meta name="keywords" content="google, maps, site, creator, maker, online, sitemap, gmaps, help, tools, making, tutorials, help for maps, sitemap help, google sitemap, yahoo sitemap">
<meta name="description" content="Create your own google sitemap within minutes, can handle large sites, small sites, full vaild google site maps aswell as yahoo two">
</head>
<body>
<div align="center">
<h1>Automap : Automaticly Create Google Site Maps - Start</h1><br /><br /><br />
<p><font color="#FF0000">To auto create your sitemap just enter your homepage url and<br> select the amount of max pages to scan and page extensions and submit your form</font></p>
<form method="POST" action="index.php">
	<table class="form" style="border: 1px dotted #FF0000">
		<tbody>
		<tr>
			<th style="border:1px dotted #FF0000; text-align: center">Start from:</th>
			<td align="center" style="border: 1px dotted #FF0000"><input type="text" size="40" name="url" value="http://" /> </td>
		</tr>
		<tr>
			<th style="border:1px dotted #FF0000; text-align: center">Maximum number of links:</th>
			<td align="center" style="border: 1px dotted #FF0000">
			<input type="text" size="40" name="maxpages" value="99" /> </td>
		</tr>
		<tr>
			<th style="border:1px dotted #FF0000; text-align: center">Webpage extensions:</th>
			<td align="center" style="border: 1px dotted #FF0000">
			<input type="text" size="40" name="ext" value="asp aspx cgi htm html php pl" />
			</td>
		</tr>
		<tr>
			<td colspan=2 style="border:1px dotted #FF0000; text-align: center">
			<input type="submit" value="Create your map" name="automap" /></td>
			<input type="hidden" size="40" name="ses" value="id sid PHPSESSID" />
		</tr>
	</tbody>
	</table>
</form>
<!-- do not remove this copyright unless otherwise stated -->
<p>Automap : Automaticly Create Google site maps by <a href="http://www.freakcms.com/portfolio.php">Lee Johnstone</a> @ <a href="http://www.freakcms.com">Freak cms</a></p>
<!-- do not remove this copyright unless otherwise stated -->
</div>
</body>

</html>
<?php
}
?>