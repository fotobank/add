<?php
/*
Class that connects to a FTP server to work with files and directores.
It features:
- connect to ftp server
- change current working dir
- create new empty file
- create new dir
- change access right to object
- send SITE command
- copy file
- move and rename file or dirs
- move uploaded file from TMP into CWD
- delete file or empty directory
- write into file
*/

  define('TEMPFOLDER', '/zakaz/tmp/');
class php_ftp_class{
  var $user;
  var $pw;
  var $host;
  var $root_dir;//root ftp dir of server
  var $con_id;//descriptor on ftp connection
  var $cwd;//current working dir
  var $FTP_MODE=FTP_BINARY;// FTP_ASCII | FTP_BYNARY
  var $ERR=true;//must object display ftp errors

  //constr.
  function __construct($user="guest",$pw="guest",$host="localhost",$root=""){
    $this->host=$host;
    $this->user=$user;
    $this->pw=$pw;
    $this->root_dir=$root;
    if($this->connect()){
      $this->cwd=ftp_pwd($this->con_id);
    }
  }

  //connect to ftp server
  function connect(){
    if($this->con_id=ftp_connect($this->host)){
      if(ftp_login($this->con_id,$this->user,$this->pw))return true;
      else $this->error("User <b>&quot;".$this->user."&quot;</b> cannot login to host <b>&quot;".$this->host."&quot;</b>");
    }else $this->error("Connection with host <b>&quot;".$this->host."&quot;</b> not create!");
    return false;
  }

  //close ftp connection
  function close(){
    ftp_quit($this->con_id);
  }

  //print error messages
  function error($err_str=""){
    if($this->ERR)echo "[".$err_str."]<br>\n";
  }

  //change current working dir
  function cd($dir){
    if(!@ftp_chdir($this->con_id,$dir)){
      $this->error("Cannot view directory <b>&quot;".$this->root_dir."/".$dir."&quot;</b>!");
      return false;
    }
    $this->cwd=@ftp_pwd($this->con_id);
    return true;
  }

  //create new empty file
  function mk_file($name){
    if(file_exists($this->root_dir."/".$this->cwd."/".$name)){
      $this->error("File <b>&quot;".$this->root_dir."/".$this->cwd."/".$name."&quot;</b> already exists!");
      return false;
    }else{
      if(!$tmpfile=tempnam("/tmp","phpftptmp")){
        $this->error("Can't create temp file?");
        return false;
      }elseif(!ftp_put($this->con_id,$name,$tmpfile,$this->FTP_MODE)){
        $this->error("Can't create file <b>&quot;".$this->root_dir."/".$this->cwd."/".$name."&quot;</b>");
        unlink($tmpfile);
        return false;
      }
    }
    unlink($tmpfile);
    return true;
  }

  //create new dir
  function mk_dir($name){
    if(file_exists($this->root_dir."/".$this->cwd."/".$name)){
      $this->error("Directory <b>&quot;".$this->root_dir."/".$name."&quot;</b> already exists!");
      return false;
    }elseif(!ftp_mkdir($this->con_id,$name)){
      $this->error("Cannot create directory <b>&quot;".$this->root_dir."/".$name."&quot;");
      return false;
    }
    return true;
  }

  //change access right to object
  function set_perm($obj,$num){
    //CHMOD 444 ftp.php3
    if(!$this->site("CHMOD ".$num." ".$obj)){
      $this->error("Cannot change permitions of object <b>&quot;".$this->root_dir."/".$this->cwd."/".$obj."&quot;</b>");
      return false;
    }
    return true;
  }

  //send SITE command
  function site($cmd){
    if(!ftp_site($this->con_id, $cmd)){
      $this->error("Cannot send site command <b>&quot;".$cmd."&quot;</b>");
      return false;
    }
    return true;
  }

  //copy file
  function copy($from,$to){
    if(file_exists($this->root_dir.$to)){
      $this->error("Object <b>&quot;".$this->root_dir.$to."&quot;</b> already exists!");
      return false;
    }
    srand((double)microtime()*1000000);
    $tmpfile="/zakaz/log.jpg";
    if(!copy($this->root_dir.$from,$tmpfile)){
      $this->error("Can't create temp file?");
      return false;
    }elseif(!ftp_put($this->con_id,$to,$tmpfile,$this->FTP_MODE)){
      $this->error("File <b>&quot;".$this->root_dir.$from."&quot;</b> can not copied to <b>&quot;".$this->root_dir.$to."&quot;</b>!");
      return false;
    }
    return true;
  }




// bool ftp_copy  ( resource $ftp_stream  , string $initialpath, string $newpath, string $imagename )
	 function ftp_copy($pathftp , $pathftpimg ,$img){
		// on recupere l'image puis on la repose dans le nouveau folder
		if(ftp_get($this->con_id, TEMPFOLDER.$img, $pathftp ,FTP_BINARY)){
		  if(ftp_put($this->con_id, $pathftpimg ,TEMPFOLDER.$img , FTP_BINARY)){
			 unlink(TEMPFOLDER.$img) ;
		  } else{
			 return false;
		  }

		}else{
		  return false ;
		}
		return true ;
	 }

  //move object
  function move($from,$to){
    if(file_exists($this->root_dir."/".$to)){
      $this->error("Object <b>&quot;".$this->root_dir."/".$to."&quot;</b> already exists!");
      return false;
    }
    if(!ftp_rename($this->con_id,$from,$to)){
      $this->error("Cannot move object <b>&quot;".$this->root_dir."/".$from."&quot;</b> to <b>&quot;".$this->root_dir."/".$to."&quot;</b>");
      return false;
    }
    return true;
  }

  //rename object
  function rename($from,$to){
    if(file_exists($this->root_dir."/".$this->cwd."/".$to)){
      $this->error("Object <b>&quot;".$this->root_dir."/".$this->cwd."/".$to."&quot;</b> already exists!");
      return false;
    }elseif(!ftp_rename($this->con_id,$from,$to)){
      $this->error("Cannot rename object <b>&quot;".$this->root_dir."/".$this->cwd."/".$to."&quot;</b>");
      return false;
    }
    return true;
  }

  //kill file or empty directory
  function del($obj){
    if(is_dir($this->root_dir."/".$this->cwd."/".$obj)){
      if(!ftp_rmdir($this->con_id, $obj)){
        $this->error("Cannot delete directory <b>&quot;".$this->root_dir."/".$this->cwd."/".$obj."&quot;</b>");
        return false;
      }
    }elseif(is_file($this->root_dir."/".$this->cwd."/".$obj)){
      if(!ftp_delete($this->con_id, $obj)){
        $this->error("Cannot delete file <b>&quot;".$this->root_dir."/".$this->cwd."/".$obj."&quot;</b>");
        return false;
      }
    }else{
      $this->error("Removing object <b>&quot;".$this->root_dir."/".$this->cwd."/".$obj."&quot;</b> canceled!");
      return false;
    }
    return true;
  }

  //write into file
  function write($dest,$FILEDATA){
    if(!WIN){
      $old_perm=$this->get_perm($dest,'i');
      $this->set_perm($dest,"666");
    }
    $fd=fopen($this->root_dir."/".$this->cwd."/".$dest,"w");
    if(!fwrite($fd,$FILEDATA)){
      $this->error("Cannot write file <b>&quot;".$this->root_dir."/".$this->cwd."/".$dest."&quot;</b>");
      fclose($fd);
      if(!WIN)$this->set_perm($dest,"644");
      return false;
    }
    fclose($fd);
    if(!WIN)$this->set_perm($dest,"644");
    return true;
  }

  //move uploaded file from TMP into CWD
  function move_uploaded_file($file_to_move,$file_name){
    srand((double)microtime()*1000000);

    $tmpfile="zakaz/".rand();
    if(!copy($file_to_move,$tmpfile)){
      $this->error("Can't create temp file?");
      unlink($file_to_move);
      return false;
    }elseif(!ftp_put($this->con_id,$this->cwd."/".$file_name,$tmpfile,$this->FTP_MODE)){
      $this->error("Can't write file <b>&quot;".$this->root_dir."/".$this->cwd."/".$file_name."&quot;</b>");
      unlink($file_to_move);
      unlink($tmpfile);
      return false;
    }
    unlink($file_to_move);
    unlink($tmpfile);
    return true;
  }

  //возвращение право доступа объекта, в различных форматах
  function get_perm($obj,$type='i'){
    $num=fileperms($obj);
	 $ret = '';
	 $str = '';
    $s=array(07=>'rwx',06=>'rw-',05=>'r-x',04=>'r--',03=>'-wx',02=>'-w-',01=>'--x',00=>'---');
    $i=array(07=>'7',06=>'6',05=>'5',04=>'4',03=>'3',02=>'2',01=>'1',00=>'0');
    $b=array(
      07=>array(1,1,1),
      06=>array(1,1,0),
      05=>array(1,0,1),
      04=>array(1,0,0),
      03=>array(0,1,1),
      02=>array(0,1,0),
      01=>array(0,0,1),
      00=>array(0,0,0)
    );
    switch($type){
      case 'b':
        $ret['o']=$b[($num & 0700)>>6];
        $ret['g']=$b[($num &  070)>>3];
        $ret['a']=$b[($num &   07)   ];
        break;
      case 's':
        if($num & 0x1000)     $ret ='p';//FIFO pipe
        elseif($num & 0x2000) $ret.='c';//Character special
        elseif($num & 0x4000) $ret.='d';//Directory
        elseif($num & 0x6000) $ret.='b';//Block special
        elseif($num & 0x8000) $ret.='-';//Regular
        elseif($num & 0xA000) $ret.='l';//Symbolic Link
        elseif($num & 0xC000) $ret.='s';//Socket
        else $str.='?'; //UNKNOWN
        $ret.=$s[($num & 0700)>>6];
        $ret.=$s[($num &  070)>>3];
        $ret.=$s[($num &   07)   ];
        break;
      case 'i':
        $ret =$i[($num & 0700)>>6];
        $ret.=$i[($num &  070)>>3];
        $ret.=$i[($num &   07)   ];
        break;
    }
    return $ret;
  }

  //print dir file list
  function dir_list(){
    //ftp_nlist - Возвращает список файлов в заданной директории.
    //ftp_rawlist - Возвращает подробный список файлов в данной директории.
    ?><table border=1 cellpadding=3 cellspacing=0><tr><td>Directories</td><td>Files</td></tr><?
	  $contents=ftp_nlist($this->con_id, $this->cwd);
    $d_i=0;
    $f_i=0;
    sort($contents);
	 $nlist_dirs = null;
	 $nlist_files = null;
	 $nlist_filesize[$f_i] = null;
    for($i=0;$i<count($contents);$i++){
      $file_size=ftp_size($this->con_id,$contents[$i]);
      if(is_dir($this->root_dir.$contents[$i])){
        $nlist_dirs[$d_i]=$contents[$i];
        $d_i++;
      }else{
        $nlist_files[$f_i]=$contents[$i];
        $nlist_filesize[$f_i]=$file_size;
        $f_i++;
      }
    }
    ?><tr><td><pre><?
    for($i=0;$i<count($nlist_dirs);$i++)echo $nlist_dirs[$i]."<br>";
    ?></td><td><pre><?
    for($i=0;$i<count($nlist_files);$i++)echo $nlist_files[$i]." ".(int)@$nlist_filesize[$f_i]."<br>";
    ?></td></tr></table><?
  }
}//end class




/*$FTP_HOST="localhost";
$FTP_USER="";
$FTP_PW="";
$FTP_ROOT_DIR="";

$obj = new php_ftp_class($FTP_USER,$FTP_PW,$FTP_HOST,$FTP_ROOT_DIR);
$obj->dir_list();*/

?>