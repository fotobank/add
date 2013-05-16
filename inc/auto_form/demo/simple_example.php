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
//database connection
include("./connection.php");

//form class
include("./auto_form.php");

//on success

function success($result)
{
	if($result === false)
	{
		echo "<p>Нет связи с базой данных</p>";
	}
	else if($result === 0)
	{
		echo "<p>Не генерируется ID</p>";
	}
	else
	{
		echo "<p>Новый идентификатор ".$result."</p>";
	}
}

$form = new auto_form($serverlink);
$form->debug();

//exclude table columns
$ex = array("ID","Col");

//language array
$lang = array(
	"int" => "Integer", "decimal" => "Decimal", 
	"double" => "Float", "text" => "Text", 
	"bool" => "Checkbox", "enum" => "Select", 
	"set" => "Multiple select", "varchar" => "Default");
$form->set_language($lang);

//set on success function
$form->set_onsuccess("success");

//insert form
echo "<fieldset>";
echo "<legend>Insert form</legend>";
$form->insert_form("test_table", $ex);
echo "</fieldset>";

//update form
echo "<fieldset>";
echo "<legend>Update form</legend>";
$form->update_form("test_table", "WHERE ID = '2'", $ex);
echo "</fieldset>";
ob_end_flush();
?>