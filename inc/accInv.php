<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 09.06.13
 * Time: 0:22
 * To change this template use File | Settings | File Templates.
 */

header('Content-type: text/html; charset=windows-1251');
//set_time_limit(0);

       chdir(__DIR__.'/../');
require_once __DIR__.'/../alex/fotobank/Framework/Boot/config.php';


if ($link->referralSeed) {
if($link->check($_SERVER['SCRIPT_NAME'].'?go='.trim(isset($_GET['go'])?$_GET['go']:''))){
  // проверка кода
  //	print "<br>checked link: ${_SERVER['REQUEST_URI']}<br />\n";

if (!isset($_SESSION['logged']))
  {
	 ?>
	 <div class="drop-shadow lifted" style="margin: 150px 0 0 290px;" xmlns="http://www.w3.org/1999/html">
		<div style="font-size: 24px;">Пополнение счета доступно только авторизованным пользователям!</div>
		Зайдите на сайт под своим логином.
	 </div>
  <?
  } else {
  $rs = go\DB\query('SELECT `transaction_id`,`id`,`status` FROM `account_inv` WHERE `id_user` = ?i  ORDER BY `id` DESC LIMIT 2',array($_SESSION['userid']),'assoc');

  $id = ($rs)?$rs[0]['id']:false;
  if($rs && $rs[0]['status'] != '' || $id == false)
	 {
  // чистка базы от невыполненных запросов
  /*go\DB\query('DELETE account_inv, actions
				  FROM account_inv, actions
				  WHERE account_inv.status = (?string)
				  AND  account_inv.id_user = ?i
				  AND actions.id_account_inv = account_inv.id
				  ',array('',$_SESSION['userid']));*/

  // id пополнения счета
	 $id = go\DB\query('INSERT INTO `account_inv` (`id_user`) VALUES (?i)',array($_SESSION['userid']),'id');
	 go\DB\query('INSERT INTO `actions` (`ip`,`id_user`,`user_event`,`id_account_inv`,`brauzer`)
	 VALUES (?string ,?i, ?string, ?i,?string)',array(Get_IP(),$_SESSION['userid'],'пополнение счета',$id,$_SERVER['HTTP_USER_AGENT']),'id');
	 }
?>
<script type="text/javascript">
  function mailOrder() {
	 var pA, pB, pC, pD, pE, pF;
	 pA = '<a style="color: #000000;" href='+'"mai';
	 pB = 'aleksjurii';
	 pC = '">';
	 pA += 'lto:';
	 pB += '@';
	 pE = '</a>';
	 pF = '(нажмите сюда)';
	 pB += 'gmail.com';
	 pD = pF;
	 $('#eMail').empty().append(pA + pB + pC + pD + pE);
  }
</script>


<div id="order">
<div class="modal-header" style="background: rgba(229,229,229,0.53);">
  <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
  <div id="list-c"class="cont-list" style="position: relative; width: 80%; margin-left: 25%;">
	 <div class="drop-shadow curved curved-vt-2">
		<h3><span style="color: #000000; font-size: 24px;">Пополнение счета <span style="padding-left: 10px;font-family: Times New Roman, serif; font-style: italic;
		 font-size: 20px;"> аккаунта <span style="padding-left: 10px; font-size: 24px;"><?=$_SESSION['us_name']?></span></h3>
	 </div></div>
  <div style="clear: both"></div><br>
</div>
<div class="modal-body">
<span style="font-size: 18px;">Выбор способа оплаты:</span>
<p style="float: right;margin-right: 60px;">Номер заказа:  <?=$id?></p>


<!--	  www.liqpay.com-->
<!--	   необязательный параметр 'dcur' отвечает за валюту выбранную у клиента по-умолчанию-->
<!-- <form action="https://www.liqpay.com/">
	 <input type=hidden name="do" value="clickNbuy">
	 <input type=hidden name="button" value="i3213059147"><input type=submit value="пополнить">
  </form>-->




<hr style="border: none; background-color: #61cdf2;color: red; height: 1px;">
<!--  LiqPay-->
  <form action='/inc/liqPay/liqPay.php' method='POST'>
<table style=" margin: 30px 0 0 0" border="0">
  <tbody>
  <tr>
	 <td>1.<span style="font-weight: bold; margin: 10px;">ПриватБанк LiqPAY:</span></td>
	 <td colspan="3" style="padding-left: 10px;width: 270px;">Visa/MasterCard или счета LiqPAY</td>
	 <td rowspan="3" style="width: 400px;"><p style="padding-left:  20px; font-size: 12px">Автоматичесская система оплаты c быстрым переводом и зачислением денег.
		  Приём платежей по кредитным картам Visa и Master Card. Верификация платежей происходит через мобильный телефон. Минимальная сумма перевода - 2 копейки.</p>
	 <p style="padding-left:  20px; margin-top: -10px; font-size: 12px">Введите необходимую сумму и нажмите на значек "LIQPAY>>"</p>
	 </td>
  </tr>
  <tr>
	 <td class="t1">&nbsp;</td>
	 <td></td>
	 <td></td>
  </tr>
  <tr>
	 <td style="padding-left:  55px;">Сумма (гр.):</td>
	 <td><div class="control-group success">
		  <label class="control-label" for="inputSuccess"></label>
		  <div class="controls">
		  <input id="inputSuccess" class="autoclear" type="text" value="" name="LiqPay" onkeyup="parseField(this.name)"
			style="margin-left: 10px; width: 150px; margin-bottom: -5px;" data-original-title="" title="">
		  <input type="hidden" value="<?=$id?>" name="userId" style="margin-left: 10px; width: 150px; margin-bottom: -5px;" data-original-title="" title="">
		  </div>
		</div>
	 </td>
	 <td style="padding-left:10px;padding-top:15px;text-align:right">
		<input type="image" value="пополнить" src="https://www.liqpay.com/cnb/img/logo.png" style="width: 100px; margin-top: -15px;">
		</td>
  </tr>
  </tbody>
</table>
  </form>

  <?
  $pods = '';
  if(isset($rs[1]) && $rs[1]['status'] == 'wait_secure')
	 {
   $pods = "<span style='font-size: 12px;'> Статус предыдущей транзакции: `проверяется банком`. Нажмите для обновления. Деньги будут зачислены сразу после проверки банком.</span>";
	 } else {
	 $pods = "<span style='font-size: 12px;'> Проверка платежа.</span>";
  }
  ?>
<!--   кнопка проверки транзакции-->
		<span style="float: left; margin-left: 210px; font-size: 12px;">Ваша последняя транзакция: </span>
		<button class="btn" name="checkPay" style="float: left; margin: -5px 40px 25px 20px; "
		 onClick="ajaxPostQ('/inc/liqPay/ajaxCheck.php','#checkOut','trId='+true)">Проверить</button>
		<span id="checkOut" style="position: relative;"><?=$pods?></span>






<hr style="border: none; background-color: #61cdf2;color: red; height: 1px; clear: both;">
<!--	  easypay.ua-->
  <?
  $easyPay = 'https://merchant.easypay.ua/client/order';
  ?>
  <script type="text/javascript">
	 mailOrder();
  </script>
<form action="<?=$easyPay?>" method="post">
  <div class="block-editor">
	 <table style="margin: 30px 0 0 0" border="0">
		<tbody><tr>
		  <td class="t1">2.<span style="font-weight: bold; margin-left: 10px; margin-right: 35px;">Система easypay:</span></td>
		  <td colspan="3" style="padding-left: 10px;width: 270px;">Visa/MasterCard, кошелек easypay или через терминал
			 <input id="merchant_id" name="merchant_id" type="hidden" value="81cc65154f3841158366234538e0049b"></td>
		  <td rowspan="3" style="width: 400px;"><p style="padding-left: 20px; font-size: 12px">Быстрый и качественный сервис.
				Возможна оплата без регистрации. Банк берет небольшой процент за перевод, который необходимо учитывать при оплате.
				Минимальная сумма перевода - 5 гривень. После оплаты пришлите, пожалуйста, на e-mail:<span id="eMail"></span>
				сообщение, в котором укажите свой логин, номер заказа (указан в правом верхнем углу формы), сумму перевода и дату и время оплаты.
				Деньги будут зачислены на Ваш счет сразу после проверки. </p>
			 <p style="padding-left:  20px; margin-top: -10px; font-size: 12px">Введите необходимую сумму и нажмите на значек "easypay"</p>
		  </td>
		</tr>
		<tr>
		  <td class="t1">&nbsp;</td>
		  <td></td>
		  <td></td>
		</tr>
		<tr>
		  <td style="padding-left:  55px;">Сумма (гр.):</td>
		  <td><div class="control-group success">
			 <label for="amount"></label><input id="amount" class="autoclear" type="text" onkeyup="parseField(this.name)"
				 style="margin-left: 10px; width: 150px; margin-bottom: -10px;" value="" name="amount" data-original-title="" title="">
			 <input type="hidden" id="orderId" name="orderId" type="text" value="">
			 <input type="hidden" id="desc" name="desc" type="text"
			  value="<?=iconv ('windows-1251', 'utf-8', 'Пополнение счета пользователя '.$_SESSION['us_name'].' на сайте '.$_SERVER['SERVER_NAME'])?>">
			 </div>
		  </td>
		  <td style="text-align:right;">
			 <input type="image" value="Оплатить" src="https://merchant.easypay.ua/content/images/easypay_pay2.png" style="width: 100px; margin-left: 10px; margin-bottom: -5px;">
		</tr>
		</tbody></table>
  </div>
</form>


<hr style="border: none; background-color: #61cdf2;color: red; height: 1px;">
<!--carta-->
<table style="margin: 30px 0 0 0" border="0">
  <tbody><tr>
	 <td class="t1">3.<span style="font-weight: bold; margin-left: 10px; margin-right: 55px;">Перевод на карту<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ПриватБанка:</span></td>
	 <td colspan="2" style="padding-left: 10px;width: 290px;">На Ваш E-mail будут высланы<br> реквизиты для перевода необходимой<br> суммы</td>
	 <td style="width: 400px;"><p style="padding-left:  24px; font-size: 12px">Инструкция будет выслана Вам в письме.
		  Перевод в отделении ПриватБанка или через терминал без банковских процентов.</p></td>
  </tr>
  <tr>
	 <td></td>
	 <td>
		 <p style="padding-left: 10px; margin-top: 10px;">Выслать реквизиты:</p>
		 <p style="padding-left: 10px; margin-top: 10px;"><i>нажмите на рисунок карточки --></i></p>
	 </td>
	 <td style="text-align:right;">
		<input type="image" value="Выслать" src="/img/rekvizity-privat-kart.jpg"
		 onClick="ajaxPostQ('/inc/privat/ajaxPrivatMail.php','#rekMail','prMail='+true)"
		style="width: 100px; margin-left: 20px;">
	 </td>
	 <td><p id='rekMail' style="padding-left: 24px; font-size: 12px">Для получения счета нажмите на значек визитной карточки. Если в течении 10 минут Вы не получите
	                                                                 письмо, проверьте ящик спама.</p></td>
  </tr>
  </tbody></table>

<!--<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
	<input type="hidden" name="LMI_PAYMENT_NO" value="1">
	<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="0.05">
	<input type="hidden" name="LMI_PAYMENT_DESC" value="код пополнения Super Mobile">
	<input type="hidden" name="LMI_PAYEE_PURSE" value="Z155771820786">
	<input type="hidden" name="id" value="345">
	Укажите email для обратной связи: <input type="text" name="email" size="15">
	<input type="submit" value="Перейти к оплате">
</form>-->
<!--		http://owebmoney.ru/merchant.shtml - инструкция -->

<?
  /* ini_set('display_errors','On');
  $mId='i3213059147';//идентификатор мечанта
  $merch_sign='JiKgSHyWrT7ljCbKeAXHbGK6RgAHTvaTvA';//подпись мерчанта для операций

  $xml='<request>';
	 $xml.='<action>obilling_test_api</action>';
	 $xml.="<merchant_id>$mId</merchant_id>";
	 $xml.='<version>1.2</version>';
	 $xml.='</request>';
  $sign=base64_encode(sha1($merch_sign.$xml.$merch_sign,1));
  $operationXmlEncoded=base64_encode($xml);
  $requestXml="<?xml version='1.0' encoding='UTF-8' ?><request><liqpay><operation_envelope><operation_xml>$operationXmlEncoded</operation_xml><signature>$sign</signature></operation_envelope></liqpay></request>";
  $response="";
  if ($fp = fsockopen ("ssl://www.liqpay.com", 443, $errno, $errstr, 30))
  {
  $request ="POST /?do=open_billing HTTP/1.0\r\n";
  $request.="Host: www.liqpay.com\r\n";
  $request.="Content-Type: text/xml \r\n";
  $request.="Expect: \r\n";
  $request.="Content-Length: ".strlen($requestXml)."\r\n";
  $request.="\r\n";
  $request.="$requestXml";

  fwrite($fp,$request,strlen($request));

  while (!feof($fp))
  $response.=fread($fp,8192);

  fclose($fp);
  }
  else die('Could not open socket');
  echo "<pre>\n";
  $response = substr($response, strpos( $response,"<" ));
  $mxml = simplexml_load_string($response);
  $decoded= base64_decode( $mxml->operation_xml );
  echo $decoded;
  echo "</pre>\n";*/
?>
</div>
<div class="modal-footer">
  <a class="btn btn-primary" data-dismiss="modal">Закрыть</a>
</div>
</div>

  <script type='text/javascript'>
	 function parseField(id){
		var obj = '[name="'+id+'"]';
		var str = new String(jQuery(obj).val());
		if(str.match(/[^0-9]+/gi)){

		  jQuery(obj).css({'border-color':'#980000','background-color':'#EDCECE'});
		  jQuery(obj).val(str.replace(/[^0-9]+/gi,''));

		  setTimeout(function(){jQuery(obj).css({'border-color':'#85BFF2','background-color':'#FFFFFF'});},1000)
		}
	 }
  </script>

<?
}
}else{
  //	print "<br>link invalid: ${_SERVER['REQUEST_URI']} \n";
  include (__DIR__.'/../error_.php');
}
}  else include (__DIR__.'/../error_.php');
