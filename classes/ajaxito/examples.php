<?php
/*
Este archivo muestra varios ejemplos sencillos de como utilizar la clase AjaxIto (v1.2) / This files show some examples of how to use AjaxIto (v1.2).
AjaxIto es una utilidad escrita en PHP que facilita la integración de AJAX con aplicaciones PHP. 
AjaxIto is a class written in php that makes it easy to integrate AJAX in a PHP application.
Espero les guste / Hope you like it.
Escrito por Javier Rubacha / Written by Javier Rubacha.
*/

// Incluyo la clase principal de AjaxIto
// Include the AjaxIto main class 
include_once("AjaxIto/AjaxIto.class.php");
// Incluyo la clase a la que se le podrán utilizar sus métodos mediante AJAX
// Include the class that, it methods, can be used by AJAX
include_once("ExampleControllerClass.class.php");
// ATENCION!!! es completamente necesario instanciar la clase ANTES de que sea enviado cualquier encabezado al cliente! (cuidado con las lineas en blanco). 
// ATTENTION!!! the class must be instatied BEFORE any headers are sent to the client. (be careful with blank lines)
$ajaxito = new AjaxIto("testing");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>AjaxIto Ejemplo de uso / Example File </title>
</head>
<body>
<?php 
// traigo el codigo javascript que necesita AjaxIto para funcionar
// brings the JavaScript code that AjaxIto needs to work.
echo $ajaxito->getJs(); 
// muestra el div del "cartelito de procesamiento" (podría pasarse como parametro los estilos para el cartelito de cargando)
// show the loader div (a custom style can by specified been passed by parameter)
echo $ajaxito->getLoaderHTML(); 

/* 
In the next lines of HTML code you will see the JavaScript funtion to call AjaxIto, it's name is testing_doPHP (where testing is the name of the AjaxIto class instatied), and the arguments are:
1° argument: name of the controller class, in this case "ExampleControllerClass", there are the methods that we can call and where we process the answer.
2° argument: the name of the method we are calling (it must be declared in the class of the 1° argument)
3° argument: the variables that are going to be passes to the method that we are calling, te sctructure of this "string" is :<vars><var0><value>variableValue</value></var0><var1><value>variableValue</value></var1></vars> (of course you can continue defining variables using var2,var3,etc.)
4° argument: the text to show in the "loading" message.


En las proximas lineas de código HTML veran la función JavaScript para utilizar AjaxIto, en este caso el nombre es testing_doPHP (testing es reemplazado por el correspondiente nombre usado al instanciar AjaxIto), los argumentos a utilizar son:
1° argumento: nombre de la clase controladora, en este caso "ExampleControllerClass", alli están declarados los métodos que podemos llamar mediante AjaxIto y que procesaran la respuesta en el servidor.
2° argumento: el nombre del método que estamos utilizando, que debe estar declarado en la clase especificada en el 1° argumento.
3° argumento: las variables que estamos pasandole a dicho método para que procese lo que necesite hacer, la estructura y forma de pasar las variables es mediante la siguiente "cadena": <vars><var0><value>variableValue</value></var0><var1><value>valorDeLaVariable</value></var1></vars> (porsupuesto que se pueden seguir agregando variables de nombrandolas var2, var3, var4, etc.), el valor de estas variables es recuperado luego en el método elegido.
4° argumento: es el texto a mostrar en el cartel que muestra el "cargando" o "procesando" del a petición.
*/

?>
<h1>AjaxIto Ejemplo de uso / Example File </h1>
<h2>Introducci&oacute;n / Introduction</h2>
AjaxIto es una utilidad escrita en PHP que facilita la integraci&oacute;n de AJAX con aplicaciones PHP<BR />
<i>AjaxIto is a class wirtten in php that makes it easy to integrate AJAX in a PHP application.</i><BR /><BR />
Con AjaxIto se pueden manipular facilmente las propiedades de cualquier objeto de una p&aacute;gina HTML asi como ejecutar c&oacute;digo JavaScript generado desde el servidor. <br />
<i>With AjaxIto you can easily manipulate every css aspect of an object in a webpage and also execute JavaScript code.</i><br />
<BR />
Este archivo presenta ejemplos b&aacute;sicos del uso de la clase AjaxIto <BR />
<i>This file shows basic examples of how to use AjaxIto class</i>.
<BR />

<h2>Cambio de color / Color change</h2>
Elija el color que desea para la palabra "COLOR"
Choose the color that you prefer for the word "COLOR"
<div name="colorDiv" id="colorDiv" style="background:#E7E7E7;padding:5px;font-weight:bold;width:55px;border:1px #979797 solid;">COLOR</div>
<br />
<input type="button" value="Rojo (Red)" onClick="testing_doPHP('ExampleControllerClass','cambioDeColor','<vars><var0><value>#FF0000</value></var0></vars>','Coloreando...');" />
<input type="button" value="Azul (Blue)" onClick="testing_doPHP('ExampleControllerClass','cambioDeColor','<vars><var0><value>#0000FF</value></var0></vars>','Coloreando...');" />

<BR />
<h2>Cambio de contenido / Content change</h2>
<div name="contExample" id="contExample" style="background:#E7E7E7;padding:7px;font-weight:bold;height:20px;width:550px;border:1px #979797 solid;">Cambiame! / Change Me!</div><BR />
<input type="button" value="Cambialo! / Change It! " onClick="testing_doPHP('ExampleControllerClass','cambioDeContenido','<vars><var0><value>null</value></var0></vars>','Cambiando...');" />
<h2>Calculadora / Calculator</h2>
Ingrese los números, seleccione la operación y presione el botón:
<BR />
<div style="float:left;">
<SELECT name="nro1" id="nro1">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>			
	<option value="5"">5</option>	
</SELECT> 
<SELECT name="op" id="op">
	<option value="a">+</option>
	<option value="-">-</option>
	<option value="x">x</option>
	<option value="/">/</option>				
</SELECT> 
<SELECT name="nro2" id="nro2">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>			
	<option value="5"">5</option>	
</SELECT> = 
</div>
<div id="res" style="padding-left:7px;color:#009900;float:left;"></div>
 <br /> <br />
 <input type="button" value="Calcular!/Calculate!" onClick="testing_doPHP('ExampleControllerClass','calculate','<vars><var0><value>'+document.getElementById('nro1').value+'</value></var0><var1><value>'+document.getElementById('nro2').value+'</value></var1><var2><value>'+document.getElementById('op').value+'</value></var2></vars>','Calculando...');" />
<br />
<h2>Dimensionando / Changing sizes</h2>
<div name="cuad" id="cuad" style="background:#4444AA;height:50px;color:#ffffff;width:50px;border:1px #9999AA solid;"></div><BR />
Ancho/Width : <input type="text" name="width" id="width"></input>
Alto/Height : <input type="text" name="height" id="height"></input>
<br />
<input type="button" value="Redimensionar!/Resize!" onClick="testing_doPHP('ExampleControllerClass','resizeSquare','<vars><var0><value>'+document.getElementById('width').value+'</value></var0><var1><value>'+document.getElementById('height').value+'</value></var1></vars>','Cambiando...');" />


<h2>Alerts (ejecuci&oacute;n de c&oacute;digo JavaScript creado de la respuesta del servidor/ JavaScript code execution from server response)</h2>
Presionando el siguiente enlace se ejecutar&aacute;n 2 mensajes "Alert", previamente procesados en el servidor. 
By clicking on the link will be shown two alert messages previously processed in server side.
<BR />
<input type="button" value="Alerts Example" onClick="testing_doPHP('ExampleControllerClass','testAlert','<vars><var0><value>Hola Mundo!</value></var0><var1><value>Hello World!</value></var1></vars>','Loading...');" />
<BR /> 
<hr />
AjaxIto v1.2 - Javier Rubacha
</body>
</html>
