<?php
  include (dirname(__FILE__).'/inc/head.php');
  if (!isset($_SESSION['logged']))
	 {
		?>
		<div class="drop-shadow lifted" style="margin: 150px 0 0 290px;" xmlns="http://www.w3.org/1999/html">
		  <div style="font-size: 24px;">Корзина доступна только авторизованным пользователям!</div>
		  Зайдите на сайт под своим логином.
		</div>
	 <?
	 }
  else
	 {
		if (isset($_POST['go_back']))
		  {
			 $_SESSION['print'] = 1;
		  }
		if (isset($_POST['go_order']) && isset($_SESSION['basket']) && is_array($_SESSION['basket'])
		 && count($_SESSION['basket']) > 0
		)
		  {
			 $mysqlErrno = 0;
			 $id_order   = 0;
			 try
				{
				  $id_order = $db->query('insert into orders (id_user, dt) values (?i,?i)',
					 array($_SESSION['userid'], time()),
					 'id');
				}
			 catch (go\DB\Exceptions\Query $e)
				{
				  trigger_error("
			                  'SQL-query: ".$e->getQuery()."\n'
                           'Error description: ".$e->getError()."\n'
                           'Error code: ".$e->getErrorCode()."\n'
		       ");
				  $mysqlErrno = 1;
				}
			 if ($mysqlErrno == 0)
				{
				  $order = iTogo();
				  if ($order['price'] > $user_balans)
					 {
						$_SESSION['order_msg']
						 = 'Недостаточно средств на балансе!<br> Пополните счет или закажите печать наложенным платежем.';
						$db->query('delete from orders where id = ?i', array($id_order));
					 }
				  else
					 {
						$tm           = time();
						$download_ids = array();
						$id_user      = intval($_SESSION['userid']);
						foreach ($_SESSION['basket'] as $ind => $val)
						  {
							 $id_item = $db->query('insert into order_items (id_order, id_photo) values (?i,?i)',array($id_order, $ind),'id');
							 $key               = md5($id_item.$tm.$id_order.mt_rand(1, 10000));
							 $id                = intval($db->query('insert into download_photo (id_user, id_order, id_order_item, id_photo, dt_start, download_key)
                                values (?i,?i,?i,?i,?i,?string)',
								array($id_user, $id_order, $id_item, $ind, $tm, $key),
								'id'));
							 $download_ids[$id] = $key;
						  }
						$user_data = $db->query('select * from users where id = ?i', array($id_user), 'row');
						$title     = 'Фотографии Creative line studio';
						$headers   = "Content-type: text/plain; charset=windows-1251\r\n";
						$headers .= "From: Администрация Creative line studio \r\n";
						$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
						$letter  = "Здравствуйте, $user_data[us_name]!\r\n";
						$letter .= "Вам предоставлен доступ для скачивания следующих фото:.\r\n\r\n";
						foreach ($download_ids as $ind => $val)
						  {
							 $letter .= 'http://'.$_SERVER['HTTP_HOST']."/download.php?key=$val\r\n";
						  }
						$letter .= "\r\nВНИМАНИЕ! Для скачивания фотографий сначала нужно залогиниться на сайте! Ссылки действительны 48 часов!\r\n";
						// Отправляем письмо
						if (!mail($user_data['email'], $subject, $letter, $headers))
						  {
							 $db->query('delete from orders where id = ?i', array($id_order));
							 $db->query('delete from order_items where id_order = ?i', array($id_order));
							 $db->query('delete from download_photo where id_order = ?i', array($id_order));
							 $_SESSION['order_msg']
							  = 'Ошибка отправки письма со ссылками! Возможно сайт перегружен. Пожалуйста, зайдите позже.';
							 trigger_error("Ошибка отправки письма со ссылками!");
						  }
						else
						  {
							 $_SESSION['basket'] = array();
							 $_SESSION['order_msg']
														= 'Заказ оплачен! Вам на E-mail отправлено письмо со списком ссылок для скачивания фото!';
							 $db->query('update users set balans = balans - ?f where id = ?i',
								array($order['price'], $id_user));
							 trigger_error("Произведена покупка фотографий!");
						  }
						?>
						<script type="text/javascript">
						  location.replace("basket.php?1=1");
						</script>
					 <?
					 }
				}
		  }
		$_SESSION['print'] = 0;
		?>
		<div id="main">
		<?
		if (isset($_POST['go_print']) && count($_SESSION['basket']) > 0)
		  {
			 $_SESSION['print'] = 1;
		  }

		if (isset($_POST['mat_gl']) && count($_SESSION['basket']) > 0)
		  {
			 $_SESSION['print']            = 2;
			 $_SESSION['basket']['ramka']  = trim($_POST['ramka']);
			 $_SESSION['basket']['mat_gl'] = trim($_POST['mat_gl']);
			 $_SESSION['basket']['format'] = trim($_POST['format']);
		  }

		if (isset($_POST['go_mail']) && count($_SESSION['basket']) > 0)
		  {
			 $_SESSION['print'] = 3;
		  }


		if (isset($_SESSION['order_msg2']))
		  {
			 ?>
			 <div style="position: relative">
				<div style="margin-top: 50px; margin-left: 150px;" class="drop-shadow lifted">
				  <div style="font-size: 22px;"><?=$_SESSION['order_msg2']?></div>
				</div>
			 </div>
			 <br><br><br><br>
			 <?
			 unset($_SESSION['order_msg2']);
		  }
		if (isset($_SESSION['order_msg']))
		  {
			 $_SESSION['order_msg2'] = $_SESSION['order_msg'];
			 unset($_SESSION['order_msg']);
		  }

		?>
		<div id="clearStr">
		<?

		if (isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
		  {
			 if (isset($_SESSION['print']) && $_SESSION['print'] == 1)
				{
				  foreach ($_SESSION['album_name'] as $id => $key)
					 {
						$rs = $db->query('select `pecat`, `pecat_A4` FROM `albums` WHERE `id` =?i', array($id), 'row')
						?>
						<div class="drop-shadow lifted" style="margin: 20px 0 20px 250px;">
						  <div style="font-size: 24px;">Откорректируйте количество на каждой фотографии и нажмите далее</div>
						</div>
						<span class="label label-info" style="margin: 0 0 0 0;">
					    Цена на напечатанные фотографии в альбоме "<?=$key?>": 10x15см, 13x18см - <?=$rs['pecat']?>
						  грн, 20x30см - <?=$rs['pecat_A4']?> грн
				    </span>
						<div style="clear: both;"></div>
					 <?
					 }
				}
			 elseif ($_SESSION['print'] == 0 || $_SESSION['print'] == 2 || $_SESSION['print'] == 3)
				{
				  ?>
				  <div class="drop-shadow lifted" style="margin: 20px 0 20px 500px;">
					 <div style="font-size: 24px;">Ваша корзина</div>
				  </div>
				  <div style="clear: both;"></div>
				<?
				}
			 if (!isset($_SESSION['basket']['format']))
				{
				  $_SESSION['basket']['format'] = '13x18';
				}
			 $print = iTogo();
			 $format = $_SESSION['basket']['format'];
			 if ($format == '10x15' || $format == '13x18')
				{
				  $sum = $print['pecat']; // кол-во денег для всех напечатанных фото 13x18
				}
			 elseif ($format == '20x30')
				{
				  $sum = $print['pecat_A4']; // кол-во денег для всех напечатанных фото A4
				}
			 if (
				isset($_SESSION['print']) && $_SESSION['print'] == 0 || isset($_SESSION['print']) && $_SESSION['print'] == 1
			 )
				{
				  ?>
				  <ul class="thumbnails">
					 <?
					 foreach ($_SESSION['basket'] as $ind => $val)
						{
						  if (!isset($print['id'][$ind]) || $print['id'][$ind] != $ind)
							 {
								if ($ind != "ramka" and $ind != "mat_gl" and $ind != "format")
								  {
									 unset($_SESSION['basket'][$ind]); // чистка от мусора
								  }
							 }
						  else
							 {
								?>
								<div style="width: 170px; ; height: 290px; float: left;">
								  <div id="<?= 'ramka'.$ind ?>">
									 <li class="span2" style="margin-left: 30px; width: 160px; height: 300px;">
										<div class="thumbnail img-polaroid foto">
										  <span class="del" style="margin-left: 140px; margin-bottom: 0; margin-top: -12px; z-index: 1" onclick="goKorzDel('<?= $ind ?>','<?= $_SESSION['print'] ?>');"></span>
										  <img src="dir.php?num=<?= $ind ?>" alt="<?= $print['nm'][$ind] ?>" title="<?= $print['nm'][$ind] ?>"><br>
										  <span class="foto_prev_nm" style="margin-top: -20px; margin-left: 0; text-align: center;"><b>№  <?=$print['nm'][$ind]?></b></span>

										  <?
										  if (isset($_SESSION['print']) && $_SESSION['print'] == 1)
											 {
												if ($format == '10x15' || $format == '13x18')
												  {
													 $pr = $print['13'][$ind]; //цена за одно фото одного номера в массиве
													 $fSumm
														  = $print['arr13'][$ind]; // стоимость всех напечатанных фото одного номера 13x18
												  }
												elseif ($format == '20x30')
												  {
													 $pr    = $print['A4'][$ind]; //цена за одно фото одного номера в массиве
													 $fSumm = $print['arrA4'][$ind]; // цена за все фото одного номера в массиве
												  }

												?>
												<div style="display: inline">
												  <div style="float: left; height: 20px; width: 152px;">
													 <button class="btn-mini btn-info" onclick="ajaxAdd('goZakazAdd='+'<?= $ind ?>'+'&add='+'1');" style="float:left; width: 28px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;">
														+
													 </button>
													 <button class="btn-mini btn-info" onclick="ajaxAdd('goZakazAdd='+'<?= $ind ?>'+'&add='+'-1');" style="float:left; width: 28px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;">
														-
													 </button>
			     <span id="<?= 'fKoll'.$ind ?>" class="label label-warning" style="float: left; margin-left: 2px;">
				     <?=$_SESSION['basket'][$ind]?> шт</span> <span id="<?=
													 'fCena'
													  .$ind ?>" class="label label-success" style="float: right;"><?=isset($pr) ? $pr : NULL;?>
														грн</span>
												  </div>
												</div>
												<span><b>Всего:</b></span>
												<span id="<?= 'fSumm'
												 .$ind ?>" class="label label-success" style="float: right; margin-right: -2px;">
	        <?=isset($fSumm) ? $fSumm : NULL;?> грн</span>
											 <?
											 }
										  elseif (isset($_SESSION['print']) && $_SESSION['print'] == 0)
											 {
												?>
												<span class="label label-success" style="margin-left: 96px"><?=$print['cena_file'][$ind]?>
												  грн</span>
											 <?
											 }
										  ?>
										</div>
									 </li>
								  </div>
								</div>
							 <?
							 }
						}
					 ?>
				  </ul>
				<?
				}
			 if (isset($_SESSION['print']) && $_SESSION['print'] == 0)
				{
				  ?>
				  <table style="margin-top: 50px;">
					 <tr>
						<td>
						  <span id="iTogo" class="label label-important" style="margin: 0 0 10px 0;"><?= summa()?></span>
						</td>
					 </tr>
					 <tr>
						<td>
						  <form action="basket.php" method="post">
							 <input type="hidden" name="go_order" value="1"/>
							 <input class="metall_knopka" type="submit" value="Оплатить и получить в цифровом виде"/>
						  </form>
						</td>
						<td>
						  <span class="label label-important" style="text-align: center; margin-bottom: 20px; margin-left: 50px;"><b>или</b></span>
						</td>
						<td>
						  <form action="basket.php" method="post">
							 <input type="hidden" name="go_print" value="1"/>
							 <input class="metall_knopka" type="submit" style="margin-left: 50px;" value="Открыть форму заказа печати"/>
						  </form>
						</td>
					 </tr>
				  </table>
				<?
				}
			 elseif (isset($_SESSION['print']) && $_SESSION['print'] == 1)
				{
				  if (!isset($_SESSION['basket']['ramka']))
					 {
						$_SESSION['basket']['ramka'] = 0;
					 }
				  if (!isset($_SESSION['basket']['mat_gl']))
					 {
						$_SESSION['basket']['mat_gl'] = 'глянцевая';
					 }
				  if (!isset($_SESSION['basket']['format']))
					 {
						$_SESSION['basket']['format'] = '13x18';
					 }
				  $fFormat = array('10x15', '13x18', '20x30');
				  $fBum    = array('глянцевая', 'матовая');

				  ?>
				  <script>
					 $(document).ready(function () {
						$('#format ').change(function () {
						  ajaxFormat('goFormat=' + $('#format').val());
						  return false;
						});
					 });
					 $(document).ajaxStart(function () {
						$('#loading').show();
					 }).ajaxStop(function () {
						 $('#loading').hide();
					  });
				  </script>
				  <div id="form_reg" style="position: relative; width: 380px; height: 176px; z-index: 12; margin-bottom: 0; margin-top: 40px;">
					 <div id="pr_Form" style="position:absolute;left:24px;top:-10px;width:280px;z-index:12;">
						<form name="printMail" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="printMail">
						  <label id="pr_Name1" style="position: absolute; left: 0; top: 32px; width: 160px; height: 14px; z-index: 0; text-align: left;" for="format">
							 <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Размер фотографии:</span>
						  </label>
						  <select id="format" style="position: absolute; left: 142px; top: 30px; width: 204px; height: 25px; z-index: 1;" size="1" name="format">
							 <?
							 foreach ($fFormat as $format)
								{
								  ?>
								  <option value='<?= $format ?>' <?=(
								  $_SESSION['basket']['format'] == $format ? 'selected="selected"' : '')?>

									><?=$format?> см
								  </option>
								<?
								}
							 ?>
						  </select>
						  <label id="pr_Name2" style="position: absolute; left: 0; top: 64px; width: 114px; height: 14px; z-index: 0; text-align: left;" for="mat_gl">
							 <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Тип бумаги:</span></label>
						  <select id="mat_gl" style="position: absolute; left: 142px; top: 62px; width: 204px; height: 25px; z-index: 1;" size="1" name="mat_gl">
							 <?
							 foreach ($fBum as $bum)
								{
								  ?>
								  <option value='<?= $bum ?>' <?=(
								  $_SESSION['basket']['mat_gl'] == $bum ? 'selected="selected"' : '')?>><?=$bum?></option>
								<?
								}
							 ?>
						  </select>
						  <label id="pr_Name3" style="position:absolute;left:0;top:94px;width:114px;height:14px;z-index:2;text-align:left;" for="ramka">
							 <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Белая рамка:</span></label>
						  <input type="hidden" name="ramka" value="0"/>
						  <input type="checkbox" id="ramka" name="ramka" value="1"
							<? if ($_SESSION['basket']['ramka'])
							 {
								echo 'checked="checked"';
							 } ?>
							style="position:absolute;left:145px;top:94px;z-index:3;"/>
						  <input class="metall_knopka" type="submit" style="position: absolute; left: 273px; top: 153px; z-index: 13;" value="Далее" data-original-title="" title="">
						</form>
			  <span id="iTogo" class="label label-important" style="position:absolute;top:128px;z-index:0;text-align:left;">
                     <?= summa()?></span>

						<div id="loading" style="display: none;position:absolute;left:290px;top:132px;z-index:0;text-align:left;">
						  <img src="/img/ajax-loader.gif">
						</div>
						<div style="position:absolute;left:0;top:138px;z-index:0;text-align:left;">
						  <form action="basket.php" method="post" style="float: left;">
							 <input type="hidden" name="go_back" value="1"/>
							 <input class="metall_knopka" type="submit" value="Назад" style="margin-top: 15px;"/>
						  </form>
						  <form action="basket.php" method="post" style="float: right; margin-right: -265px;">

						  </form>
						</div>
					 </div>
				  </div>

				<?
				}
			 elseif (isset($_SESSION['print']) && $_SESSION['print'] == 2)
				{
				   $rs = $db->query('select * from nastr order by id asc', null, 'assoc');
	          	$spOpl = array();
				   $spDost = array();
				   $adr_pecat = array();
				   $nm_pocta = array();
				   $http_pocta = array();
				   $poctRash = 'плюс почтовые расходы';
				  if($rs)
					 {
							 foreach($rs as $i => $v)
								{
		                    $iN = substr($i, 0, strlen($i) - 1);
	                    	  if($iN == 'oplata') 	  $spOpl[]      = $i;
								  if($iN == 'dostavka')   $spDost[]     = $i;
								  if($iN == 'adr_pecat')  $adr_pecat[]  = $i;
								  if($iN == 'nm_pocta')   $nm_pocta[]   = $i;
								  if($iN == 'http_pocta') $http_pocta[] = $i;
								}
				 	}

				  ?>
				  <div id="form_reg" style="position: relative;width:380px;height:510px;display: inline-block;">
					 <div id="pr_Form" style="position: relative; width: 350px;height: auto; left: 10px;">
						<form name="printMail" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Form1">

						  <label id="pr_Name1" style="position: relative; width: 114px; height: 14px; text-align: left; margin-top: 20px;float: left;" for="Combobox3">
							 <span style="color:#000000;font-family:Arial,serif;font-size:14px;float: left;">Способ оплаты:</span>
						  </label>
						  <select id="Combobox3" class="inp_f_reg" style="position: relative; width: 214px; height: 25px; float: right; margin-top: 20px;" size="1" name="Combobox"> </select>

						  <label for="Combobox1" id="pr_Name2" style="position:relative;width:114px;height:14px;text-align:left; margin-top: 20px;float: left;">
							 <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Доставка:</span></label>
						  <select name="Combobox1" class="inp_f_reg" size="1" id="Combobox1" style="position:relative;width:214px;height:25px;float: right;"> </select>

						  <label id="pr_Name3" style="position:relative;width:314px;height:14px;text-align:center;float:left;margin-left: 25px;">
							 <span style="color:#000000;font-family:Arial,serif;font-size:16px;">Контактные данные получателя:</span></label>

						  <div id="pr_Clear1" style="clear: both;">
							 <label id="pr_Name4" style="position: relative; width: 120px; height: 28px; text-align: left; float: left; margin-top: 10px;" for="Editbox1">
								<span style="color:#000000;font-family:Arial,serif;font-size:14px;">Имя:</span> </label>
							 <input id="Editbox1" class="inp_f_reg" type="text" value="" name="Editbox1" style="position: relative; width: 200px; height: 23px; line-height: 23px;
							     float: right; margin-top: 10px;" data-original-title="" title="">
						  </div>
						  <div id="pr_Clear2" style="clear: both;">
							 <label id="pr_Name5" style="position: relative; width: 120px; height: 28px; text-align: left; float: left;" for="Editbox2">
								<span style="color:#000000;font-family:Arial,serif;font-size:14px;">Фамилия:</span> </label>
							 <input id="Editbox2" class="inp_f_reg" type="text" value="" name="Editbox2" style="position: relative; width: 200px; height: 23px; line-height: 23px;
							     float: right;" data-original-title="" title="">
						  </div>
						  <div id="pr_Clear3" style="clear: both;">
							 <label id="pr_Name6" style="position: relative; width: 120px; height: 28px; text-align: left; float: left;" for="Editbox3">
								<span style="color:#000000;font-family:Arial,serif;font-size:14px;">Телефон:</span> </label>
							 <input id="Editbox3" class="inp_f_reg" type="text" value="" name="Editbox3" style="position: relative; width: 200px; height: 23px; line-height: 23px;
							     float: right;" data-original-title="" title="">
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

						  <span id="iTogo" class="label label-important" style="position: relative; margin: 20px 0 20px 0;"><?= summa().' '.$poctRash?></span><br>
						  <input class="metall_knopka" type="submit" style="position: relative; float: right;" value="Заказать" data-original-title="" title="">
						</form>
					 <form action="basket.php" method="post" style="position:relative;">
						<input type="hidden" name="go_print" value="1"/>
						<input class="metall_knopka" type="submit"  value="Назад" data-original-title="" title="">
					 </form>
					 </div>
				  </div>

				<?
		  }

			 elseif (isset($_SESSION['print']) && $_SESSION['print'] == 3)
				{
				  if (isset($_POST['go_mail']) && isset($_SESSION['basket']) && is_array($_SESSION['basket'])
					&& count($_SESSION['basket']) > 0
				  )
					 {
						$mysqlErrno  = 0;
						$id_order    = 0;
						$mat_gl      = '';
						$ramka       = '';
						$phone       = '';
						$id_pocta    = '';
						$adress_otpr = '';
						$order       = '';
						$id_nal      = '';
						try
						  {
							 $id_order = $db->query('insert into print_order (mat_gl,ramka,id_user,dt,phone,id_pocta,order,adress_otpr,id_nal)
							     values (?,?i,?i,?i,?string,?i,?f,?string,?i)',
								array($mat_gl, $ramka, $_SESSION['userid'], time(), $phone, $id_pocta, $order, $adress_otpr,
										$id_nal),
								'id');
						  }
						catch (go\DB\Exceptions\Query $e)
						  {
							 trigger_error("
			                  'SQL-query: ".$e->getQuery()."\n'
                           'Error description: ".$e->getError()."\n'
                           'Error code: ".$e->getErrorCode()."\n'
		                                 ");
							 $mysqlErrno = 1;
						  }
						if ($mysqlErrno == 0)
						  {
							 $order = iTogo();
							 if ($order['pecat'] > $user_balans)
								{
								  $_SESSION['order_msg']
									= 'Недостаточно средств на балансе!<br> Пополните счет или закажите печать наложенным платежем.';
								  $db->query('delete from orders where id = ?i', array($id_order));
								}
							 else
								{
								  $tm           = time();
								  $download_ids = array();
								  $id_user      = intval($_SESSION['userid']);
								  foreach ($_SESSION['basket'] as $ind => $val)
									 {
										$id_item           = $db->query('insert into order_items (id_order, id_photo) values (?i,?i)',
										  array($id_order, $ind),
										  'id');
										$key               = md5($id_item.$tm.$id_order.mt_rand(1, 10000));
										$id                = intval($db->query('insert into download_photo (id_user, id_order, id_order_item, id_photo, dt_start, download_key)
                                values (?i,?i,?i,?i,?i,?string)',
										  array($id_user, $id_order, $id_item, $ind, $tm, $key),
										  'id'));
										$download_ids[$id] = $key;
									 }
								  $user_data = $db->query('select * from users where id = ?i', array($id_user), 'row');
								  $title     = 'Фотографии Creative line studio';
								  $headers   = "Content-type: text/plain; charset=windows-1251\r\n";
								  $headers .= "From: Администрация Creative line studio \r\n";
								  $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
								  $letter  = "Здравствуйте, $user_data[us_name]!\r\n";
								  $letter .= "Вам предоставлен доступ для скачивания следующих фото:.\r\n\r\n";
								  foreach ($download_ids as $ind => $val)
									 {
										$letter .= 'http://'.$_SERVER['HTTP_HOST']."/download.php?key=$val\r\n";
									 }
								  $letter .= "\r\nВНИМАНИЕ! Для скачивания фотографий сначала нужно залогиниться на сайте! Ссылки действительны 48 часов!\r\n";
								  // Отправляем письмо
								  if (!mail($user_data['email'], $subject, $letter, $headers))
									 {
										$db->query('delete from orders where id = ?i', array($id_order));
										$db->query('delete from order_items where id_order = ?i', array($id_order));
										$db->query('delete from download_photo where id_order = ?i', array($id_order));
										$_SESSION['order_msg']
										 = 'Ошибка отправки письма со ссылками! Возможно сайт перегружен. Пожалуйста, зайдите позже.';
										trigger_error("Ошибка отправки письма со ссылками!");
									 }
								  else
									 {
										$_SESSION['basket'] = array();
										$_SESSION['order_msg']
																  = 'Заказ оплачен! Вам на E-mail отправлено письмо со списком ссылок для скачивания фото!';
										$db->query('update users set balans = balans - ?f where id = ?i',
										  array($order['price'], $id_user));
										trigger_error("Произведена покупка фотографий!");
									 }
								  ?>
								  <script type="text/javascript">
									 location.replace("basket.php?1=1");
								  </script>
								<?
								}
						  }
					 }
		
				  ?>


				  <div class="drop-shadow lifted" style="margin: 50px 0 0 150px;">
					 <div style="font-size: 24px;">Вам на E-mail отправлено письмо для подтверждения заказа. Проверьте,
						пожалуйста, почту.
					 </div>
				  </div>
				<?
        }
		  }
		else
		  {
			 ?>
			 <div class="drop-shadow lifted" style="margin: 50px 0 0 480px;">
				<div style="font-size: 24px;">Ваша корзина пуста!</div>
			 </div>
		  <? } ?>
		</div>
		</div>
	 <?
	 }
?>
  <div class="end_content"></div>
  </div>
<?
  include (dirname(__FILE__).'/inc/footer.php');
?>