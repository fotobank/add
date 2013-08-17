<?php

  require_once (__DIR__.'/../core/checkSession/checkSession.php');

  /**
	* @param        $addr
	* @param bool   $close_conn
	* @param string $code
	*/
function main_redir($addr = '', $close_conn = true, $code = 'HTTP/1.1 303 See Other')
{

  header($code);
  if(empty($addr))
	 {
		if (isset($_SERVER['HTTP_REFERER'])) {
		  header ("location: ".$_SERVER['HTTP_REFERER']);
		}else{
		  header ("location: index.php");
		}
	 } else {
	 header('location: '.$addr);
  }

  if ($close_conn)
	 {
		$db = go\DB\Storage::getInstance()->get('db-for-data');
		$db->close();
	 }
  exit();
 }


  /**
	* @param string $msg
	* @param string $addr
	*/
//��������� �������� � ����������
function err_exit($msg = '������! ���������� � �������������.', $addr = '')
{
  $session = checkSession::getInstance();
  if(empty($addr)) $addr = $_SERVER['HTTP_REFERER'];
  $session->set('err_msg', $msg);
  main_redir($addr);
}

  /**
	* @param string $msg
	* @param string $addr
	*/
//�������� �������� � ����������
function ok_exit($msg = '�������� ������� ���������', $addr = '')
{
  $session = checkSession::getInstance();
  if(empty($addr)) $addr = $_SERVER['HTTP_REFERER'];
  $session->set('ok_msg', $msg);
  main_redir($addr, false);
}

  /**
	* @param $param_name
	* @param $param_index
	*
	* @return bool|\go\DB\Result
	*/
function get_param($param_name,$param_index)
{
	$db = go\DB\Storage::getInstance()->get('db-for-data');
	$rs = $db->query('select `param_value` from nastr where `param_name` = (?string) AND `param_index` = ?i',array($param_name,$param_index), 'el');
	$value = $rs ? $rs : false;
	return $value;
}

/**
 * @return string
 */
function fotoFolder()
   {
	   $session = checkSession::getInstance();
	   $db = go\DB\Storage::getInstance()->get('db-for-data');
	   $foto_folder = $db->query('select `foto_folder` from `albums` where `id` = ?i',array($session->get('current_album')), 'el');
      return $foto_folder;
   }

  /**
	* @param $password
	* @param $id
	*
	* @return bool
	*/
function getPassword($password,$id){
//	stripslashes($password);
//	$ipassword = trim(md5($password));
//	$update = mysql_query("UPDATE users SET pass = '$ipassword' WHERE id = '$id'")or die(mysql_error()) ;
	$db = go\DB\Storage::getInstance()->get('db-for-data');
	$update = $db->query('UPDATE users SET pass = md5(?string) WHERE id = ?i',array($password,$id)) or die(mysql_error()) ;
	if($update){return true;}
	return false;
}

/**
 * @param     $number
 * @param int $param
 *
 * @return string
 * ������ � ������������ ������� ���������
 * genpass(10, 1); // ���������� ������ �� 10 �������� ���������� ����� � ������� � ������ ��������
 * genpass(10, 2); // ���������� ������ �� 10 �������� ���������� ����� � ������� � ������ ��������, � ����� ����� �� 0 �� 9
 * genpass(10, 3); // ���������� ������ �� 10 �������� ���������� ����� � ������� � ������ ��������, ����� �� 0 �� 9 � ��� ����. �������. ������ ��������� ������� �������))
 */
function genpass($number, $param = 1)
	{
		$arr = array('a','b','c','d','e','f',
		             'g','h','i','j','k','l',
		             'm','n','o','p','r','s',
		             't','u','v','x','y','z',
		             'A','B','C','D','E','F',
		             'G','H','I','J','K','L',
		             'M','N','O','P','R','S',
		             'T','U','V','X','Y','Z',
		             '1','2','3','4','5','6',
		             '7','8','9','0','.',',',
		             '(',')','[',']','!','?',
		             '&','^','%','@','*','$',
		             '<','>','/','|','+','-',
		             '{','}','`','~');
		// ���������� ������
		$pass = "";
		for($i = 0; $i < $number; $i++)
			{
				if ($param>count($arr)-1)$param=count($arr) - 1;
				if ($param==1) $param=48;
				if ($param==2) $param=58;
				if ($param==3) $param=count($arr) - 1;
				// ��������� ��������� ������ �������
				$index = rand(0, $param);
				$pass .= $arr[$index];
			}
		return $pass;
	}

/**
 * @param int $size
 *
 * @return string
 * ������������������� ������
 */
function genPassword($size = 8){
	$a = array('e','y','u','i','o','a','E','Y','U','I','O','A');
	$b = array('q','w','r','t','p','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
	$c = array('1','2','3','4','5','6','7','8','9','0');
	//$e = array('-','_','!','~','$','*','@',':','<','>','+','%');
   $e = array('-','_','!','~','*',':','<','>','+','.');
	$password = $b[array_rand($b)];

	do {
		$lastChar = $password[ strlen($password)-1 ];
		@$predLastChar = $password[ strlen($password)-2 ];
		if( in_array($lastChar,$b)  ) {//��������� ����� ���� ���������
			if( in_array($predLastChar,$a) ) { // ��� ��������� ����� ���� ����������
				$r = rand(0,2);
				if( $r  ) $password .= $a[array_rand($a)];
				else $password .= $b[array_rand($b)];
			}
			else $password .= $a[array_rand($a)];

		} elseif( !in_array($lastChar,$c) AND !in_array($lastChar,$e) ) {
			$r = rand(0,2);
			if($r == 2)$password .= $b[array_rand($b)];
			elseif(($r == 1)) $password .= $e[array_rand($e)];
			else $password .= $c[array_rand($c)];
		} else{
			$password .= $b[array_rand($b)];
		}

	} while ( ($len = strlen($password) ) < $size);

	return $password;
}


// ����� �������� string str_digit_str(integer)
function str_digit_str($summ){
    $tmp_num = (integer)$summ;  // �������
    $str = "";
    $i = 1;            // ������� �����
    $th = array("");

    // ���������� �� ��� ����� � ����� � ������������ ��������
    while(strlen($tmp_num) > 0)
    {
        $tri = "";
        if (strlen($tmp_num) > 3)
        {
            $dig = substr($tmp_num,strlen($tmp_num)-3);
            $tmp_num = substr($tmp_num,0, -3);
        }
        else
        {
            $dig = $tmp_num;
            $tmp_num = "";
        }
       if ($i == 1) $th = " ";
       else if ($i == 2) $th = " ����� ";
       else if ($i == 3) $th = " ��������� ";
       else if ($i == 4) $th = " ���������� ";
       else if ($i == 5) $th = " ��������� ";
       else if ($i == 6) $th = " ���������� ";
       
        // �������� ������� "����� ��������" ��� ����� ������ � ������������ �������� �������
        $str = digit_to_string($dig).$th.$str;
        $i++;
    }
    
    // � ������ ������� ������������ ������ - �� �� ��� �����, ������� ��������� �������� �����
    $tr_arr = array(
        "���� �����" => "���� ������",
        "��� �����" => "��� ������",
        "��� �����" => "��� ������",
        "������ �����" => "������ ������",
        "���� ���������" => "���� �������",
        "��� ���������" => "��� ��������",
        "��� ���������" => "��� ��������",
        "������ ���������" => "������ ��������",
        "���� ����������" => "���� ��������",
        "��� ����������" => "��� ���������",
        "��� ����������" => "��� ���������",
        "������ ����������" => "������ ���������", );

    // �������� ������
    $str = strtr($str, $tr_arr);
    return($str);
}

// ����� �������� �� 999
function digit_to_string($dig){
    $str = "";
    
    // ���������� ������� ������, �������� � �����
    $ed = array("","����","���","���","������","����","�����","����","������","������","������",
        "�����������","����������","����������","������������","����������","�����������",
        "����������","������������","������������","��������");
    $des = array("","������","��������","��������","�����","���������","����������","���������","�����������","���������");
    $sot = array("","���","������","������","���������","�������","��������","�������","���������","���������");

    $dig = (int)$dig;
    if ($dig > 0 && $dig <= 20)
    {
        $str = $ed[$dig];
    }
    else if ($dig > 20 && $dig < 100)
    {
        $tmp1 = substr($dig,0,1);
        $tmp2 = substr($dig,1,1);
        $str = $des[$tmp1]." ".$ed[$tmp2];
    }
    else if ($dig > 99 && $dig < 1000)
   {
        $tmp1 = substr($dig,0,1);
        if (substr($dig,1,2) > 20)
        {
            $tmp2 = substr($dig,1,1);
            $tmp3 = substr($dig,2,1);
            $str = $sot[$tmp1]." ".$des[$tmp2]." ".$ed[$tmp3];
        }
        else $str = $sot[$tmp1]." ".digit_to_string(substr($dig,1,2));
    }
  return $str;
}

	/**
	 * ������� ���������� ������ ��� �������
	 * @return float|int
	 */
	function iTogo()
		{
		  $session = checkSession::getInstance();

			if ($session->has('basket'))
				{
					$basket = '';
					$key    = 0;
					$koll   = array();
					foreach ($session->get('basket') as $ind => $val)
						{

							$basket .= $ind.',';
							$koll[$key] = $val;
							$key++;

						}
					if($basket !='')
						{
					$basket = substr($basket, 0, strlen($basket) - 1); // �������� ��������� ������ �� ������
					$db = go\DB\Storage::getInstance()->get('db-for-data');
					$rs = $db->query('SELECT * FROM `photos` WHERE `id` IN ('.$basket.')')->assoc();
					$sum = array();
					$sum['pecat'] = 0;
					$sum['pecat_A4'] = 0;
					$sum['koll'] = 0;
					$sum['price'] = 0;
					$sum['file'] = 0;
					$sum['arrA4'] = array();
					$sum['arr13'] = array();
					$sum['A4'] = array();
					$sum['13'] = array();
					$sum['id'] = array();
					$sum['nm'] = array();
					if ($rs)
						{
							foreach ($rs as $key => $val)
								{
									$sum['file']   = $key+1; // ���-�� ���������� ������
									$sum['price'] += floatval($rs[$key]['price']); // ���� �� ��� ��������� �����
									$sum['pecat'] += floatval($rs[$key]['pecat']) * intval($koll[$key]);  // ���� �� ������ 13x18
									$sum['pecat_A4'] += floatval($rs[$key]['pecat_A4']) * intval($koll[$key]); // ���� �� ������ A4
									$sum['koll'] += intval($koll[$key]); // ���-�� ���� ��� ������
									$sum['arr13'][$val['id']] = (floatval($rs[$key]['pecat']) * intval($koll[$key])); // ������ ���� 13x18 - ���� * ���-��
									$sum['arrA4'][$val['id']] = floatval($rs[$key]['pecat_A4']) * intval($koll[$key]); // ������ ���� 20x30 - ���� * ���-��
									$sum['13'][$val['id']] = floatval($rs[$key]['pecat']); // ������ ���� 13x18 - ����
									$sum['A4'][$val['id']] = floatval($rs[$key]['pecat_A4']); // ������ ���� 20x30 - ����
									$sum['cena_file'][$val['id']] = floatval($rs[$key]['price']); // ������ ��� �� �����
									$sum['id'][$val['id']] = $val['id'];
									$sum['nm'][$val['id']] = $val['nm'];
								}
							return $sum;
						}
					return $sum;
				     }
				  $session->del('basket');
					return false;
				}
			else
				{
					return false;
				}
		}

	/**
	 * @return null|string
	 * ������� ����� ������
	 */
	function summa()
		{
		  $session = checkSession::getInstance();
			    $print = iTogo();
			if ($print)
				{
				 $zakaz =  $session->get("zakaz");
				 $format = $zakaz['format'];
			    $rt = NULL;

			if ($session->get('print') == '1' || $session->get('print') == '2')
				{
					if ($format == '10x15' || $format == '13x18')
						{
							$rt = "�����: ".$print['pecat']." ������� (".$print['koll']." ���� ".$format."��)";
						}
					elseif ($format == '20x30')
						{
							$rt = "�����: ".$print['pecat_A4']." ������� (".$print['koll']." ���� ".$format."��)";
						}
				}
			 elseif ($session->get('print') == 0)
				{
					$rt = "�����: ".$print['price']." ������� (".$print['file']." ���� 13x18��)";
				}

			 return $rt;
				} else {
			 return false;
			}
		}

  function russData($mysqldate)
  {
# ���������� � ����� �� ����
//	 $mysqldate = '2011-06-10 15:18:00';

# ������� ���� �� ����  � ������ ������� Unix
# ���������� �������� ����� 1307719080
	 $time = strtotime($mysqldate);

# ������� ������������� ������ ��� ������� ����� ������ �������� �������� ������
	 $month_name = array( 1 => '������', 2 => '�������', 3 => '�����',
								 4 => '������', 5 => '���', 6 => '����',
								 7 => '����', 8 => '�������', 9 => '��������',
								 10 => '�������', 11 => '������', 12 => '�������'
	 );

#�������� �������� ������, ����� ������������ ��� ��������� ������
	 $month = $month_name[ date( 'n',$time ) ];

	 $day   = date( 'j',$time ); # � ������� ������� date() �������� ����� ���
	 $year  = date( 'Y',$time ); # �������� ���
	 $hour  = date( 'G',$time ); # �������� �������� ����
	 $min   = date( 'i',$time ); # �������� ������

	 $date = "$day $month $year, $hour:$min";  # �������� ���� �� ����������

	 return $date; #������� ��������������� ����
  }



  /**
	* ������� ��� �������� ���� �� ������� ����
	*
	* @param number ���� � unix �������
	* @param string ������ ��������� ����
	* @param number ����� ������� (�����, ������������ ������� �� �������)
	*
	* %MONTH% � ������� �������� ������ (����������� �����)
	* %DAYWEEK% � ������� �������� ��� ������
	*
	* @example
	* echo dateToRus( time(), '%DAYWEEK%, j %MONTH% Y, G:i' );
	*  �������, 10 ������� 2010, 12:03
	*  ������ �������������:
   * echo dateToRus($row['created_unix'], '%DAYWEEK%, j %MONTH% Y, G:i');
	*/
  function dateToRus($d, $format = 'j %MONTH% Y', $offset = 0)
  {
	 $months = array('������', '�������', '�����', '������', '���', '����', '����',
						  '�������', '��������', '�������', '������', '�������');

	 $days = array('�����������', '�������', '�����', '�������',
						'�������', '�������', '�����������');

	 $d += 3600 * $offset;

	 $format = preg_replace(array(
									'/%MONTH%/i',
									'/%DAYWEEK%/i'
									), array(
										$months[date("m", $d) - 1],
										$days[date("N", $d) - 1]
										), $format);

	 return date($format, $d);
  }


  /**
	* @return string
	*
	*  ���������� $domain �������� ��� ������, �� ������� ����������� ���� ����������.
	*/
  function get_domain()
  {
	 $domain = "http://www.aleks.od.ua/";
	 return $domain;
  }

  /**
	* @param $link
	* @param $text
	* @param $title
	* @param $extras
	*
	* @return string
	*
	*  anchor('new-page.php','New Page','Custom Title Message!','#special_link');
	*
	*  � ������ ������� ������, ID � ��� �������� � ����� ����, ����� ������� ����� ����� ���:
	*  $extras = array('#special_id','.special_class','_blank');
	*  echo anchor('new-page.php','New Page','Custom Title Message!',$extras);
	*
	*/
  function anchor($link, $text, $title, $extras)
  {
	 $domain = get_domain();
	 $link = $domain . $link;
	 $data = '<a href="' . $link . '"';
	 if ($title)
		{
		  $data .= ' title="' . $title . '"';
		}
	 else
		{
		  $data .= ' title="' . $text . '"';
		}
	 if (is_array($extras))
		{
		  foreach($extras as $rule)
			 {
				$data .= parse_extras($rule);
			 }
		}
	 if (is_string($extras))
		{
		  $data .= parse_extras($extras);
		}
	 $data.= '>';
	 $data .= $text;
	 $data .= "</a>";
	 return $data;
  }



  /**
	* @param $rule
	*
	* @return string
	*
	* ���� �� �������� CSS ID, �� �� ����� ���������� � #.
	* ���� �� �������� ����� CSS, �� �� �������� � . .
	* � ���� ���������� ��� target, �� �� �������� � _.
	*/
  function parse_extras($rule)
  {
	 if ($rule[0] == "#")
		{
		  $id = substr($rule,1,strlen($rule));
		  $data = ' id="' . $id . '"';
		  return $data;
		}
	 elseif ($rule[0] == ".")
		{
		  $class = substr($rule,1,strlen($rule));
		  $data = ' class="' . $class . '"';
		  return $data;
		}
	 elseif ($rule[0] == "_")
		{
		  $data = ' target="' . $rule . '"';
		  return $data;
		}
	 return false;
  }


  /**
	* @param $email
	* @param $text
	* @param $title
	* @param $extras
	*
	* @return string
	*
	* ��� �������� ������ mailto:
	* echo mailto('secret@emailaddress.com','Contact Me');
	* ���, ���� ������������ ���������������� ���������, ���:
	* $extras = array('#special_id','.special_class','_blank');
	* echo mailto('secret@emailaddress.com','Contact me','Contact your good pal Barry.',$extras);
	*
	*/
function mailto($email, $text, $title, $extras)
{
$link = '<a href=\"mailto:' . $email;
$link = str_rot13($link);
$data = '<script type="text/javascript">document.write("';
  $data .= $link;
  $data .= '".replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));
</script>';
$data .= '"';
if ($title)
{
$data .= ' title="' . $title . '"';
}
else
{
$data .= ' title="' . $text . '"';
}
if (is_array($extras))
{
foreach($extras as $rule)
{
$data .= parse_extras($rule);
}
}
if (is_string($extras))
{
$data .= parse_extras($extras);
}
$data .= ">";
$data .= $text;
$data .= "</a>";
return $data;
}

  /**
	*  ��������� ����
	*   $n � �����/����������
	*  ehample :  padegi(2)
	*  result: ����������
	*  ehample : padegi(55,'��������','��������','�������')
	*  result: �������
	*/
 function padegi($n,$var1='�����������',$var2='�����������',$var3='������������'){

  return $n%10==1&&$n%100!=11?$var1:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$var2:$var3);

  }


  /**
	* �������� ������ �� ������
	* $string = '��� �������� ������ � ��������: http://xozblog.ru � ��� http://google.com';
	*
	* @param $string
	*
	* @return mixed
	*/
  function removeUrl ($string){
	 return preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $string);
  }


// ������� �� ����� ����������� ������������ Gravatar
  function printGgravatar ($email) {
  $gravatar = 'http://www.gravatar.com/avatar/' . md5($email) . '?s=32';
  return '<img src="' . $gravatar . '" width="32" height="32"/>';
  }

  /**
	* �������� ���������� URL �� ������
	* ����� �� �������� � ������� ��������� ����������, ����������� ������ � ������ ������� � �������� ��� ������� ����.
	* ������� ��� � ��������� ��������� WordPress, ������ ��������� ������ � ����� ����������� URL ��������.
	* echo create_slug('Create Simple Slug URL');
	*
	* @param $string
	*
	* @return mixed
	*/
  function create_slug($string){
	 $string = strtolower($string);
	 $slug=preg_replace('/[^a-z0-9-]+/', '-', $string);
	 return $slug;
  }
