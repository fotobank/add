<?php
    include (dirname(__FILE__).'/inc/head.php');

?>
<script language=JavaScript type="text/javascript">

function ajaxAdd(data) {

				$.ajax({
					type: "POST",
					header: ('Content-Type: application/json; charset=utf-8;'),
					url: '/inc/ajaxZakazDel.php',
					data: data,

					error:function(XHR) {
						alert(" ������: "+XHR.status+ "  " + XHR.statusText);
					},
					statusCode: {
						404: function() {
							alert("�������� �� �������");
						}
					},

					success: function (html) {
//  alert (html);
						var ans = JSON.parse(html);
						if (ans.add == 1) {
						dhtmlx.message({
							text: "���������� � "+ans.nm+"<br> ���������� � �������",
							expire:9000,
							type:"addfoto" // 'customCss' - css �����
						});
						} else {
							dhtmlx.message({
								text: "���������� � "+ans.nm+"<br> ������� �� �������",
								expire:12000
							});
						}
						if(ans.fDel == 1) {
	$('#ramka'+ans.id).empty().html("<div style='margin:25px 0 0 5px;'><img style='width: 140px; float: left; margin-left: 5px;' src= '/img/not_foto.png'></div>';")
						} else {
						   $('#fKoll'+ans.id).empty().append(ans.fKoll+' ��');
							$('#fSumm'+ans.id).empty().append(ans.fSumm+' ��');
						}
						$('#iTogo').empty().append('�����: '+ans.sum+'  ������� - '+ans.prKoll+' ���� (13x18 ��)');
					}
				});
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
		      <div style="font-size: 24px;">������� �������� ������ �������������� �������������!</div>
		      ������� �� ���� ��� ����� �������.
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
        $sum+= floatval($rs)*intval($val);
      }
        else
      {
        unset($_SESSION['basket'][$ind]);
      }
      }
    if($sum > $user_balans)
      {
       $_SESSION['order_msg'] = '������������ ������� �� �������!<br> ��������� ���� ��� �������� ������ ���������� ��������.';
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
      $title = '���������� Creative line studio';
      $headers  = "Content-type: text/plain; charset=windows-1251\r\n";
      $headers .= "From: ������������� Creative line studio \r\n";
      $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w","k")).'?=';
      $letter = "������������, $user_data[us_name]!\r\n";
      $letter.= "��� ������������ ������ ��� ���������� ��������� ����:.\r\n\r\n";
    foreach($download_ids as $ind => $val)
      {
        $letter.= 'http://'.$_SERVER['HTTP_HOST']."/download.php?key=$val\r\n";
      }
      $letter.= "\r\n��������! ��� ���������� ���������� ������� ����� ������������ �� �����! ������ ������������� 48 �����!\r\n";
        // ���������� ������
    if (!mail($user_data['email'], $subject, $letter, $headers))
      {
	      $db->query('delete from orders where id = ?i', array($id_order));
	      $db->query('delete from order_items where id_order = ?i', array($id_order));
	      $db->query('delete from download_photo where id_order = ?i', array($id_order));
         $_SESSION['order_msg'] = '������ �������� ������ �� ��������! �������� ���� ����������. ����������, ������� �����.';
	      trigger_error("������ �������� ������ �� ��������!");
      }
      else
      {
      $_SESSION['basket'] = array();
      $_SESSION['order_msg'] = '����� �������! ��� �� ����� ���������� ������ �� ������� ������ ��� ���������� ����!';
	      $db->query('update users set balans = balans - ?f where id = ?i', array($sum,$id_user));
	      trigger_error("����������� ������� ����������!");
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
      $sum = 0;
   ?>
		    <?
	if($_SESSION['print'] == 1)
			  {
			 ?>
		    <div class="drop-shadow lifted" style="margin: 20px 0 20px 250px;" >
			    <div style="font-size: 24px;">��������������� ���������� �� ������ ���������� � ������� �����</div>
		    </div>
				    <span class="label label-info" style="margin: 0 0 0 80px;">
					    ���� 9x12��, 13x18�� - 12 ���, 20x30�� - 40 ���
				    </span>
				    <div style="clear: both;"></div>
				    <?
			    } else {
				    ?>
			    <div class="drop-shadow lifted" style="margin: 20px 0 20px 500px;" >
				    <div style="font-size: 24px;">���� �������</div>
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
onclick="goKorzDel('<?=$photo_data['id']?>', '<?=$_SESSION['print']?>');"
		  ></span>
	  <img src="dir.php?num=<?=substr(($photo_data['img']),2,-4)?>" alt="<?=$photo_data['nm']?>" title="<?=$photo_data['nm']?>"><br>
     <span class="foto_prev_nm" style="margin-top: -20px; margin-left: 0; text-align: center;"><b>�  <?=$photo_data['nm']?></b></span>
	     <?
	      if($_SESSION['print'] == 1)
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
			     <span id="<?='fKoll'.$photo_data['id'] ?>" class="label label-warning" style="float: left; margin-left: 2px;"><?=$_SESSION['basket'][$photo_data['id']]?> ��</span>
			     <span class="label label-success" style="float: right;"><?=$photo_data['pecat']?> ���</span>
		     </div>
	     </div>
	     <span><b>�����:</b></span>
        <span id="<?='fSumm'.$photo_data['id'] ?>" class="label label-success" style="float: right; margin-right: -2px;">
	        <?=floatval($_SESSION['basket'][$photo_data['id']]*$photo_data['pecat'])?> ���</span>
			      <?
		      } else {
			      ?>
	     <span class="label label-success" style="margin-left: 96px"><?=$photo_data['price']?> ���</span>
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


 $print=iTogo();
		    if(isset($_SESSION['print']) &&  $_SESSION['print'] == 0)
		    {
			  ?>
		    <table style="margin-top: 50px;">
			    <tr>
				    <td>
       <span id="iTogo" class="label label-important" style="margin: 0 0 10px 0;"><?='�����: '.$print['price'].' ������� - '.$print['file'].' ����'?></span>
				    </td>
			    </tr>
			    <tr>
				    <td>
        <form action="basket.php" method="post">
          <input type="hidden" name="go_order" value="1" />
          <input class="metall_knopka" type="submit" value="�������� � �������� � �������� ����" />
        </form>
				    </td>
				    <td>
<span class="label label-important" style="text-align: center; margin-bottom: 20px; margin-left: 50px;"><b>���</b></span>
				    </td>
				    <td>
					    <form action="basket.php" method="post">
						    <input type="hidden" name="go_print" value="1" />
		    <input class="metall_knopka" type="submit" style="margin-left: 50px;" value="������� ����� ������ ������" />
					    </form>
				    </td>
			    </tr>
		    </table>
		    <?
		    }
		    else
			 {

		    ?>
				 <table style="margin-top: 50px;">
					 <tr>
						 <td>
				 <span id="iTogo" class="label label-important" style="margin: 20px 0 0 80px;">
					 �����: <?=$print['pecat']?> ������� - <?=$print['koll']?> ���� (13x18 ��)</span>
						 </td>
					 </tr>
					 <tr>
						 <td>
               <form action="basket.php" method="post" style="float: left; margin-right: 50px;">
					  <input type="hidden" name="go_back" value="1" />
					  <input class="metall_knopka" type="submit" value="�����" style="margin-top: 15px;" />
				   </form>
						 </td>
						 <td>
				 <form action="basket.php" method="post">
					 <input type="hidden" name="go_forma" value="1" />
					 <input class="metall_knopka" type="submit" value="�����" style="margin-top: 15px;" />
				 </form>
				 </td>
				 </tr>
				 </table>
	        <?
		    }
	    }
    else
	    { ?>
	    <div class="drop-shadow lifted" style="margin: 50px 0 0 480px;" >
		    <div style="font-size: 24px;">���� ������� �����!</div>
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