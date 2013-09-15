<?php
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
  error_reporting(0);
		define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
  include_once (BASEPATH.'inc/head.php');

  $session = check_Session::getInstance();

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
		if (isset($_POST['go_order']) && isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
		  {
			 $mysqlErrno = 0;
			 $id_order   = 0;
			 try
				{
				  $id_order = $db->query('insert into orders (id_user, dt) values (?i,?i)', array($_SESSION['userid'], time()),'id');
				}
			 catch (go\DB\Exceptions\Query $e)
				{
				  trigger_error("
			                  'SQL-query: ".$e->getQuery()."\n'
                           'Error description: ".$e->getError()."\n'
                           'Error code: ".$e->getErrorCode()."\n'");
				  $mysqlErrno = 1;
				}
			 if ($mysqlErrno == 0)
				{
				  $order = iTogo();
				  if ($order['price'] > $user_balans)
					 {

						$_SESSION['basket_err'] = "Недостаточно средств на балансе!<br> Пополните счет или закажите печать наложенным платежем.";
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
						$headers .= "From: Creative line studio \r\n";
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
							 $_SESSION['basket_err'] = "Ошибка отправки подтверждения! Возможно сайт перегружен. Пожалуйста, зайдите позже.";
							 trigger_error("Ошибка отправки письма со ссылками!");
						  }
						else
						  {
							 $_SESSION['basket'] = array();
							 $_SESSION['zakaz'] = array();
							 $_SESSION['basket_ok'] = "Заказ оплачен! Вам на E-mail отправлено письмо со списком ссылок для скачивания фото!";
							 $db->query('update users set balans = balans - ?f where id = ?i', array($order['price'], $id_user));
						  }
						?>
						<script type="text/javascript">
						  location.replace("basket.php?1=1");
						</script>
					   <?
						die();
					 }
				}
		  }

if (isset($_POST['okei']) && is_array($session->get('basket')) && count($session->get('basket')) > 0 )
		  {

			 $id_user = intval($session->get('userid'));
			 $name = $_POST['us_name'];
			 $subname = $_POST['us_surname'];
			 $phone = $_POST['phone'];
			 $email = $_POST['email'];
			 $adr_poluc = $_POST['adress'];
			 $adr_studii = $_POST['aPecat'];

//			  $tmp = explode('|',$_POST['nPocta']);
//			  $nPocta = $tmp[0];
			 $nPocta = $_POST['nPocta'];
			 $id_nal = $_POST['opl'];
			 $id_dost = $_POST['dost'];
			 $user_dost = $_POST['txtDost'];
			 $user_opl = $_POST['txtOpl'];
			 $ramka = $session->get('zakaz/ramka');
			 $mat_gl = $session->get('zakaz/mat_gl');
			 $format = $session->get('zakaz/format');
			 $comm = $_POST['comment'];
			 $zakaz = 0;
	       $tm  = time();
			 $order = iTogo();
			 $summ = NULL;
			 if ($order)
				{
				  $format = $session->get('zakaz/format');
				  if ($format == '10x15' || $format == '13x18')
					 {
						$summ = $order['pecat'];
					 }
				  elseif ($format == '20x30')
					 {
						$summ = $order['pecat_A4'];
					 }
				}

			 $pattern = 'INSERT INTO `print`(`dt`,`id_user`,`name`,`subname`,`phone`,`email`,`adr_poluc`,`adr_studii`,`nPocta`,`id_nal`,`id_dost`,`user_dost`,
                  `user_opl`,`ramka`,`mat_gl`,`format`,`comm`, `summ`,`zakaz`)
                  VALUES (?i, ?i, ?string, ?string, ?string, ?string, ?string, ?string, ?string, ?string, ?string, ?string, ?string, ?b, ?string, ?string, ?string, ?f, ?b)';
			 $data    = array($tm, $id_user,$name,$subname,$phone,$email,$adr_poluc,$adr_studii,$nPocta,$id_nal,$id_dost,$user_dost,$user_opl,$ramka,$mat_gl,$format,$comm,
									 $summ,$zakaz);
			 try {
				$id_order = $db->query($pattern, $data)->id(); // номер заказа
				if($id_order)
				  {
					 foreach ($session->get('basket') as $ind => $val)
						{
								$db ->query('INSERT INTO `order_print`(`id_print`,`id_photo`,`koll`) VALUES (?i,?i,?i)',array($id_order,$ind,$val));
						}
				  }

					 $key      = sha1(md5($id_order.md5($tm.mt_rand(1, 10000))));
					 $db->query('UPDATE `print` SET `key` = ?string WHERE id = ?i', array($key,$id_order));
					 $album_name = '';
					 foreach($_SESSION['album_name'] as $val)
						{
                $album_name = $val;
						}

					 $title     = 'Фотографии Creative line studio';
					 $headers   = "Content-type: text/plain; charset=windows-1251\r\n";
					 $headers .= "From: Creative line studio \r\n";
					 $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';


					 $letter  = "Здравствуйте, ".$name."!\r\n";
					 $letter .= "Вы или кто - то от Вашего имени сделал заказ печати фотографий на сайте http://".$_SERVER['HTTP_HOST']."\r\n";
					 $letter .= "Если заказ сделан не Вами, просто удалите это письмо.\r\n\r\n";
					 $letter .= "Заказ № ".$id_order." \r\n";
					 $letter .= "Дата заказа: ".date('d.m.Y  H.i', $tm)."\r\n";
					 $letter .= "Имя получателя: ".$name."\r\n";
					 $letter .= "Фамилия получателя: ".$subname."\r\n";
					 $letter .= "Номер телефона получателя: ".$phone."\r\n";
					 $letter .= "Размер фотографий:\t ".$format." см.\r\n";
					 $letter .= "Бумага ".$mat_gl."\r\n";
					 $letter .= ($id_nal == 'другое') ? "Способ оплаты выбранный пользователем: '".$user_opl.",\r\n":"Способ оплаты: ".$id_nal."\r\n";
					 $letter .= ($id_dost == 'другое') ? "Способ доставки выбранный пользователем: '".$user_dost.",\r\n":"Вид доставки: ".$id_dost."\r\n";
					 if($id_dost == 'Самовывоз из почтового отделения Вашего города' || $id_dost == 'Доставка до двери почтовой службой (кроме Одессы)')
						{
						  $letter .= "Наименование службы доставки: ".$nPocta.",\r\n";
						  $letter .= "Адрес почтового отделения или получателя:\r\n ".$adr_poluc."\r\n";
						}
					 if($id_dost == 'Самовывоз из студии (в Одессе)') $letter .= "Адрес студии для получения фотографий: '".$adr_studii.",\r\n";
					 $letter .= "Примечание пользователя:\r\n".$comm."\r\n";
					 $letter .= "\r\nНазвание альбома: '".$album_name."'\r\n";
					 $letter .= "Номер и количество фотографий:\r\n";
					 foreach ($_SESSION['basket'] as $ind => $val)
						{
						  $name = $db->query('select `nm` from `photos` where id =?i',array($ind),'el');
						  $letter .= "Фотография № ".$name." - ".$val."шт.\r\n";
						}
					 $letter .= "К оплате: ".$summ."гр. (".str_digit_str($summ)."гр.)\r\n\r\n";
					 $letter .= "Подтвердить или проверить заказ:  ";
					 $letter .= 'http://'.$_SERVER['HTTP_HOST']."/security.php?key=$key";
					 $letter .= "\r\nВНИМАНИЕ! Для подтверждения заказа необходимо сначала залогиниться на сайте! Ссылка действительна 48 часов!\r\n";
					 // Отправляем письмо
					 if (!mail($email, $subject, $letter, $headers))
						{
						  $db->query('delete from `print` where `id` = ?i', array($id_order));
						  $db->query('delete from `order_print` where `id_print` = ?i', array($id_order));
						  $_SESSION['basket_err'] = "Ошибка отправки подтверждения! Возможно сайт перегружен. Пожалуйста, зайдите позже.";
						  trigger_error("Ошибка отправки письма подтверждения!");
						}
					 else
						{
                    $_SESSION['basket'] = array();
						  $_SESSION['zakaz'] = array();
						  $_SESSION['basket_ok'] = "Спасибо, на Ваш E-mail отправлено письмо для проверки и подтверждения заказа.";
						 	?>
						  <div class="drop-shadow lifted" style="margin: 50px 0 0 200px;">
							 <div style="font-size: 24px;">На Ваш E-mail отправлено письмо для проверки и подтверждения заказа.<br>
								<span style="font-size: 18px;">Проверьте, пожалуйста, почту.</span>
							 </div>
						  </div>
				      	<?
						}


			 } catch (go\DB\Exceptions\Query $e) {
				$err  = 'SQL-query: '.$e->getQuery()."\n";
				$err .= 'Error description: '.$e->getError()."\n";
				$err .= 'Error code: '.$e->getErrorCode()."\n";
				trigger_error($err);

	/* */?><!--
	 <script type="text/javascript">
		location.replace("basket.php?1=1");
	 </script>
     --><?
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

		if (isset($_POST['mat_gl']) && count($session->get('basket')) > 0)
		  {
			 $_SESSION['print']           = 2;
			 $_SESSION['zakaz']['ramka']  = trim($_POST['ramka']);
			 $_SESSION['zakaz']['mat_gl'] = trim($_POST['mat_gl']);
			 $_SESSION['zakaz']['format'] = trim($_POST['format']);
		  }

		?>
		<div id="clearStr">
		<?

		if (isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
		  {
			 if (isset($_SESSION['print']) && $_SESSION['print'] == 1)
				{
		?>
		<div class="drop-shadow lifted" style="margin: 20px 0 20px 250px;">
		  <div style="font-size: 24px;">Откорректируйте количество на каждой фотографии и нажмите далее</div>
		</div>
		<?
 				  foreach ($session->get('zakaz/album_name') as $id => $key)
					 {
						$rs = $db->query('select `pecat`, `pecat_A4` FROM `albums` WHERE `id` =?i', array($id), 'row')
						?>
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
			 if (!$session->has('zakaz/format'))
				{
				  $session->set('zakaz/format','13x18');
				}
			 $print = iTogo();
			 $format = $session->get('zakaz/format');

			 if ($session->get('print') == 0 || $session->get('print') == 1)
				{
				  ?>

				  <ul class="thumbnails">
					 <?
					 foreach ($_SESSION['basket'] as $ind => $val)
						{
						  if (!isset($print['id'][$ind]) || $print['id'][$ind] != $ind)
							 {
									 unset($_SESSION['basket'][$ind]); // чистка от мусора
							 }
						  else
							 {
								?>
								<div style="width: 170px; ; height: 290px; float: left;">
								  <div id="<?= 'ramka'.$ind ?>">
									 <li class="span2" style="margin-left: 30px; width: 160px; height: 300px;">
										<div class="thumbnail img-polaroid foto">
										  <span class="del" style="margin-left: 140px; margin-bottom: 0; margin-top: -12px; z-index: 1"
											onclick="goKorzDel('<?= $ind ?>','<?= $_SESSION['print'] ?>');"></span>
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
					                      <?=$_SESSION['basket'][$ind]?> шт</span> <span id="<?='fCena'.$ind ?>"
													  class="label label-success" style="float: right;"><?=isset($pr) ? $pr : NULL;?>грн</span>
												  </div>
												</div>
												<span><b>Всего:</b></span>
												<span id="<?= 'fSumm'.$ind ?>" class="label label-success" style="float: right; margin-right: -2px;"><?=isset($fSumm) ? $fSumm : NULL;?> грн</span>
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
				  <div id="form_bask" style="margin-bottom: 0; padding-top: 20px; height: 76px; width: 667px; margin-left: 270px;">
				  <table>
					 <tr>
						<td>
						  <span id="iTogo" class="label label-important" style="margin: 0 0 10px 0;"><?= summa()?></span>
						</td>
					 </tr>
					 <tr>
						<td>
						  <form action="basket.php" method="post">
							 <input type="hidden" name="go_order" value="1"/>
							 <input class="btn btn-primary" type="submit" value="Оплатить и получить в цифровом виде"/>
						  </form>
						</td>
						<td>
						  <span class="label label-important" style="text-align: center; margin-bottom: 20px; margin-left: 50px;"><b>или</b></span>
						</td>
						<td>
						  <form action="basket.php" method="post">
							 <input type="hidden" name="go_print" value="1"/>
							 <input class="btn btn-primary" type="submit" style="margin-left: 50px;" value="Открыть форму заказа печати"/>
						  </form>
						</td>
					 </tr>
				  </table>
				  </div>
				<?
				}
			 elseif ($session->get('print')== 1)
				{
				  if (!$session->has('zakaz/ramka'))
					 {
						$session->set('zakaz/ramka',0);
					 }
				  if (!$session->has('zakaz/mat_gl'))
					 {
						$session->set('zakaz/mat_gl', 'глянцевая');
					 }
				  if (!$session->has('zakaz/format'))
					 {
						$session->set('zakaz/format', '13x18');
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
						  <label id="pr_format" style="position: absolute; left: 0; top: 32px; width: 160px; height: 14px; z-index: 0; text-align: left;" for="format">
							 <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Размер фотографии:</span>
						  </label>
						  <select id="format" style="position: absolute; left: 142px; top: 30px; width: 204px; height: 25px; z-index: 1;" size="1" name="format">
							 <?
							 foreach ($fFormat as $format)
								{
								  ?>
								  <option value='<?= $format ?>' <?=(
								  ($session->get('zakaz/format') == $format) ? 'selected="selected"' : '')?>

									><?=$format?> см
								  </option>
								<?
								}
							 ?>
						  </select>
						  <label id="pr_mat_gl" style="position: absolute; left: 0; top: 64px; width: 114px; height: 14px; z-index: 0; text-align: left;" for="mat_gl">
							 <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Тип бумаги:</span></label>
						  <select id="mat_gl" style="position: absolute; left: 142px; top: 62px; width: 204px; height: 25px; z-index: 1;" size="1" name="mat_gl">
							 <?
							 foreach ($fBum as $bum)
								{
								  ?>
								  <option value='<?= $bum ?>' <?=(
								  ($session->get('zakaz/mat_gl') == $bum) ? 'selected="selected"' : '')?>><?=$bum?></option>
								<?
								}
							 ?>
						  </select>
						  <label id="pr_ramka" style="position:absolute;left:0;top:94px;width:114px;height:14px;z-index:2;text-align:left;" for="ramka">
							 <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Белая рамка:</span></label>
						  <input type="hidden" name="ramka" value="0"/>
						  <input type="checkbox" id="ramka" name="ramka" value="1"
							<? if ($_SESSION['zakaz']['ramka'])
							 {
								echo 'checked="checked"';
							 } ?>
							style="position:absolute;left:145px;top:94px;z-index:3;"/>
						  <input class="btn btn-primary" type="submit" style="position: absolute; left: 273px; top: 153px; z-index: 13;" value="Далее" data-original-title="" title="">
						</form>
			  <span id="iTogo" class="label label-important" style="position:absolute;top:128px;z-index:0;text-align:left;">
                     <?= summa()?></span>
						<div id="loading" style="display: none;position:absolute;left:290px;top:132px;z-index:0;text-align:left;">
						  <img src="/img/ajax-loader.gif">
						</div>
						<div style="position:absolute;left:0;top:138px;z-index:0;text-align:left;">
						  <form action="basket.php" method="post" style="float: left;">
							 <input type="hidden" name="go_back" value="1"/>
							 <input class="btn btn-primary" type="submit" value="Назад" style="margin-top: 15px;"/>
						  </form>
						  <form action="basket.php" method="post" style="float: right; margin-right: -265px;">
						  </form>
						</div>
					 </div>
				  </div>

				<?
				}
			 elseif (isset($_SESSION['print']) && $_SESSION['print'] == 2)  // страница выбора способа оплаты
				{
?>


<!--		для работы		  -->

<script type="text/javascript" src="/js/jquery/jquery-ui.js"></script>
<link rel="stylesheet" href="/js/jquery/themes/base/minified/jquery-ui.min.css" type="text/css" media="screen"/>
<script type="text/javascript" src="/js/zakazPecat.js"></script>
<link rel="stylesheet" href="/js/jquery/themes/base/minified/jquery.ui.theme.min.css" type="text/css" media="screen"/>
<script language='javascript' src="/js/form-validator/formvalidator.class.js"></script>


<!--		 для настройки-->

<!--<script type="text/javascript" src="/js/jquery/jquery-plus-jquery-ui.js"></script>-->
<!--<script type="text/javascript" src="/js/ixedit/ixedit.js"></script>-->
<!--<link rel="stylesheet" href="/js/ixedit/ixedit.css" type="text/css" media="screen"/>-->


				 <?
				   $rs = $db->query('select * from nastr order by id asc', NULL, 'assoc');
	          	$spOpl = array();
				   $spDost = array();
				   $adr_pecat = array();
				   $pocta = array();
				   $poctRash = '+ почтовые расходы';
				   $nPocta = '';
				  if($rs)
					 {
							 foreach($rs as $v)
								{
	                    	  if($v['param_name'] == 'oplata') 	   $spOpl[$v['param_index']]      = $v['param_value'];
								  if($v['param_name'] == 'dostavka')   $spDost[$v['param_index']]     = $v['param_value'];
								  if($v['param_name'] == 'adr_pecat')  $adr_pecat[$v['param_index']]  = $v['param_value'];
								  if($v['param_name'] == 'nm_pocta')
									 {
									   $nPocta = $v['param_value'];
										$pocta[$nPocta]  = $v['param_value'];
									 }
								  if($v['param_name'] == 'http_pocta') $pocta[$nPocta] = $v['param_value'];

								}
						 $spOpl[]     = 'выбрать';
						 $spDost[]    = 'выбрать';
						 $adr_pecat[] = 'выбрать';
			   	 	 $pocta['выбрать']  = 'выбрать';
				 	}
				  $rs = $db->query('select * from users where id =?i', array($_SESSION['userid']), 'row');
				  ?>
				  <div id="form_bask" style="display: none;">
					 <div id="prFormOpl" style="position: relative; width: 350px;left: 10px;">
						<form  id="formOpl" name="validatedform"  method="post" action="<?php echo basename(__FILE__); ?>"
						 enctype="multipart/form-data" style="margin-bottom: 40px;">

						  <label id="pr_opl" style="position: relative; width: 114px; height: 14px; text-align: left; margin-top: 24px;float: left;" for="opl">
							 <span style="float: left;">Способ оплаты:</span>
						  </label>
						  <select id="opl" class="inp_f_reg" style="position: relative; width: 214px; float: right; margin-top: 20px;" size="1" name="opl">
							 <?
							 foreach ($spOpl as $opl)
								{
								  ?>
								  <option value='<?= $opl ?>' <?=($opl ? 'selected="selected"' : '')?>><?=$opl?></option>
								<?
								}
							 ?>
						  </select>

						  <div id="clear_txtOpl" style="clear: both;">
							 <label id="pr_txtOpl" for="txtOpl"></label>
							 <span class="ttext_blue" style="font-size:10px; float: right;">укажите удобный Вам способ оплаты</span>
							 <textarea id="txtOpl" class="inp_f_reg" title="в некоторых случаях потребуется предоплата" data-original-title="" name="txtOpl" rows="5" cols="32" style="width: 336px; height: 80px;
						   margin-top: 10px;"></textarea>
						  </div>

						  <div id="clear_dost" style="clear: both;">
							 <label for="dost" id="pr_dost" style="position:relative;width:114px;height:14px;text-align:left; margin-top: 5px;float: left;">
								<span>Доставка:</span></label>
							 <select  id="dost" name="dost" class="inp_f_reg" size="1" style="position: relative; width: 214px; float: right;">
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
						  </div>

						  <div id="clear_txtDost" style="clear: both;">
						  <label id="pr_txtDost" for="txtDost"></label>
						  <span class="ttext_blue" style="font-size:10px; float: right;">укажите свой способ доставки</span>
						  <textarea id="txtDost" class="inp_f_reg" title="например: заберу заказ при личной встрече и т.д." data-original-title="" name="txtDost" rows="5" cols="32" style="width: 336px; height: 80px;
						   margin-top: 10px;"></textarea>
						  </div>

						  <div id="clear_nPocta" style="clear: both;">
							 <label id="pr_nPocta" style="position: relative; width: 114px; height: 14px; text-align: left; margin-top: 5px;float: left;" for="nPocta">
								<span style="float: left;">Почта:</span>
							 </label>
							 <select id="nPocta" class="inp_f_reg" style="position: relative; width: 214px; float: right;" size="1" name="nPocta"
                     onchange="hPocta()">
								<?
								foreach ($pocta as $key => $nPocta)
								  {
									 ?>
									 <option value='<?= $key.'|'.$nPocta ?>' <?=(
									 $nPocta ? 'selected="selected"' : '')?>><?=$key?></option>
								  <?
								  }
								?>
							 </select>
							 <div id="clear_a" style="clear: both;">
								<span id="httpPocta" style="margin-bottom: 15px;"></span>
							</div>
						  </div>

						  <div id="clear_aPecat" style="clear: both;">
						  <label id="pr_aPecat" style="position: relative; width: 114px; height: 14px; text-align: left; margin-top: 5px;float: left;" for="aPecat">
							 <span style="float: left;">Адрес студии:</span>
						  </label>
						  <select id="aPecat" class="inp_f_reg" style="position: relative; width: 214px; float: right;" size="1" name="aPecat">
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
                    </div>

                   <div id="clear_Block">
						  <div id="clear_polucatel">
						  <label id="pr_pol" style="position:relative;width:314px;height:14px;text-align:center;float:left;margin-left: 25px; margin-top: 5px;"
							data-placement="right" title="Если получать заказ планируете не Вы, измените эти данные на данные Вашего представителя">
							 <span style="font-size:18px;">Контактные данные получателя:</span></label>
						  </div>

						  <div id="clear_us_name" style="clear: both;">
							 <label id="pr_us_name" style="position: relative; width: 120px; height: 28px; text-align: left; float: left; margin-top: 10px;" for="us_name">
								<span>Имя:</span> </label>
							 <input id="us_name" class="inp_f_reg required" type="text" value="<?= $rs['us_name']?>" name="us_name" style="position: relative; width: 200px;
							  height: 23px; line-height: 23px; float: right; margin-top: 10px;" data-placement="right" title="Имя получателя заказа" maxlength="20">
						  </div>
						  <div id="clear_us_surname" style="clear: both;">
							 <label id="us_surname" style="position: relative; width: 120px; height: 28px; text-align: left; float: left;" for="us_surname">
								<span>Фамилия:</span> </label>
							 <input id="us_surname" class="inp_f_reg required" type="text" value="<?= $rs['us_surname']?>" name="us_surname"
							  style="position: relative; width: 200px; height: 23px; line-height: 23px;
							     float: right;"  data-placement="right" title="Фамилия получателя заказа" maxlength="20">
						  </div>

						  <div id="clear_phone" style="clear: both;">
							 <label id="pr_phone" style="position: relative; width: 120px; height: 28px; text-align: left; float: left;" for="phone">
								<span >Телефон:</span> </label>
							 <input id="phone" class="inp_f_reg numberValidator" type="text" value="<?= $rs['phone']?>" name="phone" style="position: relative;
							 width: 200px; height: 23px; line-height: 23px;float: right;" data-placement="right" title="Контактный телефон" maxlength="20">
						  </div>

						  <div id="clear_email" style="clear: both;">
							 <label id="pr_email" style="position: relative; width: 120px; height: 28px; text-align: left; float: left;" for="email">
								<span>E-mail:</span> </label>
							 <input id="email" class="inp_f_reg emailValidator required" type="text" value="<?= $rs['email']?>" name="email" style="position: relative;
							 width: 200px; height: 23px; line-height: 23px;float: right;" data-placement="right" title="Почтовый ящик для подтверждения заказа" maxlength="20">
						  </div>

						  <div id="clear_adress" style="clear: both;">
							 <label for="adress" id="pr_adress" style="position:relative;width:120px;height:52px;text-align:left;float: left; margin-top: 10px;">
								<span>Адрес почтового отделения </span>
								<span style="font-size:12px;">(или получателя если доставка на дом):</span></label>
							 <textarea class="inp_f_reg" id="adress" cols="32" rows="5" style="position: relative; width: 205px; height: 80px; float: right; margin-top: 10px;"
							  name="adress" data-original-title="" title="почтовый индекс, страна, город, улица, дом, квартира" maxlength="512"></textarea>
						  </div>

						  <div id="clear_a" style="clear: both;">
						  <a href="" onclick="return false;"><span class="ttext_blue" style="font-size:10px; float: right;">Добавить комментарий к заказу</span></a>
						  </div>

						  <div id="clear_comment" style="clear: both;display: none;">
							 <label id="pr_comment" for="comment"> </label>
								<textarea class="inp_f_reg" id="comment" title="комментарии к заказу" data-original-title="" name="comment" rows="5" cols="32" style="width: 336px; height: 80px; margin-top: 10px;" maxlength="512"></textarea>
						  </div>

						  <div id="clear_okei" style="clear: both;">
							 <input id="okei" type="checkbox" style="float: left; margin: 15px 0 0 60px;" value="on" name="okei" data-original-title="" title="">
							 <label id="pr_okei" for="okei">
								<div style="font-size: 12px; float: right; width: 260px; margin-top: 10px; margin-left: 10px;">
								  Подтвердить заказ <br>(подтверждая заказ, я соглашаюсь с
								 <a href="" onclick="return false;" ><span class="ttext_blue" style="font-size:12px;"> пользовательским соглашением)</span></a></div>
							 </label>
						  </div>
                    </div>
						  <span id="iTogo" class="label label-important" style="margin: 20px 0 10px -10px;"><?= summa().' '?>
							 <span id='poctRashod' class="label label-important"><?=$poctRash?></span></span><br>
						  <div id="clear_zakazat">
						  <input id="metall_kn" class="btn btn-success" type="submit" style="position: relative;float: right;width: 140px;"
							value="Заказать" data-original-title="" title="">
				        </div>
						</form>
					 <form action="basket.php" method="post" style="position: absolute;margin-top: -40px;">
						<input type="hidden" name="go_print" value="1"/>
						<input class="btn btn-primary" type="submit"  value="Назад" data-original-title="" title="">
					 </form>
					 </div>
				  </div>
				  <script language='javascript'>
					 var formvalidator = new FormValidator("validatedform");
					 formvalidator.initValidation();
				  </script>
				<?
		   }
		  }
	  else
		   {
			 ?>
			 <div class="drop-shadow lifted" style="margin: 50px 0 0 480px;">
				<div style="font-size: 24px;">Ваша корзина пуста!</div>
			 </div>
			 <?
			 }
			 ?>
		</div>
		</div>
	 <?
	 }

  if (isset($_SESSION['basket_ok']))
	 {
		?>
		<script type='text/javascript'>
		  humane.timeout = 6000;
		  humane.success("<?=$_SESSION['basket_ok']?>");
		</script>
		<?
		unset($_SESSION['basket_ok']);
	 }


  if (isset($_SESSION['basket_err']))
	 {
		?>
		<script type='text/javascript'>
		  humane.timeout = 6000;
		  humane.error("<?=$_SESSION['basket_err']?>");
		</script>
		<?
		unset($_SESSION['basket_err']);
	 }

?>
  <div class="end_content"></div>
  </div>
<?
  include_once (BASEPATH.'/inc/footer.php');
?>