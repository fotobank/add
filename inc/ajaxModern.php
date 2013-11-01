<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 30.06.13
 * Time: 13:16
 * To change this template use File | Settings | File Templates.
 */

  header('Content-type: text/html; charset=windows-1251');

  require_once (__DIR__.'/config.php');
  require_once (__DIR__.'/func.php');




  if(isset($_POST['fotoId']))
	 {

          $imgData = array(
                 "referer" => $_SERVER['HTTP_REFERER'],
                 "query"   => $_POST['fotoId']
          );


                 go::call('md5_loader')->idImg($imgData);

//		$user_balans = go\DB\query('select balans from users where id = ?i',array($fotoBank->get('userid')),'el');

	//	$votpr = floatval(go\DB\query('select vote_price from albums where id = ?i', array($session->get('current_album')), 'el'));
	//	$rs = go\DB\query('select `votes`, `price` from `photos` where id = ?i', array($_POST['fotoId']), 'assoc');

    $rs = go\DB\query('select p.votes, p.price, a.vote_price from photos as p, albums as a where p.id = ?i and a.id = ?i',
                                                 array($_POST['fotoId'], $session->get('current_album')), 'assoc');

		echo json_encode(array('price' => $rs[0]['price'],'votpr' => floatval($rs[0]['vote_price']), 'votes' => $rs[0]['votes']));
	 }