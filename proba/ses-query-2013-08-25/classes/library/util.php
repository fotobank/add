<?php
/**
 * This file contains the util class.
 * 
 * @author Gonzalo Chumillas <gonzalo@soloproyectos.com>
 * @package library
 */

/**
 * class util
 * 
 * This class contains several useful static functions.
 * 
 * @package library
 */
class util {
    
    /**
     * Checks whether a value is an empty string or a null value.
     * 
     * Example:
     * <pre>
     * util::isempty('');         // returns TRUE, as '' is an empty string
     * util::isempty(null);       // returns TRUE, as the value is null
     * util::isempty('testing');  // returns FALSE, as 'testing' is not an empty string
     * util::isempty(0);          // returns FALSE, as 0 is not a string
     * </pre>
     * 
     * @param string $str
     * @return boolean
     */
    public static function isEmpty($str) {
        return $str === NULL || is_string($str) && strlen($str) == 0;
    }
    
    /**
     * Concatenates multiple strings using the 'glue' parameter.
     * This function ignores the undefined and empty strings.
     * 
     * Examples:
     * 
     * util::concat(', ', 'John', '', 'Maria', null, 'Mohamad'); // returns 'John, Maria, Mohamad'
     * util::concat(', ', 'John');                               // returns 'John'
     * 
     * @param string url
     * @param string str...
     * @return string
     */
     public static function concat($glue) {
        $ret = "";
        $args = func_get_args();
        $len = func_num_args();
        
        for ($i = 1; $i < $len; $i++) {
            $str = func_get_arg($i);
            
            if (util::isempty($str)) {
                continue;
            }
            
            if (strlen($ret) > 0) {
                $ret = rtrim($ret, $glue) . $glue;
            }
            
            $ret .= $str;
        }
        
        return $ret;
    }
}
