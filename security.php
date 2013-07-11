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
  include (__DIR__.'/inc/lib_ouf.php');
  include (__DIR__.'/inc/lib_errors.php');
  require_once (__DIR__.'/core/debug/PHPDebug.php');
  $PHPDebug = new PHPDebug();


  $error_processor = Error_Processor::getInstance();


  $link=new linkObfuscator($_SESSION['referralSeed']);
  // print "actual referral Seed:". $_SESSION['referralSeed'] ."<br />\n";
  $_SESSION['referralSeed']=$link->seed;
  ($PHPDebug)?$PHPDebug->debug("referralSeed: ", $_SESSION['referralSeed']):null;


  if(!isset($_GET['key']) and !isset($_GET['user']) and !isset($_GET['acc']) and !isset($_POST['idZakaz']))
	 err_exit('Ќеправильный вход!');

  if(!isset($_SESSION['logged']) and (!isset($_POST['idZakaz'])))  // разрешить гостевой допуск по idZakaz
	 err_exit('¬ведите свой логин и пароль. √остевой доступ на данную страницу запрещен!');

  // собрать на FTP заказ печати
  if(isset($_POST['idZakaz'])) {
  
    $_SESSION['referralSeed']=$link->seed;
	 $newLink= '/inc/sobrZakaz.php';
	 $idZakaz = trim($_POST['idZakaz']);
	 $newLinkObscured=$link->obfuscate(preg_replace('/(&|\?)go=(\w)+/','',$newLink));
	 // echo $newLinkObscured."<br>";
	 main_redir($newLinkObscured.'&idZakaz='.$idZakaz);

  }

// заказ  печати
if(isset($_GET['key'])) {

  $_SESSION['referralSeed']=$link->seed;
  $newLink= '/printZakaz.php';
  $key = trim($_GET['key']);
  $newLinkObscured=$link->obfuscate(preg_replace('/(&|\?)go=(\w)+/','',$newLink));
  ($PHPDebug)?$PHPDebug->debug("key: ", $_GET['key']):null;
  ($PHPDebug)?$PHPDebug->debug("newLinkObscured: ", $newLinkObscured):null;
  main_redir($newLinkObscured.'&key='.$key);

}

// страница пользовател€
  if(isset($_GET['user']) and $_GET['user'] == $_SESSION['userVer']) {
  
    $_SESSION['referralSeed']=$link->seed;
	 $newLink= '/core/users/page.php';
	 $newLinkObscured=$link->obfuscate(preg_replace('/(&|\?)go=(\w)+/','',$newLink));
	 unset($_SESSION['userVer']);
	 unset($_GET['user']);
	 main_redir($newLinkObscured);

  }

// пополнение счета
  if(isset($_GET['acc']) and $_GET['acc'] == $_SESSION['accVer']) {
  
    $_SESSION['referralSeed']=$link->seed;
	 $newLink= '/inc/accInv.php';
	 $newLinkObscured=$link->obfuscate(preg_replace('/(&|\?)go=(\w)+/','',$newLink));
	 unset($_GET['acc']);
	 main_redir($newLinkObscured);

  }

  err_exit('¬ход на страницу не выполнен. ѕользуйтесь дл€ навигации только кнопками, расположенными на соответствующих страницах.');
