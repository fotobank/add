<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 12.05.13
 * Time: 15:46
 * To change this template use File | Settings | File Templates.
 */

	include (dirname(__FILE__).'/config.php');
	include (dirname(__FILE__).'/func.php');


if(isset($_POST['goZakazDel']))
		{
			if(isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
				{
					unset($_SESSION['basket'][intval($_POST['goZakazDel'])]);
					$print = iTogo();
					if(trim($_POST['str']) == '1')
						{
					echo "�����: ".$print['pecat']." ������� - ".$print['koll']." ���� (13x18 ��)";
						}
					else
						{
						echo "�����: ".$print['price']." ������� - ".$print['file']." ����";
				      }
	      	}
		}

if(isset($_POST['goZakazAdd']))
	{
		$id = intval($_POST['goZakazAdd']);
		$add = intval($_POST['add']);
		$fDel = 0;
		if(isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
			{

				if($add == '1')
					{
						$_SESSION['basket'][$id]++;
					} else
					{
					   $_SESSION['basket'][$id]--;
						if( $_SESSION['basket'][$id] <= 0)
							{
								unset($_SESSION['basket'][$id]);
								$fDel = 1;
							}
				   }
				$rs = $db->query('SELECT * FROM `photos` WHERE `id` = ?i',array($id),'row');
				$print = iTogo();
				$sum = $print['pecat']; // ���-�� ����� ��� ���� ������������ ����
				$fSumm = intval($_SESSION['basket'][$id])*intval($rs['pecat']); // ���-�� ����� ��� ������������ ���� ������ ������
				$koll = $_SESSION['basket'][$id]; // ���-�� ���� ��� ������ (13x18)
				$prKoll = $print['koll']; // ����� ���-�� ���� ��� ������ (13x18)
				echo json_encode(array('sum' => $sum, 'fSumm' => $fSumm, 'fKoll'=> $koll, 'id' => $id, 'add' => $add, 'nm' => $rs['nm'], 'fDel' => $fDel, 'prKoll' => $prKoll));
			}
	}


	if(isset($_POST['goFormat']))
		{
			$format = trim($_POST['goFormat']);
			if(isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
				{
					$print = iTogo();
					$prKoll = $print['koll']; // ����� ���-�� ���� ��� ������
					$id = $print['id'];

           if ($format == '10x15' || $format == '13x18')
	         {
		         $sum = $print['pecat']; // ���-�� ����� ��� ���� ������������ ���� 13x18
		         $fSumm = $print['arr13']; // ���� �� ��� ���� ������ ������ � �������
		         $pr = $print['13']; //���� �� ���� ���� ������ ������ � �������
		         echo json_encode(array('format' => $format,'sum' => $sum, 'prKoll' => $prKoll, 'summArr' => $fSumm,'prArr' => $pr,'id' => $id));
	         } elseif ($format == '20x30')
	         {
		         $sum = $print['pecat_A4']; // ���-�� ����� ��� ���� ������������ ���� A4
		         $fSumm = $print['arrA4']; // ���� �� ��� ���� ������ ������ � �������
		         $prA4 = $print['A4']; //���� �� ���� ���� ������ ������ � �������
		         echo json_encode(array('format' => $format,'sum' => $sum, 'prKoll' => $prKoll, 'summArr' => $fSumm,'prArr' => $prA4,'id' => $id));
	         } else {
	           echo json_encode($format);
           }

          }
		}