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
					$sum['pecat'] = iTogo();
					echo  "ИТОГО: <b>".$sum['pecat']." гривень</b>";
	      	}
		}

if(isset($_POST['goZakazAdd']))
	{
		$id = intval($_POST['goZakazAdd']);
		$add = intval($_POST['add']);
		if(isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
			{


				$sum = iTogo();
				echo json_encode(array('iTogo' => $sum, '#fSumm'.$id => $fSumm, '#fkoll'.$id => $koll, 'id' => $id, 'add' => $add));
			}
	}