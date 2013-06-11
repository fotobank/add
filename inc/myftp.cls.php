<?php

/*
 * class name : myFtpWriter
 * developed by : Md. Shahadat Hossain Khan Razon
 * version : 2.00
 * date : Aug 23, 2006
 * dependency : none
 * email : razonklnbd@yahoo.com
 * developed for: personal use
 * required php version: 5+
 */

/*
version 1.0
file name: ftp.cls.php
version 2.0
file name: myftp.cls.php

version 2.0 made a lot of change comparing to version 1.0 thats why i change the name of the file....
either you need to use 2.0 or 1.0... please don't use this two version simuntaneously
*/

/*
 * change log of this version
 *
 * 20120315: add ftp_nlist cache machenism. so that user will control cache nlist. by default it will not cache nlist output.
 * 20120315: fix a bug of is_file_exist method
 *
 */


class myFtpWriter{

	var $ftpInfo;
	var $logtext=array();
	var $ftpconnid;

	#ftp_nlist cache machenism
	var $ftp_nlist_cache;
	var $clear_ftp_nlist_cache;

  var $ERR=true;//must object display ftp errors

/*
$this->ftpInfo['serverroot']
this variable will hold the server root of ftp server
suppose you ftp user's root is '/home/mywebsite/public_html/'
and your server root may be '/home/mywebsite/'
when you login into your server through ftp that will show you as '/'
so you must put '/home/mywebsite/public_html/' into this variable...
this varable should hold absoulate path related of OS

$this->ftpInfo['ftproot']
this varable will hold current working directory within a connection
suppose if we are uploading a file into '/home/mywebsite/public_html/uploaddir/'
then this variable will hold '/uploaddir/' with trailing directory saperator
please note it will hold absoulate path of ftp directory
in our example our ftp server show path as '/' when connected
so this is a virtual path related of OS
for that reason this variable will hold '/uploaddir/'

$this->ftpInfo['ftpcurrentpath']
this variable will hold directory path related with ftproot w/o leading directory saperator
in our case this variable will hold 'uploaddir/'

*/

	function __construct($p_settings_arr=NULL){
		$this->clear_ftp_nlist_cache=true;
		$this->ftpInfo['serverroot']='';
		$this->ftpInfo['ftproot']='';
		$this->ftpInfo['ftpcurrentpath']='';
		$this->ftpInfo['ftpserver']='';
		$this->ftpInfo['ftpusername']='';
		$this->ftpInfo['ftpuserpassword']='';
		$this->ftpInfo['ftptempdir']=sys_get_temp_dir();
		$this->ftpInfo['ftpinitialtimeout']=100;
		$this->ftpInfo['ftptimeout']=90;
		$this->ftpInfo['ftpport']=21;
		if(isset($p_settings_arr) && is_array($p_settings_arr)){
			foreach($p_settings_arr as $key=>$val) $this->ftpInfo[$key]=$val;
		}
		if(isset($p_settings_arr) && !is_array($p_settings_arr) && strlen(trim($p_settings_arr))>0){
			// Split FTP URI into:
			// $match[0] = ftp://username:password@sld.domain.tld/path1/path2/
			// $match[1] = ftp://
			// $match[2] = username
			// $match[3] = password
			// $match[4] = sld.domain.tld
			// $match[5] = /path1/path2/
			preg_match("/ftp:\/\/(.*?):(.*?)@(.*?)(\/.*)/i", trim($p_settings_arr), $match);
			$this->ftpInfo['ftpusername']=$match[2];
			$this->ftpInfo['ftpuserpassword']=$match[3];
			if(strlen(substr($match[5], 1))>0) $this->ftpInfo['ftpcurrentpath']=substr($match[5], 1);
			$this->ftpInfo['ftpserver']=$match[4];
		}
		$this->ftpInfo['_serverroot']=$this->ftpInfo['serverroot'];
		$this->ftpInfo['_ftproot']=$this->ftpInfo['ftproot'];
		if(strlen(trim($this->ftpInfo['ftpserver']))>0 && strlen($this->ftpInfo['ftpport'])>0 &&
			strlen(trim($this->ftpInfo['ftpusername']))>0 && 
			strlen(trim($this->ftpInfo['ftpuserpassword']))>0
			) $con=$this->conServer();
		return $con;
	}

	function setFtpPath($p_path){
		$this->ftpInfo['ftproot']=$this->ftpInfo['_ftproot'].$p_path;
		$this->ftpInfo['serverroot']=$this->ftpInfo['_serverroot'].$p_path;
		$this->ftpInfo['ftpcurrentpath']=$p_path;
	}

	protected function conServer(){
		$rtrn=true;
		if(!isset($this->ftpconnid) || !$this->ftpconnid){
			// set up basic connection
			$this->ftpconnid=@ftp_connect($this->ftpInfo['ftpserver'], $this->ftpInfo['ftpport'], $this->ftpInfo['ftpinitialtimeout']);
			// login with username and password
			$login_result=@ftp_login($this->ftpconnid, $this->ftpInfo['ftpusername'], $this->ftpInfo['ftpuserpassword']);
			if(!$this->ftpconnid || !$login_result){
				$this->logtext[]='FTP connection has failed!';
				$this->logtext[]='Attempted to connect to '.$this->ftpInfo['ftpserver'].' for user '.$this->ftpInfo['ftpusername'].'';
				unset($this->ftpconnid);
				$rtrn=false;
			}else{
				$this->logtext[]='Connected to '.$this->ftpInfo['ftpserver'].', for user '.$this->ftpInfo['ftpusername'].'';
				ftp_set_option($this->ftpconnid, FTP_TIMEOUT_SEC, $this->ftpInfo['ftptimeout']);
			}
		}
		return $rtrn;
	}

	function disconServer(){
		if(isset($this->ftpconnid) && $this->ftpconnid){
			ftp_quit($this->ftpconnid);
			unset($this->ftpconnid);
		}
		return true;
	}

	//function defination
	public function write($pFileContent, $pFileFTP_Path, $pOverwrite=false, $pTmpFlNm=''){
	
		$filename=$this->ftpInfo['ftptempdir'].$pTmpFlNm;
		if(strlen($pTmpFlNm)<=0){
			$filename=tempnam($this->ftpInfo['ftptempdir'], 'ftp');
			$this->logtext[]="Empty temporary file path parameter.<br>New temporary file name and path - $filename";
		}
	
		$fReadOk=true;
		//check target file exist and need to overwrite?
		$fIsFileExists=$this->is_file_exists($pFileFTP_Path);
		if(false==$pOverwrite && true==$fIsFileExists){
			$this->logtext[]="Target temporary file exist. ($pFileFTP_Path)<br>Overwrite flag setted as false.";
			$fReadOk=false;
		}

		if(true==$fReadOk){
			//delete if temporary source file exist
			if(file_exists($filename)) @unlink($filename);
			// We're opening $filename in append mode.
			// The file pointer is at the bottom of the file hence 
			// that's where $content will go when we fwrite() it.
			if(!$handle=fopen($filename, 'wb')){
				$this->logtext[]="Cannot open temporary file ($filename) into read/write mode...";
				$fReadOk=false;
			}else{
				// Write $somecontent to our opened file.
				if(fwrite($handle, $pFileContent, strlen($pFileContent))===false){
					$this->logtext[]="Temporary file ($filename) open with write mode but fail to write...";
					$fReadOk=false;
				}
				if($fReadOk===true){
					fclose($handle);
					$this->logtext[]="Success, data written into temporary file ($filename)..."; // <textarea>$fc</textarea>
					$fReadOk=$this->upload($filename, $pFileFTP_Path, $pOverwrite);
				}
			}
		}


		//delete temporary file
		$this->delete($filename,false);
//		@unlink($filename);
		
		//return the result
		return $fReadOk;
	}

//print error messages
	 function error($err_str=""){
		if($this->ERR)
		  {
		  echo $err_str."<br><pre>";
		  print_r($this->logtext);
		  echo "</pre>";
		  }
	 }


	function is_dir_exists($p_dir) {
		$rtrn=true;
		if(!isset($this->ftpconnid) || false===$this->ftpconnid) $rtrn=$this->conServer();
		if(true==$rtrn && strlen($p_dir)>0){
			$cur_dir=ftp_pwd($this->ftpconnid);
			if(@ftp_chdir($this->ftpconnid, $this->ftpInfo['ftproot'].$p_dir)){
				ftp_chdir($this->ftpconnid, $cur_dir);
				$rtrn=true;
			}else $rtrn=false;
//			echo('DIR: '.$cur_dir.$this->ftpInfo['ftproot'].$p_dir);
		}else $rtrn=false;
		return $rtrn;
	}

	public function is_file_exists($p_target_file){
		$rtrn=true;
		if(!isset($this->ftpconnid) || false===$this->ftpconnid) $rtrn=$this->conServer();
		if(true==$rtrn && strlen($p_target_file)>0){
			$flnm=$p_target_file;
			$dirnm=$this->ftpInfo['ftproot'];
			$pos=strrpos($flnm, '/');
			if(false!==$pos){
				if(($pos+1)!=strlen($flnm)){
					$flnm=substr($p_target_file, $pos+1);
					$dirnmX=substr($p_target_file, 0, $pos).'/';
					$dirnm=(strpos($flnm, '/')===0?$dirnmX:$this->ftpInfo['ftproot'].$dirnmX);
				}else $rtrn=false;
			}
			if(true==$rtrn){
				$rtrn=false;
				$md5dirnm=md5($dirnm);
				if(!isset($this->ftp_nlist_cache[$md5dirnm]) || $this->clear_ftp_nlist_cache==true) $this->ftp_nlist_cache[$md5dirnm]=@ftp_nlist($this->ftpconnid, $dirnm);
				$contents=$this->ftp_nlist_cache[$md5dirnm];
				#echo('list: <pre>'.print_r($contents,true).'</pre>');
				foreach($contents as $fl){
					if(false!==strpos($fl, '/')){
						$flX=(0!==strpos($fl, '/')?'/':'').$fl;
						if($flX==$dirnm.$flnm) $rtrn=true;
					}else{
						# we found only file name in directory listing without leading directory
						if($fl==$flnm) $rtrn=true;
					}
					if(true==$rtrn) break;
				}
			}
		}else $rtrn=false;
		return $rtrn;
	}

/*
 * Source Resource = File resource open with fopen or other media
 */
	public function write_resource($pSourceResource, $pTargetFile, $pOverwrite=false,$pSourceFile){
		$rtrn=true;
		if(!isset($this->ftpconnid) || false===$this->ftpconnid) $rtrn=$this->conServer();
		if(true==$rtrn){
			$fileexist=$this->is_file_exists($this->ftpInfo['ftproot'].$pTargetFile);
			//check target file exist and need to overwrite?
			if(false==$pOverwrite && true==$fileexist){
				$this->logtext[]="Target File Exist. ($pTargetFile)<br>Overwrite flag setted as false.";
				$rtrn=false;
			}
		}else $this->logtext[]="Can't open connection. Please set all the paramter properly...";
		if(true==$rtrn){
			$rtrn=false;
			if(is_resource($pSourceResource)){
				$rtrn=true;
				$upload=@ftp_fput($this->ftpconnid, $this->ftpInfo['ftproot'].$pTargetFile, $pSourceResource, FTP_BINARY);
				if(!$upload){
					$this->logtext[]='FTP upload has failed!';
					$this->logtext[]='Destination File Path: '.$this->ftpInfo['ftproot'].$pTargetFile;
					$this->logtext[]='Source as resource';
					$this->logtext[]="Source Resource Validity Status: ".$pSourceFile." - OK";
					$this->logtext[]='Current Ftp Directory: '.@ftp_pwd($this->ftpconnid);
					$rtrn=false;
				}else $this->logtext[]="Resource uploaded to ".$this->ftpInfo['ftpserver']." as $pTargetFile";
			}else $this->logtext[]="Invalid source resource...";
		}
		return $rtrn;
	}


/*
 * Source File = Absoulate file path related of OS
 */
	public function upload($pSourceFile, $pTargetFile, $pOverwrite=false){
		$fReadOk=true;
	   $fileexist=$this->is_file_exists($this->ftpInfo['ftproot'].$pTargetFile);
		if(true==$fReadOk && (!isset($this->ftpconnid) || false===$this->ftpconnid)) $fReadOk=$this->conServer();
		if(strlen($pSourceFile)<=0 || empty($pSourceFile)){
			$fReadOk=false;
			$this->logtext[]="Empty source.. request terminated...";
		}
		if(true==$fReadOk){
			if(true==$fileexist) $this->logtext[]="Target File Exist. ($pTargetFile)";
			//check target file exist and need to overwrite?
			if(false==$pOverwrite && true==$fileexist){
				$this->logtext[]="Overwrite flag setted as false.";
				$fReadOk=false;
			}
		}
		if(true==$fReadOk && $this->ftpconnid){
			if(true==$pOverwrite && true==$fileexist){
				if(!$this->delete($pTargetFile, NULL, true)){
					$this->logtext[]="Overwrite flag setted as true. Fail to delete target file. FTP write aborted!!!";
					$fReadOk=false;
				}else $this->logtext[]="Overwrite flag setted as true. Target file deleted!";
			}
			if(true==$fReadOk){
//				print_r($this->ftpInfo);exit();

				if($fp=fopen($pSourceFile, 'r')){
					$upload=@ftp_fput($this->ftpconnid, $this->ftpInfo['ftproot'].$pTargetFile, $fp, FTP_BINARY);
					fclose($fp);
					// check upload status
					if(!$upload){
						$this->logtext[]='FTP upload has failed!';
						$this->logtext[]='Destination File Path: '.$this->ftpInfo['ftproot'].$pTargetFile;
						$this->logtext[]='Source File Name: '.$pSourceFile;
						$this->logtext[]="Source File Existance Status: $pSourceFile - ".(is_file($pSourceFile)?'Exist':'Not Found');
						$this->logtext[]='Current Ftp Directory: '.ftp_pwd($this->ftpconnid);
						$fReadOk=false;
					}else $this->logtext[]="Uploaded $pSourceFile to ".$this->ftpInfo['ftpserver']." as $pTargetFile";
				}else $this->logtext[]="Uploaded Fail! Can't open $pSourceFile into read mode...";
			}
		}
	
		//return the result
		return $fReadOk;
	}





/*
 * Source File = file path related on ftp connection
 * Target File = file path related on ftp connection
 */
	public function move($pSourceFile, $pTargetFile, $pOverWrite=false){
		return $this->move_copy(true, $pSourceFile, $pTargetFile, $pOverWrite);
	}
	public function copy($pSourceFile, $pTargetFile, $pOverWrite=false){
		return $this->move_copy(false, $pSourceFile, $pTargetFile, $pOverWrite);
	}

	 private function move_copy($pCmdMove, $pSourceFile, $pTargetFile, $pOverWrite=false){
		$fileexist=file_exists($pTargetFile);
		//check target file exist and need to overwrite?
		if(false==$pOverWrite && true==$fileexist){
		  $this->logtext[]="Target File Exist. ($pTargetFile)<br>Overwrite flag setted as false.";
		  $fReadOk=false;
		}else $fReadOk=true;

		if(true==$fReadOk && (!isset($this->ftpconnid) || false===$this->ftpconnid)) $fReadOk=$this->conServer();
		if(true==$fReadOk && $this->ftpconnid){
		  if(true==$pOverWrite && true==$fileexist) $fReadOk=$this->delete($pTargetFile);
		  if(true==$fReadOk){
			 $upload=ftp_put($this->ftpconnid,$pTargetFile,$pSourceFile, FTP_BINARY);
			 // check upload status
			 if(!$upload){
				$this->logtext[]='FTP copy has failed!';
				$this->logtext[]='Destination File Path: '.$pTargetFile;
				$this->logtext[]='Source File Name: '.$pSourceFile;
				$this->logtext[]="Source File Existance Status: $pSourceFile - ".(is_file($pSourceFile)?'Exist':'Not Found');
				$this->logtext[]='Current Ftp Directory: '.ftp_pwd($this->ftpconnid);
				$fReadOk=false;
			 }else{
				if(true===$pCmdMove){
				  $fReadOk=$this->delete($pSourceFile);
				  if($fReadOk) $this->logtext[]='FTP move success!';
				  else $this->logtext[]='FTP delete failed! can\'t move - ['.$pSourceFile.'] but copy ok...';
				}else $this->logtext[]='File copy done! Source: '.$pSourceFile.', Target: '.$pTargetFile;
			 }
		  }
		}
		//return the result
		return $fReadOk;
	 }

	public function myChMod($pTargetFile, $p_mode){
		$fReadOk=$this->conServer();
		if(true==$fReadOk){
			if(ftp_chmod($this->ftpconnid, $p_mode, $this->ftpInfo['ftproot'].$pTargetFile)!==false) $this->logtext[]="$pTargetFile chmoded successfully to $p_mode";
			else $this->logtext[]="could not chmod $pTargetFile";
		}
		return $fReadOk;
	}

  #################################################
  #												#
  #				GET THE FILE TO SERVER 			#
  #												#
  #################################################
  private function download($to, $from){
	 if($this->conServer())
		return ftp_get($this->ftpconnid, $to, $from, FTP_BINARY);
	 else
		$this->logtext[]="You must be connect.";
		throw new Exception("You must be connect.");
  }

  #################################################
  #												#
  #					DELETE FOLDER				#
  #												#
  #################################################
  public function delFolder($folder){
	 if($this->conServer())
		return ftp_rmdir($this->ftpconnid, $this->ftpInfo['ftpcurrentpath'].$folder);
	 else
		$this->logtext[]="You must be connect.";
		throw new Exception("You must be connect.");
  }


/*
@File Name
1. Absoulate file path related on your OS for normal delete
2. Relative path for ftp delete (related on $this->ftpInfo['ftproot'])
 */
	public function delete($pFileName, $pFtpDel=true, $pTryOnlyFtpDelete=false){
		$fDeleteOk=false;
		if(!isset($pFtpDel)) $pFtpDel=true;
		if(!isset($pTryOnlyFtpDelete)) $pTryOnlyFtpDelete=false;
		if(true==$pFtpDel){
			// check connection
			if($this->conServer()){
				$this->logtext[]="Try to delete with ftp connection...";
				if(@ftp_delete($this->ftpconnid, $this->ftpInfo['ftproot'].$pFileName)!==false){
					$this->logtext[]="File found and deleted successfully";
					$fDeleteOk=true;
				}else{
					$this->logtext[]="Can't delete through ftp connection...";
					if(false===$pTryOnlyFtpDelete) $fDeleteOk=$this->delete($this->ftpInfo['serverroot'].$pFileName,false);
				}
			}
		}else{
			$this->logtext[]="Try to delete with php file system functions...";
			if(file_exists($pFileName)){
				@unlink($pFileName);
				$fDeleteOk=!file_exists($pFileName);
				$this->logtext[]='File found '.(true==$fDeleteOk?'and delete success':'but delete fail').'!';
			}else $this->logtext[]="File not found to delete!";
		}
		//return the result
		return $fDeleteOk;
	}


/* creating directory */
	function mkdir($p_path_name, $p_int_chmode=0700){
		$rtrn=false;
		if($this->conServer()){
			$this->logtext[]="Try to create directory...";
			if(ftp_mkdir($this->ftpconnid, $this->ftpInfo['ftproot'].$p_path_name)){
				$rtrn=true;
				$this->logtext[]='directory created - '.$this->ftpInfo['ftproot'].$p_path_name;
				if (ftp_chmod($this->ftpconnid, $p_int_chmode, $this->ftpInfo['ftproot'].$p_path_name) === false) $this->logtext[]="fail to change directory mode to $p_int_chmode";
			}else $this->logtext[]="creating directory fail!!!";
		}
		return $rtrn;
	}



/* deprecated function... will be remove from next release */
	function fileMove($pSourceFile, $pTargetFile, $pOverWrite=false){
		return $this->copy($pSourceFile, $pTargetFile, $pOverWrite);
	}
	function fileCopy($pSourceFile, $pTargetFile, $pOverWrite=false){
		return $this->move($pSourceFile, $pTargetFile, $pOverWrite);
	}





}
