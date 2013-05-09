<?php
    include (dirname(__FILE__).'/inc/head.php');

    if(isset($_GET['del']))
      {
	unset($_SESSION['basket'][intval($_GET['del'])]);
      }

    if(!isset($_SESSION['logged']))
      {
	  ?>
	      <div class="drop-shadow lifted" style="margin: 150px 0 0 290px;" >
		      <div style="font-size: 24px;">Корзина доступна только авторизованным пользователям!</div>
		      Зайдите на сайт под своим логином.
	      </div>
	  <?
      }
        else
      {

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
       $_SESSION['order_msg'] = 'Недостаточно средств на балансе!';
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
  ?>
  <div id="main"> 
    <?
    if(isset($_SESSION['order_msg2']))
    {
    	?>
		    <div class="drop-shadow lifted" style="margin: 50px 0 0 155px;" >
			    <div style="font-size: 22px;"><?=$_SESSION['order_msg2']?></div>
		    </div><br><br><br><br>
    	<?
    	unset($_SESSION['order_msg2']);
    }
    if(isset($_SESSION['order_msg']))
    {
    	$_SESSION['order_msg2'] = $_SESSION['order_msg'];
    	unset($_SESSION['order_msg']);
    }    
    if(isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0):            
      $sum = 0;
   ?>
   <div style="margin-top: 40px"></div>

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

     <div style="width: 170px; ; height: 280px; float: left;">
     <li class="span2" style="margin-left: 30px; width: 160px; height: 300px;">
     <div class="thumbnail img-polaroid foto">
	 <a class="del" href="basket.php?del=<?=$ind?>" style="margin-left: 140px; margin-bottom: 0px; margin-top: -12px; z-index: 1" ></a>
	  <img src="dir.php?num=<?=substr(($photo_data['img']),2,-4)?>" alt="<?=$photo_data['nm']?>" title="<?=$photo_data['nm']?>"><br>
     <span class="foto_prev_nm" style="margin-top: -20px; margin-left: 0; text-align: center;">№  <?=$photo_data['nm']?></span>
     <span class="label label-success" style="margin-left: 96px"><?=$photo_data['price']?> грн.</span>
	 </div>

     </li>   
     </div>
     <?
     }
   }	  
	 ?>
  </ul>
      <div id="foto_prev">
       <span class="label label-important" style="margin: 0 0 10px 73px"> ИТОГО: <b><?=$sum?> грн.</b></span>
        <form action="basket.php" method="post" style="margin-bottom: -100px">
          <input type="hidden" name="go_order" value="1" />
          <input class="metall_knopka" type="submit" value="Оплатить и получить в виде файла" />
        </form>
      </div>

    <? else: ?>
	    <div class="drop-shadow lifted" style="margin: 50px 0 0 480px;" >
		    <div style="font-size: 24px;">Ваша корзина пуста!</div>
	    </div>
    <? endif; ?>
 </div>


<?
}
?>
	<div class="end_content"></div>
	</div>
<?
include (dirname(__FILE__).'/inc/footer.php');
?>