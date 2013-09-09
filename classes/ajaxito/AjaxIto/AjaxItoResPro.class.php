<?php
/**
* AjaxItoResPro
* Class that process de AJAX requests and returns the xml that will be processed by javascript.
* The controller class that has the user defined methods needs to be extended from this one.
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
    class AjaxItoResPro {
        var $post;
        var $XMLEncoding='iso-8859-1';
        var $arrayResp;
        var $arguments='';
        function AjaxItoResPro(){
        }
        function setPost($post){
            $this->post=$post;
        }
        function setXMLEncoding($XMLEncoding){
        	$this->XMLEncoding=$XMLEncoding;
        }
        function procesar(){
            $post=$this->post;
            if (!empty($post['funcion'])){   
                if (!empty($post['vars'])) $this->ejecutar($post['funcion'],$post['vars']);
                else $this->ejecutar($post['funcion']);
            }        
        }
        function ejecutar($funcion, $xml=''){
            if ($xml) {
                $argumentos = array();
                
                $arrayVars = $this->createArray($xml); 
                foreach($arrayVars as $nombreNodoRaiz => $nodoRaiz){
                    if ($nombreNodoRaiz == 'VARS') {
                        foreach ($nodoRaiz as $nombreVar => $var){
                            $cual = substr($nombreVar,3);
                            $argumentos[$cual] = addslashes($var['VALUE']);
                        }
                    }
                }
                
                $this->arguments=$argumentos;
            }
            //if (sizeof($this->arguments)==1) $this->$funcion($this->arguments[0]);        
            /*else*/ $this->$funcion($this->arguments);
            $arrayResp = $this->arrayResp;
            if (!$arrayResp) {
                $arrayResp=array();
                $arrayResp['nop']['valor'] = 'nop';
            }
            $xml = $this->arrayResp2XML($arrayResp);
            $this->xmlResp=$xml;
            $this->returnXML($xml);
        }
        function addDOMProperty($DOMId, $property,$value){
            if (strlen($value)==0)$value="[ningunvalor]"; // Parche para Safari -> luego este valor es reemplazado por '' en javascript
            $this->arrayResp[$DOMId][$property]=$value;
            
        }
        function addJavaScriptCode($code){
            $this->arrayResp['javascript']['code'].=$code.";";
        }
        function arrayResp2XML($arrayResp){
            $xml="<?xml version=\"1.0\" encoding=\"$this->XMLEncoding\" standalone=\"yes\"?>";
            $xml.="<objetos>";
            foreach ($arrayResp as $nombreObjeto => $propiedades) {
                $xml.="<objeto>";
                $xml.="<id>$nombreObjeto</id>";
                $xml.="<propiedades>";
                foreach ($propiedades as $nombrePropiedad => $propiedad){
                    $xml.="<propiedad>";
                    $xml.="<nombre>$nombrePropiedad</nombre>";
                    $xml.="<valor><![CDATA[$propiedad]]></valor>";
                    $xml.="</propiedad>";
                }
                $xml.="</propiedades>";
                $xml.="</objeto>";
            }        
             $xml.="</objetos>";  
             return($xml);      
        }
        
        function returnXML($xml=''){             
            if ($xml=='') $xml=$this->xmlResp;
             header('Content-Type: text/xml');
             echo $xml;
        }

        function createArray($xml){
            $xml_parser = xml_parser_create();
            $data=$xml;
            xml_parse_into_struct($xml_parser, $data, $vals, $index);
            xml_parser_free($xml_parser);        
            $params = array();
            $level = array();
            foreach ($vals as $xml_elem) {
              if ($xml_elem['type'] == 'open') {
                if (array_key_exists('attributes',$xml_elem)) {
                  list($level[$xml_elem['level']],$extra) = array_values($xml_elem['attributes']);
                } else {
                  $level[$xml_elem['level']] = $xml_elem['tag'];
                }
              }
              if ($xml_elem['type'] == 'complete') {
                $start_level = 1;
                $php_stmt = '$params';
                while($start_level < $xml_elem['level']) {
                  $php_stmt .= '[$level['.$start_level.']]';
                  $start_level++;
                }
                $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
                eval($php_stmt);
              }
            }
            /*
            foreach ($params as $key => $param){
                if ($key==("VARS")){
                    foreach ($param as $numVar => $var){
                        $arrVars[]=$var['VALUE'];
                    }
                }
            }
            */
            return($params);
        }
        
        function returnXMLAlertError($textoAlert='error'){
            $xml  = "<?xml version=\"1.0\" encoding=\"$this->XMLEncoding\" standalone=\"yes\"?>
            <objetos>
                <objeto>
                    <id>javascript</id>
                    <propiedades>
                        <propiedad>
                            <nombre>code</nombre>
                            <valor><![CDATA[alert('$textoAlert');]]></valor>
                        </propiedad>
                    </propiedades>
                </objeto>   
            </objetos> 
             ";        
            $this->returnXML($xml);
        }                
    }
?>