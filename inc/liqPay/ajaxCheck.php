<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 10.06.13
 * Time: 18:41
 * To change this template use File | Settings | File Templates.
 * Просмотр статуса транзакции
 */

  header('Content-type: text/html; charset=windows-1251');
  set_time_limit(0);
  ini_set("display_errors","1");
  ignore_user_abort(1);
  require_once (__DIR__.'/../config.php');


  // парсинг xml
  function XMLfilter($rs, $tag) {
	 $rs = str_replace("\n", "", str_replace("\r", "", $rs));
	 $tags = '<'.$tag.'>';
	 $tage = '|</'.$tag;
	 $start = strpos($rs, $tags)+strlen($tags);
	 $end = strpos($rs, $tage);
	 return substr($rs, $start, ($end-$start));
  }


  if(isset($_POST['trId']))
	 {

		$rs = $db->query('SELECT `transaction_id`,`id`,`status`,`amount` FROM `account_inv` WHERE `id_user` = ?i  ORDER BY `id` DESC LIMIT 2',array($_SESSION['userid']),'assoc');

		$transaction_id = $rs[1]['transaction_id'];
		$transaction_order_id = $rs[1]['id'];
		$merchant_id='i3213059147';
		$signature="JiKgSHyWrT7ljCbKeAXHbGK6RgAHTvaTvA";
		$url="https://www.liqpay.com/?do=api_xml";

		// Просмотр последней транзакции:
		// transaction_id - более приоритетное поле
		// Order id - обрабатывается только если нет transaction_id
		$str = "<request>
						  <version>1.2</version>
						  <action>view_transaction</action>
						  <merchant_id>$merchant_id</merchant_id>
						  <transaction_id>$transaction_id</transaction_id>
						  <transaction_order_id>$transaction_order_id</transaction_order_id>
						  </request>";

		$xml_encoded = base64_encode($str);
		$lqsignature = base64_encode(sha1($signature.$str.$signature,1));

		$operation_envelop = '<operation_envelope>
											 <operation_xml>'.$xml_encoded.'</operation_xml>
											 <signature>'.$lqsignature.'</signature>
											 </operation_envelope>';

		$post = '<?xml version=\"1.0\" encoding=\"UTF-8\"?>
							 <request>
							 <liqpay>'.$operation_envelop.'</liqpay>
							 </request>';

		$url = "https://www.liqpay.com/?do=api_xml";
		$page = "/?do=api_xml";
		$headers = array("POST ".$page." HTTP/1.0",
							  "Content-type: text/xml;charset=\"utf-8\"",
							  "Accept: text/xml",
							  "Content-length: ".strlen($post));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec($ch);
		curl_close($ch);

		$xmlin = explode("<operation_xml>",$result);
		$xmlin = explode("</operation_xml>",$xmlin[1]);
		$xmlin = base64_decode($xmlin[0]);

		$status = XMLfilter($xmlin, 'status');
		$response_description = iconv('utf-8', 'windows-1251', XMLfilter($xmlin, 'response_description'));

		if ($status == "success" && $rs[1]['status'] != "success")
		  {
			 $user_balans = $db->query('select balans from users where id = ?i',array($_SESSION['userid']),'el');
			 $user_balans += floatval($rs[1]['amount']);
			 $db->query('update `users` set `balans` = ?f where `id` = ?i',array($user_balans, $_SESSION['userid']));
			 $db->query('update `account_inv` set `status` = ?string where `id` = ?i',array($status, $rs[1]['id']));
			 echo   "<script type='text/javascript'>
					 $('#balans').empty().append($user_balans);
					 </script>";
			 echo "Транзакция прошла успешно!<br> На ваш счет зачислено ".$rs[1]['amount']."гр.";
		  }elseif($status != "success" && $rs[1]['status'] != "success"){
		  echo $response_description;
		}else{
		  echo "Предыдущая транзакция прошла успешно!";
		}
	 }
