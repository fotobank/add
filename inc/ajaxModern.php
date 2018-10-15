<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 30.06.13
 * Time: 13:16
 * To change this template use File | Settings | File Templates.
 */

  header('Content-type: text/html; charset=windows-1251');

  require_once __DIR__.'/config.php';
  require_once __DIR__.'/func.php';

  if(isset($_POST['fotoId']))
	 {
          include __DIR__.'./../classes/md5/md5_ini.php';
          /*$ini =  array(
                 "pws"          => "Protected_Site_Sec", // секретная строка
                 "iv_len"       => 24, // сложность шифра
          );*/
          $idImg = go::call('md5_loader', $ini)->idImg(array('query' => $_POST['fotoId']));
          // передать через сессию
          //$idImg = check_Session::getInstance()->get('idImg');
          $rs = go\DB\query('select p.votes, p.price, a.vote_price from photos as p, albums as a where p.id = ?i and a.id = ?i',
                                                 array($idImg, $session->get('current_album')), 'assoc');

		echo json_encode(array('price' => $rs[0]['price'], 'votpr' => (float)$rs[0]['vote_price'], 'votes' => $rs[0]['votes']));
	 }
