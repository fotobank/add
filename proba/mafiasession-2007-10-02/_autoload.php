<?php
// http://br.php.net/manual/en/function.session-cache-limiter.php
session_cache_limiter("nocache");// nгo permite cache da sessгo em proxy ou no cliente, default em FreebSD
//http://br.php.net/manual/en/function.session-cache-expire.php
//session_cache_expire(4); //sу funciona para valores diferentes de nocache
session_start();
# configuraзгo do banco de dados
define("RELDB","MYSQL");// SUPORTA MYSQL e PGSQL
define("DATABASE","mafiasession");// Nome da sua base de dados
define("HOST","localhost");// Nome ou ip do servidor de banco de dados
define("USER","root");// usario de login do banco de dados , use root somente se seu banco de dados for local
define("PASSWORD", "minhasenha");// senha do usuario de banco de dados
define("TIMELOGIN",30000);// tempo em microsendos para que o usuario use o formulбrio de login
define("TIMEKEY",60);//tem em segundos com que as chaves da sessгo deve ser trocada
define("TIMESESSION",3);//tempo em minuto , tempo maximo de inatividade 
define("SESSIONKEY","Frase chave da minha sessгo"); // chave personalizada para compor a chave de sessгo
define("LOGINURL","http://localhost/mafiasession/login.php"); // URL para se efetuar o ligin
define("LOGINOKURL","http://localhost/mafiasession/mafiasession.php"); // URL que uma autenticaзгo com sucesso deve carregar
define("KICKURL","http://www.dpf.gov.br/"); // URL para redirecionar tentativas de entrar na sessгo sem as chaves autenticadas

# auto carregar classe a partir de quando ela й instanciada
function __autoload($classename)
{
# pode ser especificado um caminho dentro ou fora do DOCUMENT_ROOT
//$CLASSPATCH="/usr/local/www/phpmafia/_class/";
//require_once($CLASSPATCH."class_".$classename.".php");
require_once("class_".$classename.".php");
}

?>