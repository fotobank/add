<?php
/* $Id: cDBbackup.php,v 1.1 2008/11/06 23:00:00 aedavies Exp $ */
/*
 * Copyright (c) 2008,2009,2010,2011,2012 Archzilon Eshun-Davies
 *	<laudarch@qremiaevolution.org>
 *
 * Permission to use, copy, modify, and distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */

/**
 *
 * @Coder:          Archzilon Eshun-Davies(laudarch)
 * @Description:    Backup MySQL Server
 * @Date:           November 6, 2008
 * @update:         Added interface declaration and turn it into a class(2012/02/14)
 *		   
 */

interface iDBbackup
{
	/**
	 * params for connection
	 *
	 * XXX: $dbName is not implemented yet
	 */
	public function params($dbServer, $user, $password, $file="default",
		$dbName=null);

	/**
	 * Backup Mysql Database
	 */
    	public function mysql();
}

/**
 * DB Backup Class
 *
 * XXX: Backup specific DBs
 *	Possible DB name filter
 */
final class DBbackup implements iDBbackup {
	private $dbserver,
		$user,
		$password,
		$file,
		$dbname;

	/**
	 * Parameters needed to backup database
	 *
	 * @param dbServer
	 * @param user
	 * @param password
	 * @param file
	 * @param dbName
	 */
	public function params($dbServer, $user, $password, $file="default",
		$dbName=null)
	{
		$date 		= date("Ymd_Hi");
		$this->dbserver = $dbServer;
		$this->user	= $user;
		$this->password	= $password;
		$this->file	= ($file=="default") ? "dbbackup_$date.php" :
			$file;
		$this->dbname	= $dbName;
	}

	/**
	 * Backup MySQL server
	 * This would backup the *whole* my sql database except the 'mysql' db
	 * Specific db filter would be added later :)
	 *
	 */
	public function mysql()
	{
		$fd = fopen($this->file, 'w');
		$t = date("H:i:s");
		$d = date("Y/m/d");
		$head = "<?php\n\n
		/* \$Id: {$this->file},v 1.0 $d $t aedavies Exp $ */
		/*
		 * MySQL Backup by:
		 * laudarch(Archzilon Eshun-Davies)
		 */

		\$user = '{$this->user}';\n
		\$password = '{$this->password}';\n
		\$con = mysql_connect('{$this->dbserver}', \$user, \$password);
		\n\n";
		
		fwrite($fd, $head);
        
		$con    = mysql_connect($this->dbserver, $this->user, $this->password );
		$dblist = mysql_list_dbs($con);
		while ($row  = mysql_fetch_object($dblist)) {
			$db = $row->Database;
			if ($db !== "mysql") {
				$dbcreate = "mysql_query(\"CREATE DATABASE `$db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci\");";
				fwrite($fd, "$dbcreate\n");
				$dbselect = mysql_select_db("$db");
				fwrite($fd, "mysql_select_db('$db');\n");
				$tbl = mysql_list_tables($db);
				while ($table = mysql_fetch_row($tbl)) {
					$fld = mysql_query("SELECT * FROM `$table[0]`");
					if ($fld)
						$fields = mysql_num_fields($fld);
					else
						$fields = 0;

					unset($tblcreate);

					$tblcreate = "CREATE TABLE `$table[0]` (";
					$arrfield = array();
					$arrfieldnum = 0;
					for ($i=0; $i<$fields; $i++) {
						$fieldinfo = mysql_fetch_field($fld, $i);
						unset($fieldname);
						$fieldname = $fieldinfo->name;
						$arrfield[$arrfieldnum] = $fieldname;
						$arrfieldnum++;
						$fieldlen = mysql_field_len($fld, $i);
						if ($fieldlen=="65535") {
							$fieldtype = "TEXT";
						} else {
							$fieldtype = "VARCHAR($fieldlen)";
						}
						$tblcreate .= "`$fieldname` $fieldtype NOT NULL";
						if ($i !== $fields - 1) {
							$tblcreate .= ", ";
						}
					}
					$tblcreate .= ")";
					fwrite($fd,"     mysql_query(\"$tblcreate\", \$con);\n" );
					$readtable = "SELECT * FROM `$table[0]`";
					$retval = mysql_query($readtable);

					if ($retval)
						while ($col = mysql_fetch_row($retval)) {
							$insert = "mysql_query(\"INSERT INTO `$table[0]` (";
							for ($ifield=0; $ifield<count($arrfield)-1; $ifield++) {
								$insert .= "`{$arrfield[$ifield]}`, ";
							}
							$insert .= "`{$arrfield[$ifield]}`) VALUES(";
							for ($icol=0; $icol<count($col)-1; $icol++) {
								$col[$icol] = str_replace("\"", "'", $col[$icol]);
								$insert .= "'{$col[$icol]}', ";
							}
							$insert .= "'{$col[$icol]}'";
							$insert .= ")\", \$con);";
							fwrite($fd, "          $insert\n");
						}
				}
			}
		}
		mysql_close($con);

		$tail = "\nmysql_close(\$con);\n\n
		?>\n\n
		<html><title>MySQL Restoration by laudarch</title><body>\n
		<font face=\"arial\" size=4 color=\"#000000\"><b>Database Restored!</b></font>\n
		</body></html>";

		fwrite($fd, $tail);
		fclose( $fd );
	}
}
?>