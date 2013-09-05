<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 21.05.13
 * Time: 0:14
 * To change this template use File | Settings | File Templates.
 */
  header('Content-type: text/html; charset=windows-1251');
  // обработка ошибок
	include_once (__DIR__.'/../classes/autoload.php');
	autoload::getInstance();


  $error_processor = Error_Processor::getInstance();
  include (dirname(__FILE__).'/config.php');
  include (dirname(__FILE__).'/func.php');


  if(isset($_POST['album']))  //подписка на сообщение о готовности альбома
	 {
      $userId = isset($_SESSION['userid'])?$_SESSION['userid']:false;
		$album = $_POST['album'];
		if($userId)
		  {
      $rs = $db->query('select `user_event` from `actions` where `id_user` = ?i and `id_album` = ?i and `user_event` = ?i order by `time_event` asc limit 1',
		  array($userId,$album,3),'el');
		if($rs && $rs == 'подписка')
		  {
			 echo "<div class='drop-shadow lifted' style='margin: 0 0 0 310px;width: 210px'><div style='font-size: 14px;'>Вы уже подписаны на этот альбом</div></div>";
		  } else {
		  $rs = $db->query('INSERT INTO `actions` (`ip`,`id_user`,`user_event`,`id_album`,`brauzer`) VALUES (?string,?i,?i,?i,?string)',
			 array(Get_IP(),$userId,3,$album,$_SERVER['HTTP_USER_AGENT']));
		  echo "<div class='drop-shadow lifted' style='margin: 0 0 0 340px;width: 150px'><div style='font-size: 14px;'>Вы успешно подписаны</div></div>";
		}
		  } else {
		  echo "<div class='drop-shadow lifted' style='margin: 0 0 0 210px;width: 390px'><div style='font-size: 14px;'>Подписка доступна только зарегистрированным пользователям!</div></div>";
		}
	 }