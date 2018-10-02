<?php
//define the database connection
$dbhost = "localhost";
//database name
$dbname = "creative_ls";
//database username
$dbuser = "canon632";
//database pass
$dbpass = "fianit8546";

$conn = @mysql_pconnect($dbhost, $dbuser, $dbpass);
$conn = mysql_select_db($dbname, $conn);

$myPath = "";

/***
 * SHOW TABLES   ** row[Tables_in_heart]
 * DESCRIBE [table]
 * SHOW COLUMNS FROM  [tables]
 * Field | Type | Null | Key | Default | Extra
 *
 */
/**
 *
 * MYSQL_PHP_DUMP
 * 'mysql_export_sql_dump.txt' CONTAINS ALL TABLES STRUCTURE
 * TABLENAME_BACKUP.TXT CONTAINS ALL TABLES VALUES
 *
 * @author myPHPDelights
 *
 */
class mysql_php_dump {

	/*
	 * $pathname , directory to load mysql files
	 */
	private $pathname = "";
	private $output = "";
	private $dbname = "";
	private $svnpath = "";
	private $table_fields = array();
	//set the number of rows to created for the insert query
	private $queryLimitRow = 200;
	private $numDumpRows = 0;
	private $files = array();



	/**
	 * CREATE DUMP FILE OF MYSQL DB STRUCTURE AND VALUES
	 */
	function mysql_php_dump($dbname) {

		/*HEADER*/
		$this->dbname = $dbname;
		$this->output
						  = "
-- mysql_export_sql.php dump file
-- version ".mysql_get_server_info()."
--
-- Host: http://".$_SERVER["HTTP_HOST"]."
-- Generation Time: ".date('M d, Y at h:i A')."
-- Server software: ".$_SERVER['SERVER_SOFTWARE']."
-- PHP Version: ".phpversion()."\n
--
-- Database: `$this->dbname`
--
-- --------------------------------------------------------";

	}


	function setPath($path) {

		$this->pathname = $path;
	}


	function getOutput() {

		return $this->output;
	}


	function getNumberDumpRows() {

		return $this->numDumpRows;
	}


	function getFiles() {

		return $this->files;

	}


	/**
	 * COLLECT ALL THE TABLES_NAMES IN THE DATABASE
	 *
	 * @return array[]
	 */
	function getTables() {

		//STORE TABLES FROM DATABASE IN ARRAY TABLES
		$result = mysql_query("SHOW TABLES");
		while ($row = mysql_fetch_assoc($result)) {
			$tables[] = $row['Tables_in_'.$this->dbname];
		}
		return $tables;
	}


	/**
	 * APPEND TABLE_NAME DESCRIPTION INTO A FILE.
	 *
	 * @param String $table
	 */
	function createTableStruc($table) {

		$this->output       = "";
		$this->table_fields = array();
		//STORE FIELD FROM TABLE IN ARRAY FIELDS
		$output = "";
		$result = mysql_query("SHOW COLUMNS IN ".$table);
		while ($row = mysql_fetch_assoc($result)) {
			$field[]   = $row['Field'].'|'.$row['Type'].'|'.$row['Null'].'|'.$row['Default'].'|'.$row['Extra'];
			$key[]     = $row['Key'];
			$columns[] = $row['Field'];
		}
		$output .= "
--
-- Table structure for table `$table`
--

CREATE TABLE IF NOT EXISTS `$table` (\r\n";
		$table_fields = array();
		foreach ($field as $val) {
			$column = explode("|", $val);
			//FIELD TYPE
			$output .= "`$column[0]` $column[1]";
			//NULL
			($column[2] == 'NO') ? $output .= " NOT NULL" : $output .= " NULL";
			//DEFAULT
			($column[3] != "") ? $output .= " DEFAULT '$column[3]'" : $output .= "";
			//EXTRA
			($column[4] != "") ? $output .= " $column[4]" : $output .= "";
			$output .= ",\n";
			$this->table_fields[] = $column[0];

		}
		$col     = 0;
		$primary = array();
		$unique  = "";
		foreach ($key as $val) {
			$column = explode("|", $field[$col]);
			switch ($val) {
				case 'PRI':
					$primary[] = $column[0];
					break;
				case 'UNI':
					$unique = ",\nUNIQUE KEY `$column[0]` ($column[0])";
					break;
				case 'MUL':
					$primary[] = $column[0];
					break;

			}
			$col++;
		}
		if (count($primary) > 0) {
			$output .= "PRIMARY KEY($primary[0]";
			for ($i = 1; $i < count($primary); $i++) {
				$output .= ",$primary[$i]";
			}
			$output .= ")\n";
		}
		$output .= $unique;
		$output .= ")ENGINE=InnoDB DEFAULT CHARSET=latin1;\n\n";
		//remove any extra comma before the engine //this will stop mysql to upload if needed
		$this->output .= str_replace(",\n)ENGINE", "\n)ENGINE", $output);
		$this->dumpingData($table, $columns);

	}


	/**
	 * DUMPING TABLE_NAME.TXT FILE OF ALL THE VALUES IN THE TABLE
	 *
	 * @param String $table  , table name
	 * @param array  $fields , array of table fields
	 */
	function dumpingData($table, $fields) {

		$output      = "";
		$insertTable = "
--
-- Dumping values for table `$table`
-- 

";
		$insertTable .= "insert into $table (";
		//adding the tables fields into the query
		foreach ($this->table_fields as $table_fields) {
			$insertTable .= $table_fields;
			if (end($this->table_fields) != $table_fields) {
				$insertTable .= ",";
			}
		}
		$insertTable .= ") values \n";
		$countRows = 0;
		//OUTPUT CONTENT TO STRING BUFFER OUTPUT
		$result            = mysql_query("SELECT * FROM ".$table);
		$this->numDumpRows = 0;
		while ($row = mysql_fetch_array($result)) {
			if ($countRows == $this->queryLimitRow) {
				//reset counter
				$countRows = 0;
				$output .= "EOF".$insertTable;
			}
			$output .= "(";
			$i = 1;
			foreach ($fields as $val) {
				$value = addslashes($row[$val]);
				//set
				($i == sizeof($fields)) ? $delimiter = "" : $delimiter = ",";
				//if its a number dont put the quotes
				(is_numeric($value)) ? $query = $value : $query = "'$value'";
				$output .= $query.$delimiter;
				$i++;
			}
			$output .= "),\n";
			$countRows++;
			$this->numDumpRows++;
		}
		//flag for EOF
		$output .= "EOF";
		//if there are any rows that where created then add to query
		if ($this->numDumpRows) {
			$this->output .= $insertTable.str_replace(",\nEOF", ";\n", $output);
		}
		//make new directory to dump data
		$directory = $this->makeDirectory();
		//PLACE CONTENT ON [TABLE_NAME].TXT FILE
		file_put_contents("$directory/$table.sql", $this->output);
		//PLACE CONTENT ONTO SVN DIR
		if (is_dir($this->svnpath)) {
			file_put_contents("$this->svnpath/$table.txt", $this->output);
		}
		$this->files[] = "$table.sql";

	}


	function makeDirectory() {

		//create new folder for path
		$directory = $this->pathname.'mysql_backup_'.date('ymd');
		//test that it does not exist
		if (!is_dir($directory)) {
			mkdir($directory);
		}
		/*
		 * CREATE INDEX FOR NEW DIR
		 */
		$content = file_get_contents("index.php");
		//REPLACE CONTENT WITH NEW DIR
		$content = str_replace("getcwd();", '"'.str_replace("\\", "/", $directory).'/";', $content);
		//CREATE NEW FILE WITH NEW LOCATION
		file_put_contents($directory.'/index.php', $content);
		return $directory;

	}

}



$a = new mysql_php_dump($dbname);
$a->setPath($myPath);
$tables = $a->getTables();
/*$a->createTableStruc($tables[21]);
echo $a->getOutput();*/
foreach ($tables as $table) {
	$a->createTableStruc($table);

	//echo "COMPLETED DUMPING $table; ".$a->getNumberDumpRows()." rows affected<br>";
}


$files = $a->getFiles();

if (!empty($files)):
	//echo "CREATING ZIP: mysql_backup_".date('ymd')."<br>";
	$destination = getcwd()."/mysql_backup_".date('ymd');
	$zip         = new ZipArchive();
	$failedToZip = array(); //handler to keep all the failed zip files
	(file_exists($destination.".zip")) ? $ZIPARCHIVE = ZIPARCHIVE::OVERWRITE : $ZIPARCHIVE = ZIPARCHIVE::CREATE;
	if ($zip->open($destination.".zip", $ZIPARCHIVE)) {
		foreach ($files as $file) {
			$localPath = $destination."/".$file;
			if ($zip->addFile($localPath, $file)) {
				//deleting the old file once inserted
			}
			else {
				$failedToZip[] = $file;
			}
		}
	}
	else {
		echo "FAILED TO CREATE ZIP<br>";
	}
	$zip->close();
	//if all zip files where sucessfull zip delete parent folder
	if (!empty($failedToZip)) {
		echo count($failedToZip)." failed to zip<br>";
	}
	else {
		foreach ($files as $file) {
			$localPath = $destination."/".$file;
			unlink($localPath);
		}
		unlink($destination."/index.php");
		rmdir($destination);

	}


endif;

//start deleting any zip files that are over 30 days old
$lastMonth = date("ymd", strtotime("last Month"));


// create a handler for the directory
$handler = opendir(getcwd());

// keep going until all files in directory have been read
while ($file = readdir($handler)) {
	// if $file isn't this directory or its parent,
	// add it to the results array
	if ($file != '.' && $file != '..' && $file != 'index.php' && $file != '.svn' && $file != 'mysql_export_file.php') {
		$results[] = $file;
	}
}

// tidy up: close the handler
closedir($handler);

$count = 0;
foreach ($results as $var) {
	$date = substr($var, strripos($var, "_") + 1, 6);
	if ($date < $lastMonth) {
		echo "Removing $var is is over 30 days old<br />";
		unlink($var);
	}
	$count++;
}

?>
