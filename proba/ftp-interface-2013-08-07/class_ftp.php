<?php
/*********************************************************************************
**
** class FTP
** rev 2013-08-07 Mark Kintigh
**
** Common class to interface with an FTP server
** ______________________________________________________________________________
**
** $this->server == FTP server's name
** $this->logon_user == User name for the FTP logon
** $this->logon_pswd == User name's password for the FTP logon
** $this->transfer_mode == Current/default transfer mode for FTP file transfers
** $this->lconnected() == Returns the current status of the FTP connection
** $this->connect(["server", 'user", "password]) == Returns if a connection to
**      the FTP server was successful.  Optionally, a new server, user name, and
**      password can be given
** $this->pasivemode(<true/false>) == Set the passive mode for the FTP connection;
**      true = passive, false = active.
** $this->close() == Attempts to close the connection to the FTP server
** $this->makedir("directory") == Attempts to create a directory on the remote
**      FTP host.  This will create an entire path of folders if necessary.
**      Returns the success or failure of the attempt.
** $this->lpwd() == Returns the local, present working directory
** $this->pwd() == Returns the remote (FTP), present working directory
** $this->lcd("directory") == Attempts to change the local directory; returns the
**      success or failure
** $this->cd("directory") == Attempts to change the remote directory; returns the
**      success or failure
** $this->isdir("directory") == Returns if the given name is a directory or not;
**      this can be the full path or relative to the present working directory
** $this->dir(["new directory"]) == Returns an array of file and folder names
**      from the FTP server (empty array if error/not connected/etc).  Optionally
**      a new folder path can be given
** $this->dirfind($filespecs) == Returns an array of files and folder names from
**      the FTP server that match the given file specifications (empty array if
**      error/not connected/etc)
** $this->dirdetails(["directory"]) == Returns an array of arrays with details
**      about each of the directory entries.  The subarray contains the following:
**           [x]['name'] == File/directory name for this entry
**           [x]['dir'] == T/F; true = subdirectory, false = file
**           [x]['size'] == Human readable version of the file size (blank if
**                 directory)
**           [x]['chmod'] == Unix permissions (blank if Windows server)
**           [x]['date'] == Date of the file
**           [x]['raw'] == the raw array of information that the above was built
**                 from
**      Optionally a new folder path can be given
** $this->get($filename[,$mode=NULL]) == Attempt to download a file.  The file
**      name can contain a path as well.  Optionally the transfer mode is give.
** $this->mget($filespecs[, $mode=NULL]) == Attempt to download a group of files
**      from server.  The file  name can contain a path as well.  Optionally the
**      transfer mode is give.
** $this->getdir($path[, $recursive=true[, $mode=NULL]]) == Attempts to download
**      an entire directory from an FTP server.  Optionally you can download just
**      the files in the first folder or (default) the entire tree.  You can also
**      change/set the download mode as well.
** $this->getdirfilter($path[[[, $filter="*"[, $recursive=true[, $mode=NULL]]])
**      Attempts to download a list of files matching a given pattern from a
**      directory from an FTP server.  Optionally you can download just the files
**      in the first folder or (default) the entire tree.  You can also change/set
**      the download mode as well.
** $this->put($filename[, $dest=""[,$mode=NULL]]) == Attempts to upload a single
**      file to the FTP server.  Optionally it will upload it in a destination
**      directory.  You can also change/set the upload mode as well.
** $this->mput($filespecs="*"[, $dest=""[, $mode=NULL]]) == Attempts to upload a
**      file(s) to the FTP server.  Optionally it will upload it in a destination
**      directory.  You can also change/set the upload mode as well.
** $this->putdir($srcdir[, $destdir=""[, $mode=NULL]]) == Attempts to upload a
**      folder to the FTP server.  Optionally it will upload it in a destination
**      directory.  You can also change/set the upload mode as well.
** $this->del($file) == Attempts to delete a file on the FTP host.  Returns
**      success or failure.
** $this->deldir($dir) == Attempts to delete a folder on the FTP host.  Returns
**      success or failure.
** $this->exists($path) == Checks to see if a file exists.  Returns T/F.
** $this->existsdir($path)  == Checks to see if a file or folder exists.  Returns
**      T/F.
** $this->movetoserver($file[, $dest=""[, $mode=NULL]]) == Combines the tasks of
**      uploading a file, verifying it was uploading, then removing it from the
**      local server.  Returns success or failure.
** $this->movefromserver($file[, $mode=NULL]) == Combines the tasks of downloading
**      a file, verifying it was downloaded, then removing it from the FTP server.
**      Returns success or failure.
** $this->rename($oldname, $newname) == Will attempt to rename the given file on
**      the remote host to a new name.  Returns success / failure.
** $this->chmod($mode, $filename) == Will attempt to set permissions on a file on
**      the host.  Returns success or failure.  This ONLY works on a Linux/UNIX
**      host because it call the external "chmod" command to set these values.
**      Limitations on how the mode is passed depends on the FTP host; best bet is
**      to use the 3 octal numbers instead of something like "u+rw,g+w,o+r".
** $this->translatecommand($commandline) == Will attempt to translate the string
**      into the operation for this class and execute it -- used for translating
**      scripts.  Returns success or failure.
**
*********************************************************************************/
class FTP {
	//
	// Public variables
	//
	public $server = "";
	public $logon_user = "";
	public $logon_pswd = "";
	public $transfer_mode = FTP_BINARY;
	//
	// Private, global variables
	//
	private $lconnected = false;
	private $conn;
	private $port = 21;
	
	//----------------------------------------------------------------------------
	public function __construct($newserver="", $newuser="", $newpswd="") {
		$this->server = trim($newserver);
		$this->logon_user = trim($newuser);
		$this->logon_pswd = trim($newpswd);
		$this->checkforport();
    }
	
	//----------------------------------------------------------------------------
	private function checkforport() {
		//
		// Check the set server's name for a port number (standard
		// "ftp.some.com:2121" configuration)
		//
		if(strpos($this->server, ":")>-1) {
			$a = split(":", $this->server, 2);
			$this->server = trim($a[0]);
			$this->port = intval($a[1])>0 ? intval($a[1]) : 21;
			unset($a);
		}
	}

	//----------------------------------------------------------------------------
	private function connected() {
		//
		// Return the current status of the FTP connection
		//
		return $this->lconnected;
	}
	
	//----------------------------------------------------------------------------
	public function connect($newserver="", $newuser="", $newpswd="") {
		//
		// Attempt to connect to an FTP server
		// __________
		//
		// If the 3 optional parameters are all set, change to the new server
		//
		if(strlen(trim($newserver))>0 && strlen(trim($newuser))>0 && 
			strlen(trim($newpswd))>0) {
			$this->server = trim($newserver);
			$this->logon_user = trim($newuser);
			$this->logon_pswd = trim($newpswd);
			$this->checkforport();
		}
		//
		// If there is already an open connection close it
		//
		if($this->lconnected) $this->close();
		//
		// Try to connect to the FTP server and then try to login
		//
		$this->conn = ftp_connect($this->server, $this->port);
		$result = ftp_login($this->conn, $this->logon_user, $this->logon_pswd);
		if(!$this->conn || !$result) {
			$this->lconnected = false;
			return false;
		} else {
			$this->lconnected = true;
			return true;
		}
	}

	//----------------------------------------------------------------------------
	public function pasivemode($isPassive=true) {
		//
		// Set the passive mode for the connection
		//
		if(!$this->lconnected) return false;
		return ftp_pasv($this->conn, $isPassive);
	}

	//----------------------------------------------------------------------------
	public function close() {
		//
		// If there is a connection open close it
		//
		if($this->conn) {
			ftp_close($this->conn);
			$this->lconnected = false;
		}
	}

	//----------------------------------------------------------------------------
	public function makedir($dirname) {
		if(!$this->lconnected) return false;
		$pwd = $this->pwd();
		$cur = $pwd;
		//
		// Determine if this is just creating one folder or a series of folders
		//
		$temp = str_replace("\\","/",$dirname);
		//
		// If the path start with the root, then change out the path to root
		//
		if(substr($temp,0,1)=="/") {
			$temp = substr($temp,1);
			$this->cd("/");
			$cur = "/";
		}
		if(strpos($temp,"/")>-1) {
			//
			// Has a full path, so verify that the folders exist or create the
			// desired folder
			//
			$ret = true;
			//
			// For each of the parts
			//
			foreach(split("/",$temp) as $part) {
				//
				// Add this part to the current path
				//
				$cur .= "/$part";
				//
				// Try to change to the folder
				//
				if(!$this->cd($cur)) {
					//
					// It did not change, so try to create the folder
					//
					if(ftp_mkdir($this->conn, $cur)) {
						//
						// Successfully created the folder, so change to it
						//
						$this->cd($cur);
					} else {
						//
						// Fail the creation of the path
						//
						$ret = false;
					}
				}
			}
			//
			// Return to the original folder and return the results
			//
			$this->cd($pwd);
			return $ret;
		} else {
			//
			// Just try to create the folder
			//
			return ftp_mkdir($this->conn, $dirname);
		}
	}

	//----------------------------------------------------------------------------
	public function lpwd() {
		//
		// Return local present working directory
		//
		return getcwd();
	}
	
	//----------------------------------------------------------------------------
	public function pwd() {
		//
		// Return the remote present working directory
		//
		if(!$this->lconnected) return "";
		return ftp_pwd($this->conn);
	}
	
	//----------------------------------------------------------------------------
	public function lcd($ldir) {
		//
		// Local change directory; return success/faliure
		//
		if(is_dir($ldir)) {
			return @chdir($ldir);
		} else {
			return false;
		}
	}

	//----------------------------------------------------------------------------
	public function cd($rdir) {
		//
		// Change the remote directory, if possible, and return
		// success/failure
		//
		if(!$this->lconnected) return false;
		return @ftp_chdir($this->conn, $rdir);
	}
	
	//----------------------------------------------------------------------------
	public function isdir($foldername) {
		//
		// Check to see if the given folder name is a directory.  If
		// it fails the first time, try again after adding the present
		// working directory
		//
		if(!$this->lconnected) return false;
		$pwd = $this->pwd();
		$ret = $this->cd($foldername);
		if(!$ret) {
			$tmp = "$pwd/$foldername";
			$ret = $this->cd($foldername);
		}
		$this->cd($pwd);
		return $ret;
	}
	
	//----------------------------------------------------------------------------
	public function dir($newdir="") {
		if(!$this->lconnected) return array();
		$pwd = $this->pwd();
		//
		// If the user wants a different directory, try to change to
		// that directory
		//
		if(strlen(trim($newdir))>0) {
			if($this->cd($newdir)) {
				$pwd = $this->pwd();
			}
		}
		$list = ftp_nlist($this->conn, $pwd);
		//
		// Strip the path off of the file names
		//
		for($x=0; $x<count($list); $x++) {
			$list[$x] = substr($list[$x], strlen($pwd));
			//
			// Remove any leading "\" and "/" characters
			//
			if(strcmp(substr($list[$x],0,1),"\\")==0)
				$list[$x] = substr($list[$x],1);
			if(strcmp(substr($list[$x],0,1),"/")==0)
				$list[$x] = substr($list[$x],1);
		}
		return $list;
	}
	
	//----------------------------------------------------------------------------
	public function dirfilter($filespecs="*.*") {
		if(!$this->lconnected) return array();
		$pwd = $this->pwd();
		$list = @ftp_nlist($this->conn, "$pwd/" . trim($filespecs));
		//
		// Strip the path off of the file names
		//
		for($x=0; $x<count($list); $x++) {
			$list[$x] = substr($list[$x], strlen($pwd));
			//
			// Remove any leading "\" and "/" characters
			//
			if(strcmp(substr($list[$x],0,1),"\\")==0)
				$list[$x] = substr($list[$x],1);
			if(strcmp(substr($list[$x],0,1),"/")==0)
				$list[$x] = substr($list[$x],1);
		}
		return $list;
	}

	//----------------------------------------------------------------------------
	public function dirdetails($newdir="") {
		if(!$this->lconnected) return array();
		$pwd = $this->pwd();
		//
		// If the user wants a different directory, try to change to
		// that directory
		//
		if(strlen(trim($newdir))>0) {
			if($this->cd($newdir)) {
				$pwd = $this->pwd();
			}
		}
		$list = ftp_rawlist($this->conn, $this->pwd(), false);
		$ret = array();
		if(empty($list)) return $ret;
		foreach($list as $fil) {
			$info = array(
				'name'=>'',
				'dir'=>false,
				'size'=>'',
				'chmod'=>'',
				'date'=>'',
				'raw'=>NULL
				);
			if(strpos("0123456789",substr($fil,0,1))>-1) {
				//
				// Windows FTP host
				//
				$split = preg_split("/[\s]+/", $fil);
				if(count($split)>3) {
					$split = preg_split("/[\s]+/", $fil, 4);
					$info['name'] = str_replace(":", "", trim($split[3]));
					if(strcmp("<DIR>",trim($split[2]))==0) {
						$info['dir'] = true;
					} else {
						$info['dir'] = false;
						$info['size'] = $this->byteconvert($split[2]);
					}
					$info['date'] = strtotime(str_replace("-","/", "{$split[0]} "
						. str_replace("P"," P",
							str_replace("A"," A",strtoupper($split[1])))));
					$info['raw'] = $split;
				}
			} elseif(strlen(trim($fil))>0) {
				//
				// UNIX FTP host
				//
				$split = preg_split("/[\s]+/", $fil);
				if(count($split)>8) {
					$split = preg_split("/[\s]+/", $fil, 9);
					$info['name'] = trim($split[8]);
					$info['dir'] = ($split[0]{0}=='d');
					$info['size'] = $this->byteconvert($split[4]);
					$info['chmod'] = $this->chmodnum($split[0]);
					$info['date'] = strtotime("{$split[6]} {$split[5]} {$split[7]}");
					$info['raw'] = $split;
				}
			}
			if(strlen(trim($info['name']))>0) {
				array_push($ret,$info);
			}
			unset($info);
		}
		//
		// Strip the path off of the file names
		//
		return $ret;
	}

	//----------------------------------------------------------------------------
	private function stringMatchWithWildcard($source,$pattern) {
		$pattern = preg_quote($pattern,'/');        
		$pattern = str_replace( '\*' , '.*', $pattern);   
		return preg_match( '/^' . $pattern . '$/i' , $source );
	}

	//----------------------------------------------------------------------------
	public function dirdetailsfilter($filespecs="*", $newdir="") {
		if(!$this->lconnected) return array();
		$pwd = $this->pwd();
		//
		// If the user wants a different directory, try to change to
		// that directory
		//
		if(strlen(trim($newdir))>0) {
			if($this->cd($newdir)) {
				$pwd = $this->pwd();
			}
		}
		$list = ftp_rawlist($this->conn, $this->pwd(), false);
		$ret = array();
		if(empty($list)) return $ret;
		foreach($list as $fil) {
			$info = array(
				'name'=>'',
				'dir'=>false,
				'size'=>'',
				'chmod'=>'',
				'date'=>'',
				'raw'=>NULL
				);
			if(strpos("0123456789",substr($fil,0,1))>-1) {
				//
				// Windows FTP host
				//
				$split = preg_split("/[\s]+/", $fil);
				if(count($split)>3) {
					$split = preg_split("/[\s]+/", $fil, 4);
					$info['name'] = str_replace(":", "", trim($split[3]));
					if(strcmp("<DIR>",trim($split[2]))==0) {
						$info['dir'] = true;
					} else {
						$info['dir'] = false;
						$info['size'] = $this->byteconvert($split[2]);
					}
					$info['date'] = strtotime(str_replace("-","/", "{$split[0]} "
						. str_replace("P"," P",
							str_replace("A"," A",strtoupper($split[1])))));
					$info['raw'] = $split;
				}
			} elseif(strlen(trim($fil))>0) {
				//
				// UNIX FTP host
				//
				$split = preg_split("/[\s]+/", $fil);
				if(count($split)>8) {
					$split = preg_split("/[\s]+/", $fil, 9);
					$info['name'] = trim($split[8]);
					$info['dir'] = ($split[0]{0}=='d');
					$info['size'] = $this->byteconvert($split[4]);
					$info['chmod'] = $this->chmodnum($split[0]);
					$info['date'] = strtotime("{$split[6]} {$split[5]} {$split[7]}");
					$info['raw'] = $split;
				}
			}
			if($this->stringMatchWithWildcard(trim($info['name']), $filespecs)) {
				array_push($ret,$info);
			}
		}
		//
		// Strip the path off of the file names
		//
		return $ret;
	}

	//----------------------------------------------------------------------------
	private function byteconvert($bytes) {
		$symbol = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$exp = floor( log($bytes) / log(1024) );
		return @sprintf( '%.2f ' . $symbol[ $exp ], 
			($bytes / pow(1024, floor($exp))) );
	}

	//----------------------------------------------------------------------------
	private function chmodnum($chmod) {
		$trans = array('-' => '0', 'r' => '4', 'w' => '2', 'x' => '1');
		$chmod = substr(strtr($chmod, $trans), 1);
		$array = str_split($chmod, 3);
		return array_sum(str_split($array[0])) . array_sum(str_split($array[1]))
			. array_sum(str_split($array[2]));
	}

	//----------------------------------------------------------------------------
	public function get($filename,$mode=NULL) {
		if(!$this->lconnected) return false;
		//
		// Check to see if the user wants to use a specific transfer method,
		// otherwise assume that they want to use the class' default mode
		//
		$usemode = $this->transfer_mode;
		if($mode==FTP_BINARY || $mode==FTP_ASCII) $usemode = $mode;
		//
		// Check to see if there is a path as part of the file name and, if so,
		// split off the file name to use it as the local file name too
		//
		if(strpos($filename,"\\")>-1) {
			$parts = explode("\\",$filename);
			$localname = array_pop($parts);
			unset($parts);
		} elseif(strpos($filename,"/")>-1) {
			$parts = explode("/",$filename);
			$localname = array_pop($parts);
			unset($parts);
		} else {
			$localname = $filename;
		}
		//
		// Try to get the file
		//
		if(ftp_get($this->conn, $localname, $filename, $usemode)) {
			return true;
		} else {
			return false;
		}
	}
	
	//----------------------------------------------------------------------------
	public function mget($filespecs, $mode=NULL) {
		if(!$this->lconnected) return false;
		$pwd = $this->pwd();
		$remotepath = $pwd;
		//
		// Check to see if the user wants to use a specific transfer method,
		// otherwise assume that they want to use the class' default mode
		//
		$usemode = $this->transfer_mode;
		if($mode==FTP_BINARY || $mode==FTP_ASCII) $usemode = $mode;
		//
		// Check to see if there is a path as part of the file specs and, if so,
		// split off the filespecs and the folder path
		//
		if(strpos($filespecs,"\\")>-1) {
			$parts = explode("\\",$filename);
			$localspecs = array_pop($parts);
			$remotepath = implode("\\",$parts);
			unset($parts);
		} elseif(strpos($filespecs,"/")>-1) {
			$parts = explode("/",$filename);
			$localspecs = array_pop($parts);
			$remotepath = implode("/",$parts);
			unset($parts);
		} else {
			$localspecs = $filespecs;
		}
		//
		// The the present working directory on the FTP server is not the same as
		// the desired location, try to change to that folder.  If that does not
		// work then exit with failure here (not accessable/does not exist).
		//
		if(strcmp($pwd,$remotepath)!=0) if(!$this->cd($remotepath)) return false;
		//
		// Process each of the files
		//
		$success = 0;
		$found = 0;
		foreach($this->dirdetailsfilter($localspecs, $remotepath) as $info) {
			//
			// If this is NOT a folder
			//
			if(!$info['dir']) {
				$found++;
				if($this->get($info['name'], $usemode)) {
					$success++;
				}
			}
		}
		//
		// The the present working directory on the FTP server is not the same as
		// the desired location, try to return to the old directory.
		//
		if(strcmp($pwd,$remotepath)!=0) $this->cd($pwd);
		//
		// Determine what to return
		// * If nothing found, return -1
		// * If found = success, return 1
		// * Otherwise, return 0
		//
		if($found==0) {
			return -1;
		} elseif($found==$success) {
			return 1;
		} else {
			return 0;
		}
	}

	//----------------------------------------------------------------------------
	function getdir($path, $recursive=true, $mode=NULL) {
		if(!$this->lconnected) return false;
		$pwd = $this->pwd();
		$ret = true;
		//
		// Check to see if the user wants to use a specific transfer method,
		// otherwise assume that they want to use the class' default mode
		//
		$usemode = $this->transfer_mode;
		if($mode==FTP_BINARY || $mode==FTP_ASCII) $usemode = $mode;
		$parts = explode("/", str_replace("\\","/",$path));
		//
		// Stip the desired folder name off of the given path
		//
		$foldername = array_pop($parts);
		unset($parts);
		if(!is_dir($foldername)) mkdir($foldername);
		if($this->lcd($foldername)) {
			//
			// What kind of get is this -- single folder or recursive
			//
			if($recursive) {
				if($this->cd($path)) {
					//
					// In the subfolder, so read the directory
					//
					$files = $this->dirdetails();
					foreach($files as $fil) {
						if($fil['dir']==true) {
							//
							// This is a folder, so recursively call the function
							// __________
							//
							// 1 -- get the current local path
							// 2 -- recursively call this function
							// 3 -- return to the current remote path
							// 4 -- return to the local path before the recursion
							//
							$olddir = $this->lpwd();
							$this->getdir($path . "/" . trim($fil['name']),
								$recursive, $usemode);
							$this->cd($path);
							$this->lcd($olddir);
						} else {
							//
							// Download the file
							//
							if(!$this->get($path . "/" . $fil['name'], $usemode)) {
								$ret = false;
							}
						}
					}
				} else {
					//
					// Could not change to the desired path on the FTP server, so
					// this operation has failed
					//
					$ret=false;
				}
			} else {
				//
				// Just download the files in the given folder; this will recreate
				// the folder name in the current path.  If it already exists it will
				// just add files to the existing folder.
				if($this->cd($path)) {
					//
					// In the subfolder, so read the directory
					//
					$files = $this->dirdetails();
					foreach($files as $fil) {
						//
						// If this entry is not a directory...
						//
						if($fil['dir']==false) {
							//
							// ...download the file
							//
							if(!$this->get($fil['name'], $usemode)) {
								$ret = false;
							}
						}
					}
				} else {
					//
					// Could not change to the desired path on the FTP server, so
					// this operation has failed
					//
					$ret=false;
				}
			}
		} else {
			//
			// Could not change to the desired path on the local machine, so
			// this operation has failed
			//
			$ret=false;
		}
		//
		// Return to the original path
		//
		$this->cd($pwd);
		return $ret;
	}

	//----------------------------------------------------------------------------
	function getdirfilter($path, $filter="*", $recursive=true, $mode=NULL) {
		if(!$this->lconnected) return false;
		$pwd = $this->pwd();
		$ret = true;
		//
		// Check to see if the user wants to use a specific transfer method,
		// otherwise assume that they want to use the class' default mode
		//
		$usemode = $this->transfer_mode;
		if($mode==FTP_BINARY || $mode==FTP_ASCII) $usemode = $mode;
		$parts = explode("/", str_replace("\\","/",$path));
		//
		// Stip the desired folder name off of the given path
		//
		$foldername = array_pop($parts);
		unset($parts);
		if(!is_dir($foldername)) mkdir($foldername);
		if($this->lcd($foldername)) {
			//
			// What kind of get is this -- single folder or recursive
			//
			if($recursive) {
				if($this->cd($path)) {
					//
					// In the subfolder, so read the directory
					//
					$files = $this->dirdetailsfilter($filter);
					if(!empty($files)) {
						foreach($files as $fil) {
							if($fil['dir']==true) {
								//
								// This is a folder, so recursively call the function
								// __________
								//
								// 1 -- get the current local path
								// 2 -- recursively call this function
								// 3 -- return to the current remote path
								// 4 -- return to the local path before the recursion
								//
								$olddir = $this->lpwd();
								$this->getdirfilter($path . "/" . trim($fil['name']),
									$filter, $recursive, $usemode);
								$this->cd($path);
								$this->lcd($olddir);
							} else {
								//
								// Download the file
								//
								if(!$this->get($path . "/" . $fil['name'], $usemode)) {
									$ret = false;
								}
							}
						}
					} else {
						//
						// Nothing matched
						//
						$ret=false;
					}
				} else {
					//
					// Could not change to the desired path on the FTP server, so
					// this operation has failed
					//
					$ret=false;
				}
			} else {
				//
				// Just download the files in the given folder; this will recreate
				// the folder name in the current path.  If it already exists it will
				// just add files to the existing folder.
				if($this->cd($path)) {
					//
					// In the subfolder, so read the directory
					//
					$files = $this->dirdetails();
					foreach($files as $fil) {
						//
						// If this entry is not a directory...
						//
						if($fil['dir']==false) {
							//
							// ...download the file
							//
							if(!$this->get($fil['name'], $usemode)) {
								$ret = false;
							}
						}
					}
				} else {
					//
					// Could not change to the desired path on the FTP server, so
					// this operation has failed
					//
					$ret=false;
				}
			}
		} else {
			//
			// Could not change to the desired path on the local machine, so
			// this operation has failed
			//
			$ret=false;
		}
		//
		// Return to the original path
		//
		$this->cd($pwd);
		return $ret;
	}

	//----------------------------------------------------------------------------
	public function put($filename, $dest="",$mode=NULL) {
		if(!$this->lconnected) return false;
		$pwd = $this->pwd();
		//
		// Check to see if the user wants to use a specific transfer method,
		// otherwise assume that they want to use the class' default mode
		//
		$usemode = $this->transfer_mode;
		if($mode==FTP_BINARY || $mode==FTP_ASCII) $usemode = $mode;
		//
		// Check to see if there was a destination location given.  If so, change
		// to that location.  If that fails, return to the present working 
		// directory and return false.
		//
		if(strlen($dest)>0) {
			if(!$this->cd($dest)) {
				$this->cd($pwd);
				return -1;
			}
		}
		//
		// Check to see if there is a path as part of the file name and, if so,
		// split off the file name to use it as the local file name too
		//
		if(strpos($filename,"\\")>-1) {
			$parts = explode("\\",$filename);
			$localname = array_pop($parts);
			unset($parts);
		} elseif(strpos($filename,"/")>-1) {
			$parts = explode("/",$filename);
			$localname = array_pop($parts);
			unset($parts);
		} else {
			$localname = $filename;
		}
		//
		// Try to put the file
		//
		$ret = false;
		if(ftp_put($this->conn, $localname, $filename, $usemode)) {
			return false;
		}
		$this->cd($pwd);
		return $ret;
	}
	
	//----------------------------------------------------------------------------
	public function mput($filespecs="*", $dest="", $mode=NULL) {
		if(!$this->lconnected) return false;
		$lpwd = $this->lpwd();
		$localpath = $lpwd;
		$pwd = $this->pwd();
		//
		// Check to see if the user wants to use a specific transfer method,
		// otherwise assume that they want to use the class' default mode
		//
		$usemode = $this->transfer_mode;
		if($mode==FTP_BINARY || $mode==FTP_ASCII) $usemode = $mode;
		//
		// Check to see if there was a destination location given.  If so, change
		// to that location.  If that fails, return to the present working 
		// directory and return false.
		//
		if(strlen($dest)>0) {
			if(!$this->cd($dest)) {
				$this->cd($pwd);
				return -1;
			}
		}
		//
		// Check to see if there is a path as part of the file name and, if so,
		// split off the file name to use it as the local file name too.
		//
		if(strpos($filespecs,"\\")>-1) {
			$parts = explode("\\",$filespecs);
			$localspecs = array_pop($parts);
			$localpath = implode("\\", $parts);
			unset($parts);
		} elseif(strpos($filespecs,"/")>-1) {
			$parts = explode("/",$filespecs);
			$localspecs = array_pop($parts);
			$localpath = implode("/", $parts);
			unset($parts);
		} else {
			$localspecs = $filespecs;
		}
		//
		// The the present working directory on the local server is not the same as
		// the desired location, try to change to that folder.  If that does not
		// work then exit with failure here (not accessable/does not exist).
		//
		if(strcmp($lpwd,$localpath)!=0) if(!$this->lcd($localpath)) return -1;
		//
		// Process each of the files
		//
		$success = 0;
		$found = 0;
		$list = glob($filespecs);
		if(empty($list)) return 0;
		foreach($list as $srcfile) {
			if(!is_dir($srcfile)) {
				$found++;
				if($this->put($srcfile, $usemode)) $success++;
			}
		}
		//
		// The the present working directory on the local server is not the same as
		// the desired location, try to return to the old directory.
		//
		if(strcmp($lpwd,$localpath)!=0) $this->lcd($lpwd);
		$this->cd($pwd);
		//
		// Determine what to return
		// * If nothing found or an error, return -1
		// * If found = success, return 1
		// * Otherwise, return 0
		//
		if($found==0) {
			return -1;
		} elseif($found==$success) {
			return 1;
		} else {
			return 0;
		}
	}

	//----------------------------------------------------------------------------
	public function putdir($srcdir, $destdir="",$mode=NULL) {
		if(!$this->lconnected) return false;
		$ret = true;
		$pwd = $this->pwd();
		//
		// Check to see if the user wants to use a specific transfer method,
		// otherwise assume that they want to use the class' default mode
		//
		$usemode = $this->transfer_mode;
		if($mode==FTP_BINARY || $mode==FTP_ASCII) $usemode = $mode;
		//
		// Check to see if there was a destdirination location given.  If so, change
		// to that location.  If that fails, return to the present working 
		// directory and return false.
		//
		if(strlen($destdir)>0) {
			if(!$this->cd($destdir)) {
				$this->cd($pwd);
				return -1;
			}
		}
		//
		// Try to put the folder
		// __________
		//
		// Load the source directory 
		//
		$local = dir($srcdir);
		$target = strlen(trim($destdir))>0 ? trim($destdir) : $pwd;
		while($file =  $local->read()) {
			//
			// Ignore . and .. (prevents a loop)
			//
			if($file != "." && $file!="..") {
				if(is_dir("$srcdir/$file")) {
					//
					// This is a directory
					//
					if(!$this->cd("$target/$file")) {
						//
						// Try to create the new folder
						//
						if(!$this->makedir("$target/$file")) {
							//
							// If the folder was not made, fail here and do
							// not try to upload this folder
							//
							$ret = false;
						} else {
							//
							// Recursively call this function to add the files
							//
							$this->putdir("$srcdir/$file", "$target/$file",
								$usemode);
						}
					} else {
						//
						// Recursively call this function to add the files
						//
						$this->putdir("$srcdir/$file", "$target/$file",
							$usemode);
					}
				} else {
					//
					// Try to upload the file to the server
					//
					if(!$this->put("$srcdir/$file", "$target", $usemode)) {
						$ret = false;
					}
				}
			}
		}
		$local->close();
		$this->cd($pwd);
		return $ret;
	}

	//----------------------------------------------------------------------------
	public function del($file) {
		if(!$this->lconnected) return false;
		if(strpos($file,"*")>-1 || strpos($file,"?")>-1) {
			//
			// Name has wildcards, so delete multiple files
			//
			$pwd = $this->pwd();
			$remotepath = $pwd;
			//
			// Check to see if there is a path as part of the file specs and, if so,
			// split off the filespecs and the folder path
			//
			if(strpos($file,"\\")>-1) {
				$parts = explode("\\",$file);
				$localspecs = array_pop($parts);
				$remotepath = implode("\\",$parts);
				unset($parts);
			} elseif(strpos($file,"/")>-1) {
				$parts = explode("/",$file);
				$localspecs = array_pop($parts);
				$remotepath = implode("/",$parts);
				unset($parts);
			} else {
				$localspecs = $file;
			}
			//
			// Get a list of matching files
			//
			$this->cd($remotepath);
			$list = $this->dirdetailsfilter($localspecs);
			$ret = true;
			foreach($list as $fil) {
				if(!$fil['dir']) {
					if(!$this->del($fil['name'])) {
						$ret = false;
					}
				}
			}
			$this->cd($pwd);
			return $ret;
		} else {
			//
			// Just removing one file
			//
			return ftp_delete($this->conn, $file);
		}
	}

	//----------------------------------------------------------------------------
	public function deldir($dir) {
		if(!$this->lconnected) return false;
		if(strlen(trim($dir))<1) return false;
		$pwd = $this->pwd();
		//
		// Make sure the folder exists
		//
		$ret = true;
		$dir = str_replace("\\","/",$dir);
		if(substr($dir,0,1)!="/") $dir = "$pwd/$dir";
		if(!$this->existsdir($dir)) return false;
		if(!(@ftp_rmdir($this->conn, $dir) || @ftp_delete($this->conn, $dir))) {
			//
			// If this fails, then the folder has files in it still
			//
			$list = @ftp_nlist($this->conn, $dir);
			//
			// Call this function again for each of the entries within this folder
			//
			foreach($list as $name) {
				if($name !="." && $name!="..") {
					if(!$this->deldir($name)) $ret = false;
				}
			}
			//
			// Try removing this folder again
			//
			if(!$this->deldir($dir)) $ret = false;
		}
		if(!$this->cd($pwd)) $this->cd("/");
		return $ret;
	}

	//----------------------------------------------------------------------------
	public function exists($path) {
		//
		// File existance check
		//
		if(!$this->lconnected) return false;
		$list = $this->dirdetails($path);
		$ret = count($list)>0 ? true : false;
		unset($list);
		return $ret;
	}
	
	//----------------------------------------------------------------------------
	public function existsdir($path) {
		//
		// File or folder existance check
		//
		if(!$this->lconnected) return false;
		$path = str_replace("\\","/",$path);
		if($path == "/") return true;
		$parts = split("/",$path);
		$last = array_pop($parts);
		$base = implode("/", $parts);
		unset($parts);
		$list = $this->dirdetailsfilter($last, $base);
		$ret = count($list)>0 ? true : false;
		unset($list);
		return $ret;
	}

	//----------------------------------------------------------------------------
	public function movetoserver($file, $dest="", $mode=NULL) {
		if(!$this->lconnected) return false;
		//
		// Try to put the file on the host
		//
		$ret = $this->put($file,$dest,$mode);
		//
		// If the put operation was successful, delete the file
		//
		if($ret) unlink($file);
		return $ret;
	}

	//----------------------------------------------------------------------------
	public function movefromserver($file, $mode=NULL) {
		if(!$this->lconnected) return false;
		//
		// Try to get the file from the server
		//
		$ret = $this->get($file,$mode);
		//
		// If the get operation was successful, delete the file from the FTP host
		//
		if($ret) $this->del($file);
		return $ret;
	}

	//----------------------------------------------------------------------------
	public function rename($oldname, $newname) {
		if(!$this->lconnected) return false;
		//
		// Call the native rename command and return its results
		//
		return ftp_rename($this->conn, $oldname, $newname);
	}
	
	//----------------------------------------------------------------------------
	public function chmod($mode, $filename) {
		if(!$this->lconnected) return false;
		$mod = trim($mode);
		$fil = str_replace("\\","/",trim($filename));
		return ftp_site($this->conn, "chmod $mod $fil");
	}
	
	//----------------------------------------------------------------------------
	public function translatecommand($commandline) {
		$commandline = trim(str_replace("\\", "/", $commandline));
		if(strlen($commandline)<1) return false;
		//
		// Ignore comment lines
		//
		if(substr($commandline,0,1)=="#") return true;
		$commandline = $this->replacetokens($commandline);
		//
		// Process the actual FTP command
		//
		$ret = false;
		$parts = split(" ", $commandline, 2);
		echo var_dump($parts) . "\n";
		if(isset($parts[0])) {
			switch(trim($parts[0])) {
				case 'chmod':
					$list = split(" ", $parts[1], 2);
					$mod = isset($list[0]) ? trim($list[0]) : "";
					$fil = isset($list[1]) ? trim($list[1]) : "";
					if(strlen($mod)>0 && strlen($fil)>0) {
						$ret = $this->chmod($mod, $fil);
					} else {
						$ret = false;
					}
					break;
				case 'ren':
				case 'rename':
					$list = split(" ", $parts[1], 2);
					$old = isset($list[0]) ? trim($list[0]) : "";
					$new = isset($list[1]) ? trim($list[1]) : "";
					if(strlen($old)>0 && strlen($new)>0) {
						$ret = $this->rename($old, $new);
					} else {
						$ret = false;
					}
					break;
				case 'put':
					$ret = $this->put($parts[1]);
					break;
				case 'mput':
					$list = split(" ", $parts[1]);
					foreach($list as $s) {
						if($this->mput($s)) $ret = true;
					}
					break;
				case 'mget':
					$list = split(" ", $parts[1]);
					foreach($list as $s) {
						if($this->mget($s)) $ret = true;
					}
					break;
				case 'mkdir':
					if($this->conn) {
						$ret = $this->makedir($parts[1]);
					} else {
						$ret = false;
					}
					break;
				case 'mget':
					$ret = $this->mget($parts[1]);
					break;
				case 'get':
					$ret = $this->get($parts[1]);
					break;
				case 'rmdir':
					$ret = $this->deldir($parts[1]);
					break;
				case 'mdel':
				case 'mdelete':
					$list = split(" ", $parts[1]);
					foreach($list as $s) {
						if($this->del($s)) $ret = true;
					}
					break;
				case 'del':
				case 'delete':
					$ret = $this->del($parts[1]);
					break;
				case 'lcd':
					$ret = $this->lcd($parts[1]);
					break;
				case 'cd':
					$ret = $this->cd($parts[1]);
					break;
				case 'binary':
					$this->transfer_mode = FTP_BINARY;
					$ret = true;
					break;
				case 'ascii':
					$this->transfer_mode = FTP_ASCII;
					$ret = true;
					break;
				case 'close':
				case 'quit':
				case 'bye':
					$this->close();
					$ret = true;
					break;
			}
		}
		return $ret;
	}
	
	//----------------------------------------------------------------------------
	private function replacetokens($cmd) {
		$ret = $cmd;
		$ret = str_replace("%d%", date("d",strtotime("now")), $ret);
		$ret = str_replace("%D%", date("D",strtotime("now")), $ret);
		$ret = str_replace("%j%", date("j",strtotime("now")), $ret);
		$ret = str_replace("%l%", date("l",strtotime("now")), $ret);
		$ret = str_replace("%N%", date("N",strtotime("now")), $ret);
		$ret = str_replace("%S%", date("S",strtotime("now")), $ret);
		$ret = str_replace("%w%", date("w",strtotime("now")), $ret);
		$ret = str_replace("%z%", date("z",strtotime("now")), $ret);
		$ret = str_replace("%W%", date("W",strtotime("now")), $ret);
		$ret = str_replace("%F%", date("F",strtotime("now")), $ret);
		$ret = str_replace("%m%", date("m",strtotime("now")), $ret);
		$ret = str_replace("%M%", date("M",strtotime("now")), $ret);
		$ret = str_replace("%n%", date("n",strtotime("now")), $ret);
		$ret = str_replace("%t%", date("t",strtotime("now")), $ret);
		$ret = str_replace("%L%", date("L",strtotime("now")), $ret);
		$ret = str_replace("%o%", date("o",strtotime("now")), $ret);
		$ret = str_replace("%Y%", date("Y",strtotime("now")), $ret);
		$ret = str_replace("%y%", date("y",strtotime("now")), $ret);
		$ret = str_replace("%a%", date("a",strtotime("now")), $ret);
		$ret = str_replace("%A%", date("A",strtotime("now")), $ret);
		$ret = str_replace("%B%", date("B",strtotime("now")), $ret);
		$ret = str_replace("%g%", date("g",strtotime("now")), $ret);
		$ret = str_replace("%G%", date("G",strtotime("now")), $ret);
		$ret = str_replace("%h%", date("h",strtotime("now")), $ret);
		$ret = str_replace("%H%", date("H",strtotime("now")), $ret);
		$ret = str_replace("%i%", date("i",strtotime("now")), $ret);
		$ret = str_replace("%s%", date("s",strtotime("now")), $ret);
		$ret = str_replace("%u%", date("u",strtotime("now")), $ret);
		$ret = str_replace("%e%", date("e",strtotime("now")), $ret);
		$ret = str_replace("%I%", date("I",strtotime("now")), $ret);
		$ret = str_replace("%O%", date("O",strtotime("now")), $ret);
		$ret = str_replace("%P%", date("P",strtotime("now")), $ret);
		$ret = str_replace("%T%", date("T",strtotime("now")), $ret);
		$ret = str_replace("%Z%", date("Z",strtotime("now")), $ret);
		$ret = str_replace("%c%", date("c",strtotime("now")), $ret);
		$ret = str_replace("%r%", date("r",strtotime("now")), $ret);
		$ret = str_replace("%U%", date("U",strtotime("now")), $ret);
		$ret = str_replace("%LONGDATE%", date("l, F j, Y", strtotime("now")),
			$ret);
		$ret = str_replace("%SHORTDATE%", date("n/j/Y",strtotime("now")), $ret);
		$ret = str_replace("%LONGTIME%", date("g:i:s A", strtotime("now")), $ret);
		$ret = str_replace("%SHORTTIME%", date("H:i:s",strtotime("now")), $ret);
		$ret = str_replace("%DATESTAMP%", strtotime("now"), $ret);
		return $ret;
	}

}

?>