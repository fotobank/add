<?php
function main_redir($addr, $close_conn = true, $code = 'HTTP/1.1 303 See Other')
{
  header($code);
  header('location: '.$addr);
  if ($close_conn)
  {
	 $db = go\DB\Storage::getInstance()->get('db-for-data');
	 $db->close();
    exit();
  }
}

//��������� �������� � ����������
function err_exit($msg = '������! ���������� � �������������.', $addr = '')
{
  if(empty($addr)) $addr = $_SERVER['PHP_SELF'];
  $_SESSION['err_msg'] = $msg;
  main_redir($addr);
}

//�������� �������� � ����������
function ok_exit($msg = '�������� ������� ���������', $addr = '')
{
  if(empty($addr)) $addr = $_SERVER['PHP_SELF'];
  $_SESSION['ok_msg'] = $msg;
  main_redir($addr);
}



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
	   $db = go\DB\Storage::getInstance()->get('db-for-data');
	   $foto_folder = $db->query('select foto_folder from albums where id = ?i',array($_SESSION['current_album']), 'el');
      return $foto_folder;
   }

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
	$e = array('-','_','!','~','$','*','@',':','<','>','+','%');
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
			if ($_SESSION['basket'])
				{
					$basket = '';
					$key    = 0;
					$koll   = array();
					foreach ($_SESSION['basket'] as $ind => $val)
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
					unset ($_SESSION['basket']);
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
			    $print = iTogo();
			if ($print)
				{
			    $format = $_SESSION['zakaz']['format'];
			    $rt = NULL;
			if (isset($_SESSION['print']))
				{
			if ($_SESSION['print'] == '1' || $_SESSION['print'] == '2')
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
			 elseif ($_SESSION['print'] == 0)
				{
					$rt = "�����: ".$print['price']." ������� (".$print['file']." ���� 13x18��)";
				}
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
?>