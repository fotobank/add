<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 09.06.13
 * Time: 19:24
 * To change this template use File | Settings | File Templates.
 */

  /**
	* @param $path
	* функция, которая проверяет настройки php.ini
	* @return mixed
	*/
  function magic($path){
	 if ( @ini_get ('magic_quotes_sybase')=='1'){
		$path = str_replace ('""','"',$path);
		$path = str_replace ("''","'",$path);
	 }
	 else {
		if ( @get_magic_quotes_gpc ()=='1'){
		  $path = str_replace ('\\"','"',$path);
		  $path = str_replace ("\\'","'",$path);
		  $path = str_replace ("\\\\","\\",$path);
		}
	 }
	 return $path;
  }

// вытащим в программу все переменные с учетом настроек php.ini
if ( isset ($_GET)) { foreach ($_GET as $key=>$val) {$$key=magic($val);}}
if ( isset ($_POST)) { foreach ($_POST as $key=>$val) {$$key=magic($val);}}
if ( isset ($_COOKIE)){ foreach ($_COOKIE as $key=>$val) {$$key=magic($val);}}
?>
