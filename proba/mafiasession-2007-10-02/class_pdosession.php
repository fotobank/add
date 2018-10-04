<?php
/**
* This class can be used to authenticate Web users securely.
* It creates a key encoded with SHA1 based on the IP address and the current time when an user accesses the login page.
* The key is used to generate a salt value that is used to encrypt the password that the user enters in the login form.
* On the server side the class uses the same salt to verify whether the password entered by the user matches the password stored in a database.
* If the authentication is successful, the class starts an authenticated user session.
* The login keys, user and session information is stored in a database. 
* Currently the class supports now suport all pdo drivers.
* @author Marcelo Soares da Costa
* @email phpmafia at yahoo dot com dot br
* @copyright Marcelo Soares da Costa © 2007.
* @license FreeBSD http://www.freebsd.org/copyright/freebsd-license.html
* @version 2,0
* @access public
* @package pdo_extension
* @subpackage pdosession 
* @changelog suport a pdo extension class, 
* http://www.phpclasses.org/browse/package/4136.html
* package for mysql and pgsql not PDO driver
* http://www.phpclasses.org/browse/package/3705.html 
* @data 2007-10-01
* tanks for Manuel Lemos for english description
*/
require_once ("class_pdo_extension.php");

class pdosession extends PDO_EXT
{
/**
*
* seta o tempo limite para login em microsegundos
* returnt microtime for login
* @access private
* @input microtime {string}
* @return 
*
*/
private function __timelogin($microtime)
{
    unset($this->timelogin);
    $this->timelogin = $microtime;
}
/**
*
* seta o tempo limite para a verificacao de sessao em segundos
* return time session limit
* @access private
* @input time {string}
* @return 
*
*/
private function __timelimit($lifetime)
{
    unset($this->timelimit);
    $this->timelimit = $lifetime;
}
/**
*
* insere no banco de dados as informacoes para criar uma chave de autenticacao
* insert public key form login
* retorna o id inserido
* @access private
* @input 
* @return insertid
*
*/
private function insertkeydata()
{
$this-> __timelogin(TIMELOGIN);
$this->keytime = str_replace(".",'',microtime(true));
$this->REMOTE_ADDR=str_replace(".",'',$_SERVER["REMOTE_ADDR"]);
if($this->REMOTE_ADDR=="::1")
{
$this->REMOTE_ADDR=127001;
}

if($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]==str_replace("http://",'',LOGINURL))
{
session_unset();
session_destroy();

$this->REQUEST_URI=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

$this->clientedata=$this->REMOTE_ADDR.$this->REQUEST_URI.$this->keytime;

$SQL_CLEAN="DELETE FROM _session WHERE keytime<=".($this->keytime-$this->timelogin);
$SQL_CLEAN.=" AND keepalive=0";

$this->setsql($SQL_CLEAN);

$SQL_KEY="INSERT INTO _session (REMOTE_ADDR,REQUEST_URI,keytime,keepalive) VALUES ('".$this->REMOTE_ADDR."','".$this->REQUEST_URI."',".$this->keytime.",0)";

$this->idkey= $this->setsql($SQL_KEY);

return $this->idkey;
}else{
header("Location: ".KICKURL."");exit; /* Redirect browser */
}
}
/**
*
* cria a chave sha256 de autenticação a partir dos dados gravados no bd
* create a sha256 key server 
* @access private
* @input id session
* @return bolean
*
*/
private function createserverkey($id)
{
$SQL_KEY="SELECT * FROM _session WHERE id_session=".$id;
$this->setsql($SQL_KEY);
//var_dump($this->getlinearray());die();
extract($this->getlinearray(),EXTR_OVERWRITE);
$this->serverkey=hash('sha256',$remote_addr.$request_uri.$keytime);
//echo $remote_addr."=>".$request_uri."=>".$keytime;die();
return true;
}
/**
*
* Ataualiza a tabela quando a chave é validada
* update time session for valid key
* retorna o id inserido
* @access privado
* @input id session
* @return bolean
*
*/
private function validkey($id)
{
$this->timecurrent=time();
$SQL="UPDATE _session set keepalive=".$this->timecurrent." WHERE id_session=".$id ;
$this->setsql($SQL);
return true;
}
/**
*
* Verifica se a chave de autenticação eh identica 
* check if key server and client key is valid, identical
* @access private
* @input id ,  key
* @return bolean
*
*/
private function checkserverkey($id,$keyserver)
{
//unset($this->keydb);
$SQL_KEY="SELECT * FROM _session WHERE id_session=".$id;//." ".$param;

$this->setsql($SQL_KEY);
extract($this->getlinearray(),EXTR_OVERWRITE);

  $this->keydb=hash('sha256',$remote_addr.$request_uri.$keytime);
    
    if($keyserver===$this->keydb)
    {
    return true;
    }else{
    return false;
    }
}
/**
*
* Retorna uma nova chave de autenticacao
* return public form key for login
* @access public
* @input 
* @return array keys
*
*/
public function newserverkey()
{
$this->createserverkey($this->insertkeydata());
return array("idkey"=>$this->idkey,"serverkey"=>$this->serverkey);
}
/**
*
* Registra no banco de dados a chave de keepaive
* register key for keepalive
* @access private
* @input 
* @return array keys
*
*/
private function registerkey($id,$keyserver)
{
  if($this->checkserverkey($id,$keyserver)==true)
  {
  return $this->validkey($id);
  }else{
  return false;
  }
}
/**
*
* Verifica por hmac se a senha eh valida
* check hmac keys is identical
* @access private
* @input user,login,passwd md5, passwd sha1
* @return id user
*
*/
private function checkpasswd($user,$salt,$passwdmd5,$passwdsha1)
{
$SQL_PASS="SELECT * FROM login WHERE login='".$user."'";
//echo $SQL_PASS;
$this->setsql($SQL_PASS);
  extract($this->getlinearray(),EXTR_OVERWRITE);
  //aplico hmac para verificar se as senhas correpondem
  $hashmd5=hash_hmac('md5',$salt,$senhamd5);
  // echo "MD5=>".$passwdmd5."===".$hashmd5;
  $hashsha1=hash_hmac('sha1',$salt,$senhasha1);
  // echo "SHA1=>".$passwdsha1."===".$hashsha1;
  // die();
  if(($passwdmd5===$hashmd5) AND ($passwdsha1===$hashsha1))
  {
  $this->iduser=$id_login;
  return $this->iduser;
  }else{
  return false;
  }
  
}
/**
*
* Registra em sessao os dados para verificacao
* register session for valid hmac keys
* @access public
* @input $_POST form
* @return redirect url
*
*/
public function registersession()
{

if(is_array($_POST))
  {

  if($this->registerkey($_POST['id'],$_POST['salt'])==true)
    {

    list($senhamd5,$senhasha1)=explode("|",base64_decode($_POST['password']));
    if($this->checkpasswd(base64_decode($_POST['username']),$_POST['salt'],$senhamd5,$senhasha1)==true)
      {  
      //$this->keysession=1;
      $_SESSION['idkey']=$_POST['id'];
      $_SESSION['keylogin']=$_POST['salt'];
      $_SESSION['iduser']=$this->iduser;
      $_SESSION['time']=$this->timecurrent;
      $_SESSION['keysession']=hash_hmac('sha256',$_SERVER["REMOTE_ADDR"].$_POST['username'].$this->timecurrent,SESSIONKEY);
      $_SESSION['remote_addr']=$_SERVER["REMOTE_ADDR"];
      $_SESSION['browser']=$_SERVER["HTTP_USER_AGENT"];
      //echo LOGINOKURL; exit;
      header("Location: ".LOGINOKURL."");exit; /* Redirect browser */
      }else{
      header("Location: ".LOGINURL."");exit; /* Redirect browser */
      }
    }
  }
}
/**
*
* Verifica se a sessão corrente ainda eh valida
* Atualiza a chave da sessao ou destroi a sessao
* Check if keys in session are valid
* @access public
* @input 
* @return redirect url , bolean
*
*/
public function check_Session()
{

if(($_SESSION['remote_addr']===$_SERVER["REMOTE_ADDR"]) AND ($_SESSION['browser']===$_SERVER["HTTP_USER_AGENT"]))
{

   if(time()>($_SESSION['time']+(TIMESESSION*60)+1))
   {
   header("Location: ".LOGINURL."");exit; /* Redirect browser */
   }

     if(time()>$_SESSION['time']+TIMEKEY)
     {
       if($this->keepalive()==false)
       {
       header("Location: ".LOGINURL."");exit; /* Redirect browser */
       }
     
     }else{
   //echo "dentro do tempo de validade da sessão<br/>";
     return true;
     }
    
}else{
header("Location: ".KICKURL.""); /* Redirect browser */
}

}
/**
*
* Verifica se a chave da sessão eh valida e atualiza
* update key in session on keealive  
* @access private
* @input 
* @return  bolean
*
*/
private function keepalive()
{
$keepalive=false;
//$timecurrent=time();
$SQL_PASS="SELECT login FROM login WHERE id_login='".$_SESSION['iduser']."'";
  $this->setsql($SQL_PASS);
    $login=$this->getrow();
    if($_SESSION['keysession']===hash_hmac('sha256',$_SERVER["REMOTE_ADDR"].base64_encode($login).$_SESSION['time'],SESSIONKEY))
     {
     if($this->checkserverkey($_SESSION['idkey'],$_SESSION['keylogin'])==true)
        {
          if($this->validkey($_SESSION['idkey'])==true)
            {
            $_SESSION['time']=$this->timecurrent;
            $_SESSION['keysession']=hash_hmac('sha256',$_SERVER["REMOTE_ADDR"].base64_encode($login).$this->timecurrent,SESSIONKEY);
            $keepalive=true;
            }
        }
     }
return $keepalive;
}
# fim da classe
}