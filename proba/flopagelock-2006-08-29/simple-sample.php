<?
/*
 - Product name: floPageLock
 - Author: Joshua Hatfield (flobi@flobi.com)
 - Release Version: 1.0.0
 - Release Date: 2005-10-22
 - License: Free for non-commercial use

SAMPLE FILE
 - This sample file demonstrates how easily this can be added to an existing page.
 - This SHOULD be before any other code.
*/
include("floPageLock.php");
$pagelock = new floPageLock("myusername", "mypassword", true);
?>
<html>
<head>
	<title>floPageLock Test (unlocked)</title>
	<style>
		.floPageLock_outertable {
			border: 1px solid #aaaaff;
			background-color: #ffffff;
		}
		p {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 10pt;
		}
		h1 {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 20pt;
		}
	</style>
</head>
<body bgcolor="f8f8ff">
<table width=100% height=100% class="floPageLock_outertable">
	<tr>
		<td align=center>
			<h1>floPageLock Test (unlocked)</h1>
			<p>The page you are looking at has been unlocked.  </p>
		</td>
	</tr>
</table>
</body>
</html>
