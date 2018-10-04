<?PHP
/***********************************

Ejemplo de compresion

***********************************/
require_once("../rar.php");
$rar=new rar("c:/archivo.rar");		//Crear el objeto "rar" y darle el nombre del archivo objetivo.     
$rar->setPassword("12345");		//Poner al archivo la contraseña 12345.
$rar->addfolder("c:/carpeta");          //Añadir una carpeta al archivo rar.
?>