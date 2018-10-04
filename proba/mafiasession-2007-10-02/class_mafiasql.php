<?php
/**
* Classe que abstrai um 
* banco de dados relacional
* @author Marcelo Soares da Costa
* @email phpmafia at yahoo dot com dot br
* @copyright Marcelo Soares da Costa � 2006. 
* @license FreeBSD http://www.freebsd.org/copyright/freebsd-license.html
* @version 1,1
* @access public
* @package phpmafiasql
* @subpackage phpmafiasql
* @data 2006-10-18
* @ changelog adicionada os m�todos getlinearray() sql2linearray()
* @update 2007-02-01
*/ 
require_once ("class_mafiarelbd.php");
##################################################################################
class MafiaSQL extends MafiaRelDB
{
#
private function __querytype($sqlstring)
{
   unset($this->sql);
	unset($this->querytype);

	$array_injection=array("#","--","\\","//",";","/*","*/","drop","truncate");
	
   $this->sql=trim(strtolower(str_replace($array_injection,"",$sqlstring)));
	 
   list($this->querytype)= explode(" ",$this->sql);
   
   return $this->querytype;
}
#
public function setsql($sqlstring) 
{ 
if($sqlstring==null)
{
die("O valor passado para a fun��o setsql n�o pode ser nulo \r\n<br>");
}
  switch($this->__querytype($sqlstring))
  {
  case "select";
	 return $this->__selectquery($this->sql);
	 break;
  case "update";
	 return $this->__updatequery($this->sql);
	 break;
  case "insert";
	 return $this->__insertquery($this->sql);
	 break;
  case "delete";
	 return $this->__deletequery($this->sql);
	 break;
 default:
    die("Query n�o suportada => ".$sqlstring."\r\n<br/> => para executar este tipo de query � necess�rio utilizar um gerenciador de banco de dados\r\n<br>");
      break;
  }
} 
#
private function __selectquery($sqlstring)
{
  $this->__setquery($sqlstring);
  $this->numberrows=$this->getnumberrows();
  return $this->numberrows;
}
#
private function __updatequery($sqlstring)
{
  if(stripos($sqlstring, 'where') == false)
  {
  die("Para fazer UPDATE � necess�rio a clausula WHERE em => ".$sqlstring);
  }
  $this->__setquery($sqlstring);
  return $this->affected();
}
#
private function __insertquery($sqlstring)
{
  $this->__setquery($sqlstring);
  return $this->getlastid();
}
#
private function __deletequery($sqlstring)
{
	 
  if(stripos($sqlstring, 'where') == false)
  {
  die("Para fazer DELETE � necess�rio a clausula WHERE em => ".$sqlstring);
  }
  
 $this->__setquery($sqlstring);
 return $this->affected(); 
}
#
public function getassocarray()
{
	unset($this->rows);
	unset($this->results);
 if($this->querytype=="select")
 {
	$this->results = array();
	while ($this->rows=$this->__fetchassoc())
	{
	 $this->results[]=$this->rows;
	}
	return $this->results;
 }else{
 die("O m�todo getassocarray � somente suportado em select");
 }
}
#
public function getlinearray()
{
	unset($this->rows);
	unset($this->results);
 if($this->querytype=="select")
 {
	return $this->__fetchassoc();

 }else{
 die("O m�todo getlinearray � somente suportado em select");
 }
}
#
public function getarray()
{
	unset($this->rows);
	unset($this->results);
 if($this->querytype=="select")
 {
	$this->results = array();
	while ($this->rows=$this->__fetchrow())
	{
	 $this->results[]=$this->rows;
	}
	return $this->results;
 }else{
 die("O m�todo getarray � somente suportado em select");
 }
}
#
public function getrow($row=0)
{
 if($this->querytype=="select")
 {	
	return $this->getrecord($row);
 }else{
 die("O m�todo getrow � somente suportado em select");
 }
}
#
public function sql2assocarray($sqlstring)
{
  
   if($this->__querytype($sqlstring)=="select")
   {
	  if($this->__selectquery($this->sql)==true)
	  {
	  return $this->getassocarray();
	  }else{
	  die(" A query => ".$sqlstring." n�o retornou um resultado v�lido");
	  }
	}else{
	die(" A query => ".$sqlstring." n�o � um select");
	}
}
public function sql2linearray($sqlstring)
{
  
   if($this->__querytype($sqlstring)=="select")
   {
	  if($this->__selectquery($this->sql)==true)
	  {
	  return $this->getlinearray();
	  }else{
	  die(" A query => ".$sqlstring." n�o retornou um resultado v�lido");
	  }
	}else{
	die(" A query => ".$sqlstring." n�o � um select");
	}
}
# Fim da Classe
}
?>
