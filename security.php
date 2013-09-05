<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 16.06.13
 * Time: 17:35
 * To change this template use File | Settings | File Templates.
 */

	require_once (__DIR__.'/classes/autoload.php');
	autoload::getInstance();


   error_reporting(E_ALL);
   ini_set('display_errors', 1);
  // error_reporting(0);
  require_once (__DIR__.'/inc/config.php');
  require_once (__DIR__.'/inc/func.php');



  $link=new link_Obfuscator($_SESSION['referralSeed']);
  // print "actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
  $_SESSION['referralSeed']=$link->seed;



  if(!isset($_GET['key']) and !isset($_GET['user']) and !isset($_GET['acc']) and !isset($_POST['idZakaz']))
	 err_exit('������������ ����!');

  if(!isset($_SESSION['logged']) and (!isset($_POST['idZakaz'])))  // ��������� �������� ������ �� idZakaz
	 err_exit('������� ���� ����� � ������. �������� ������ �� ������ �������� ��������!');

  // ������� �� FTP ����� ������
  if(isset($_POST['idZakaz'])) {
  
    $_SESSION['referralSeed']=$link->seed;
	 $newLink= '/inc/sobrZakaz.php';
	 $idZakaz = trim($_POST['idZakaz']);
	 $newLinkObscured=$link->obfuscate(preg_replace('/(&|\?)go=(\w)+/','',$newLink));
	 // echo $newLinkObscured."<br>";
	 main_redir($newLinkObscured.'&idZakaz='.$idZakaz);

  }

// �����  ������
if(isset($_GET['key'])) {

  $_SESSION['referralSeed']=$link->seed;
  $newLink= '/printZakaz.php';
  $key = trim($_GET['key']);
  $newLinkObscured=$link->obfuscate(preg_replace('/(&|\?)go=(\w)+/','',$newLink));
  main_redir($newLinkObscured.'&key='.$key);

}

// �������� ������������
  if(isset($_GET['user']) and $_GET['user'] == $_SESSION['userVer']) {
  
    $_SESSION['referralSeed']=$link->seed;
	 $newLink= '/core/users/page.php';
	 $newLinkObscured=$link->obfuscate(preg_replace('/(&|\?)go=(\w)+/','',$newLink));
	 unset($_SESSION['userVer']);
	 unset($_GET['user']);
	 main_redir($newLinkObscured);

  }

// ���������� �����
  if(isset($_GET['acc']) and $_GET['acc'] == $_SESSION['accVer']) {
  
    $_SESSION['referralSeed']=$link->seed;
	 $newLink= '/inc/accInv.php';
	 $newLinkObscured=$link->obfuscate(preg_replace('/(&|\?)go=(\w)+/','',$newLink));
	 unset($_GET['acc']);
	 main_redir($newLinkObscured);

  }

  err_exit('���� �� �������� �� ��������. ����������� ��� ��������� ������ ��������, �������������� �� ��������������� ���������.');
