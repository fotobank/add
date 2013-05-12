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

	if (isset($_POST['goPecatDel']))
		{


			if(isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
				{
					unset($_SESSION['basket'][intval($_POST['goPecatDel'])]);

							$sum = 0;
							foreach($_SESSION['basket'] as $ind => $val)
								{
									$rs = $db->query('select price from photos where id = ?i', array($ind), 'el');
									if($rs)
										{
											$sum+= floatval($rs);
										}
									else
										{
											unset($_SESSION['basket'][$ind]);
										}
								}
					echo  "ИТОГО: <b>$sum гривен</b>";
	      	}
		}