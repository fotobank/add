<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 25.05.13
 * Time: 11:56
 * To change this template use File | Settings | File Templates.
 */

  set_time_limit(0);
  ini_set("display_errors","1");
  ignore_user_abort(1);
  require_once (__DIR__.'/inc/config.php');
  require_once (__DIR__.'/inc/func.php');


  if(!isset($_SESSION['logged']))
    err_exit('��� ������������� ������ ���������� ������������ �� �����!', 'index.php');
  if(!isset($_GET['key']))
    err_exit('���� �� ������!', 'index.php');
  $key = $_GET['key'];
  $data = $db->query('select * from `print` where `key` = ?string', array($key), 'row');
if(!$data)
  {
	 err_exit('���� �� ������!', 'index.php');
  }
else
  {
	 include (__DIR__.'/inc/head.php');
	 require_once (__DIR__.'/inc/lib_mail.php');
	 require_once (__DIR__.'/inc/http.php');


    if((time() - intval($data['dt']) > 172800) && $data['id_nal'] != '���������� ������� �����')
		{

		  //����������������� ��������� ������, ���� ���� ������� ������������ ������ � ����
		  // $db->query('delete from print where id = ?',array($data['id']));
		  // $db->query('delete from order_print where id_print = ?',array($data['id']));
		  ?>
		  <script type='text/javascript'>
			 dhtmlx.message.expire = 6000; // ����� ����� ���������
			 dhtmlx.message({ type: 'error', text: '����� � 48 ����� ��� ������������� ������ ������.'});
		  </script>
		  <div class="drop-shadow lifted" style="margin: 50px 0 0 320px;">
			 <div style="font-size: 24px;">����� � 48 ����� ��� ������������� ������ ������.</div>
			 <div style="font-size: 24px;">����� ���������� �����������.</div>
		  </div><br><br><br><br><br><br><br>
		  <?
		}
	 else
		{
		      $balans = $user_balans - $data['summ'];
		  if ($balans < 0 && $data['id_nal'] != '���������� ������')
			 {
				$_SESSION['order_msg'] = '������������ ������� �� �������! ����������  '.$data['summ'].' ��. ��������� ���� ���� �� ����� �����<br> ��������� ��� ��������.
				 ��� �������� ����� ����� ���������� ��������.';
				?>
				<script type="text/javascript">
				  location.replace("basket.php?1=1");
				</script>
			 <?
				die('������������ ������� �� �������! ����������  '.$data['summ'].' ��. ��������� ���� ���� �� ����� �����<br> ��������� ��� ��������.
				 ��� �������� ����� ����� ���������� ��������.');
			 }
		  else
			 {

				if(intval($data['zakaz']) == 1 && $data['status'] == 0) // ���� ����� ��� ��� �����������
				  {
					 ?>
					 <div class="drop-shadow lifted" style="margin: 50px 0 0 350px;">
						<div style="font-size: 24px;">����� �<?=$data['id']?> ���� ����� ������� �� ����������.</div>
						<div style="font-size: 24px;">�� ��� ���������� �� �������� �����������.</div>
					 </div><br><br><br><br><br><br><br>
				  <?
				  }
				else
				  {
		                                            /*todo: ����� �����*/
								try {
										$db->query('UPDATE `print` SET `zakaz` = ?b WHERE id = ?i', array('1',$data['id']));
										if ($data['id_nal'] != '���������� ������')
											 {
												$db->query('UPDATE `users` SET `balans` = ?f WHERE id = ?i',array($balans,$_SESSION['userid']));
											 }
									 }
								catch (go\DB\Exceptions\Exception $e)
									 {
										 die ('<br><br><br>������ ��� ������ � ����� ������: '.$e);
									 }


		   if ($data['id_nal'] != '���������� ������')
						{
         echo   "<script type='text/javascript'>
					 $('#balans').empty().append($balans);
					 </script>";
						}
	?>

		  <div class="drop-shadow lifted" style="margin: 50px 0 0 400px;">
			 <div style="font-size: 24px;">�������, ��� ����� �<?=$data['id']?> ������ � ���������. </div>
		  </div>
        <?
        /*todo: ������ ��������� */
		  $letter = '<html><body><h2>����� �'.$data['id'].'</h2>';
        $user = $db->query('SELECT * FROM `users` WHERE `id` = ?i',array($data['id_user']),'row');
		  $letter .= "<b>������������:</b> ".$user['us_name'].' '.$user['us_surname']."<br>";
		  $letter .= "<b>E-mail ������������:</b> ".$data['email']."<br>";
		  $letter .= "<b>Id ������������:</b> ".$data['id_user']."<br>";
		  $letter .= "<b>���� ������:</b> ".date('d.m.Y  H.i', $data['dt'])."<br>";
		  $letter .= "<b>����������:</b> ".$data['name'].'  '.$data['subname']."<br>";
		  $letter .= "<b>����� �������� ����������:</b> ".$data['phone']."<br>";
		  $letter .= "<b>������ ����������:</b> ".$data['format']." ��.<br>";
		  $letter .= "<b>������:</b> ".$data['mat_gl']."<br>";
		  $letter .= ($data['id_nal'] == '������') ? "<b>������ ������ ��������� �������������:</b> '".$data['user_opl'].",<br>":"<b>������ ������:</b> ".$data['id_nal']."<br>";
		  $letter .= ($data['id_dost'] == '������') ? "<b>������ �������� ��������� �������������:</b> '".$data['user_dost'].",<br>":"<b>��� ��������:</b> ".$data['id_dost']."<br>";
		  if($data['id_dost'] == '��������� �� ��������� ��������� ������ ������' || $data['id_dost'] == '�������� �� ����� �������� ������� (����� ������)')
			 {
				$letter .= "<b>������������ ������ ��������:</b> ".$data['subname'].",<br>";
				$letter .= "<b>����� ��������� ��������� ��� ����������:</b><br> ".$data['subname']."<br>";
			 }
		  if($data['id_dost'] == '��������� �� ������ (� ������)') $letter .= "<b>����� ������ ��� ��������� ����������:</b> '".$data['adr_studii']."'<br>";
		  $letter .= "<b>���������� ������������:</b><br>".$data['comm']."<br>";
		  $nmAlb = $db->query('SELECT a.nm FROM albums a, photos p, order_print o WHERE a.id = p.id_album  AND o.id_photo = p.id AND o.id_print = ?i LIMIT 1',array($data['id']),'el');
		  $photo_data = $db->query('select * from `order_print` where `id_print` = ?i', array($data['id']), 'assoc');
		  $letter .= "<br><b>�������� �������:</b> '".$nmAlb."'<br>";
		  $letter .= "<b>����� � ���������� ����������:</b><br>";
		  $koll = 0;
		  foreach ($photo_data as  $val)
			 {
				$name = $db->query('select `nm` from `photos` where id =?i',array($val['id_photo']),'el');
				$letter .= "���������� � ".$name." - ".$val['koll']."��.<br>";
				$koll += $val['koll'];
			 }
		  $letter .= "<b>�����:</b> ".$koll." ��.<br>";
		  $letter .= "<b>� ������:</b> ".$data['summ']."��. (".str_digit_str($data['summ'])."��.)<br><br>";
		  $letter .= ' <p>
								 ������ �������� '.date('Y-m-d').'.
								 <br>
								 ��� ������ ������ �����, please don\'t reply!
							 </p></body></html>';


		  $mail            = new Mail_sender;
		  $mail->from_addr = $data['email'];
		  $mail->from_name = $data['name'];
		  $mail->to        = 'aleksjurii@gmail.com';
		  $mail->subj      = '����� ����������';
		  $mail->body_type = 'text/html';
		  $mail->body      = $letter;
		  $mail->priority  = 1;
		  $mail->prepare_letter();
		  $mail->send_letter();


		  /* todo: ��������� ������ �� FTP */
		  $http = new http;
		  /*todo: ������� ����� */
		  $zakazPrint = $http->post($_SERVER['HTTP_HOST'].'/inc/sobrZakaz.php', array('idZakaz' => $data['id']));

		  /*todo:  SMS � ����������� ������ */
		  $zakaz = iconv ('windows-1251', 'utf-8',
			 '����� �'.$data['id'].
			 ' ��: '.$user['us_name'].
			 ' '.
			 $user['us_surname'].
			 ' '.
			 $data['format'].
			 '-'.
			 $koll.' ��. �� ����� '.
			 $data['summ'].'��.');
	 	  $sendSMS = $http->post($_SERVER['HTTP_HOST'].'/inc/sendSMS.php', array('sendSMS' => $zakaz, 'number' => '+380949477070'));
		  /* todo: �������� - ��������� �������� */
		  // echo $sendSMS;
		}
	  }
	 }
  }


/* todo: ���� - ������� ����� */
 //  $http = new http;
 //  $http->post($_SERVER['HTTP_HOST'].'/inc/sobrZakaz.php', array('idZakaz' => $data['id']));
 //  $zakaz = iconv ('windows-1251', 'utf-8', '�������� ���������');
 //  $sendSMS = $http->post($_SERVER['HTTP_HOST'].'/inc/sendSMS.php', array('sendSMS' => $zakaz, 'number' => '+380949477070'));
/* todo: �������� - ��������� �������� */
 //  echo  iconv ('utf-8','windows-1251', $sendSMS);


$db->close();

?>
  </div>
<?php
  include (dirname(__FILE__).'/inc/footer.php');
?>