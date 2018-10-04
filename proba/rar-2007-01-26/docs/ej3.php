<?PHP
/***********************************

Ejemplo de compresion

***********************************/
require_once("../rar.php");
$rar=new rar("c:/archivo.rar");		//Crear el objeto "rar" y darle el nombre del archivo objetivo.     
$rar->setPassword();                	//Crear una contrase�a aleatoria si se desea.
$rar->compression("normal", true);  	//Establecer un nivel de compresion
$rar->setRecovery(2);			//Esteblecer un registro de recuperaci�n de un 2%
$rar->addList("c:\carpeta1; c:\carpeta2; c:\carpeta3\*.exe");	//A�adir "carpeta1", "carpeta2", y los archivos ".exe" de "carpeta3"
$rar->addfolder("c:/carpeta");      //A�adir una carpeta al archivo rar.
$rar->addfile("c:/comprimir.txt");  //A�adir un fichero al archivo rar.
echo $rarfile->getPassword();           //Mostrar la contrase�a utilizada.
?>