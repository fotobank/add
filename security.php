<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 16.06.13
 * Time: 17:35
 * To change this template use File | Settings | File Templates.
 */

   error_reporting(E_ALL);
   ini_set('display_errors', 1);
  // error_reporting(0);
  require_once (__DIR__.'/inc/config.php');
  require_once (__DIR__.'/inc/func.php');


  //  $link=new linkObfuscator($_SESSION['referralSeed']);
  // print "actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
  $_SESSION['referralSeed']=$link->seed;


  if(!isset($_GET['key']) and !isset($_POST['idZakaz']))
	 err_exit('Ключ не найден!', 'index.php');

  if(isset($_POST['idZakaz'])) {

	 $newLink= '/inc/sobrZakaz.php';
	 $idZakaz = trim($_POST['idZakaz']);
	 $newLinkObscured=$link->obfuscate(preg_replace('/(&|\?)go=(\w)+/','',$newLink));
	 // echo $newLinkObscured."<br>";
	 header('location: '.$newLinkObscured.'&idZakaz='.$idZakaz);

  }

  if(!isset($_SESSION['logged']))
	 err_exit('Введите свой логин и пароль. Гостевой доступ на данную страницу запрещен!', 'index.php');

if(isset($_GET['key'])) {

  $newLink= '/printZakaz.php';
  $key = trim($_GET['key']);
  $newLinkObscured=$link->obfuscate(preg_replace('/(&|\?)go=(\w)+/','',$newLink));
 // echo $newLinkObscured."<br>";
  header('location: '.$newLinkObscured.'&key='.$key);
}

