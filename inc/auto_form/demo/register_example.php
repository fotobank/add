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

//custom validation - repeated password match
function pass_match($arr)
{
	if($arr["password"] == $arr["repeat_pass"])
	{
		return true;
	}
	else
	{
		return false;
	}
}
//another custom validation
//email address
function check_email($arr)
{
	if(preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/",	$arr["email"]))
	{
		return true;
	}
	else
	{
		return false;
	}
}
//modifying values - hashing password
function hash_pass($arr)
{
	$arr["password"] = md5($arr["password"]);
	return $arr;
}
//class instance
$form = new auto_form($serverlink);

//debug queries
$form->debug();

//setting callback functions
$form->add_custom_validation("pass_match", "Repeated password didn't match");
$form->add_custom_validation("check_email", "Incorrect email format");
$form->set_modification("hash_pass");

//excluding table columns
$ex = array("ID", "password");
//providing form language
$lang = array("username" => "Username", "email" => "Email address", "firstname" => "Firstname", "lastname" => "Lastname", "password" => "Password", "repeat_pass" => "Reapeat password", "gender" => "Gender");
$form->set_language($lang);

/*************************
 * Generating form
 *************************/

echo "<fieldset>";
echo "<legend>Register</legend>";

//adding custom password field
$html = "<input type='password' name='password'";
if(isset($_POST["password"]))
{
	$html .= " value='".$_POST["password"]."'";
}
$html .= "/>";

$form->add_custom_html($html, "password", true);

//adding custom repeated password field
$html = "<input type='password' name='repeat_pass'";
if(isset($_POST["repeat_pass"]))
{
	$html .= " value='".$_POST["repeat_pass"]."'";
}
$html .= "/>";

$form->add_custom_html($html, "repeat_pass", false);

//adding class predefined validation for password
$form->add_class_validation("password", "char", true);

//adding class predefined validation for repeated password
$form->add_class_validation("repeat_pass", "char", true);

//generating form
$form->insert_form("test_users", $ex);
echo "</fieldset>";


ob_end_flush();
?>