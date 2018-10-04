<?php
// Arquivo base do sistema, possue o html básico com menu e iframe
require_once ("_autoload.php");
$Objeto = new mafiasession();
$Objeto->check_Session();
?>
<html>
<head>
<title>MafiaSession - Security Login</title>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<p>
verifique que o valor de 1170958697 e keysession mudam de acordo com o valor
setado em TIMEKEY, ou seja a chave da sessão é trocada.
</p>
<p>
<?php
foreach($_SESSION as $key=>$value)
{
echo $key."=>>".$value."<br/>";
}
?>
</p>
<p>
com o setup default<br/><br/>
define("TIMELOGIN",30000);// microsendos<br/>
define("TIMEKEY",60);//segundos<br/>
define("TIMESESSION",3);//minutos<br/><br/>
voce tera 30 segundos para efetuar o login,
a chave da sessão sera atualzada a cada 60 segundos
o tempo maximo de inatividade é de 3 minutos , ou seja se em 3 minutos
 voce não efetuar o método $Objeto->check_Session() sua sessão sera encerrada
  e sera redirecionado para a página de login
  </p>
</body>
</html>