<?php

require("config.php.inc");

$conn = new config_class;

mysql_connect($conn->server, $conn->db_user, $conn->db_pass) or die("mysql conn failed!");
mysql_select_db($conn->database) or die("db select failed!");

$query = mysql_query("CREATE TABLE authlib_confirm (
   mdhash longtext,
   username text,
   password text,
   name text,
   email text,
   age int(3),
   sex text,
   school longtext,
   date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL
)");

if (!$query) echo "authlib_confirm table was not created due to an internal error";

$query = mysql_query("CREATE TABLE authlib_confirm_email (
   id int(8),
   email text,
   mdhash longtext,
   date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL
)");

if (!$query) echo "<br>authlib_confirm_email table was not created due to an internal error";

$query = mysql_query("CREATE TABLE authlib_data (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   name text NOT NULL,
   email text NOT NULL,
   age int(3) DEFAULT '0' NOT NULL,
   sex text NOT NULL,
   school text NOT NULL,
   PRIMARY KEY (id)
)");

if (!$query) echo "<br>authlib_data table was not created due to an internal error";

$query = mysql_query("CREATE TABLE authlib_login (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   username text NOT NULL,
   password text NOT NULL,
   PRIMARY KEY (id)
)");

if (!$query) echo "<br>authlib_login table was not created due to an internal error";

echo "done installation!";