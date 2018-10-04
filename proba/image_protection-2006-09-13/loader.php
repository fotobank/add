<?php
/*
:::::::::::::::::::::::::::::::::::::::::::::::::
::                                             ::
::             H O W  T O  U S E ?             ::
::                                             ::
::                                             ::
::                                             ::
::   require('Loader.class.php');              ::
::                                             ::
::   $protect = new Loader(                    ::
::    	$_SERVER['HTTP_REFERER'],              ::
::    	$_SERVER['QUERY_STRING'],              ::
::    	String password,                       ::
::    	String watermark text,                 ::
::    	Watermark switch true->on false->off,  ::
::    	String font,                           ::
::    	Int fontsize,                          ::
::    	Hex fontcolor,                         ::
::    	Hex shadowcolor,                       ::
::      String Error action                    ::
::      	'jump=>protected.php'              ::
::      	Redirect into specified site       ::
::	    	'show=>protected/protected.gif'    ::
::      	Display a specified image          ::
::     );                                      ::
::                                             ::
:::::::::::::::::::::::::::::::::::::::::::::::::
*/

require('Loader.class.php');

$protect = new Loader( $_SERVER['HTTP_REFERER'], $_SERVER['QUERY_STRING'], "protected_site", "aleks.od.ua", true, "fonts/arialbd.ttf", 16, "FFFFFF", "000000", "jump=>protected.php", "show=>protected/protected.gif" );

?>
