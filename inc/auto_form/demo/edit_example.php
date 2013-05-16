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
$form->set_modification("hash_pass");

//excluding table columns
$ex = array("ID", "password");
//providing form language
$lang = array("username" => "Username", "email" => "Email address", "firstname" => "Firstname", "lastname" => "Lastname", "password" => "Password", "gender" => "Gender");
$form->set_language($lang);

/*************************
 * Generating form
 *************************/

echo "<fieldset>";
echo "<legend>Edit account</legend>";

//adding custom password field
$html = "<input type='password' name='password'";
if(isset($_POST["password"]))
{
	$html .= " value='".$_POST["password"]."'";
}
$html .= "/>";

$form->add_custom_html($html, "password", true);

//generating form
$form->update_form("test_users", "WHERE ID = '1'", $ex);
echo "</fieldset>";


ob_end_flush();
?>