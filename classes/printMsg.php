<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 08.09.13
 * Time: 20:15
 * To change this template use File | Settings | File Templates.
 *
 * ��������� �� ������
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
			dhtmlx.message.expire = 6000; // ����� ����� ���������
			dhtmlx.message({ type: 'error', text: '������!<br><?=$session->get('err_msg')?>'});
			<!--			humane.error('������!<br>--><?//=$session->get('err_msg')?><!--')-->
		</script>
		<?
		$session->del('err_msg');
	}

	// <!-- ��������� � ������� ����������-->
	if ($session->has('ok_msg') && $session->get('ok_msg') != '')
	{

		?>
		<script type='text/javascript'>
			humane.success("����� ����������, <?=$session->get('us_name')?>!<br><span><?=$session->get('ok_msg')?></span>");
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