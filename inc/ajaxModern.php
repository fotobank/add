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
          $idImg = check_Session::getInstance()->get('idImg');


          $ini = go::has('md5_loader') ? NULL : array(
                 "pws"          => "Protected_Site_Sec", // секретная строка
                 //    "text_string"  => "ТЕСТ", // текст водяного знака
                 "vz"           => "img/vz.png", // картинка водяного знака
                 "vzm"          => "img/vzm.png", // multi картинка водяного знака
                 "font"         => "fonts/arialbd.ttf", // применяемый шрифт
                 "text_padding" => 10, // смещение от края
                 "hotspot"      => 2, // расположение текста в углах квадрата (1-9)
                 "font_size"    => 16, // размер шрифта водяного знака
                 "iv_len"       => 24, // сложность шифра
                 "rgbtext"      => "FFFFFF", // цвет текста
                 "rgbtsdw"      => "000000", // цвет тени
                 "process"      => "show=>security/protected.gif", // "jump=>security/protected.php"
                 // или картинка "jump=>security/protected.gif" - выводится при незаконной закачке
          );
          go::call('md5_loader', $ini);


          $imgData = array(
                 "referer" => $_SERVER['HTTP_REFERER'],
                 "query"   => $_POST['fotoId']
          );
          $idImg = go::call('md5_loader')->idImg($imgData);


    $rs = go\DB\query('select p.votes, p.price, a.vote_price from photos as p, albums as a where p.id = ?i and a.id = ?i',
                                                 array($idImg, $session->get('current_album')), 'assoc');

		echo json_encode(array('price' => $rs[0]['price'],'votpr' => floatval($rs[0]['vote_price']), 'votes' => $rs[0]['votes']));
	 }