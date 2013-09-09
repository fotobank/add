<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 30.06.13
 * Time: 13:16
 * To change this template use File | Settings | File Templates.
 */


  header('Content-type: text/html; charset=windows-1251');
  // обработка ошибок
	require_once (__DIR__.'/../classes/autoload.php');
	autoload::getInstance();


  $error_processor = Error_Processor::getInstance();
  require_once (__DIR__.'/config.php');
  require_once (__DIR__.'/func.php');

  $fotoBank = check_Session::getInstance();

  if(isset($_POST['fotoId']))  //
	 {

		$user_balans = $db->query('select balans from users where id = ?i',array($fotoBank->get('userid')),'el');
		$id_album = $fotoBank->get('current_album');
		$votpr = floatval($db->query('select vote_price from albums where id = ?i', array($id_album), 'el'));
		$rs = $db->query('select `votes`, `price` from `photos` where id = ?i', array($_POST['fotoId']), 'assoc');
		$price = $rs[0]['price'];
		$votes = $rs[0]['votes'];

		echo json_encode(array('price' => $price,'votpr' => $votpr, 'votes' => $votes));
	 }