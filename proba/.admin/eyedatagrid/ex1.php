<?php
require 'class.eyemysqladap.inc.php';
require 'class.eyedatagrid.inc.php';

// Load the database adapter
$db = new EyeMySQLAdap('localhost', 'test', 'test', 'test');

// Load the datagrid class
$x = new EyeDataGrid($db);

// Set the query
$x->setQuery("*", "people");
?>
<html>
<head>
<title>EyeDataGrid Example 1</title>
<link href="table.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>Basic Datagrid</h1>
<p>This is a basic example of the datagrid</p>
<?php
// Print the table
$x->printTable();
?>
</body>
</html>