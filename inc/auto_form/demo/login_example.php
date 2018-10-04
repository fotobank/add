<?php
/*************************************************************
 * This script is developed by Arturs Sosins aka ar2rsawseen, http://webcodingeasy.com
 * Fee free to distribute and modify code, but keep reference to its creator
 *
 * Auto form class can generate simple update, insert, select and delete 
 * HTML forms, form validation and form processing programmatically
 * based on information from mysql table
 *
 * For more information, examples and online documentation visit: 
 * http://webcodingeasy.com/PHP-classes/Generate-forms-programmatically
**************************************************************/
ob_start();
session_start();

include("./connection.php");
include("./auto_form.php");

//emulating catcha code
$captcha = "45GHK";
//custom validation - captcha
function valid_captcha($arr)
{
	global $captcha;
	if(strtoupper($arr["captcha"]) == $captcha)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//on success callback, validate login
//select form returns mysql result resource
function login($result)
{
	if(mysql_num_rows($result) > 0)
	{
		$_SESSION["user"] = true;
		echo "<p>You are now logged in</p>";
		return true;
	}
	else
	{
		echo "<p>Incorrect username or password</p>";
		return false;
	}
}
//modifying values - hashing password
function hash_pass($arr)
{
	$arr["password"] = md5($arr["password"]);
	return $arr;
}
//checking if user logged in
if(!isset($_SESSION["user"]))
{
	echo "<p>Not logged in</p>";
}
else
{
	echo "<p>Logged in</p>";
}
//class instance
$form = new auto_form($serverlink);

//debug queries
$form->debug();

//setting callback functions
$form->add_custom_validation("valid_captcha", "Incorrect captcha entered");
$form->set_onsuccess("login");
$form->set_modification("hash_pass");

//excluding table columns
$ex = array("ID", "firstname", "lastname", "email", "password", "gender");
//providing form language
$lang = array("username" => "Username", "password" => "Password", "captcha" => "Enter captcha", "code" => "Captcha code");
$form->set_language($lang);

/*************************
 * Generating form
 *************************/

echo "<fieldset>";
echo "<legend>Login</legend>";

//adding custom password field
$html = "<input type='password' name='password'";
if(isset($_POST["password"]))
{
	$html .= " value='".$_POST["password"]."'";
}
$html .= "/>";

$form->add_custom_html($html, "password", true);

//adding class predefined validation fo password
$form->add_class_validation("password", "char", true);

//displaying captcha code
$form->add_custom_html($captcha, "code", false);

$html = "<input type='text' name='captcha' style='text-transform: uppercase;' maxlength='5'";
if(isset($_POST["captcha"]))
{
	$html .= " value='".$_POST["captcha"]."'";
}
$html .= "/>";
//adding custom captcha input
$form->add_custom_html($html, "captcha", false);

//adding class predefined validation for captcha
$form->add_class_validation("captcha", "char", true, 5);

//generating form
$form->select_form("test_users", $ex);
echo "</fieldset>";


ob_end_flush();
?>