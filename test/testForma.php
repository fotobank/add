<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 20.05.13
 * Time: 1:50
 * To change this template use File | Settings | File Templates.
 */

  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  //error_reporting(0);
  header('Content-type: text/html; charset=windows-1251');


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//RU" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:Логин="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>


  <link href="/css/main.css" rel="stylesheet" type="text/css"/>
  <script src="/js/jquery.js"></script>


  <script type="text/javascript" src="/js/ixedit/jquery/jquery-plus-jquery-ui.js"></script>
  <script type="text/javascript" src="/js/ixedit/ixedit/ixedit.packed.js"></script>
  <link rel="stylesheet" href="/js/ixedit/ixedit/ixedit.css" type="text/css" media="screen"/>
  <link rel="stylesheet" href="/js/ixedit/sample-style/ui-sui.css" type="text/css" media="screen"/>


</head>
<body>


  <div id="form_reg" style="position: relative;width:380px;height:510px;display: inline-block;">
	 <div id="pr_Form" style="position: relative; width: 350px;height: auto; left: 10px;">
		<form name="printMail" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Form1">

		  <label id="pr_Name1" style="position: relative; width: 114px; height: 14px; text-align: left; margin-top: 24px;float: left;" for="Combobox3">
			 <span style="color:#000000;font-family:Arial,serif;font-size:14px;float: left;">Способ оплаты:</span>
		  </label>
		  <select id="Combobox3" class="inp_f_reg" style="position: relative; width: 214px; float: right; margin-top: 20px;" size="1" name="Combobox3">
			 <?
			 foreach ($spOpl as $opl)
				{
				  ?>
				  <option value='<?= $opl ?>' <?=(
				  $opl ? 'selected="selected"' : '')?>><?=$opl?></option>
				<?
				}
			 ?>
		  </select>

		  <label for="Combobox1" id="pr_Name2" style="position:relative;width:114px;height:14px;text-align:left; margin-top: 25px;float: left;">
			 <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Доставка:</span></label>
		  <select name="Combobox1" class="inp_f_reg" size="1" id="Combobox1" style="position:relative;width:214px;float: right;">
			 <?
			 foreach ($spDost as $dost)
				{
				  ?>
				  <option value='<?= $dost ?>' <?=(
				  $dost ? 'selected="selected"' : '')?>><?=$dost?></option>
				<?
				}
			 ?>
		  </select>

		  <label id="pr_Name1" style="position: relative; width: 114px; height: 14px; text-align: left; margin-top: 25px;float: left;" for="Combobox32">
			 <span style="color:#000000;font-family:Arial,serif;font-size:14px;float: left;">Почта:</span>
		  </label>
		  <select id="Combobox32" class="inp_f_reg" style="position: relative; width: 214px; float: right;" size="1" name="Combobox32">
			 <?
			 foreach ($nm_pocta as $nPocta)
				{
				  ?>
				  <option value='<?= $nPocta ?>' <?=(
				  $nPocta ? 'selected="selected"' : '')?>><?=$nPocta?></option>
				<?
				}
			 ?>
		  </select>
		  <label id="pr_Name1" style="position: relative; width: 114px; height: 14px; text-align: left; margin-top: 25px;float: left;" for="Combobox31">
			 <span style="color:#000000;font-family:Arial,serif;font-size:14px;float: left;">Адрес студии:</span>
		  </label>
		  <select id="Combobox31" class="inp_f_reg" style="position: relative; width: 214px; float: right;" size="1" name="Combobox31">
			 <?
			 foreach ($adr_pecat as $aPecat)
				{
				  ?>
				  <option value='<?= $aPecat ?>' <?=(
				  $aPecat ? 'selected="selected"' : '')?>><?=$aPecat?></option>
				<?
				}
			 ?>
		  </select>

		  <label id="pr_Name3" style="position:relative;width:314px;height:14px;text-align:center;float:left;margin-left: 25px;"
			data-placement="right" title="Если получать заказ планируете не Вы, измените эти данные на данные Вашего представителя">
			 <span style="color:#000000;font-family:Arial,serif;font-size:16px;">Контактные данные получателя:</span></label>

		  <div id="pr_Clear1" style="clear: both;">
			 <label id="pr_Name4" style="position: relative; width: 120px; height: 28px; text-align: left; float: left; margin-top: 10px;" for="Editbox1">
				<span style="color:#000000;font-family:Arial,serif;font-size:14px;">Имя:</span> </label>
			 <input id="Editbox1" class="inp_f_reg" type="text" value="" name="Editbox1" style="position: relative; width: 200px; height: 23px; line-height: 23px;
							     float: right; margin-top: 10px;" data-placement="right" title="Имя получателя заказа">
		  </div>
		  <div id="pr_Clear2" style="clear: both;">
			 <label id="pr_Name5" style="position: relative; width: 120px; height: 28px; text-align: left; float: left;" for="Editbox2">
				<span style="color:#000000;font-family:Arial,serif;font-size:14px;">Фамилия:</span> </label>
			 <input id="Editbox2" class="inp_f_reg" type="text" value="" name="Editbox2"
			  style="position: relative; width: 200px; height: 23px; line-height: 23px;
							     float: right;"  data-placement="right" title="Фамилия получателя заказа">
		  </div>
		  <div id="pr_Clear3" style="clear: both;">
			 <label id="pr_Name6" style="position: relative; width: 120px; height: 28px; text-align: left; float: left;" for="Editbox3">
				<span style="color:#000000;font-family:Arial,serif;font-size:14px;">Телефон:</span> </label>
			 <input id="Editbox3" class="inp_f_reg" type="text" value="" name="Editbox3" style="position: relative;
							 width: 200px; height: 23px; line-height: 23px;float: right;" data-placement="right" title="Контактный телефон">
		  </div>

		  <div id="pr_Clear31" style="clear: both;">
			 <label id="pr_Name61" style="position: relative; width: 120px; height: 28px; text-align: left; float: left;" for="Editbox31">
				<span style="color:#000000;font-family:Arial,serif;font-size:14px;">E-mail:</span> </label>
			 <input id="Editbox31" class="inp_f_reg" type="text" value="" name="Editbox31" style="position: relative;
							 width: 200px; height: 23px; line-height: 23px;float: right;" data-placement="right" title="Почтовый ящик для подтверждения заказа">
		  </div>

		  <div id="pr_Clear4" style="clear: both;">
			 <label for="pr_adress" id="pr_Name7" style="position:relative;width:120px;height:52px;text-align:left;float: left; margin-top: 10px;">
				<span style="color:#000000;font-family:Arial,serif;font-size:14px;">Адрес почтового отделения </span><span style="color:#000000;font-family:Arial,serif;font-size:12px;">(или получателя если доставка на дом):</span></label>
			 <textarea id="pr_adress" cols="32" rows="5" style="position: relative; width: 205px; height: 80px; float: right; margin-top: 10px;"
			  name="pr_adress" data-original-title="" title="" >Почтовый индекс, страна, город, улица, дом, квартира.</textarea>
		  </div>

		  <div id="pr_Clear4" style="clear: both;">
			 <input id="Checkbox1" type="checkbox" style="float: left; margin: 15px 0 0 60px;" value="on" name="" data-original-title="" title="">
			 <label id="pr_Name3" for="Checkbox1">
				<a style="color: rgb(0, 0, 0); font-family: Arial,serif; font-size: 14px; float: right; width: 260px; margin-top: 10px; margin-left: 10px;">
				  Мне больше 18 лет</a>
			 </label>

			 <div id="pr_Clear4" style="clear: both;">
				<input id="Checkbox1" type="checkbox" style="float: left; margin: 15px 0 0 60px;" value="on" name="" data-original-title="" title="">
				<label id="pr_Name3" for="Checkbox1">
				  <a style="color: rgb(0, 0, 0); font-family: Arial,serif; font-size: 14px; float: right; width: 260px; margin-top: 10px; margin-left: 10px;">
					 С действующими на сайте правилами ознакомлен(на) и согласен(а)</a>
				</label>

			 </div>

			 <span id="iTogo" class="label label-important" style="position: relative; margin: 20px 0 20px 0;"></span><br>
			 <input class="metall_knopka" type="submit" style="position: relative; float: right;" value="Заказать" data-original-title="" title="">
		</form>
		<form action="basket.php" method="post" style="position:relative;">
		  <input type="hidden" name="go_print" value="1"/>
		  <input class="metall_knopka" type="submit"  value="Назад" data-original-title="" title="">
		</form>
	 </div>
  </div>
  </body>
</html>
<?