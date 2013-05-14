<?php
    include (dirname(__FILE__).'/inc/head.php');

?>
<script language=JavaScript type="text/javascript">

	</script>
<?

    if(!isset($_SESSION['logged']))
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

	 if(isset($_POST['go_back']))
		 {
			 $_SESSION['print'] = 1;
		 }


    if(isset($_POST['go_order']) && isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
      {
	      $mysqlErrno = 0;
	      $id_order = 0;
	       try {
	  $id_order = $db->query('insert into orders (id_user, dt) values (?i,?i)', array($_SESSION['userid'],time()),'id');
	      } catch (go\DB\Exceptions\Query $e) {
		      trigger_error("
			                  'SQL-query: ".$e->getQuery()."\n'
                           'Error description: ".$e->getError()."\n'
                           'Error code: ".$e->getErrorCode()."\n'
		       ");
		      $mysqlErrno = 1;
	      }
    if($mysqlErrno == 0)
      {
	$order = iTogo();
    if($order['price'] > $user_balans)
      {
       $_SESSION['order_msg'] = 'Недостаточно средств на балансе!<br> Пополните счет или закажите печать наложенным платежем.';
	      $db->query('delete from orders where id = ?i', array($id_order));
      }
      else
      {
      $tm = time();
      $download_ids = array();
      $id_user = intval($_SESSION['userid']);
    foreach($_SESSION['basket'] as $ind => $val)
      {
	   $id_item = $db->query('insert into order_items (id_order, id_photo) values (?i,?i)', array($id_order, $ind), 'id');
      $key = md5($id_item.$tm.$id_order.mt_rand(1, 10000));
	   $id = intval($db->query('insert into download_photo (id_user, id_order, id_order_item, id_photo, dt_start, download_key)
                                values (?i,?i,?i,?i,?i,?string)', array($id_user, $id_order, $id_item, $ind, $tm, $key),'id'));

      $download_ids[$id] = $key;
      }
	   $user_data = $db->query('select * from users where id = ?i', array($id_user),'row');
      $title = 'Фотографии Creative line studio';
      $headers  = "Content-type: text/plain; charset=windows-1251\r\n";
      $headers .= "From: Администрация Creative line studio \r\n";
      $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w","k")).'?=';
      $letter = "Здравствуйте, $user_data[us_name]!\r\n";
      $letter.= "Вам предоставлен доступ для скачивания следующих фото:.\r\n\r\n";
    foreach($download_ids as $ind => $val)
      {
        $letter.= 'http://'.$_SERVER['HTTP_HOST']."/download.php?key=$val\r\n";
      }
      $letter.= "\r\nВНИМАНИЕ! Для скачивания фотографий сначала нужно залогиниться на сайте! Ссылки действительны 48 часов!\r\n";
        // Отправляем письмо
    if (!mail($user_data['email'], $subject, $letter, $headers))
      {
	      $db->query('delete from orders where id = ?i', array($id_order));
	      $db->query('delete from order_items where id_order = ?i', array($id_order));
	      $db->query('delete from download_photo where id_order = ?i', array($id_order));
         $_SESSION['order_msg'] = 'Ошибка отправки письма со ссылками! Возможно сайт перегружен. Пожалуйста, зайдите позже.';
	      trigger_error("Ошибка отправки письма со ссылками!");
      }
      else
      {
      $_SESSION['basket'] = array();
      $_SESSION['order_msg'] = 'Заказ оплачен! Вам на E-mail отправлено письмо со списком ссылок для скачивания фото!';
	      $db->query('update users set balans = balans - ?f where id = ?i', array($order['price'],$id_user));
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
if(isset($_POST['go_print']) && count($_SESSION['basket']) > 0)
{
			  $_SESSION['print'] = 1;
}

if(isset($_POST['mat_gl']) && count($_SESSION['basket']) > 0)
   {
      $_SESSION['print'] = 2;
	   $_SESSION['basket']['ramka'] = trim($_POST['ramka']);
	   $_SESSION['basket']['mat_gl'] = trim($_POST['mat_gl']);
	   $_SESSION['basket']['format'] = trim($_POST['format']);
   }

if(isset($_POST['go_mail']) && count($_SESSION['basket']) > 0)
   {
      $_SESSION['print'] = 3;
   }


if(isset($_SESSION['order_msg2']))
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
    if(isset($_SESSION['order_msg']))
    {
    	$_SESSION['order_msg2'] = $_SESSION['order_msg'];
    	unset($_SESSION['order_msg']);
    }




if(isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
	    {

	if(isset($_SESSION['print']) && $_SESSION['print'] == 1)
			  {
			 ?>
		    <div class="drop-shadow lifted" style="margin: 20px 0 20px 250px;" >
			    <div style="font-size: 24px;">Откорректируйте количество на каждой фотографии и нажмите далее</div>
		    </div>
				    <span class="label label-info" style="margin: 0 0 0 80px;">
					    Цена 10x15см, 13x18см - 12 грн, 20x30см - 40 грн
				    </span>
				    <div style="clear: both;"></div>
				    <?
			 } elseif($_SESSION['print'] == 0 || $_SESSION['print'] == 2 || $_SESSION['print'] == 3)
		{
				    ?>
			    <div class="drop-shadow lifted" style="margin: 20px 0 20px 500px;" >
				    <div style="font-size: 24px;">Ваша корзина</div>
			    </div>
			    <div style="clear: both;"></div>
			    <?
	   }
   if(isset($_SESSION['print']) && $_SESSION['print'] == 0 || isset($_SESSION['print']) && $_SESSION['print'] == 1)
     {
			    ?>
	<ul class="thumbnails">
   <?    
   foreach($_SESSION['basket'] as $ind => $val)
   {
	   $photo_data = $db->query('select * from photos where id = ?i', array($ind), 'row');

    if(!$photo_data)
      {
    if($ind != "ramka" and $ind != "mat_gl" and $ind != "format" )
	   {
        unset($_SESSION['basket'][$ind]);
      }
      }
        else
      {
     ?>
     <div style="width: 170px; ; height: 290px; float: left;">
	     <div id="<?='ramka'.$photo_data['id'] ?>"
	     <li class="span2" style="margin-left: 30px; width: 160px; height: 300px;">
     <div class="thumbnail img-polaroid foto">
	     <span class="del"  style="margin-left: 140px; margin-bottom: 0; margin-top: -12px; z-index: 1"
		     onclick="goKorzDel('<?=$photo_data['id']?>', '<?=$_SESSION['print']?>');" ></span>
	  <img src="dir.php?num=<?=substr(($photo_data['img']),2,-4)?>" alt="<?=$photo_data['nm']?>" title="<?=$photo_data['nm']?>"><br>
     <span class="foto_prev_nm" style="margin-top: -20px; margin-left: 0; text-align: center;"><b>№  <?=$photo_data['nm']?></b></span>
	     <?
if(isset($_SESSION['print']) && $_SESSION['print'] == 1)
		   {
	     ?>
	     <div style="display: inline">
		     <div style="float: left; height: 20px; width: 152px;">
				     <button class="btn-mini btn-info"
                 onclick="ajaxAdd('goZakazAdd='+'<?= $photo_data['id'] ?>'+'&add='+'1');"
					     style="float:left; width: 28px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;">+</button>
				     <button class="btn-mini btn-info"
                 onclick="ajaxAdd('goZakazAdd='+'<?= $photo_data['id'] ?>'+'&add='+'-1');"
					     style="float:left; width: 28px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;">-</button>
			     <span id="<?='fKoll'.$photo_data['id'] ?>" class="label label-warning" style="float: left; margin-left: 2px;"><?=$_SESSION['basket'][$photo_data['id']]?> шт</span>
			     <span class="label label-success" style="float: right;"><?=$photo_data['pecat']?> грн</span>
		     </div>
	     </div>
	     <span><b>Всего:</b></span>
        <span id="<?='fSumm'.$photo_data['id'] ?>" class="label label-success" style="float: right; margin-right: -2px;">
	        <?=floatval($_SESSION['basket'][$photo_data['id']]*$photo_data['pecat'])?> грн</span>
			      <?
		  } elseif(isset($_SESSION['print']) && $_SESSION['print'] == 0) {
			      ?>
	     <span class="label label-success" style="margin-left: 96px"><?=$photo_data['price']?> грн</span>
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

 $print=iTogo();
		    if(isset($_SESSION['print']) &&  $_SESSION['print'] == 0)
		    {
			  ?>
		    <table style="margin-top: 50px;">
			    <tr>
				    <td>
       <span id="iTogo" class="label label-important" style="margin: 0 0 10px 0;"><?='ИТОГО: '.$print['price'].' гривень - '.$print['file'].' фото'?></span>
				    </td>
			    </tr>
			    <tr>
				    <td>
        <form action="basket.php" method="post">
          <input type="hidden" name="go_order" value="1" />
          <input class="metall_knopka" type="submit" value="Оплатить и получить в цифровом виде" />
        </form>
				    </td>
				    <td>
<span class="label label-important" style="text-align: center; margin-bottom: 20px; margin-left: 50px;"><b>или</b></span>
				    </td>
				    <td>
					    <form action="basket.php" method="post">
						    <input type="hidden" name="go_print" value="1" />
		    <input class="metall_knopka" type="submit" style="margin-left: 50px;" value="Открыть форму заказа печати" />
					    </form>
				    </td>
			    </tr>
		    </table>
		    <?
		    }
		    elseif(isset($_SESSION['print']) &&  $_SESSION['print'] == 1)
			 {
			    if(!isset($_SESSION['basket']['ramka'])) $_SESSION['basket']['ramka'] = 0;
		       if(!isset($_SESSION['basket']['mat_gl']))	$_SESSION['basket']['mat_gl'] = 'глянцевая';
		       if(!isset($_SESSION['basket']['format']))	$_SESSION['basket']['format'] = '13x18';
             $fFormat = array('10x15','13x18','20x30');
				 $fBum = array('глянцевая','матовая');
		    ?>
		<div id="form_reg" style="position: relative; width: 380px; height: 176px; z-index: 12; margin-bottom: 0; margin-top: 40px;">
		 <div id="pr_Form" style="position:absolute;left:24px;top:-10px;width:280px;z-index:12;">
			<form name="printMail" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="printMail">
			 <label id="pr_Name1" style="position: absolute; left: 0; top: 32px; width: 160px; height: 14px; z-index: 0; text-align: left;" for="format">
				 <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Размер фотографии:</span> </label>
			 <select id="format" style="position: absolute; left: 142px; top: 30px; width: 204px; height: 25px; z-index: 1;" size="1" name="format">
				 <?
				 foreach ($fFormat as $format)
					 {
				 ?>
				 <option value='<?=$format?>' <?=($_SESSION['basket']['format'] == $format ? 'selected="selected"' : '')?>
					 onclick="ajaxFormat('goFormat='+'<?= $_SESSION['basket']['format'] ?>');"
					 ><?=$format?> см</option>
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
						 <option value='<?=$bum?>' <?=($_SESSION['basket']['mat_gl'] == $bum ? 'selected="selected"' : '')?>><?=$bum?></option>
					   <?
					 }
				 ?>
			 </select>
			 <label id="pr_Name3" style="position:absolute;left:0;top:94px;width:114px;height:14px;z-index:2;text-align:left;" for="ramka">
				 <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Белая рамка:</span></label>
				 <input type="hidden" name="ramka" value="0" />
				 <input type="checkbox" id="ramka" name="ramka" value="1"
					 <? if ($_SESSION['basket']['ramka'])
					 {
						 echo 'checked="checked"';
					 } ?>
					 style="position:absolute;left:145px;top:94px;z-index:3;"/>
				<input class="metall_knopka" type="submit" style="position: absolute; left: 273px; top: 153px; z-index: 13;" value="Далее" data-original-title="" title="">
			 </form>
			  <span id="iTogo" class="label label-important" style="position:absolute;left:60px;top:128px;z-index:0;text-align:left;">
                     ИТОГО: <?=$print['pecat']?> гривень - <?=$print['koll']?> фото (13x18 см)</span>
<div style="position:absolute;left:0;top:138px;z-index:0;text-align:left;">
									 <form action="basket.php" method="post" style="float: left;">
										 <input type="hidden" name="go_back" value="1" />
										 <input class="metall_knopka" type="submit" value="Назад" style="margin-top: 15px;" />
									 </form>
									 <form action="basket.php" method="post"  style="float: right; margin-right: -265px;">

									 </form>
</div>
								 </div>
							 </div>

	        <?
		    } elseif(isset($_SESSION['print']) &&  $_SESSION['print'] == 2)
			    {
?>
				    <div id="form_reg" style="position: relative;left:54px;width:380px;height:328px;z-index:12; display: inline-block;">
					    <div id="pr_Form" style="position:absolute;left:24px;top:-10px;width:280px;height:328px;z-index:12;">
						    <form name="printMail" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Form1">

							    <label for="Combobox3"id="pr_Name1" style="position:absolute;left:0;top:40px;width:114px;height:14px;z-index:11;text-align:left;">
								    <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Способ оплаты:</span></label>
							    <select name="Combobox" size="1" id="Combobox3" style="position:absolute;left:120px;top:40px;width:204px;height:25px;z-index:10;">
							    </select>


							    <label for="Combobox1"id="pr_Name2" style="position:absolute;left:0;top:72px;width:114px;height:14px;z-index:0;text-align:left;">
								    <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Тип бумаги:</span></label>
							    <select name="Combobox1" size="1" id="Combobox1" style="position:absolute;left:120px;top:72px;width:204px;height:25px;z-index:1;">
							    </select>


							    <label for="Checkbox1" id="pr_Name3" style="position:absolute;left:0;top:104px;width:114px;height:14px;z-index:2;text-align:left;">
								    <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Белая рамка:</span></label>
							    <input type="checkbox" id="Checkbox1" name="" value="on" style="position:absolute;left:125px;top:104px;z-index:3;"/>


							    <label for="Editbox1" id="pr_Name4" style="position:absolute;left:0;top:136px;width:114px;height:28px;z-index:4;text-align:left;">
								    <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Ваш телефон:</span></label>
							    <input type="text" id="Editbox1"
								    style="position:absolute;left:120px;top:134px;width:200px;height:23px;line-height:23px;z-index:5;" name="Editbox1" value=""/>


							    <label for="Combobox2" id="pr_Name5" style="position:absolute;left:0;top:168px;width:120px;height:14px;z-index:6;text-align:left;">
								    <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Почтовая служба:</span></label>
							    <select name="Combobox2" size="1" id="Combobox2" style="position:absolute;left:120px;top:168px;width:204px;height:25px;z-index:7;">
							    </select>


							    <label for="pr_adress" id="pr_Name6" style="position:absolute;left:0;top:230px;width:114px;height:52px;z-index:8;text-align:left;">
								    <span style="color:#000000;font-family:Arial,serif;font-size:14px;">Адрес<br> почтового отделения:</span></label>
							    <textarea name="pr_adress" id="pr_adress" style="position:absolute;left:100px;top:211px;width:220px;height:110px;z-index:9;"
								    rows="5" cols="32"></textarea>


						    </form>
					    </div>
				    </div>


				    <table style="margin-top: 50px;margin-left: 44px;">
					    <tr>
						    <td>
				 <span id="iTogo" class="label label-important" style="margin: 20px 0 0 80px;">
					 ИТОГО: <?=$print['pecat']?> гривень - <?=$print['koll']?> фото (13x18 см)</span>
						    </td>
					    </tr>
					    <tr>
						    <td>
							    <form action="basket.php" method="post" style="float: left; margin-right: 50px;">
								    <input type="hidden" name="go_print" value="1" />
								    <input class="metall_knopka" type="submit" value="Назад" style="margin-top: 15px;" />
							    </form>
						    </td>
						    <td>
							    <form action="basket.php" method="post">
								    <input type="hidden" name="go_mail" value="1" />
								    <input class="metall_knopka" type="submit" value="Заказать" style="margin-top: 15px;" />
							    </form>
						    </td>
					    </tr>
				    </table>
			    <?

			    }elseif(isset($_SESSION['print']) &&  $_SESSION['print'] == 3)
			    {

				    if(isset($_POST['go_mail']) && isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
					    {
						    $mysqlErrno = 0;
						    $id_order = 0;
						    $mat_gl = '';
						    $ramka = '';
						    $phone = '';
						    $id_pocta = '';
						    $adress_otpr = '';
						    $order = '';
						    $id_nal = '';
						    try {
							    $id_order = $db->query('insert into print_order (mat_gl,ramka,id_user,dt,phone,id_pocta,order,adress_otpr,id_nal)
							     values (?,?i,?i,?i,?string,?i,?f,?string,?i)',
								    array($mat_gl,$ramka,$_SESSION['userid'],time(),$phone,$id_pocta,$order,$adress_otpr,$id_nal),'id');
						    } catch (go\DB\Exceptions\Query $e) {
							    trigger_error("
			                  'SQL-query: ".$e->getQuery()."\n'
                           'Error description: ".$e->getError()."\n'
                           'Error code: ".$e->getErrorCode()."\n'
		                                 ");
							    $mysqlErrno = 1;
						    }

						  if($mysqlErrno == 0)
							    {
								    $order = iTogo();
								    if($order['pecat'] > $user_balans)
									    {
										    $_SESSION['order_msg'] = 'Недостаточно средств на балансе!<br> Пополните счет или закажите печать наложенным платежем.';
										    $db->query('delete from orders where id = ?i', array($id_order));
									    }
								    else
									    {
										    $tm = time();
										    $download_ids = array();
										    $id_user = intval($_SESSION['userid']);
										    foreach($_SESSION['basket'] as $ind => $val)
											    {
												    $id_item = $db->query('insert into order_items (id_order, id_photo) values (?i,?i)', array($id_order, $ind), 'id');
												    $key = md5($id_item.$tm.$id_order.mt_rand(1, 10000));
												    $id = intval($db->query('insert into download_photo (id_user, id_order, id_order_item, id_photo, dt_start, download_key)
                                values (?i,?i,?i,?i,?i,?string)', array($id_user, $id_order, $id_item, $ind, $tm, $key),'id'));

												    $download_ids[$id] = $key;
											    }
										    $user_data = $db->query('select * from users where id = ?i', array($id_user),'row');
										    $title = 'Фотографии Creative line studio';
										    $headers  = "Content-type: text/plain; charset=windows-1251\r\n";
										    $headers .= "From: Администрация Creative line studio \r\n";
										    $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w","k")).'?=';
										    $letter = "Здравствуйте, $user_data[us_name]!\r\n";
										    $letter.= "Вам предоставлен доступ для скачивания следующих фото:.\r\n\r\n";
										    foreach($download_ids as $ind => $val)
											    {
												    $letter.= 'http://'.$_SERVER['HTTP_HOST']."/download.php?key=$val\r\n";
											    }
										    $letter.= "\r\nВНИМАНИЕ! Для скачивания фотографий сначала нужно залогиниться на сайте! Ссылки действительны 48 часов!\r\n";
										    // Отправляем письмо
										    if (!mail($user_data['email'], $subject, $letter, $headers))
											    {
												    $db->query('delete from orders where id = ?i', array($id_order));
												    $db->query('delete from order_items where id_order = ?i', array($id_order));
												    $db->query('delete from download_photo where id_order = ?i', array($id_order));
												    $_SESSION['order_msg'] = 'Ошибка отправки письма со ссылками! Возможно сайт перегружен. Пожалуйста, зайдите позже.';
												    trigger_error("Ошибка отправки письма со ссылками!");
											    }
										    else
											    {
												    $_SESSION['basket'] = array();
												    $_SESSION['order_msg'] = 'Заказ оплачен! Вам на E-mail отправлено письмо со списком ссылок для скачивания фото!';
												    $db->query('update users set balans = balans - ?f where id = ?i', array($order['price'],$id_user));
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


				    <div class="drop-shadow lifted" style="margin: 50px 0 0 150px;" >
		          <div style="font-size: 24px;">Вам на E-mail отправлено письмо для подтверждения заказа. Проверьте, пожалуйста, почту. </div>
	             </div>
				    <?
			    }
	    }
    else
	    { ?>
	    <div class="drop-shadow lifted" style="margin: 50px 0 0 480px;" >
		    <div style="font-size: 24px;">Ваша корзина пуста!</div>
	    </div>
    <? }

		      ?>
 </div>
<?
}
?>
	<div class="end_content"></div>
	</div>
<?
include (dirname(__FILE__).'/inc/footer.php');
?>