<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 08.09.13
 * Time: 20:15
 * To change this template use File | Settings | File Templates.
 *
 * СООБЩЕНИЕ ОБ ОШИБКЕ
 */

class printMsg {


function __construct() {

	global $error;
	$session = check_Session::getInstance();

	if (!empty($error))
	{
		$session->set('err_msg', $error);
		unset($error);
	}

	if ($session->has('err_msg') && $session->get('err_msg') != '')
	{
		?>
		<script type='text/javascript'>
			dhtmlx.message.expire = 6000; // время жизни сообщения
			dhtmlx.message({ type: 'error', text: 'Ошибка!<br><?=$session->get('err_msg')?>'});
			<!--			humane.error('Ошибка!<br>--><?//=$session->get('err_msg')?><!--')-->
		</script>
		<?
		$session->del('err_msg');
	}

	// <!-- СООБЩЕНИЕ О УПЕШНОМ ЗАВЕРШЕНИИ-->
	if ($session->has('ok_msg') && $session->get('ok_msg') != '')
	{

		?>
		<script type='text/javascript'>
			humane.success("Добро пожаловать, <?=$session->get('us_name')?>!<br><span><?=$session->get('ok_msg')?></span>");
		</script>
		<?
		$session->del('ok_msg');
	}


if ($session->has('ok_msg2') && $session->get('ok_msg2') != '')
{

	?>
	<script type='text/javascript'>
		dhtmlx.message.expire = 6000;
		dhtmlx.message({ type: 'warning', text: <?=$session->get('ok_msg2') ?>});
	</script>
	<?
	$session->del('ok_msg2');
}
}
}