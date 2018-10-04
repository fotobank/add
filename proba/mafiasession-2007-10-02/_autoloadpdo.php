<?php
// http://br.php.net/manual/en/function.session-cache-limiter.php
session_cache_limiter("nocache");// n�o permite cache da sess�o em proxy ou no cliente, default em FreebSD
//http://br.php.net/manual/en/function.session-cache-expire.php
//session_cache_expire(4); //s� funciona para valores diferentes de nocache
session_start();
# configura��o do banco de dados
/*
// Oracle
define("RELDB", "oci"); // oci
define("DATABASE","pdo_ext");
define("HOST","localhost");
define("USER", "pdo_user");
define("PASSWORD", "*****");
define("OPTIONS", "");
*/
/*
// Postgres
#define("RELDB", "pgsql");//pgsql
#define("DATABASE","pdo_ext");
#define("HOST","localhost");
#define("USER", "pdo_user");
#define("PASSWORD", "*******");
define("OPTIONS", "");
*/
// mysql,
define("RELDB", "mysql"); //mysql
define("DATABASE","session");
define("HOST","localhost");
define("USER", "root");
define("PASSWORD", "");
define("OPTIONS", "");
define("TIMELOGIN",30000);// tempo em microsendos para que o usuario use o formul�rio de login
define("TIMEKEY",60);//tem em segundos com que as chaves da sess�o deve ser trocada
define("TIMESESSION",3);//tempo em minuto , tempo maximo de inatividade 
define("SESSIONKEY","Frase chave da minha sess�o"); // chave personalizada para compor a chave de sess�o
define("LOGINURL","http://localhost/enc/login.php"); // URL para se efetuar o ligin
define("LOGINOKURL","http://localhost/enc/mafiasession.php"); // URL que uma autentica��o com sucesso deve carregar
define("KICKURL","http://www.dpf.gov.br/"); // URL para redirecionar tentativas de entrar na sess�o sem as chaves autenticadas

# auto carregar classe a partir de quando ela � instanciada
function __autoload($classename)
{
# pode ser especificado um caminho dentro ou fora do DOCUMENT_ROOT
//$CLASSPATCH="/usr/local/www/phpmafia/_class/";
//require_once($CLASSPATCH."class_".$classename.".php");
require_once("class_".$classename.".php");
}

?>