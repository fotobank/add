<?
#####################################################################
#  DiskSpace 0,23
#  Released under the terms of the GNU General Public License.
#  Please refer to the README file for more information.
#####################################################################

#####################################################################
# PLEASE EDIT THE FOLLOWING VARIABLES:
#####################################################################

# Please choose a language file:
$languageFile = "./language_files/english.php";

# Your home directory on the server. Check the README file if you
# don't know how to find your home directory.
$user_home = "/home/yourusername";

# The available hard disk space for your user on the server --
# measured in megabytes.
$available_space = "15";

# Choose a password. You will have to enter this password when you
# view DiskSpace in a browser.
$password = "password";

#####################################################################
# THAT'S IT! NO MORE EDITING NECESSARY.
#####################################################################



require($languageFile);

exec("du -s $user_home", $du);	# This will output something like "3383    /home/user"
$brugtplads = split(" ", $du[0]);

$brugtplads = $brugtplads[0] / 1024;
$pladstilbage = $available_space - $brugtplads;

$p = $available_space / 100;
$p_brugtplads = round($brugtplads / $p);
$p_pladstilbage = round($pladstilbage / $p);

$bredde_brugt = $p_brugtplads * 3;	# This is used as the "width" attribute in the "<img>" tag.
$bredde_tilbage = $p_pladstilbage * 3;	# This is used as the "width" attribute in the "<img>" tag.

function afrunding($tal) {
	if (ereg("\.", $tal)) {					# Example: $tal = 12.2547821
		$tal = split("\.", $tal);			# $tal[0] = 12 and $tal[1] = 2547821
		$tal[1] = substr($tal[1], 0, 2);		# $tal[1] = 25
		$ciffer1 = substr($tal[1], 0, 1);		# $ciffer1 = 2
		$ciffer2 = substr($tal[1], 1, 2);		# $ciffer2 = 5
		if ($ciffer2 >= 5) $ciffer1 = $ciffer1 + 1;	# $ciffer1 now becomes 3
		$tal = "$tal[0].$ciffer1";			# $tal is now 12.3
	}
	return $tal;
}



echo "<html><head><title>DiskSpace</title>\n";
echo "<style type=text/css><!--\n";
echo "body {background:white; font-family:lucida,helvetica}\n";
echo "--></style>\n";
echo "</head>\n";

if (!$adgangskode) {
	echo "<body onLoad=document.forms[0].adgangskode.focus()>\n";
	echo "<form action=$PHP_SELF method=post>\n";
	echo "$l1<br>\n";
	echo "<input type=text name=adgangskode size=20>\n";
	echo "<input type=submit value=\"$l9\">\n";
	echo "</form>\n";
	echo "</body></html>";
}

if ($adgangskode && $adgangskode != $password) {
	echo "<body>\n";
	echo "<h2>$l2</h2>\n";
	echo "</body></html>";
}

if ($adgangskode == $password) {
	echo "<body>\n";
	echo "<h2>$l3</h2>\n";
	echo "<img src=image.gif height=20 width=$bredde_brugt alt=\"$l4: $p_brugtplads$l7\">";
	echo "<img src=image_gray.gif height=20 width=$bredde_tilbage alt=\"$l5: $p_pladstilbage$l7\"><p>\n";

	echo "<img src=image.gif height=20 width=10 alt=\"$l6\"><img src=image_gray.gif height=20 width=10 alt=\"$l6\">\n";
	echo "$l6: $available_space $l8 (100$l7)<p>\n";
	echo "<img src=image.gif height=20 width=20 alt=\"$l4\">\n";
	echo "$l4: ".afrunding($brugtplads)." $l8 ($p_brugtplads$l7)<p>\n";
	echo "<img src=image_gray.gif height=20 width=20 alt=\"$l5\">\n";
	echo "$l5: ".afrunding($pladstilbage)." $l8 ($p_pladstilbage$l7)\n";

	echo "</body></html>";
}
?>
