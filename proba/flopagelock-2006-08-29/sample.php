<?
/*
 - Product name: floPageLock
 - Author: Joshua Hatfield (flobi@flobi.com)
 - Release Version: 1.0.0
 - Release Date: 2005-10-22
 - License: Free for non-commercial use

SAMPLE FILE
 - This sample file demonstrates numerous ways this can be implemented.
 - This SHOULD be before any other code.
*/
include("floPageLock.php");
$locking_method = 1;
switch($locking_method){
	case 1:
		/*
		* Method 1, simple lock.  Username, password, autolock.
		* -- Not setting redirect turns it off.
		* -- That also applies if you set autolock to anything with a strlen of 0 (null, false, "", etc.).
		*/
		$pagelock = new floPageLock("myusername", "mypassword", true);
		break;
	case 2:
		/*
		* Method 2, simple lock w/ redirect.  Username, password, autolock, redirection location.
		* -- You can override the redirection with ?unlock as your querystring.
		* -- e.g if your url is
		* http://www.flobi.com/test/floPageLock/
		* -- you can override the redirect by going to 
		* http://www.flobi.com/test/floPageLock/?unlock
		*/
		$pagelock = new floPageLock("myusername", "mypassword", true, "http://www.google.com/");
		break;
	case 3:
		/*
		* Method 3, delay lock.  Username, password.
		* -- Not setting autolock requires lock function call later
		* -- That also applys if you set autolock to a false value (null, false, "", 0, etc.).
		* -- In the mean time, we can set an extra key.
		* -- Passwords in keys can be saved as md5 or plain text.  
		*/
		$pagelock = new floPageLock("myusername", "mypassword");
		$pagelock->key_add("myusername2", "f13649e3de0a972fa8b0334af9acd23f");
		$pagelock->key_add("myusername3", "mypassword3");
		// You CAN have 1 username with multiple passwords.
		$pagelock->key_add("myusername", "mypassword4");
		$pagelock->lock();
		break;
	case 4:
		/*
		* Method 4, delay lock with keys from Xoops db.  
		* -- Not setting username and password causes no initial key to be created.
		* -- Let's get some keys from a mysql table.
		* -- I've got Xoops installed, we can use the admin users from that.
		*/
		$pagelock = new floPageLock();
		$dbmap = array(
			"db_host" => "localhost",
			"db_database" => "myxoopsdb",
			"db_username" => "mydbusername",
			"db_password" => "mydbpassword",
			// The default admin group is created 4th, thereby getting an mgroup of 4 by default.
			"sql" => "SELECT * FROM `xoops_users` WHERE `mgroup` = '4'",
			"userfield" => "uname",
			"passfield" => "pass"
		);
		$pagelock->key_mysql($dbmap);
		$pagelock->lock();
		break;
	case 5:
		/*
		* Method 4, delay lock with numerous key sources.  
		* -- I've still got Xoops installed.
		* -- I've also got a custom user db, we can add those too.  
		*/
		$pagelock = new floPageLock("myusername", "mypassword");
		$pagelock->key_add("myusername2", "f13649e3de0a972fa8b0334af9acd23f");
		// Xoops keys:
		$dbmap = array(
			"db_host" => "localhost",
			"db_database" => "myxoopsdb",
			"db_username" => "mydbusername",
			"db_password" => "mydbpassword",
			"sql" => "SELECT * FROM `xoops_users` WHERE `mgroup` = '4'",
			"userfield" => "uname",
			"passfield" => "pass"
		);
		$pagelock->key_mysql($dbmap);
		// They can be added in any order.
		$pagelock->key_add("myusername3", "mypassword3");
		// My custom db:
		$dbmap = array(
			"db_host" => "localhost",
			"db_database" => "mycustomsdb",
			"db_username" => "mydbusername",
			"db_password" => "mydbpassword",
			"sql" => "
				SELECT 
					`users`.`username` as `username`, 
					`users`.`password` as `password` 
				FROM 
					`users`, 
					`user_groups` 
				WHERE 
					`users`.`username` = `user_groups`.`username` AND
					`user_groups`.`group` = 'admin'
			", // Okay, I made up the structure, but you get the point.
			"userfield" => "username",
			"passfield" => "password"
		);
		$pagelock->key_mysql($dbmap);
		// Let's redirect too, why not?
		$pagelock->redirect("http://www.flobi.com/");
		$pagelock->lock();
		break;
	case 6:
		/*
		* Method 6, I just feel like being a bastard.
		* -- The user will have to enter the first password...
		* -- then (without notification), will be required to enter the second.
		* -- but only after entering the first.  
		*/
		$pagelock = new floPageLock("myusername", "mypassword", true);
		$pagelock2 = new floPageLock("myusername2", "mypassword2", true);
		break;
	case 7:
		/*
		* Method 7, method 1 longhand.
		*/
		$pagelock = new floPageLock();
		$pagelock->key_add("myusername", "mypassword");
		$pagelock->lock();
		break;
} // switch
?>
<html>
<head>
	<title>floPageLock Test (unlocked)</title>
	<style>
		.floPageLock_outertable {
			border: 1px solid #aaaaff;
			background-color: #ffffff;
		}
		p {
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
			<h1>floPageLock Test (unlocked)</h1>
			<p>The page you are looking at has been unlocked.  </p>
		</td>
	</tr>
</table>
</body>
</html>
