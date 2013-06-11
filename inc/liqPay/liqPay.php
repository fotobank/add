<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 08.06.13
 * Time: 13:14
 * To change this template use File | Settings | File Templates.
 */


  ignore_user_abort(1);
  include (__DIR__.'/../head.php');
  require_once (__DIR__.'/../lib_ouf.php');
  require_once (__DIR__.'/../xmlArray.php');


  if (!isset($_SESSION['logged']))
	 {
		?>
		<div class="drop-shadow lifted" style="margin: 150px 0 0 290px;">
		  <div style="font-size: 24px;">Пополнение счета доступно только авторизованным пользователям!</div>
		  Зайдите на сайт под своим логином.
		</div>
	 <?
	 } else {
// запрос
  if(isset($_POST['LiqPay']))
	 {
		?>
		<script type="text/javascript">
		  $(function(){
			 $('#liqPayOrder').trigger('submit');
		  });
		</script>
		<?

		$merchant_id='i3213059147';
		$signature="JiKgSHyWrT7ljCbKeAXHbGK6RgAHTvaTvA";
		$url="https://www.liqpay.com/?do=clickNbuy";
		$method='';
		$phone='';
		$uah = floatval(GetFormValue($_POST['LiqPay']));
		$Description = 'photo';  // счет
		$userOrder = GetFormValue($_POST['userId'],'','',true);

		$xml="<request>
		 <version>1.2</version>
		 <result_url>http://".$_SERVER['HTTP_HOST']."/inc/liqPay/liqPayRet.php</result_url>
		 <server_url>http://".$_SERVER['HTTP_HOST']."/inc/liqPay/liqPayRet.php</server_url>
		 <merchant_id>$merchant_id</merchant_id>
		 <order_id>$userOrder</order_id>
		 <amount>$uah</amount>
		 <currency>UAH</currency>
		 <description>$Description</description>
		 <default_phone>$phone</default_phone>
		 <pay_way>$method</pay_way>
	  </request>
	  ";

		$xml_encoded = base64_encode($xml);
		$lqsignature = base64_encode(sha1($signature.$xml.$signature,1));

	?>
		<form id="liqPayOrder" action="<?= $url ?>" method="POST">
          <input type="hidden" name="operation_xml" value="<?= $xml_encoded ?>" />
          <input type="hidden" name="signature" value="<?= $lqsignature ?>" />
      </form>
	<?
	 }
  }


?>
  <div class="end_content"></div>
    </div>
<?php
    include (__DIR__.'/../footer.php');
?>