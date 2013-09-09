<?php
// Esta clase es la que contiene los métodos que procesan las peticiones AJAX y entregan las respuestas posibles (como ser modificar un estilo de un objeto de la página HTML, o el contenido por ejemplo). Es necesario que la clase herede de AjaxItoResPro. (Para lo cual tambien debemos incluir el archivo AjaxItoResPro.class.php.
// This class has all the methods that process the petitions and also defines what will be de answer and what to do (modify a style of a html object, a content, etc.). This class must extend AjaxItoResPro class, so we have to include the file AjaxItoResPro.class.php.


include_once("AjaxIto/AjaxItoResPro.class.php");
class ExampleControllerClass extends AjaxItoResPro { 
	// Los metodos que vayan a utilizar argumentos que provienen del llamado al AJAX deben tener un parametro mediante el cual se le pasan los valores especificados en la llamada javascript (ver "example.php") en este caso $argument_array	
	// The methods that needs arguments coming form the JavaScript call must declare and argument, in this case "$argument_array", that is an array where comes the value of the varaibles defined in the javascript call (see "example.php").
    function cambioDeColor($argument_array){
    	// de esta forma es como se van agregando las respuestas, en este caso la modificacion del color del texto de un div, el color nuevo es pasado como argumento (ver example.php).
    	// this is the way how we can add modifications to objects in the HTML page, in this case is the color of the content of a div, the new color is passed as an argument (ver example.php).
        $this->addDOMProperty('colorDiv','color',$argument_array[0]);        
    }
    function testAlert($argument_array) {    	
        foreach ($argument_array as $txt) {        	
            $this->addJavaScriptCode("alert('$txt');");
        }
    }    
    
    function calculate($argument_array){
    	$nro1=$argument_array[0];
    	$nro2=$argument_array[1];
    	$op=$argument_array[2];
    	switch ($op) {
    		case "a":
    			$res = $nro1+$nro2;
    		break;
    		case "-":
    			$res = $nro1-$nro2;
    		break;
    		case "x":
    			$res = $nro1*$nro2;
    		break;
    		case "/":
    			if ($nro2!=0) $res = $nro1/$nro2;
    			else $res="ERROR";
    		break;
    	}
        $this->addDOMProperty('res','innerHTML',$res);            	
    }
    function resizeSquare($argument_array){
    	$width=$argument_array[0];
    	$height=$argument_array[1]; 
    	if (($width>0) && ($height>0)) {
	    	$this->addDOMProperty('cuad','width',$width."px");
	    	$this->addDOMProperty('cuad','height',$height."px");
	    	$this->addDOMProperty('cuad','innerHTML',"");
    	}
    	else {
	    	$this->addDOMProperty('cuad','width',"500px");
	    	$this->addDOMProperty('cuad','height',"50px");    		
    		$this->addDOMProperty('cuad','innerHTML',"Los valores ingresados deben ser mayores a cero! / The values must be greater than zero!");
    	}
    }
    function cambioDeContenido($argument_array){
    	$text = "Soy un texto que viene desde el servidor! / I'm text that comes from server side!";
    	$this->addDOMProperty('contExample','innerHTML',$text);
    }
}
?>