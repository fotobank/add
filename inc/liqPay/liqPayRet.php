<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 09.06.13
 * Time: 20:44
 * To change this template use File | Settings | File Templates.
 */

  ignore_user_abort(1);
  include (__DIR__.'/../head.php');


  if (!isset($_SESSION['logged']))
	 {
		?>
		<div class="drop-shadow lifted" style="margin: 150px 0 0 290px;">
		  <div style="font-size: 24px;">Пополнение счета доступно только авторизованным пользователям!</div>
		  Зайдите на сайт под своим логином.
		</div>
	 <?
	 } else {

// ответ
	 if(isset($_POST['signature']))
		{
		  $otvSig = trim($_POST['signature']);
		  $signature="JiKgSHyWrT7ljCbKeAXHbGK6RgAHTvaTvA";
		  $xml = trim($_POST['operation_xml']);
		  $xml_decoded=base64_decode($xml);
		  $objXML = new xml2Array();
		  $xmlArray = $objXML->parse($xml_decoded);
		  $sign=base64_encode(sha1($signature.$xml_decoded.$signature,1));
		  if($sign === $otvSig)
			 {
				if($xmlArray['status'] == "success")
				  {
					 ?>
					 <div class="drop-shadow lifted" style="margin: 150px 0 0 420px;">
						<div style="font-size: 24px;">Ваш счет пополнен на  <?=$xmlArray['amount']?>гр.</div>
						Транзакция прошла успешно.
					 </div>
					 <?
					 $user_balans += floatval($xmlArray['amount']);
					 $db->query('update users set balans = ?f where id = ?i',array($user_balans, $_SESSION['userid']));
					 echo   "<script type='text/javascript'>
					 $('#balans').empty().append($user_balans);
					 </script>";
				  } elseif($xmlArray['status'] == "wait_secure")
				  {
					 ?>
					 <div class="drop-shadow lifted" style="margin: 150px 0 0 420px;">
						<div style="font-size: 24px;">Платеж находится на проверке.</div>
						Транзакция проверяется банком.
					 </div>
				  <?
				  } elseif($xmlArray['status'] == "failure")
				  {
					 ?>
					 <div class="drop-shadow lifted" style="margin: 150px 0 0 490px;">
						<div style="font-size: 24px;">Неудачный платеж.</div>
						Транзакция отклонена банком.
					 </div>
				  <?
				  }  else {
				  ?>
				  <div class="drop-shadow lifted" style="margin: 150px 0 0 490px;">
					 <div style="font-size: 24px;">Статус транзакции: "<?=$xmlArray['status']?>" гр."</div>
				  </div>
				<?
				}
				$code = isset($xmlArray['code'])?$xmlArray['code']:"";
				$set = array(
				  'merchant_id' => $xmlArray['merchant_id'],
				  'amount' => $xmlArray['amount'],
				  'sys' => 'liqpay',
				  'currency' => $xmlArray['currency'],
				  'description' => $xmlArray['description'],
				  'status' => $xmlArray['status'],
				  'code' => $code,
				  'transaction_id' => $xmlArray['transaction_id'],
				  'pay_way' => $xmlArray['pay_way'],
				  'sender_phone' => $xmlArray['sender_phone'],
				);
				$id = $xmlArray['order_id'];
            $db->query('UPDATE `account_inv` SET ?set WHERE `id`=?i',array($set,$id));
			 }
		}
  }


?>
  <div class="end_content"></div>
  </div>
<?php
  include (__DIR__.'/../footer.php');
?>