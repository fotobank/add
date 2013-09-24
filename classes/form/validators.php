<?php
//   header('Content-type: text/html; charset=windows-1251');
  require_once (__DIR__.'/../../inc/config.php');
  require_once (__DIR__.'/../../inc/func.php');



class form_Validator {


    /*
     * ������ ��������� ����� Windows-1251 ����� ����� ���� ��������������, ��������� �� ��� �������-���������� ������������ ������������� �������
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

            $length=mb_strlen($value, 'cp1251');

            if (($min)&&($length<$min)) {
                return("������� ������� (���. $min ��������)");
            }
            if (($max)&&($length>$max)) {
                return("������� ������ (����. $max ��������)");
            }
	   return false;
    }


  /**
	* @param $value
	* @param $args
	*
	* @return bool|string
	*/
  public function passValidator($value, $args) {

	 $pass1=$args[0];
	 $pass2=$args[1];
	 $min=$args[2];
	 $max=$args[3];

	 if($pass1 !== $pass2) return("������ �� ���������");

	 $length=strlen(html_entity_decode($value,ENT_QUOTES, "UTF-8"));
	 if (($min)&&($length<$min)&&($length!=0)) {
		return("������� ������� (���. $min ��������)");
	 }
	 if (($max)&&($length>$max)) {
		return("������� ������ (����. $max ��������)");
	 }


	 if (preg_match($args[4], $value) || $pass1 == '') {
		return false;
	 }else{
		return $args[5];
	 }

  }


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
	* @param $value
	* @param $args
	*
	* @return bool|string
	*/
  public function regExpValidator($value, $args) {

	 $min=$args[0];
	 $max=$args[1];
	 $length=strlen(html_entity_decode($value,ENT_QUOTES, "UTF-8"));
	 if (($min)&&($length<$min)&&($length!=0)) {
		return("������� ������� (���. $min ��������)");
	 }
	 if (($max)&&($length>$max)) {
		return("������� ������ (����. $max ��������)");
	 }

        if (preg_match($args[2], $value)) {
           return false;
        }else{
            return $args[3];
        }
    }


  /**
	* @param $value
	* @param $args
	*
	* @return bool|string
	*/
  public function loginValidator($value, $args) {

	 $min=$args[0];
	 $max=$args[1];
	 $length=strlen(html_entity_decode($value,ENT_QUOTES, "UTF-8"));
	 if (($min)&&($length<$min)&&($length!=0)) {
		return("������� ������� (���. $min ��������)");
	 }
	 if (($max)&&($length>$max)) {
		return("������� ������ (����. $max ��������)");
	 }

	 if (!preg_match($args[2], $value)) {
		return $args[3];
	 }

	 $db = go\DB\Storage::getInstance()->get('db-for-data');
	 $rs = $db->query('SELECT `id` FROM `users` WHERE `login`=?string',array($value),'el');

	 if ($rs && $rs != $_SESSION['userid']) {
		return "������������ � ����� ������� ��� ����������, ��������, ����������, ������.";
	 }

		return false;
  }


  /**
	* @param $value
	* @param $args
	*
	* @return bool|string
	*/
  public function phoneValidator($value, $args) {

	 $min=$args[0];
	 $max=$args[1];
	 $length=strlen(html_entity_decode($value,ENT_QUOTES, "UTF-8"));
	 if (($min)&&($length<$min)&&($length!=0)) {
		return("������� ������� (���. $min ��������)");
	 }
	 if (($max)&&($length>$max)) {
		return("������� ������ (����. $max ��������)");
	 }

	 if (!preg_match($args[2], $value)) {
		return false;
	 }else{
		return $args[3];
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
            return ("������������ ��� ������ (JS ����� ���� ��������, ��� �� ���)");
        }
        return false;
    }
}