<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 21.05.13
 * Time: 0:14
 * To change this template use File | Settings | File Templates.
 */
  header('Content-type: text/html; charset=windows-1251');

  require_once (__DIR__.'/config.php');
		 // ��������� ������
		 $error_processor = Error_Processor::getInstance();
  require_once (__DIR__.'/func.php');


  if(isset($_POST['album']))  //�������� �� ��������� � ���������� �������
	 {

		$userId =	$session -> get('userid');
		$album = trim($_POST['album']);

		if($userId)
		  {
      $rs = go\DB\query('select `user_event` from `actions` where `id_user` = ?i and `id_album` = ?i and `user_event` = ?i order by `time_event` asc limit 1',
		  array($userId,$album,3),'el');
		if($rs && $rs == '��������')
		  {
			 echo "<div class='drop-shadow lifted' style='margin: 0 0 0 310px;width: 210px'><div style='font-size: 14px;'>�� ��� ��������� �� ���� ������</div></div>";
		  } else {
		  $rs = go\DB\query('INSERT INTO `actions` (`ip`,`id_user`,`user_event`,`id_album`,`brauzer`) VALUES (?string,?i,?i,?i,?string)',
			 array(Get_IP(),$userId,3,$album,$_SERVER['HTTP_USER_AGENT']));
		  echo "<div class='drop-shadow lifted' style='margin: 0 0 0 340px;width: 150px'><div style='font-size: 14px;'>�� ������� ���������</div></div>";
		}
		  } else
		{
		  echo "<div class='drop-shadow lifted' style='margin: 0 0 0 210px;width: 390px'>
		        <div style='font-size: 14px;'>�������� �������� ������ ������������������ �������������!</div></div>";
		}
	 }