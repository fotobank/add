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
//				$sum['file']
//				$sum['price']
//				$sum['pecat']
//				$sum['pecat_A4']
//				$sum['koll']
				$rs = $db->query('SELECT * FROM `photos` WHERE `id` = ?i',array($id),'row'); // ��������� �������� ����������
				$print = iTogo();
				$sum = $print['pecat']; // ���-�� ����� ��� ���� ������������ ����
				$fSumm = intval($_SESSION['basket'][$id])*intval($rs['pecat']); // ���-�� ����� ��� ������������ ���� ������ ������
				$koll = $_SESSION['basket'][$id]; // ���-�� ���� ��� ������ (13x18)
				$prKoll = $print['koll']; // ����� ���-�� ���� ��� ������ (13x18)
				echo json_encode(array('sum' => $sum, 'fSumm' => $fSumm, 'fKoll'=> $koll, 'id' => $id, 'add' => $add, 'nm' => $rs['nm'], 'fDel' => $fDel, 'prKoll' => $prKoll));
			}
	}