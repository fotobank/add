<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 07.06.13
 * Time: 20:16
 * To change this template use File | Settings | File Templates.
 */



    //http://www.nanolink.ca/pub/sha256/sha256.inc.txt
	require_once("sha256.inc.php");

	function hextostr($x) {
	  $s='';
	  foreach(explode("\n",trim(chunk_split($x,2))) as $h) $s.=chr(hexdec($h));
	  return($s);
	}

	function strtohex($x) {
	  $s='';
	  foreach(str_split($x) as $c) $s.=sprintf("%02X",ord($c));
	  return($s);
	}

	$secret_key = "de328f55c9c44d5b871aa78efbcd830b"; //Your secret key

	$string_to_hash = $_POST['merchant_id'].";".
	 $_POST['order_id'].";".
	 $_POST['payment_id'].";".
	 $_POST['desc'].";".
	 $_POST['payment_type'].";".
	 $_POST['amount'].";".
	 $_POST['commission'].";".$secret_key;

	$sign = $_POST['sign'];

	//Return 0 - if sign is valid, if else - invalid
	function VerifySign($source_message, $sign){
	  $sign = strtohex(base64_decode(rawurldecode($sign)));

	  //For (PHP 4, 5)
	  $obj = new nanoSha2();
	  $sha_str = $obj->hash($source_message, false);

	  //For (PHP 5 >= 5.1.2, PECL hash >= 1.1)
	  //$sha_str = hash('sha256', $source_message, false);
	  return strcmp(strtolower($sign), $sha_str);
	}
?>