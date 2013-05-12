<?php
    include (dirname(__FILE__).'/inc/head.php');
?>
	<script language=JavaScript type="text/javascript">
		function goKorzDel(idName) {
	$('#ramka'+idName).empty().html("<div style='margin:25px 0 0 5px;'><img style='width: 140px; float: left; margin-left: 5px;' src= '/img/not_foto.png'></div>';");
	$('#iTogo').empty().load('/inc/ajaxPecatDel.php', {goPecatDel: idName });

		}
	</script>
<?

    if(isset($_GET['del']))
      {
	unset($_SESSION['basket'][intval($_GET['del'])]);
      }

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
      $sum = 0;
    foreach($_SESSION['basket'] as $ind => $val)
      {
        $rs = $db->query('select price from photos where id = ?i', array($ind), 'el');
    if($rs)
      {
        $sum+= floatval($rs);
      }
        else
      {
        unset($_SESSION['basket'][$ind]);
      }
      }
    if($sum > $user_balans)
      {
       $_SESSION['order_msg'] = 'Недостаточно средств на балансе!<br> Пополните счет или закажите печать наложенным платежом.';
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
      $_SESSION['order_msg'] = 'Заказ оплачен! Вам на почту отправлено письмо со списком ссылок для скачивания фото!';
	      $db->query('update users set balans = balans - ?f where id = ?i', array($sum,$id_user));
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
if(isset($_POST['go_print']) && $_SESSION['basket'] > 0)
{
			  $_SESSION['print'] = 1;
}

if(isset($_SESSION['order_msg2']))
    {
    	?>
	    <div style="position: relative">
		    <div style="position: absolute; margin-left: auto; margin-right: auto" class="drop-shadow lifted">
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
      $sum = 0;
   ?>
		    <?
		    if($_SESSION['print'] == 1)
			    {
			 ?>
		    <div class="drop-shadow lifted" style="margin: 20px 0 20px 250px;" >
			    <div style="font-size: 24px;">Откорректируйте количество на каждой фотографии и нажмите далее</div>
		    </div>
				    <div style="clear: both;"></div>
				    <?
			    } else {
				    ?>
			    <div class="drop-shadow lifted" style="margin: 20px 0 20px 500px;" >
				    <div style="font-size: 24px;">Ваша корзина</div>
			    </div>
			    <div style="clear: both;"></div>
			    <?
		    }
			    ?>
	<ul class="thumbnails">
   <?    
   foreach($_SESSION['basket'] as $ind => $val)
   {
       $rs = $db->query('select * from photos where id = ?i', array($ind), 'row');
    if(!$rs)
      {
        unset($_SESSION['basket'][$ind]);
      }
        else
      {
        $photo_data = $rs;
        $sum+= $photo_data['price'];			
     ?>

     <div style="width: 170px; ; height: 290px; float: left;">
	     <div id="<?='ramka'.$photo_data['id'] ?>"
	     <li class="span2" style="margin-left: 30px; width: 160px; height: 300px;">
     <div class="thumbnail img-polaroid foto">
	     <span class="del"  style="margin-left: 140px; margin-bottom: 0; margin-top: -12px; z-index: 1"
		     onclick="goKorzDel('<?=$photo_data['id']?>');"
		  ></span>
	  <img src="dir.php?num=<?=substr(($photo_data['img']),2,-4)?>" alt="<?=$photo_data['nm']?>" title="<?=$photo_data['nm']?>"><br>
     <span class="foto_prev_nm" style="margin-top: -20px; margin-left: 0; text-align: center;"><b>№  <?=$photo_data['nm']?></b></span>
	     <?
	      if($_SESSION['print'] == 1)
		      {
	     ?>
	     <div style="display: inline">
		     <div style="float: left; height: 20px; width: 152px;">

			     <form action="index.php" name="go_turn" method="post" style="margin: 0;" target="hiddenframe"
				     onsubmit="document.getElementById('<?= $photo_data['id'] ?>').innerHTML='Подождите, идёт загрузка...'; return true;">
				     <input class="btn" type="hidden" name="go_turn" value="<?= $photo_data['id'] ?>"/>
				     <input class="btn" type="hidden" name="povorot" value="270"/>
				     <input class="btn-mini btn-info" type="submit" value="+" style="float:left; width: 28px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;"/>
			     </form>
			     <form action="index.php" name="go_turn" method="post" style="margin: 0;" target="hiddenframe"
				     onsubmit="document.getElementById('<?= $photo_data['id'] ?>').innerHTML='Подождите, идёт загрузка...'; return true;">
				     <input class="btn" type="hidden" name="go_turn" value="<?= $photo_data['id'] ?>"/>
				     <input class="btn" type="hidden" name="povorot" value="90"/>
				     <input class="btn-mini btn-info" type="submit" value="-" style="float:left; width: 28px; height: 18px; padding: 0 0 0 0;  margin: 0 0 0 0;"/>
			     </form>
			     <span class="label label-warning" style="float: left">80 шт</span>
			     <span class="label label-success" style="float: right;"><?=$photo_data['price']?> грн</span>
		     </div>
	     </div>
	     <span><b>Всего:</b></span>
     <span class="label label-success" style="float: right; margin-right: -2px;">856.00 грн</span>
			      <?
		      } else {
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
		    if(isset($_SESSION['print']) &&  $_SESSION['print'] == 0)
		    {
			  ?>
		    <table style="margin-top: 50px;">
			    <tr>
				    <td>
       <span id="itogo" class="label label-important" style="margin: 0 0 10px 73px;"> ИТОГО: <b><?=$sum?> грн.</b></span>
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
		    <input class="metall_knopka" type="submit" style="margin-left: 50px;" value="Открыть форму заказ печати" />
					    </form>
				    </td>
			    </tr>
		    </table>
		    <?
		    }
		    else
			 {
		    ?>
				 <span id="iTogo" class="label label-important" style="margin: 0 0 10px 55px;"> ИТОГО: <b><?=$sum?> грн.</b></span>
               <form action="basket.php" method="post" style="float: left; margin-right: 50px;">
					  <input type="hidden" name="go_back" value="1" />
					  <input class="metall_knopka" type="submit" value="Назад" style="margin-top: 15px;" />
				   </form>
				 <form action="basket.php" method="post">
					 <input type="hidden" name="go_forma" value="1" />
					 <input class="metall_knopka" type="submit" value="Далее" style="margin-top: 15px;" />
				 </form>
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