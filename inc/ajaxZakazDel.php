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
					echo "ИТОГО: ".$print['pecat']." гривень - ".$print['koll']." фото (13x18 см)";
						}
					else
						{
						echo "ИТОГО: ".$print['price']." гривень - ".$print['file']." фото";
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
				$rs = $db->query('SELECT * FROM `photos` WHERE `id` = ?i',array($id),'row'); // выводимое название фотографии
				$print = iTogo();
				$sum = $print['pecat']; // кол-во денег для всех напечатанных фото
				$fSumm = intval($_SESSION['basket'][$id])*intval($rs['pecat']); // кол-во денег для напечатанных фото одного номера
				$koll = $_SESSION['basket'][$id]; // кол-во фото для печати (13x18)
				$prKoll = $print['koll']; // общее кол-во фото для печати (13x18)
				echo json_encode(array('sum' => $sum, 'fSumm' => $fSumm, 'fKoll'=> $koll, 'id' => $id, 'add' => $add, 'nm' => $rs['nm'], 'fDel' => $fDel, 'prKoll' => $prKoll));
			}
	}