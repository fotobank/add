<?
/*
 - Product name: floPageLock
 - Author: Joshua Hatfield (flobi@flobi.com)
 - Release Version: 1.0.1-php4
 - Release Date: 2005-10-26
 - License: Free for non-commercial use
 - License stipulations: Please email me and let me know if you use this file at flobi@flobi.com.  Also, you must leave this license, date and author information in the file.

Uppdate Version 1.0.1-php4: 2006-08-29
In systems with an unusually high warning level, some unset keys issue warnings when accessed.  A number of these have been adjusted.  

Alternate Version 1.0.0-php4: 2005-10-26
Changes:
 - Downgraded to PHP4...includes:
 - __construct has changed to:
   function floPageLock($username = NULL, $password = NULL, $autolock = NULL, $redirect = NULL)

Origional Release 1.0.0: 2005-10-22
Documentation:
The included public functions are:
 - function __construct($username = NULL, $password = NULL, $autolock = NULL, $redirect = NULL)
 - function key_add($username, $password)
 - function key_mysql($dbmap)
 - function redirect($where)
 - function lock()

All the functions are pretty well straight forward except key_mysql.  The $dbmap variable needs to be an array formatted like this:
	$dbmap = array(
		"db_host" => "localhost",
		"db_database" => "myxoopsdb",
		"db_username" => "mydbusername",
		"db_password" => "mydbpassword",
		"sql" => "SELECT * FROM `xoops_users` WHERE `mgroup` = '4'",
		"userfield" => "uname",
		"passfield" => "pass"
	);

For more details, please see the sample.php file with this distribution.
*/
@session_start();
if (!isset($_SESSION["floPageLock_credentials"])) {
	$_SESSION["floPageLock_credentials"] = array();
}
if (!isset($_SESSION["floPageLock_failures"])) {
	$_SESSION["floPageLock_failures"] = 0;
}
class floPageLock {
	var $keys = array();
	var $redirect = "";
	function floPageLock($username = NULL, $password = NULL, $autolock = NULL, $redirect = NULL) {
		$this->key_add($username, $password);
		if ($autolock) {
			$this->lock();
		}
		if ($redirect) {
			$this->redirect($redirect);
		}
	}
	function key_add($username, $password) {
		if (strlen($username) > 0 && strlen($password) > 0) {
			$this->keys[] = array(
				"username" => $username,
				"password" => $password
			);
		}
	}
	function key_mysql($dbmap) {
		// It really doesn't make a difference if this is successful or not, the page will still be locked.
		$db_conn = mysql_connect($dbmap["db_host"], $dbmap["db_username"], $dbmap["db_password"]) or die(__FILE__." line ".__LINE__.": Couldn't connect to database.");
		mysql_select_db($dbmap["db_database"], $db_conn) or die(__FILE__." line ".__LINE__.": Couldn't select database.");
		$db_recordset = mysql_query($dbmap["sql"], $db_conn);
		while($db_record = mysql_fetch_array($db_recordset)){
			$this->key_add($db_record[$dbmap["userfield"]], $db_record[$dbmap["passfield"]]);
		} // while
		// Well, I guess it would make a difference that you couldn't unlock it, but you'll get an error message.
	}
	function redirect($where) {
		$this->redirect = $where;
	}
	function lock() {
		$message = false;
		$credentials = $_SESSION["floPageLock_credentials"];
		if (@$_POST["floPageLock_u"] || @$_POST["floPageLock_p"]) {
			if ($_POST["floPageLock_u"]&& $_POST["floPageLock_p"]) {
				if ($this->try_key($_POST["floPageLock_u"], $_POST["floPageLock_p"]) || $_SESSION["floPageLock_failures"] >= 10) {
					$credentials[] = array(
						"floPageLock_u" => $_POST["floPageLock_u"],
						"floPageLock_p" => $_POST["floPageLock_p"]
					);
					$_SESSION["floPageLock_credentials"] = $credentials;
					return false;
				}
				$_SESSION["floPageLock_failures"]++;
				$message = "The credentials you provided are inadequate.";
			} else {
				$message = "You must include both Username and Password.";
			}
		}
		if (count($credentials) > 0) {
			foreach ($credentials as $try) {
				if ($this->try_key($try["floPageLock_u"], $try["floPageLock_p"])) {
					return false;
				}
			}
		}
		if ($this->redirect && $_SERVER["QUERY_STRING"] != "unlock") {
			header("location: ".$this->redirect);
		}
		$this->create_keyhole($message);
	}
	function try_key($username, $password) {
		foreach ($this->keys as $key) {
			if (strtolower($username) == strtolower($key["username"]) &&
				($password == $key["password"] || md5($password) == $key["password"])) {
				return true;
			}
		}
		return false;
	}
	function create_keyhole($message) {
		/*
		* This HTML page is a simple form.  Just keep the form elements the same, and this should work with whatever HTML you want.
		*/

		?>
		<html>
		<head>
			<title>Page Locked by floPageLock</title>
			<style>
				.floPageLock_outertable {
					border: 1px solid #aaaaff;
					background-color: #ffffff;
				}
				.floPageLock_innertable {
					border: 1px solid #aaaaff;
					background-color: #f8f8ff;
				}
				p, td {
					font-family: Verdana, Arial, Helvetica, sans-serif;
					font-size: 10pt;
				}
				h1 {
					font-family: Verdana, Arial, Helvetica, sans-serif;
					font-size: 20pt;
				}
			</style>
		</head>
		<body bgcolor="f8f8ff">
		<table width=100% height=100% class="floPageLock_outertable">
			<tr>
				<td align=center>
					<h1>Page Locked by floPageLock</h1>
					<?
					if ($message) {
						?>
						<p><b><?=$message?></b></p>
						<?
					}
					?>
					<form method=post>
						<p>
							<table class="floPageLock_innertable">
								<tr>
									<td>Username:</td>
									<td><input type=text name="floPageLock_u" value="<?=htmlentities(@$_POST["floPageLock_u"])?>"></td>
								</tr>
								<tr>
									<td>Password:</td>
									<td><input type=password name="floPageLock_p"></td>
								</tr>
								<tr>
									<td colspan=2 align=center><input type=submit value="Unlock Page"></td>
								</tr>
							</table>
						</p>
					</form>
				</td>
			</tr>
		</table>
		</body>
		</html>
		<?
		die("");
	}
}
?>