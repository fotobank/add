<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 09.06.13
 * Time: 21:57
 * To change this template use File | Settings | File Templates.
 */

  /* Usage
 Grab some XML data, either from a file, URL, etc. however you want. Assume storage in $strYourXML;

 $objXML = new xml2Array();
 $arrOutput = $objXML->parse($strYourXML);
 print_r($arrOutput); //print it out, or do whatever!

*/
  class xml2Array {

	 var $arrXml = array();
	 var $resParser;
	 var $strXmlData;
	 var $arrOutput = array();

	 function parse($strInputXML) {

		$this->resParser = xml_parser_create ();
		xml_set_object($this->resParser,$this);
		xml_set_element_handler($this->resParser, "tagOpen", "tagClosed");

		xml_set_character_data_handler($this->resParser, "tagData");

		$this->strXmlData = xml_parse($this->resParser,$strInputXML);
		if(!$this->strXmlData) {
		  die(sprintf("XML error: %s at line %d",
			 xml_error_string(xml_get_error_code($this->resParser)),
			 xml_get_current_line_number($this->resParser)));
		}

		xml_parser_free($this->resParser);

		foreach($this->arrXml as $key => $val)
		  {
			 $this->arrOutput[strtolower($val['name'])] = isset($val['tagData'])?$val['tagData']:'';
		  }

		return $this->arrOutput;
	 }
	 function tagOpen($parser, $name, $attrs) {
		$tag=array("name"=>$name);
		array_push($this->arrXml,$tag);
	 }

	 function tagData($parser, $tagData) {
		if(trim($tagData)) {
		  if(isset($this->arrXml[count($this->arrXml)-1]['tagData'])) {
			 $this->arrXml[count($this->arrXml)-1]['tagData'] .= $tagData;
		  }
		  else {
			 $this->arrXml[count($this->arrXml)-1]['tagData'] = $tagData;
		  }
		}
	 }

	 function tagClosed($parser, $name) {
		$this->arrXml[count($this->arrXml)][] = $this->arrXml[count($this->arrXml)-1];
		array_pop($this->arrXml);
	 }
  }