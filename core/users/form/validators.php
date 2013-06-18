<?php
/**
* Just some examples showing text/checkbox/regexp validation.
* You should extend and improve this class to make it fit for your own needs.
*/
class Validator {
    /**
     * @brief sample textValidator
     * @param <type> $value
     * @param <type> $args
     *
     * @bug getting the length of a windows-1251 strings can be problematic, since not all hosting providers support multibyte functions
     */
  /**
	* @param $value
	* @param $args
	*
	* @return string
	*/
  public function textValidator($value, $args) {
        $min=$args[0];
        $max=$args[1];

            $length=strlen(html_entity_decode($value,ENT_QUOTES, "windows-1251"));
            if (($min)&&($length<$min)) {
                return("������� ������� (min. $min chars)");
            }
            if (($max)&&($length>$max)) {
                return("������� ������ (max. $max chars)");
            }

	   return false;
    }
    /**
     * @brief sample termValidator
     * @param <type> $value     
     */
  /**
	* @param $value
	*
	* @return string
	*/
  public function termValidator($value) {
        if ($value!="on") {
           return(" �� ������ ������� �������.");
        }
	   return false;
    }
    /**
     * @brief sample termValidator
     * @param <type> $id
     * @param <type> $args
     */
  /**
	* @param $value
	* @param $args
	*
	* @return bool|string
	*/
  public function regExpValidator($value, $args) {

        if (preg_match($args[0], $value)) {
           return false;
        }else{
            return ("�� �������������� ����� ����������� �����");
        }
    }
    /**
     * @brief check protection code
	  * @param $code
	  * @param $args
	  * @return bool|string
	  */
  public function jsProtector($code, $args){
        if ($code!=$args[0]) {
            return ("������������ ��� ������ (JS ����� ���� ��������, ��� �� �� �������)");
        }
        return false;
    }
}
?>