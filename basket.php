<?php
    include (dirname(__FILE__).'/inc/head.php');

    if(isset($_GET['del']))
      {
	unset($_SESSION['basket'][intval($_GET['del'])]);
      }
    if(!isset($_SESSION['logged']))
      {
	  ?>
      <link href="css/main.css" rel="stylesheet" type="text/css" />
	  Корзина доступна только авторизованным пользователям!
	  <?
      }
        else
      {
    if(isset($_POST['go_order']) && isset($_SESSION['basket']) && is_array($_SESSION['basket']) && count($_SESSION['basket']) > 0)
      {
	     $id_order = $db->query('insert into orders (id_user, dt) values (?i,?)', array($_SESSION['userid'],time()),'id');
  $test = mysql_errno();
    if(mysql_errno() == 0)
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
	   $tmp = $db->query('insert into download_photo (id_user, id_order, id_order_item, id_photo, dt_start, download_key)
                                values (?i,?i,?i,?i,?i,?i)', array($id_user, $id_order, $id_item, $ind, $tm, $key),'id');

      $download_ids[$tmp] = $key;
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
      $letter.= "\r\nВНИМАНИЕ! Для скачивания фотографий сначала нужно войти на сайт! Скачивание доступно только зарегистрированным пользователям!\r\n";
        // Отправляем письмо
    if (!mail($user_data['email'], $subject, $letter, $headers))
      {
	      $db->query('delete from orders where id = ?i', array($id_order));
	      $db->query('delete from order_items where id_order = ?i', array($id_order));
	      $db->query('delete from download_photo where id_order = ?i', array($id_order));
      $_SESSION['order_msg'] = 'Ошибка отправки письма со ссылками! Обратитесь к администрации!';
      }
      else
      {
      $_SESSION['basket'] = array();
      $_SESSION['order_msg'] = 'Заказ оплачен! Вам на почту отправлено письмо со списком ссылок для скачивания фото!';
	      $db->query('update users set balans = balans - \''.$sum.'\' where id = '.$id_user);
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
      <div style="margin: 20px; color: #fff; font-size: 24px; ">
        <?=$_SESSION['order_msg2']?>
      </div>
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
	  <a class="del" href="basket.php?del=<?=$ind?>" style="margin-left: 174px; margin-bottom: 0px; margin-top: -5px;" ></a>
     <li class="span2" style="margin-left: 30px; width: 160px; height: 300px;">
     <div class="thumbnail img-polaroid">
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
       <span class="label label-important" style="margin-bottom: 10px"> ИТОГО: <b><?=$sum?> грн.</b></span>
        <form action="basket.php" method="post">
          <input type="hidden" name="go_order" value="1" />
          <input class="metall_knopka" type="submit" value="Оплатить" />
        </form>
      </div>
    <? else: ?>
      <div style="margin: 20px; font-size: 24px; ">
        Ваша корзина пуста!
      </div>
    <? endif; ?>
 </div>
 <div class="end_content"></div>
 </div>
<?
}
include (dirname(__FILE__).'/inc/footer.php');
?>