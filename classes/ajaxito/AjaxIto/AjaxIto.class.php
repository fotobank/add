<?php
/**
* AjaxIto
* Easy call php functions via AJAX, and refresh content and styles without reloading the page.
* AjaxIto es una utilidad escrita en PHP que facilita la integración de AJAX con aplicaciones PHP. 
* AjaxIto is a class written in php that makes it easy to integrate AJAX in a PHP application.
* 
* @package AjaxIto 
* @author Javier Rubacha (javoru@gmail.com)
* @version 1.2 - 04/2008 - works with PHP4 and PHP5
* @web http://www.jabox.com.ar/ajaxito
* 
* LICENSE
* 
* Copyright (c) 2009 Javier Rubacha
* All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions
* are met:
* 1. Redistributions of source code must retain the above copyright
*    notice, this list of conditions and the following disclaimer.
* 2. Redistributions in binary form must reproduce the above copyright
*    notice, this list of conditions and the following disclaimer in the
*    documentation and/or other materials provided with the distribution.
* 3. Neither the name of copyright holders nor the names of its
*    contributors may be used to endorse or promote products derived
*    from this software without specific prior written permission.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
* ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED
* TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
* PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL COPYRIGHT HOLDERS OR CONTRIBUTORS
* BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
* CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
* SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
* CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
* ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
* POSSIBILITY OF SUCH DAMAGE.
* 
*/
class AjaxIto{
	var $XMLEncoding;
    var $name;        
    function AjaxIto($name,$XMLEncoding='iso-8859-1'){ //encoding: UTF-8, iso-8859-1, etc
        $this->name=$name;   
        $this->XMLEncoding = $XMLEncoding;     
        $this->checkProcessorBehaviour();
    }
    function checkProcessorBehaviour(){
        $process=0;
        if (isset($_GET["AjaxItoProcess"])) $process = $_GET["AjaxItoProcess"];
        if ($process==1) {
            include_once("AjaxItoResPro.class.php");
            $clase = $_POST['claseAjaxIto'];
            if (class_exists(strtolower($clase))){
                $procesador = new $clase();
                $procesador->setPost($_POST);
                $procesador->setXMLEncoding($this->XMLEncoding);
                //$procesador->returnXMLAlertError('Vamos bien');
                $procesador->procesar();
            }
            else {
                $procesador = new AjaxItoResPro();
                echo $procesador->returnXMLAlertError('AjaxIto ERROR: controller class not found');
            }
            die();
        }        
    }
    function getJs(){
        $processFile=$this->curPageURL()."?AjaxItoProcess=1";
        $js = "<script language=\"javascript\" type=\"text/javascript\">/* AjaxIto Javascript Code by Javier Rubacha (http://projects.javoru.com.ar), tested in IE, Firefox and Safari */";
        $js .= "                
         ".$this->name."_getObj = function() {
                 try {
                         objeto = new ActiveXObject(\"Msxml2.XMLHTTP\");
                } catch (e) {
                         try {
                                 objeto = new ActiveXObject (\"Microsoft.XMLHTTP\");
                         } catch (e) {
                                  objeto = false;
                        }
                }
                if (!objeto && typeof XMLHttpRequest != 'undefined') {
                         objeto = new XMLHttpRequest();
                }
                return objeto;
        };"
        ;  
              
        $js.= "
         ".$this->name."_getValor = function(id) {
            return (document.getElementById(id).value);
        };";       
         
        $js .= "

        ".$this->name."_doPHP = function (clase, funcion, vars, msgEspera)
        {        
            try {        
                 /*vars = URLEncode(vars);*/
                 /*alert(vars);*/
                 /*alert(funcion);*/
                 var huboErrorRaro = false;
                 document.getElementById('".$this->name."_loader').innerHTML = msgEspera;
                 if (msgEspera!='') document.getElementById('".$this->name."_loader').style.visibility='visible';        
                 document.body.style.cursor= 'wait';
                 _objAjax=".$this->name."_getObj();
                 _values_send=\"claseAjaxIto=\"+clase+\"&funcion=\"+funcion+\"&vars=\"+vars;
                 _URL_=\"$processFile\";
                 _objAjax.open(\"POST\",_URL_,true);
                 /*_objAjax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');*/
                 _objAjax.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=".strtoupper($this->XMLEncoding)."');
                 _objAjax.send('&'+_values_send);
                 _objAjax.onreadystatechange=function() {
                     if (_objAjax.readyState != 4)
                     {
    
                     }        
                     if (_objAjax.readyState==4)
                     {  
                         document.getElementById('".$this->name."_loader').style.visibility='hidden';
                         document.body.style.cursor= 'default';
                         var respXML = _objAjax.responseXML;
                         if (respXML==null) {
                            alert('AjaxIto ERROR: invalid XML response (\"'+_objAjax.responseText+'\")');
                            return(1);
                         }
                         var objetosXML = respXML.getElementsByTagName('objetos')[0];
                         for (i = 0; i < objetosXML.getElementsByTagName('objeto').length; i++){ 
                            var objetoXML = objetosXML.getElementsByTagName('objeto')[i]; 
                            var _id = objetoXML.getElementsByTagName('id')[0].firstChild.data;
                            var propiedadesXML = objetoXML.getElementsByTagName('propiedades')[0]; 
                            for (p = 0; p < propiedadesXML.getElementsByTagName('propiedad').length; p++){ 
                                var propiedadXML = propiedadesXML.getElementsByTagName('propiedad')[p]; 
                                var _nombreProp = propiedadXML.getElementsByTagName('nombre')[0].firstChild.data;
                                var _valorProp = propiedadXML.getElementsByTagName('valor')[0].firstChild.data;
                                if (_valorProp=='[ningunvalor]')_valorProp=''; /* Este fue un parche para que funcione en Safari*/
                                _str = new String (_valorProp);
                                _str = _str.replace(/-]-]->/g, ']]>');
                                _str = _str.replace(/--]--]-->/g, '-]-]->');
                                _valorProp = _str.replace(/---]---]--->/g, '--]--]-->');
                                /* alert(_id); */
                                if (_id=='nop'){ 
                                    return(0);
                                }
                                if (_id=='javascript'){ 
                                    try {
                                        eval(_valorProp);
                                    }
                                    catch (e){
                                        huboErrorRaro=true;
                                        alert(\"AjaxIto ERROR in user JavaScript: \"+e.message);
                                    }
        
        
                                }
                                else {
                                    if (!huboErrorRaro) {
                                        try {
                                            switch (_nombreProp){
                                                case 'innerHTMLAdd':
                                                    document.getElementById(_id).innerHTML += _valorProp;
                                                break;
                                                case 'innerHTML' :
                                                    document.getElementById(_id).innerHTML = _valorProp;
                                                break;
                                                case 'value':
                                                    document.getElementById(_id).value = _valorProp;
                                                break;
                                                case 'valueAdd':
                                                    document.getElementById(_id).value += _valorProp;
                                                break;
                                                case 'className':
                                                    document.getElementById(_id).className = _valorProp;
                                                break;                                            
            
                                                default:
                                                    try{                                        
                                                        document.getElementById(_id).style.setProperty(_nombreProp,_valorProp,null);
                                                    }
                                                    catch(e){
                										try {
                											eval(\"document.getElementById('\"+_id+\"').style.\"+_nombreProp+\"='\"+_valorProp+\"'\");
                										}
                										catch(e){
                                                            /* No hago nada.... hasta acá llegué porque IE no acepta background-color */
                                                             alert ('No se pudo realizar la operacion. Intente Nuevamente'+e.message);
                										}
                                                    }                                        
                                                break;
                                            }/* cierra el switch */
            							}
            							catch(e){
            							     alert(\"AjaxIto ERROR: does the id '\"+_id+\"' exist?\");
            							}
        						    }
        						}
                            }
                         }          
                         
                     }
            
                 }
        	} /* cierra el try */
            catch (e){
                alert ('No se pudo realizar la operacion. Intente Nuevamente. ('+e.message+')');
            }
        }
        ";
        $js.="</script>"; 
        $js = $this->sacaNuevaLinea($js);
        return($js);
    }            
    function sacaNuevaLinea($text)
    {
       return preg_replace("/\r\n|\n|\r|\s\s+/", "", $text);
    }     
    function getLoaderHTML($cssStyle="position:absolute;top:0px;left:0px;z-index:5;BORDER: 1px #4c9adb solid;FONT: 8pt Verdana;COLOR: #000000;TEXT-DECORATION: none;PADDING:3px;background-color:#8fc6f3;visibility:hidden;cursor:wait;"){
        return("<div id=\"".$this->name."_loader\" name=\"".$this->name."_loader\" style=\"$cssStyle\"></div>");
    }        
    function curPageURL() {
        $isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
        $port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
        $port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
        $url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
        $url = str_replace('?'.$_SERVER['QUERY_STRING'], "", $url);     
        return $url;
    }   
 
}
?>