<?PHP
/***********************************

Ejemplo de compresion

***********************************/
require_once("../rar.php");
$rarfile=new rar("c:/archivo.rar");   //Crear el objeto "rar" y darle el nombre del archivo objetivo.     
$rarfile->addfile("c:/comprimir.txt");   //A�adir un fichero al archivo rar.
?>