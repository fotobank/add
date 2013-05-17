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

   $print = iTogo();

if(isset($_POST['goZakazDel']))
		{
			if(isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
				{
				// 	unset($_SESSION['basket'][intval($_POST['goZakazDel'])]);
	echo summa($print);
	      	}
		}


if(isset($_POST['goZakazAdd']))
	{
		$id = intval($_POST['goZakazAdd']);
		$add = intval($_POST['add']);
		$format = $_SESSION['basket']['format'];
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
				$prKoll = $print['koll']; // общее кол-во фото для печати
				$koll = $_SESSION['basket'][$id]; // кол-во фото для печати

				if ($format == '10x15' || $format == '13x18')
					{
						$sum = $print['pecat']; // кол-во денег для всех напечатанных фото 13x18
						$fSumm = $print['arr13'][$id]; // цена за все фото одного номера в массиве // кол-во денег для напечатанных фото одного номера 13x18
						$pr = $print['13'][$id]; //цена за одно фото одного номера в массиве
	echo json_encode(array('pr' => $pr,'sum' => $sum, 'fSumm' => $fSumm, 'fKoll'=> $koll, 'id' => $id, 'add' => $add,
	                       'nm' => $rs['nm'], 'fDel' => $fDel, 'prKoll' => $prKoll));
					} elseif ($format == '20x30')
					{
						$sum = $print['pecat_A4']; // кол-во денег для всех напечатанных фото A4
						$fSumm = $print['arrA4'][$id]; // цена за все фото одного номера в массиве
						$prA4 = $print['A4'][$id]; //цена за одно фото одного номера в массиве
	echo json_encode(array('pr' => $prA4, 'sum' => $sum, 'fSumm' => $fSumm, 'fKoll'=> $koll, 'id' => $id, 'add' => $add,
	                       'nm' => $rs['nm'], 'fDel' => $fDel, 'prKoll' => $prKoll));
					}
			}
	}


	if(isset($_POST['goFormat']))
		{
			$format = trim($_POST['goFormat']);
			$_SESSION['basket']['format'] =  $format;
			if(isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
				{
					$prKoll = $print['koll']; // общее кол-во фото для печати
					$id = $print['id'];

           if ($format == '10x15' || $format == '13x18')
	         {
		         $sum = $print['pecat']; // кол-во денег для всех напечатанных фото 13x18
		         $fSumm = $print['arr13']; // цена за все фото одного номера в массиве
		         $pr = $print['13']; //цена за одно фото одного номера в массиве
		         echo json_encode(array('format' => $format,'sum' => $sum, 'prKoll' => $prKoll, 'summArr' => $fSumm,'prArr' => $pr,'id' => $id));
	         } elseif ($format == '20x30')
	         {
		         $sum = $print['pecat_A4']; // кол-во денег для всех напечатанных фото A4
		         $fSumm = $print['arrA4']; // цена за все фото одного номера в массиве
		         $prA4 = $print['A4']; //цена за одно фото одного номера в массиве
		         echo json_encode(array('format' => $format,'sum' => $sum, 'prKoll' => $prKoll, 'summArr' => $fSumm,'prArr' => $prA4,'id' => $id));
	         } else {
	           echo json_encode($format);
           }
          }
		}