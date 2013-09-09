<?php

/**
 * 
 *@author Cerion Morgauin
 * @version $Id$
 * @copyright Enrico Marongiu (cerion _@_ tiscali _._ it) - 2004
*  linkObfuscator manages a simple way of validating links: starting from a session, an user can browse exclusively those links that are performed by this page. to do this, a random seed is generated and a special code (named go) is attached to each link.
* each page that has to be obfuscated needs this class and a $linkObfuscator::check() to validate the user.
 **/

require_once('./link_Obfuscator.php');

session_start();


$link=new link_Obfuscator($_SESSION['referralSeed']);
 print "actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
?>
<html><body>
<?
if ($link->referralSeed) {
    if($link->check($_SERVER['REQUEST_URI'])){
		print "checked link: ${_SERVER['REQUEST_URI']}<br />\n";
	}else{
		print "link invalid: ${_SERVER['REQUEST_URI']} \n";

	}
}
$_SESSION['referralSeed']=$link->seed;
$newLink= preg_replace('/(&|\?)go=(\w)+/','',$_SERVER['REQUEST_URI']);
$newLinkObscured=$link->obfuscate($newLink);

?>
<a href="<?=$newLinkObscured?>">Obscured</a>
</body>