
Thank you for downloading google sitemap create tool

----------------------------------------------------------------------------------------------------------------------------
ABOUT
----------------------------------------------------------------------------------------------------------------------------

Package Name: automap
Author: lee johnstone
Site: www.freakcms.com
Contact: info@freakcms.com
Release Date: 30-12-2008
Description: This tool will provide u a way of creating google sitemaps by just simply scanning your sites domain from the index file.

----------------------------------------------------------------------------------------------------------------------------
COPYRIGHT
----------------------------------------------------------------------------------------------------------------------------

YOU MAY NOT
1. Use this for commercial usage
2. Claim the code as your own
3. Remove any copyrights from its original authors

YOU MAY
1. Upgrade, Update, Adjust, Modify this script, providing you keep all original comments.
2. Redistribute this code under the same license and none other.
3. Modify and use this script on your own site as you wish, providing you keep the copyright markings from original authors.

----------------------------------------------------------------------------------------------------------------------------
INFORMATION
----------------------------------------------------------------------------------------------------------------------------

For further information please visit our license page
http://www.freakcms.com/licensing.php

If u like this script please consider buying me a beer
http://www.freakcms.com/buyabeer.php

For more of our projects please visit
http://www.freakcms.com/projects.php

----------------------------------------------------------------------------------------------------------------------------
INSTALLATION
----------------------------------------------------------------------------------------------------------------------------

What your need!

---------------

php5+
webserver

---------------

What to do!

--------------

1. unzip the package to your sites root directory keeping all files in the 'automap' folder.

2. make sure the automap directory is write and readable if not change permissions

3. point your browser to http://yoursite/automap/index.php

4. Now enter the domain u wish to scan

5. enter the amount of links u wish to max out at.

6. enter the file types u wish to look for 

7. now scan and a 2nd window will open 

8. once the scan is finished you will be shown scan details and a option to download the map.

9. download the map and upload it to your sites root directory.

10. now go to google webmaster tools and submit your sitemap.


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

----------------------------------------------------------------------------------------------------------------------------
WARRANTY
----------------------------------------------------------------------------------------------------------------------------

We can not be held responsible for any wrong doings with this package.
We can not promise this file is virus or Trojan free unless downloaded from our servers.
We will not hold responsibility for any harm done to hardware or software by this package.
We can and will not promise high rankings in google.