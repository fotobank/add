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
                 "pws"          => "Protected_Site_Sec", // ��������� ������
                 //    "text_string"  => "����", // ����� �������� �����
                 "vz"           => "img/vz.png", // �������� �������� �����
                 "vzm"          => "img/vzm.png", // multi �������� �������� �����
                 "font"         => "fonts/arialbd.ttf", // ����������� �����
                 "text_padding" => 10, // �������� �� ����
                 "hotspot"      => 2, // ������������ ������ � ����� �������� (1-9)
                 "font_size"    => 16, // ������ ������ �������� �����
                 "iv_len"       => 24, // ��������� �����
                 "rgbtext"      => "FFFFFF", // ���� ������
                 "rgbtsdw"      => "000000", // ���� ����
                 "process"      => "show=>security/protected.gif", // "jump=>security/protected.php"
                 // ��� �������� "jump=>security/protected.gif" - ��������� ��� ���������� �������
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