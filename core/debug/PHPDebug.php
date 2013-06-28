<?php

class PHPDebug {

function __construct() {
    if (!defined("LOG"))    define("LOG",1);
    if (!defined("INFO"))   define("INFO",2);
    if (!defined("WARN"))   define("WARN",3);
    if (!defined("ERROR"))  define("ERROR",4);

    define("NL","\r\n");
    echo '<script type="text/javascript">'.NL;

    /// ����. ��� ������������ ��� ��������� ��� �������
    echo 'if (!window.console) console = {};';
    echo 'console.log = console.log || function(){};';
    echo 'console.warn = console.warn || function(){};';
    echo 'console.error = console.error || function(){};';
    echo 'console.info = console.info || function(){};';
    echo 'console.debug = console.debug || function(){};';
    echo '</script>';
    /// ����� ������ ��� ��������� ��� �������
}



function debug($name, $var = null, $type = LOG) {
    echo '<script type="text/javascript">'.NL;
    switch($type) {
        case LOG:
            echo 'console.log("'.$name.'");'.NL;
        break;
        case INFO:
            echo 'console.info("'.$name.'");'.NL;
        break;
        case WARN:
            echo 'console.warn("'.$name.'");'.NL;
        break;
        case ERROR:
            echo 'console.error("'.$name.'");'.NL;
        break;
    }

    if (!empty($var)) {
        if (is_object($var) || is_array($var)) {


  function iconv_deep($e1, $e2, $value)
		{
				if (is_array($value))
				  {
					 $item = null;
					 foreach ($value as &$item)
						{
						  $item = iconv_deep($e1, $e2, $item);
						}
					 unset($item);
				  }
				else
				  {
					 if (is_string($value)) $value = mb_convert_encoding($value, $e2, $e1);
				  }
				return $value;
		}

			 $var = iconv_deep('windows-1251', 'utf-8', $var);
			 $object = json_encode($var);

            echo 'var object'.preg_replace('~[^A-Z|0-9]~i',"_",$name).' = \''.str_replace("'","\'",$object).'\';'.NL;
            echo 'var val'.preg_replace('~[^A-Z|0-9]~i',"_",$name).' = eval("(" + object'.preg_replace('~[^A-Z|0-9]~i',"_",$name).' + ")" );'.NL;
            switch($type) {
                case LOG:
                    echo 'console.debug(val'.preg_replace('~[^A-Z|0-9]~i',"_",$name).');'.NL;
                break;
                case INFO:
                    echo 'console.info(val'.preg_replace('~[^A-Z|0-9]~i',"_",$name).');'.NL;
                break;
                case WARN:
                    echo 'console.warn(val'.preg_replace('~[^A-Z|0-9]~i',"_",$name).');'.NL;
                break;
                case ERROR:
                    echo 'console.error(val'.preg_replace('~[^A-Z|0-9]~i',"_",$name).');'.NL;
                break;
            }
        } else {
            switch($type) {
                case LOG:
                    echo 'console.debug("'.str_replace('"','\\"',$var).'");'.NL;
                break;
                case INFO:
                    echo 'console.info("'.str_replace('"','\\"',$var).'");'.NL;
                break;
                case WARN:
                    echo 'console.warn("'.str_replace('"','\\"',$var).'");'.NL;
                break;
                case ERROR:
                    echo 'console.error("'.str_replace('"','\\"',$var).'");'.NL;
                break;
            }
        }
    }
    echo '</script>'.NL;
}
}
?>